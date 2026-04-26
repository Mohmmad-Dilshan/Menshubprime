<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM AFFILIATE STYLES */
.affiliate-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(34, 197, 94, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(249, 115, 22, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.affiliate-hero::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200%;
    height: 200%;
    background: url('assets/images/grid-dots.png') repeat;
    opacity: 0.03;
    transform: translate(-50%, -50%) rotate(-15deg);
    pointer-events: none;
}

.a-badge {
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

.affiliate-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
    animation: fadeInUp 0.8s ease;
}

.affiliate-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    animation: fadeInUp 1s ease;
}

.affiliate-content {
    padding: 60px 20px 100px;
    max-width: 1000px;
    margin: 0 auto;
}

.a-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    position: relative;
}

.a-section {
    margin-bottom: 50px;
}

.a-section:last-child {
    margin-bottom: 0;
}

.a-section h2 {
    font-size: 24px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.a-section h2 i {
    color: #22c55e;
    font-size: 20px;
}

.a-text {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.8;
}

.a-benefit-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 30px;
}

.a-benefit-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 25px;
    border-radius: 24px;
    transition: 0.3s;
}

.a-benefit-card:hover {
    background: rgba(255, 255, 255, 0.06);
    transform: translateY(-5px);
}

.a-benefit-card i {
    font-size: 24px;
    color: #22c55e;
    margin-bottom: 15px;
    display: block;
}

.a-benefit-card h4 {
    color: #fff;
    margin-bottom: 10px;
    font-size: 17px;
}

.a-benefit-card p {
    color: #94a3b8;
    font-size: 14px;
    margin: 0;
    line-height: 1.5;
}

.a-highlight {
    background: rgba(34, 197, 94, 0.05);
    border-left: 4px solid #22c55e;
    padding: 25px;
    border-radius: 0 20px 20px 0;
    margin: 40px 0;
}

.a-highlight h3 {
    color: #fff;
    font-size: 18px;
    margin-bottom: 10px;
}

.a-highlight p {
    color: #94a3b8;
    font-size: 14px;
    margin: 0;
}

.a-trust-box {
    margin-top: 60px;
    padding: 40px;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(249, 115, 22, 0.1));
    border-radius: 30px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.a-trust-box h3 {
    color: #fff;
    margin-bottom: 15px;
}

.a-brand-logos {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-top: 30px;
    opacity: 0.6;
}

.a-brand-logos i {
    font-size: 28px;
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
    .a-glass-card { padding: 40px 25px; border-radius: 30px; }
    .affiliate-hero { padding-top: 120px; }
    .affiliate-hero h1 { font-size: 34px; }
    .a-benefit-grid { grid-template-columns: 1fr; }
    .a-section h2 { font-size: 20px; }
}
</style>

<div class="affiliate-hero">
    <div class="a-badge"><i class="fas fa-handshake"></i> Fully Transparent</div>
    <h1>Affiliate <span style="color:#22c55e">Disclosure</span></h1>
    <p>Honesty is our priority. We want you to know exactly how we sustain our platform while helping you find the best deals.</p>
</div>

<div class="affiliate-content">
    <div class="a-glass-card">
        
        <div class="a-section">
            <h2><i class="fas fa-info-circle"></i> What is MenHub Prime?</h2>
            <p class="a-text">
                MenHub Prime ek personal affiliate curation platform hai. Humara kaam din bhar internet par faili hui hazaron deals me se sirf best aur verified deals ko chun kar aapke samne lana hai. 
            </p>
        </div>

        <div class="a-section">
            <h2><i class="fas fa-link"></i> Personalized Links</h2>
            <p class="a-text">
                Is website par diye gaye products ke link affiliate links ho sakte hain. Iska matlab hai ki agar aap un links par click karke kuch buy karte hain, toh humein us store (jaise Amazon ya Myntra) se ek chota commission milta hai.
            </p>
        </div>

        <div class="a-benefit-grid">
            <div class="a-benefit-card">
                <i class="fas fa-coins"></i>
                <h4>Zero Extra Cost</h4>
                <p>Aapko wahi price dena padta hai jo normally hota. Humara commission brand pay karta hai, aap nahi.</p>
            </div>
            <div class="a-benefit-card">
                <i class="fas fa-rocket"></i>
                <h4>Supports Us</h4>
                <p>Ye commission humein website ko fast rakhne aur daily fresh deals update karne me help karta hai.</p>
            </div>
        </div>

        <div class="a-highlight">
            <h3>Our Trust Promise</h3>
            <p>Hum sirf unhi products ko recommend karte hain jo ya toh humne khud test kiye hain, ya unki user rating bohot high hai. Commission kabhi bhi humare reviews ko bias nahi karta.</p>
        </div>

        <div class="a-section">
            <h2><i class="fas fa-shopping-cart"></i> Trusted Partners</h2>
            <p class="a-text">
                Hum world-class shopping platforms ke saath kaam karte hain taaki aapko security ki koi fikar na ho:
            </p>
            <div class="a-brand-logos">
                <i class="fab fa-amazon" title="Amazon"></i>
                <i class="fas fa-shopping-bag" title="Myntra"></i>
                <i class="fas fa-bolt" title="Flipkart"></i>
                <i class="fas fa-tshirt" title="AJIO"></i>
            </div>
        </div>

        <div class="a-trust-box">
            <h3>Shopping with Confidence</h3>
            <p class="a-text">Aap bindass hoke shop kar sakte hain, humari research aapke liye pure din chalti hai.</p>
            <p style="margin-top:20px; font-weight:800; color:#fff;">– Team MenHub Prime</p>
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
