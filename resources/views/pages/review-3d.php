<?php
include ROOT_PATH . '/includes/header.php';

$id = $_GET['id'] ?? null;
$slug = $_GET['slug'] ?? null;

if (!$id && !$slug) {
    header("Location: /Menshubprime/");
    exit();
}

if ($slug) {
    $slug = mysqli_real_escape_string($conn, $slug);
    $product_query = mysqli_query($conn, "SELECT * FROM products WHERE slug = '$slug' LIMIT 1");
} else {
    $id = intval($id);
    $product_query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id LIMIT 1");
}

if (mysqli_num_rows($product_query) == 0) {
    header("Location: /Menshubprime/");
    exit();
}
$p = mysqli_fetch_assoc($product_query);
$id = $p['id']; // Ensure $id is set for backward compatibility in the rest of the file

// Logic for Review Content (In a real scenario, this might come from a DB table, 
// but for now we'll generate high-fidelity dummy review data based on the category)
$trending_reason = "This product has viral potential due to its minimalist design and premium build quality. Most users are praising its durability and sleek finish.";
$pros = ["Premium Build", "Modern Aesthetic", "Great Value", "Viral Trending"];
$cons = ["Limited Stock", "Exclusive Drop"];
?>

<div class="review-3d-wrapper">
    <div class="review-bg-glow"></div>
    
    <div class="review-container">
        <!-- Center 3D Product Showpiece -->
        <div class="product-3d-zone">
            <div class="product-card-3d" data-tilt data-tilt-max="15" data-tilt-speed="400" data-tilt-perspective="1000">
                <div class="product-image-wrap">
                    <img src="/Menshubprime/assets/images/<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['title']) ?>">
                </div>
                <div class="product-3d-badge">NEW LAUNCH</div>
                <div class="glow-effect"></div>
            </div>
            
            <div class="product-main-info">
                <span class="category-tag"><?= strtoupper($p['category']) ?></span>
                <h1><?= htmlspecialchars($p['title']) ?></h1>
                <div class="price-pill">₹<?= $p['price'] ?> <span class="old-price">₹<?= round($p['price'] * 1.4) ?></span></div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="review-details-grid">
            <!-- Trending Card -->
            <div class="glass-card trending-card">
                <div class="card-header">
                    <i class="fas fa-fire"></i> Why it's Trending?
                </div>
                <p><?= $trending_reason ?></p>
            </div>

            <!-- Pros/Cons Card -->
            <div class="glass-card pros-cons-card">
                <div class="card-header">
                    <i class="fas fa-check-circle"></i> Quick Verdict
                </div>
                <div class="pc-split">
                    <ul class="pros-list">
                        <?php foreach($pros as $pro): ?>
                        <li><i class="fas fa-plus"></i> <?= $pro ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <ul class="cons-list">
                        <?php foreach($cons as $con): ?>
                        <li><i class="fas fa-minus"></i> <?= $con ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Specs Card -->
            <div class="glass-card specs-card">
                <div class="card-header">
                    <i class="fas fa-list-ul"></i> Specifications
                </div>
                <div class="specs-grid">
                    <div class="spec-item"><span>Brand</span><strong>Premium</strong></div>
                    <div class="spec-item"><span>Quality</span><strong>High-End</strong></div>
                    <div class="spec-item"><span>Trend</span><strong>Viral</strong></div>
                    <div class="spec-item"><span>Stock</span><strong>Low</strong></div>
                </div>
            </div>
        </div>

        <!-- Final CTA -->
        <div class="review-cta-zone">
            <a href="/Menshubprime/product?id=<?= $p['id'] ?>" class="btn-3d-final">
                <span class="btn-glow"></span>
                <span class="btn-text">Check Full Details & Buy Now <i class="fas fa-arrow-right"></i></span>
            </a>
            <p class="cta-sub">Secure checkout via official affiliate partners.</p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>

<style>
:root {
    --accent-red: #f43f5e;
    --accent-blue: #3b82f6;
    --accent-orange: #f97316;
}

.review-3d-wrapper {
    min-height: 100vh;
    background: #020617;
    padding: 140px 20px 100px;
    position: relative;
    overflow: hidden;
    font-family: 'Outfit', sans-serif;
}

.review-bg-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
    z-index: 0;
    pointer-events: none;
}

.review-container {
    max-width: 1100px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

/* 3D Zone */
.product-3d-zone {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 80px;
}

.product-card-3d {
    width: 320px;
    height: 400px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transform-style: preserve-3d;
    box-shadow: 0 50px 100px rgba(0,0,0,0.5);
    margin-bottom: 40px;
    cursor: grab;
}

.product-image-wrap {
    width: 85%;
    transform: translateZ(50px);
}

.product-image-wrap img {
    width: 100%;
    filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
}

.product-3d-badge {
    position: absolute;
    top: 30px;
    right: -20px;
    background: var(--accent-orange);
    color: #fff;
    padding: 8px 16px;
    font-size: 12px;
    font-weight: 800;
    border-radius: 12px;
    transform: translateZ(80px) rotate(10deg);
}

.glow-effect {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(255,255,255,0.1), transparent);
    opacity: 0;
    transition: 0.3s;
}

.product-card-3d:hover .glow-effect { opacity: 1; }

.product-main-info h1 {
    font-size: clamp(32px, 6vw, 56px);
    font-weight: 900;
    color: #fff;
    letter-spacing: -2px;
    margin-bottom: 10px;
    line-height: 1.1;
}

.category-tag {
    font-size: 13px;
    font-weight: 700;
    color: var(--accent-orange);
    letter-spacing: 3px;
    margin-bottom: 20px;
    display: block;
}

.price-pill {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    padding: 10px 30px;
    background: rgba(255,255,255,0.05);
    border-radius: 100px;
    font-size: 24px;
    font-weight: 800;
    color: #fff;
}

.old-price {
    font-size: 16px;
    color: #475569;
    text-decoration: line-through;
}

/* Details Grid */
.review-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 80px;
}

.glass-card {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.06);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    padding: 35px;
    transition: 0.3s;
}

.glass-card:hover {
    background: rgba(255,255,255,0.04);
    border-color: rgba(255,255,255,0.12);
    transform: translateY(-5px);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 800;
    font-size: 18px;
    color: #fff;
    margin-bottom: 20px;
}

.card-header i { color: var(--accent-orange); }

.glass-card p {
    color: #94a3b8;
    line-height: 1.7;
    font-size: 16px;
}

.pc-split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.pros-list, .cons-list { list-style: none; padding: 0; }
.pros-list li, .cons-list li {
    font-size: 14px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pros-list li { color: #2ecc71; }
.cons-list li { color: #94a3b8; opacity: 0.7; }

.specs-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.spec-item {
    display: flex;
    flex-direction: column;
}
.spec-item span { font-size: 12px; color: #475569; }
.spec-item strong { font-size: 15px; color: #fff; }

/* CTA Zone */
.review-cta-zone {
    text-align: center;
}

.btn-3d-final {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 22px 60px;
    background: #fff;
    border-radius: 20px;
    text-decoration: none;
    position: relative;
    overflow: hidden;
    transition: 0.4s;
}

.btn-text {
    position: relative;
    z-index: 2;
    color: #000;
    font-weight: 800;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #fb923c, #f97316);
    opacity: 0;
    transition: 0.4s;
    z-index: 1;
}

.btn-3d-final:hover { transform: scale(1.05); }
.btn-3d-final:hover .btn-glow { opacity: 1; }
.btn-3d-final:hover .btn-text { color: #fff; }

.cta-sub {
    margin-top: 20px;
    color: #475569;
    font-size: 14px;
}

@media (max-width: 768px) {
    .review-3d-wrapper { padding-top: 100px; }
    .product-main-info h1 { font-size: 40px; }
    .pc-split { grid-template-columns: 1fr; }
    .btn-3d-final { width: 100%; padding: 20px; }
}
</style>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
