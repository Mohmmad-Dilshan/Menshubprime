<?php include ROOT_PATH . '/includes/header.php'; ?>

<head>
    <title>FAQ - MenHub Prime Help Center</title>
    <meta name="description" content="Find answers to common questions about MenHub Prime, our deals, digital products, and how we help smart men shop better.">
</head>

<style>
/* --- PREMIUM FAQ DESIGN SYSTEM --- */
.faq-hero {
    padding: 100px 20px 60px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, 0.08), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.faq-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: url('assets/images/grid.png'); /* Assuming a subtle grid exists */
    opacity: 0.1;
    pointer-events: none;
}

.faq-title {
    font-size: clamp(32px, 5vw, 48px);
    font-weight: 800;
    color: #fff;
    margin-bottom: 15px;
    letter-spacing: -1px;
}

.faq-title span {
    color: #f97316;
}

.faq-subtitle {
    color: #94a3b8;
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto 40px;
}

.faq-container {
    max-width: 850px;
    margin: 0 auto 100px;
    padding: 0 20px;
}

/* Glassmorphism Accordion */
.faq-item {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 20px;
    margin-bottom: 15px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.faq-item:hover {
    border-color: rgba(249, 115, 22, 0.3);
    background: rgba(15, 23, 42, 0.8);
    transform: translateY(-2px);
}

.faq-header {
    padding: 24px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.faq-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #f1f5f9;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 15px;
}

.faq-header h3 i {
    color: #f97316;
    font-size: 16px;
    width: 24px;
    text-align: center;
}

.faq-icon-box {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 50%;
    color: #94a3b8;
    transition: transform 0.4s;
}

.faq-item.active .faq-icon-box {
    transform: rotate(180deg);
    background: rgba(249, 115, 22, 0.1);
    color: #f97316;
}

/* Content Animation */
.faq-content {
    max-height: 0;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 0 30px 0 69px; /* Aligned with text after icon */
}

.faq-item.active .faq-content {
    max-height: 500px; /* Large enough to fit content */
    padding-bottom: 30px;
}

.faq-content p {
    color: #94a3b8;
    line-height: 1.7;
    font-size: 16px;
    margin: 0;
}

/* Support CTA */
.support-cta {
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(30, 41, 59, 0.9));
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 30px;
    padding: 40px;
    text-align: center;
    margin-top: 60px;
}

.support-cta h4 {
    color: #fff;
    font-size: 24px;
    margin-bottom: 10px;
}

.support-cta p {
    color: #94a3b8;
    margin-bottom: 25px;
}

.btn-contact {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #f97316;
    color: #fff;
    padding: 14px 28px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    transition: 0.3s;
}

.btn-contact:hover {
    background: #fff;
    color: #f97316;
    transform: scale(1.05);
}

@media (max-width: 600px) {
    .faq-header { padding: 20px; }
    .faq-header h3 { font-size: 16px; }
    .faq-content { padding: 0 20px 0 20px; }
    .faq-item.active .faq-content { padding-bottom: 20px; }
    .faq-hero { padding-top: 80px; }
}
</style>

<div class="faq-hero">
    <h1 class="faq-title">Help <span>Center</span></h1>
    <p class="faq-subtitle">Everything you need to know about MenHub Prime and how we curate the world's best deals.</p>
</div>

<div class="faq-container">
    <div class="faq-box">

        <!-- Question 1 -->
        <div class="faq-item">
            <div class="faq-header">
                <h3><i class="fas fa-info-circle"></i> What is MenHub Prime?</h3>
                <div class="faq-icon-box"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="faq-content">
                <p>MenHub Prime is a premium curation platform dedicated to helping smart men find the absolute best deals, viral products, and digital toolkit essentials across major marketplaces like Amazon and Flipkart.</p>
            </div>
        </div>

        <!-- Question 2 -->
        <div class="faq-item">
            <div class="faq-header">
                <h3><i class="fas fa-shield-alt"></i> Are the products genuine?</h3>
                <div class="faq-icon-box"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="faq-content">
                <p>Absolutely. We don't sell products directly; instead, we curate and review links from verified, high-rated sellers on trusted global platforms. Every deal you see has been vetted for quality and authenticity.</p>
            </div>
        </div>

        <!-- Question 3 -->
        <div class="faq-item">
            <div class="faq-header">
                <h3><i class="fas fa-bolt"></i> How do you find these deals?</h3>
                <div class="faq-icon-box"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="faq-content">
                <p>Our team (and smart algorithms) tracks price history, social media trends, and marketplace ratings 24/7. We look for high-value price drops that offer the best "bang for buck" for our community.</p>
            </div>
        </div>

        <!-- Question 4 -->
        <div class="faq-item">
            <div class="faq-header">
                <h3><i class="fas fa-undo"></i> Do you provide refunds?</h3>
                <div class="faq-icon-box"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="faq-content">
                <p>Since your purchase is completed on marketplaces like Amazon or Flipkart, the refund and return process follows their respective policies. We recommend checking the seller's return window before completing your purchase.</p>
            </div>
        </div>

        <!-- Question 5 -->
        <div class="faq-item">
            <div class="faq-header">
                <h3><i class="fas fa-handshake"></i> How can brands collaborate?</h3>
                <div class="faq-icon-box"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="faq-content">
                <p>We're always looking for quality products to showcase. If you own a brand or service and want to reach thousands of smart shoppers, please visit our <strong>Collaboration page</strong> or contact us directly via email.</p>
            </div>
        </div>

        <!-- Question 6 -->
        <div class="faq-item">
            <div class="faq-header">
                <h3><i class="fas fa-wallet"></i> Does using your link cost extra?</h3>
                <div class="faq-icon-box"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="faq-content">
                <p>Not at all! In many cases, our links include discount codes or tracking that ensures you get the <strong>lowest</strong> possible price. We may earn a small commission which helps keep this platform running, but it costs you ₹0 extra.</p>
            </div>
        </div>

    </div>

    <!-- Contact Support CTA -->
    <div class="support-cta">
        <h4>Still have questions?</h4>
        <p>Can't find the answer you're looking for? Please chat with our friendly team.</p>
        <a href="/Menshubprime/contact" class="btn-contact">
            <i class="fas fa-envelope"></i> Contact Support
        </a>
    </div>
</div>

<script>
document.querySelectorAll(".faq-header").forEach(header => {
    header.addEventListener("click", () => {
        const item = header.parentElement;
        
        // Close other items
        document.querySelectorAll(".faq-item").forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.classList.remove("active");
            }
        });
        
        // Toggle current item
        item.classList.toggle("active");
    });
});
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>