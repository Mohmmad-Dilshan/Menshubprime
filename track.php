<?php
include 'config/db.php';

$pid = intval($_GET['id'] ?? 0);
$url = $_GET['url'] ?? '';

if(!empty($url)) {
    // Log the click into database
    $url_clean = mysqli_real_escape_string($conn, $url);
    mysqli_query($conn, "INSERT INTO link_clicks (product_id, target_url) VALUES ('$pid', '$url_clean')");
    
    // Redirect to final destination
    header("Location: " . $url);
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
