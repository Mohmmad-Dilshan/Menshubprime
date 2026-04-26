<?php
include ROOT_PATH . '/includes/header.php';

/* PAGE BASED SEO - Only set if not already set by header logic */
if (!isset($page_title)) {
    $page_title = "About Us - MenHub Prime";
    $page_description = "Learn more about MenHub Prime and our mission to help smart men shop better.";
}
?>

<head>
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
</head>

<style>
/* --- PREMIUM ABOUT PAGE DESIGN --- */
.about-hero {
    padding: clamp(80px, 15vw, 120px) 20px clamp(40px, 10vw, 80px);
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.1), transparent 50%),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, 0.1), transparent 50%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.about-hero h1 {
    font-size: clamp(32px, 6vw, 56px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -1.5px;
    line-height: 1.1;
}

.about-hero h1 span { color: #f97316; }

.about-hero p {
    color: #94a3b8;
    font-size: clamp(16px, 3vw, 20px);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.5;
}

/* Glass Section Container */
.about-content-wrap {
    max-width: 1100px;
    margin: 0 auto 100px;
    padding: 0 20px;
}

.glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 32px;
    padding: clamp(25px, 5vw, 60px);
    margin-bottom: 40px;
}

.mission-grid {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 50px;
    align-items: center;
}

.mission-text h2 {
    font-size: clamp(24px, 4vw, 32px);
    color: #fff;
    margin-bottom: 20px;
    font-weight: 800;
}

.mission-text p {
    color: #94a3b8;
    line-height: 1.8;
    font-size: clamp(15px, 2vw, 17px);
}

/* Stats System */
.prime-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 40px;
}

.stat-item {
    background: rgba(255, 255, 255, 0.03);
    padding: 20px 10px;
    border-radius: 20px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.02);
}

.stat-item h4 {
    color: #f97316;
    font-size: clamp(20px, 4vw, 28px);
    margin-bottom: 5px;
    font-weight: 800;
}

.stat-item span {
    color: #cbd5e1;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: block;
    font-weight: 700;
}

/* Steps Section */
.work-steps {
    margin-top: clamp(60px, 10vw, 100px);
    text-align: center;
}

.work-steps h2 {
    font-size: clamp(24px, 5vw, 32px);
    color: #fff;
    margin-bottom: 50px;
    font-weight: 800;
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.step-box {
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid rgba(255,255,255,0.05);
    padding: 40px 30px;
    border-radius: 24px;
    position: relative;
    transition: 0.3s;
}

.step-box:hover {
    border-color: #f97316;
    transform: translateY(-8px);
}

.step-num {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 45px;
    height: 45px;
    background: #f97316;
    color: #fff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
}

.step-box h3 {
    color: #fff;
    margin-top: 15px;
    margin-bottom: 15px;
    font-size: 20px;
    font-weight: 700;
}

.step-box p {
    color: #94a3b8;
    font-size: 15px;
    line-height: 1.6;
}

/* Brands Strip */
.partner-logos {
    margin-top: clamp(60px, 10vw, 100px);
    text-align: center;
}

.logos-track {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: clamp(20px, 5vw, 40px);
    flex-wrap: wrap;
    opacity: 0.6;
    filter: grayscale(1);
    transition: 0.5s;
}

.partner-logos:hover .logos-track { opacity: 1; filter: grayscale(0); }

.logos-track img {
    height: clamp(25px, 4vw, 35px);
    width: auto;
    object-fit: contain;
}

/* Social & CTA */
.final-cta {
    background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(37, 99, 235, 0.1));
    border-radius: 32px;
    padding: clamp(40px, 8vw, 80px) clamp(20px, 5vw, 40px);
    text-align: center;
    margin-top: clamp(60px, 10vw, 100px);
    border: 1px solid rgba(255,255,255,0.05);
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.social-pill {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    border-radius: 100px;
    color: #fff;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    transition: 0.3s;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
}

.social-pill:hover { background: #f97316; border-color: #f97316; transform: scale(1.05); }

/* RESPONSIVE OVERRIDES */
@media (max-width: 991px) {
    .mission-grid { grid-template-columns: 1fr; gap: 40px; text-align: center; }
}

@media (max-width: 768px) {
    .steps-grid { grid-template-columns: 1fr; gap: 40px; }
    .prime-stats-grid { grid-template-columns: repeat(2, 1fr); }
    .stat-item:last-child { grid-column: span 2; }
}

@media (max-width: 480px) {
    .prime-stats-grid { grid-template-columns: 1fr; }
    .stat-item:last-child { grid-column: span 1; }
    .social-pill { width: 100%; justify-content: center; }
    .mission-visual div { max-width: 200px; margin: 0 auto; }
}
</style>

<div class="about-hero">
    <h1>Built for <span>Smart Men</span></h1>
    <p>We curate the world's best gear, tech, and style so you don't have to waste time searching.</p>
</div>

<div class="about-content-wrap">
    
    <!-- Mission Section -->
    <div class="glass-card">
        <div class="mission-grid">
            <div class="mission-text">
                <h2>Our Vision</h2>
                <p>
                    MenHub Prime was born from a simple observation: the internet is too noisy. Finding a high-quality product that actually delivers value has become a full-time job.
                    <br><br>
                    Our mission is to cut through the fluff and bring you verified, high-value deals from trusted giants like <strong>Amazon, Flipkart, and Myntra.</strong> We don't just find deals; we find the <i>prime</i> ones.
                </p>
                <div class="prime-stats-grid">
                    <div class="stat-item">
                        <h4>5K+</h4>
                        <span>Smart Men</span>
                    </div>
                    <div class="stat-item">
                        <h4>10K+</h4>
                        <span>Deals Found</span>
                    </div>
                    <div class="stat-item">
                        <h4>24/7</h4>
                        <span>Active Monitoring</span>
                    </div>
                </div>
            </div>
            <div class="mission-visual" style="text-align: center;">
                <div style="background: rgba(249,115,22,0.1); width: 100%; aspect-ratio: 1; border-radius: 30px; display: flex; align-items: center; justify-content: center; position: relative;">
                    <i class="fas fa-gem" style="font-size: 80px; color: #f97316;"></i>
                    <!-- Animated elements -->
                    <div style="position: absolute; width: 100%; height: 100%; border: 2px dashed rgba(249,115,22,0.2); border-radius: 30px; animation: rotate 20s linear infinite;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- How it Works -->
    <div class="work-steps">
        <h2>How We Find the Best Gear</h2>
        <div class="steps-grid">
            <div class="step-box">
                <div class="step-num">1</div>
                <h3>Intelligent Tracking</h3>
                <p>Our algorithms track price fluctuations across major platforms to spot real drops, not fake discounts.</p>
            </div>
            <div class="step-box">
                <div class="step-num">2</div>
                <h3>Manual Vetting</h3>
                <p>We check ratings, seller history, and review quality to ensure every product is actually worth your money.</p>
            </div>
            <div class="step-box">
                <div class="step-num">3</div>
                <h3>Prime Selection</h3>
                <p>Only the top 1% of products make it to our homepage. We focus on quality over quantity.</p>
            </div>
        </div>
    </div>

    <!-- Partner Logos -->
    <div class="partner-logos">
        <p style="color: #64748b; font-weight: 800; text-transform: uppercase; font-size: 11px; letter-spacing: 2px; margin-bottom: 25px;">Our Trusted Partners</p>
        <div class="logos-track">
            <img src="assets/images/amazon.png" alt="Amazon">
            <img src="assets/images/flipkart.png" alt="Flipkart">
            <img src="assets/images/myntra.png" alt="Myntra">
            <img src="assets/images/ajio.png" alt="AJIO">
            <img src="assets/images/meesho.png" alt="Meesho">
        </div>
    </div>

    <!-- Connect -->
    <div class="final-cta">
        <h2 style="color: #fff; font-size: 28px; font-weight: 800; margin-bottom: 15px;">Join the Inner Circle</h2>
        <p style="color: #94a3b8; margin-bottom: 30px;">Get exclusive alerts, viral tech news, and secret deals before they go out of stock.</p>
        <div class="social-links">
            <a href="https://t.me/thezayanway" target="_blank" class="social-pill" style="background: #0088cc;">
                <i class="fab fa-telegram-plane"></i> Telegram
            </a>
            <a href="https://instagram.com/thezayanway" target="_blank" class="social-pill" style="background: #e4405f;">
                <i class="fab fa-instagram"></i> Instagram
            </a>
            <a href="https://x.com/thezayanway" target="_blank" class="social-pill" style="background: #000;">
                <i class="fab fa-twitter"></i> Twitter
            </a>
        </div>
    </div>

</div>

<style>
@keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
