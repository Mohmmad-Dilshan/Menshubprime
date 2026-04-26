<?php
include ROOT_PATH . '/includes/header.php';
include ROOT_PATH . '/helpers/brand_helper.php';

// Security Redirect
if (($sys['show_wishlist'] ?? 0) == 0) {
    echo "<script>window.location='/Menshubprime/'</script>";
    exit();
}

$brand_slug = strtolower($_GET['brand'] ?? 'amazon');

// Fetch store metadata from database
$store_res = mysqli_query($conn, "SELECT * FROM stores WHERE slug = '$brand_slug' AND status = 1 LIMIT 1");
if (mysqli_num_rows($store_res) == 0) {
    echo "<script>window.location='/Menshubprime/brands'</script>";
    exit();
}
$store = mysqli_fetch_assoc($store_res);

// Security Check (Global Hub & Individual Store)
if (($sys['show_wishlist'] ?? 0) == 0 || $store['status'] == 0) {
    echo "<script>window.location='/Menshubprime/'</script>";
    exit();
}

$current_brand = [
    'id' => $store['id'],
    'name' => $store['name'],
    'icon' => $store['icon'],
    'color' => $store['color']
];

// Split Hex color for CSS variable (RGB)
list($r, $g, $b) = sscanf($current_brand['color'], "#%02x%02x%02x");
$accent_rgb = "$r, $g, $b";

// Fetch products based on store_id
$store_id = $current_brand['id'];
$results = mysqli_query($conn, "SELECT * FROM products WHERE store_id = '$store_id' AND (status = 'active' OR status = '1') ORDER BY id DESC");
?>

<div class="brand-store-wrapper" style="--accent-color: <?= $current_brand['color'] ?>; --accent-color-rgb: <?= $accent_rgb ?>">
    <div class="store-hero">
        <div class="store-header-info">
            <a href="/Menshubprime/brands" class="back-link"><i class="fas fa-arrow-left"></i> All Stores</a>
            <h1><i class="<?= $current_brand['icon'] ?>"></i> <?= $current_brand['name'] ?></h1>
            <p>Curated high-value deals exclusively from <?= $current_brand['name'] ?></p>
        </div>
    </div>

    <div class="results-container">
        <div class="results-grid">
            <?php if(mysqli_num_rows($results) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($results)): 
                    // Determine price and link for THIS brand
                    $p_price = $row['price'];
                    $p_link = $row['affiliate_link'];
                    
                    if ($brand_slug == 'flipkart') {
                        $p_price = !empty($row['flipkart_price']) ? $row['flipkart_price'] : $row['price'];
                        $p_link = !empty($row['flipkart_link']) ? $row['flipkart_link'] : $row['affiliate_link'];
                    } elseif ($brand_slug == 'myntra') {
                        $p_price = !empty($row['myntra_price']) ? $row['myntra_price'] : $row['price'];
                        $p_link = !empty($row['myntra_link']) ? $row['myntra_link'] : $row['affiliate_link'];
                    } elseif ($brand_slug == 'ajio' || $brand_slug == 'meesho' || $brand_slug == 'other') {
                        $p_price = !empty($row['other_platform_price']) ? $row['other_platform_price'] : $row['price'];
                        $p_link = !empty($row['other_platform_link']) ? $row['other_platform_link'] : $row['affiliate_link'];
                    } else {
                        $p_price = $row['price'];
                        $p_link = $row['affiliate_link'];
                    }
                ?>
                    <div class="p-card">
                        <div class="p-img">
                            <img src="/Menshubprime/assets/images/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                            <div class="p-badge">Deals</div>
                        </div>
                        <div class="p-info">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <div class="p-price-row">
                                <span class="price-val">₹<?= $p_price ?></span>
                                <span class="price-label">at <?= $current_brand['name'] ?></span>
                            </div>
                            <a href="<?= $p_link ?>" target="_blank" class="buy-btn">
                                <i class="<?= $current_brand['icon'] ?>"></i> Buy Now
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h2>No deals found for this store.</h2>
                    <p>Check back later or try another store.</p>
                    <a href="/Menshubprime/brands" class="btn-primary">Browse All Stores</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
:root {
    --glass-bg: rgba(255, 255, 255, 0.03);
    --glass-border: rgba(255, 255, 255, 0.08);
    --accent-glow: 0 0 25px rgba(var(--accent-color-rgb), 0.2);
}

.brand-store-wrapper {
    min-height: 100vh;
    padding-bottom: 100px;
    font-family: 'Outfit', sans-serif;
    position: relative;
    overflow: hidden;
}

/* Dynamic Brand Mesh Background */
.brand-store-wrapper::before {
    content: '';
    position: absolute;
    top: -200px;
    right: -100px;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, var(--accent-color) 0%, transparent 70%);
    opacity: 0.15;
    filter: blur(80px);
    z-index: -1;
}

.store-hero {
    padding: 180px 0 100px;
    text-align: center;
    position: relative;
}

.store-header-info {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #94a3b8;
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 30px;
    padding: 8px 20px;
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 100px;
    transition: all 0.3s;
}

.back-link:hover {
    color: #fff;
    background: rgba(255,255,255,0.1);
    transform: translateX(-5px);
}

.store-header-info h1 {
    font-size: clamp(32px, 6vw, 56px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 15px;
    letter-spacing: -2px;
}

.store-header-info h1 i {
    color: var(--accent-color);
    margin-right: 15px;
    text-shadow: 0 0 20px var(--accent-color);
}

.store-header-info p {
    color: #cbd5e1;
    font-size: clamp(16px, 2vw, 20px);
    opacity: 0.8;
}

.results-container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 20px;
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 40px;
}

.p-card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    backdrop-filter: blur(10px);
    border-radius: 28px;
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}

.p-card:hover {
    transform: translateY(-12px) scale(1.02);
    border-color: var(--accent-color);
    box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
}

.p-img {
    height: 280px;
    position: relative;
    background: rgba(255,255,255,0.02);
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.p-img img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.5s;
}

.p-card:hover .p-img img {
    transform: scale(1.1);
}

.p-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: var(--accent-color);
    color: #fff;
    padding: 6px 14px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.p-info {
    padding: 30px;
}

.p-info h3 {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    height: 52px;
    overflow: hidden;
    margin-bottom: 20px;
    line-height: 1.3;
}

.p-price-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 25px;
}

.price-main {
    display: flex;
    flex-direction: column;
}

.price-val {
    font-size: 32px;
    font-weight: 900;
    color: var(--accent-color);
    line-height: 1;
}

.price-label {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 5px;
    font-weight: 600;
}

.buy-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px;
    background: var(--accent-color);
    color: #fff;
    text-decoration: none;
    border-radius: 16px;
    font-weight: 800;
    font-size: 16px;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.buy-btn:hover {
    filter: brightness(1.2);
    transform: scale(1.02);
    box-shadow: 0 8px 25px var(--accent-color);
}

.no-results {
    grid-column: 1 / -1;
    text-align: center;
    padding: 120px 20px;
    background: var(--glass-bg);
    border: 2px dashed var(--glass-border);
    border-radius: 40px;
}

.no-results i {
    font-size: 80px;
    color: #475569;
    margin-bottom: 25px;
    opacity: 0.5;
}

.no-results h2 { color: #fff; font-size: 28px; margin-bottom: 12px; }
.no-results p { color: #94a3b8; font-size: 18px; margin-bottom: 40px; }

@media (max-width: 768px) {
    .store-hero { padding: 140px 0 60px; }
    .results-container { margin-top: 20px; }
    .results-grid { grid-template-columns: 1fr; gap: 20px; }
    .p-card { border-radius: 20px; }
    .p-img { height: 220px; }
}
</style>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
