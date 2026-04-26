<?php
include ROOT_PATH . '/includes/header.php';
include ROOT_PATH . '/helpers/brand_helper.php';

// Security Redirect
if (($sys['show_wishlist'] ?? 0) == 0) {
    echo "<script>window.location='/Menshubprime/'</script>";
    exit();
}

// Fetch active stores from the database
$results = mysqli_query($conn, "SELECT * FROM stores WHERE status = 1 ORDER BY id ASC");
$brands = [];
while ($row = mysqli_fetch_assoc($results)) {
    // Count live deals for this store
    $store_id = $row['id'];
    $count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE store_id = '$store_id' AND (status = 'active' OR status = '1')");
    $count_row = mysqli_fetch_assoc($count_res);
    
    $brands[] = [
        'name' => $row['name'],
        'slug' => $row['slug'],
        'icon' => $row['icon'],
        'color' => $row['color'],
        'deals' => $count_row['total']
    ];
}
?>

<div class="brand-hub-container">
    <div class="hub-header">
        <h1>Affiliate <span class="highlight">Stores</span></h1>
        <p>Browse the best deals from your favorite shopping platforms</p>
    </div>

    <!-- Store Stories (App Style) -->
    <div class="store-stories-wrap">
        <div class="stories-container">
            <?php foreach($brands as $b): ?>
            <a href="/Menshubprime/brand-store/<?= $b['slug'] ?>" class="story-item" style="--story-color: <?= $b['color'] ?>">
                <div class="story-circle">
                    <i class="<?= $b['icon'] ?>"></i>
                </div>
                <span><?= $b['name'] ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Featured Hero Section -->
    <?php if(!empty($brands)): 
        $f = $brands[0]; // Take the first store as featured for now
    ?>
    <div class="featured-hero-wrap">
        <a href="/Menshubprime/brand-store/<?= $f['slug'] ?>" class="featured-card" style="--feat-color: <?= $f['color'] ?>">
            <div class="feat-badge">Featured Store</div>
            <div class="feat-content">
                <div class="feat-icon"><i class="<?= $f['icon'] ?>"></i></div>
                <div class="feat-info">
                    <h2><?= $f['name'] ?> Mega Sale</h2>
                    <p>Unlock exclusive discounts up to 70% off today.</p>
                </div>
            </div>
            <div class="feat-action">Visit Now <i class="fas fa-arrow-right"></i></div>
        </a>
    </div>
    <?php endif; ?>

    <div class="brand-grid">
            <?php foreach($brands as $index => $b): ?>
            <a href="/Menshubprime/brand-store/<?= $b['slug'] ?>" class="brand-card reveal-item" style="--brand-color: <?= $b['color'] ?>; --delay: <?= $index * 0.1 ?>s">
                <div class="brand-logo-wrap">
                    <i class="<?= $b['icon'] ?>"></i>
                </div>
                <div class="brand-info">
                    <h3><?= $b['name'] ?></h3>
                    <div class="deal-badge">
                        <i class="fas fa-bolt"></i> <?= $b['deals'] ?> Live Deals
                    </div>
                </div>
                <div class="card-action-btn">Open</div>
                <div class="card-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            <?php endforeach; ?>
    </div>
    
    <!-- Custom Stores Section -->
    <div class="custom-stores">
        <h2>More Brands Coming Soon...</h2>
        <div class="store-tags">
            <span>Ajio</span> <span>Nykaa</span> <span>Mamaearth</span> <span>H&M</span>
        </div>
    </div>
</div>

<style>
:root {
    --glass-bg: rgba(255, 255, 255, 0.03);
    --glass-border: rgba(255, 255, 255, 0.08);
    --neon-shadow: 0 0 20px rgba(249, 115, 22, 0.2);
}

.brand-hub-container {
    max-width: 1200px;
    margin: 160px auto 100px;
    padding: 0 20px;
    font-family: 'Outfit', sans-serif;
    position: relative;
}

/* Background Mesh Glows */
.brand-hub-container::before {
    content: '';
    position: absolute;
    top: -100px;
    left: -50px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(249, 115, 22, 0.1) 0%, transparent 70%);
    z-index: -1;
}

.hub-header {
    text-align: center;
    margin-bottom: 80px;
}

.hub-header h1 {
    font-size: clamp(36px, 8vw, 64px);
    font-weight: 900;
    margin-bottom: 15px;
    letter-spacing: -2px;
    color: #fff;
    line-height: 1.1;
}

.hub-header .highlight {
    background: linear-gradient(135deg, #fb923c, #f97316);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hub-header p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.brand-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 35px;
}

.brand-card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    backdrop-filter: blur(15px);
    border-radius: 32px;
    padding: 35px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 25px;
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
    text-decoration: none;
}

.brand-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent, rgba(255,255,255,0.03));
    opacity: 0;
    transition: opacity 0.4s;
}

.brand-card:hover {
    transform: translateY(-12px) scale(1.02);
    border-color: var(--brand-color);
    box-shadow: 
        0 25px 50px -12px rgba(0, 0, 0, 0.5),
        0 0 25px -5px var(--brand-color);
    background: rgba(15, 23, 42, 0.6);
}

.brand-card:hover::after {
    opacity: 1;
}

.brand-logo-wrap {
    width: 85px;
    height: 85px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    color: var(--brand-color);
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: inset 0 0 15px rgba(255,255,255,0.05);
}

.brand-card:hover .brand-logo-wrap {
    background: #fff;
    transform: rotateY(180deg);
}

/* Fix icon rotation so it's not mirrored when background rotates */
.brand-card:hover .brand-logo-wrap i {
    transform: rotateY(-180deg);
}

.brand-info {
    width: 100%;
}

.brand-info h3 {
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.deal-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 100px;
    font-size: 14px;
    color: #cbd5e1;
    font-weight: 700;
    transition: all 0.3s;
}

.brand-card:hover .deal-badge {
    background: var(--brand-color);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 15px var(--brand-color);
}

.card-arrow {
    position: absolute;
    right: 35px;
    bottom: 35px;
    width: 50px;
    height: 50px;
    background: var(--glass-border);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: all 0.4s;
    opacity: 0.3;
}

.brand-card:hover .card-arrow {
    opacity: 1;
    background: var(--brand-color);
    transform: rotate(-45deg);
}

.custom-stores {
    margin-top: 120px;
    text-align: center;
    padding: 60px 40px;
    background: linear-gradient(to bottom, transparent, rgba(139, 92, 246, 0.03));
    border-radius: 40px;
    border-top: 1px dashed rgba(255,255,255,0.1);
}

.custom-stores h2 {
    font-size: 22px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.store-tags {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.store-tags span {
    padding: 10px 25px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 100px;
    color: #64748b;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s;
}

.store-tags span:hover {
    color: #fff;
    background: rgba(255,255,255,0.1);
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .brand-hub-container { margin-top: 100px; padding: 0 15px; }
    .hub-header { text-align: left; margin-bottom: 30px; }
    .hub-header h1 { font-size: 32px; }
    .hub-header p { margin: 0; font-size: 15px; }

    /* Hide hub header on mobile if needed for more compact look */
    /* .hub-header { display: none; } */

    /* Store Stories Row */
    .store-stories-wrap {
        margin: 0 -15px 30px;
        padding: 0 15px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .store-stories-wrap::-webkit-scrollbar { display: none; }
    
    .stories-container {
        display: flex;
        gap: 15px;
        padding-bottom: 5px;
    }
    .story-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        min-width: 75px;
    }
    .story-circle {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: var(--glass-bg);
        border: 2px solid var(--story-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--story-color);
        padding: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    .story-item span {
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Featured Hero Card */
    .featured-hero-wrap {
        margin-bottom: 35px;
    }
    .featured-card {
        display: block;
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.95));
        border: 1px solid var(--glass-border);
        border-radius: 28px;
        padding: 25px;
        position: relative;
        text-decoration: none;
        overflow: hidden;
        border-left: 4px solid var(--feat-color);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    .featured-card::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, var(--feat-color) 0%, transparent 70%);
        opacity: 0.2;
    }
    .feat-badge {
        display: inline-block;
        padding: 4px 12px;
        background: var(--feat-color);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        border-radius: 100px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    .feat-content {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 20px;
    }
    .feat-icon {
        font-size: 40px;
        color: var(--feat-color);
    }
    .feat-info h2 {
        font-size: 20px;
        color: #fff;
        margin-bottom: 5px;
    }
    .feat-info p {
        font-size: 14px;
        color: #94a3b8;
    }
    .feat-action {
        font-size: 13px;
        font-weight: 700;
        color: var(--feat-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* App List Layout */
    .brand-grid { grid-template-columns: 1fr; gap: 15px; }
    .brand-card {
        flex-direction: row;
        align-items: center;
        padding: 15px 20px;
        gap: 15px;
        border-radius: 20px;
    }
    .brand-logo-wrap {
        width: 60px;
        height: 60px;
        min-width: 60px;
        font-size: 28px;
        border-radius: 14px;
    }
    .brand-info h3 {
        font-size: 18px;
        margin-bottom: 4px;
    }
    .deal-badge {
        padding: 2px 10px;
        font-size: 11px;
    }
    .card-arrow { display: none; }
    
    .card-action-btn {
        display: block;
        padding: 6px 18px;
        background: rgba(255,255,255,0.08);
        border-radius: 100px;
        color: #3b82f6;
        font-weight: 800;
        font-size: 13px;
        text-transform: uppercase;
    }
}

/* Animations Row Reveal */
.reveal-item {
    opacity: 0;
    transform: translateY(20px);
    animation: revealCard 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    animation-delay: var(--delay);
}

@keyframes revealCard {
    to { opacity: 1; transform: translateY(0); }
}

/* Hide action btn on desktop */
@media (min-width: 769px) {
    .card-action-btn, .store-stories-wrap, .featured-hero-wrap { display: none; }
}
</style>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
