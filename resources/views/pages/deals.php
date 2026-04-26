<?php
// bootstrap removed
include ROOT_PATH . '/includes/header.php';

$uri_parts = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$end_part = end($uri_parts);
$cat = ($end_part !== 'deals') ? $end_part : ($_GET['cat'] ?? '');

$query_str = "SELECT deals.*, products.slug AS product_slug, products.title AS p_title, products.category AS p_cat 
              FROM deals 
              LEFT JOIN products ON deals.product_id = products.id 
              WHERE products.status='active'";
if($cat) $query_str .= " AND products.category='$cat'";
$query_str .= " ORDER BY deals.id DESC";

$q = mysqli_query($conn, $query_str);
$totalDeals = $q ? mysqli_num_rows($q) : 0;
?>

<style>
/* ============================================================
   MENS HUB PRIME - THE DEFINITIVE DEALS PAGE (V10)
   100% HOMEPAGE SYNC | NO CLIPPING | ULTRA PREMIUM
   ============================================================ */

:root {
    --mh-bg: #0b1220; /* EXACT HOMEPAGE BG */
    --mh-orange: #fb923c; /* EXACT HOMEPAGE ORANGE */
    --mh-glass: rgba(15, 23, 42, 0.4);
    --mh-border: rgba(255, 255, 255, 0.06);
}

#prime-deals-v10 {
    background: var(--mh-bg);
    color: #fff;
    font-family: Arial, sans-serif; /* MATCHING HOMEPAGE FONT */
    padding-bottom: 120px;
    overflow-x: hidden;
    width: 100%;
}

#prime-deals-v10 * { box-sizing: border-box; }

/* 1. HERO SECTION - EXACT HOMEPAGE MATCH */
.hero-v10 {
    padding: 120px 20px 60px;
    text-align: center;
    background: url('assets/images/hero.webp') no-repeat center/cover;
    position: relative;
    border-bottom: 1px solid var(--mh-border);
}

.hero-v10::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(11, 18, 32, 0.8), var(--mh-bg));
    z-index: 1;
}

.hero-content-v10 {
    position: relative;
    z-index: 2;
    max-width: 900px;
    margin: 0 auto;
}

/* EXACT HEADING STYLE FROM HOME.PHP */
.hero-content-v10 h1 {
    font-size: clamp(32px, 8vw, 56px);
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.1;
    color: #fff;
    text-transform: none;
}

.hero-content-v10 h1 strong {
    color: var(--mh-orange);
    font-style: normal;
}

.hero-content-v10 p {
    color: #cbd5e1;
    font-size: 18px;
    margin-bottom: 40px;
}

/* 2. CATEGORY NAV - HYBRID STYLE */
.cat-nav-v10 {
    display: flex;
    justify-content: center;
    gap: 12px;
    overflow-x: auto;
    padding: 10px 15px 30px;
    scrollbar-width: none;
    mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
}
.cat-nav-v10::-webkit-scrollbar { display: none; }

.cat-btn-v10 {
    white-space: nowrap;
    padding: 12px 28px;
    background: var(--mh-glass);
    border: 1px solid var(--mh-border);
    color: #fff;
    border-radius: 6px;
    font-weight: bold;
    font-size: 14px;
    text-decoration: none;
    transition: 0.3s;
}

.cat-btn-v10.active {
    background: var(--mh-orange);
    border-color: var(--mh-orange);
}

/* 3. PREMIUM SEARCH BAR */
.search-wrap-v10 {
    max-width: 550px;
    margin: 0 auto 50px;
    position: relative;
    padding: 0 15px;
}
.search-wrap-v10 input {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    padding: 18px 20px 18px 55px;
    color: #fff;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
}
.search-wrap-v10 input:focus {
    border-color: var(--mh-orange);
    background: rgba(255, 255, 255, 0.08);
}
.search-wrap-v10 i {
    position: absolute;
    left: 35px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--mh-orange);
    font-size: 20px;
}

/* 4. THE GRID & MASTER CARD - TOTAL CLEANUP */
.grid-v10 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

.card-v10 {
    background: linear-gradient(135deg, rgba(25, 33, 52, 0.4), rgba(15, 23, 42, 0.8)) !important;
    backdrop-filter: blur(25px) !important;
    -webkit-backdrop-filter: blur(25px) !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-radius: 20px !important;
    overflow: hidden;
    position: relative;
    display: flex;
    flex-direction: column;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    min-height: auto !important;
}
.card-v10:hover { transform: translateY(-8px); border-color: rgba(249, 115, 22, 0.4) !important; box-shadow: 0 15px 40px rgba(0,0,0,0.4); }

.img-box-v10 {
    position: relative;
    aspect-ratio: 1 / 1;
    width: 100%;
    overflow: hidden;
    background: #000;
}
.img-box-v10 img { width: 100%; height: 100%; object-fit: cover; transition: 0.6s ease; }
.card-v10:hover .img-box-v10 img { transform: scale(1.08); }

.info-v10 { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; }

.pro-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
.pro-rating { color: #fbbf24; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 4px; }
.pro-timer { color: #ef4444; font-size: 10px; font-weight: 900; }

.info-v10 h3 {
    font-size: 15px !important; font-weight: 800 !important; color: #fff !important;
    margin: 0 0 10px 0 !important; line-height: 1.4; min-height: 42px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}

.pro-price-area { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 12px; }
.now-v14 { font-size: 22px; font-weight: 900; color: #fb923c; }
.old-v14 { font-size: 12px; color: #64748b; text-decoration: line-through; margin-left: 5px; }

.save-pill-v14 {
    background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); 
    color: #22c55e; padding: 2px 8px; border-radius: 6px; font-size: 9px; font-weight: 900;
}

.strength-v14 { width: 100%; height: 2px; background: rgba(255,255,255,0.05); border-radius: 10px; margin-bottom: 15px; overflow: hidden; }
.strength-fill-v14 { height: 100%; background: linear-gradient(to right, #fb923c, #ef4444); }

.pro-btn-v14 {
    background: var(--mh-orange); color: #fff; padding: 12px; border-radius: 12px; font-weight: 800;
    text-align: center; text-decoration: none; font-size: 13px; text-transform: uppercase;
    display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.3s;
}
.pro-btn-v14:hover { filter: brightness(1.1); box-shadow: 0 5px 15px rgba(249, 115, 22, 0.3); }

@media (min-width: 1200px) { .grid-v10 { grid-template-columns: repeat(4, 1fr) !important; } }
@media (max-width: 1199px) { .grid-v10 { grid-template-columns: repeat(3, 1fr); gap: 20px; } }
@media (max-width: 768px) {
    .grid-v10 { grid-template-columns: repeat(2, 1fr) !important; gap: 10px; padding: 10px; }
    .card-v10 { border-radius: 16px !important; }
    .info-v10 { padding: 10px; }
    .info-v10 h3 { font-size: 13px !important; min-height: 36px; }
    .now-v14 { font-size: 18px; }
    .pro-btn-v14 { padding: 9px; font-size: 11px; }
    .hero-v10 { padding: 60px 15px 30px; }
}

/* ELITE ADDITIONS */
.pulse-bar-v14 { max-width: 1400px; margin: 25px auto 5px; padding: 0 20px; }
.pulse-inner-v14 {
    background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(15px); border: 1px solid rgba(251, 146, 60, 0.2);
    border-radius: 12px; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center;
}
.pulse-dot { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; display: inline-block; margin-right: 8px; box-shadow: 0 0 10px #22c55e; animation: pulsev14 1.5s infinite; }
@keyframes pulsev14 { 0% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.2); } 100% { opacity: 1; transform: scale(1); } }

.prime-choice-badge {
    position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(10px); border: 1px solid rgba(251, 146, 60, 0.3);
    color: #fb923c; padding: 4px 10px; border-radius: 6px; font-size: 9px; font-weight: 900;
    display: flex; align-items: center; gap: 5px; z-index: 5;
}

@media (max-width: 768px) {
    .pulse-bar-v14 { margin: 15px auto 5px; padding: 0 10px; }
    .pulse-inner-v14 { padding: 8px 12px; font-size: 11px; }
}

/* PREMIUM SKELETON LOADERS */
.skeleton-v14 {
    background: rgba(255,255,255,0.03); border-radius: 20px;
    height: 420px; position: relative; overflow: hidden;
    border: 1px solid rgba(255,255,255,0.05); display: none;
}
.skeleton-v14::after {
    content: ""; position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
    animation: shimmerV14 1.5s infinite;
}
@keyframes shimmerV14 { 100% { left: 100%; } }

.lazy-batch { height: 0; opacity: 0; padding: 0; margin: 0; overflow: hidden; pointer-events: none; }
.lazy-batch.revealed { height: auto; opacity: 1; padding: initial; margin: initial; overflow: visible; pointer-events: auto; transition: opacity 0.8s ease; }

#scrollSentinel { height: 50px; width: 100%; margin-top: 20px; }

</style>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<style>
/* SUCCESS DELIGHT UI */
#eliteToastv14 {
    position: fixed; top: 20px; left: 50%; transform: translateX(-50%) translateY(-100px);
    background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(20px); border: 1px solid #fb923c;
    color: #fff; padding: 12px 25px; border-radius: 50px; font-weight: 800; z-index: 10000;
    transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); display: flex; align-items: center; gap: 10px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5); font-size: 13px;
}
#eliteToastv14.active { transform: translateX(-50%) translateY(30px); }
</style>

<div id="prime-deals-v10">

    <!-- Success Toast -->
    <div id="eliteToastv14">
        <i class="fas fa-bolt" style="color:#fb923c;"></i> 
        <span>DEAL UNLOCKED! REDIRECTING...</span>
    </div>

    <section class="hero-v10">
        <div class="hero-content-v10">
            <h1>Smart <strong>Deals</strong><br>for <strong>Smart</strong> Men</h1>
            <p>Access the vault of premium flash sales, updated 24/7 for the prime community.</p>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 0 10px;">
                <span style="font-size: 14px; font-weight: 800; color: var(--mh-orange); text-transform: uppercase; letter-spacing: 1px;">Categories</span>
                <a href="/Menshubprime/categories" style="color: var(--mh-orange); font-size: 13px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 5px;">View All <i class="fas fa-chevron-right" style="font-size: 10px;"></i></a>
            </div>

            <div class="cat-nav-v10" id="catScrollv10">
                <a href="/Menshubprime/deals" class="cat-btn-v10 <?= empty($cat) ? 'active' : '' ?>" onclick="hapticv10()">All Deals</a>
                <?php
                $cats=mysqli_query($conn,"SELECT * FROM categories WHERE status='active' ORDER BY name ASC");
                while($c=mysqli_fetch_assoc($cats)){
                    $is_act = ($cat == $c['slug']) ? 'active' : '';
                    echo '<a href="/Menshubprime/deals/'.$c['slug'].'" class="cat-btn-v10 '.$is_act.'" onclick="hapticv10()">'.$c['name'].'</a>';
                }
                ?>
            </div>

            <div class="search-wrap-v10">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search brands or categories..." onkeyup="filterv10(this.value)">
            </div>
        </div>
    </section>

    <?php $total_deals = mysqli_num_rows($q); ?>
    <div class="pulse-bar-v14">
        <div class="pulse-inner-v14">
            <div style="color: #fff; display: flex; align-items: center; font-weight: 700;">
                <span class="pulse-dot"></span> <span id="dealCountv14"><?= $total_deals ?></span> Hot Deals Active
            </div>
            <div style="color: #64748b; font-size: 11px; font-weight: 800;">
                <i class="fas fa-sync-alt fa-spin" style="margin-right: 5px;"></i> RESET IN: <span id="resetTimerV14">04:22:15</span>
            </div>
        </div>
    </div>

    <div class="grid-v10" id="gridv10">
        <!-- Persistent No Results Message -->
        <div id="noResults" style="display:none; grid-column:1/-1; text-align:center; padding:80px 20px; color:#64748b;">
            <i class="fas fa-search fa-4x" style="opacity:0.2; margin-bottom:20px;"></i><br>
            <h2 style="color:#fff; font-size:24px; font-weight:900;">OOPS! NO DEALS MATCHED</h2>
            <p>Try searching for brands like Sneakers, Watches or grooming gear.</p>
        </div>
        <?php
        $idx = 0;
        while($row=mysqli_fetch_assoc($q)){
            $off=($row['old_price'] > 0) ? round((($row['old_price']-$row['price'])/$row['old_price'])*100) : 0;
            $save=$row['old_price']-$row['price'];
            $randT = (rand(1, 10) <= 2) ? rand(5, 15) : rand(3600, 86400); 
            $is_hidden = ($idx >= 8) ? 'lazy-batch' : 'revealed';
        ?>

        <div class="card-v10 <?= $is_hidden ?>" onclick="hapticv10()" data-idx="<?= $idx ?>">
            <div class="prime-choice-badge"><i class="fas fa-check-circle"></i> Prime Choice</div>

            <div class="img-box-v10">
                <a href="/Menshubprime/product/<?=$row['product_slug'];?>" style="height:100%; display:block;">
                    <img loading="lazy" src="assets/images/<?php echo $row['image']; ?>" alt="Prime Deal">
                </a>
                
                <!-- TOP RIGHT: EYE PEEK -->
                <button class="share-dot-v12" style="position:absolute; top:12px; right:12px; width:34px; height:34px; background:rgba(15,23,42,0.8); backdrop-filter:blur(10px); border-radius:50%; border:1px solid rgba(255,255,255,0.1); color:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer;" onclick="event.stopPropagation(); hapticv10(); window.openQuickPeek && window.openQuickPeek('<?=$row['product_slug'];?>');" aria-label="Peek">
                    <i class="fas fa-expand" style="font-size:11px;"></i>
                </button>

                <!-- BOTTOM LEFT: OFF BADGE -->
                <?php if($off > 0): ?>
                <div style="position:absolute; bottom:12px; left:12px; background:#ef4444; color:#fff; padding:4px 10px; border-radius:6px; font-size:10px; font-weight:950; z-index:5; box-shadow:0 4px 15px rgba(239, 68, 68, 0.4);">🔥 <?=$off;?>% OFF</div>
                <?php endif; ?>

                <!-- BOTTOM RIGHT: WHATSAPP -->
                <button class="share-dot-v12" style="position:absolute; bottom:12px; right:12px; width:34px; height:34px; background:rgba(15,23,42,0.8); backdrop-filter:blur(10px); border-radius:50%; border:1px solid rgba(255,255,255,0.1); color:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer;" onclick="event.stopPropagation(); shareV10('wa', '<?=$row['p_title'];?>', '<?=$row['product_slug'];?>')" aria-label="Share">
                    <i class="fab fa-whatsapp"></i>
                </button>
            </div>

            <div class="info-v10">
                <div class="pro-header">
                    <div class="pro-rating"><i class="fas fa-star"></i> 4.8</div>
                    <div class="pro-timer"><i class="fas fa-clock"></i> <span class="t-span" data-time="<?= $randT ?>">00:00:00</span></div>
                </div>

                <h3><a href="/Menshubprime/product/<?=$row['product_slug'];?>" style="color:inherit;text-decoration:none;"><?= htmlspecialchars($row['title']); ?></a></h3>
                
                <div class="pro-price-area">
                    <div class="price-tag">
                        <span class="now-v14">₹<?=$row['price'];?></span>
                        <?php if($save > 0): ?>
                        <span class="old-v14">₹<?=$row['old_price'];?></span>
                        <?php endif; ?>
                    </div>
                    <?php if($save > 0): ?>
                    <div class="save-pill-v14">SAVE ₹<?=$save;?></div>
                    <?php endif; ?>
                </div>

                <div class="strength-v14">
                    <div class="strength-fill-v14" style="width:<?= rand(75,95) ?>%;"></div>
                </div>

                <a href="/Menshubprime/product/<?=$row['product_slug'];?>" class="pro-btn-v14" onclick="event.preventDefault(); triggerSuccessV14(this.href)">
                    GRAB DEAL <i class="fas fa-bolt"></i>
                </a>
            </div>
        </div>

        <?php $idx++; } ?>
    </div>

    <!-- Skeletons Container -->
    <div class="grid-v10" id="skeletonGrid" style="display:none; margin-top:20px;">
        <div class="skeleton-v14" style="display:block;"></div>
        <div class="skeleton-v14" style="display:block;"></div>
        <div class="skeleton-v14" style="display:block;"></div>
        <div class="skeleton-v14" style="display:block;"></div>
    </div>

    <div id="scrollSentinel"></div>

</div>

<script>
function filterv10(v) {
    let q = v.toLowerCase();
    let cards = document.querySelectorAll(".card-v10");
    let found = 0;
    
    cards.forEach(c => {
        let t = c.querySelector('h3').innerText.toLowerCase();
        if(t.includes(q)) {
            c.style.display = "flex";
            found++;
        } else {
            c.style.display = "none";
        }
    });

    // Show/Hide No Results UI
    document.getElementById('noResults').style.display = (found === 0) ? "block" : "none";
}

function hapticv10() {
    if ("vibrate" in navigator) navigator.vibrate(10);
}

function triggerSuccessV14(url) {
    // 1. Triple Haptic Pulse
    if ("vibrate" in navigator) navigator.vibrate([100, 30, 100, 30, 100]);

    // 2. Confetti Burst
    confetti({
        particleCount: 150, spread: 70, origin: { y: 0.6 },
        colors: ['#fb923c', '#f97316', '#22c55e', '#ffffff']
    });

    // 3. Success Toast
    const toast = document.getElementById('eliteToastv14');
    toast.classList.add('active');

    // 4. Redirect
    setTimeout(() => { window.location.href = url; }, 1200);
}

function initCountv10() {
    // Pulse Reset Timer
    let resetTime = 15735; // ~4 hours in seconds
    let rt = document.getElementById('resetTimerV14');
    if(rt) {
        setInterval(() => {
            resetTime--;
            let h = Math.floor(resetTime / 3600);
            let m = Math.floor((resetTime % 3600) / 60);
            let s = resetTime % 60;
            rt.innerText = `${h.toString().padStart(2, "0")}:${m.toString().padStart(2, "0")}:${s.toString().padStart(2, "0")}`;
        }, 1000);
    }

    document.querySelectorAll('.card-v10').forEach(card => {
        let span = card.querySelector('.t-span');
        if(!span) return;
        let time = parseInt(span.getAttribute('data-time'));
        
        let itv = setInterval(() => {
            if(time <= 0) {
                clearInterval(itv);
                card.classList.add('expired');
                let btn = card.querySelector('.pro-btn-v14');
                if(btn) {
                    btn.style.background = "#475569";
                    btn.innerHTML = 'EXPIRED';
                }
            } else {  time--;
                let h = Math.floor(time / 3600);
                let m = Math.floor((time % 3600) / 60);
                let s = time % 60;
                span.innerText = `${h.toString().padStart(2, "0")}:${m.toString().padStart(2, "0")}:${s.toString().padStart(2, "0")}`;
            }
        }, 1000);
    });
}
window.addEventListener('load', initCountv10);

// Infinite Scroll / Skeleton Mock
const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if(e.isIntersecting) {
            const batch = document.querySelectorAll('.lazy-batch:not(.revealed)');
            if(batch.length > 0) {
                // Show Skeletons
                document.getElementById('skeletonGrid').style.display = 'grid';
                
                setTimeout(() => {
                    // Reveal real content (batch of 4)
                    for(let i=0; i<4; i++) {
                        if(batch[i]) batch[i].classList.add('revealed');
                    }
                    document.getElementById('skeletonGrid').style.display = 'none';
                }, 800);
            }
        }
    });
}, { threshold: 0.1 });

const sent = document.getElementById('scrollSentinel');
if(sent) obs.observe(sent);

// Scroll auto
window.addEventListener('DOMContentLoaded', () => {
    const act = document.querySelector('.cat-btn-v10.active');
    const b = document.getElementById('catScrollv10');
    if(act && b) b.scrollLeft = act.offsetLeft - (b.offsetWidth / 2) + (act.offsetWidth / 2);
});
</script>

<?php include 'includes/related-content.php'; ?>
<?php include ROOT_PATH . '/includes/footer.php'; ?>
