<?php

// Professional Order Processor
require_once __DIR__ . '/../src/bootstrap.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'process_mock_payment'){
    
    // Sanitize inputs
    $product_id = intval($_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $custom_info = mysqli_real_escape_string($conn, $_POST['custom_info']);
    $amount_raw = $_POST['amount'];
    // Strip everything except numbers and dots
    $amount = floatval(preg_replace('/[^0-9.]/', '', $amount_raw));
    
    // Basic verification
    if(empty($name) || empty($email) || empty($phone) || empty($product_id)){
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    // Verify Product exists
    $check_prod = mysqli_query($conn, "SELECT id, title, price, razorpay_link FROM digital_products WHERE id=$product_id AND status='active'");
    if(mysqli_num_rows($check_prod) == 0){
        echo json_encode(['success' => false, 'message' => 'Invalid product.']);
        exit;
    }
    
    $product_data = mysqli_fetch_assoc($check_prod);
    
    // Convert amount to paisa
    $amount_paisa = round($amount * 100);

    // Create Razorpay Order via cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "amount" => $amount_paisa,
        "currency" => "INR",
        "receipt" => "rcpt_" . uniqid()
    ]));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, RAZORPAY_KEY_ID . ":" . RAZORPAY_KEY_SECRET);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $headers = [];
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['success' => false, 'message' => 'Error contacting payment gateway.']);
        exit;
    }
    curl_close($ch);

    $rzp_response = json_decode($result, true);
    
    // Check if order was created
    if(!isset($rzp_response['id'])) {
        echo json_encode(['success' => false, 'message' => 'Payment Gateway Error: ' . ($rzp_response['error']['description'] ?? 'Unknown error')]);
        exit;
    }

    $razorpay_order_id = $rzp_response['id'];
    $status = "Pending";

    // Insert into database waiting for payment callback
    $query = "INSERT INTO digital_orders 
              (order_id, product_id, customer_name, customer_email, customer_phone, amount_paid, payment_status, custom_info) 
              VALUES 
              ('$razorpay_order_id', $product_id, '$name', '$email', '$phone', $amount, '$status', '$custom_info')";
              
    if(mysqli_query($conn, $query)){
        echo json_encode([
            'success' => true, 
            'order_id' => $razorpay_order_id,
            'amount_paisa' => $amount_paisa,
            'key_id' => RAZORPAY_KEY_ID,
            'title' => $product_data['title'],
            'email' => $email,
            'contact' => $phone,
            'name' => $name
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Database error: Could not record transaction. '. mysqli_error($conn)
        ]);
    }
    exit;

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
