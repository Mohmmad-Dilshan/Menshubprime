<?php
include 'config/db.php';

$q1 = "ALTER TABLE digital_products ADD COLUMN preview_images TEXT DEFAULT NULL AFTER image;";

if (mysqli_query($conn, $q1)) {
    echo "SUCCESS: preview_images added.";
} else {
    echo "ERROR: " . mysqli_error($conn);
}
?>
