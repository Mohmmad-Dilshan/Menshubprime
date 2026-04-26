<?php include ROOT_PATH . '/includes/header.php'; 
?>



<!-- HERO -->
<div class="hero" id="mainHero" style="background:url('assets/images/hero.webp') no-repeat center/cover; position:relative; overflow:hidden;">








<style>
/* GLOBAL RESPONSIVE RESET */
html, body { overflow-x: hidden !important; width: 100%; position: relative; box-sizing: border-box; }
*, *:before, *:after { box-sizing: inherit; }

@media (max-width: 768px) {
    .hero-btns { display: flex; flex-direction: column; gap: 15px; width: 100%; align-items: center; }
    .hero-btns a.btn { 
        margin: 0 !important; 
        width: 80% !important; 
        display: flex; 
        justify-content: center; 
        font-size: 11px !important; /* Extremely compact for mobile */
        padding: 10px 18px !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
}
</style>

  <div class="hero-content">
    <div class="hero-text">
      <h1>Smart <strong style="font-style: ?title?;">Shopping</strong><br>for <strong style="color:orange;">Smart</strong> Men</h1>
      <span></span>
      <p class="small-text">Find the best deals on top men's products.</p>
      <hr class="hr1">
      <div class="hero-btns">
        <a class="btn orange" href="/deals">Explore Deals</a>
        <a class="btn blue" href="/telegram">Join the Club</a>
      </div>
    </div>
  </div>

  <!-- MOBILE BRAND PROMO POPUP (Inside Hero - FORCED SHOW) -->
  <?php
    $popup_q = mysqli_query($conn,"SELECT * FROM hero_popup WHERE (status='active' OR status='1') LIMIT 1");
    $p_data = ($popup_q) ? mysqli_fetch_assoc($popup_q) : null;
    if(!$p_data) $p_data = ['emoji'=>'🔥','title'=>'Limited Deal!','description'=>'Extra 10% OFF today','btn_text'=>'Grab Now','link'=>'/deals'];

    $slides_q = mysqli_query($conn, "SELECT image_path, link FROM hero_popup_slides ORDER BY id DESC");
    $slides_count = ($slides_q) ? mysqli_num_rows($slides_q) : 0;
    $track_width = ($slides_count > 0) ? ($slides_count * 100) : 100;
    $slide_width = ($slides_count > 0) ? (100 / $slides_count) : 100;
    ?>

  <div class="apple-stack-container" id="heroPromoPopup">
    
    <!-- Top Notification Bar -->
    <div class="apple-notif-bar">
      <button class="apple-notif-close" id="promoClose">✕</button>
      <div class="apple-notif-icon"><?= htmlspecialchars($p_data['emoji']) ?></div>
      <div class="apple-notif-body">
        <p class="apple-notif-title"><?= htmlspecialchars($p_data['title']) ?></p>
        <p class="apple-notif-desc"><?= htmlspecialchars($p_data['description']) ?></p>
      </div>
      <div class="apple-notif-right">
        <a href="<?= htmlspecialchars($p_data['link']) ?>" class="apple-notif-btn"><?= htmlspecialchars($p_data['btn_text']) ?></a>
      </div>
    </div>

    <!-- Slider Container -->
    <div class="apple-lite-card">
      <div class="apple-slider-track" id="appleSliderScroll" style="width: <?= $track_width ?>%;">
        <?php if($slides_count > 0): ?>
          <?php while($s = mysqli_fetch_assoc($slides_q)): ?>
            <div class="apple-slide" style="flex: 0 0 <?= $slide_width ?>%;">
               <a href="<?= htmlspecialchars($s['link']) ?>" style="display:block; width:100%; height:100%;">
                 <img loading="lazy" src="<?= htmlspecialchars($s['image_path']) ?>" alt="Promo" width="380" height="140">
                 <div class="slide-overlay"><span>Exclusive Deal</span></div>
               </a>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="apple-slide" style="flex: 0 0 100%;">
             <img src="apple_promo_banner_lite_webp_1776345556197.png" alt="Special Offer">
             <div class="slide-overlay"><span>Special Today</span></div>
          </div>
        <?php endif; ?>
      </div>

      <?php if($slides_count > 1): ?>
      <div class="apple-slider-dots">
        <?php for($i=0; $i<$slides_count; $i++): ?>
          <span class="<?= $i==0?'active':'' ?>" data-index="<?= $i ?>"></span>
        <?php endfor; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

</div> <!-- End of Hero -->

<style>
/* ============================================
   APPLE STACKED CARD SYSTEM (v8)
   ============================================ */
  .apple-stack-container {
    position: absolute !important;
    top: 15px;
    left: 50%;
    transform-origin: top center;
    transform: translateX(-50%) translateY(-100px) scale(0.8) rotateX(-30deg);
    width: calc(100% - 24px);
    max-width: 380px;
    z-index: 99 !important;
    opacity: 0;
    filter: blur(15px);
    display: flex;
    flex-direction: column;
    gap: 25px !important;
    transition: transform 1s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease, filter 0.8s ease;
    perspective: 1000px;
  }

.apple-stack-container.active {
  transform: translateX(-50%) translateY(0) scale(1) rotateX(0);
  opacity: 1;
  filter: blur(0);
  animation: apple-float 6s ease-in-out infinite alternate 1s;
}

@keyframes apple-float {
  0% { transform: translateX(-50%) translateY(0); }
  100% { transform: translateX(-50%) translateY(8px); }
}

/* Desktop Fix */
@media (min-width: 769px) {
  .apple-stack-container {
    left: auto !important;
    right: 30px !important;
    top: 140px !important;
    transform: perspective(1000px) translateX(150px) rotateY(-20deg) scale(0.9);
    transform-origin: right center;
  }
  .apple-stack-container.active {
    transform: perspective(1000px) translateX(0) rotateY(0) scale(1);
    animation: apple-float-desktop 5s ease-in-out infinite alternate 1s;
  }
  @keyframes apple-float-desktop {
    0% { transform: translateY(0); }
    100% { transform: translateY(12px); }
  }
}

/* 1. Top Bar Style */
.apple-notif-bar {
  display: flex;
  align-items: center;
  gap: 20px !important; /* Forced large gap between icon and text */
  background: rgba(10, 15, 25, 0.92);
  backdrop-filter: blur(30px) saturate(210%);
  -webkit-backdrop-filter: blur(30px) saturate(210%);
  border: 1px solid rgba(255, 255, 255, 0.18);
  border-radius: 20px;
  padding: 12px 18px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
  position: relative;
}

/* 2. Lite Card Slider Style */
.apple-lite-card {
  height: 140px;
  background: #000;
  border-radius: 8px 8px 24px 24px; /* Integrated bottom */
  overflow: hidden;
  position: relative;
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 15px 40px rgba(0,0,0,0.5);
}

@media (max-width: 768px) {
  .apple-lite-card { height: 110px; } /* Slimmer on mobile */
}

.apple-slider-track {
  display: flex;
  height: 100%;
  transition: transform 0.5s ease;
}

.apple-slide {
  flex: 0 0 100%;
  position: relative;
}

.apple-slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.slide-overlay {
  position: absolute;
  bottom: 12px;
  left: 12px;
  background: rgba(0,0,0,0.6);
  padding: 4px 10px;
  border-radius: 100px;
  font-size: 10px;
  color: #fff;
  font-weight: 700;
  backdrop-filter: blur(5px);
}

.apple-slider-dots {
  position: absolute;
  bottom: 8px;
  right: 12px;
  display: flex;
  gap: 4px;
}

.apple-slider-dots span {
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background: rgba(255,255,255,0.3);
}

.apple-slider-dots .active {
  background: #fb923c;
  width: 12px;
  border-radius: 10px;
}

/* Common Components */
.apple-notif-close {
  position: absolute;
  top: -8px;
  right: -8px;
  background: #1e293b;
  border: 1px solid rgba(255,255,255,0.2);
  color: #fff;
  font-size: 10px;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10;
  cursor: pointer;
}

/* Mobile: Hide close button as requested */
@media (max-width: 768px) {
  .apple-notif-close { display: none !important; }
}

.apple-notif-icon { 
  width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #fb923c, #f97316);
  display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;
}

.apple-notif-body { flex: 1; min-width: 0; }
.apple-notif-title { margin: 0; font-size: 14px; font-weight: 800; color: #fff; }
.apple-notif-desc { margin: 1px 0 0; font-size: 11px; color: rgba(255,255,255,0.7); line-height: 1.3; }

.apple-notif-btn { background: #fb923c; color: #fff; font-size: 11px; font-weight: 800; padding: 6px 14px; border-radius: 10px; text-decoration: none; }

.apple-stack-container.dismissing {
  transform: translateX(-50%) translateY(-150%) !important;
  opacity: 0 !important;
}
</style>

<script>
(function(){
  var popup = document.getElementById('heroPromoPopup');
  var closeBtn = document.getElementById('promoClose');
  var track = document.getElementById('appleSliderScroll');
  var dots = document.querySelectorAll('.apple-slider-dots span');
  if (!popup) return;

  setTimeout(function() { popup.classList.add('active'); }, 600);

  function dismiss() {
    popup.classList.add('dismissing');
    setTimeout(function() { popup.style.display = 'none'; }, 600);
  }
  if(closeBtn) closeBtn.addEventListener('click', dismiss);

  // Slider Logic (Dynamic)
  var curr = 0;
  var slidesCount = <?= $slides_count ?>;
  if(slidesCount > 1) {
    setInterval(function(){
      curr = (curr + 1) % slidesCount;
      if(track) track.style.transform = 'translateX(-' + (curr * (100/slidesCount)) + '%)';
      dots.forEach(function(d, i){ d.classList.toggle('active', i === curr); });
    }, 4000);
  }
})();
</script>

<!-- PRIME RIBBON - PREMIUM BRIDGE -->
<div class="prime-ribbon">
  <div class="ribbon-track">
    <!-- Set 1: Real items -->
    <div class="ribbon-item">
      <div class="ribbon-icon"><i class="fas fa-check-circle"></i></div>
      <div class="ribbon-text">
        <strong>Verified Choices</strong>
        <span>100% Authentic Brands</span>
      </div>
    </div>
    <div class="ribbon-divider"></div>
    <div class="ribbon-item">
      <div class="ribbon-icon"><i class="fas fa-bolt"></i></div>
      <div class="ribbon-text">
        <strong>Live Updates</strong>
        <span>New Deals Every 10 Mins</span>
      </div>
    </div>
    <div class="ribbon-divider"></div>
    <div class="ribbon-item">
      <div class="ribbon-icon"><i class="fas fa-crown"></i></div>
      <div class="ribbon-text">
        <strong>Prime Selection</strong>
        <span>Handpicked Luxury Gear</span>
      </div>
    </div>
    <!-- Set 2: Cloned items for seamless loop (mobile only) -->
    <div class="ribbon-item ribbon-clone">
      <div class="ribbon-icon"><i class="fas fa-check-circle"></i></div>
      <div class="ribbon-text">
        <strong>Verified Choices</strong>
        <span>100% Authentic Brands</span>
      </div>
    </div>
    <div class="ribbon-divider ribbon-clone"></div>
    <div class="ribbon-item ribbon-clone">
      <div class="ribbon-icon"><i class="fas fa-bolt"></i></div>
      <div class="ribbon-text">
        <strong>Live Updates</strong>
        <span>New Deals Every 10 Mins</span>
      </div>
    </div>
    <div class="ribbon-divider ribbon-clone"></div>
    <div class="ribbon-item ribbon-clone">
      <div class="ribbon-icon"><i class="fas fa-crown"></i></div>
      <div class="ribbon-text">
        <strong>Prime Selection</strong>
        <span>Handpicked Luxury Gear</span>
      </div>
    </div>
  </div>
</div>

<!-- CATEGORY SECTION - HYBRID (Desktop Grid / Mobile Stories) -->
<section class="category-hybrid-section">
  <div class="category-header">
    <h2 class="category-title">Explore <span class="accent">Categories</span></h2>
    <a href="/categories" class="view-all-btn">View All <i class="fas fa-chevron-right"></i></a>
  </div>
  
  <div class="category-container">
    <div class="category-grid-desktop">
       <div class="cat-card">
         <a href="/category/shoes">
           <img loading="lazy" src="assets/images/Cat1.png" alt="Shoes">
           <span>Shoes</span>
         </a>
       </div>
       <div class="cat-card">
         <a href="/category/watches">
           <img loading="lazy" src="assets/images/Cat2.png" alt="Watches">
           <span>Watches</span>
         </a>
       </div>
       <div class="cat-card">
         <a href="/category/grooming">
           <img loading="lazy" src="assets/images/Cat3.png" alt="Grooming">
           <span>Grooming</span>
         </a>
       </div>
       <div class="cat-card">
         <a href="/category/fitness">
           <img loading="lazy" src="assets/images/Cat4.png" alt="Fitness">
           <span>Fitness</span>
         </a>
       </div>
       <div class="cat-card">
         <a href="/category/accessories">
           <img loading="lazy" src="assets/images/Cat5.png" alt="Accessories">
           <span>Accessories</span>
         </a>
       </div>
    </div>

    <!-- Mobile Story Track (Hidden on Desktop) -->
    <div class="category-story-track-mobile">
      <div class="story-item">
        <a href="/category/shoes">
          <div class="story-circle glow-orange"><img src="assets/images/Cat1.png" alt="Shoes"></div>
          <span>Shoes</span>
        </a>
      </div>
      <div class="story-item">
        <a href="/category/watches">
          <div class="story-circle glow-blue"><img src="assets/images/Cat2.png" alt="Watches"></div>
          <span>Watches</span>
        </a>
      </div>
      <div class="story-item">
        <a href="/category/grooming">
          <div class="story-circle glow-purple"><img src="assets/images/Cat3.png" alt="Grooming"></div>
          <span>Grooming</span>
        </a>
      </div>
      <div class="story-item">
        <a href="/category/fitness">
          <div class="story-circle glow-green"><img src="assets/images/Cat4.png" alt="Fitness"></div>
          <span>Fitness</span>
        </a>
      </div>
      <div class="story-item">
        <a href="/category/accessories">
          <div class="story-circle glow-red"><img src="assets/images/Cat5.png" alt="Gear"></div>
          <span>Gear</span>
        </a>
      </div>
      <div class="story-item">
        <a href="/categories">
          <div class="story-circle more-icon"><i class="fas fa-plus"></i></div>
          <span>Explore Categories</span>
        </a>
      </div>
    </div>
  </div>

  <div class="offer-alert-v2">
    <div class="offer-track">
      <div class="offer-text">🔥 <span>Special Deal:</span> Get EXTRA 10% OFF Today • <span>Live Updates:</span> Hot deals refreshed every 15 mins • <span>Join the Club:</span> Shop smart, save more!</div>
      <div class="offer-text">🔥 <span>Special Deal:</span> Get EXTRA 10% OFF Today • <span>Live Updates:</span> Hot deals refreshed every 15 mins • <span>Join the Club:</span> Shop smart, save more!</div>
    </div>
  </div>
</section>

<style>
/* ============================================
   HYBRID CATEGORY SYSTEM
   ============================================ */
.category-hybrid-section { padding: 60px 0 20px; }

.category-header { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto 30px; padding: 0 20px; }
.category-title { font-size: 32px; font-weight: 950; color: #fff; margin: 0; }
.category-title .accent { color: #f97316; }

.view-all-btn { 
    color: #f97316; font-weight: 800; text-decoration: none; font-size: 14px; 
    display: flex; align-items: center; gap: 8px; transition: 0.3s;
}

/* DESKTOP GRID */
.category-grid-desktop {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.cat-card {
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 24px;
    padding: 25px 20px;
    text-align: center;
    transition: 0.4s;
}

.cat-card:hover { transform: translateY(-8px); background: rgba(15, 23, 42, 0.8); border-color: rgba(249, 115, 22, 0.4); }
.cat-card img { width: 100%; max-width: 120px; border-radius: 12px; margin-bottom: 15px; transition: 0.3s; }
.cat-card:hover img { transform: scale(1.1); }
.cat-card span { display: block; font-size: 16px; font-weight: 800; color: #fff; }

/* MOBILE STORIES (Hidden on Desktop) */
.category-story-track-mobile { display: none; }

@media (max-width: 768px) {
    .category-hybrid-section { padding: 30px 0 10px; }
    .category-title { font-size: 20px; }
    .category-grid-desktop { display: none; }
    
    .category-story-track-mobile {
        display: flex;
        overflow-x: auto;
        gap: 15px;
        padding: 0 0 20px 20px;
        scrollbar-width: none;
    }
    .category-story-track-mobile::-webkit-scrollbar { display: none; }
    
    .story-item { flex: 0 0 75px; text-align: center; }
    .story-circle { 
        width: 70px; height: 70px; border-radius: 50%; padding: 3px; 
        background: rgba(15, 23, 42, 0.5); border: 2px solid rgba(255,255,255,0.1);
        margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;
    }
    .story-circle img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .story-item span { font-size: 11px; font-weight: 700; color: #94a3b8; }
    
    /* Story Glows */
    .glow-orange { border-color: #f97316; box-shadow: 0 0 10px rgba(249, 115, 22, 0.3); }
    .glow-blue { border-color: #3b82f6; }
    .glow-purple { border-color: #a855f7; }
    .glow-green { border-color: #22c55e; }
    .glow-red { border-color: #ef4444; }
    .more-icon { color: #fff; font-size: 18px; border: 2px dashed rgba(255,255,255,0.2); }
}

/* OFFER ALERT Ticker v2 */
.offer-alert-v2 {
    background: rgba(249, 115, 22, 0.05); border: 1px solid rgba(249, 115, 22, 0.1);
    padding: 12px 0; overflow: hidden; margin-top: 20px;
}
.offer-track { display: flex; white-space: nowrap; animation: scroll-v3 40s linear infinite; gap: 40px; }
.offer-text { font-size: 11px; font-weight: 800; color: #f97316; letter-spacing: 0.5px; }
.offer-text span { color: #fff; }

@keyframes scroll-v3 { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
</style>

<!-- MOBILE BANNER SLIDER (mobile only) -->
<?php
// Create table if not exists (first run)
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS mobile_banners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  link VARCHAR(500) DEFAULT '#',
  status ENUM('active','inactive') DEFAULT 'active',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
$mob_banners = mysqli_query($conn,"SELECT * FROM mobile_banners WHERE status='active' ORDER BY sort_order ASC, id DESC");
$mob_count = mysqli_num_rows($mob_banners);
?>
<?php if($mob_count > 0): ?>
<section class="mob-banner-section">
  <div class="mob-slider-wrap">
    <div class="mob-slider-track" id="mobTrack">
      <?php while($mb = mysqli_fetch_assoc($mob_banners)): ?>
      <a href="<?= htmlspecialchars($mb['link']) ?>" class="mob-slide">
        <img src="assets/images/<?= htmlspecialchars($mb['image']) ?>" alt="<?= htmlspecialchars($mb['title']) ?>">
        <?php if(!empty($mb['title'])): ?>
        <span class="mob-slide-badge"><?= htmlspecialchars($mb['title']) ?></span>
        <?php endif; ?>
      </a>
      <?php endwhile; ?>
    </div>
    <div class="mob-dots" id="mobDots"></div>
  </div>
</section>
<?php endif; ?>

<style>
.mob-banner-section {
  display: none;
  margin: 15px 0 10px;
  padding: 0 12px;
}
@media (max-width: 768px) {
  .mob-banner-section { display: block; }
}

/* SMART RECOMMENDATIONS STYLES */
.prime-reco-section { display: none; margin: 30px 0; padding: 0 20px; }
.reco-header { border-left: 4px solid #fb923c; padding-left: 15px; margin-bottom: 20px; }
.reco-title { font-size: 24px; font-weight: 900; color: #fff; margin: 0; }
.reco-subtitle { color: #64748b; font-size: 14px; margin-top: 4px; }
.reco-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 15px; }

@media (max-width: 768px) {
    .prime-reco-section { padding: 0 12px; margin: 20px 0; }
    .reco-title { font-size: 18px; }
    .reco-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
}

.mob-slider-wrap {
  position: relative;
  overflow: hidden;
  border-radius: 16px;
}
.mob-slider-track {
  display: flex;
  transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1);
  will-change: transform;
}
.mob-slide {
  flex: 0 0 100%;
  width: 100%;
  display: block;
  text-decoration: none;
}
.mob-slide img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 16px;
  display: block;
}
.mob-dots {
  display: flex;
  justify-content: center;
  gap: 6px;
  margin-top: 10px;
}
.mob-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: rgba(255,255,255,0.25);
  border: none;
  padding: 0;
  cursor: pointer;
  transition: all 0.3s;
}
.mob-dot.active {
  background: #fb923c;
  width: 20px;
  border-radius: 10px;
}

/* Title Badge - top-left corner */
.mob-slide {
  position: relative;
}
.mob-slide-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: linear-gradient(135deg, #fb923c, #f97316);
  color: #fff;
  font-size: 11px;
  font-weight: 800;
  padding: 5px 13px;
  border-radius: 20px;
  letter-spacing: 0.4px;
  max-width: 75%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  z-index: 5;
  box-shadow: 0 3px 10px rgba(249,115,22,0.45);
}

/* SMART RECOMMENDATIONS STYLES */
.prime-reco-section { display: none; margin: 50px auto; max-width: 1400px; padding: 0 40px; }
.reco-header { border-left: 5px solid #fb923c; padding-left: 20px; margin-bottom: 30px; }
.reco-title { font-size: 32px; font-weight: 900; color: #fff; margin: 0; letter-spacing: -0.5px; }
.reco-subtitle { color: #94a3b8; font-size: 16px; margin-top: 6px; }
.reco-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 25px; }

/* Desktop Card Enhancements */
.reco-card { 
    background: rgba(30, 41, 59, 0.4); 
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px; 
    overflow: hidden; 
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    backdrop-filter: blur(10px);
}
.reco-card:hover { 
    transform: translateY(-12px); 
    border-color: rgba(251, 146, 60, 0.4);
    box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px rgba(251, 146, 60, 0.1);
}
.reco-card .card-media { height: 180px; position: relative; overflow: hidden; }
.reco-card .card-peek-btn { 
    position: absolute; bottom: 15px; right: 15px; 
    opacity: 0; transform: translateY(10px); 
    transition: all 0.3s ease; 
    background: #fb923c; color: #fff; border:none;
    width: 38px; height: 38px; border-radius: 12px;
}
.reco-card:hover .card-peek-btn { opacity: 1; transform: translateY(0); }

@media (max-width: 1200px) { .reco-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 768px) {
    .prime-reco-section { padding: 0 15px; margin: 25px auto; }
    .reco-title { font-size: 20px; }
    .reco-subtitle { font-size: 13px; }
    .reco-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .reco-card .card-media { height: 150px; }
    .reco-card .card-peek-btn { opacity: 1; transform: translateY(0); width: 32px; height: 32px; }
}
</style>

<!-- SMART RECOMMENDATIONS UI -->
<section class="prime-reco-section" id="primeRecoSection">
    <div class="reco-header">
        <h2 class="reco-title">💎 Handpicked <span style="color:#fb923c">For You</span></h2>
        <p class="reco-subtitle">Based on your recent interests</p>
    </div>
    <div class="reco-grid" id="recoGrid"></div>
</section>

<script>
(function(){
  var track = document.getElementById('mobTrack');
  var dotsWrap = document.getElementById('mobDots');
  if(!track) return;
  var slides = track.querySelectorAll('.mob-slide');
  var total = slides.length;
  if(total <= 0) return;
  var current = 0;
  var timer;

  // Build dots
  slides.forEach(function(_,i){
    var d = document.createElement('button');
    d.className = 'mob-dot' + (i===0?' active':'');
    d.setAttribute('aria-label','Slide '+(i+1));
    d.addEventListener('click', function(){ goTo(i); resetTimer(); });
    dotsWrap.appendChild(d);
  });

  function goTo(n){
    current = (n + total) % total;
    track.style.transform = 'translateX(-' + (current * 100) + '%)';
    dotsWrap.querySelectorAll('.mob-dot').forEach(function(d,i){
      d.classList.toggle('active', i===current);
    });
  }

  function next(){ goTo(current + 1); }

  function resetTimer(){
    clearInterval(timer);
    timer = setInterval(next, 3500);
  }

  // Touch swipe
  var startX = 0;
  track.addEventListener('touchstart', function(e){ startX = e.touches[0].clientX; }, {passive:true});
  track.addEventListener('touchend', function(e){
    var diff = startX - e.changedTouches[0].clientX;
    if(Math.abs(diff) > 40){ diff > 0 ? next() : goTo(current-1); resetTimer(); }
  }, {passive:true});
  resetTimer();
})();
</script>

<!-- SMART DISCOVERY SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const interests = JSON.parse(localStorage.getItem('mh_interests') || '[]');
  if (interests.length === 0) return;

  fetch(`/api/recommendations.php?cats=${interests.join(',')}`)
      .then(res => res.json())
      .then(data => {
          if (data && data.products && data.products.length > 0) {
              const grid = document.getElementById('recoGrid');
              const section = document.getElementById('primeRecoSection');
              
              grid.innerHTML = data.products.map(p => `
                  <div class="reco-card">
                      <a href="/product/${p.slug}" style="text-decoration:none;">
                          <div class="card-media">
                              <img src="assets/images/${p.image}" alt="${p.title}" style="width:100%; height:100%; object-fit:cover;">
                              <button onclick="event.preventDefault(); event.stopPropagation(); openQuickPeek('${p.slug}')" class="card-peek-btn"><i class="fas fa-eye"></i></button>
                          </div>
                          <div class="card-details" style="padding:15px;">
                              <h3 style="font-size:14px; height:40px; margin-bottom:10px; line-height:1.4; color:#f1f5f9; font-weight:600;">${p.title}</h3>
                              <div class="price-box" style="font-size:18px; color:#fb923c; font-weight:800;">₹${p.price}</div>
                          </div>
                      </a>
                  </div>
              `).join('');
              
              section.style.display = 'block';
          }
      }).catch(e => console.log("Reco offline", e));
});
</script>

<!-- TRENDING PRIME DEALS -->
<section class="section trending-prime-deals">

  <div class="trending-header">
    <div class="header-top-row">
      <h2 class="section-title">🔥 Trending <span class="accent">Prime Deals</span> 🔥</h2>
      <div class="prime-nav-container">
        <button class="prime-nav prev" id="slidePrev" aria-label="Previous Slide"><i class="fas fa-chevron-left"></i></button>
        <button class="prime-nav next" id="slideNext" aria-label="Next Slide"><i class="fas fa-chevron-right"></i></button>
      </div>
    </div>
    <p class="section-subtitle">Handpicked premium gear with exclusive discounts</p>
  </div>

  <div class="trending-slider-v2">
    <div class="trending-container-v2">
      <div class="trending-track-v2">

    <?php
/* Already handled by bootstrap */
    // Fetch a mix of categories for diversity (Shoes, Watches, Grooming, etc.)
    $q = mysqli_query($conn, "
      (SELECT * FROM products WHERE category = 'shoes' AND (status='active' OR status='1') LIMIT 3)
      UNION
      (SELECT * FROM products WHERE category = 'watches' AND (status='active' OR status='1') LIMIT 3)
      UNION
      (SELECT * FROM products WHERE category = 'grooming' AND (status='active' OR status='1') LIMIT 3)
      ORDER BY RAND()
    ");
    while($row=mysqli_fetch_assoc($q)){
    ?>

    <div class="prime-product-card">
      <div class="card-image-wrap">
        <span class="prime-badge">Limited Offer</span>
        <img loading="lazy" src="assets/images/<?php echo $row['image']; ?>" width="310" height="190" alt="<?php echo $row['title']; ?>">
        <div class="image-overlay"></div>
      </div>

      <div class="card-info">
        <h3><?php echo $row['title']; ?></h3>
        
        <div class="card-meta">
          <div class="price-tag">
            <span class="curr">₹</span><?php echo $row['price']; ?>
          </div>
          <div class="card-rating">
            <i class="fas fa-star"></i> 4.5 <span>(1.2k)</span>
          </div>
        </div>

        <a href="/product/<?php echo $row['slug']; ?>" 
           title="<?php echo $row['title']; ?>" class="prime-grab-btn">
          Grab Deal <i class="fas fa-bolt"></i>
        </a>
      </div>
    </div>

    <?php } ?>

      </div>
    </div>
  </div>
</section>

<!-- TRENDING 3D REVEALS - FUTURISTIC UI -->
<section class="section-3d-reveal">
    <div class="reveal-container">
        <div class="reveal-header-glow">
            <h2 class="reveal-title"><i class="fas fa-cube"></i> Trending <span class="accent-glow">3D Reveals</span></h2>
            <p class="reveal-tagline">Step into the future of shopping with immersive product depth.</p>
        </div>
        
        <?php
        $latest_3d = mysqli_query($conn, "SELECT * FROM products WHERE (status='active' OR status='1') ORDER BY id DESC LIMIT 1");
        if($l = mysqli_fetch_assoc($latest_3d)):
        ?>
        <div class="reveal-3d-card" data-tilt>
            <div class="reveal-inner-wrap">
                <div class="content-side">
                    <div class="badge-row">
                        <span class="badge-glass">Next-Gen</span>
                        <span class="badge-glass">Limited Reveal</span>
                    </div>
                    <h3><?= htmlspecialchars($l['title']) ?></h3>
                    <p>Experience original design in 360°. Every detail, every texture, explored in our virtual showroom.</p>
                    
                    <a href="/review-3d/<?= $l['slug'] ?>" class="scifi-btn">
                        <span>Launch 3D Lab</span>
                        <div class="btn-aura"></div>
                        <i class="fas fa-atom"></i>
                    </a>
                </div>

                <div class="visual-side">
                    <div class="glow-orb"></div>
                    <img src="assets/images/<?= $l['image'] ?>" alt="<?= htmlspecialchars($l['title']) ?>" class="floating-img">
                </div>
            </div>
            <!-- Decorative corner elements -->
            <div class="corner-line top-left"></div>
            <div class="corner-line bottom-right"></div>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* ============================================
   3D REVEAL - SCI-FI PREMIUM UI (v1)
   ============================================ */
.section-3d-reveal {
    padding: 80px 0;
    position: relative;
    overflow: hidden;
    background: radial-gradient(circle at 50% 10%, rgba(249, 115, 22, 0.05) 0%, transparent 60%);
}

.reveal-container { max-width: 1200px; margin: auto; padding: 0 20px; }

.reveal-header-glow { text-align: center; margin-bottom: 50px; }
.reveal-title { font-size: 42px; color: #fff; font-weight: 900; letter-spacing: -1px; }
.accent-glow { color: #f97316; text-shadow: 0 0 20px rgba(249, 115, 22, 0.4); }
.reveal-tagline { color: #94a3b8; font-size: 18px; margin-top: 8px; }

/* 3D Card Glassmorphism */
.reveal-3d-card {
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255, 255, 255, 0.08); /* Subtle border */
    border-radius: 40px;
    position: relative;
    padding: 60px;
    box-shadow: 0 30px 60px rgba(0,0,0,0.5);
    transition: all 0.5s ease;
}

.reveal-3d-card:hover { border-color: rgba(249, 115, 22, 0.3); }

.reveal-inner-wrap { display: flex; align-items: center; gap: 60px; position: relative; z-index: 10; }

.content-side { flex: 1.2; }
.badge-row { display: flex; gap: 10px; margin-bottom: 30px; }
.badge-glass { padding: 5px 15px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 100px; color: #f97316; font-size: 11px; font-weight: 800; }

.content-side h3 { font-size: 48px; color: #fff; margin-bottom: 20px; font-weight: 900; line-height: 1.1; }
.content-side p { color: #94a3b8; font-size: 19px; line-height: 1.6; margin-bottom: 40px; }

/* Sci-fi Button */
.scifi-btn {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    padding: 16px 40px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: #fff;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 800;
    font-size: 16px;
    position: relative;
    overflow: hidden;
    transition: 0.3s ease;
    box-shadow: 0 10px 30px rgba(249, 115, 22, 0.3);
}

.scifi-btn:hover { transform: scale(1.05); box-shadow: 0 15px 40px rgba(249, 115, 22, 0.5); }

/* Visual Side with Glow */
.visual-side { flex: 1; display: flex; justify-content: center; align-items: center; position: relative; padding: 40px 0; }
.glow-orb {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(249, 115, 22, 0.35) 0%, transparent 70%);
    z-index: 1;
    filter: blur(20px);
}

.floating-img {
    width: 100%; max-width: 450px;
    /* Strong Orange Glow Shadow */
    filter: drop-shadow(0 0 40px rgba(249, 115, 22, 0.4)) drop-shadow(0 30px 60px rgba(0,0,0,0.8));
    position: relative; z-index: 3;
    animation: floating-v2 6s ease-in-out infinite;
}

/* Ground shadow with orange tint to be visible */
.visual-side::after {
    content: '';
    position: absolute;
    bottom: -10px;
    width: 70%;
    height: 40px;
    background: radial-gradient(ellipse at center, rgba(249, 115, 22, 0.4) 0%, transparent 75%);
    border-radius: 50%;
    z-index: 2;
    filter: blur(5px);
    animation: shadow-scale 6s ease-in-out infinite;
}

@keyframes shadow-scale {
    0%, 100% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(0.85); opacity: 0.3; } /* Shadow fades as product moves up */
}

@keyframes floating-v2 {
    0% { transform: translateY(0) rotate(0); }
    50% { transform: translateY(-30px) rotate(3deg); }
    100% { transform: translateY(0) rotate(0); }
}

/* Corner Decor */
.corner-line { position: absolute; width: 40px; height: 40px; border: 2px solid transparent; }
.top-left { top: 30px; left: 30px; border-top-color: #f97316; border-left-color: #f97316; }
.bottom-right { bottom: 30px; right: 30px; border-bottom-color: #f97316; border-right-color: #f97316; }

/* Mobile Fixes */
@media (max-width: 768px) {
    .section-3d-reveal { padding: 40px 0; }
    .reveal-title { font-size: 28px; }
    .reveal-3d-card { padding: 30px; border-radius: 30px; }
    .reveal-inner-wrap { flex-direction: column; text-align: center; gap: 40px; }
    .content-side h3 { font-size: 32px; }
    .content-side p { font-size: 16px; }
    .badge-row { justify-content: center; }
    .floating-img { max-width: 300px; }
}
</style>

<!-- PREMIUM INFINITE PROMO TICKER -->
<div class="prime-promo-ticker">
    <div class="ticker-track">
        <!-- Set 1 -->
        <div class="ticker-item"><i class="fas fa-percent"></i> <span>Extra 10% OFF</span> using this website</div>
        <div class="ticker-divider"></div>
        <div class="ticker-item"><i class="fas fa-truck-fast"></i> <span>Free Updates</span> on all deals daily</div>
        <div class="ticker-divider"></div>
        <div class="ticker-item"><i class="fas fa-shield-halved"></i> <span>100% Trusted</span> & Verified Products</div>
        <div class="ticker-divider"></div>
        <div class="ticker-item"><i class="fas fa-fire"></i> <span>Limited Drops</span> exclusive to Prime members</div>
        <div class="ticker-divider"></div>
        
        <!-- Duplicated Set for Seamless Loop -->
        <div class="ticker-item"><i class="fas fa-percent"></i> <span>Extra 10% OFF</span> using this website</div>
        <div class="ticker-divider"></div>
        <div class="ticker-item"><i class="fas fa-truck-fast"></i> <span>Free Updates</span> on all deals daily</div>
        <div class="ticker-divider"></div>
        <div class="ticker-item"><i class="fas fa-shield-halved"></i> <span>100% Trusted</span> & Verified Products</div>
        <div class="ticker-divider"></div>
        <div class="ticker-item"><i class="fas fa-fire"></i> <span>Limited Drops</span> exclusive to Prime members</div>
        <div class="ticker-divider"></div>
    </div>
</div>

<style>
/* ============================================
   PRIME PROMO TICKER - MODERN UI (v1)
   ============================================ */
.prime-promo-ticker {
    width: 100%;
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    overflow: hidden;
    padding: 15px 0;
    margin: 20px 0;
    position: relative;
    z-index: 5;
}

.ticker-track {
    display: flex;
    align-items: center;
    width: max-content;
    animation: scroll-ticker 25s linear infinite;
    will-change: transform;
}

.ticker-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 40px;
    white-space: nowrap;
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.ticker-item i { color: #f97316; font-size: 16px; }
.ticker-item span { color: #fff; font-weight: 800; text-transform: uppercase; font-size: 12px; margin-right: 4px; }

.ticker-divider {
    width: 6px;
    height: 6px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

@keyframes scroll-ticker {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.prime-promo-ticker:hover .ticker-track { animation-play-state: paused; }

/* Mobile Style */
@media (max-width: 768px) {
    .prime-promo-ticker { padding: 12px 0; margin: 10px 0; }
    .ticker-item { font-size: 13px; padding: 0 30px; }
    .ticker-track { animation-duration: 20s; } /* Slightly faster for mobile visual pace */
}
</style>

<?php
$q = mysqli_query($conn,"SELECT * FROM mini_products WHERE status='active' ORDER BY id DESC LIMIT 4");
?>

<!-- POPULAR RIGHT NOW (PREMIUM FEED) -->
<section class="popular-feed-section">
  <div class="feed-header">
    <div class="header-main">
      <h2 class="feed-title">🌟 Popular <span class="accent">Right Now</span></h2>
      <p class="feed-subtitle">Most clicked and highly rated gear this week</p>
    </div>
    <span class="live-pulse"><span class="pulse-dot"></span> UPDATED LIVE</span>
  </div>

  <div class="popular-grid">
    <?php while($row=mysqli_fetch_assoc($q)){ ?>
    <div class="popular-card" data-tilt>
      <div class="card-media">
        <?php if($row['price'] < 500): ?>
          <span class="deal-tag">Budget Pick</span>
        <?php else: ?>
          <span class="deal-tag hot">Trending</span>
        <?php endif; ?>
        <img loading="lazy" src="assets/images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
        <div class="media-overlay"></div>
      </div>

      <div class="card-details">
        <h3><?php echo $row['title']; ?></h3>
        <div class="card-price-row">
          <div class="price-box">
             <span class="symbol">₹</span>
             <span class="amt"><?php echo $row['price']; ?></span>
          </div>
          <div class="rating-strip">
             <i class="fas fa-star"></i> 4.8
          </div>
        </div>
        
        <a href="<?php echo $row['link']; ?>" target="_blank" rel="noopener" class="grab-pill">
           Grab Now <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
    <?php } ?>
  </div>
</section>

<style>
/* ============================================
   POPULAR FEED - PREMIUM UI (v1)
   ============================================ */
.popular-feed-section {
  max-width: 1200px;
  margin: 60px auto;
  padding: 0 20px;
}

.feed-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 35px;
  border-left: 4px solid #f97316;
  padding-left: 20px;
}

.feed-title {
  font-size: 32px;
  font-weight: 900;
  color: #fff;
  margin: 0;
  letter-spacing: -0.5px;
}

.feed-title .accent { color: #f97316; }
.feed-subtitle { color: #94a3b8; font-size: 15px; margin-top: 5px; }

.live-pulse {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 800;
  color: #f97316;
  background: rgba(249, 115, 22, 0.1);
  padding: 6px 14px;
  border-radius: 100px;
}

.pulse-dot {
  width: 8px;
  height: 8px;
  background: #f97316;
  border-radius: 50%;
  animation: pulse-ring 1.5s infinite;
}

@keyframes pulse-ring {
  0% { transform: scale(0.8); opacity: 0.8; }
  50% { transform: scale(1.2); opacity: 0.4; }
  100% { transform: scale(0.8); opacity: 0.8; }
}

/* Grid Layout */
.popular-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
  gap: 25px;
}

/* Modern Card */
.popular-card {
  background: rgba(15, 23, 42, 0.5);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 28px;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  position: relative;
}

.popular-card:hover {
  transform: translateY(-10px);
  border-color: rgba(249, 115, 22, 0.4);
  background: rgba(15, 23, 42, 0.8);
  box-shadow: 0 20px 40px rgba(0,0,0,0.4);
}

.card-media {
  height: 180px;
  position: relative;
  overflow: hidden;
}

.card-media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: 0.5s;
}

.popular-card:hover .card-media img { transform: scale(1.1); }

.deal-tag {
  position: absolute;
  top: 15px;
  left: 15px;
  z-index: 10;
  background: #fff;
  color: #0f172a;
  padding: 4px 12px;
  border-radius: 100px;
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
}

.deal-tag.hot {
  background: linear-gradient(135deg, #f97316, #ea580c);
  color: #fff;
}

.card-details {
  padding: 22px;
}

.card-details h3 {
  font-size: 18px;
  font-weight: 700;
  color: #fff;
  margin: 0 0 12px;
  line-height: 1.4;
  height: 50px;
  overflow: hidden;
}

.card-price-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
}

.price-box { color: #f97316; font-weight: 900; font-size: 20px; }
.price-box .symbol { font-size: 15px; margin-right: 2px; }

.rating-strip {
  background: rgba(255, 255, 255, 0.05);
  padding: 4px 10px;
  border-radius: 8px;
  color: #fbbf24;
  font-size: 12px;
  font-weight: 800;
}

/* Modern Card button center fix */
.grab-pill {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  max-width: 220px; /* More defined width */
  margin: 0 auto; /* Centered in card */
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #fff;
  padding: 12px;
  border-radius: 16px;
  text-decoration: none;
  font-weight: 800;
  font-size: 14px;
  transition: 0.3s;
}

.grab-pill:hover {
  background: #f97316;
  border-color: #f97316;
  box-shadow: 0 8px 15px rgba(249, 115, 22, 0.3);
}

/* Mobile Fixes - 2 Column Compact Style */
@media (max-width: 768px) {
  .popular-feed-section { margin: 25px auto; padding: 0 12px; overflow: hidden; }
  .feed-header { border-left-width: 3px; padding-left: 12px; margin-bottom: 20px; }
  .feed-title { font-size: 20px; }
  .feed-subtitle { font-size: 13px; }
  .live-pulse { padding: 4px 10px; font-size: 9px; }

  .popular-grid { 
    grid-template-columns: repeat(2, 1fr); /* 2 Columns on Mobile */
    gap: 12px; 
    width: 100%;
  }
  
  .popular-card { border-radius: 18px; }
  .card-media { height: 130px; } /* Compact image */
  
  .deal-tag { top: 8px; left: 8px; padding: 2px 8px; font-size: 8px; }
  
  .card-details { padding: 12px; }
  .card-details h3 { font-size: 13px; height: 36px; margin-bottom: 8px; line-height: 1.3; }
  
  .card-price-row { margin-bottom: 12px; }
  .price-box { font-size: 16px; }
  .price-box .symbol { font-size: 12px; }
  .rating-strip { font-size: 10px; padding: 2px 6px; border-radius: 6px; }
  
  .grab-pill { padding: 8px; font-size: 12px; border-radius: 12px; gap: 5px; margin: 0 auto !important; width: 90%; display: flex !important; }
  .grab-pill i { font-size: 11px; }
}
</style>

<!-- EXPERT COMPARISON SECTION - AUTHORITY UI -->
<?php
include_once ROOT_PATH . '/includes/comparison-ui.php';
$homeComp = mysqli_query($conn, "SELECT id, title FROM comparison_tables WHERE status='active' ORDER BY id DESC LIMIT 1");
if(mysqli_num_rows($homeComp) > 0){
    $hc = mysqli_fetch_assoc($homeComp);
?>
<section class="expert-comparison-wrap">
    <div class="comparison-inner">
        <div class="comparison-header">
            <div class="expert-badge"><i class="fas fa-microchip"></i> DATA-DRIVEN ANALYSIS</div>
            <h2 class="comp-title">⚔️ The Ultimate <span class="accent-reveal">Comparison</span></h2>
            <p class="comp-subtitle">We put the top choices head-to-head. Only one remains as the definitive prime selection.</p>
        </div>

        <div class="table-reveal-card">
            <?php renderComparison($hc['id'], $conn); ?>
        </div>

        <div class="comp-footer">
            <a href="/comparisons" class="premium-view-btn">
               Check Full Comparison Guide <i class="fas fa-arrow-right-long"></i>
            </a>
        </div>
    </div>
</section>

<style>
/* ============================================
   EXPERT COMPARISON - AUTHORITY UI (v1)
   ============================================ */
.expert-comparison-wrap {
    padding: 80px 0 40px;
    background: linear-gradient(to bottom, transparent, rgba(15, 23, 42, 0.4), transparent);
    border-top: 1px solid rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(255, 255, 255, 0.03);
}

.comparison-inner { max-width: 1200px; margin: auto; padding: 0 20px; }

.comparison-header { text-align: center; margin-bottom: 50px; }

.expert-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(249, 115, 22, 0.1);
    color: #f97316;
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.comp-title { font-size: 48px; color: #fff; font-weight: 950; margin-bottom: 12px; letter-spacing: -1.5px; }
.comp-title .accent-reveal { background: linear-gradient(135deg, #f97316, #fb923c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0 0 15px rgba(249,115,22,0.3)); }
.comp-subtitle { color: #94a3b8; font-size: 19px; max-width: 650px; margin: 0 auto; line-height: 1.7; font-weight: 400; text-wrap: balance; }

/* Table Container */
.table-reveal-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 32px;
    padding: 40px;
    box-shadow: 0 40px 80px rgba(0,0,0,0.5);
    overflow-x: auto; /* For mobile tables */
}

/* Footer & Button */
.comp-footer { text-align: center; margin-top: 40px; }

.premium-view-btn {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
    transition: 0.3s;
    font-size: 15px;
    border-bottom: 2px solid #f97316;
    padding-bottom: 5px;
}

.premium-view-btn:hover { color: #f97316; gap: 20px; }

/* Mobile Optimization */
@media (max-width: 768px) {
    .expert-comparison-wrap { padding: 60px 0; }
    .comp-title { font-size: 26px; }
    .comp-subtitle { font-size: 15px; }
    .table-reveal-card { padding: 20px; border-radius: 20px; margin: 0 -10px; }
}
</style>
<?php } ?>

<!-- LATEST BLOGS SECTION - PREMIUM BENTO CARDS -->
<section class="home-blog-section">
  <div class="editorial-header">
    <div class="header-content">
      <h2 class="editorial-title">📖 Latest <span class="accent">Blogs</span> & Guides</h2>
      <p class="section-subtitle">Level up your lifestyle with our expert insights</p>
    </div>
    <a href="/blog/" class="editorial-view-btn">Explore All <i class="fas fa-arrow-right"></i></a>
  </div>

  <div class="bento-blog-container">
    <?php
    $blog_query = mysqli_query($conn, "SELECT * FROM blogs WHERE status='active' ORDER BY id DESC LIMIT 3");
    $blog_count = 0;
    while($blog = mysqli_fetch_assoc($blog_query)){
      $blog_count++;
      $card_class = ($blog_count === 1) ? 'bento-large' : 'bento-small';
    ?>
    <div class="premium-blog-card <?= $card_class ?>">
      <div class="blog-card-image">
        <img loading="lazy" src="assets/images/<?php echo $blog['image']; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
        <div class="blog-date-badge">
          <span class="d"><?php echo date('d', strtotime($blog['date'] ?? 'now')); ?></span>
          <span class="m"><?php echo date('M', strtotime($blog['date'] ?? 'now')); ?></span>
        </div>
      </div>
      <div class="blog-card-content">
        <?php if($blog_count === 1): ?><span class="choice-tag">Editor's Choice</span><?php endif; ?>
        <h3><?php echo htmlspecialchars($blog['title']); ?></h3>
        <p><?php echo substr(strip_tags($blog['content']), 0, ($blog_count === 1) ? 140 : 80); ?>...</p>
        <div class="blog-card-footer">
          <a href="/blog/<?php echo $blog['slug']; ?>" class="premium-read-btn stretched-link" aria-label="Read full article: <?php echo htmlspecialchars($blog['title']); ?>">
            Read full article <i class="fas fa-long-arrow-alt-right"></i>
          </a>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>

  <div class="blog-footer-nav">
     <div class="seo-tags-row">
        <a href="/category/shoes">Men's Shoes</a>
        <a href="/category/watches">Watches</a>
        <a href="/category/grooming">Grooming</a>
        <a href="/category/fitness">Fitness</a>
        <a href="/category/accessories">Accessories</a>
     </div>
  </div>
</section>

<style>
/* ============================================
   PREMIUM BENTO BLOG CARDS (v2)
   ============================================ */
.home-blog-section {
    max-width: 1200px;
    margin: 10px auto 50px !important; /* Force minimal top margin */
    padding: 0 20px;
}

.editorial-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 40px;
}

.editorial-title { font-size: 32px; color: #fff; font-weight: 900; margin: 0; }
.editorial-title .accent { color: #f97316; }
.editorial-view-btn { border-bottom: 2px solid #f97316; color: #fff; text-decoration: none; font-weight: 700; font-size: 14px; padding-bottom: 4px; transition: 0.3s; position: relative; z-index: 99; display: inline-block; }
.editorial-view-btn:hover { color: #f97316; padding-right: 10px; }

/* Bento Container */
.bento-blog-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(2, 260px);
    gap: 25px;
}

.premium-blog-card {
    position: relative; /* Added for stretched link */
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 30px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    cursor: pointer;
}

.premium-blog-card:hover { 
    transform: translateY(-8px); 
    border-color: rgba(249, 115, 22, 0.3);
    background: rgba(15, 23, 42, 0.8);
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
}

.stretched-link::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 10;
}

.bento-large { grid-column: span 2; grid-row: span 2; }

.blog-card-image { position: relative; width: 100%; height: 60%; overflow: hidden; }
.bento-large .blog-card-image { height: 65%; }
.bento-small .blog-card-image { height: 50%; } /* Reduced for small cards */

.blog-card-image img { width: 100%; height: 100%; object-fit: cover; object-position: center; transition: 0.8s; }
.premium-blog-card:hover .blog-card-image img { transform: scale(1.1); }

/* Content Adjustments for Small Cards */
.bento-small .blog-card-content p { display: none; } /* Hide desc on small cards to save height */
.bento-small .blog-card-content h3 { font-size: 16px; margin-bottom: 8px; }
.bento-small .blog-card-content { padding: 15px; }

.blog-date-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #fff;
    width: 45px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    z-index: 5;
}
.blog-date-badge .d { color: #000; font-weight: 900; font-size: 19px; line-height: 1; }
.blog-date-badge .m { color: #f97316; font-size: 10px; font-weight: 800; text-transform: uppercase; }

/* Content */
.blog-card-content { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
.choice-tag { color: #f97316; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block; }

.blog-card-content h3 { font-size: 20px; color: #fff; font-weight: 800; margin-bottom: 12px; line-height: 1.4; }
.bento-large .blog-card-content h3 { font-size: 28px; }

.blog-card-content p { color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 15px; }
.blog-card-footer { margin-top: auto; }

.premium-read-btn { display: inline-flex; align-items: center; gap: 8px; color: #f97316; text-decoration: none; font-weight: 800; font-size: 14px; transition: 0.3s; }
.premium-read-btn:hover { gap: 12px; }

/* SEO Tags */
.blog-footer-nav { margin-top: 40px; }
.seo-tags-row { display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
.seo-tags-row a { padding: 8px 18px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 100px; color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 600; transition: 0.3s; }
.seo-tags-row a:hover { border-color: #f97316; color: #fff; }

/* Mobile Magazine Style */
@media (max-width: 768px) {
    .editorial-header { flex-direction: column; align-items: center; text-align: center; gap: 15px; margin-bottom: 30px; }
    .editorial-title { font-size: 24px; }
    .section-subtitle { font-size: 14px; }

    .bento-blog-container { grid-template-columns: 1fr; grid-template-rows: auto; gap: 20px; }
    .bento-large { grid-column: auto; grid-row: auto; }
    .premium-blog-card { height: auto; }
    .blog-card-image { height: 200px; }
    
    /* Hide all blogs except the first one on mobile as requested */
    .premium-blog-card:nth-child(n+2) { display: none; }
}
</style>

<?php
$sponsors = mysqli_query($conn,"
SELECT * FROM sponsors 
WHERE status='active' AND position='home'
ORDER BY id DESC
");

if(mysqli_num_rows($sponsors) > 0){
?>

<!-- PREMIUM SPONSORED DISPLAY GRID (AD BANNERS) -->
<section class="sponsored-display-section">
  <div class="ad-header">
     <h2 class="ad-section-title"><i class="fas fa-bullhorn"></i> Featured <span class="accent">Promotions</span></h2>
     <p class="ad-subtitle">Handpicked collaborations and exclusive brand drops.</p>
  </div>

  <div class="ad-banners-grid">
    <?php 
    mysqli_data_seek($sponsors, 0); 
    while($row=mysqli_fetch_assoc($sponsors)){ 
    ?>
      <a href="<?= $row['link'] ?>" target="_blank" class="ad-banner-card">
        <div class="ad-image-wrap">
          <img loading="lazy" src="assets/images/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['title']) ?>" width="400" height="170">
          <div class="ad-overlay">
             <span class="promoted-tag">PROMOTED</span>
             <div class="ad-content-box">
                <span class="ad-title"><?= htmlspecialchars($row['title']) ?></span>
                <span class="ad-cta">Learn More <i class="fas fa-external-link-alt"></i></span>
             </div>
          </div>
        </div>
      </a>
    <?php } ?>
  </div>
</section>

<style>
/* ============================================
   SPONSORED DISPLAY GRID - MODERN UI (v3)
   ============================================ */
.sponsored-display-section {
    max-width: 1200px;
    margin: 60px auto;
    padding: 0 20px;
}

.ad-header { text-align: left; margin-bottom: 35px; border-left: 4px solid #f97316; padding-left: 20px; }
.ad-section-title { font-size: 32px; color: #fff; font-weight: 900; }
.ad-section-title .accent { color: #f97316; }
.ad-subtitle { color: #94a3b8; font-size: 16px; margin-top: 5px; }

.ad-banners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
}

.ad-banner-card {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    background: #0f172a;
    aspect-ratio: 21/9; /* CINEMATIC BANNER RATIO */
    display: block;
    transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.ad-banner-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }

.ad-image-wrap { width: 100%; height: 100%; position: relative; }
.ad-image-wrap img { width: 100%; height: 100%; object-fit: cover; transition: 0.6s; }
.ad-banner-card:hover .ad-image-wrap img { transform: scale(1.05); }

.ad-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(0,0,0,0.85) 0%, transparent 80%); /* Gradual Left-to-Right Fade */
    padding: 20px 30px;
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center Content vertically */
    gap: 10px;
}

.promoted-tag {
    align-self: flex-start;
    background: #f97316;
    color: #fff;
    font-size: 9px;
    font-weight: 900;
    padding: 3px 10px;
    border-radius: 4px;
    letter-spacing: 1px;
}

.ad-title {
    display: block;
    color: #fff;
    font-size: 20px;
    font-weight: 900;
}

.ad-cta {
    color: rgba(255,255,255,0.8);
    font-size: 13px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Mobile Adjustments - SLEEK BANNER STRIPS */
@media (max-width: 768px) {
    .sponsored-display-section { padding: 0 0 0 15px; margin: 30px auto; overflow: hidden; }
    
    .ad-banners-grid {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        gap: 12px;
        padding-bottom: 10px;
        scrollbar-width: none;
    }

    .ad-banner-card {
        min-width: 90%; 
        flex: 0 0 90%;
        aspect-ratio: 3/1; /* STYLISH STRIP BANNER FOR MOBILE */
        scroll-snap-align: start;
        border-radius: 12px;
    }
    
    .ad-title { font-size: 16px; }
    .ad-overlay { padding: 12px 20px; }
}
</style>

<?php } ?>

<!-- PREMIUM SEO INFO SECTION -->
<section class="prime-seo-section">
    <div class="seo-glass-board">
        <h2 class="seo-title">Best <span class="highlight">Men's Deals</span>, Fashion & Smart Shopping Guides</h2>
        <div class="seo-content-wrap">
            <p>Welcome to <strong>MENSHUB <span class="accent-prime">PRIME</span></strong>, a smart shopping platform designed for modern men who want the best products at the best prices. Discover trending deals on shoes, watches, grooming products, fitness gear and stylish accessories.</p>
            <p>We research popular products from trusted platforms like Amazon, Flipkart, Myntra and other top marketplaces to help you find the best deals quickly.</p>
        </div>
        <div class="seo-action-row">
            <a href="/blog" class="prime-btn-link neon-blue">Read Shopping Guides <i class="fas fa-book-open"></i></a>
            <a href="/deals" class="prime-btn-link neon-orange">Explore Best Deals <i class="fas fa-bolt"></i></a>
        </div>
    </div>
</section>

<style>
/* ============================================
   PRIME SEO SECTION - MODERN UI
   ============================================ */
.prime-seo-section { padding: 20px 0 60px 0; background: radial-gradient(circle at 50% 50%, rgba(249, 115, 22, 0.03) 0%, transparent 70%); margin-top: -20px; }
.seo-glass-board {
    max-width: 1000px; margin: auto; padding: 60px;
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    text-align: center;
    box-shadow: 0 40px 100px rgba(0,0,0,0.5);
}
.seo-title { font-size: 36px; color: #fff; font-weight: 900; margin-bottom: 25px; line-height: 1.2; }
.seo-title .highlight { color: #f97316; }
.accent-prime { color: #f97316; letter-spacing: 1px; }
.seo-content-wrap p { color: #94a3b8; font-size: 18px; line-height: 1.8; margin-bottom: 20px; text-wrap: balance; }

.seo-action-row { display: flex; justify-content: center; gap: 20px; margin-top: 40px; }
.prime-btn-link {
    padding: 16px 35px; border-radius: 16px; font-weight: 800; font-size: 15px;
    text-decoration: none; display: inline-flex; align-items: center; gap: 12px;
    transition: 0.3s;
}
.neon-blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); }
.neon-blue:hover { background: #3b82f6; color: #fff; box-shadow: 0 0 30px rgba(59, 130, 246, 0.4); }
.neon-orange { background: rgba(249, 115, 22, 0.1); color: #f97316; border: 1px solid rgba(249, 115, 22, 0.2); }
.neon-orange:hover { background: #f97316; color: #fff; box-shadow: 0 0 30px rgba(249, 115, 22, 0.4); }

@media (max-width: 768px) {
    .seo-glass-board { padding: 30px 20px; border-radius: 30px; }
    .seo-title { font-size: 24px; }
    .seo-content-wrap p { font-size: 15px; }
    .seo-action-row { flex-direction: column; }
}
</style>

<!-- NEXT-LEVEL VIRAL CINEMA SECTION -->
<section class="next-level-cinema">
<?php
$v_q = mysqli_query($conn,"SELECT * FROM videos WHERE status = 1 ORDER BY id DESC LIMIT 1");
$v = mysqli_fetch_assoc($v_q);
if($v){
?>
  <!-- Immersive Backdrop -->
  <div class="cinema-backdrop" style="background-image: url('uploads/thumbs/<?= $v['thumb']; ?>');"></div>
  
  <div class="cinema-overlay-wash"></div>

  <div class="cinema-main-wrap">
    
    <div class="cinema-section-head">
       <span class="cinema-badge-top">CINEMATIC SHOWCASE</span>
       <h2 class="cinema-major-title">🎞️ Viral <span class="accent">Featured Reveal</span></h2>
       <p class="cinema-major-sub">Deep dive into this season's most viral gadgets.</p>
    </div>

    <div class="cinema-content-glow">
        <div class="cinema-grid-modern">
            
            <!-- Video Showcase Frame -->
            <div class="cinema-video-frame">
                <div class="video-glass-wrapper">
                    <?php if(strpos($v['video_link'],'youtube') !== false){ ?>
                      <iframe loading="lazy" src="<?= $v['video_link']; ?>" frameborder="0" allowfullscreen></iframe>
                    <?php } else { ?>
                      <video controls poster="uploads/thumbs/<?= $v['thumb']; ?>" loading="lazy">
                        <source loading="lazy" src="uploads/videos/<?= $v['video_link']; ?>" type="video/mp4">
                      </video>
                    <?php } ?>
                </div>
                <div class="video-reflection"></div>
            </div>

            <!-- Cinematic Info -->
            <div class="cinema-text-side">
                <div class="viral-tag-modern">
                   <div class="pulse-dot"></div> FEATURED PRODUCTION
                </div>
                <h2 class="cinema-mega-title"><?= htmlspecialchars($v['title']); ?></h2>
                <p class="cinema-mega-desc"><?= substr(strip_tags($v['description']),0,200); ?>...</p>
                
                <div class="cinema-cta-bundle">
                    <a href="<?= $v['buy_link']; ?>" target="_blank" class="buy-neon-btn haptic-press">
                        Get It Now <i class="fas fa-shopping-bag"></i>
                    </a>
                    <a href="/video/<?= $v['slug']; ?>" class="watch-pure-btn haptic-press">
                        Watch Full Review <i class="fas fa-play-circle"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
    
    <div class="cinema-footer-minimal">
        <a href="/videos">Explore The Viral Vault <i class="fas fa-chevron-right"></i></a>
    </div>
  </div>
<?php } ?>
</section>

<style>
/* ============================================
   NEXT-LEVEL CINEMA SECTION - PREMIUM UI
   ============================================ */
.next-level-cinema {
    position: relative;
    padding: 20px 0 40px 0;
    background: #000;
    min-height: 700px;
    display: flex;
    align-items: center;
    overflow: hidden;
    color: #fff;
    margin-top: -30px;
}

/* Immersive Background */
.cinema-backdrop {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    filter: blur(80px) opacity(0.35) saturate(1.5);
    transform: scale(1.1);
}

.cinema-overlay-wash {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 70% 50%, transparent 20%, #000 80%);
}

.cinema-main-wrap {
    width: 100%;
    max-width: 1400px;
    margin: auto;
    padding: 0 40px;
    position: relative;
    z-index: 10;
}

.cinema-section-head { margin-bottom: 50px; text-align: left; }
.cinema-badge-top { color: #f97316; font-size: 10px; font-weight: 800; letter-spacing: 3px; }
.cinema-major-title { font-size: 42px; font-weight: 900; color: #fff; margin: 10px 0; }
.cinema-major-title .accent { color: #f97316; }
.cinema-major-sub { color: #94a3b8; font-size: 16px; font-weight: 500; }

.cinema-grid-modern {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 80px;
    align-items: center;
}

/* Video Frame with Reflection */
.cinema-video-frame {
    position: relative;
}

.video-glass-wrapper {
    position: relative;
    aspect-ratio: 16/9;
    background: #111;
    border-radius: 30px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 30px 100px rgba(0,0,0,0.8), 0 0 50px rgba(249, 115, 22, 0.1);
    z-index: 2;
}

.video-glass-wrapper iframe, .video-glass-wrapper video {
    width: 100%; height: 100%; object-fit: cover;
}

.video-reflection {
    position: absolute;
    bottom: -60px;
    left: 10%;
    right: 10%;
    height: 100px;
    background: linear-gradient(to top, transparent, rgba(249, 115, 22, 0.2));
    filter: blur(40px);
    border-radius: 50%;
    z-index: 1;
}

/* Text Stylings */
.viral-tag-modern {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.05);
    padding: 6px 15px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
    color: #f97316;
    margin-bottom: 30px;
    border: 1px solid rgba(249, 115, 22, 0.2);
}

.pulse-dot {
    width: 6px; height: 6px;
    background: #f97316;
    border-radius: 50%;
    box-shadow: 0 0 10px #f97316;
    animation: pulse-neon-cin 1.5s infinite;
}

.cinema-mega-title {
    font-size: 52px;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 25px;
    background: linear-gradient(to bottom, #fff, #94a3b8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.cinema-mega-desc {
    font-size: 18px;
    color: #94a3b8;
    line-height: 1.7;
    margin-bottom: 45px;
    max-width: 500px;
}

/* CTAs */
.cinema-cta-bundle { display: flex; gap: 20px; }

.buy-neon-btn {
    background: #f97316;
    color: #fff;
    padding: 18px 35px;
    border-radius: 18px;
    font-weight: 900;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: 0.3s;
    box-shadow: 0 15px 35px rgba(249, 115, 22, 0.4);
}
.buy-neon-btn:hover { background: #fff; color: #000; transform: translateY(-5px); box-shadow: 0 20px 45px rgba(255,255,255,0.2); }

.watch-pure-btn {
    border: 1px solid rgba(255,255,255,0.1);
    color: #fff;
    padding: 18px 30px;
    border-radius: 18px;
    font-weight: 800;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: 0.3s;
}
.watch-pure-btn:hover { background: rgba(255,255,255,0.05); border-color: #fff; transform: translateY(-3px); }

.cinema-footer-minimal {
    margin-top: 40px;
    padding-top: 25px;
    border-top: 1px solid rgba(255,255,255,0.05);
    text-align: center;
}
.cinema-footer-minimal a { color: rgba(255,255,255,0.4); text-decoration: none; font-weight: 700; font-size: 14px; transition: 0.3s; }
.cinema-footer-minimal a:hover { color: #f97316; letter-spacing: 1px; }

@keyframes pulse-neon-cin {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(2.5); opacity: 0; }
}

/* Mobile Cinema Layout */
@media (max-width: 992px) {
    .next-level-cinema { padding: 10px 0 40px 0; margin-top: 0; }
    .cinema-section-head { text-align: center; margin-bottom: 30px; padding: 0 20px; }
    .cinema-major-title { font-size: 26px; }
    .cinema-major-sub { font-size: 14px; }
    .cinema-grid-modern { grid-template-columns: 1fr; gap: 30px; }
    .cinema-mega-title { font-size: 28px; line-height: 1.2; }
    .cinema-main-wrap { padding: 0 15px; }
    .cinema-text-side { text-align: center; display: flex; flex-direction: column; align-items: center; }
    .cinema-mega-desc { margin: 0 auto 35px; }
    .cinema-cta-bundle { flex-direction: column; gap: 14px; width: 82%; max-width: 100%; margin: 0 auto; padding: 20px; align-items: center; box-sizing: border-box; }
    .buy-neon-btn, .watch-pure-btn { 
        width: 100%; 
        justify-content: center; 
        padding: 16px; 
        font-size: 15px; 
        border-radius: 16px; /* Super smooth corners */
    }
    .watch-pure-btn { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); }
    .video-reflection { display: none; }
}
</style>

<!-- PREMIUM DIGITAL PRODUCT SHOWCASE -->
<section class="premium-digital-assets">
  <?php
  mysqli_data_seek($q, 0); // Reset pointer for safety if needed
  $q = mysqli_query($conn,"SELECT * FROM digital_products WHERE status='active' ORDER BY id DESC LIMIT 1");
  while($row = mysqli_fetch_assoc($q)){
  ?>
  <div class="digital-master-card">
    <div class="digital-grid-wrap">
        
        <!-- Product Mockup Side -->
        <div class="digital-visual-side">
            <div class="digital-image-glow">
                <img loading="lazy" src="uploads/digital_products/<?php echo $row['image']; ?>" 
                     alt="<?php echo htmlspecialchars($row['title']); ?>" width="500" height="300" loading="lazy">
            </div>
            <div class="digital-floating-tag"><i class="fas fa-bolt"></i> BEST SELLER</div>
        </div>

        <!-- Product Content Side -->
        <div class="digital-details-side">
            <div class="digital-label-row">
                <span class="type-badge">DIGITAL ASSET</span>
                <span class="access-badge">INSTANT ACCESS</span>
            </div>

            <h2 class="digital-title"><?php echo htmlspecialchars($row['title']); ?></h2>
            <p class="digital-description">
                High-performance blueprints, field-tested systems, and premium toolkits designed only for those who take their craft seriously.
            </p>

            <div class="digital-features-list">
                <div class="feat-pill"><i class="fas fa-history"></i> Lifetime Access</div>
                <div class="feat-pill"><i class="fas fa-file-pdf"></i> PDF & Tools</div>
                <div class="feat-pill"><i class="fas fa-headset"></i> Expert Support</div>
            </div>

            <div class="digital-purchase-stack">
                <div class="digital-price-box">
                    <span class="val-label">EXCLUSIVE PRICE</span>
                    <span class="val-amount">₹<?php echo $row['price']; ?></span>
                </div>
                <div class="digital-action-btns">
                    <a href="/digital-product/<?php echo $row['slug']; ?>" class="prime-details-btn">Full Details <i class="fas fa-chevron-right"></i></a>
                    <a href="/checkout?id=<?php echo $row['id']; ?>&type=digital" class="prime-buy-btn">Unlock Now <i class="fas fa-lock-open"></i></a>
                </div>
            </div>
        </div>

    </div>
  </div>
  <?php } ?>

  <div class="digital-explore-footer">
    <a href="/digital-products">View All Premium Guides <i class="fas fa-arrow-right"></i></a>
  </div>
</section>

<style>
/* ============================================
   PREMIUM DIGITAL ASSETS - MODERN UI
   ============================================ */
.premium-digital-assets { padding: 40px 0 80px 0; max-width: 1200px; margin: auto; padding: 0 20px; }

.digital-master-card {
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 60px;
    box-shadow: 0 40px 100px rgba(0,0,0,0.5);
    overflow: hidden;
    position: relative;
    border: 1px solid rgba(249, 115, 22, 0.1);
}

.digital-grid-wrap { display: flex; align-items: center; gap: 60px; }

.digital-visual-side { flex: 0.8; position: relative; }
.digital-image-glow { 
    border-radius: 20px; overflow: hidden; background: #000;
    box-shadow: 0 30px 60px rgba(0,0,0,0.8); border: 1px solid rgba(255,255,255,0.1);
    transform: perspective(1000px) rotateY(-5deg); transition: 0.5s;
}
.digital-image-glow img { width: 100%; height: auto; display: block; opacity: 0.9; }

.digital-floating-tag {
    position: absolute; bottom: -15px; right: -15px;
    background: #f97316; color: #fff; padding: 10px 20px;
    border-radius: 12px; font-weight: 800; font-size: 11px;
    box-shadow: 0 10px 20px rgba(249, 115, 22, 0.4);
}

.digital-details-side { flex: 1.2; }
.digital-label-row { display: flex; gap: 10px; margin-bottom: 25px; }
.type-badge { color: #f97316; border: 1px solid rgba(249, 115, 22, 0.3); padding: 5px 15px; border-radius: 100px; font-size: 10px; font-weight: 900; letter-spacing: 1px; }
.access-badge { background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 5px 15px; border-radius: 100px; font-size: 10px; font-weight: 900; }

.digital-title { font-size: 42px; color: #fff; font-weight: 900; margin-bottom: 20px; line-height: 1.1; }
.digital-description { color: #94a3b8; font-size: 17px; line-height: 1.7; margin-bottom: 35px; }

.digital-features-list { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 45px; }
.feat-pill { background: rgba(255,255,255,0.03); color: #fff; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,0.05); }
.feat-pill i { color: #f97316; }

.digital-purchase-stack { display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 35px; }
.digital-price-box { display: flex; flex-direction: column; }
.val-label { font-size: 10px; color: #94a3b8; font-weight: 800; }
.val-amount { font-size: 28px; color: #fff; font-weight: 900; }

.digital-action-btns { display: flex; gap: 15px; }
.prime-details-btn { border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 15px 25px; border-radius: 15px; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 10px; transition: 0.3s; font-size: 14px; }
.prime-details-btn:hover { background: rgba(255,255,255,0.05); border-color: #fff; }

.prime-buy-btn { background: #f97316; color: #fff; padding: 15px 30px; border-radius: 15px; font-weight: 900; text-decoration: none; display: flex; align-items: center; gap: 10px; transition: 0.3s; font-size: 14px; box-shadow: 0 10px 25px rgba(249, 115, 22, 0.4); }
.prime-buy-btn:hover { background: #fff; color: #000; box-shadow: 0 15px 35px rgba(255,255,255,0.2); }

.digital-explore-footer { text-align: center; margin-top: 40px; }
.digital-explore-footer a { color: #94a3b8; text-decoration: none; font-weight: 700; font-size: 14px; transition: 0.3s; }
.digital-explore-footer a:hover { color: #f97316; letter-spacing: 1px; }

@media (max-width: 992px) {
    .digital-master-card { padding: 40px 20px; }
    .digital-grid-wrap { flex-direction: column; text-align: center; gap: 40px; }
    .digital-label-row, .digital-features-list, .digital-action-btns { justify-content: center; }
    .digital-purchase-stack { flex-direction: column; gap: 30px; }
    .digital-title { font-size: 30px; }
    .digital-description { font-size: 15px; }
    .digital-image-glow { transform: none; max-width: 300px; margin: auto; }
}
</style>

<!-- HYBRID COLLABORATION SECTION (Desktop Grid / Mobile Slider) -->
<section class="collaboration-hybrid-section">
  
  <!-- DESKTOP VERSION (Premium Agency Bento Style) -->
  <div class="collab-desktop-wrap">
    <div class="collaboration-container">
      
      <!-- Partner Stats Ticker -->
      <div class="partner-ticker-wrap">
        <div class="ticker-item"><i class="fas fa-check-circle"></i> 150+ Trusted Brands</div>
        <div class="ticker-divider"></div>
        <div class="ticker-item"><i class="fas fa-chart-line"></i> 2.5M+ Monthly Impressions</div>
        <div class="ticker-divider"></div>
        <div class="ticker-item"><i class="fas fa-users"></i> 500K+ Active Shoppers</div>
      </div>

      <div class="collab-header-v2">
         <span class="collab-badge-v2">PARTNERSHIP PROGRAM 2024</span>
         <h2 class="collab-title-v2">Scale Your Brand With <span class="accent">MensHub Prime</span></h2>
         <p class="collab-subtitle-v2">We don't just promote; we build viral success stories. Join the elite network of brands winning the Indian market.</p>
      </div>
      
      <div class="collab-bento-grid">
        <!-- Main Feature Card -->
        <div class="bento-card card-large">
          <div class="bento-image">
            <img loading="lazy" src="assets/images/brand1.png.jpeg" alt="Product Promotion">
            <div class="glass-overlay">
               <h3>Product Blitz Promotion</h3>
               <p>Dominate the headlines. High-retention video features and premium blog placements that convert.</p>
               <ul class="benefit-list">
                 <li><i class="fas fa-bolt"></i> Instant Visibility</li>
                 <li><i class="fas fa-bullseye"></i> Targeted Reach</li>
               </ul>
            </div>
          </div>
        </div>

        <!-- Side Cards Grid -->
        <div class="bento-side-col">
          <div class="bento-card card-small">
            <div class="tile-content">
              <div class="tile-icon-v2"><i class="fas fa-users-viewfinder"></i></div>
              <h3>Influencer Network</h3>
              <p>Viral reach across Instagram, YouTube, and Telegram.</p>
            </div>
          </div>

          <div class="bento-card card-small purple-glow">
            <div class="tile-content">
              <div class="tile-icon-v2"><i class="fas fa-handshake-angle"></i></div>
              <h3>Affiliate Growth</h3>
              <p>Performance-based sales that scale with your growth.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="collab-action-v2">
         <div class="cta-group">
            <a href="/collaboration" class="main-partner-btn">
               Start Your Journey <i class="fas fa-chevron-right"></i>
            </a>
            <span class="cta-hint">Response time: < 4 hours</span>
         </div>
      </div>
    </div>
  </div>

  <!-- MOBILE VERSION (New App Dashboard Style) -->
  <div class="collab-mobile-wrap">
    <div class="collab-app-header">
       <div class="app-status-row">
         <span class="status-chip"><i class="fas fa-circle"></i> SYSTEM ONLINE</span>
         <span class="time-chip">Updated 2m ago</span>
       </div>
       <h2 class="app-title-glass">Work With <span class="accent">MensHub Prime</span></h2>
       <p class="app-sub-glass">Select a channel to start growing.</p>
    </div>
    
    <div class="app-dashboard-grid">
      <div class="dash-tile">
        <a href="/collaboration">
          <div class="tile-icon icon-orange"><i class="fas fa-bullhorn"></i></div>
          <h3>Product Promo</h3>
          <p class="tile-desc">Viral features in deal grids.</p>
          <span class="tile-stat">HIGH ROI</span>
        </a>
      </div>

      <div class="dash-tile">
        <a href="/collaboration">
          <div class="tile-icon icon-blue"><i class="fas fa-users"></i></div>
          <h3>Influencer Ads</h3>
          <p class="tile-desc">Blast to 1M+ active buyers.</p>
          <span class="tile-stat">VIRAL BOOT</span>
        </a>
      </div>

      <div class="dash-tile">
        <a href="/collaboration">
          <div class="tile-icon icon-purple"><i class="fas fa-handshake"></i></div>
          <h3>Affiliate Network</h3>
          <p class="tile-desc">Passive recurring sales.</p>
          <span class="tile-stat">RECURRING</span>
        </a>
      </div>

      <div class="dash-tile">
        <a href="/contact">
          <div class="tile-icon icon-green pulse-soft"><i class="fas fa-headset"></i></div>
          <h3>Partner Support</h3>
          <p class="tile-desc">Direct chat with our team.</p>
          <span class="tile-stat">LIVE NOW</span>
        </a>
      </div>
    </div>

    <!-- App Bottom Action -->
    <div class="app-quick-cta">
       <button class="dash-main-btn" onclick="location.href='/collaboration'">
          Apply for Brand Partnership <i class="fas fa-arrow-right"></i>
       </button>
    </div>
  </div>

</section>

<style>
/* ============================================
   HYBRID COLLABORATION STYLES (v3 Premium Agency)
   ============================================ */
.collaboration-hybrid-section { padding: 100px 0; background: #020617; position: relative; overflow: hidden; }

/* DESKTOP PREMIUM STYLE */
.collab-mobile-wrap { display: none; }
.collaboration-container { max-width: 1200px; margin: auto; padding: 0 40px; }

/* Stats Ticker */
.partner-ticker-wrap { display: flex; align-items: center; justify-content: center; gap: 30px; margin-bottom: 50px; background: rgba(255,255,255,0.03); padding: 15px 30px; border-radius: 100px; border: 1px solid rgba(255,255,255,0.05); width: max-content; margin-left: auto; margin-right: auto; }
.ticker-item { font-size: 13px; font-weight: 700; color: #94a3b8; display: flex; align-items: center; gap: 8px; }
.ticker-item i { color: #f97316; font-size: 14px; }
.ticker-divider { width: 4px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 50%; }

.collab-header-v2 { text-align: center; margin-bottom: 70px; }
.collab-badge-v2 { font-size: 11px; font-weight: 800; color: #f97316; letter-spacing: 3px; background: rgba(249,115,22,0.1); padding: 8px 20px; border-radius: 50px; margin-bottom: 25px; display: inline-block; }
.collab-title-v2 { font-size: 52px; font-weight: 950; color: #fff; line-height: 1.1; margin-bottom: 20px; }
.collab-title-v2 .accent { color: #f97316; }
.collab-subtitle-v2 { color: #94a3b8; font-size: 19px; max-width: 750px; margin: 0 auto; line-height: 1.7; font-weight: 500; }

/* Bento Grid */
.collab-bento-grid { display: grid; grid-template-columns: 7fr 4fr; gap: 25px; margin-bottom: 60px; }

.bento-card { background: rgba(15,23,42,0.4); border: 1px solid rgba(255,255,255,0.06); border-radius: 40px; overflow: hidden; position: relative; transition: 0.5s cubic-bezier(0.2, 0.8, 0.2, 1); }
.bento-card:hover { transform: translateY(-5px); border-color: rgba(249,115,22,0.3); box-shadow: 0 30px 60px rgba(0,0,0,0.5); }

.card-large .bento-image { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: #020617; overflow: hidden; }
.card-large .bento-image img { position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); width: 95%; height: 75%; object-fit: contain; transition: 0.6s; z-index: 12; }
.card-large { height: 100%; min-height: 550px; }
.card-large:hover .bento-image img { transform: translate(-50%, -50%) scale(1.08); }

.glass-overlay { position: absolute; bottom: 0; left: 0; right: 0; padding: 40px; background: linear-gradient(to top, rgba(2,6,23,0.95), rgba(2,6,23,0.5)); backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px); color: #fff; z-index: 10; border-top: 1px solid rgba(255,255,255,0.1); }
.glass-overlay h3 { font-size: 28px; font-weight: 800; margin-bottom: 15px; color: #fff; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
.glass-overlay p { color: #cbd5e1; font-size: 16px; margin-bottom: 20px; max-width: 500px; line-height: 1.5; }
.benefit-list { list-style: none; padding: 0; display: flex; gap: 20px; margin: 0; z-index: 11; }
.benefit-list li { font-size: 13px; font-weight: 700; color: #f97316; display: flex; align-items: center; gap: 8px; background: rgba(249,115,22,0.1); padding: 6px 15px; border-radius: 50px; }

.bento-side-col { display: flex; flex-direction: column; gap: 25px; }
.card-small { flex: 1; padding: 40px; display: flex; align-items: center; justify-content: center; background: rgba(15,23,42,0.6); }
.tile-content { text-align: center; }
.tile-icon-v2 { width: 65px; height: 65px; background: rgba(249,115,22,0.1); color: #f97316; font-size: 24px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; transition: 0.4s; }
.card-small:hover .tile-icon-v2 { transform: rotate(10deg) scale(1.1); background: #f97316; color: #fff; }
.card-small h3 { font-size: 22px; color: #fff; font-weight: 800; margin-bottom: 12px; }
.card-small p { color: #94a3b8; font-size: 14px; line-height: 1.6; }
.purple-glow .tile-icon-v2 { background: rgba(168,85,247,0.1); color: #a855f7; }
.purple-glow:hover .tile-icon-v2 { background: #a855f7; color: #fff; }

.collab-action-v2 { text-align: center; }
.main-partner-btn { display: inline-flex; align-items: center; gap: 15px; background: #f97316; color: #fff; padding: 22px 60px; border-radius: 25px; font-weight: 900; font-size: 18px; text-decoration: none; box-shadow: 0 20px 40px rgba(249,115,22,0.3); transition: 0.3s; }
.main-partner-btn:hover { transform: translateY(-3px); box-shadow: 0 25px 50px rgba(249,115,22,0.4); }
.cta-hint { display: block; margin-top: 15px; color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

/* MOBILE STYLES (NEW APP DASHBOARD 2x2) */
@media (max-width: 768px) {
    .collaboration-hybrid-section { padding: 40px 0; background: #020617; }
    .collab-desktop-wrap { display: none; }
    .collab-mobile-wrap { display: block; padding: 0 20px; }
    
    .collab-app-header { margin-bottom: 25px; }
    .app-status-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
    .status-chip { font-size: 8px; font-weight: 800; color: #22c55e; background: rgba(34, 197, 94, 0.1); padding: 4px 10px; border-radius: 100px; display: flex; align-items: center; gap: 5px; border: 1px solid rgba(34, 197, 94, 0.1); }
    .status-chip i { font-size: 6px; animation: blink 2s infinite; }
    @keyframes blink { 0% { opacity: 1; } 50% { opacity: 0.3; } 100% { opacity: 1; } }
    .time-chip { font-size: 8px; font-weight: 600; color: #94a3b8; }
    
    .app-title-glass { font-size: 26px; font-weight: 950; color: #fff; line-height: 1.1; margin-bottom: 8px; }
    .app-title-glass .accent { color: #f97316; }
    .app-sub-glass { font-size: 13px; color: #94a3b8; font-weight: 500; }

    .app-dashboard-grid { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 15px; 
    }

    .dash-tile {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 28px;
        padding: 25px 15px;
        transition: 0.3s;
        text-align: center;
    }
    .dash-tile:active { transform: scale(0.95); background: rgba(15, 23, 42, 0.9); }
    .dash-tile a { text-decoration: none; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; }
    
    .tile-icon { width: 50px; height: 50px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px; }
    .icon-orange { background: rgba(249, 115, 22, 0.15); color: #f97316; box-shadow: 0 5px 15px rgba(249, 115, 22, 0.1); }
    .icon-blue { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .icon-purple { background: rgba(168, 85, 247, 0.15); color: #a855f7; }
    .icon-green { background: rgba(34, 197, 94, 0.15); color: #22c55e; }

    .dash-tile h3 { font-size: 14px; font-weight: 800; color: #fff; line-height: 1.3; margin: 0 0 6px 0; }
    .tile-desc { font-size: 11px; color: #94a3b8; font-weight: 500; margin-bottom: 12px; line-height: 1.3; }
    .tile-stat { font-size: 9px; font-weight: 800; color: #f97316; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; }

    .app-quick-cta { margin-top: 25px; }
    .dash-main-btn { width: 100%; background: #f97316; color: #fff; border: none; padding: 18px; border-radius: 20px; font-weight: 900; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3); }
}
</style>

<script>
// Dashboard interaction logic
document.addEventListener('DOMContentLoaded', () => {
    // Analytics or haptics for dashboard tiles can go here
});
</script>

<div class="featured-ad ">
  <h3>🎯 Featured Deal</h3>
  <p>Top Brands • Extra Cashback • Limited Time</p>
  <a href="/telegram" class="ad-btn">View Offer</a>
</div>

<section class="why-section ">
<div class="why-container">

<h2>Why Choose <span>MEN'S HUB </span>PRIME?</h2>

<div class="why-grid">

<div class="why-card">
<div class="why-icon">🔥</div>
<h3>Best Offers</h3>
<p>Daily best deals with heavy discounts</p>
</div>

<div class="why-card">
<div class="why-icon">✔</div>
<h3>100% Genuine</h3>
<p>Only trusted & verified products</p>
</div>

<div class="why-card">
<div class="why-icon">⚡</div>
<h3>Daily Updates</h3>
<p>Fresh deals updated every day</p>
</div>

<div class="why-card">
<div class="why-icon">⭐</div>
<h3>Trusted Reviews</h3>
<p>Real user reviews & ratings</p>
</div>

</div>

</div>
</section>

<section class="affiliate-wrap ">
<div class="affiliate-box">

<h2>OUR AFFILIATE PROGRAM</h2>

<div class="brand-row">

<a href="https://www.amazon.in/" aria-label="Shop on Amazon"><img loading="lazy" src="assets/images/amazon.png" alt="Amazon India Deals"></a>
<a href="https://www.meesho.com/" aria-label="Shop on Meesho"><img loading="lazy" src="assets/images/meesho.png" alt="Meesho Shopping Deals"></a>
<a href="https://www.myntra.com/" aria-label="Shop on Myntra"><img loading="lazy" src="assets/images/myntra.png" alt="Myntra Fashion Deals"></a>
<a href="https://www.ajio.com/" aria-label="Shop on AJIO"><img loading="lazy" src="assets/images/ajio.png" alt="AJIO Lifestyle Deals"></a>
<a href="https://www.flipkart.com/" aria-label="Shop on Flipkart"><img loading="lazy" src="assets/images/flipkart.png" alt="Flipkart Best Offers"></a>

</div>

</div>
</section>


<section class="work-section-premium">
  <div class="work-container">
    <div class="work-header reveal-up">
      <span class="work-badge">HOW IT WORKS</span>
      <h2 class="work-main-title">Experience <span class="prime-italic">MensHub Prime</span> in 3 Easy Steps</h2>
    </div>

    <!-- Desktop Grid (Preserved) -->
    <div class="work-modern-grid desktop-only">
      <div class="work-step-card reveal-up" style="--step-color: #f97316;">
        <div class="step-number-wrap">
          <span class="step-num">01</span>
          <div class="step-glow"></div>
        </div>
        <div class="step-content">
          <h3>Explore Deals</h3>
          <p>Discover hand-picked premium deals and daily trending offers curated specifically for men.</p>
        </div>
        <div class="step-connector"></div>
      </div>
      <div class="work-step-card reveal-up" style="--step-color: #3b82f6;">
        <div class="step-number-wrap">
          <span class="step-num">02</span>
          <div class="step-glow"></div>
        </div>
        <div class="step-content">
          <h3>Claim Your Rank</h3>
          <p>Select your favorite products and analyze price trends through our Prime-only dashboard.</p>
        </div>
        <div class="step-connector"></div>
      </div>
      <div class="work-step-card reveal-up" style="--step-color: #22c55e;">
        <div class="step-number-wrap">
          <span class="step-num">03</span>
          <div class="step-glow"></div>
        </div>
        <div class="step-content">
          <h3>Secure Checkout</h3>
          <p>Get redirected to trusted global retailers for a 100% safe and verified purchase experience.</p>
        </div>
      </div>
    </div>

    <!-- Mobile APP Style Slider -->
    <div class="work-mobile-app-wrap mobile-only">
      <div class="app-work-slider" id="appWorkSlider">
        <div class="app-work-card-mob" style="--step-color: #f97316;">
          <div class="app-step-num-mob">01</div>
          <h3>Explore Deals</h3>
          <p>Hand-picked premium deals curated for you.</p>
        </div>
        <div class="app-work-card-mob" style="--step-color: #3b82f6;">
          <div class="app-step-num-mob">02</div>
          <h3>Claim Your Rank</h3>
          <p>Analyze price trends through our dashboard.</p>
        </div>
        <div class="app-work-card-mob" style="--step-color: #22c55e;">
          <div class="app-step-num-mob">03</div>
          <h3>Secure Checkout</h3>
          <p>100% safe & verified purchase experience.</p>
        </div>
      </div>
      
      <!-- App Progress Bar -->
      <div class="app-work-progress">
        <div class="progress-track"><div class="progress-fill" id="appWorkProgress"></div></div>
      </div>
    </div>
  </div>
</section>

<section class="telegram-wrap">

<div class="telegram-box ">

<div class="tg-left">
<img loading="lazy" src="assets/images/telegram.png" width="70" height="70" alt="Telegram Deals">
</div>

<div class="tg-center">
<h2>Join Our Telegram Club!</h2>
<p>Get Exclusive Deals & Alerts!</p>
</div>

<div class="tg-right">
<a href="https://t.me/thezayanway" target="_blank" rel="noopener">Join</a>
</div>

</div>

</section>
<!-- BRAND STATEMENT -->
<section class="brand-wrap">
  <div class="brand-box">
    <h3>Built for <span>Smart Men</span></h3>
    <p>
      Men's Hub Prime curates the best deals for you —  
      so you don’t waste time searching.
    </p>
  </div>
</section>

<style>
/* ============================================
   WORK SECTION PREMIUM
   ============================================ */
.work-section-premium { padding: 100px 0; background: #020617; position: relative; overflow: hidden; }
.work-container { max-width: 1200px; margin: auto; padding: 0 20px; }

.work-header { text-align: center; margin-bottom: 70px; }
.work-badge { font-size: 11px; font-weight: 800; color: #f97316; letter-spacing: 3px; background: rgba(249,115,22,0.1); padding: 8px 18px; border-radius: 50px; }
.work-main-title { font-size: 42px; font-weight: 950; color: #fff; margin-top: 25px; line-height: 1.2; }
.work-main-title .prime-italic { font-style: italic; color: #f97316; font-family: 'Georgia', serif; }

.work-modern-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; position: relative; }

.work-step-card { background: rgba(15,23,42,0.4); border: 1px solid rgba(255,255,255,0.05); border-radius: 35px; padding: 50px 30px; text-align: center; position: relative; transition: 0.4s; }
.work-step-card:hover { transform: translateY(-10px); background: rgba(15,23,42,0.7); border-color: var(--step-color); box-shadow: 0 20px 50px rgba(0,0,0,0.5); }

.step-number-wrap { width: 80px; height: 80px; margin: 0 auto 30px; position: relative; display: flex; align-items: center; justify-content: center; }
.step-num { font-size: 28px; font-weight: 900; color: var(--step-color); z-index: 2; }
.step-glow { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: var(--step-color); border-radius: 50%; opacity: 0.1; filter: blur(15px); transition: 0.4s; }
.work-step-card:hover .step-glow { opacity: 0.3; transform: scale(1.2); }

.step-content h3 { font-size: 24px; color: #fff; font-weight: 800; margin-bottom: 15px; }
.step-content p { color: #94a3b8; font-size: 15px; line-height: 1.7; }

/* Desktop Connector Arrows */
@media (min-width: 769px) {
    .step-connector { position: absolute; top: 50%; right: -30px; z-index: 5; font-size: 20px; color: rgba(255,255,255,0.1); font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f054"; }
    .work-step-card:nth-child(1) .step-connector::after { content: "\f061"; font-family: "Font Awesome 5 Free"; font-weight: 900; }
    .work-step-card:nth-child(2) .step-connector::after { content: "\f061"; font-family: "Font Awesome 5 Free"; font-weight: 900; }
}

/* Responsive Toggles */
.desktop-only { display: grid; }
.mobile-only { display: none; }

@media (max-width: 768px) {
    .desktop-only { display: none; }
    .mobile-only { display: block; }
    
    .work-section-premium { padding: 50px 0; }
    .app-work-slider { display: flex; overflow-x: auto; gap: 15px; padding: 20px 0; scrollbar-width: none; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; }
    .app-work-slider::-webkit-scrollbar { display: none; }
    
    .app-work-card-mob { min-width: 85%; flex: 0 0 85%; background: rgba(15,23,42,0.6); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.06); border-radius: 32px; padding: 40px 25px; scroll-snap-align: center; text-align: center; border-bottom: 3px solid var(--step-color); transition: 0.3s; }
    .app-step-num-mob { font-size: 32px; font-weight: 950; color: var(--step-color); margin-bottom: 20px; text-shadow: 0 0 20px rgba(var(--step-color-rgb), 0.3); }
    .app-work-card-mob h3 { font-size: 22px; color: #fff; margin-bottom: 12px; font-weight: 800; }
    .app-work-card-mob p { color: #94a3b8; font-size: 14px; line-height: 1.6; margin: 0; }
    
    .app-work-progress { margin-top: 25px; display: flex; justify-content: center; }
    .progress-track { width: 80px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden; }
    .progress-fill { width: 33%; height: 100%; background: #f97316; transition: 0.2s cubic-bezier(0.2, 0.8, 0.2, 1); }
}
</style>

<script>
// Mobile Work Slider Progress Indicator
document.addEventListener('DOMContentLoaded', () => {
    const workSlider = document.getElementById('appWorkSlider');
    const workProgress = document.getElementById('appWorkProgress');
    if(workSlider && workProgress) {
        workSlider.addEventListener('scroll', () => {
            const scrollWidth = workSlider.scrollWidth - workSlider.clientWidth;
            const scrollPercent = (workSlider.scrollLeft / scrollWidth) * 100;
            workProgress.style.width = Math.max(33, scrollPercent) + '%';
        });
    }
});
</script>

<!-- REVEAL SCRIPT START -->

<script>
/* GLOBAL INTERSECTION OBSERVER FOR APP-LIKE SCROLL REVEALS */
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        threshold: 0.05,
        rootMargin: "0px 0px -50px 0px"
    };

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                // Once revealed, no need to observe anymore for performance
                revealObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Apply to all major sections
    const sections = document.querySelectorAll('section, .featured-ad, .telegram-wrap, .brand-wrap, .app-collab-container');
    sections.forEach(sec => {
        sec.classList.add('reveal-init');
        revealObserver.observe(sec);
    });
});
</script>

<style>
/* REVEAL ANIMATIONS */
.reveal-init {
    opacity: 0;
    transform: translateY(30px) scale(0.98);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: transform, opacity;
}

.reveal-init.revealed {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* Staggered delay for grid items if needed */
.revealed .cat-card, .revealed .app-collab-card {
    animation: fadeInUp 0.6s ease forwards;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
/* ABSOLUTE DESKTOP GAP KILLER */
@media (min-width: 769px) { 
    .hero { min-height: 99vh !important; }
    .brand-wrap, .telegram-wrap, .work-section-premium { margin-bottom: 0 !important; padding-bottom: 40px !important; }
    footer.footer { margin-top: 0 !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
    .footer-copy { margin-bottom: 0 !important; padding-bottom: 20px !important; }
}
html, body { background-color: #020617 !important; margin: 0 !important; padding: 0 !important; overflow-x: hidden; }
</style><?php include ROOT_PATH . '/includes/footer.php'; ?>
