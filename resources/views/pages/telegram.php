<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM TELEGRAM STYLES */
.tg-hero {
    padding: 140px 0 60px;
    background: radial-gradient(circle at top right, rgba(56, 189, 248, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(34, 197, 94, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.tg-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(56, 189, 248, 0.1);
    border: 1px solid rgba(56, 189, 248, 0.2);
    border-radius: 100px;
    color: #38bdf8;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    animation: fadeInDown 0.8s ease;
}

.tg-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
}

.tg-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.tg-content {
    padding: 40px 20px 100px;
    max-width: 900px;
    margin: 0 auto;
}

.tg-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    text-align: center;
}

.tg-features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin: 40px 0;
    text-align: left;
}

.tg-feature-item {
    display: flex;
    gap: 15px;
    align-items: flex-start;
}

.tg-feature-item i {
    color: #38bdf8;
    font-size: 18px;
    margin-top: 3px;
}

.tg-feature-item span {
    color: #cbd5e1;
    font-size: 15px;
    line-height: 1.5;
}

.tg-join-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 20px 45px;
    background: linear-gradient(135deg, #38bdf8, #0ea5e9);
    color: #fff;
    text-decoration: none;
    border-radius: 100px;
    font-weight: 800;
    font-size: 20px;
    transition: 0.3s;
    box-shadow: 0 20px 40px rgba(56, 189, 248, 0.3);
}

.tg-join-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(56, 189, 248, 0.4);
}

.tg-trust-stats {
    margin-top: 40px;
    padding-top: 40px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    justify-content: center;
    gap: 20px;
    color: #94a3b8;
    font-size: 14px;
}

@media (max-width: 768px) {
    .tg-glass-card { padding: 40px 25px; border-radius: 30px; }
    .tg-hero h1 { font-size: 38px; }
    .tg-features-grid { grid-template-columns: 1fr; }
    .tg-join-btn { padding: 20px 3px; width: 100%; justify-content: center; font-size: 18px; }
}
</style>

<div class="tg-hero">
    <div class="tg-badge"><i class="fab fa-telegram-plane"></i> VIP Channel</div>
    <h1>Telegram <span style="color:#38bdf8">Club</span></h1>
    <p>Get instant price drop alerts, hidden coupon codes, and limited-time loot deals directly on your phone.</p>
</div>

<div class="tg-content">
    <div class="tg-glass-card">
        
        <h2>Why Join the Club?</h2>
        
        <div class="tg-features-grid">
            <div class="tg-feature-item">
                <i class="fas fa-bolt"></i>
                <span><strong>Instant Alerts:</strong> Be the first to know about flash sales.</span>
            </div>
            <div class="tg-feature-item">
                <i class="fas fa-tag"></i>
                <span><strong>Hidden Coupons:</strong> Access exclusive codes not found anywhere else.</span>
            </div>
            <div class="tg-feature-item">
                <i class="fas fa-check-circle"></i>
                <span><strong>Verified Deals:</strong> Every loot is manualy checked by our team.</span>
            </div>
            <div class="tg-feature-item">
                <i class="fas fa-shield-alt"></i>
                <span><strong>No Spam:</strong> Clean updates, only high-value deals.</span>
            </div>
        </div>

        <a href="https://t.me/thezayanway" target="_blank" class="tg-join-btn">
            Join the Channel <i class="fab fa-telegram-plane"></i>
        </a>

        <div class="tg-trust-stats">
            <span><i class="fas fa-users"></i> Fast Growing Community</span>
            <span>•</span>
            <span><i class="fas fa-lock"></i> 100% Free Access</span>
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
