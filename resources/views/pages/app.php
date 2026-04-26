<?php
$page_title = "Download MenHub Prime App | Premium Shopping Experience";
$page_description = "Experience MenHub Prime like a real app. Install our PWA for faster loading, offline access, and premium mobile shopping for smart men.";
include ROOT_PATH . '/includes/header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

<style>
.app-page-container {
    max-width: 900px;
    margin: 60px auto;
    padding: 0 20px;
    font-family: 'Outfit', sans-serif;
    color: #fff;
    text-align: center;
}

.app-hero {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(249, 115, 22, 0.1) 100%);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 30px;
    padding: 60px 40px;
    backdrop-filter: blur(20px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    margin-bottom: 50px;
}

.app-icon-large {
    width: 120px;
    height: 120px;
    background: #f97316;
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 60px;
    color: #fff;
    margin: 0 auto 30px;
    box-shadow: 0 15px 35px rgba(249, 115, 22, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); box-shadow: 0 15px 35px rgba(249, 115, 22, 0.4); }
    50% { transform: scale(1.05); box-shadow: 0 25px 50px rgba(249, 115, 22, 0.6); }
    100% { transform: scale(1); box-shadow: 0 15px 35px rgba(249, 115, 22, 0.4); }
}

.app-title {
    font-size: clamp(32px, 6vw, 48px);
    font-weight: 900;
    margin-bottom: 15px;
    letter-spacing: -1px;
}

.app-title span {
    color: #f97316;
}

.app-subtitle {
    font-size: 18px;
    color: #94a3b8;
    max-width: 600px;
    margin: 0 auto 40px;
    line-height: 1.6;
}

.install-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.feature-box {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 30px;
    border-radius: 20px;
    transition: 0.3s;
}

.feature-box:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: #f97316;
    transform: translateY(-5px);
}

.feature-box i {
    font-size: 30px;
    color: #f97316;
    margin-bottom: 15px;
}

.feature-box h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
}

.feature-box p {
    font-size: 14px;
    color: #94a3b8;
}

.guide-section {
    margin-top: 80px;
    text-align: left;
}

.guide-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 30px;
    text-align: center;
}

.guide-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

@media (max-width: 768px) {
    .guide-grid { grid-template-columns: 1fr; }
    .app-hero { padding: 40px 20px; }
}

.guide-box {
    background: rgba(15, 23, 42, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 30px;
    border-radius: 24px;
}

.guide-box h4 {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 20px;
    margin-bottom: 20px;
    color: #f97316;
}

.guide-steps {
    list-style: none;
    padding: 0;
}

.guide-steps li {
    margin-bottom: 15px;
    display: flex;
    gap: 15px;
    font-size: 15px;
    color: #cbd5e1;
}

.step-num {
    background: #f97316;
    color: #000;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 12px;
    flex-shrink: 0;
}

.install-button-trigger {
    display: inline-block;
    background: #f97316;
    color: #000;
    padding: 18px 45px;
    border-radius: 100px;
    font-weight: 800;
    font-size: 18px;
    text-decoration: none;
    margin-bottom: 20px;
    transition: 0.3s;
    cursor: pointer;
    border: none;
    box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
}

.install-button-trigger:hover {
    transform: scale(1.05);
    box-shadow: 0 15px 35px rgba(249, 115, 22, 0.5);
}

.install-button-trigger span {
    font-size: 14px;
    opacity: 0.8;
    font-weight: 400;
    display: block;
}
</style>

<div class="app-page-container">
    <div class="app-hero">
        <div class="app-icon-large">
            <i class="fas fa-heart"></i>
        </div>
        <h1 class="app-title">MensHub <span>Prime App</span></h1>
        <p class="app-subtitle">Ab shopping aur bhi fast aur easy hai! Hamare Web App ko apne phone par install karein aur payein premium experience.</p>
        
        <button id="pwaInstallBtn" class="install-button-trigger" style="display: none;">
            Install App Now
            <span>Faster Access • Lite Weight • Secure</span>
        </button>

        <div class="install-features">
            <div class="feature-box">
                <i class="fas fa-bolt"></i>
                <h3>Fast Loading</h3>
                <p>App mode mein website 2x fast load hoti hai.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-mobile-alt"></i>
                <h3>Fullscreen</h3>
                <p>Bina kisi browser buttons ke pura app jaisa feel.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-cloud-moon"></i>
                <h3>Offline Mode</h3>
                <p>Kuch features bina internet ke bhi kaam karenge.</p>
            </div>
        </div>
    </div>

    <div class="guide-section">
        <h2 class="guide-title">How to Install</h2>
        <div class="guide-grid">
            <div class="guide-box">
                <h4><i class="fab fa-android"></i> For Android (Chrome)</h4>
                <ul class="guide-steps">
                    <li><span class="step-num">1</span> Browser ke upar right side 3 dots (⋮) par click karein.</li>
                    <li><span class="step-num">2</span> <b>"Install App"</b> ya <b>"Add to Home Screen"</b> par click karein.</li>
                    <li><span class="step-num">3</span> Confirm karein aur app icon aapke home screen par aa jayega!</li>
                </ul>
            </div>
            <div class="guide-box">
                <h4><i class="fab fa-apple"></i> For iOS (Safari)</h4>
                <ul class="guide-steps">
                    <li><span class="step-num">1</span> Safari browser mein neeche <b>Share</b> button par click karein.</li>
                    <li><span class="step-num">2</span> List ko scroll karein aur <b>"Add to Home Screen"</b> choose karein.</li>
                    <li><span class="step-num">3</span> Top right mein <b>"Add"</b> par click karein. Done!</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
let deferredPrompt;
const installBtn = document.getElementById('pwaInstallBtn');

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    installBtn.style.display = 'inline-block';
});

installBtn.addEventListener('click', (e) => {
    installBtn.style.display = 'none';
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the A2HS prompt');
        } else {
            console.log('User dismissed the A2HS prompt');
        }
        deferredPrompt = null;
    });
});
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
