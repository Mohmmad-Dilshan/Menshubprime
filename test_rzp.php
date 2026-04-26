<?php
include 'src/bootstrap.php';

$amount_paisa = 10000; // Rs 100

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
    echo "CURL ERROR: " . curl_error($ch);
} else {
    echo "RAZORPAY RESPONSE: \n";
    print_r(json_decode($result, true));
}
curl_close($ch);
?>
