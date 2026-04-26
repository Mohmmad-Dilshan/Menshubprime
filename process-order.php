<?php
session_start();
require_once __DIR__ . '/src/bootstrap.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'process_mock_payment') {

    // Sanitize inputs
    $product_id  = intval($_POST['product_id']);
    $name        = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email       = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone       = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $custom_info = mysqli_real_escape_string($conn, trim($_POST['custom_info'] ?? ''));
    $amount      = floatval(preg_replace('/[^0-9.]/', '', $_POST['amount']));

    if (empty($name) || empty($email) || empty($phone) || empty($product_id)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    // Verify product
    $check_prod = mysqli_query($conn, "SELECT id, title, price, razorpay_link FROM digital_products WHERE id=$product_id AND status='active'");
    if (mysqli_num_rows($check_prod) == 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid product.']);
        exit;
    }
    $product_data  = mysqli_fetch_assoc($check_prod);
    $amount_paisa  = round($amount * 100);
    $razorpay_link = $product_data['razorpay_link'] ?? '';

    // --- Try Razorpay API ---
    $rzp_success = false;
    $razorpay_order_id = '';

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => 'https://api.razorpay.com/v1/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode([
            'amount'   => $amount_paisa,
            'currency' => 'INR',
            'receipt'  => 'rcpt_' . uniqid()
        ]),
        CURLOPT_USERPWD        => RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
        CURLOPT_TIMEOUT        => 12,          // fast timeout — don't hang user
        CURLOPT_CONNECTTIMEOUT => 6,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    ]);

    $result   = curl_exec($ch);
    $curl_err = curl_errno($ch);
    curl_close($ch);

    if (!$curl_err && !empty($result)) {
        $rzp_response = json_decode($result, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($rzp_response['id'])) {
            $razorpay_order_id = $rzp_response['id'];
            $rzp_success = true;
        }
    }

    // --- Log the attempt to DB ---
    $order_ref = $rzp_success ? $razorpay_order_id : ('DIRECT_' . uniqid());
    $status    = 'Pending';

    $query = "INSERT INTO digital_orders 
              (order_id, product_id, customer_name, customer_email, customer_phone, amount_paid, payment_status, custom_info) 
              VALUES 
              ('$order_ref', $product_id, '$name', '$email', '$phone', $amount, '$status', '$custom_info')";
    mysqli_query($conn, $query); // non-blocking — don't stop flow if fails

    if ($rzp_success) {
        echo json_encode([
            'success'      => true,
            'order_id'     => $razorpay_order_id,
            'amount_paisa' => $amount_paisa,
            'key_id'       => RAZORPAY_KEY_ID,
            'title'        => $product_data['title'],
            'email'        => $email,
            'contact'      => $phone,
            'name'         => $name,
        ]);
    } else {
        // API failed — send key + amount so frontend can open popup without order_id
        echo json_encode([
            'success'       => false,
            'gateway_down'  => true,
            'key_id'        => RAZORPAY_KEY_ID,
            'amount_paisa'  => $amount_paisa,
            'title'         => $product_data['title'],
            'email'         => $email,
            'contact'       => $phone,
            'name'          => $name,
            'razorpay_link' => $razorpay_link,
            'message'       => 'gateway_unavailable',
        ]);
    }
    exit;

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}
?>
