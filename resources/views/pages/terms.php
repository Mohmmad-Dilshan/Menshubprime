<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM TERMS STYLES */
.terms-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.t-badge {
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

.terms-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
    animation: fadeInUp 0.8s ease;
}

.terms-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
    animation: fadeInUp 1s ease;
}

.terms-content {
    padding: 60px 20px 100px;
    max-width: 1000px;
    margin: 0 auto;
}

.t-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    position: relative;
}

.t-section {
    margin-bottom: 50px;
}

.t-section:last-child {
    margin-bottom: 0;
}

.t-section h2 {
    font-size: 22px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.t-section h2 span {
    width: 35px;
    height: 35px;
    background: rgba(249, 115, 22, 0.1);
    color: #f97316;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 900;
}

.t-text {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.8;
}

.t-highlight {
    background: rgba(249, 115, 22, 0.05);
    border-left: 4px solid #f97316;
    padding: 25px;
    border-radius: 0 20px 20px 0;
    margin: 40px 0;
}

.t-highlight p {
    color: #cbd5e1;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}

.t-footer-note {
    margin-top: 60px;
    padding: 40px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 30px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.t-footer-note p {
    color: #94a3b8;
    font-size: 15px;
    margin-bottom: 20px;
}

.t-btn-small {
    display: inline-flex;
    padding: 10px 25px;
    background: rgba(249, 115, 22, 0.1);
    border: 1px solid rgba(249, 115, 22, 0.2);
    color: #f97316;
    text-decoration: none;
    border-radius: 100px;
    font-weight: 700;
    font-size: 14px;
    transition: 0.3s;
}

.t-btn-small:hover {
    background: #f97316;
    color: #fff;
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
    .t-glass-card { padding: 40px 25px; border-radius: 30px; }
    .terms-hero { padding-top: 120px; }
    .terms-hero h1 { font-size: 38px; }
}
</style>

<div class="terms-hero">
    <div class="t-badge"><i class="fas fa-file-contract"></i> Legal Agreement</div>
    <h1>Terms of <span style="color:#f97316">Service</span></h1>
    <p>Please read these terms carefully before using MenHub Prime. By accessing our platform, you agree to follow these guidelines.</p>
</div>

<div class="terms-content">
    <div class="t-glass-card">
        
        <div class="t-section">
            <h2><span>1</span> Website Usage</h2>
            <p class="t-text">
                Welcome to MenHub Prime. You may use this website only for lawful and personal purposes. Any misuse of the website, including automated scraping, illegal activities, or unauthorized access attempts, is strictly prohibited and may result in a ban.
            </p>
        </div>

        <div class="t-section">
            <h2><span>2</span> Affiliate Disclosure</h2>
            <p class="t-text">
                MenHub Prime is an affiliate curation platform. We are not the direct seller or owner of any products listed. We provide direct links to verified marketplaces like Amazon and Flipkart. All transactions happen on the respective seller's platform.
            </p>
        </div>

        <div class="t-highlight">
            <p><strong>Note:</strong> We are not responsible for delivery, returns, or product quality issues. These should be addressed directly with the vendor where the purchase was made.</p>
        </div>

        <div class="t-section">
            <h2><span>3</span> Content Accuracy</h2>
            <p class="t-text">
                While we strive for 100% accuracy, deals and prices change rapidly. We do not guarantee that prices or offers will remain the same by the time you visit the store link. Always verify the final price on the seller's page.
            </p>
        </div>

        <div class="t-section">
            <h2><span>4</span> Policy Changes</h2>
            <p class="t-text">
                We reserve the right to update or modify these Terms & Conditions at any time. Changes take effect as soon as they are published here. Continued use of the site constitutes acceptance of the new terms.
            </p>
        </div>

        <div class="t-footer-note">
            <p>Have questions about our terms?</p>
            <a href="/Menshubprime/contact" class="t-btn-small">Contact Support</a>
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
