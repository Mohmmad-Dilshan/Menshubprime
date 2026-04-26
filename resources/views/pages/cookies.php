<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM COOKIES STYLES */
.cookies-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.c-badge {
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

.cookies-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
    animation: fadeInUp 0.8s ease;
}

.cookies-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
    animation: fadeInUp 1s ease;
}

.cookies-content {
    padding: 60px 20px 100px;
    max-width: 1000px;
    margin: 0 auto;
}

.c-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    position: relative;
}

.c-section {
    margin-bottom: 50px;
}

.c-section:last-child {
    margin-bottom: 0;
}

.c-section h2 {
    font-size: 22px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.c-section h2 span {
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

.c-text {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.8;
}

.c-list {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.c-list li {
    display: flex;
    gap: 15px;
    align-items: flex-start;
    margin-bottom: 15px;
    color: #cbd5e1;
    font-size: 15px;
}

.c-list li i {
    color: #f97316;
    font-size: 14px;
    margin-top: 5px;
}

.c-highlight {
    background: rgba(249, 115, 22, 0.05);
    border-left: 4px solid #f97316;
    padding: 25px;
    border-radius: 0 20px 20px 0;
    margin: 40px 0;
}

.c-highlight p {
    color: #cbd5e1;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}

.c-footer-note {
    margin-top: 60px;
    padding: 40px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 30px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.c-footer-note p {
    color: #94a3b8;
    font-size: 15px;
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
    .c-glass-card { padding: 40px 25px; border-radius: 30px; }
    .cookies-hero { padding-top: 120px; }
    .cookies-hero h1 { font-size: 38px; }
}
</style>

<div class="cookies-hero">
    <div class="c-badge"><i class="fas fa-cookie-bite"></i> Trust & Privacy</div>
    <h1>Cookies <span style="color:#f97316">Policy</span></h1>
    <p>Understanding how we use cookies to provide a smarter, faster, and more personalized experience for you.</p>
</div>

<div class="cookies-content">
    <div class="c-glass-card">
        
        <div class="c-section">
            <h2><span>1</span> What are Cookies?</h2>
            <p class="c-text">
                Cookies are small text files stored on your device when you visit websites. They act like a memory for the browser, helping us remember your preferences, keep you logged in, and understand how you interact with our platform.
            </p>
        </div>

        <div class="c-section">
            <h2><span>2</span> How we use them</h2>
            <p class="c-text">At MenHub Prime, we use cookies for the following purposes:</p>
            <ul class="c-list">
                <li><i class="fas fa-check-circle"></i> <strong>Functionality:</strong> To remember your theme settings and navigation preferences.</li>
                <li><i class="fas fa-check-circle"></i> <strong>Analytics:</strong> To see which deals and blogs are trending, so we can provide more value.</li>
                <li><i class="fas fa-check-circle"></i> <strong>Personalization:</strong> To show you products and offers that match your interests.</li>
                <li><i class="fas fa-check-circle"></i> <strong>Security:</strong> To protect your account and our website from unauthorized access.</li>
            </ul>
        </div>

        <div class="c-highlight">
            <p><strong>Strict Privacy:</strong> Our cookies do not store sensitive personal information like your full name, home address, or payment details. They are purely for site optimization.</p>
        </div>

        <div class="c-section">
            <h2><span>3</span> Third-Party Cookies</h2>
            <p class="c-text">
                We may use trusted partners like Google Analytics and Meta to analyze traffic. These partners use their own cookies to help us improve MenHub Prime. You can find more details in our <a href="/Menshubprime/privacy" style="color:#f97316; text-decoration:none;">Privacy Policy</a>.
            </p>
        </div>

        <div class="c-section">
            <h2><span>4</span> Your Choices</h2>
            <p class="c-text">
                Most browsers accept cookies automatically, but you can change your settings to block them. Please note that disabling cookies may cause some parts of the site to not function correctly (like your saved preferences).
            </p>
        </div>

        <div class="c-footer-note">
            <p>By continuing to use our website, you agree to our use of cookies as described in this policy.</p>
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
