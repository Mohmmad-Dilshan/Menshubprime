<?php
$ch = curl_init('http://localhost/Menshubprime/process-order.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'action' => 'process_mock_payment',
    'product_id' => '3',
    'name' => 'Test User',
    'email' => 'test@example.com',
    'phone' => '9876543210',
    'amount' => '399',
    'custom_info' => 'test'
]);
$result = curl_exec($ch);
echo "RAW_RESPONSE_START\n";
echo $result;
echo "\nRAW_RESPONSE_END\n";
if (curl_errno($ch)) {
    echo "CURL_ERROR: " . curl_error($ch);
}
?>
