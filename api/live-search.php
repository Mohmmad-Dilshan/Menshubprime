<?php
require_once __DIR__ . '/../src/bootstrap.php';

$query = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

if (empty($query)) {
    echo json_encode(['products' => [], 'blogs' => []]);
    exit;
}

// Products
$p_sql = "SELECT title, price, image, slug FROM products WHERE (title LIKE '%$query%') AND status='active' LIMIT 6";
$p_res = mysqli_query($conn, $p_sql);
$products = [];
while($row = mysqli_fetch_assoc($p_res)) {
    $products[] = [
        'title' => $row['title'],
        'price' => number_format($row['price']),
        'image' => $row['image'],
        'slug' => $row['slug']
    ];
}

// Blogs
$b_sql = "SELECT title, image, slug FROM blogs WHERE (title LIKE '%$query%') AND status='active' LIMIT 3";
$b_res = mysqli_query($conn, $b_sql);
$blogs = [];
while($row = mysqli_fetch_assoc($b_res)) {
    $blogs[] = [
        'title' => $row['title'],
        'image' => $row['image'],
        'slug' => $row['slug']
    ];
}

echo json_encode(['products' => $products, 'blogs' => $blogs]);
