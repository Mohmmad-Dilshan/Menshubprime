<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    die("Unauthorized access.");
}
include '../config/db.php';

// 1. Get all stores
$stores_res = mysqli_query($conn, "SELECT id, slug FROM stores");
$stores = [];
while($s = mysqli_fetch_assoc($stores_res)) {
    $stores[$s['slug']] = $s['id'];
}

// 2. Update existing products based on affiliate_link
// Amazon
if(isset($stores['amazon'])) {
    mysqli_query($conn, "UPDATE products SET store_id = " . $stores['amazon'] . " WHERE affiliate_link LIKE '%amazon%' AND store_id IS NULL");
}
// Flipkart
if(isset($stores['flipkart'])) {
    mysqli_query($conn, "UPDATE products SET store_id = " . $stores['flipkart'] . " WHERE (flipkart_link IS NOT NULL AND flipkart_link != '') AND store_id IS NULL");
}
// Myntra
if(isset($stores['myntra'])) {
    mysqli_query($conn, "UPDATE products SET store_id = " . $stores['myntra'] . " WHERE (myntra_link IS NOT NULL AND myntra_link != '') AND store_id IS NULL");
}
// Ajio
if(isset($stores['ajio'])) {
    mysqli_query($conn, "UPDATE products SET store_id = " . $stores['ajio'] . " WHERE (other_platform_name LIKE '%ajio%' OR other_platform_link LIKE '%ajio%') AND store_id IS NULL");
}

echo "Legacy data migration complete!";
?>
