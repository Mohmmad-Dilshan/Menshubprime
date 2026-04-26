<?php
include 'config/db.php';
$q = mysqli_query($conn, "SELECT id, title FROM products WHERE id=2");
$row = mysqli_fetch_assoc($q);
print_r($row);
?>
