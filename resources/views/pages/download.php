<?php
// Absolute silence to prevent binary corruption
error_reporting(0);
ini_set('display_errors', 0);
ob_start();

include 'config/db.php';

// Get Order ID safely
$order_id = isset($_GET['order']) ? mysqli_real_escape_string($conn, $_GET['order']) : '';

if (empty($order_id)) {
    ob_end_clean();
    die("Invalid access.");
}

// Fetch order and product details
$q = mysqli_query($conn, "
    SELECT o.*, p.title, p.product_link 
    FROM digital_orders o 
    JOIN digital_products p ON o.product_id = p.id 
    WHERE o.order_id = '$order_id' AND o.payment_status = 'Completed'
");

$order = mysqli_fetch_assoc($q);

if (!$order) {
    ob_end_clean();
    die("Error: Security violation. Order not found or payment not completed.");
}

// The physical file in the local server
$fileName = basename($order['product_link']);
$filePath = 'uploads/downloads/' . $fileName;

if (!file_exists($filePath)) {
    ob_end_clean();
    die("Error: File not found on server.");
}

// ==========================================
// 1. Send Email Notification (Customer)
// ==========================================
$to = $order['customer_email'];
$subject = "Success! Your download is ready - " . $order['title'];
$product_title = $order['title'];
$cust_name = $order['customer_name'];

$email_message = "<html><body style='font-family:Arial,sans-serif;'>
    <h2 style='color:#22c55e;'>Thank you, $cust_name!</h2>
    <p>Your purchase of <strong>$product_title</strong> was successful.</p>
    <p>Order ID: #$order_id<br>Amount Paid: ₹{$order['amount_paid']}</p>
    <p>Enjoy your product!</p>
</body></html>";

$headers = "MIME-Version: 1.0\r\nContent-type:text/html;charset=UTF-8\r\nFrom: MensHubPrime <noreply@menshubprime.com>\r\n";
@mail($to, $subject, $email_message, $headers);

// Admin Sale Alert
@mail(ADMIN_EMAIL, "New Sale: " . $product_title, "Sale! $cust_name downloaded $product_title.", "From: sales@menshubprime.com");

// ==========================================
// 2. Force File Download (Pure Binary)
// ==========================================
// Clean EVERYTHING from the buffer before headers
while (ob_get_level()) {
    ob_end_clean();
}

$fileSize = filesize($filePath);
$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// Map extensions to MIME types
$mimes = [
    'pdf'  => 'application/pdf',
    'zip'  => 'application/zip',
    'rar'  => 'application/x-rar-compressed',
    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'ppt'  => 'application/vnd.ms-powerpoint',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'doc'  => 'application/msword',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'xls'  => 'application/vnd.ms-excel',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png'
];

$mimeType = $mimes[$ext] ?? 'application/octet-stream';

header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . $fileSize);
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

readfile($filePath);
exit;

