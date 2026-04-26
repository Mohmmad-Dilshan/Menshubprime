<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM REFUND STYLES */
.refund-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.r-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(249, 115, 22, 0.1);
    border: 1px solid rgba(249, 115, 22, 0.2);
    border-radius: 100px;
    color: #f97316;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    animation: fadeInDown 0.8s ease;
}

.refund-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
    animation: fadeInUp 0.8s ease;
}

.refund-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
    animation: fadeInUp 1s ease;
}

.refund-content {
    padding: 60px 20px 100px;
    max-width: 1000px;
    margin: 0 auto;
}

.r-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    position: relative;
}

.r-section {
    margin-bottom: 50px;
}

.r-section:last-child {
    margin-bottom: 0;
}

.r-section h2 {
    font-size: 22px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.r-section h2 i {
    color: #f97316;
    font-size: 20px;
}

.r-text {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.8;
}

.r-highlight {
    background: rgba(249, 115, 22, 0.05);
    border-left: 4px solid #f97316;
    padding: 25px;
    border-radius: 0 20px 20px 0;
    margin: 40px 0;
}

.r-highlight p {
    color: #cbd5e1;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}

.r-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 40px;
}

.r-grid-item {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 30px;
    border-radius: 24px;
    transition: 0.3s;
}

.r-grid-item:hover {
    background: rgba(255, 255, 255, 0.06);
    transform: translateY(-5px);
}

.r-grid-item i {
    font-size: 30px;
    color: #f97316;
    margin-bottom: 15px;
    display: block;
}

.r-grid-item h4 {
    color: #fff;
    font-size: 18px;
    margin-bottom: 12px;
}

.r-grid-item p {
    color: #94a3b8;
    font-size: 14px;
    line-height: 1.5;
    margin: 0;
}

/* Animations */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .r-glass-card { padding: 40px 25px; border-radius: 30px; }
    .refund-hero { padding-top: 120px; }
    .refund-hero h1 { font-size: 38px; }
    .r-grid { grid-template-columns: 1fr; }
}
</style>

<div class="refund-hero">
    <div class="r-badge"><i class="fas fa-money-bill-wave"></i> Policy Info</div>
    <h1>Refund <span style="color:#f97316">Policy</span></h1>
    <p>We strive for clarity. Since we are an affiliate platform, our refund guidelines depend on the type of product you purchase.</p>
</div>

<div class="refund-content">
    <div class="r-glass-card">
        
        <div class="r-section">
            <h2><i class="fas fa-info-circle"></i> Service Overview</h2>
            <p class="r-text">
                MenHub Prime is mainly an affiliate curation platform. We do not manufacture or ship physical products. Your purchase is fulfilled by our partners like Amazon, Flipkart, or independent stores.
            </p>
        </div>

        <div class="r-grid">
            <div class="r-grid-item">
                <i class="fas fa-file-download"></i>
                <h4>Digital Products</h4>
                <p>Ebooks, premium guides, or digital tools are non-refundable once the download link is accessed, except in cases of technical failure.</p>
            </div>
            <div class="r-grid-item">
                <i class="fas fa-box-open"></i>
                <h4>Physical Products</h4>
                <p>Returns and refunds for items like clothing, tech or accessories follow the official policy of the store where the order was placed.</p>
            </div>
        </div>

        <div class="r-highlight">
            <p><strong>Note:</strong> We recommend checking the "Return & Refund" section on the checkout page of the respective store (Amazon, etc.) before finalizing your order.</p>
        </div>

        <div class="r-section">
            <h2><i class="fas fa-question-circle"></i> How to request?</h2>
            <p class="r-text">
                To initiate a return or refund for a physical product, please log in to your account on the store where you bought the item (e.g., Amazon "Your Orders" section) and follow their standard process.
            </p>
        </div>

        <div class="r-section">
            <h2><i class="fas fa-exclamation-triangle"></i> Damaged Items</h2>
            <p class="r-text">
                If you receive a wrong or damaged item, contact the store's support team immediately. They have dedicated systems to handle logistics and replacements.
            </p>
        </div>

        <div class="r-section" style="text-align: center; margin-top: 60px;">
            <p class="r-text">Still have questions? We're here to help.</p>
            <a href="/Menshubprime/contact" style="display:inline-block; margin-top:15px; padding:12px 30px; background:#f97316; color:#fff; text-decoration:none; border-radius:100px; font-weight:800;">Contact us</a>
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