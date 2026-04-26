<?php
include 'config/db.php';
$res = mysqli_query($conn, "SELECT * FROM stores WHERE slug='ajio'");
$row = mysqli_fetch_assoc($res);
print_r($row);
?>
