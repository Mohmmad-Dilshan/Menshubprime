<?php
include 'config/db.php';
$sql = "ALTER TABLE blogs ADD COLUMN status VARCHAR(10) DEFAULT 'active'";
if(mysqli_query($conn, $sql)){ echo "Success"; } else { echo "Error: " . mysqli_error($conn); }
?>
