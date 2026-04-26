<?php
require_once __DIR__ . '/../src/bootstrap.php';

// Check if column exists
$result = mysqli_query($conn, "SHOW COLUMNS FROM blogs LIKE 'status'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if(!$exists) {
    mysqli_query($conn, "ALTER TABLE blogs ADD COLUMN status ENUM('active','inactive') DEFAULT 'active'");
    echo "Column 'status' added to 'blogs' table.";
} else {
    echo "Column 'status' already exists in 'blogs' table.";
}
?>
