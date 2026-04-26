<?php
require_once __DIR__ . '/../src/bootstrap.php';

$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : '';

if (empty($slug)) {
    echo json_encode(['error' => 'No product specified']);
    exit;
}

$p_sql = "SELECT * FROM products WHERE slug = '$slug' AND status='active' LIMIT 1";
$p_res = mysqli_query($conn, $p_sql);
$p = mysqli_fetch_assoc($p_res);

if (!$p) {
    echo json_encode(['error' => 'Product not found']);
    exit;
}

// Format data for the app-like drawer
echo json_encode([
    'title' => $p['title'],
    'price' => number_format($p['price']),
    'image' => $p['image'],
    'category' => ucfirst($p['category']),
    'link' => "/Menshubprime/product/" . $p['slug'],
    'affiliate_link' => $p['affiliate_link'],
    'description' => $p['description'] ? substr(strip_tags($p['description']), 0, 100) . "..." : "Experience premium quality with this curated Selection from MensHub Prime.",
    'comparisons' => [
        ['name' => 'Amazon', 'price' => number_format($p['price']), 'link' => $p['affiliate_link'], 'icon' => 'amazon.png'],
        ['name' => 'Flipkart', 'price' => $p['flipkart_price'] ? number_format($p['flipkart_price']) : null, 'link' => $p['flipkart_link'], 'icon' => 'flipkart.png'],
        ['name' => 'Myntra', 'price' => $p['myntra_price'] ? number_format($p['myntra_price']) : null, 'link' => $p['myntra_link'], 'icon' => 'myntra.png'],
        ['name' => $p['other_platform_name'] ?: 'Other', 'price' => $p['other_platform_price'] ? number_format($p['other_platform_price']) : null, 'link' => $p['other_platform_link'], 'icon' => 'bag.png']
    ]
]);
