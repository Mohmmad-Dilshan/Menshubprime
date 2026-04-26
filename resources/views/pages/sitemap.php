<?php
include 'config/db.php';
include ROOT_PATH . '/includes/header.php';
?>

<style>
/* PREMIUM SITEMAP STYLES */
.sitemap-hero {
    padding: 140px 0 60px;
    background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(249, 115, 22, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.s-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 100px;
    color: #3b82f6;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    animation: fadeInDown 0.8s ease;
}

.sitemap-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
}

.sitemap-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.sitemap-container {
    padding: 40px 20px 100px;
    max-width: 1200px;
    margin: 0 auto;
}

.s-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
}

.s-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
}

.s-section h2 {
    font-size: 20px;
    color: #fff;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.s-section h2 i {
    color: #f97316;
}

.s-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.s-links li {
    margin-bottom: 12px;
}

.s-links li a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 15px;
    transition: 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.s-links li a::before {
    content: '→';
    font-size: 12px;
    opacity: 0;
    transform: translateX(-10px);
    transition: 0.3s;
    color: #f97316;
}

.s-links li a:hover {
    color: #fff;
    transform: translateX(5px);
}

.s-links li a:hover::before {
    opacity: 1;
    transform: translateX(0);
}

@media (max-width: 768px) {
    .s-glass-card { padding: 40px 25px; border-radius: 30px; }
    .sitemap-hero h1 { font-size: 38px; }
}
</style>

<div class="sitemap-hero">
    <div class="s-badge"><i class="fas fa-map-marked-alt"></i> Navigation Map</div>
    <h1>Website <span style="color:#f97316">Sitemap</span></h1>
    <p>Finding your way through MenHub Prime. Explore our curated collections, viral content, and essential pages.</p>
</div>

<div class="sitemap-container">
    <div class="s-glass-card">
        
        <div class="s-grid">

            <!-- MAIN PAGES -->
            <div class="s-section">
                <h2><i class="fas fa-home"></i> Core Navigation</h2>
                <ul class="s-links">
                    <li><a href="/Menshubprime/">Homepage</a></li>
                    <li><a href="/Menshubprime/about">About MensHub Prime</a></li>
                    <li><a href="/Menshubprime/categories">Product Categories</a></li>
                    <li><a href="/Menshubprime/deals">Hottest Deals</a></li>
                    <li><a href="/Menshubprime/comparisons">Comparison Guides (Top Picks)</a></li>
                    <li><a href="/Menshubprime/videos">Viral Product Videos</a></li>
                    <li><a href="/Menshubprime/blog">Premium Blog</a></li>
                    <li><a href="/Menshubprime/digital-products">Digital Assets</a></li>
                </ul>
            </div>

            <!-- DYNAMIC COLLECTIONS -->
            <div class="s-section">
                <h2><i class="fas fa-layer-group"></i> Collections</h2>
                <ul class="s-links">
                    <?php
                    $q = mysqli_query($conn,"SELECT slug,name FROM categories WHERE status='active' OR status=1 LIMIT 8");
                    while($row = mysqli_fetch_assoc($q)){
                        echo '<li><a href="/Menshubprime/category/'.$row['slug'].'">'.$row['name'].'</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- RECENT BLOGS -->
            <div class="s-section">
                <h2><i class="fas fa-newspaper"></i> Latest Articles</h2>
                <ul class="s-links">
                    <?php
                    $q = mysqli_query($conn,"SELECT title,slug FROM blogs WHERE status='active' OR status=1 ORDER BY id DESC LIMIT 6");
                    while($row = mysqli_fetch_assoc($q)){
                        echo '<li><a href="/Menshubprime/blog/'.$row['slug'].'">'.mb_strimwidth($row['title'], 0, 30, "...").'</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- TRENDING VIDEOS -->
            <div class="s-section">
                <h2><i class="fas fa-play-circle"></i> Trending Reviews</h2>
                <ul class="s-links">
                    <?php
                    $q = mysqli_query($conn,"SELECT title,slug FROM videos WHERE status=1 OR status='active' LIMIT 6");
                    while($row = mysqli_fetch_assoc($q)){
                        echo '<li><a href="/Menshubprime/video/'.$row['slug'].'">'.mb_strimwidth($row['title'], 0, 30, "...").'</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- PARTNERSHIPS & SERVICES -->
            <div class="s-section">
                <h2><i class="fas fa-handshake"></i> Services & Partners</h2>
                <ul class="s-links">
                    <li><a href="/Menshubprime/collaboration">Business Collaboration</a></li>
                    <li><a href="/Menshubprime/dropshipping">Dropshipping Service</a></li>
                    <li><a href="/Menshubprime/hire-me">Hire Me (Consultation)</a></li>
                    <li><a href="/Menshubprime/mobile-app">Mobile App Experience</a></li>
                    <li><a href="/Menshubprime/affiliate">Affiliate Disclosure</a></li>
                    <li><a href="/Menshubprime/contact">Contact Support</a></li>
                </ul>
            </div>

            <!-- LEGAL & SAFETY -->
            <div class="s-section">
                <h2><i class="fas fa-shield-alt"></i> Safety & Legal</h2>
                <ul class="s-links">
                    <li><a href="/Menshubprime/faq">Help Center (FAQ)</a></li>
                    <li><a href="/Menshubprime/privacy">Privacy Policy</a></li>
                    <li><a href="/Menshubprime/terms">Terms of Service</a></li>
                    <li><a href="/Menshubprime/refund">Refund Policy</a></li>
                    <li><a href="/Menshubprime/disclaimer">Disclaimer</a></li>
                    <li><a href="/Menshubprime/cookies">Cookie Policy</a></li>
                </ul>
            </div>

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

<?php include ROOT_PATH . '/includes/footer.php'; ?>
