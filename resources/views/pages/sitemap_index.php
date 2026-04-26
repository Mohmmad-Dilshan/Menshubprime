<?php
include 'config/db.php';

header("Content-Type: application/xml; charset=utf-8");

// Use dynamic domain detection to ensure it works on localhost and production
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$domain = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/Menshubprime";

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php
/**
 * 1. STATIC CORE PAGES
 */
$staticPages = [
    "" => 1.0,
    "about" => 0.8,
    "categories" => 0.9,
    "deals" => 0.9,
    "comparisons" => 0.9,
    "videos" => 0.8,
    "blog" => 0.8,
    "digital-products" => 0.8,
    "contact" => 0.7,
    "collaboration" => 0.7,
    "dropshipping" => 0.7,
    "mobile-app" => 0.7,
    "faq" => 0.6,
    "privacy" => 0.5,
    "terms" => 0.5
];

foreach($staticPages as $path => $priority){
    echo "<url>";
    echo "<loc>$domain/$path</loc>";
    echo "<changefreq>weekly</changefreq>";
    echo "<priority>$priority</priority>";
    echo "</url>";
}

/**
 * 2. DYNAMIC BLOG POSTS
 */
$blogs = mysqli_query($conn,"SELECT slug FROM blogs WHERE status='active'");
while($b = mysqli_fetch_assoc($blogs)){
    echo "<url>";
    echo "<loc>$domain/blog/".$b['slug']."</loc>";
    echo "<changefreq>weekly</changefreq>";
    echo "<priority>0.7</priority>";
    echo "</url>";
}

/**
 * 3. DYNAMIC PRODUCTS
 */
$products = mysqli_query($conn,"SELECT slug FROM products WHERE status='active'");
while($p = mysqli_fetch_assoc($products)){
    echo "<url>";
    echo "<loc>$domain/product/".$p['slug']."</loc>";
    echo "<changefreq>weekly</changefreq>";
    echo "<priority>0.7</priority>";
    echo "</url>";
}

/**
 * 4. DYNAMIC CATEGORIES
 */
$cats = mysqli_query($conn,"SELECT slug FROM categories WHERE status='active'");
while($c = mysqli_fetch_assoc($cats)){
    echo "<url>";
    echo "<loc>$domain/category/".$c['slug']."</loc>";
    echo "<changefreq>weekly</changefreq>";
    echo "<priority>0.6</priority>";
    echo "</url>";
}

/**
 * 5. DYNAMIC VIDEOS
 */
$vids = mysqli_query($conn,"SELECT slug FROM videos WHERE status=1 OR status='active'");
while($v = mysqli_fetch_assoc($vids)){
    echo "<url>";
    echo "<loc>$domain/video/".$v['slug']."</loc>";
    echo "<changefreq>weekly</changefreq>";
    echo "<priority>0.6</priority>";
    echo "</url>";
}

/**
 * 6. DIGITAL PRODUCTS
 */
$dp = mysqli_query($conn,"SELECT slug FROM digital_products WHERE status='active'");
while($d = mysqli_fetch_assoc($dp)){
    echo "<url>";
    echo "<loc>$domain/digital-product/".$d['slug']."</loc>";
    echo "<changefreq>weekly</changefreq>";
    echo "<priority>0.6</priority>";
    echo "</url>";
}
?>

</urlset>