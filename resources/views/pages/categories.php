<?php
include ROOT_PATH . '/includes/header.php';

$q = mysqli_query($conn, "SELECT * FROM categories WHERE status='active' ORDER BY id DESC");
?>

<style>
/* HYBRID LAYOUT: PREMIUM CARDS (DESKTOP) + CIRCLES (MOBILE) */
.premium-hero-box {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.12), transparent 50%),
                radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.08), transparent 50%);
    text-align: center;
    position: relative;
    overflow: hidden;
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
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 25px;
}

.premium-hero-box h1 {
    font-size: clamp(40px, 7vw, 70px);
    font-weight: 950;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -3px;
    line-height: 0.9;
}

.p-container {
    padding: 70px 20px 120px;
    max-width: 1400px;
    margin: 0 auto;
}

/* DESKTOP GRID (CARDS) */
.cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 35px;
}

.p-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    overflow: hidden;
    transition: 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    position: relative;
    text-decoration: none;
    display: block;
}

.p-card:hover {
    transform: translateY(-15px) rotateX(2deg);
    border-color: rgba(249, 115, 22, 0.5);
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
}

.p-img-box {
    width: 100%;
    height: 240px;
    overflow: hidden;
}

.p-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.8s;
}

.p-card:hover .p-img-box img { transform: scale(1.1); }

.p-info {
    padding: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(to top, rgba(15, 23, 42, 0.9), transparent);
}

.p-name { color: #fff; font-size: 22px; font-weight: 950; letter-spacing: -1px; }

.p-arrow {
    width: 50px; height: 50px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #f97316; transition: 0.4s;
}

.p-card:hover .p-arrow {
    background: #f97316; color: #000;
    transform: rotate(-45deg);
}

/* MOBILE DESIGN (APP CIRCLES) */
@media (max-width: 768px) {
    .cat-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 30px 10px;
    }

    .p-card {
        background: transparent;
        border: none;
        backdrop-filter: none;
        box-shadow: none;
        text-align: center;
        overflow: visible;
    }

    .p-card:hover { transform: scale(1.1); }

    .p-img-box {
        width: 100px;
        height: 100px;
        margin: 0 auto 15px;
        border-radius: 50%;
        padding: 4px; /* Gap between image and border */
        border: 2px solid #f97316; /* Outer colored border (Orange) */
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5); /* Outer shadow (Blue) */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .p-img-box img {
        width: 100%; height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .p-info {
        background: none;
        padding: 0;
        display: block;
    }

    .p-name { font-size: 13px; font-weight: 800; }
    .p-arrow { display: none; }
    
    .premium-hero-box { padding: 120px 0 60px; }
}

@media (max-width: 480px) {
    .p-img-box { width: 85px; height: 85px; }
    .p-name { font-size: 12px; }
}

/* BUTTONS */
.p-load-wrap { text-align: center; margin-top: 80px; }
.p-btn {
    background: rgba(249, 115, 22, 0.1);
    border: 1px solid rgba(249, 115, 22, 0.3);
    color: #f97316; padding: 16px 45px; border-radius: 100px;
    font-weight: 800; cursor: pointer; transition: 0.3s;
}
.p-btn:hover { background: #f97316; color: #000; transform: scale(1.05); }

/* OFFERS AUTO-SLIDER */
.offers-section { max-width: 1400px; margin: 0 auto 60px; padding: 0 20px; }
.offers-title { color: #fff; font-size: 28px; font-weight: 900; margin-bottom: 25px; }
.offers-title span { color: #f97316; }
.offers-slider { position: relative; width: 100%; }
.offers-track { display: flex; gap: 20px; overflow-x: auto; scroll-snap-type: x mandatory; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none; }
.offers-track::-webkit-scrollbar { display: none; }
.offer-card { box-sizing: border-box; border-radius: 20px; padding: 30px; background-color: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.08); display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); scroll-snap-align: start; flex-shrink: 0; }
@media (min-width: 769px) { .offer-card { width: calc(50% - 12px); min-height: 180px; } }
@media (max-width: 768px) { .offer-card { width: 100%; padding: 25px 20px; border-radius: 15px; min-height: 150px; } .offer-card h4 { font-size: 20px !important; margin-bottom: 5px !important; } .offer-card p { font-size: 13px !important; margin-bottom: 15px !important; } .offers-section { padding: 0 15px; margin-bottom: 40px; } }
.offer-card * { z-index: 1; position: relative; }
.offer-card h4 { font-size: 26px; color: #fff; margin-bottom: 8px; font-weight: 900; letter-spacing: -0.5px; text-shadow: 0 2px 5px rgba(0,0,0,0.8); }
.offer-card p { color: #e2e8f0; font-size: 15px; margin-bottom: 20px; font-weight: 500; text-shadow: 0 2px 5px rgba(0,0,0,0.8); }
.o-btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #fff; color: #000; text-decoration: none; border-radius: 100px; font-size: 13px; font-weight: 800; width: max-content; transition: 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
.o-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(255,255,255,0.4); }
</style>

<div class="premium-hero-box">
    <div class="p-badge"><i class="fas fa-layer-group"></i> Smart Explorer</div>
    <h1>Shop by <span style="color:#f97316">Category</span></h1>
    <p>Premium collections curated specifically for the modern man's lifestyle.</p>
</div>

<div class="p-container">
    <div class="cat-grid" id="catContainer">
        <?php
        $i=0;
        if(mysqli_num_rows($q) > 0){
            while($row = mysqli_fetch_assoc($q)){
                $i++;
                ?>
                <a href="/Menshubprime/category/<?=$row['slug'];?>" class="p-card cat-item" style="<?=($i>12)?'display:none':'';?>">
                    <div class="p-img-box">
                        <img loading="lazy" src="assets/images/<?=$row['image'];?>" alt="<?=$row['name'];?>">
                    </div>
                    <div class="p-info">
                        <span class="p-name"><?=$row['name'];?></span>
                        <div class="p-arrow"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </a>
                <?php
            }
        } else {
            echo "<h3 style='color:#64748b;text-align:center;grid-column:1/-1;padding:60px 0;'>No active categories found.</h3>";
        }
        ?>
    </div>

    <?php if(mysqli_num_rows($q) > 12): ?>
    <div class="p-load-wrap">
        <button id="loadMoreBtn" class="p-btn">View More</button>
    </div>
    <?php endif; ?>
</div>

<?php
$set_q = mysqli_query($conn, "SELECT show_promotional_offers FROM settings LIMIT 1");
$opt = mysqli_fetch_assoc($set_q);
if(!isset($opt['show_promotional_offers']) || $opt['show_promotional_offers'] == 1):
    
    $offers_q = mysqli_query($conn, "SELECT * FROM promotional_offers WHERE status=1 ORDER BY id DESC");
    if(mysqli_num_rows($offers_q) > 0):
?>
<!-- AUTO SLIDING OFFERS SECTION -->
<div class="offers-section">
    <h3 class="offers-title">🔥 Trending <span>Offers</span></h3>
    <div class="offers-slider">
        <div class="offers-track" id="offersScrollTrack">
            <?php
            while($o = mysqli_fetch_assoc($offers_q)){
                $bg = !empty($o['banner_image']) ? "uploads/".$o['banner_image'] : "";
            ?>
            <div class="offer-card" style="background: url('<?=$bg;?>') center/cover; background-color: rgba(15, 23, 42, 0.8);">
                <?php if(!empty($o['title']) || !empty($o['subtitle']) || !empty($o['button_text'])): ?>
                    <!-- Dark overlay for readability when there is text -->
                    <div style="position:absolute; inset:0; background:linear-gradient(to right, rgba(15,23,42,0.9), rgba(15,23,42,0.5)); z-index:0;"></div>
                    
                    <?php if(!empty($o['title'])): ?>
                        <h4 style="position:relative; z-index:1;"><?=htmlspecialchars($o['title']);?></h4>
                    <?php endif; ?>
                    
                    <?php if(!empty($o['subtitle'])): ?>
                        <p style="position:relative; z-index:1;"><?=htmlspecialchars($o['subtitle']);?></p>
                    <?php endif; ?>
                    
                    <?php if(!empty($o['button_text'])): ?>
                        <a href="<?=htmlspecialchars($o['button_link']);?>" class="o-btn" style="position:relative; z-index:2;">
                            <?=htmlspecialchars($o['button_text']);?> <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(empty($o['button_text']) && !empty($o['button_link'])): ?>
                    <!-- Make the whole image clickable if there's no button but a link exists -->
                    <a href="<?=htmlspecialchars($o['button_link']);?>" style="position:absolute; inset:0; z-index:3;"></a>
                <?php endif; ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const track = document.getElementById('offersScrollTrack');
    if(!track) return;
    
    // Auto slide scroll-snap every 4.5 seconds
    setInterval(function(){
        let card = track.querySelector('.offer-card');
        if(!card) return;
        let cardWidth = card.offsetWidth + 20; // include gap
        
        // If reached the end, snap back to start smoothly
        if(track.scrollLeft + track.clientWidth >= track.scrollWidth - 10) {
            track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            track.scrollTo({ left: track.scrollLeft + cardWidth, behavior: 'smooth' });
        }
    }, 4500);
});
</script>
<?php endif; endif; ?>

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

<script>
let items = document.querySelectorAll(".cat-item");
let loadBtn = document.getElementById("loadMoreBtn");
let current = 12;

if(loadBtn) {
    loadBtn.onclick = function(){
        let loadCount = window.innerWidth <= 768 ? 6 : 8;
        for(let i=current; i<current+loadCount; i++){
            if(items[i]){
                // Use default flex for mobile (circles) and block for desktop (cards) managed by CSS
                items[i].style.display=""; 
            }
        }
        current += loadCount;
        if(current >= items.length){
            loadBtn.style.display="none";
        }
    }
}
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>