<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM PRIVACY STYLES */
.privacy-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.privacy-hero::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200%;
    height: 200%;
    background: url('assets/images/grid-dots.png') repeat;
    opacity: 0.03;
    transform: translate(-50%, -50%) rotate(15deg);
    pointer-events: none;
}

.p-badge {
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

.privacy-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
    animation: fadeInUp 0.8s ease;
}

.privacy-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    animation: fadeInUp 1s ease;
}

.privacy-content {
    padding: 60px 20px 100px;
    max-width: 1000px;
    margin: 0 auto;
}

.p-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    position: relative;
}

.p-section {
    margin-bottom: 50px;
}

.p-section:last-child {
    margin-bottom: 0;
}

.p-section h2 {
    font-size: 24px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.p-section h2 i {
    color: #f97316;
    font-size: 20px;
}

.p-text {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.8;
}

.p-list {
    list-style: none;
    padding: 0;
    margin-top: 20px;
}

.p-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    color: #cbd5e1;
    margin-bottom: 12px;
    font-size: 15px;
}

.p-list li i {
    color: #f97316;
    margin-top: 4px;
    font-size: 14px;
}

.p-highlight {
    background: rgba(249, 115, 22, 0.05);
    border-left: 4px solid #f97316;
    padding: 25px;
    border-radius: 0 20px 20px 0;
    margin: 40px 0;
}

.p-highlight h3 {
    color: #fff;
    font-size: 18px;
    margin-bottom: 10px;
}

.p-highlight p {
    color: #94a3b8;
    font-size: 14px;
    margin: 0;
}

.p-contact-box {
    margin-top: 60px;
    padding: 40px;
    background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(37, 99, 235, 0.1));
    border-radius: 30px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.p-contact-box h3 {
    color: #fff;
    margin-bottom: 15px;
}

.p-contact-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 30px;
    background: #f97316;
    color: #fff;
    text-decoration: none;
    border-radius: 100px;
    font-weight: 800;
    margin-top: 20px;
    transition: 0.3s;
}

.p-contact-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(249, 115, 22, 0.4);
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
    .p-glass-card { padding: 40px 25px; border-radius: 30px; }
    .privacy-hero { padding-top: 120px; }
    .privacy-hero h1 { font-size: 38px; }
    .p-section h2 { font-size: 20px; }
}
</style>

<div class="privacy-hero">
    <div class="p-badge"><i class="fas fa-shield-alt"></i> Safe & Secure</div>
    <h1>Privacy <span style="color:#f97316">Policy</span></h1>
    <p>At MenHub Prime, we believe your data belongs to you. We are committed to absolute transparency and data protection.</p>
</div>

<div class="privacy-content">
    <div class="p-glass-card">
        
        <div class="p-section">
            <h2><i class="fas fa-user-shield"></i> Data Respect</h2>
            <p class="p-text">
                TheZayanWay aapki privacy ko fully respect karta hai. Hum believe karte hain ki ek trusted relationship ke liye transparency zaroori hai. Hamara main goal aapko best deals provide karna hai, na ki user data collect karna.
            </p>
        </div>

        <div class="p-section">
            <h2><i class="fas fa-cookie-bite"></i> How We Use Cookies</h2>
            <p class="p-text">
                Hum simple cookies ka use karte hain taaki aapka browsing experience smooth rahe. Cookies humein niche diye gaye kaam me help karti hain:
            </p>
            <ul class="p-list">
                <li><i class="fas fa-check-circle"></i> Website performance improve karne ke liye.</li>
                <li><i class="fas fa-check-circle"></i> Aapki preferences yaad rakhne ke liye.</li>
                <li><i class="fas fa-check-circle"></i> Relevant shopping deals aur ads show karne ke liye.</li>
                <li><i class="fas fa-check-circle"></i> Traffic analyze karke content behtar banane ke liye.</li>
            </ul>
        </div>

        <div class="p-highlight">
            <h3>Zero Misuse Policy</h3>
            <p>Hum kabhi bhi kisi bhi user ka personal data kisi third-party ko sell, rent ya lease nahi karte. Aapka data hamare pass 100% safe hai.</p>
        </div>

        <div class="p-section">
            <h2><i class="fas fa-external-link-alt"></i> Third Party Links</h2>
            <p class="p-text">
                Kyunki hum ek affiliate platform hain, hamari website par Amazon, Flipkart, aur Myntra jaise platforms ke links hote hain. Jab aap un links par click karte hain, tab unki apni privacy policy apply hoti hai.
            </p>
        </div>

        <div class="p-contact-box">
            <h3>Pricavy-related Questions?</h3>
            <p class="p-text">Agar aapko hamari policy ya data use se related koi bhi doubt ho, feel free to reach out.</p>
            <a href="/Menshubprime/contact" class="p-contact-btn">
                Contact Support <i class="fas fa-arrow-right"></i>
            </a>
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
