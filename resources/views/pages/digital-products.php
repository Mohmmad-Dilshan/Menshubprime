<?php 
include ROOT_PATH . '/includes/header.php'; 
if(!isset($conn)) { include_once ROOT_PATH . '/config/db.php'; }
?>

<style>
/* ===== PREMIUM DIGITAL STOREFRONT SYSTEM ===== */
.digital-page {
  background: #020617;
  padding: 140px 20px 100px;
  color: white;
  position: relative;
  overflow: hidden;
}

/* Background Aura */
.digital-page::before {
  content: "";
  position: absolute;
  top: -100px;
  right: -100px;
  width: 600px;
  height: 600px;
  background: radial-gradient(circle, rgba(249, 115, 22, 0.08) 0%, transparent 70%);
  z-index: 0;
}

/* ===== HERO SECTION ===== */
.dp-hero {
  max-width: 1400px;
  margin: 0 auto 100px;
  display: grid;
  grid-template-columns: 1.2fr 0.8fr;
  gap: 60px;
  align-items: center;
  position: relative;
  z-index: 1;
}

.dp-hero h1 {
  font-size: clamp(42px, 6vw, 75px);
  font-weight: 950;
  line-height: 0.95;
  letter-spacing: -4px;
  margin-bottom: 30px;
  color: #fff;
}

.dp-hero h1 span {
  background: linear-gradient(135deg, #f97316, #fb923c);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.dp-hero p {
  color: #94a3b8;
  font-size: 20px;
  max-width: 600px;
  line-height: 1.5;
  margin-bottom: 40px;
}

.dp-hero-badges {
  display: flex;
  gap: 15px;
}

.dp-badge {
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.08);
  padding: 10px 20px;
  border-radius: 100px;
  font-size: 13px;
  font-weight: 800;
  color: #cbd5e1;
  display: flex;
  align-items: center;
  gap: 8px;
}
.dp-badge i { color: #f97316; }

.dp-hero-img {
  position: relative;
  display: flex;
  justify-content: flex-end;
}

.dp-hero-img img {
  width: 90%;
  border-radius: 40px;
  box-shadow: 0 50px 100px rgba(0,0,0,0.6);
  border: 1px solid rgba(255,255,255,0.1);
  transform: rotate(3deg);
  transition: 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.dp-hero-img:hover img { transform: rotate(0deg) scale(1.05); }

/* ===== PRODUCT GRID ===== */
.digital-grid {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
  gap: 40px;
  position: relative;
  z-index: 1;
}

.digital-card {
  position: relative;
  background: rgba(15, 23, 42, 0.6);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 35px;
  border: 1px solid rgba(255, 255, 255, 0.06);
  overflow: hidden;
  transition: 0.5s cubic-bezier(0.19, 1, 0.22, 1);
}

.digital-card:hover {
  transform: translateY(-15px);
  border-color: #f97316;
  background: rgba(15, 23, 42, 0.9);
  box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6), 0 0 20px rgba(249, 115, 22, 0.1);
}

.card-img-wrap {
  height: 250px;
  overflow: hidden;
  position: relative;
  background: #0f172a; /* Studio backdrop */
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 15px;
}

.digital-card img {
  width: 100%;
  height: 100%;
  object-fit: contain; /* Full visibility of book covers/mockups */
  filter: drop-shadow(0 15px 25px rgba(0,0,0,0.5));
  transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.digital-card:hover img { transform: translateY(-5px) scale(1.08); }

/* Glass Highlight Effect */
.card-img-wrap::after {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; height: 50%;
  background: linear-gradient(to bottom, rgba(255,255,255,0.05) 0%, transparent 100%);
  pointer-events: none;
}

.offer-badge {
    position: absolute; top: 15px; right: 15px;
    background: #f97316; color: #fff; padding: 6px 16px; border-radius: 100px;
    font-size: 11px; font-weight: 900; text-transform: uppercase; z-index: 10;
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}

.digital-body { padding: 30px; position: relative; z-index: 1; }
.digital-body h2 { font-size: 24px; font-weight: 900; margin-bottom: 15px; letter-spacing: -0.5px; }
.digital-body p { color: #94a3b8; font-size: 15px; line-height: 1.7; margin-bottom: 25px; }

.digital-price { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
.price-now { font-size: 32px; font-weight: 950; color: #f97316; }
.price-old { color: #64748b; font-size: 18px; text-decoration: line-through; }

.view-btn {
  width: 100%; height: 55px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1);
  border-radius: 18px; color: #fff; display: flex; align-items: center; justify-content: center;
  font-weight: 800; text-decoration: none; transition: 0.3s;
}
.digital-card:hover .view-btn { background: #f97316; color: #000; border-color: #f97316; }

/* Stretched Link */
.stretched-link::after { content: ""; position: absolute; inset: 0; z-index: 5; }

/* ===== RESPONSIVE ===== */
@media(max-width: 1180px) {
  .dp-hero { grid-template-columns: 1fr; text-align: center; gap: 40px; }
  .dp-hero p, .dp-hero-badges { justify-content: center; margin-left: auto; margin-right: auto; }
  .dp-hero-img { display: none; }
}

@media(max-width: 768px) {
  .digital-page { padding: 100px 12px 60px; }
  
  .dp-hero h1 { font-size: 38px; letter-spacing: -2px; }
  .dp-hero p { font-size: 16px; margin-bottom: 25px; }

  .digital-grid { 
    grid-template-columns: repeat(2, 1fr); 
    gap: 12px; 
  }

  .digital-card { 
    border-radius: 24px; 
  }

  .card-img-wrap { 
    height: 160px; 
    padding: 10px;
  }

  .offer-badge {
    top: 10px; right: 10px;
    padding: 3px 10px;
    font-size: 9px;
  }

  .digital-body { 
    padding: 15px; 
  }

  .digital-body h2 { 
    font-size: 14px; 
    margin-bottom: 8px; 
    line-height: 1.3;
    height: 36px;
    overflow: hidden;
  }

  .digital-body p { display: none; } /* Hide description on mobile for app look */

  .digital-price { 
    margin-bottom: 15px; 
    gap: 8px;
  }
  .price-now { font-size: 18px; }
  .price-old { font-size: 12px; }

  .view-btn {
    height: 38px;
    border-radius: 12px;
    font-size: 12px;
  }
}
</style>

<div class="digital-page">

<!-- ===== HERO ===== -->
<section class="dp-hero">
  <div>
    <h1>Premium <span>Digital Products</span><br>that actually work</h1>

    <p>
      No theory. No recycled PDFs.  
      Only proven systems, tools & guides  
      built to help you earn smarter.
    </p>

    <div class="dp-hero-badges">
      <div class="dp-badge"><i class="fas fa-check-circle"></i> Proven Systems</div>
      <div class="dp-badge"><i class="fas fa-briefcase"></i> Business Ready</div>
      <div class="dp-badge"><i class="fas fa-bolt"></i> Instant Access</div>
    </div>
  </div>

  <div class="dp-hero-img">
    <img src="assets/images/digital-hero.jpeg"  alt="Premium Digital Products">
  </div>
</section>

<!-- ===== PRODUCTS ===== -->
<section class="digital-grid">

<?php
$q = mysqli_query($conn,"
  SELECT * FROM digital_products 
  WHERE status='active' 
  ORDER BY id DESC
");

if(mysqli_num_rows($q)>0){
while($row=mysqli_fetch_assoc($q)){
?>

<div class="digital-card">

  <div class="card-img-wrap">
    <?php if(!empty($row['badge_text'])){ ?>
      <div class="offer-badge"><?= htmlspecialchars($row['badge_text']); ?></div>
    <?php } ?>
    <img loading="lazy" src="uploads/digital_products/<?= $row['image']; ?>" alt="<?= htmlspecialchars($row['title']); ?>">
  </div>

  <div class="digital-body">
    <h2><?= htmlspecialchars($row['title']); ?></h2>

    <p>
      <?= substr(strip_tags($row['description']),0,110); ?>...
    </p>

    <div class="digital-price">
      <span class="price-now">₹<?= trim($row['price']); ?></span>
      <?php if(!empty($row['old_price'])){ ?>
        <span class="price-old">₹<?= trim($row['old_price']); ?></span>
      <?php } ?>
    </div>

    <div class="digital-actions">
      <a href="/Menshubprime/digital-product/<?= $row['slug']; ?>" class="view-btn stretched-link">
        View Product <i class="fas fa-chevron-right" style="margin-left:8px; font-size:12px;"></i>
      </a>
    </div>
  </div>

</div>

<?php } } else { ?>

<p style="grid-column:1/-1;text-align:center;color:#94a3b8;">
No digital products available
</p>

<?php } ?>

</section>

</div>

<section class="brand-wrap">
  <div class="brand-box">
    <h3>Built for <span>Smart Men</span></h3>
    <p>
      MensHub Prime curates the best deals for you —  
      so you don’t waste time searching.
    </p>
  </div>
</section>
<section class="telegram-wrap">

<div class="telegram-box">

<div class="tg-left">
<img src="assets/images/telegram.png" alt="Telegram Logo">
</div>

<div class="tg-center">
<h2>Join Our Telegram Club!</h2>
<p>Get Exclusive Deals & Alerts!</p>
</div>

<div class="tg-right">
<a href="https://t.me/thezayanway" target="_blank">Join</a>
</div>

</div>

</section>

<hr>
<?php include ROOT_PATH . '/includes/footer.php'; ?>