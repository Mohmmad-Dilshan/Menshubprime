<?php
// bootstrap removed

if(isset($_GET['slug'])){
  $slug = mysqli_real_escape_string($conn, $_GET['slug']);
} elseif(isset($_GET['cat'])){
  $slug = mysqli_real_escape_string($conn, $_GET['cat']);
} else {
  $slug = '';
}

/* category data */
$catQ = mysqli_query($conn, "SELECT name FROM categories WHERE slug='$slug' AND (status='active' OR status='1')");
$catData = mysqli_fetch_assoc($catQ);

if(!$catData){
    header("Location: /categories");
    exit();
}

$page_title = "Best ".$catData['name']." Deals | MENHUB PRIME";
$page_description = "Explore the best ".$catData['name']." deals, trending products and top discounts curated for smart shoppers.";

include ROOT_PATH . '/includes/header.php';

/* products */
$q = mysqli_query($conn, "
SELECT * FROM products 
WHERE category='$slug' AND (status='active' OR status='1')
ORDER BY id DESC
");
?>

<style>
/* PREMIUM CATEGORY PAGE DESIGN SYSTEM */
.premium-cat-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.1), transparent 45%),
                radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.08), transparent 45%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.cv-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(249, 115, 22, 0.1);
    border: 1px solid rgba(249, 115, 22, 0.2);
    border-radius: 100px;
    color: #f97316;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 25px;
}

.premium-cat-hero h1 {
    font-size: clamp(38px, 6vw, 68px);
    font-weight: 950;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -3px;
    line-height: 1;
}

.premium-cat-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.6;
}

/* MAIN CONTENT CONTAINER */
.cv-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 20px 100px;
}

/* INTRODUCTION GLASS CARD */
.glass-intro-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    margin-bottom: 80px;
    text-align: center;
    position: relative;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
}

.glass-intro-card h2 {
    font-size: 32px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -1px;
}

.cv-intro-desc {
    color: #94a3b8;
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 35px;
}

.cv-hero-actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.cv-pill-btn {
    padding: 14px 35px;
    border-radius: 100px;
    font-weight: 800;
    text-decoration: none;
    transition: 0.4s;
    font-size: 14px;
}

.pill-orange { background: #f97316; color: #000 !important; box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3); }
.pill-glass { background: rgba(255, 255, 255, 0.05); color: #fff !important; border: 1px solid rgba(255, 255, 255, 0.1); }

.cv-pill-btn:hover { transform: translateY(-5px) scale(1.05); }

/* DYNAMIC PRODUCT GRID */
.cv-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
}

.cv-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 30px;
    overflow: hidden;
    transition: 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    position: relative;
}

.cv-card:hover {
    transform: translateY(-15px) rotateX(4deg);
    border-color: rgba(249, 115, 22, 0.4);
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
}

.cv-img-wrap {
    width: 100%;
    height: 240px;
    overflow: hidden;
    position: relative;
}

.cv-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.8s;
}

.cv-card:hover .cv-img-wrap img { transform: scale(1.1); }

.cv-card-body {
    padding: 25px;
}

.cv-card-title {
    color: #f1f5f9;
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 12px;
    line-height: 1.5;
    height: 50px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.cv-card-price {
    font-size: 22px;
    font-weight: 900;
    color: #f97316;
}

.cv-card-btn {
    margin: 20px auto 0;
    display: block;
    width: fit-content;
    padding: 12px 35px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 100px;
    color: #cbd5e1;
    text-align: center;
    text-decoration: none;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 11px;
    transition: 0.3s;
}

.cv-card:hover .cv-card-btn { background: #f97316; color: #000; border-color: #f97316; }

/* FAQ SECTION */
.cv-faq-box {
    margin-top: 100px;
    padding: 60px;
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 50px;
}

.cv-faq-item { margin-bottom: 40px; }
.cv-faq-item:last-child { margin-bottom: 0; }
.cv-faq-q { color: #fff; font-size: 18px; font-weight: 800; margin-bottom: 15px; }
.cv-faq-a { color: #94a3b8; font-size: 15px; line-height: 1.8; }

/* LOAD MORE */
.cv-loader { text-align: center; margin-top: 70px; }
.cv-load-btn {
    background: rgba(249, 115, 22, 0.1);
    border: 1px solid rgba(249, 115, 22, 0.2);
    color: #f97316;
    padding: 16px 45px;
    border-radius: 100px;
    font-weight: 800;
    cursor: pointer;
    transition: 0.3s;
}
.cv-load-btn:hover { background: #f97316; color: #000; transform: scale(1.05); }

@media (max-width: 768px) {
    .cv-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
    .cv-card { border-radius: 20px; }
    .cv-img-wrap { height: 160px; }
    .cv-card-body { padding: 15px; }
    .cv-card-title { font-size: 14px; height: 42px; }
    .cv-card-price { font-size: 18px; }
    .glass-intro-card { padding: 40px 25px; border-radius: 30px; }
    .cv-hero-actions { flex-direction: column; }
}

@media (max-width: 480px) {
    .cv-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .cv-card-body { padding: 10px; }
    .cv-card-btn { padding: 8px 15px; font-size: 10px; margin-top: 15px; }
    .premium-cat-hero { padding: 120px 0 60px; }
    .cv-container { padding: 40px 10px 80px; }
}
</style>

<div class="premium-cat-hero">
    <div class="cv-badge"><i class="fas fa-gem"></i> Curated Essentials</div>
    <h1>Premium <?= htmlspecialchars($catData['name']); ?></h1>
    <p>Discover the finest <?= htmlspecialchars($catData['name']); ?> specifically selected for quality, style, and value.</p>
</div>

<div class="cv-container">
    
    <div class="glass-intro-card">
        <h2>Expert Review & Insights</h2>
        <p class="cv-intro-desc">
            We track thousands of data points across platforms like Amazon, Myntra, and Flipkart to bring you the top-rated <?= htmlspecialchars($catData['name']); ?>. Every item is verified for merchant trust and historical price value.
        </p>
        <div class="cv-hero-actions">
            <a href="/deals" class="cv-pill-btn pill-orange">🔥 Daily Price Drops</a>
            <a href="/blog" class="cv-pill-btn pill-glass">📖 Buying Guides</a>
        </div>
    </div>

    <?php
    include_once ROOT_PATH . '/includes/comparison-ui.php';
    $compQ = mysqli_query($conn, "SELECT id FROM comparison_tables WHERE category='$slug' AND status='active' LIMIT 1");
    if(mysqli_num_rows($compQ) > 0){
        $compData = mysqli_fetch_assoc($compQ);
        echo '<div style="margin-bottom:80px;">';
        echo '<h2 style="color:white; text-align:center; margin-bottom:40px; font-size:26px; font-weight:800; letter-spacing:-1px;">🏆 Prime Comparison Picks</h2>';
        renderComparison($compData['id'], $conn);
        echo '</div>';
    }
    ?>

    <div class="cv-grid" id="productContainer">
        <?php
        $i=0;
        if(mysqli_num_rows($q) > 0){
            while($row = mysqli_fetch_assoc($q)){
                $i++;
                ?>
                <div class="cv-card prod-item" style="display:none">
                    <div class="cv-img-wrap">
                        <img loading="lazy" src="assets/images/<?= $row['image']; ?>" alt="<?= htmlspecialchars($row['title']); ?>">
                        <!-- QUICK PEEK TRIGGER -->
                        <button onclick="openQuickPeek('<?= $row['slug']; ?>')" class="card-peek-btn" aria-label="Quick Peek">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="cv-card-body">
                        <h3 class="cv-card-title"><?= htmlspecialchars($row['title']); ?></h3>
                        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <span class="cv-card-price">₹<?= number_format($row['price']); ?></span>
                            <span style="font-size: 10px; color: #64748b; font-weight: 900; text-transform:uppercase;">Prime Select</span>
                        </div>
                        <a href="/product/<?= $row['slug']; ?>" class="cv-card-btn">View Offer</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<h3 style='color:#64748b; text-align:center; grid-column: 1/-1; padding: 60px 0;'>No active deals found in this category yet.</h3>";
        }
        ?>
    </div>

    <?php if(mysqli_num_rows($q) > 6): ?>
    <div class="cv-loader">
        <button id="loadMoreBtn" class="cv-load-btn">Explore More Deals</button>
    </div>
    <?php endif; ?>

    <div class="cv-faq-box">
        <h3 style="color:#fff; font-size:28px; font-weight:900; margin-bottom:40px; letter-spacing:-1px;">Information Hub</h3>
        <div class="cv-faq-item">
            <h4 class="cv-faq-q">Are these <?= htmlspecialchars($catData['name']); ?> verified?</h4>
            <p class="cv-faq-a">Yes. We only showcase products that maintain a high seller rating and have positive historical performance to ensure you get the best quality gear.</p>
        </div>
        <div class="cv-faq-item">
            <h4 class="cv-faq-q">How to stay updated on price drops?</h4>
            <p class="cv-faq-a">Prices fluctuate daily based on marketplace algorithms. We suggest joining our Telegram club below for real-time alerts on secret discount codes.</p>
        </div>
    </div>

</div>

<section class="brand-wrap">
  <div class="brand-box">
    <h3>Built for <span>Smart Men</span></h3>
    <p>
      MenHub Prime curates the best deals for you —  
      so you don’t waste time searching.
    </p>
  </div>
</section>

<hr style="border:0; border-top: 1px solid rgba(255,255,255,0.05);">

<script>
let items = document.querySelectorAll(".prod-item");
let btn = document.getElementById("loadMoreBtn");
let current = 0;

function showItems(count){
    let grid = document.getElementById("productContainer");
    
    // 1. Create Skeletons
    let skeletons = [];
    for(let i=0; i<3; i++){
        let s = document.createElement('div');
        s.className = 'cv-card skeleton-container';
        s.innerHTML = `
            <div class="skeleton" style="width:100%; height:180px; border-radius:30px 30px 0 0;"></div>
            <div style="padding:20px;">
                <div class="skeleton" style="width:80%; height:15px; margin-bottom:10px;"></div>
                <div class="skeleton" style="width:40%; height:20px;"></div>
            </div>
        `;
        grid.appendChild(s);
        skeletons.push(s);
    }

    // 2. Hide "Show More" Button for a sec
    if(btn) btn.style.opacity = "0.5";

    // 3. Delay then reveal real items
    setTimeout(() => {
        // Remove Skeletons
        skeletons.forEach(s => s.remove());

        // Show Real Items
        for(let i=current; i<current+count; i++){
            if(items[i]){
                items[i].style.display="";
                items[i].style.animation = "zoomIn 0.5s ease both";
            }
        }
        current += count;
        if(btn) {
            btn.style.opacity = "1";
            if(current >= items.length) btn.style.display="none";
        }
    }, 400);
}

// First Load
showItems(6);

// Load More
if(btn) {
    btn.onclick = function(){
        let loadCount = window.innerWidth <= 768 ? 4 : 3;
        showItems(loadCount);
    }
}
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>