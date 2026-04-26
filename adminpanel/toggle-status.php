<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin_id'])){
    die('Unauthorized');
}

if(isset($_GET['id']) && isset($_GET['table'])){
    $id = intval($_GET['id']);
    $table = mysqli_real_escape_string($conn, $_GET['table']);
    $ref = $_SERVER['HTTP_REFERER'] ?? 'dashboard.php';

    // Allow list for tables for security
    $allowed = ['products', 'mini_products', 'categories', 'videos', 'digital_products', 'blogs', 'sponsors'];
    if(!in_array($table, $allowed)){
        die('Invalid Table');
    }

    $q = mysqli_query($conn, "SELECT status FROM $table WHERE id=$id");
    $row = mysqli_fetch_assoc($q);
    if($row){
        $new_status = ($row['status'] == 'active') ? 'inactive' : 'active';
        mysqli_query($conn, "UPDATE $table SET status='$new_status' WHERE id=$id");
    }
    
    // Append unique timestamp to bypass browser cache on redirect
    $separator = (strpos($ref, '?') !== false) ? '&' : '?';
    header("Location: $ref" . $separator . "updated=1&t=" . time());
    exit();
}
?>
