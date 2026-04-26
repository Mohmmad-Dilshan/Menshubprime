<?php
// bootstrap removed
if (isset($_GET['slug'])) {
    $slug = mysqli_real_escape_string($conn, $_GET['slug']);
    $q = mysqli_query($conn, "SELECT * FROM products WHERE slug='$slug' AND (status='active' OR status='1')");
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $q = mysqli_query($conn, "SELECT * FROM products WHERE id=$id AND (status='active' OR status='1')");
} else {
    header("Location: /");
    exit();
}

if(mysqli_num_rows($q)==0){
    header("Location: /");
    exit();
}

$row = mysqli_fetch_assoc($q);
$id = $row['id'];
$product_category = $row['category'];

if (isset($_GET['id']) && !isset($_GET['slug'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /product/" . $row['slug']);
    exit();
}

$productURL = "https://" . $_SERVER['HTTP_HOST'] . "/product/" . $row['slug'];

// Set SEO Variables
$page_title = $row['title'] . " | MenHub Prime Products | Thezayanway";
$page_description = "Buy " . $row['title'] . " at best price ₹" . $row['price'] . ". Best deals for smart men.";
$og_image = "https://" . $_SERVER['HTTP_HOST'] . "/assets/images/" . $row['image'];
$og_type = "product";

include ROOT_PATH . '/includes/header.php';

echo '<link rel="canonical" href="' . $productURL . '" />';
?>




<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

<style>
/* === SCOPED HIGH-FIDELITY DESIGN SYSTEM === */
.zn-product-container {
  --p-accent: #2563eb;
  --p-accent-dark: #1e40af;
  --p-success: #10b981;
  --p-text: #0f172a;
  --p-text-light: #64748b;
  --p-bg: #ffffff;
  --p-bg-alt: #f8fafc;
  --p-border: #f1f5f9;
  --p-radius-lg: 24px;
  --p-radius-md: 16px;
  --p-shadow: 0 10px 30px rgba(0,0,0,0.05);
  --p-glass: rgba(255, 255, 255, 0.8);
  
  /* Fluid Scaling */
  --f-pad: clamp(16px, 4vw, 32px);
  --f-h1: clamp(22px, 5vw, 36px);
  --f-price: clamp(24px, 5vw, 38px);

  font-family: 'Outfit', sans-serif;
  color: var(--p-text);
  line-height: 1.6;
}

.zn-product-container * { box-sizing: border-box; }

/* 1. Main Wrapper & Layout */
.product-wrap {
  max-width: 1180px;
  margin: clamp(20px, 5vw, 60px) auto;
  background: var(--p-bg);
  border-radius: var(--p-radius-lg);
  box-shadow: var(--p-shadow);
  padding: var(--f-pad);
  overflow: hidden;
  animation: fadeIn 0.8s ease-out;
}

.product-flex {
  display: flex;
  flex-direction: column;
  gap: clamp(20px, 5vw, 50px);
}

@media (min-width: 992px) {
  .product-flex { flex-direction: row; align-items: flex-start; }
  .product-img { flex: 0 0 45%; position: sticky; top: 100px; }
  .product-info { flex: 1; text-align: left; }
}

/* 2. Visual Elements (Image & Badges) */
.product-img {
  width: 100%;
  max-width: 500px;
  margin: 0 auto;
  position: relative;
}

.product-img img {
  width: 100%;
  height: auto;
  border-radius: var(--p-radius-md);
  display: block;
  transition: transform 0.5s ease;
}

.product-img:hover img { transform: scale(1.03); }

.wishlist, .stock-badge, .rating-badge {
  position: absolute;
  padding: 6px 12px;
  border-radius: 50px;
  font-size: 12px;
  font-weight: 700;
  z-index: 10;
  backdrop-filter: blur(8px);
}

.wishlist { top: -26px; left: 15px; background: rgba(255,255,255,0.9); cursor: pointer; font-size: 16px; padding: 8px; }
.stock-badge { top: -20px; right: 15px; background: rgba(239, 68, 68, 0.9); color: #fff; }
.rating-badge { bottom: 70px; right: 15px; background: rgba(252, 211, 77, 0.9); color: #1e293b; }

/* 3. Typography & Pricing */
.product-title {
  font-size: var(--f-h1);
  font-weight: 800;
  letter-spacing: -0.02em;
  margin-bottom: 12px;
  line-height: 1.2;
}

.price-row strong {
  font-size: var(--f-price);
  color: var(--p-success);
  font-weight: 800;
  display: block;
  margin-bottom: 20px;
}

/* 4. Comparison Cards */
.comparison-box { margin: 30px 0; }
.comparison-box h3 { font-size: 16px; font-weight: 700; color: var(--p-text-light); margin-bottom: 15px; display: flex; align-items: center; gap: 8px; }

.comp-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 20px;
  background: var(--p-bg-alt);
  border: 1px solid var(--p-border);
  border-radius: var(--p-radius-md);
  margin-bottom: 16px;
  transition: all 0.3s ease;
  cursor: pointer;
  gap: 10px;
}

.comp-row:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.05); border-color: var(--p-accent); }

.brand-col { display: flex; align-items: center; gap: 12px; flex: 1; }
.brand-icon { width: 32px; height: 32px; object-fit: contain; }
.brand-name { font-weight: 700; font-size: 15px; color: var(--p-text); }
.price-col { font-weight: 800; color: var(--p-success); font-size: clamp(16px, 4vw, 20px); white-space: nowrap; }

.comp-row.best-deal { background: #f0fdf4; border-color: #86efac; border-width: 2px; }

.visit-col {
  background: var(--p-accent);
  color: #fff;
  padding: 8px 16px;
  border-radius: 50px;
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  white-space: nowrap;
}

/* 5. Buttons & CTAs */
.buy-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 16px 32px;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 700;
  font-size: 16px;
  transition: 0.3s;
  border: none;
  cursor: pointer;
}

.primary-btn { background: #0f172a; color: #fff; }
.secondary-btn { background: #f1f5f9; color: var(--p-text); margin-top: 12px; width: 100%; border: 1px solid var(--p-border); }
a.buy-btn.secondary-btn {
  margin-left: auto;
}
.primary-btn:hover { background: var(--p-accent); transform: translateY(-2px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); }

/* 6. Sticky Action Bar (Global Fixed) */
.mobile-sticky-bar {
  display: none;
  position: fixed;
  bottom: <?= (($sys['mobile_app_mode'] ?? 0) == 1) ? '105px' : '25px'; ?>;
  left: 20px;
  right: 20px;
  background: rgba(15, 23, 42, 0.95);
  backdrop-filter: blur(25px) saturate(180%);
  -webkit-backdrop-filter: blur(25px) saturate(180%);
  padding: 12px 12px 12px 25px;
  border-radius: 100px;
  box-shadow: 0 20px 50px rgba(0,0,0,0.5), inset 0 0 0 1px rgba(255,255,255,0.1);
  z-index: 2000;
  align-items: center;
  justify-content: space-between;
  opacity: 0;
  transform: translateY(50px) scale(0.95);
  transition: all 0.6s cubic-bezier(0.19, 1, 0.22, 1);
  pointer-events: none;
}

.mobile-sticky-bar.show-sticky {
  opacity: 1;
  transform: translateY(0) scale(1);
  pointer-events: auto;
}

.sticky-btn {
  background: linear-gradient(135deg, #fb923c, #f97316) !important;
  color: #000 !important;
  padding: 14px 28px !important;
  font-size: 14px !important;
  margin: 0 !important;
  font-weight: 900 !important;
  box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
  animation: stickyPulse 2s infinite;
}

@keyframes stickyPulse {
  0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.5); }
  70% { box-shadow: 0 0 0 12px rgba(249, 115, 22, 0); }
  100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
}

@media (max-width: 768px) {
  <?php if (($sys['mobile_app_mode'] ?? 0) == 1): ?>
  .mobile-sticky-bar { display: flex; }
  .zn-product-container { padding-bottom: 30px; }
  <?php else: ?>
  .zn-product-container { padding-bottom: 30px; }
  <?php endif; ?>
  .product-wrap { margin: 0; border-radius: 0; padding: 25px 16px; }


  
  .comp-row { padding: 12px 14px; }
  .visit-col { padding: 6px 12px; font-size: 10px; }
  .brand-name { font-size: 13px; }
}

/* Media Gallery Styles */
.thumb-gallery {
  display: flex;
  gap: 10px;
  margin-top: 15px;
  overflow-x: auto;
  padding-bottom: 5px;
}
.thumb {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  border: 2px solid transparent;
  cursor: pointer;
  overflow: hidden;
  flex-shrink: 0;
  transition: 0.3s;
  background: var(--p-bg-alt);
  display: flex;
  align-items: center;
  justify-content: center;
}
.thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.thumb.active {
  border-color: var(--p-accent);
}
.thumb.vid-thumb {
  font-size: 24px;
  color: var(--p-accent);
}
.media-showcase-box {
  min-height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #000;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 30px 60px rgba(0,0,0,0.4);
  border: 1px solid rgba(255,255,255,0.1);
  position: relative;
  transition: 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
}
.media-showcase-box:hover {
  transform: scale(1.01);
  border-color: rgba(255,255,255,0.2);
}
#mainMedia {
  width: 100%;
  height: auto;
  max-height: 600px;
  border-radius: 20px;
  display: block;
  object-fit: contain;
}
iframe#mainMedia {
  aspect-ratio: 16/9;
  height: 100%;
  border: none;
}
/* Instagram Embed Fix */
.ig-embed-wrap { width: 100%; height: 500px; display: flex; align-items: center; justify-content: center; background: #000; }


.sticky-info { display: flex; flex-direction: column; }
.sticky-info span { font-size: 10px; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
.sticky-info strong { color: #fff; font-size: 19px; font-weight: 900; }

/* 7. Additional Sections (Related, Sponsors, Mini) */
.section-title { 
  text-align: center; 
  margin: clamp(30px, 8vw, 60px) 0 30px; 
  font-weight: 800; 
  font-size: clamp(20px, 5vw, 28px); 
  color: #ffffff; 
  text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

/* ====== HANDPICKED: AUTO-SLIDER (2-up desktop, 1-up mobile) ====== */
.hp-slider-wrap {
  position: relative;
  overflow: hidden;
  border-radius: 20px;
}
.hp-slider-track {
  display: flex;
  gap: 14px;
  transition: transform 0.5s cubic-bezier(0.16,1,0.3,1);
  will-change: transform;
}

/* Desktop: each slide = 50% of container minus half gap */
.hp-slide {
  flex: 0 0 calc(50% - 12px);
  min-width: 0;
  display: flex;
  align-items: center;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 18px;
  overflow: hidden;
  text-decoration: none;
  color: #fff !important;
  transition: border-color 0.3s, box-shadow 0.3s;
  cursor: pointer;
  min-height: 100px;
  box-sizing: border-box;
}
.hp-slide:hover { border-color: var(--orange); box-shadow: 0 10px 30px rgba(0,0,0,0.4); }

.hp-slide img {
  width: 85px; min-width: 85px; height: 85px;
  object-fit: cover; display: block; flex-shrink: 0;
  border-radius: 12px; margin-left: 10px;
}

.hp-slide-body {
  padding: 12px 14px;
  flex: 1; overflow: hidden;
  display: flex; flex-direction: column; justify-content: center;
}
.hp-slide-body h3 {
  font-size: 13px; font-weight: 900;
  color: #ffffff !important;
  margin: 0 0 8px;
  overflow: hidden;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  line-height: 1.3;
}
.hp-price-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  flex-wrap: nowrap;
}
.hp-slide-body p {
  color: #f97316 !important;
  font-weight: 900; font-size: 16px;
  margin: 0; letter-spacing: -0.5px;
  white-space: nowrap;
}
.hp-slide-btn {
  display: inline-block;
  background: #f97316;
  color: #000 !important;
  font-size: 10px; font-weight: 900;
  text-transform: uppercase; letter-spacing: 1px;
  padding: 6px 12px; border-radius: 7px;
  white-space: nowrap; flex-shrink: 0;
}

/* Dots */
.hp-dots { display: flex; justify-content: center; gap: 6px; margin-top: 12px; }
.hp-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.2); transition: 0.3s; cursor: pointer; }
.hp-dot.active { background: var(--orange); width: 18px; border-radius: 3px; }

/* Mobile: 1 card full width */
@media (max-width: 768px) {
  .hp-slide { flex: 0 0 100%; }
  .hp-slider-track { gap: 0; }
  .hp-slide img { width: 85px; min-width: 85px; height: 85px; margin-left: 10px; border-radius: 12px; object-fit: cover; }
  .hp-slide-body { padding: 10px; }
  .hp-slide-body h3 { font-size: 13px; margin-bottom: 5px; }
  .hp-slide-body p { font-size: 15px; }
}

/* mini-grid (Popular Now) - compact portrait cards */
.mini-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
}
@media (max-width: 900px) { .mini-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } }

.mini-card {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 14px;
  overflow: hidden;
  text-decoration: none;
  color: #fff;
  display: block;
  cursor: pointer;
  transition: 0.35s cubic-bezier(0.16,1,0.3,1);
  position: relative;
}
.mini-card:hover {
  transform: translateY(-4px);
  border-color: var(--orange);
  box-shadow: 0 12px 28px rgba(0,0,0,0.4);
}
.mini-card-img {
  width: 100%;
  height: 200px;
  position: relative;
  overflow: hidden;
}
@media (max-width: 900px) { .mini-card-img { height: 110px; } }

.mini-card-img img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: 0.5s;
}
.mini-card:hover .mini-card-img img { transform: scale(1.06); }

.mini-fire {
  position: absolute; top: 7px; left: 7px;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(6px);
  width: 24px; height: 24px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px;
}
.mini-price-badge {
  position: absolute; bottom: 7px; right: 7px;
  background: var(--orange); color: #000;
  font-size: 11px; font-weight: 900;
  padding: 3px 8px; border-radius: 6px;
}
.mini-card-body { padding: 9px 10px 10px; }
.mini-card-body h3 {
  font-size: 11px; font-weight: 800;
  color: #fff !important; margin: 0 0 7px;
  overflow: hidden; display: -webkit-box;
  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  line-height: 1.3; height: 28px;
}
.mini-buy-btn {
  display: block;
  background: rgba(249,115,22,0.1);
  border: 1px solid rgba(249,115,22,0.3);
  color: #f97316 !important;
  text-align: center;
  font-size: 10px; font-weight: 900;
  text-transform: uppercase; letter-spacing: 0.8px;
  padding: 6px; border-radius: 8px;
  text-decoration: none; transition: 0.25s;
}
.mini-buy-btn:hover { background: var(--orange); color: #000 !important; }


/* Sponsor Specifics */
.sponsor-section { padding: 40px 0; }
.sponsor-track { display: flex; gap: 20px; overflow-x: auto; padding: 10px 0; scroll-snap-type: x mandatory; }
.sponsor-card { flex: 0 0 300px; scroll-snap-align: start; }
@media (max-width: 768px) { .sponsor-card { flex: 0 0 85%; } }

/* Global Utilities */
.share-box { 
  margin-top: 40px; 
  padding: 30px 20px; 
  background: var(--p-bg-alt); 
  border-radius: var(--p-radius-md);
  border: 1px solid var(--p-border);
}
.share-btn { 
  display: inline-flex; 
  align-items: center; 
  padding: 12px 24px; 
  border-radius: 50px; 
  color: #fff; 
  text-decoration: none; 
  font-size: 14px; 
  font-weight: 700; 
  margin: 6px; 
  border: none; 
  cursor: pointer; 
  transition: 0.3s;
}
.share-btn i { margin-right: 8px; }
@media (max-width: 600px) {
  .share-box { display: flex; flex-direction: column; gap: 10px; padding: 20px; text-align: center; }
  .share-btn { width: 100%; margin: 0; justify-content: center; padding: 14px; }
}
.whatsapp { background: #22c55e; }
.copy { background: #0f172a; }
.back { display: block; margin-top: 25px; color: var(--p-text-light); text-decoration: none; font-weight: 700; font-size: 14px; text-align: center; }
.seo-link { color: var(--p-accent); font-weight: 700; }
.redirect-info { margin-top: 25px; padding: 20px; background: var(--p-bg-alt); border-radius: 12px; font-size: 13px; color: var(--p-text-light); }
.affiliate-disclosure { margin-top: 30px; padding: 20px; border-top: 1px solid var(--p-border); font-size: 12px; color: var(--p-text-light); line-height: 1.6; }

@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { transform: translateY(100px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
/* FAQ Visibility */
.desktop-only-faq { display: block; }
.mobile-only-faq-v2 { display: none; }

@media (max-width: 992px) {
  .desktop-only-faq { display: none; }
  .mobile-only-faq-v2 { display: block; }
}

/* Redesign Spacing Overrides for Product Page */
.zn-product-container .telegram-wrap {
  padding: 20px 0 !important;
  margin-top: 0;
}
.zn-product-container .telegram-box {
  margin-bottom: 0 !important;
}

@media (max-width: 768px) {
  .related-section, .sponsor-section, .popular-section, .rc-section-wrap {
    margin: 10px auto !important;
    padding-top: 10px !important;
    padding-bottom: 10px !important;
  }
  .zn-product-container .section-title {
    margin-top: 20px !important;
    margin-bottom: 15px !important;
  }
  .zn-product-container .telegram-wrap {
    padding: 10px 0 !important;
  }
}
</style>

<div class="zn-product-container">

<div class="product-wrap">
  <div class="product-flex">
    <!-- IMAGE SECTION -->
    <div class="product-img">
      <div style="position: relative;">
        <span class="wishlist" onclick="this.innerHTML='💖'">❤️</span>
        <span class="stock-badge">⚡ Limited Stock</span>
      
      <div id="mainMediaContainer" class="media-showcase-box">
        <?php if(!empty($row['image']) && $row['image'] !== ''): ?>
          <img id="mainMedia" src="/Menshubprime/assets/images/<?php echo $row['image']; ?>" alt="<?= htmlspecialchars($row['title']); ?>">
        <?php elseif(!empty($row['video_file'])): ?>
          <video id="mainMedia" src="/Menshubprime/assets/images/<?= $row['video_file']; ?>" controls autoplay muted playsinline></video>
        <?php elseif(!empty($row['video_url_mockup'])): ?>
          <?php 
            $v_url = $row['video_url_mockup'];
            if(strpos($v_url, 'youtube.com') !== false || strpos($v_url, 'youtu.be') !== false) {
                // YouTube & Shorts detection
                if(strpos($v_url, 'shorts/') !== false) {
                    $parts = explode('shorts/', $v_url);
                    $vidId = strtok(end($parts), '?');
                } elseif(strpos($v_url, 'v=') !== false) {
                  parse_str(parse_url($v_url, PHP_URL_QUERY), $urlVars);
                  $vidId = $urlVars['v'];
                } else {
                  $vidId = basename(parse_url($v_url, PHP_URL_PATH));
                }
                echo '<iframe id="mainMedia" src="https://www.youtube.com/embed/'.$vidId.'?autoplay=1&muted=1" frameborder="0" allowfullscreen></iframe>';
            } elseif(strpos($v_url, 'instagram.com') !== false) {
                $clean_url = strtok($v_url, '?');
                $parts = explode('/', rtrim($clean_url, '/'));
                $igCode = end($parts);
                echo '<iframe id="mainMedia" src="https://www.instagram.com/reel/'.$igCode.'/embed" frameborder="0" scrolling="no" allowtransparency="true" style="height:500px;"></iframe>';
            } elseif(preg_match('/\.(mp4|webm|ogg)$/i', $v_url)) {
                echo '<video id="mainMedia" src="'.$v_url.'" controls autoplay muted playsinline></video>';
            } else {
                echo '<iframe id="mainMedia" src="'.$v_url.'" frameborder="0" allowfullscreen style="min-height:400px;"></iframe>';
            }
          ?>
        <?php else: ?>
           <div style="color:#fff; padding:40px; text-align:center;">
             <i class="fas fa-image-slash fa-3x" style="opacity:0.2; margin-bottom:15px; display:block;"></i>
             No Media Available
           </div>
        <?php endif; ?>
      </div>

      <!-- Thumbnail Gallery -->
      <div class="thumb-gallery">
        <div class="thumb active" onclick="switchMedia('img', '/Menshubprime/assets/images/<?= $row['image']; ?>', this)">
          <img src="/Menshubprime/assets/images/<?= $row['image']; ?>">
        </div>
        <?php for($i=2; $i<=5; $i++): $imgKey = "image$i"; if(!empty($row[$imgKey])): ?>
          <div class="thumb" onclick="switchMedia('img', '/Menshubprime/assets/images/<?= $row[$imgKey]; ?>', this)">
            <img src="/Menshubprime/assets/images/<?= $row[$imgKey]; ?>">
          </div>
        <?php endif; endfor; ?>
        
        <?php 
        // Show mockup video thumbnail if file is missing but URL is present
        if(!empty($row['video_file'])): ?>
          <div class="thumb vid-thumb" onclick="switchMedia('video', '/Menshubprime/assets/images/<?= $row['video_file']; ?>', this)">
            <i class="fas fa-play-circle" title="Play Video File"></i>
          </div>
        <?php elseif(!empty($row['video_url_mockup'])): ?>
          <div class="thumb vid-thumb" onclick="switchMedia('link', '<?= $row['video_url_mockup']; ?>', this)">
            <i class="fab fa-instagram" title="Watch Mockup/Reel"></i>
          </div>
        <?php endif; ?>
      </div>

        <span class="rating-badge">⭐ 4.8 (120+ Reviews)</span>
      </div>
      
      <!-- FAQ for Desktop Sidebar (Hidden on Mobile) -->
      <div class="seo-faq-container desktop-only-faq" style="margin-top:30px; padding:20px; background:var(--p-bg-alt); border-radius:var(--p-radius-md); border:1px solid var(--p-border);">
        <h2 style="font-size:18px; margin-bottom:15px; color:var(--p-text);">Product Overview & FAQ</h2>
        <div class="seo-faq-item">
          <p style="color:var(--p-text);"><strong>Is this product currently on sale?</strong></p>
          <p style="color:var(--p-text-light); font-size:13px;">We track prices across Amazon, Flipkart, and Myntra daily to ensure you get the absolute best deal.</p>
        </div>
      </div>
    </div>

    <!-- INFO SECTION -->
    <div class="product-info">
      <h1 class="product-title"><?= $row['title']; ?></h1>
      
      <?php if(!empty($row['description'])): ?>
      <div class="product-description" style="margin-bottom:20px; color:var(--p-text-light); font-size:15px; line-height:1.6;">
        <?= nl2br(htmlspecialchars($row['description'])); ?>
      </div>
      <?php endif; ?>

      <div class="price-row">
        <strong>₹<?= number_format($row['price']); ?></strong>
      </div>

      <!-- Comparison Section -->
      <div class="comparison-box">
        <h3><i class="fas fa-search-plus"></i> Live Price Comparison</h3>
        
        <div class="comp-row best-deal" onclick="window.open('<?= (!empty($row['affiliate_link'])) ? htmlspecialchars($row['affiliate_link']) : '#'; ?>', '_blank')">
          <div class="brand-col">
            <img src="/Menshubprime/assets/images/amazon.png?v=1.3" class="brand-icon" alt="Amazon">
            <span class="brand-name">Amazon</span>
          </div>
          <div class="price-col">₹<?= number_format($row['price']); ?></div>
          <div class="visit-col">View Deal</div>
        </div>

        <?php if(!empty($row['flipkart_price'])): ?>
        <div class="comp-row" onclick="window.open('<?= (!empty($row['flipkart_link'])) ? htmlspecialchars($row['flipkart_link']) : htmlspecialchars($row['affiliate_link']); ?>', '_blank')">
          <div class="brand-col">
            <img src="/Menshubprime/assets/images/flipkart.png?v=1.3" class="brand-icon" alt="Flipkart">
            <span class="brand-name">Flipkart</span>
          </div>
          <div class="price-col">₹<?= number_format($row['flipkart_price']); ?></div>
          <div class="visit-col">View Deal</div>
        </div>
        <?php endif; ?>

        <?php if(!empty($row['myntra_price'])): ?>
        <div class="comp-row" onclick="window.open('<?= (!empty($row['myntra_link'])) ? htmlspecialchars($row['myntra_link']) : htmlspecialchars($row['affiliate_link']); ?>', '_blank')">
          <div class="brand-col">
            <img src="/Menshubprime/assets/images/myntra.png?v=1.3" class="brand-icon" alt="Myntra">
            <span class="brand-name">Myntra</span>
          </div>
          <div class="price-col">₹<?= number_format($row['myntra_price']); ?></div>
          <div class="visit-col">View Deal</div>
        </div>
        <?php endif; ?>

        <?php if(!empty($row['other_platform_price'])): ?>
        <div class="comp-row" onclick="window.open('<?= (!empty($row['other_platform_link'])) ? htmlspecialchars($row['other_platform_link']) : htmlspecialchars($row['affiliate_link']); ?>', '_blank')">
          <div class="brand-col">
            <?php 
              $other_icon = "/Menshubprime/assets/images/bag.png";
              if(stripos($row['other_platform_name'], 'ajio') !== false) $other_icon = "/Menshubprime/assets/images/ajio.png?v=1.3";
              if(stripos($row['other_platform_name'], 'meesho') !== false) $other_icon = "/Menshubprime/assets/images/meesho.png?v=1.3";
            ?>
            <img src="<?= $other_icon; ?>" class="brand-icon" alt="<?= htmlspecialchars($row['other_platform_name']); ?>">
            <span class="brand-name"><?= htmlspecialchars($row['other_platform_name']); ?></span>
          </div>
          <div class="price-col">₹<?= number_format($row['other_platform_price']); ?></div>
          <div class="visit-col">View Deal</div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Main Actions -->
      <div class="action-buttons-wrap">
        <a class="buy-btn primary-btn" target="_blank" href="<?php echo htmlspecialchars($row['affiliate_link']); ?>">
          <i class="fas fa-shopping-cart"></i> BUY FROM AMAZON
        </a>
        <?php if(!empty($row['video_url'])): ?>
        <a class="buy-btn secondary-btn" href="/Menshubprime/video/<?php echo htmlspecialchars($row['video_url']); ?>">
          <i class="fas fa-play-circle"></i> Watch Full Video Review
        </a>
        <?php endif; ?>
      </div>

      <div class="redirect-info">
        <p><i class="fas fa-shield-alt"></i> <strong>Safe Checkout:</strong> Verified by MenHub Prime. You will be redirected to the official marketplace for secure payment.</p>
      </div>

      <!-- FAQ for Mobile (Hidden on Desktop) -->
      <div class="seo-faq-container mobile-only-faq-v2" style="margin-top:30px; padding:20px; background:var(--p-bg-alt); border-radius:var(--p-radius-md); border:1px solid var(--p-border);">
        <h2 style="font-size:18px; margin-bottom:15px; color:var(--p-text);">Product Overview & FAQ</h2>
        <div class="seo-faq-item">
          <p style="color:var(--p-text);"><strong>Is this product currently on sale?</strong></p>
          <p style="color:var(--p-text-light); font-size:13px;">We track prices across Amazon, Flipkart, and Myntra daily to ensure you get the absolute best deal.</p>
        </div>
      </div>

      <a class="back" href="/Menshubprime/">← Back to Homepage</a>

      <!-- Share Box -->
      <div class="share-box">
        <h2 style="font-size:16px; margin-bottom:15px; font-weight:800; color:var(--p-text);">Love it? Share with friends</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
          <button class="share-btn primary-btn" onclick="shareProduct()"><i class="fas fa-share-alt"></i> Share Page</button>
          <a class="share-btn whatsapp" href="https://wa.me/?text=<?php echo urlencode($productURL); ?>" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          <button class="share-btn copy" onclick="copyLink()"><i class="fas fa-link"></i> Copy Link</button>
        </div>
      </div>

      <!-- FAQ moved to sidebar -->

      <div class="affiliate-disclosure">
        <strong>Affiliate Disclosure:</strong> In compliance with the FTC, please note that some of the links on this page are affiliate links. At no additional cost to you, we may earn a commission if you click through and make a purchase. We only recommend products we believe add value to our audience.
      </div>
    </div> <!-- info-end -->
  </div> <!-- flex-end -->
</div> <!-- wrap-end -->

<!-- STICKY ACTION BAR (Outside for Float) -->
<div class="mobile-sticky-bar">
    <div class="sticky-info">
        <span>Current Best Price</span>
        <strong>₹<?= number_format($row['price']); ?></strong>
    </div>
    <a href="<?= htmlspecialchars($row['affiliate_link']); ?>" target="_blank" class="buy-btn primary-btn sticky-btn">
       <i class="fas fa-bolt"></i> GET DEAL
    </a>
</div>

<div class="related-section" style="max-width:1180px; margin: 40px auto; padding: 0 20px;">
  <h2 class="section-title">🔥 Handpicked for You</h2>
  <div class="hp-slider-wrap" id="hpSliderWrap">
    <div class="hp-slider-track" id="hpTrack">
      <?php
      $cat = $row['category'];
      $current_id = $row['id'];
      $rq = mysqli_query($conn,"SELECT * FROM products WHERE category='$cat' AND id!='$current_id' AND status='active' ORDER BY RAND() LIMIT 8");
      $hp_items = [];
      while($r = mysqli_fetch_assoc($rq)) $hp_items[] = $r;
      foreach($hp_items as $r): ?>
      <a href="/Menshubprime/product/<?= $r['slug']; ?>" class="hp-slide">
        <img src="/Menshubprime/assets/images/<?= $r['image']; ?>" alt="<?= htmlspecialchars($r['title']); ?>">
        <div class="hp-slide-body">
          <h3><?= $r['title']; ?></h3>
          <div class="hp-price-row">
            <p>₹<?= number_format($r['price']); ?></p>
            <span class="hp-slide-btn">View Deal →</span>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="hp-dots" id="hpDots"></div>
</div>

<?php
$sponsors = mysqli_query($conn,"SELECT * FROM sponsors WHERE status='active' AND position='home' ORDER BY id DESC");
if(mysqli_num_rows($sponsors) > 0){ ?>
<div class="sponsor-section" style="max-width:1180px; margin: 0 auto; padding: 0 20px;">
  <h2 class="section-title">✨ Sponsored Picks</h2>
  <div class="sponsor-track">
    <?php while($srow=mysqli_fetch_assoc($sponsors)){ ?>
    <div class="sponsor-card">
      <div class="sponsor-box">
        <img src="assets/images/<?= $srow['image']; ?>" alt="<?= htmlspecialchars($srow['title']); ?>">
        <div style="font-weight:700; margin:10px 0; color:var(--p-text);"><?= htmlspecialchars($srow['title']); ?></div>
        <a href="<?= $srow['link']; ?>" target="_blank" class="buy-btn primary-btn" style="padding:10px; font-size:13px;">Visit Now</a>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<?php } ?>

<?php
$mq = mysqli_query($conn,"SELECT * FROM mini_products WHERE status='active' ORDER BY id DESC LIMIT 4");
if(mysqli_num_rows($mq) > 0){ ?>
<div class="popular-section" style="max-width:1300px; margin: 40px auto; padding: 0 20px;">
  <h2 class="section-title">🔥 Popular Right Now</h2>
  <div class="mini-grid">
    <?php while($mrow=mysqli_fetch_assoc($mq)){ ?>
    <a href="<?= htmlspecialchars($mrow['link']); ?>" target="_blank" class="mini-card">
      <div class="mini-card-img">
        <span class="mini-fire">🔥</span>
        <img src="/Menshubprime/assets/images/<?= $mrow['image']; ?>" alt="<?= htmlspecialchars($mrow['title']); ?>">
        <span class="mini-price-badge">₹<?= number_format($mrow['price']); ?></span>
      </div>
      <div class="mini-card-body">
        <h3><?= $mrow['title']; ?></h3>
        <span class="mini-buy-btn">Buy Now &rarr;</span>
      </div>
    </a>
    <?php } ?>
  </div>
</div>
<?php } ?>

<?php 
$related_cat = $product_category;
include 'includes/related-content.php'; 
?>

<!-- TELEGRAM SECTION -->
<section class="telegram-wrap">
  <div class="telegram-box">
    <div class="tg-left">
      <img loading="lazy" src="assets/images/telegram.png" width="70" height="auto" alt="Telegram Deals">
    </div>
    <div class="tg-center">
      <h2>Join Our Telegram Club!</h2>
      <p>Get Exclusive Deals & Alerts!</p>
    </div>
    <div class="tg-right">
      <a href="https://t.me/thezayanway" target="_blank" rel="noopener">Join Now</a>
    </div>
  </div>
</section>

<!-- SMART MEN SECTION -->
<div style="max-width:350px; margin: 5px auto 10px; text-align:center; padding: 0 20px;">
  <h2 style="font-size:20px; font-weight:800; color: #fff; margin: 0;">Built for <span style="color:#fb923c;">Smart Men</span></h2>
  <p style="font-size:12px; opacity:0.8; margin-top:5px; color: #f8fafc; line-height: 1.4;">MenHub Prime curates the best deals for you — so you don't waste time searching.</p>
</div>

</div> <!-- .zn-product-container end -->

<script>
function copyLink(){
    navigator.clipboard.writeText(window.location.href);
    alert("Link copied to clipboard!");
}
function switchMedia(type, src, el) {
  const container = document.getElementById('mainMediaContainer');
  let html = '';
  
  if(type === 'img') {
    html = '<img id="mainMedia" src="' + src + '" style="animation: fadeIn 0.5s;">';
  } else if(type === 'video') {
    html = '<video id="mainMedia" src="' + src + '" controls autoplay muted playsinline style="animation: fadeIn 0.5s;"></video>';
  } else if(type === 'link') {
     if(src.includes('youtube.com') || src.includes('youtu.be')) {
        let vidId = "";
        if(src.includes('shorts/')) {
          vidId = src.split('shorts/')[1].split('?')[0];
        } else if(src.includes('v=')) {
          vidId = src.split('v=')[1].split('&')[0];
        } else {
          vidId = src.split('/').pop().split('?')[0];
        }
        html = '<iframe id="mainMedia" src="https://www.youtube.com/embed/' + vidId + '?autoplay=1&muted=1&playsinline=1" frameborder="0" allowfullscreen style="animation: fadeIn 0.5s;"></iframe>';
     } else if(src.includes('instagram.com')) {
        let cleanUrl = src.split('?')[0].replace(/\/$/, '');
        let igCode = cleanUrl.split('/').pop();
        let igUrl = 'https://www.instagram.com/reel/' + igCode + '/embed';
        html = '<iframe id="mainMedia" src="' + igUrl + '" frameborder="0" scrolling="no" allowtransparency="true" style="height:500px; animation: fadeIn 0.5s;"></iframe>';
     } else if(/\.(mp4|webm|ogg)$/i.test(src)) {
        html = '<video id="mainMedia" src="' + src + '" controls autoplay muted playsinline style="animation: fadeIn 0.5s;"></video>';
     } else {
        html = '<iframe id="mainMedia" src="' + src + '" frameborder="0" allowfullscreen style="min-height:400px; animation: fadeIn 0.5s;"></iframe>';
     }
  }
  
  container.innerHTML = html;
  
  // Update active class
  document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
}

function shareProduct(){
    if(navigator.share){
        navigator.share({ title: document.title, url: window.location.href });
    } else {
        copyLink();
    }
}

// Handpicked Auto Slider
(function(){
  const track   = document.getElementById('hpTrack');
  const dotsBox = document.getElementById('hpDots');
  const wrap    = document.getElementById('hpSliderWrap');
  if(!track) return;

  const slides = track.querySelectorAll('.hp-slide');
  const total  = slides.length;
  if(total < 1) return;

  // How many visible per view
  function perView(){ return window.innerWidth >= 768 ? 2 : 1; }

  let cur = 0, timer;
  const maxSteps = () => Math.max(0, total - perView());

  // Build dots = number of steps
  function buildDots(){
    dotsBox.innerHTML = '';
    const steps = maxSteps() + 1;
    for(let i=0;i<steps;i++){
      const d = document.createElement('div');
      d.className = 'hp-dot' + (i===0?' active':'');
      d.onclick = () => goTo(i);
      dotsBox.appendChild(d);
    }
  }
  buildDots();
  window.addEventListener('resize', buildDots);

  function goTo(n){
    cur = Math.min(Math.max(n, 0), maxSteps());
    // Each slide width = 100% / perView()
    const pv = perView();
    const slideW = 100 / pv;
    track.style.transform = `translateX(-${cur * slideW}%)`;
    dotsBox.querySelectorAll('.hp-dot').forEach((d,i) =>
      d.classList.toggle('active', i === cur)
    );
  }

  function next(){ goTo(cur >= maxSteps() ? 0 : cur + 1); }

  function start(){ timer = setInterval(next, 3500); }
  function stop() { clearInterval(timer); }

  start();
  wrap.addEventListener('mouseenter', stop);
  wrap.addEventListener('mouseleave', start);
  let tx = 0;
  wrap.addEventListener('touchstart', e => { tx = e.touches[0].clientX; }, {passive:true});
  wrap.addEventListener('touchend',   e => {
    const diff = tx - e.changedTouches[0].clientX;
    if(Math.abs(diff) > 40) diff > 0 ? goTo(cur+1) : goTo(cur-1);
  });
})();

// Scroll reveal for sticky bar and top button
window.addEventListener('scroll', function() {
  const stickyBar = document.querySelector('.mobile-sticky-bar');
  const topBtn = document.getElementById('topBtn');
  const triggerSection = document.getElementById('hpSliderWrap');
  
  if (!triggerSection) return;
  
  const triggerPos = triggerSection.getBoundingClientRect().top;
  const screenHeight = window.innerHeight;
  
  if (triggerPos < screenHeight * 0.8) {
    if(stickyBar) stickyBar.classList.add('show-sticky');
    if(topBtn) topBtn.classList.add('visible');
  } else {
    if(stickyBar) stickyBar.classList.remove('show-sticky');
    if(topBtn) topBtn.classList.remove('visible');
  }
});
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
