<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    die("Unauthorized access.");
}
include 'config/db.php';

// Safe migration to add status column if it doesn't exist
$tables = ['messages', 'hire_requests', 'subscribers', 'collab_requests'];

foreach($tables as $table) {
    $check = mysqli_query($conn, "SHOW COLUMNS FROM $table LIKE 'reply_status'");
    if(mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "ALTER TABLE $table ADD COLUMN reply_status ENUM('pending', 'replied') DEFAULT 'pending'");
    }
}

echo "Database nodes synchronized with reply status matrix.";
?>
