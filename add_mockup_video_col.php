<?php
include 'config/db.php';
// Add video_url_mockup column to products table
$sql = "ALTER TABLE products ADD COLUMN video_url_mockup VARCHAR(255) DEFAULT NULL AFTER video_file";
if(mysqli_query($conn, $sql)) {
    echo "Column 'video_url_mockup' added successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
