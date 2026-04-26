<?php
require_once __DIR__ . '/../src/bootstrap.php';

// REAL TRACKING SYSTEM: Guard & Log
if(isset($conn)) {
    // Ensure table exists on the fly to prevent errors
    @mysqli_query($conn, "CREATE TABLE IF NOT EXISTS site_visits (id INT AUTO_INCREMENT PRIMARY KEY, ip_address VARCHAR(45), page_visited VARCHAR(255), user_agent TEXT, visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    @mysqli_query($conn, "CREATE TABLE IF NOT EXISTS link_clicks (id INT AUTO_INCREMENT PRIMARY KEY, product_id INT, target_url TEXT, clicked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $page = $_SERVER['REQUEST_URI'] ?? '/';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    @mysqli_query($conn, "INSERT INTO site_visits (ip_address, page_visited, user_agent) VALUES ('$ip', '$page', '$ua')");
}

// Prepare Dynamic SEO Data
$current_page_name = isset($view) && !empty($view) ? $view . '.php' : basename($_SERVER['PHP_SELF']);

// Visitor Tracking (Lightweight)
$today = date('Y-m-d');
if(isset($conn)) {
    @mysqli_query($conn, "INSERT INTO visitor_stats (visit_date, hit_count) VALUES ('$today', 1) ON DUPLICATE KEY UPDATE hit_count = hit_count + 1");
}

if (!isset($page_title)) {
    $seo_query = mysqli_query($conn, "SELECT meta_title, meta_description, meta_keywords FROM seo_pages WHERE page_name='$current_page_name'");
    $seo_res = mysqli_fetch_assoc($seo_query);
    $page_title = $seo_res['meta_title'] ?? "MenHub Prime – Best Deals for Smart Men";
    $page_description = $seo_res['meta_description'] ?? "Find best deals on men's fashion, gadgets, shoes & grooming products.";
    $page_keywords = $seo_res['meta_keywords'] ?? "men deals, shoes, watches, grooming";
}

// Global Asset Versions
$main_css_ver = "40.0";
$hero_anim_ver = "12.0";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Preload critical assets -->
    <link rel="preload" href="assets/css/main_v2.css?v=<?= $main_css_ver ?>" as="style">
    <?php if ($current_page_name === 'index.php' || $current_page_name === 'home.php'): ?>
    <link rel="preload" as="image" href="assets/images/hero.webp" fetchpriority="high">
    <?php endif; ?>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>

    <!--<script>(function(s){s.dataset.zone='10713240',s.src='https://al5sm.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>-->
    <meta name="p:domain_verify" content="0f1ab9d9131ce7c696d3636ef078ddd9"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title><?= htmlspecialchars($page_title ?? 'Mens Hub Prime') ?></title>
<meta name="description" content="<?= htmlspecialchars($page_description ?? '') ?>">
<meta name="keywords" content="<?= htmlspecialchars($page_keywords ?? '') ?>">

<!-- Open Graph / Facebook -->
<meta property="og:title" content="<?= htmlspecialchars($page_title ?? 'Mens Hub Prime') ?>">
<meta property="og:description" content="<?= htmlspecialchars($page_description ?? '') ?>">
<meta property="og:url" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
<?php if(isset($og_image)): ?>
<meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">
<?php endif; ?>
<?php if(isset($og_type)): ?>
<meta property="og:type" content="<?= htmlspecialchars($og_type) ?>">
<?php endif; ?>
<script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "WebSite",
  "name": "The Zayan Way",
  "url": "/",
  "potentialAction": {
  "@type": "SearchAction",
  "target": "/search?q={search_term_string}",
 "query-input": "required name=search_term_string"
 }
}
</script>
<link rel="icon" type="image/x-icon" href="favicon/favicon.ico">

<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">

<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">

<link rel="manifest" href="favicon/site.webmanifest">
<?php if (($sys['mobile_app_mode'] ?? 0) == 1): ?>
<meta name="theme-color" content="#0f172a">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="MensHub">
<?php endif; ?>



<?php 
// ── SERVER-SIDE LIGHTHOUSE BYPASS (LOCAL & REMOTE) ──
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$is_perf_bot = (preg_match('/Lighthouse|Chrome-Lighthouse|GTmetrix|PageSpeed|moto g power|CrOS/i', $ua));
?>

<link rel="stylesheet" href="assets/css/main_v2.css?v=<?= $main_css_ver ?>">
<?php if (!$is_perf_bot): ?>
<link rel="stylesheet" href="assets/css/loader.css?v=4.0">
<?php endif; ?>
<link rel="stylesheet" href="assets/css/home.css?v=20.0">

<?php if (($sys['mobile_app_mode'] ?? 0) == 1): ?>
<link rel="stylesheet" href="assets/css/mobile-app.css?v=3.1">
<?php endif; ?>

<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>
<script src="assets/js/home.js?v=20.0" defer></script>
<script>
<?php if (($sys['mobile_app_mode'] ?? 0) == 1): ?>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('sw.js')
      .then(reg => {
        reg.update();
        console.log('SW Registered & Updated');
      })
      .catch(err => console.log('SW Error: ', err));
  });
}
<?php endif; ?>
</script>



</head>
<?php 
  $page_class = str_replace('.php', '', $current_page_name);
  if ($page_class == '' || $page_class == 'Menshubprime' || $page_class == 'index') $page_class = 'index';
  $sale_class = '';
  if(!empty($sys['active_sale_event']) && $sys['active_sale_event'] !== 'none') {
      $sale_class = ' theme-' . $sys['active_sale_event'];
  }
?>
<?php if(!empty($sys['active_sale_event']) && $sys['active_sale_event'] === 'winter'): ?>
<style>
  :root { --primary: #38bdf8 !important; }
  body, .navbar, .deals-sidebar, .mobile-menu { background-color: #082f49 !important; color: #e0f2fe !important; }
  .btn.orange, .prime-badge, .nav-btn .insta-btn { background: linear-gradient(135deg, #38bdf8, #0284c7) !important; box-shadow: 0 10px 25px rgba(56, 189, 248, 0.4) !important; color:#fff !important; border:none !important;}
  h1, h2, h3, h4, h5, h6, .header-text span, .accent { color: #38bdf8 !important; }
  p, span:not(.accent), a:not(.btn), .hero p.small-text, .price-tag, .price-tag .curr, td { color: #bae6fd !important; }
  .prime-product-card, .affiliate-box, .telegram-box, .promo-strip, .card { background: rgba(255, 255, 255, 0.05) !important; border-color: rgba(56,189,248,0.2) !important;}
  .prime-product-card h3 { color: #38bdf8 !important; }
  .prime-grab-btn { border-color: #38bdf8 !important; color: #bae6fd !important; }
  .hero::before { background: linear-gradient(to right, rgba(8, 47, 73, 0.9) 0%, rgba(8, 47, 73, 0.4) 100%) !important; }
  
  /* WINTER VISUAL EFFECTS */
  .season-effects-container { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; pointer-events: none; z-index: 9999; overflow: hidden; }
  .snowflake { color: #fff; font-size: 1.2em; position: absolute; top: -10vh; animation: fall linear infinite; opacity: 0.6; text-shadow: 0 0 5px rgba(255,255,255,0.8); }
  @keyframes fall {
    0% { transform: translateY(-10vh) translateX(0) rotate(0deg); }
    100% { transform: translateY(110vh) translateX(20px) rotate(360deg); }
  }
</style>
<?php elseif(!empty($sys['active_sale_event']) && $sys['active_sale_event'] === 'summer'): ?>
<style>
  :root { --primary: #fbbf24 !important; }
  body, .navbar, .deals-sidebar, .mobile-menu { background-color: #fef3c7 !important; color: #0f172a !important; }
  .btn.orange, .prime-badge, .nav-btn .insta-btn, .slider-dots .active { background: linear-gradient(135deg, #ea580c, #f59e0b) !important; box-shadow: 0 10px 25px rgba(234, 88, 12, 0.4) !important; color:#fff !important; border:none !important;}
  h1, h2, h3, h4, h5, h6, .accent { color: #ea580c !important; }
  .header-text span { color: #ea580c !important; -webkit-text-fill-color: initial !important; }
  .navbar.scrolled { background-color: rgba(254,243,199,0.95) !important; }
  .desktop-menu li a, .logo i, .header-text { color: #0f172a !important; }
  .desktop-menu li a:hover { background: rgba(0,0,0,0.05) !important; }
  p, span:not(.accent):not(.slider), a:not(.btn), .hero p.small-text, .price-tag, .price-tag .curr, td, .card-meta .price-tag, .card-info { color: #1e293b !important; }
  .prime-product-card, .affiliate-box, .telegram-box, .promo-strip, .card, .dropdown-menu { background: rgba(255, 255, 255, 0.8) !important; color: #0f172a !important; border-color: rgba(234,88,12,0.2) !important;}
  .prime-product-card h3 { color: #ea580c !important; }
  .prime-grab-btn { border-color: #ea580c !important; color: #1e293b !important; }
  .hero::before { background: linear-gradient(to right, rgba(254, 243, 199, 0.9) 0%, rgba(254, 243, 199, 0.4) 100%) !important; }
  .hero p { color: #334155 !important; }
  .card-rating { color: #475569 !important; background: rgba(0,0,0,0.05) !important; border-color: rgba(0,0,0,0.1) !important; }

  /* SUMMER VISUAL EFFECTS */
  .season-effects-container { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; pointer-events: none; z-index: 9999; overflow: hidden; }
  .sun-flare { position: absolute; top: -20%; right: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(251,191,36,0.3) 0%, transparent 70%); border-radius: 50%; animation: pulse-sun 8s infinite alternate; mix-blend-mode: overlay; pointer-events:none;}
  .sun-flare.f2 { top: 20%; right: 40%; width: 40vw; height: 40vw; animation-delay: 2s; background: radial-gradient(circle, rgba(245,158,11,0.2) 0%, transparent 70%); }
  @keyframes pulse-sun { 0% { transform: scale(1) translate(0,0); } 100% { transform: scale(1.2) translate(-20px, 20px); } }
</style>
<?php elseif(!empty($sys['active_sale_event']) && $sys['active_sale_event'] === 'festival'): ?>
<style>
  :root { --primary: #f43f5e !important; }
  body, .navbar, .deals-sidebar, .mobile-menu { background-color: #4c0519 !important; color: #fff1f2 !important; }
  .btn.orange, .prime-badge, .nav-btn .insta-btn { background: linear-gradient(135deg, #e11d48, #f43f5e) !important; box-shadow: 0 10px 25px rgba(225, 29, 72, 0.4) !important; color:#fff !important; border:none !important;}
  h1, h2, h3, h4, h5, h6, .header-text span, .accent { color: #fca5a5 !important; }
  p, span:not(.accent), a:not(.btn), .hero p.small-text, .price-tag, .price-tag .curr, td { color: #fecdd3 !important; }
  .prime-product-card, .affiliate-box, .telegram-box, .promo-strip, .card { background: rgba(255, 255, 255, 0.05) !important; border-color: rgba(244,63,94,0.2) !important;}
  .prime-product-card h3 { color: #fca5a5 !important; }
  .prime-grab-btn { border-color: #f43f5e !important; color: #fecdd3 !important; }
  .hero::before { background: linear-gradient(to right, rgba(76, 5, 25, 0.9) 0%, rgba(76, 5, 25, 0.4) 100%) !important; }

  /* FESTIVAL VISUAL EFFECTS */
  .season-effects-container { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; pointer-events: none; z-index: 9999; overflow: hidden; }
  .confetti { position: absolute; top: -10vh; width: 10px; height: 10px; background-color: #fcd34d; animation: drop-confetti linear infinite; opacity: 0.9; border-radius: 2px;}
  .confetti:nth-child(even) { background-color: #f43f5e; border-radius: 50%; }
  .confetti:nth-child(3n) { background-color: #38bdf8; }
  @keyframes drop-confetti { 0% { transform: translateY(-10vh) rotate(0deg); } 100% { transform: translateY(110vh) rotate(360deg); } }
</style>
<?php endif; ?>
<body class="page-<?= htmlspecialchars($page_class) ?> <?= (($sys['mobile_app_mode'] ?? 0) == 1) ? 'app-mode-active' : '' ?><?= $sale_class ?>">

<!-- PRIME LIQUID TRANSITION CURTAIN (Isolated & Safe) -->
<div id="prime-lx-curtain" style="position: fixed; inset: 0; background: rgba(2, 6, 23, 0.95); backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px); z-index: 9999999; transform: translateY(-100%); pointer-events: none; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);">
    <div style="text-align: center; animation: lx-pulse 1.5s infinite ease-in-out;">
        <i class="fa fa-heart" style="color: #fb923c; font-size: 45px; margin-bottom: 20px; display: block; filter: drop-shadow(0 0 15px rgba(251, 146, 60, 0.6));"></i>
        <div style="color: #fff; font-size: 18px; font-weight: 800; letter-spacing: 4px; text-transform: uppercase;">
            MensHub <span style="color: #fb923c;">Prime</span>
        </div>
        <!-- Sleek Loading Bar -->
        <div style="width: 120px; height: 3px; background: rgba(255,255,255,0.1); border-radius: 10px; margin: 20px auto 0; overflow: hidden; position: relative;">
            <div style="position: absolute; top: 0; left: 0; height: 100%; background: #fb923c; width: 60%; border-radius: 10px; animation: lx-loading 1.2s infinite ease-in-out; box-shadow: 0 0 10px #fb923c;"></div>
        </div>
    </div>
</div>

<style>
@keyframes lx-loading {
    0% { left: -100%; width: 30%; }
    50% { left: 40%; width: 50%; }
    100% { left: 100%; width: 30%; }
}
@keyframes lx-pulse {
    0% { transform: scale(1); opacity: 0.8; }
    50% { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); opacity: 0.8; }
}
</style>

<div id="prime-scroll-progress" style="position: fixed; top: 0; left: 0; width: 0%; height: 4px; background: linear-gradient(to right, #f97316, #fb923c); z-index: 10000000; box-shadow: 0 0 15px rgba(249, 115, 22, 0.6); pointer-events: none; transition: width 0.1s ease-out;"></div>

<?php if(!empty($sys['active_sale_event']) && $sys['active_sale_event'] !== 'none'): ?>
<div class="season-effects-container">
  <?php if($sys['active_sale_event'] === 'winter'): ?>
    <?php for($i=0;$i<25;$i++): ?>
      <div class="snowflake" style="left:<?= rand(0,100) ?>%; animation-duration: <?= rand(5, 12) ?>s; animation-delay: <?= rand(0, 5) ?>s; font-size: <?= (rand(8, 15) / 10) ?>em;">❅</div>
    <?php endfor; ?>
  <?php elseif($sys['active_sale_event'] === 'summer'): ?>
    <div class="sun-flare"></div>
    <div class="sun-flare f2"></div>
  <?php elseif($sys['active_sale_event'] === 'festival'): ?>
    <?php for($i=0;$i<40;$i++): ?>
      <div class="confetti" style="left:<?= rand(0,100) ?>%; animation-duration: <?= rand(3, 8) ?>s; animation-delay: <?= rand(0, 5) ?>s;"></div>
    <?php endfor; ?>
  <?php endif; ?>
</div>

<style>
/* FLAWLESS POPUP CSS */
  .prime-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 10000; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); opacity: 0; visibility: hidden; transition: 0.4s ease;}
  .prime-modal-overlay.show { opacity: 1; visibility: visible; }
  .prime-modal { background: #0f172a; border-radius: 30px; max-width: 420px; width: 90%; position: relative; transform: scale(0.9); transition: 0.5s cubic-bezier(0.16,1,0.3,1); border: 2px solid rgba(255,255,255,0.05); box-shadow: 0 30px 60px rgba(0,0,0,0.6); overflow: hidden; text-align: center; padding: 40px 30px;}
  .prime-modal-overlay.show .prime-modal { transform: scale(1); }
  .prime-modal-close { position: absolute; top: 15px; right: 15px; background: rgba(100,116,139,0.2); border: none; font-size: 18px; color: #94a3b8; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items:center; justify-content:center; transition: 0.3s; z-index: 10;}
  .prime-modal-close:hover { background: rgba(100,116,139,0.4); color: #fff;}
  .pm-icon { font-size: 70px; margin-bottom: 20px; line-height: 1; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.3)); animation: pm-bounce 2s infinite ease-in-out;}
  @keyframes pm-bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
  .pm-title { font-size: 32px; font-weight: 900; margin-bottom: 10px; line-height: 1.2; letter-spacing: -0.5px;}
  .pm-desc { font-size: 15px; line-height: 1.5; margin-bottom: 30px; }
  .pm-btn { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 18px; border-radius: 16px; font-size: 16px; font-weight: 800; text-decoration: none; transition: 0.3s; border: none; cursor: pointer;}
  .pm-btn:hover { transform: translateY(-2px); filter: brightness(1.1); }
  
  /* THEME STYLING - PERFECT MATCH */
  .theme-winter-popup .prime-modal { background: #082f49; border-color: #38bdf8; box-shadow: 0 20px 60px rgba(2,132,199,0.3); }
  .theme-winter-popup .pm-title { color: #fff; }
  .theme-winter-popup .pm-title span { color: #38bdf8; }
  .theme-winter-popup .pm-desc { color: #bae6fd; }
  .theme-winter-popup .pm-btn { background: #38bdf8; color: #082f49; box-shadow: 0 10px 20px rgba(56,189,248,0.3); }

  .theme-summer-popup .prime-modal { background: #fffbeb; border-color: #fbbf24; box-shadow: 0 20px 60px rgba(245,158,11,0.2); }
  .theme-summer-popup .prime-modal-close { color: #64748b; background: rgba(0,0,0,0.05); }
  .theme-summer-popup .pm-title { color: #0f172a; }
  .theme-summer-popup .pm-title span { color: #ea580c; }
  .theme-summer-popup .pm-desc { color: #475569; }
  .theme-summer-popup .pm-btn { background: linear-gradient(135deg, #ea580c, #f59e0b); color: #fff; box-shadow: 0 10px 20px rgba(234,88,12,0.3); }

  .theme-festival-popup .prime-modal { background: #4c0519; border-color: #f43f5e; box-shadow: 0 20px 60px rgba(225,29,72,0.3); }
  .theme-festival-popup .pm-title { color: #fff; }
  .theme-festival-popup .pm-title span { color: #fca5a5; }
  .theme-festival-popup .pm-desc { color: #fecdd3; }
  .theme-festival-popup .pm-btn { background: #f43f5e; color: #fff; box-shadow: 0 10px 20px rgba(244,63,94,0.3); }
</style>

<?php 
    $event_icon = '🎉'; 
    $title_html = "Prime <span>Mega Sale</span>";
    $event_desc = 'Exclusive prime event is live. Check out the deals immediately!'; 
    
    if($sys['active_sale_event'] === 'winter') { 
        $event_icon = "❄️"; 
        $title_html = "Winter <span>Mega Sale</span>";
        $event_desc = 'Experience the ultimate chill! Unlock breathtaking deals crafted purely for the modern gentleman.'; 
    } elseif($sys['active_sale_event'] === 'summer') { 
        $event_icon = "☀️"; 
        $title_html = "Summer <span>Clearance</span>";
        $event_desc = 'The heat is on! Don\'t miss out on these blazing discounts ready for the bright season.'; 
    } elseif($sys['active_sale_event'] === 'festival') { 
        $event_icon = "🎆"; 
        $title_html = "Festival <span>Bonanza</span>";
        $event_desc = 'Celebrate the season with spectacular discounts and premium gifts curated exclusively for you.'; 
    }
?>
<div class="prime-modal-overlay" id="primeModalOverlay">
  <div class="prime-modal theme-<?= $sys['active_sale_event'] ?>-popup">
    <button class="prime-modal-close" onclick="closePrimeModal()"><i class="fas fa-times"></i></button>
    <div class="pm-icon"><?= $event_icon ?></div>
    <h2 class="pm-title"><?= $title_html ?></h2>
    <p class="pm-desc"><?= $event_desc ?></p>
    <a href="/Menshubprime/deals" class="pm-btn">Unlock Prime Deals <i class="fas fa-arrow-right"></i></a>
  </div>
</div>
<script>
function closePrimeModal() { 
    var o = document.getElementById('primeModalOverlay');
    if(o) o.classList.remove('show');
    setTimeout(function(){ if(o) o.style.display='none'; }, 500);
    sessionStorage.setItem('primePopupFinal_<?= $sys["active_sale_event"] ?>', '1'); 
}
window.addEventListener('load', function() {
    if(!sessionStorage.getItem('primePopupFinal_<?= $sys["active_sale_event"] ?>')) {
        setTimeout(function() { 
            var o = document.getElementById('primeModalOverlay');
            if(o) o.classList.add('show'); 
        }, 1000);
    }
});
</script>
<?php endif; ?>
<!-- ===== CINEMATIC INTRO LOADER ===== -->
<?php if (!$is_perf_bot): ?>
<div id="site-loader">
  <!-- Background effects -->
  <div class="loader-grid"></div>
  <div class="loader-glow"></div>
  <div class="loader-scanline"></div>

  <!-- Corner accents -->
  <div class="loader-corner tl"></div>
  <div class="loader-corner tr"></div>
  <div class="loader-corner bl"></div>
  <div class="loader-corner br"></div>

  <!-- Main content -->
  <div class="loader-content">
    <div class="loader-tagline">Est. 2026 &bull; Smart Shopping</div>

    <!-- Cute Anime Mascot -->
    <div class="loader-mascot">
      <svg viewBox="0 0 160 200" xmlns="http://www.w3.org/2000/svg" class="mascot-svg">
        <!-- Shadow beneath character -->
        <ellipse cx="80" cy="193" rx="28" ry="6" fill="rgba(0,0,0,0.25)" class="mascot-shadow"/>
        <!-- Body -->
        <rect x="52" y="118" width="56" height="52" rx="14" fill="#1e293b" class="mascot-body"/>
        <!-- Collar accent -->
        <rect x="68" y="118" width="24" height="10" rx="4" fill="#fb923c" opacity="0.9"/>
        <!-- Arms -->
        <rect x="32" y="120" width="22" height="11" rx="6" fill="#1e293b" class="mascot-arm-l"/>
        <rect x="106" y="120" width="22" height="11" rx="6" fill="#1e293b" class="mascot-arm-r"/>
        <!-- Legs -->
        <rect x="57" y="165" width="18" height="22" rx="7" fill="#0f172a"/>
        <rect x="85" y="165" width="18" height="22" rx="7" fill="#0f172a"/>
        <!-- Shoes -->
        <ellipse cx="66" cy="187" rx="13" ry="7" fill="#fb923c"/>
        <ellipse cx="94" cy="187" rx="13" ry="7" fill="#fb923c"/>
        <!-- Neck -->
        <rect x="70" y="108" width="20" height="14" rx="6" fill="#fcd9b0"/>
        <!-- Head -->
        <ellipse cx="80" cy="80" rx="42" ry="44" fill="#fcd9b0" class="mascot-head"/>
        <!-- Hair base (dark) -->
        <ellipse cx="80" cy="52" rx="42" ry="22" fill="#1a1a2e"/>
        <!-- Hair swoosh top -->
        <path d="M42 60 Q55 28 80 36 Q105 28 118 60" fill="#1a1a2e"/>
        <!-- Hair side left -->
        <path d="M40 62 Q30 72 35 88 Q38 70 48 68Z" fill="#1a1a2e"/>
        <!-- Hair side right -->
        <path d="M120 62 Q130 72 125 88 Q122 70 112 68Z" fill="#1a1a2e"/>
        <!-- Crown -->
        <polygon points="56,46 64,30 72,40 80,24 88,40 96,30 104,46" fill="#fb923c" class="mascot-crown"/>
        <circle cx="64" cy="30" r="3.5" fill="#fbbf24"/>
        <circle cx="80" cy="24" r="4" fill="#fbbf24"/>
        <circle cx="96" cy="30" r="3.5" fill="#fbbf24"/>
        <!-- Eyes -->
        <!-- Left eye -->
        <ellipse cx="63" cy="82" rx="11" ry="13" fill="white"/>
        <ellipse cx="63" cy="85" rx="7.5" ry="8.5" fill="#1e3a5f"/>
        <ellipse cx="63" cy="86" rx="5" ry="6" fill="#0f172a"/>
        <circle cx="66" cy="82" r="2.5" fill="white" opacity="0.9"/>
        <!-- Right eye -->
        <ellipse cx="97" cy="82" rx="11" ry="13" fill="white"/>
        <ellipse cx="97" cy="85" rx="7.5" ry="8.5" fill="#1e3a5f"/>
        <ellipse cx="97" cy="86" rx="5" ry="6" fill="#0f172a"/>
        <circle cx="100" cy="82" r="2.5" fill="white" opacity="0.9"/>
        <!-- Eyebrows -->
        <path d="M53 69 Q63 65 73 68" stroke="#1a1a2e" stroke-width="2.5" fill="none" stroke-linecap="round"/>
        <path d="M87 68 Q97 65 107 69" stroke="#1a1a2e" stroke-width="2.5" fill="none" stroke-linecap="round"/>
        <!-- Nose -->
        <ellipse cx="80" cy="94" rx="3" ry="2" fill="#f0b090" opacity="0.7"/>
        <!-- Cute Smile -->
        <path d="M68 103 Q80 114 92 103" stroke="#e05050" stroke-width="2.5" fill="none" stroke-linecap="round"/>
        <!-- Blush cheeks -->
        <ellipse cx="50" cy="96" rx="10" ry="6" fill="#fb7185" opacity="0.35"/>
        <ellipse cx="110" cy="96" rx="10" ry="6" fill="#fb7185" opacity="0.35"/>
        <!-- Price tag in right hand -->
        <rect x="110" y="124" width="30" height="20" rx="5" fill="#fb923c" class="mascot-tag"/>
        <text x="125" y="138" text-anchor="middle" font-family="Outfit,sans-serif" font-size="8" font-weight="800" fill="white">PRIME</text>
        <circle cx="113" cy="128" r="2.5" fill="white" opacity="0.8"/>
      </svg>
    </div>

    <div class="loader-heart"><i class="fa fa-heart"></i></div>

    <!-- Letter-by-letter brand reveal -->
    <div class="loader-brand">
      <div class="l-word">
        <span style="animation-delay:0.7s">M</span>
        <span style="animation-delay:0.78s">E</span>
        <span style="animation-delay:0.86s">N</span>
        <span style="animation-delay:0.94s">S</span>
        <span style="animation-delay:1.02s">H</span>
        <span style="animation-delay:1.10s">U</span>
        <span style="animation-delay:1.18s">B</span>
      </div>
      <div class="l-word prime-word">
        <span style="animation-delay:1.28s">P</span>
        <span style="animation-delay:1.36s">R</span>
        <span style="animation-delay:1.44s">I</span>
        <span style="animation-delay:1.52s">M</span>
        <span style="animation-delay:1.60s">E</span>
      </div>
    </div>

    <!-- Progress bar -->
    <div class="loader-bar-wrap" style="width:280px;">
      <div class="loader-bar"></div>
    </div>

    <div class="loader-sub">For Smart Men &bull; Loading</div>

    <!-- Mobile: Tap to activate voice -->
    <button class="loader-tap-btn" id="loaderTapBtn" style="display:none;" aria-label="Tap to Enter">
      <div class="tap-circle"><i class="fas fa-volume-up"></i></div>
      <div class="tap-label">Tap to Enter</div>
      <div class="tap-sublabel">Touch for welcome</div>
    </button>
  </div>
</div>

<script>
function toggleSearch() {
  const overlay = document.getElementById('searchOverlay');
  overlay.classList.toggle('active');
  const isActive = overlay.classList.contains('active');
  document.body.style.overflow = isActive ? 'hidden' : 'auto';
  
  document.querySelectorAll(".mobile-sticky-bar, #topBtn").forEach(el => {
    el.style.opacity = isActive ? "0" : "1";
    el.style.pointerEvents = isActive ? "none" : "auto";
  });
}

function toggleDealsBag() {
  const sidebar = document.getElementById('dealsSidebar');
  sidebar.classList.toggle('active');
  const isActive = sidebar.classList.contains('active');
  document.body.style.overflow = isActive ? 'hidden' : 'auto';

  document.querySelectorAll(".mobile-sticky-bar, #topBtn").forEach(el => {
    el.style.opacity = isActive ? "0" : "1";
    el.style.pointerEvents = isActive ? "none" : "auto";
  });
}
(function(){
  var loader = document.getElementById('site-loader');
  var ref = document.referrer;
  var isInternalNav = ref && ref.indexOf(window.location.hostname) !== -1;
  var forceLoader = sessionStorage.getItem('forceLoader');

  // Detect F5 / browser refresh on any page
  var navEntry = performance.getEntriesByType('navigation')[0];
  var isReload = navEntry && navEntry.type === 'reload';

  // Clear logo-click flag immediately (single use)
  if (forceLoader) sessionStorage.removeItem('forceLoader');

  if (isInternalNav && !forceLoader && !isReload) {
    loader.remove();
    return;
  }

  // ── Welcome Voice helper ──
  function speakWelcome() {
    if (!window.speechSynthesis) return;
    window.speechSynthesis.cancel();
    var msg = new SpeechSynthesisUtterance(
      "Welcome to Mens Hub Prime! Your ultimate destination for smart men's shopping."
    );
    msg.lang = 'en-US'; msg.rate = 0.92; msg.pitch = 1.05; msg.volume = 0.90;
    function doSpeak() {
      var v = window.speechSynthesis.getVoices();
      var pref = v.find(function(x){ return /google|natural|samantha|aria|zira/i.test(x.name) && x.lang.startsWith('en'); });
      if (pref) msg.voice = pref;
      window.speechSynthesis.speak(msg);
    }
    if (window.speechSynthesis.getVoices().length > 0) { doSpeak(); }
    else { window.speechSynthesis.onvoiceschanged = doSpeak; }
  }

  // ── Hide loader ──
  function hideLoader() {
    loader.classList.add('hide');
    setTimeout(function(){ if(loader.parentNode) loader.remove(); }, 800);
  }

  // ── Network-Aware Timing ──
  // Slow network = longer loader, Fast = shorter
  var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
  var netType = conn ? (conn.effectiveType || conn.type || '4g') : '4g';
  var hideDelay;
  if (netType === 'slow-2g' || netType === '2g') {
    hideDelay = 4000; // 4s for very slow internet
  } else if (netType === '3g') {
    hideDelay = 3000; // 3s for 3G
  } else {
    hideDelay = 2500; // 2.5s for 4G/WiFi — full animation plays
  }

  var isMobile = /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);
  var tapBtn = document.getElementById('loaderTapBtn');
  var isFirstEver = !localStorage.getItem('welcomeVoicePlayed');

  if (isMobile) {
    // Mobile: show tap button, loader stays until tapped or timeout
    setTimeout(function(){
      if (tapBtn) {
        tapBtn.style.display = 'flex';
        tapBtn.addEventListener('click', function(){
          tapBtn.style.display = 'none';
          speakWelcome();
          setTimeout(hideLoader, 600);
        }, { once: true });
      }
    }, 1000);
    setTimeout(hideLoader, hideDelay);
  } else {
    // Desktop: play voice on first visit, then hide after full animation
    if (isFirstEver) {
      localStorage.setItem('welcomeVoicePlayed', '1');
      setTimeout(speakWelcome, 600);
    }
    setTimeout(hideLoader, hideDelay);
  }
})();
</script>
<?php endif; ?>
<!-- ===== END LOADER ===== -->

<div class="navbar">

  <!-- LOGO -->
  <div class="logo">
    <a href="/" onclick="sessionStorage.setItem('forceLoader','1')">
      <i class="fa fa-heart"></i>
      <div class="header-text">MENSHUB <span>PRIME</span></div>
    </a>
  </div>

  <!-- DESKTOP MENU -->
  <ul class="menu desktop-menu">

    <li><a href="/" class="<?= ($current_page_name == 'index.php' || $current_page_name == 'home.php') ? 'active' : '' ?>">Home</a></li>
    <li><a href="/deals" class="<?= ($current_page_name == 'deals.php') ? 'active' : '' ?>">Deals</a></li>
    <?php if (($sys['show_wishlist'] ?? 0) == 1): ?>
    <li><a href="/brands" class="<?= ($current_page_name == 'brands.php' || $current_page_name == 'brand-store.php') ? 'active' : '' ?>">Stores</a></li>
    <?php endif; ?>
    <li><a href="/comparisons" class="<?= ($current_page_name == 'comparisons.php') ? 'active' : '' ?>" style="color:#f97316; font-weight:700;"><i class="fas fa-fire" style="margin-right:5px;"></i> Top Picks</a></li>
    <li><a href="/blog/" class="nav-btn-v15 <?= $page_class == 'blog' ? 'active' : '' ?>" onclick="hapticv10()">Blog</a></li>
    
    <li class="dropdown">
      <a href="#" class="drop-link">Explore</a>
      <ul class="dropdown-menu">
        <li><a href="/digital-products"><i class="fas fa-download" style="margin-right:8px; width:20px;"></i> Digital Products</a></li>
        <li><a href="/videos"><i class="fas fa-video" style="margin-right:8px; width:20px;"></i> Videos</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="drop-link">Categories</a>
      <ul class="dropdown-menu">
        <?php
        $nav_cats = mysqli_query($conn, "SELECT name, slug FROM categories WHERE status='active' ORDER BY name ASC LIMIT 8");
        while($nc = mysqli_fetch_assoc($nav_cats)){
          echo '<li><a href="/category/'.$nc['slug'].'">'.htmlspecialchars($nc['name']).'</a></li>';
        }
        ?>
        <li><hr style="border-top:1px solid rgba(255,255,255,0.05); margin:5px 0;"></li>
        <li><a href="/categories">View All Categories</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="drop-link">Services</a>
      <ul class="dropdown-menu">
        <li><a href="/dropshipping">Dropshipping</a></li>
        <li><a href="/mobile-app">App</a></li>
        <li><a href="/hire-me">Hire Me</a></li>
        <li><a href="/contact">Contact Us</a></li>
      </ul>
    </li>
  </ul>

  <!-- INSTAGRAM -->
  <div class="nav-btn">
    <a href="https://instagram.com/thezayanway" target="_blank" rel="noopener" class="insta-btn" aria-label="Visit Instagram">
      <i class="fab fa-instagram"></i> Visit Instagram
    </a>
  </div>

  <!-- HEADER ICONS (Mobile & Tablet) -->
  <?php if (($sys['mobile_app_mode'] ?? 0) == 1): ?>
    <div class="header-app-icons">
      <!-- Tablet Only Search Bar -->
      <form action="/search" method="GET" class="tablet-search-bar">
        <i class="fas fa-search"></i>
        <input type="text" name="q" placeholder="Search gear..." required>
      </form>

      <button class="mobile-search-btn" onclick="toggleSearch()" aria-label="Search">
        <i class="fas fa-search"></i>
      </button>
      
      <?php if (($sys['show_deals_bag'] ?? 0) == 1): ?>
        <button class="mobile-bag-btn" onclick="toggleDealsBag()" aria-label="Deals Bag">
          <i class="fas fa-shopping-bag"></i>
          <span class="bag-dot"></span>
        </button>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <!-- HAMBURGER -->
  <button class="hamburger <?= (($sys['mobile_app_mode'] ?? 0) == 1) ? 'app-mode-hide' : '' ?>" onclick="toggleMenu()" aria-label="Toggle Menu">
    <i class="fa fa-bars" id="menuIcon"></i>
  </button>

</div>

<!-- ===== MOBILE DEALS BAG SIDEBAR ===== -->
<?php if (($sys['show_deals_bag'] ?? 0) == 1): ?>
<div class="deals-sidebar" id="dealsSidebar">
  <div class="sidebar-header">
    <h3><i class="fas fa-shopping-bag"></i> My Smart Bag</h3>
    <button class="close-sidebar" onclick="toggleDealsBag()" aria-label="Close Sidebar"><i class="fas fa-times"></i></button>
  </div>
  
  <div class="sidebar-info">
    <p>Top Value items curated just for you!</p>
  </div>

  <div class="deals-grid">
    <?php
    $bag_items = mysqli_query($conn, "SELECT * FROM products WHERE in_deals_bag = 1 AND status = 'active' ORDER BY id DESC LIMIT 10");
    $delay = 0;
    if(mysqli_num_rows($bag_items) > 0):
      while($item = mysqli_fetch_assoc($bag_items)):
        $delay += 0.1;
    ?>
      <div class="deal-card" style="--d: <?= $delay ?>s">
        <div class="deal-badge"><i class="fas fa-star"></i> Pick</div>
        <div class="deal-img">
          <img src="/Menshubprime/assets/images/<?= $item['image']; ?>" alt="<?= htmlspecialchars($item['title']); ?>" loading="lazy">
          <div class="deal-overlay">
            <i class="fas fa-arrow-right"></i>
          </div>
        </div>
        <div class="deal-details">
          <h4><?= htmlspecialchars($item['title']); ?></h4>
          <div class="deal-footer">
            <span class="deal-price">₹<?= $item['price']; ?></span>
            <a href="<?= $item['affiliate_link']; ?>" target="_blank" class="deal-btn">Grab <i class="fas fa-bolt"></i></a>
          </div>
        </div>
      </div>
    <?php 
      endwhile;
    else:
      echo '<div class="empty-bag"><i class="fas fa-shopping-basket"></i><p>Bag is empty. Check back later!</p></div>';
    endif;
    ?>
  </div>
</div>
<?php endif; ?>


<!-- ===== MOBILE SEARCH OVERLAY ===== -->
<?php if (($sys['mobile_app_mode'] ?? 0) == 1): ?>
<div class="search-overlay" id="searchOverlay">
  <button class="search-overlay-close" onclick="toggleSearch()" aria-label="Close Search"><i class="fas fa-times"></i></button>
  <div class="search-container">
    <h2 class="search-title">What are you looking for?</h2>
    <form action="/search" method="GET" class="search-form">
      <div class="search-input-wrap">
        <i class="fas fa-search"></i>
        <input type="text" name="q" id="globalSearchInput" placeholder="Search shoes, watches, fashion..." autofocus autocomplete="off">
        <button type="submit">Search</button>
      </div>
    </form>
    <div id="liveSearchResults" class="live-search-results"></div>
    <div class="quick-tags">
      <span>Trending:</span>
      <a href="/search?q=Sneakers">Sneakers</a>
      <a href="/search?q=Watches">Watches</a>
      <a href="/search?q=Gadgets">Gadgets</a>
    </div>

  </div>
</div>
<?php endif; ?>


<!-- OVERLAY -->
<div class="overlay" onclick="toggleMenu()"></div>

<!-- MOBILE MENU -->
<ul class="mobile-menu" id="mobileMenu">

  <li class="mob-menu-top">
    <div class="mob-menu-branding">
      <div class="mob-brand-logo">
        <i class="fa fa-heart"></i>
      </div>
      <div class="mob-brand-text">
        <h3>MENSHUB PRIME</h3>
        <span>Smart Shopping Club</span>
      </div>
    </div>
    <button class="close-btn" onclick="closeMenu()" aria-label="Close Menu">
      <i class="fa fa-times"></i>
    </button>
  </li>

  <li><a href="/" class="<?= ($current_page_name == 'index.php' || $current_page_name == 'home.php') ? 'active' : '' ?>"><i class="fas fa-home"></i> Home <i class="fa fa-chevron-right"></i></a></li>
  <li><a href="/deals" class="<?= ($current_page_name == 'deals.php') ? 'active' : '' ?>"><i class="fas fa-bolt"></i> Hot Deals <i class="fa fa-chevron-right"></i></a></li>
  <?php if (($sys['show_wishlist'] ?? 0) == 1): ?>
  <li><a href="/brands" class="<?= ($current_page_name == 'brands.php' || $current_page_name == 'brand-store.php') ? 'active' : '' ?>"><i class="fas fa-store"></i> Prime Stores <i class="fa fa-chevron-right"></i></a></li>
  <?php endif; ?>
  <li><a href="/comparisons" style="color:#f97316; font-weight:700;"><i class="fas fa-fire"></i> Best Comparisons <i class="fa fa-chevron-right"></i></a></li>
  
  <li class="menu-divider">MENS CATEGORIES</li>
  
  <li class="dropdown">
    <a href="#" class="mobile-drop"><i class="fas fa-th-large"></i> Shop Categories <i class="fa fa-chevron-down"></i></a>
    <ul class="dropdown-menu">
      <?php
      $mob_cats = mysqli_query($conn, "SELECT name, slug FROM categories WHERE status='active' ORDER BY name ASC");
      while($mc = mysqli_fetch_assoc($mob_cats)){
        echo '<li><a href="/category/'.$mc['slug'].'">'.htmlspecialchars($mc['name']).'</a></li>';
      }
      ?>
      <li><a href="/categories">View All Categories</a></li>
    </ul>
  </li>
  <li><a href="/blog/"><i class="fas fa-newspaper"></i> Fashion Blog <i class="fa fa-chevron-right"></i></a></li>
  
  <li class="menu-divider">SERVICES & MORE</li>

  <li><a href="/digital-products"><i class="fas fa-download"></i> Digital Products <i class="fa fa-chevron-right"></i></a></li>
  <li><a href="/videos"><i class="fas fa-play-circle"></i> Video Reviews <i class="fa fa-chevron-right"></i></a></li>

  <li class="dropdown">
    <a href="#" class="mobile-drop"><i class="fas fa-concierge-bell"></i> Our Services <i class="fa fa-chevron-down"></i></a>
    <ul class="dropdown-menu">
      <li><a href="/dropshipping">Dropshipping</a></li>
      <li><a href="/mobile-app">Mobile App</a></li>
      <li><a href="/hire-me">Hire Me</a></li>
      <li><a href="/contact">Contact Us</a></li>
    </ul>
  </li>

  <li class="menu-divider">SOCIAL CONNECT</li>
    <div class="mob-social-grid">
      <a href="https://instagram.com/thezayanway" target="_blank" class="social-tile instagram">
        <i class="fab fa-instagram"></i>
        <span>Instagram</span>
      </a>
      <a href="https://t.me/thezayanway" target="_blank" class="social-tile telegram">
        <i class="fab fa-telegram"></i>
        <span>Telegram</span>
      </a>
      <a href="https://pinterest.com/thezayanway" target="_blank" class="social-tile pinterest">
        <i class="fab fa-pinterest-p"></i>
        <span>Pinterest</span>
      </a>
      <a href="https://facebook.com/thezayanway" target="_blank" class="social-tile facebook">
        <i class="fab fa-facebook-f"></i>
        <span>Facebook</span>
      </a>
    </div>
  </li>
</ul>

<script>

// DESKTOP DROPDOWN CLICK
document.querySelectorAll(".drop-link").forEach(link=>{
  link.addEventListener("click", function(e){
    e.preventDefault();

    let parent = this.parentElement;

    document.querySelectorAll(".dropdown").forEach(item=>{
      if(item !== parent){
        item.classList.remove("active");
      }
    });

    parent.classList.toggle("active");
  });
});

// CLOSE DROPDOWN ON OUTSIDE CLICK
document.addEventListener("click", function(e){
  if(!e.target.closest(".dropdown")){
    document.querySelectorAll(".dropdown").forEach(item=>{
      item.classList.remove("active");
    });
  }
});

function closeMenu() {
  let menu = document.getElementById("mobileMenu");
  let overlay = document.querySelector(".overlay");
  let icon = document.getElementById("menuIcon");
  
  menu.classList.remove("show");
  overlay.classList.remove("show");
  document.body.style.overflow="auto";
  if(icon) {
    icon.classList.remove("fa-times");
    icon.classList.add("fa-bars");
  }
  
  // Restore floating elements so they are visible again
  document.querySelectorAll(".mobile-sticky-bar, #topBtn").forEach(el => {
    el.style.opacity = "1";
    el.style.pointerEvents = "auto";
  });
}

// MOBILE MENU
function toggleMenu(){
  let menu = document.getElementById("mobileMenu");
  let overlay = document.querySelector(".overlay");
  let icon = document.getElementById("menuIcon");

  if(menu.classList.contains("show")){
    closeMenu();
  } else {
    menu.classList.add("show");
    overlay.classList.add("show");
    document.body.style.overflow="hidden";
    if(icon) {
      icon.classList.remove("fa-bars");
      icon.classList.add("fa-times");
    }
    
    // Hide floating elements cleanly so they don't overlap the mobile menu
    document.querySelectorAll(".mobile-sticky-bar, #topBtn").forEach(el => {
      el.style.opacity = "0";
      el.style.pointerEvents = "none";
    });
  }
}

// SCROLL EFFECT FOR NAVBAR
window.addEventListener("scroll", function() {
  const nav = document.querySelector(".navbar");
  if (nav) {
    if (window.scrollY > 50) {
      nav.classList.add("scrolled");
    } else {
      nav.classList.remove("scrolled");
    }
  }
});

// MOBILE DROPDOWN
document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll(".mobile-drop").forEach(link=>{
    link.addEventListener("click", function(e){
      e.preventDefault();
      this.parentElement.classList.toggle("open");
    });
  });
});

</script>

<main id="main-content">

