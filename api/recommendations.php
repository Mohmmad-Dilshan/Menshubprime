<?php
session_start();
include_once '../config/db.php';

$interests = isset($_GET['cats']) ? explode(',', mysqli_real_escape_string($conn, $_GET['cats'])) : [];
$results = ['products' => []];

if (!empty($interests)) {
    $placeholders = "'" . implode("','", $interests) . "'";
    $q = mysqli_query($conn, "SELECT id, title, price, image, slug, category FROM products WHERE category IN ($placeholders) AND (status='active' OR status='1') ORDER BY RAND() LIMIT 6");
    
    if ($q) {
        while ($row = mysqli_fetch_assoc($q)) {
            $results['products'][] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'price' => number_format($row['price']),
                'image' => $row['image'],
                'slug' => $row['slug'],
                'category' => ucfirst($row['category'])
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($results);
