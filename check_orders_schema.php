<?php
include 'config/db.php';
$q1 = mysqli_query($conn, "DESCRIBE digital_orders");
echo "digital_orders:\n";
while($row = mysqli_fetch_array($q1)) print_r($row);

$q2 = mysqli_query($conn, "DESCRIBE pod_orders");
echo "\npod_orders:\n";
while($row = mysqli_fetch_array($q2)) print_r($row);
?>
