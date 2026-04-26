<?php 
include ROOT_PATH . '/includes/header.php'; 
if(!isset($conn)) { include_once ROOT_PATH . '/config/db.php'; }
?>

<style>
/* ===== PREMIUM CINEMATIC GRID SYSTEM ===== */
.video-hero {
  background: #020617;
  padding: 140px 20px 80px;
  text-align: center;
  position: relative;
  overflow: hidden;
}

/* Bokeh Atmosphere */
.video-hero::after {
  content: "";
  position: absolute;
  top: -10%; left: 50%;
  transform: translateX(-50%);
  width: 600px;
  height: 400px;
  background: radial-gradient(circle, rgba(249, 115, 22, 0.1) 0%, transparent 70%);
  pointer-events: none;
}

.video-hero h1 {
  font-size: clamp(38px, 6vw, 70px);
  margin-bottom: 20px;
  background: linear-gradient(135deg, #fff, #94a3b8);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 950;
  letter-spacing: -4px;
}

.video-hero h1 span {
  color: #f97316;
  -webkit-text-fill-color: #f97316;
}

.video-hero p {
  font-size: 18px;
  color: #64748b;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
  font-weight: 500;
}

.video-wrapper {
  max-width: 1400px;
  margin: 60px auto;
  padding: 0 20px;
}

/* Premium Matrix */
.video-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  gap: 40px;
}

.video-item {
  position: relative;
  background: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 35px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.06);
  display: flex !important;
  flex-direction: column;
  transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
  display: none !important; /* Managed by JS */
}

.video-item.visible {
  display: flex !important;
  animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes slideUpFade {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

.video-item:hover {
  transform: translateY(-12px);
  border-color: #f97316;
  background: rgba(15, 23, 42, 0.8);
  box-shadow: 0 30px 60px rgba(0,0,0,0.6);
}

.video-media {
  width: 100%;
  height: 230px;
  position: relative;
  overflow: hidden;
  background: #000;
}

.video-media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 1s ease;
  opacity: 0.8;
}

.video-item:hover .video-media img { transform: scale(1.15); opacity: 1; }

.play-overlay {
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 70px; height: 70px;
  background: rgba(249, 115, 22, 0.9);
  border-radius: 50%;
  display: flex; justify-content: center; align-items: center;
  color: #fff; font-size: 22px;
  box-shadow: 0 0 30px rgba(249, 115, 22, 0.4);
  transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.play-overlay i { margin-left: 5px; }
.video-item:hover .play-overlay { transform: translate(-50%, -50%) scale(1.2) rotate(15deg); }

.video-info { padding: 30px; flex-grow: 1; display: flex; flex-direction: column; }
.video-info h2 { 
  font-size: 22px; 
  font-weight: 800; 
  color: #fff; 
  margin-bottom: 20px; 
  line-height: 1.4;
  height: 60px; /* Fixed height for 2 lines */
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

.video-btns {
  display: flex;
  gap: 12px;
  margin-top: auto;
}

.watch-btn {
  height: 50px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
  border-radius: 100px; color: #fff; font-weight: 800; display: flex; align-items: center; justify-content: center;
  text-decoration: none; transition: 0.3s; gap: 10px;
}

.video-item:hover .watch-btn { background: #f97316; color: #000; border-color: #f97316; }

/* Stretched Link */
.stretched-link::after { content: ""; position: absolute; inset: 0; z-index: 5; }

/* VIEW MORE */
.view-more-container { text-align: center; margin-top: 50px; }
.view-more-btn {
  background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1);
  padding: 16px 40px; border-radius: 100px; color: #fff; font-weight: 800; cursor: pointer;
  transition: 0.3s;
}
.view-more-btn:hover { background: #fff; color: #000; transform: scale(1.05); }

/* MOBILE REFINEMENTS */
@media(max-width: 768px) {
  .video-hero { padding: 100px 15px 60px; }
  .video-list { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .video-item { border-radius: 24px; }
  .video-media { height: 130px; }
  .video-info { padding: 15px; }
  .video-info h2 { font-size: 14px; height: 40px; overflow: hidden; }
  .video-info p { display: none; }
  .watch-btn { font-size: 12px; height: 38px; }
  .play-overlay { width: 45px; height: 45px; font-size: 14px; }
}
</style>

<!-- HERO -->
<div class="video-hero">
  <h1>🔥 Viral <span>Product Reviews</span></h1>
  <p>Watch trending products, honest demos & smart shopping reviews</p>
</div>

<div class="video-wrapper">

<div class="video-list" id="videoList">

<?php
$q = mysqli_query($conn,"SELECT * FROM videos WHERE status = 1 ORDER BY id DESC");
if(mysqli_num_rows($q) > 0){
while($v = mysqli_fetch_assoc($q)){
    $thumbUrl = "uploads/thumbs/" . $v['thumb'];
?>

<div class="video-item">
  <div class="video-media">
    <img loading="lazy" src="<?= $thumbUrl; ?>" alt="<?= htmlspecialchars($v['title']); ?>">
    <div class="play-overlay"><i class="fas fa-play"></i></div>
    <a href="/Menshubprime/video/<?=$v['slug'];?>" class="stretched-link"></a>
  </div>

  <div class="video-info">
    <h2><?= htmlspecialchars($v['title']); ?></h2>
    
    <div class="video-btns" style="position:relative; z-index:10;">
      <a href="/Menshubprime/video/<?=$v['slug'];?>" class="watch-btn" style="flex:1;">
        <i class="fas fa-play" style="font-size:10px;"></i> Watch
      </a>
      <?php if(!empty($v['buy_link'])): ?>
      <a href="<?= $v['buy_link']; ?>" class="watch-btn" target="_blank" style="flex:1; background:rgba(255,255,255,0.05); border-color:rgba(255,255,255,0.1);">
        <i class="fas fa-shopping-cart" style="font-size:10px;"></i> Deal
      </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php } } else { echo '<p style="grid-column:1/-1;text-align:center;color:#94a3b8;">No videos found.</p>'; } ?>

</div>

<!-- View More Button -->
<div class="view-more-container" id="viewMoreContainer" style="display:none;">
    <button class="view-more-btn" id="viewMoreBtn" onclick="loadMore()">Load More Reviews <i class="fas fa-arrow-down"></i></button>
</div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.video-item');
    const loadMoreBtn = document.getElementById('viewMoreContainer');
    let currentItems = 6;

    // Show initial items
    for(let i = 0; i < items.length; i++){
        if(i < currentItems){
            items[i].classList.add('visible');
        }
    }

    // Show load more button if needed
    if(items.length > currentItems){
        loadMoreBtn.style.display = 'block';
    }

    window.loadMore = function() {
        const list = document.getElementById('videoList');
        const btnContainer = document.getElementById('viewMoreContainer');
        
        // Show 2 Skeletons
        let skeletons = [];
        for(let i=0; i<2; i++){
            let s = document.createElement('div');
            s.className = 'video-item visible skeleton-container';
            s.innerHTML = `
                <div class="skeleton" style="width:100%; height:230px; border-radius:35px 35px 0 0;"></div>
                <div style="padding:25px;">
                    <div class="skeleton" style="width:90%; height:18px; margin-bottom:12px;"></div>
                    <div class="skeleton" style="width:40%; height:14px;"></div>
                </div>
            `;
            list.appendChild(s);
            skeletons.push(s);
        }
        
        btnContainer.style.opacity = "0.5";

        setTimeout(() => {
            skeletons.forEach(s => s.remove());
            const nextItems = currentItems + 6;
            for(let i = currentItems; i < nextItems; i++) {
                if(items[i]) {
                    items[i].classList.add('visible');
                }
            }
            currentItems = nextItems;
            btnContainer.style.opacity = "1";
            if(currentItems >= items.length) {
                btnContainer.style.display = 'none';
            }
        }, 400);
    };
});
</script>

<!-- PROMO -->
<div class="video-promo">
  <div style="max-width:800px; margin:0 auto; padding:60px 20px; text-align:center;">
    <h2 style="font-size:32px; font-weight:900; color:#fff; margin-bottom:15px;">Promote Your Product With Us</h2>
    <p style="color:#94a3b8; font-size:18px; margin-bottom:30px;">Get featured in our viral video section and reach thousands of buyers</p>
    <a href="/Menshubprime/collaboration" style="display:inline-block; background:#f97316; padding:16px 40px; border-radius:100px; color:#000; font-weight:900; text-decoration:none;">Work With Us</a>
  </div>
</div>

<section class="telegram-wrap">
  <div class="telegram-box">
    <div class="tg-left">
      <img loading="lazy" decoding="async" src="assets/images/telegram.png" width="80" height="auto" alt="Telegram">
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

<?php include ROOT_PATH . '/includes/footer.php'; ?>