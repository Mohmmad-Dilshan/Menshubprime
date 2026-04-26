<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM DROPSHIPPING STYLES */
.drop-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.1), transparent 40%),
                radial-gradient(circle at bottom left, rgba(34, 197, 94, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.d-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    border-radius: 100px;
    color: #22c55e;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    animation: fadeInDown 0.8s ease;
}

.drop-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
}

.drop-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

.drop-content {
    padding: 60px 20px 100px;
    max-width: 1100px;
    margin: 0 auto;
}

.d-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
}

.d-intro-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
    margin-bottom: 60px;
}

.d-intro-text h2 {
    font-size: 28px;
    color: #fff;
    margin-bottom: 20px;
}

.d-intro-text p {
    color: #94a3b8;
    line-height: 1.8;
}

.d-steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin: 60px 0;
}

.d-step-item {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 40px 30px;
    border-radius: 30px;
    text-align: center;
    transition: 0.3s;
}

.d-step-item:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.05);
    border-color: #22c55e;
}

.d-step-item i {
    font-size: 40px;
    color: #22c55e;
    margin-bottom: 20px;
}

.d-step-item h4 {
    color: #fff;
    font-size: 20px;
    margin-bottom: 15px;
}

.d-step-item p {
    color: #94a3b8;
    font-size: 15px;
    line-height: 1.6;
}

.d-benefits {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 40px;
}

.benefit-pill {
    background: rgba(34, 197, 94, 0.05);
    border: 1px solid rgba(34, 197, 94, 0.1);
    padding: 15px 25px;
    border-radius: 100px;
    color: #cbd5e1;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.benefit-pill i {
    color: #22c55e;
}

.d-cta-section {
    margin-top: 80px;
    text-align: center;
    padding: 60px;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.05), rgba(249, 115, 22, 0.05));
    border-radius: 40px;
    border: 1px solid rgba(255,255,255,0.05);
}

.d-cta-btns {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
}

.d-btn {
    padding: 16px 40px;
    border-radius: 100px;
    font-weight: 800;
    text-decoration: none;
    transition: 0.3s;
}

.d-btn-primary {
    background: #22c55e;
    color: #fff;
    box-shadow: 0 15px 30px rgba(34, 197, 94, 0.3);
}

.d-btn-secondary {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.d-btn:hover {
    transform: translateY(-5px);
}

@media (max-width: 900px) {
    .d-intro-grid, .d-steps, .d-benefits { grid-template-columns: 1fr; }
    .d-intro-text { text-align: center; }
    .d-cta-btns { flex-direction: column; }
    .d-glass-card { padding: 40px 25px; border-radius: 30px; }
}
</style>

<div class="drop-hero">
    <div class="d-badge"><i class="fas fa-rocket"></i> Scale Your Business</div>
    <h1>Start <span style="color:#22c55e">Dropshipping</span></h1>
    <p>Launch your online empire with viral products curated by MenHub Prime. No inventory, low risk, high rewards.</p>
</div>

<div class="drop-content">
    <div class="d-glass-card">
        
        <div class="d-intro-grid">
            <div class="d-intro-text">
                <h2>The Modern Business Model</h2>
                <p>
                    Dropshipping allows you to sell high-demand products without ever touching inventory. You focus on marketing and sales, while we help you find the trending products that are built to go viral.
                    <br><br>
                    With MenHub Prime, you get more than just a list of items; you get the insights needed to win in a competitive market.
                </p>
            </div>
            <div style="background: rgba(34, 197, 94, 0.05); border-radius: 30px; padding: 40px; text-align: center; border: 1px solid rgba(34, 197, 94, 0.1);">
                <i class="fas fa-chart-line" style="font-size: 80px; color: #22c55e; margin-bottom: 20px;"></i>
                <h3 style="color:#fff; margin-bottom: 10px;">Low Risk, High Growth</h3>
                <p style="color:#94a3b8; font-size:14px;">Perfect for entrepreneurs starting with limited capital.</p>
            </div>
        </div>

        <div class="d-steps">
            <div class="d-step-item">
                <i class="fas fa-layer-group"></i>
                <h4>Choose Product</h4>
                <p>Select viral and high demand products from our prime platform database.</p>
            </div>
            <div class="d-step-item">
                <i class="fas fa-store"></i>
                <h4>Create Store</h4>
                <p>Build your professional online store and list your curated prime products.</p>
            </div>
            <div class="d-step-item">
                <i class="fas fa-funnel-dollar"></i>
                <h4>Start Selling</h4>
                <p>Market your gear on social media and start banking your profits today.</p>
            </div>
        </div>

        <h3 style="color:#fff; text-align:center; margin-bottom:30px;">Why Partner With Us?</h3>
        <div class="d-benefits">
            <div class="benefit-pill"><i class="fas fa-check"></i> Viral product ideas analyzed weekly.</div>
            <div class="benefit-pill"><i class="fas fa-check"></i> Video marketing assets for social ads.</div>
            <div class="benefit-pill"><i class="fas fa-check"></i> Advanced product research tools.</div>
            <div class="benefit-pill"><i class="fas fa-check"></i> Direct affiliate & supplier connections.</div>
            <div class="benefit-pill"><i class="fas fa-check"></i> Full scaling & business guidance.</div>
            <div class="benefit-pill"><i class="fas fa-check"></i> Join a community of smart entrepreneurs.</div>
        </div>

        <div class="d-cta-section">
            <h3 style="color:#fff; font-size: 24px; margin-bottom: 15px;">Ready to build your empire?</h3>
            <p style="color:#94a3b8;">Our team is ready to help you find your first winning product.</p>
            <div class="d-cta-btns">
                <a href="/Menshubprime/contact" class="d-btn d-btn-primary">Contact Support</a>
                <a href="/Menshubprime/collaboration" class="d-btn d-btn-secondary">View Partnership</a>
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