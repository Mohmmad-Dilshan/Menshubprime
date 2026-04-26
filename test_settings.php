<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/db.php';
if (!isset($conn)) {
    // try admin path
    include 'admin8472panel/../config/db.php';
}

$res = mysqli_query($conn, "SELECT active_sale_event, sale_title FROM settings LIMIT 1");
if(!$res) {
    echo "Query Failed: " . mysqli_error($conn);
} else {
    $row = mysqli_fetch_assoc($res);
    echo "SUCCESS: " . json_encode($row);
}
?>
