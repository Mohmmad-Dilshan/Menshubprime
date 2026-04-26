<?php
// MENS HUB PRIME - DYNAMIC SITEMAP ENGINE
require_once 'src/bootstrap.php';

$base_url = "https://thezayanway.com"; // YOUR NEW PRODUCTION DOMAIN

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// 1. Static Pages
$static_pages = ['', '/blog', '/video', '/digital-product', '/telegram'];
foreach ($static_pages as $page) {
    echo '<url>';
    echo '<loc>' . $base_url . $page . '</loc>';
    echo '<lastmod>' . date('Y-m-d') . '</lastmod>';
    echo '<changefreq>daily</changefreq>';
    echo '<priority>1.0</priority>';
    echo '</url>';
}

// 2. Dynamic Blogs
$blogs = mysqli_query($conn, "SELECT slug, date FROM blogs WHERE status='active' ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($blogs)) {
    echo '<url>';
    echo '<loc>' . $base_url . '/blog/' . $row['slug'] . '</loc>';
    echo '<lastmod>' . date('Y-m-d', strtotime($row['date'] ?? 'now')) . '</lastmod>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.8</priority>';
    echo '</url>';
}

// 3. Dynamic Videos
$videos = mysqli_query($conn, "SELECT slug FROM videos WHERE status='active' OR status='1' ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($videos)) {
    echo '<url>';
    echo '<loc>' . $base_url . '/video/' . $row['slug'] . '</loc>';
    echo '<lastmod>' . date('Y-m-d') . '</lastmod>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.7</priority>';
    echo '</url>';
}

// 4. Digital Products
$digitals = mysqli_query($conn, "SELECT slug FROM digital_products WHERE status='active' ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($digitals)) {
    echo '<url>';
    echo '<loc>' . $base_url . '/digital-product/' . $row['slug'] . '</loc>';
    echo '<lastmod>' . date('Y-m-d') . '</lastmod>';
    echo '<changefreq>monthly</changefreq>';
    echo '<priority>0.6</priority>';
    echo '</url>';
}

echo '</urlset>';
?>
