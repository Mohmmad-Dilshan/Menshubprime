<?php
include 'config/db.php';

if (isset($_GET['slug'])) {
    $slug = mysqli_real_escape_string($conn, $_GET['slug']);
    $q = mysqli_query($conn, "SELECT * FROM digital_products WHERE slug='$slug' AND status='active'");
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $q = mysqli_query($conn, "SELECT * FROM digital_products WHERE id=$id AND status='active'");
} else {
    header("Location: /Menshubprime/digital-products");
    exit();
}

$product = mysqli_fetch_assoc($q);

if(!$product){
    header("Location: /Menshubprime/digital-products");
    exit();
}
$id = $product['id'];

if (isset($_GET['id']) && !isset($_GET['slug'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /Menshubprime/digital-product/" . $product['slug']);
    exit();
}

// Set SEO Variables
$page_title = $product['title'] . " | MenHub Prime Digital Products";
$page_description = "Buy " . $product['title'] . " at best price ₹" . $product['price'] . ". Premium digital product.";
$og_image = "https://" . $_SERVER['HTTP_HOST'] . "/Menshubprime/uploads/digital_products/" . $product['image'];
$og_type = "product";

include ROOT_PATH . '/includes/header.php';
?>

<style>
/* Base Wrappers */
.digital-single-wrap {
  max-width: 1200px;
  margin: 50px auto;
  padding: 0 20px;
  color: #f8fafc;
}
.digital-grid {
  display: grid;
  grid-template-columns: 2.2fr 1fr;
  gap: 40px;
}

/* LEFT COLUMN */
.digital-media {
  background: linear-gradient(145deg, #0f172a, #020617);
  border-radius: 20px;
  padding: 25px;
  box-shadow: 0 25px 50px rgba(0,0,0,0.5);
  border: 1px solid rgba(255,255,255,0.05);
  display: flex;
  justify-content: center;
  position: relative;
  overflow: hidden;
}
.digital-media img {
  width: 100%;
  max-height: 480px;
  object-fit: contain;
  border-radius: 15px;
  transition: transform 0.5s ease;
}
.digital-media:hover img {
  transform: scale(1.02);
}
.overlay-preview-btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(15, 23, 42, 0.85);
  color: #fff;
  border: 1px solid rgba(255,255,255,0.2);
  padding: 14px 28px;
  border-radius: 30px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 10px;
  backdrop-filter: blur(8px);
  transition: all 0.3s;
  box-shadow: 0 10px 30px rgba(0,0,0,0.5);
  z-index: 10;
}
.overlay-preview-btn:hover {
  background: linear-gradient(135deg, #f97316, #ea580c);
  border-color: transparent;
  transform: translate(-50%, -50%) scale(1.05);
}
@media(max-width: 500px) {
  .overlay-preview-btn {
    padding: 10px 18px;
    font-size: 13px;
    border-radius: 20px;
    gap: 6px;
    white-space: nowrap;
  }
}

.inline-scroll-player {
  width: 100%;
  max-height: 480px;
  overflow-y: auto;
  overflow-x: hidden;
  box-sizing: border-box;
  display: none;
  flex-direction: column;
  gap: 15px;
  scrollbar-width: thin;
  scrollbar-color: #f97316 transparent;
  padding-right: 5px;
  -webkit-overflow-scrolling: touch;
  touch-action: pan-y;
}
.inline-scroll-player::-webkit-scrollbar { width: 6px; }
.inline-scroll-player::-webkit-scrollbar-thumb { background: #f97316; border-radius: 10px; }
.inline-preview-img {
  width: 100%;
  max-width: 100%;
  object-fit: contain;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.5);
  display: block;
}
.close-inline-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  background: rgba(15, 23, 42, 0.85);
  color: #fff;
  border: 1px solid rgba(255,255,255,0.2);
  width: 35px;
  height: 35px;
  border-radius: 50%;
  display: none;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 20;
}
.close-inline-btn:hover {
  background: #ef4444;
  border-color: transparent;
}
@keyframes bounceDownAnim {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(10px); }
}
@keyframes bounceUpAnim {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
.bounce-down-icon { animation: bounceDownAnim 1.5s infinite; }
.bounce-up-icon { animation: bounceUpAnim 1.5s infinite; }

.digital-content h1 {
  font-size: 32px;
  margin: 30px 0 15px;
  background: linear-gradient(135deg, #f97316, #22c55e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 800;
  line-height: 1.3;
}
.digital-desc {
  color: #cbd5e1;
  line-height: 1.8;
  font-size: 16px;
  margin-bottom: 30px;
}

/* Bento Sections */
.sections-bento {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}
.section-box {
  background: rgba(15, 23, 42, 0.6);
  padding: 25px;
  border-radius: 20px;
  border: 1px solid rgba(255,255,255,0.05);
  backdrop-filter: blur(10px);
}
.section-box.features {
  border-left: 4px solid #3b82f6;
}
.section-box.what-you-get {
  border-left: 4px solid #22c55e;
}

.section-box h2 {
  font-size: 18px;
  margin-bottom: 15px;
  color: #f8fafc;
  display: flex;
  align-items: center;
  gap: 8px;
}
.section-box ul {
  padding-left: 0;
  list-style: none;
}
.section-box li {
  margin-bottom: 10px;
  color: #cbd5e1;
  font-size: 15px;
  display: flex;
  align-items: flex-start;
  gap: 8px;
}
.section-box li::before {
  content: "✓";
  color: #22c55e;
  font-weight: bold;
}

/* RIGHT COLUMN (Sidebar) */
.digital-side {
  background: #0f172a;
  border-radius: 24px;
  padding: 30px;
  position: sticky;
  top: 90px;
  border: 1px solid rgba(255,255,255,0.05);
  box-shadow: 0 15px 40px rgba(0,0,0,0.4);
  height: fit-content;
}
.price-box {
  text-align: center;
  margin-bottom: 25px;
  padding-bottom: 25px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  position: relative;
}
.price {
  font-size: 42px;
  color: #22c55e;
  font-weight: 800;
  line-height: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
}
.price-old {
  font-size: 18px;
  color: #64748b;
  text-decoration: line-through;
  font-weight: 400;
}
.offer-badge-single {
  display: inline-block;
  background: #f97316;
  color: white;
  padding: 4px 15px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 800;
  margin-bottom: 15px;
  box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
}

.premium-action-bar {
  display: flex;
  flex-direction: column;
  gap: 15px;
}
.buy-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  background: linear-gradient(135deg, #f97316, #ea580c);
  padding: 16px;
  border-radius: 14px;
  color: #fff;
  font-size: 18px;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
  transition: all 0.3s ease;
}
.buy-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(249, 115, 22, 0.6);
}

.back-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  background: rgba(255,255,255,0.05);
  padding: 14px;
  border-radius: 12px;
  color: #e2e8f0;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s;
}
.back-btn:hover {
  background: rgba(255,255,255,0.1);
}

.share-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  background: rgba(56, 189, 248, 0.1);
  padding: 14px;
  border-radius: 12px;
  color: #38bdf8;
  border: 1px solid rgba(56, 189, 248, 0.2);
  font-weight: 600;
  transition: all 0.3s;
  cursor: pointer;
  width: 100%;
  font-size: 16px;
  text-decoration: none;
}
.share-btn:hover {
  background: rgba(56, 189, 248, 0.2);
  transform: translateY(-2px);
}

/* Related Items */
.digital-side h2 {
  font-size: 18px;
  margin: 25px 0 15px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.related-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.related-item {
  display: flex;
  gap: 12px;
  align-items: center;
  background: rgba(2, 6, 23, 0.4);
  padding: 8px;
  border-radius: 12px;
  transition: 0.3s;
  border: 1px solid rgba(255,255,255,0.02);
}
.related-item:hover {
  background: rgba(30, 41, 59, 1);
  transform: translateX(4px);
  border-color: rgba(255,255,255,0.1);
}
.related-item img {
  width: 65px;
  height: 65px;
  object-fit: cover;
  border-radius: 8px;
}
.related-item a {
  color: #e2e8f0;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@media(max-width: 900px) {
  .digital-grid {
    grid-template-columns: 1fr;
    gap: 30px;
  }
  .digital-side {
    position: static;
  }
  .sections-bento {
    grid-template-columns: 1fr;
  }
}
</style>

<div class="digital-single-wrap">

<div class="digital-grid">

<!-- LEFT COLUMN -->
<div>

  <div class="digital-media">
    <button class="close-inline-btn" id="closeInlineBtn" onclick="closeVerticalPreview()">
      <i class="fas fa-times"></i>
    </button>
    
    <div id="scrollHints" style="display:none; position:absolute; right:20px; top:60px; bottom:60px; flex-direction:column; justify-content:space-between; pointer-events:none; z-index:15;">
      <i class="fas fa-chevron-up bounce-up-icon" style="color:rgba(255,255,255,0.7); font-size:24px; text-shadow:0 2px 5px rgba(0,0,0,0.5);"></i>
      <div style="flex-grow:1;"></div>
      <i class="fas fa-chevron-down bounce-down-icon" style="color:#f97316; font-size:32px; text-shadow:0 2px 10px rgba(0,0,0,0.8);"></i>
    </div>

    <div class="inline-scroll-player" id="inlinePlayer"></div>

    <img id="mainProductImage" src="uploads/digital_products/<?= $product['image']; ?>" 
         alt="<?= htmlspecialchars($product['title']); ?>">
    <?php if(!empty($product['preview_images'])) { ?>
      <button class="overlay-preview-btn" id="previewBtn" onclick="openVerticalPreview()">
        <i class="fas fa-book-open"></i> Read Preview
      </button>
    <?php } else { ?>
      <button class="overlay-preview-btn" id="previewBtn" onclick="openVerticalPreview()">
        <i class="fas fa-eye"></i> Quick Preview
      </button>
    <?php } ?>
  </div>

  <div class="digital-content">
    <h1><?= htmlspecialchars($product['title']); ?></h1>

    <div class="digital-desc">
      <?= nl2br($product['description']); ?>
    </div>

    <div class="sections-bento">
      <?php if(!empty($product['features'])){ ?>
      <div class="section-box features">
        <h2><i class="fas fa-star" style="color:#3b82f6;"></i> Core Features</h2>
        <ul>
          <?php foreach(explode("\n",$product['features']) as $f){ if(trim($f)){ ?>
            <li><?= htmlspecialchars($f); ?></li>
          <?php }} ?>
        </ul>
      </div>
      <?php } ?>

      <?php if(!empty($product['what_you_get'])){ ?>
      <div class="section-box what-you-get">
        <h2><i class="fas fa-box-open" style="color:#22c55e;"></i> What You’ll Get</h2>
        <ul>
          <?php foreach(explode("\n",$product['what_you_get']) as $w){ if(trim($w)){ ?>
            <li><?= htmlspecialchars($w); ?></li>
          <?php }} ?>
        </ul>
      </div>
      <?php } ?>
    </div>
  </div>

</div>

<!-- RIGHT SIDEBAR -->
<div class="digital-side">

  <div class="price-box">
    <?php if(!empty($product['badge_text'])){ ?>
      <div class="offer-badge-single"><?= htmlspecialchars($product['badge_text']); ?></div>
    <?php } ?>
    <div style="color:#94a3b8; font-size:14px; text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">Instant Access</div>
    <div class="price">
      <span>₹<?= trim($product['price']); ?></span>
      <?php if(!empty($product['old_price'])){ ?>
        <span class="price-old">₹<?= trim($product['old_price']); ?></span>
      <?php } ?>
    </div>
  </div>

  <div class="premium-action-bar">
    <a href="/Menshubprime/checkout?id=<?= $id; ?>" class="buy-btn">
      <i class="fas fa-lock"></i> Secure Checkout
    </a>

    <a href="/Menshubprime/digital-products" class="back-btn">
      <i class="fas fa-arrow-left"></i> All Digital Products
    </a>
    
    <button onclick="shareProduct()" class="share-btn">
      <i class="fas fa-share-nodes"></i> Share Product
    </button>
  </div>

  <h2><i class="fas fa-fire" style="color:#f97316;"></i> Trending Products</h2>

  <div class="related-list">
  <?php
  $r = mysqli_query($conn,"SELECT id,title,image,slug 
    FROM digital_products 
    WHERE status='active' AND id!='$id'
    ORDER BY RAND() LIMIT 6");

  while($rp=mysqli_fetch_assoc($r)){
  ?>
  <div class="related-item">
    <img loading="lazy" src="uploads/digital_products/<?= $rp['image']; ?>" alt="<?= htmlspecialchars($rp['title']); ?>">
    <a href="digital-product/<?= $rp['slug']; ?>">
      <?= htmlspecialchars(substr($rp['title'],0,45)); ?>
    </a>
  </div>
  <?php } ?>
  </div>
<?php
$sponsors = mysqli_query($conn,"
SELECT * FROM sponsors 
WHERE status='active' AND position='blog'
ORDER BY id DESC
");

if(mysqli_num_rows($sponsors) > 0){
?>

<style>
.sponsor-section{
  padding:50px 0;
  /* background:#0b1220; */
}

.sponsor-heading{
  text-align:center;
  color:#f97316;
  font-size:28px;
  /* margin-bottom:20px; */
  font-weight:700;
  margin-top: -30px;
}

.sponsor-wrapper{
  max-width:1200px;
  margin:auto;
  overflow:hidden;
  position:relative;
}

.sponsor-track{
  display:flex;
  gap:20px;
  transition:0.6s ease-in-out;
}

.sponsor-card{
  flex: 0 0 100%;
}

.sponsor-box{
  background:#fff;
  border-radius:16px;
  padding:16px;
  text-align:center;
  box-shadow:0 8px 20px rgba(0,0,0,.25);
}

.sponsor-box img{
  width:90%;
  height:200px;
  object-fit:contain;
}

.sponsor-title{
  font-size:16px;
  margin-top:10px;
  font-weight:700;
  color: black;
}

.sponsor-btn{
  display:inline-block;
  margin-top:10px;
  padding:8px 18px;
  background:#2563eb;
  color:#fff;
  border-radius:20px;
  text-decoration:none;
  font-size:14px;
}

/* Tablet */
@media(max-width:900px){
  .sponsor-card{flex:0 0 50%;}
}

/* Mobile */
@media(max-width:600px){
  .sponsor-card{flex:0 0 100%;}
  .sponsor-box img{height:150px;}
}
</style>

<section class="sponsor-section">

<h2 class="sponsor-heading">Sponsored Post</h2>

<div class="sponsor-wrapper">
  <div class="sponsor-track" id="blogSponsorTrack">

    <?php while($row=mysqli_fetch_assoc($sponsors)){ ?>
      <div class="sponsor-card">
        <div class="sponsor-box">
          <img src="assets/images/<?= $row['image']; ?>" alt="<?= htmlspecialchars($row['title']); ?>">
          <div class="sponsor-title"><?= htmlspecialchars($row['title']); ?></div>
          <a href="<?= $row['link']; ?>" target="_blank" class="sponsor-btn">
            Visit Sponsor
          </a>
        </div>
      </div>
    <?php } ?>

  </div>
</div>

</section>

<script>
(function(){
  const track = document.getElementById("blogSponsorTrack");
  const cards = document.querySelectorAll("#blogSponsorTrack .sponsor-card");

  if(cards.length+20 === 0) return; // safety

  let index = 0;

  function slideSponsors(){
    const cardWidth = cards[0].offsetWidth+20;
    index++;

    if(index >= cards.length){
      index = 0;
    }

    track.style.transform = "translateX(-" + (index * cardWidth) + "px)";
  }

  setInterval(slideSponsors,3000);

  window.addEventListener("resize",()=>{
    index = 0;
    track.style.transform="translateX(0px)";
  });

})();
</script>

<?php } ?>

</div> <!-- End of digital-side -->

</div> <!-- End of digital-grid -->

<!-- Load SweetAlert2 via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function shareProduct() {
  const shopUrl = window.location.href;
  const title = "<?= htmlspecialchars(addslashes($product['title'])); ?>";
  const desc = "Check out this premium digital product on MenHub Prime!";

  if (navigator.share) {
    navigator.share({
      title: title,
      text: desc,
      url: shopUrl
    }).catch(console.error);
  } else {
    navigator.clipboard.writeText(shopUrl).then(() => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Share link copied to clipboard!',
        showConfirmButton: false,
        timer: 3000,
        background: '#1e293b',
        color: '#f8fafc'
      });
    });
  }
}

function openVerticalPreview() {
  const images = [];
  images.push('uploads/digital_products/<?= htmlspecialchars($product["image"]); ?>');
  <?php if(!empty($product['preview_images'])) { 
      $prv_imgs = explode(',', $product['preview_images']);
      foreach($prv_imgs as $p_img){ if(trim($p_img)){ ?>
        images.push('uploads/digital_products/<?= htmlspecialchars(trim($p_img)); ?>');
  <?php }}} ?>

  let htmlStr = '';
  images.forEach(img => {
      htmlStr += `<img src="${img}" class="inline-preview-img">`;
  });
  
  document.getElementById('inlinePlayer').innerHTML = htmlStr;
  
  document.getElementById('mainProductImage').style.display = 'none';
  document.getElementById('previewBtn').style.display = 'none';
  
  document.getElementById('inlinePlayer').style.display = 'flex';
  document.getElementById('closeInlineBtn').style.display = 'flex';
  document.getElementById('scrollHints').style.display = 'flex';
}

function closeVerticalPreview() {
  document.getElementById('inlinePlayer').style.display = 'none';
  document.getElementById('closeInlineBtn').style.display = 'none';
  document.getElementById('scrollHints').style.display = 'none';
  
  document.getElementById('mainProductImage').style.display = 'block';
  document.getElementById('previewBtn').style.display = 'flex';
}
</script>

<!-- Premium Related Content (Blogs, Videos, Ebooks) -->
<?php include 'includes/related-content.php'; ?>

</div> <!-- End of digital-single-wrap -->

<section class="brand-wrap">
  <div class="brand-box">
    <h3>Built for <span>Smart Men</span></h3>
    <p>
      MenHub Prime curates the best deals for you —  
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