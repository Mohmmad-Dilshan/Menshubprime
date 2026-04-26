<?php
include 'config/db.php';
$q1 = mysqli_query($conn, "DESCRIBE messages");
echo "messages:\n";
while($row = mysqli_fetch_array($q1)) print_r($row);

$q2 = mysqli_query($conn, "DESCRIBE collaborations");
echo "\ncollaborations:\n";
while($row = mysqli_fetch_array($q2)) print_r($row);
?>
