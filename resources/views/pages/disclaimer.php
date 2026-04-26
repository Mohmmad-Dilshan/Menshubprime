<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM DISCLAIMER STYLES */
.disclaimer-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(239, 68, 68, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(249, 115, 22, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.d-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 100px;
    color: #ef4444;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    animation: fadeInDown 0.8s ease;
}

.disclaimer-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
    animation: fadeInUp 0.8s ease;
}

.disclaimer-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
    animation: fadeInUp 1s ease;
}

.disclaimer-content {
    padding: 60px 20px 100px;
    max-width: 1000px;
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
    position: relative;
}

.d-section {
    margin-bottom: 50px;
}

.d-section:last-child {
    margin-bottom: 0;
}

.d-section h2 {
    font-size: 22px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.d-section h2 i {
    color: #ef4444;
    font-size: 20px;
}

.d-text {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.8;
}

.d-highlight {
    background: rgba(239, 68, 68, 0.05);
    border-left: 4px solid #ef4444;
    padding: 25px;
    border-radius: 0 20px 20px 0;
    margin: 40px 0;
}

.d-highlight p {
    color: #cbd5e1;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}

.d-footer {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    text-align: center;
}

.d-footer p {
    color: #64748b;
    font-size: 14px;
    font-style: italic;
}

@media (max-width: 768px) {
    .d-glass-card { padding: 40px 25px; border-radius: 30px; }
    .disclaimer-hero { padding-top: 120px; }
    .disclaimer-hero h1 { font-size: 38px; }
}
</style>

<div class="disclaimer-hero">
    <div class="d-badge"><i class="fas fa-exclamation-triangle"></i> Legal Notice</div>
    <h1>General <span style="color:#ef4444">Disclaimer</span></h1>
    <p>Please read our legal disclaimer carefully. This document outlines the limits of our liability regarding information, products, and links.</p>
</div>

<div class="disclaimer-content">
    <div class="d-glass-card">
        
        <div class="d-section">
            <h2><i class="fas fa-handshake"></i> Affiliate Relationship</h2>
            <p class="d-text">
                MenHub Prime is an affiliate and informational website. Some links on this platform are affiliate links, meaning we may earn a small commission if you purchase through them. This comes at <strong>zero extra cost</strong> to you and helps us maintain the site.
            </p>
        </div>

        <div class="d-section">
            <h2><i class="fas fa-check-double"></i> Information Accuracy</h2>
            <p class="d-text">
                While we strive for excellence, we make no guarantees regarding the completeness, reliability, or accuracy of the information provided. Product prices, availability, and specific features are subject to change by the original sellers (Amazon, Flipkart, etc.) without notice.
            </p>
        </div>

        <div class="d-highlight">
            <p>Reliance on any information provided on MenHub Prime is strictly at your own risk. Always verify the latest details on the merchant's checkout page before completing a purchase.</p>
        </div>

        <div class="d-section">
            <h2><i class="fas fa-shipping-fast"></i> Product responsibility</h2>
            <p class="d-text">
                All products featured on MenHub Prime are sold and shipped by third-party vendors. We do not manufacture, store, or ship any physical goods. Any issues related to delivery, defects, or returns must be handled directly with the vendor where the item was purchased.
            </p>
        </div>

        <div class="d-section">
            <h2><i class="fas fa-external-link-alt"></i> External Links</h2>
            <p class="d-text">
                Our platform contains many links to external sites that are not operated by us. We have no control over the content or practices of these sites and cannot accept responsibility or liability for their respective privacy policies or terms of service.
            </p>
        </div>

        <div class="d-footer">
            <p>Last updated: April 2026. For further questions, please head over to our contact page.</p>
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