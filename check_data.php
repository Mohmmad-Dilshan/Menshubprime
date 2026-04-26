<?php
include 'config/db.php';
$q = mysqli_query($conn, "SELECT COUNT(*) as total FROM pod_variants");
$row = mysqli_fetch_assoc($q);
echo "Total variants: " . $row['total'];
?>
