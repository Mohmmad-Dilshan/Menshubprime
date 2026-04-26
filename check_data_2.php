<?php
include 'config/db.php';
$q = mysqli_query($conn, "SELECT * FROM pod_variants LIMIT 1");
$row = mysqli_fetch_assoc($q);
print_r($row);
?>
