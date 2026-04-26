<?php
include 'config/db.php';
include 'helpers/functions.php';

if (isset($_GET['slug'])) {
    $slug = mysqli_real_escape_string($conn, $_GET['slug']);
    $q = mysqli_query($conn, "SELECT * FROM videos WHERE slug='$slug' AND (status='1' OR status='active')");
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $q = mysqli_query($conn, "SELECT * FROM videos WHERE id=$id AND (status='1' OR status='active')");
} else {
    header("Location: /Menshubprime/videos");
    exit();
}

$v = mysqli_fetch_assoc($q);

if(!$v){
    header("Location: /Menshubprime/videos");
    exit();
}
$id = $v['id'];

if (isset($_GET['id']) && !isset($_GET['slug'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /Menshubprime/video/" . $v['slug']);
    exit();
}

// Set SEO Variables
$page_title = ($v['meta_title'] ?? $v['title']) . " | MensHub Prime";
$page_description = substr(strip_tags($v['meta_description'] ?? $v['description']), 0, 160);
$og_image = "https://" . $_SERVER['HTTP_HOST'] . "/Menshubprime/uploads/thumbs/" . $v['thumb'];
$og_type = "video.other";

include ROOT_PATH . '/includes/header.php';
?>
<style>
.video-single-wrap {
  max-width: 1200px;
  margin: 40px auto;
  padding: 0 20px;
  color: #f8fafc;
}

/* Breadcrumb */
.breadcrumb {
  font-size: 14px;
  margin-bottom: 25px;
  color: #94a3b8;
  font-weight: 500;
}
.breadcrumb a {
  color: #38bdf8;
  text-decoration: underline;
  text-decoration-color: rgba(56, 189, 248, 0.4);
  text-underline-offset: 4px;
  transition: all 0.3s ease;
}
.breadcrumb a:hover {
  text-decoration-color: rgba(56, 189, 248, 1);
  color: #7dd3fc;
}

/* Layout */
.video-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 40px;
}

/* Player */
.video-player {
  background: #0f172a;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(0,0,0,0.6);
  border: 1px solid rgba(255,255,255,0.05);
}
video, iframe {
  width: 100%;
  height: 480px;
  display: block;
}

/* Main Content */
.video-content {
  margin-top: 25px;
}
.video-content h1 {
  font-size: 32px;
  margin: 0 0 10px;
  background: linear-gradient(135deg, #f97316, #22c55e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 800;
  line-height: 1.3;
}
.video-meta {
  font-size: 14px;
  color: #cbd5e1;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.video-meta i {
  color: #f97316;
}
.video-desc {
  line-height: 1.8;
  color: #e2e8f0;
  font-size: 16px;
  background: rgba(15, 23, 42, 0.4);
  padding: 20px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.05);
  margin-bottom: 25px;
}

/* Review Enhancements */
.verdict-card {
  background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(56, 189, 248, 0.1));
  border: 1px solid rgba(34, 197, 94, 0.2);
  border-radius: 16px;
  padding: 25px;
  margin: 30px 0;
}
.verdict-card h2 {
  font-size: 22px;
  color: #22c55e;
  margin-bottom: 15px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.verdict-text {
  font-size: 16px;
  line-height: 1.6;
  color: #f8fafc;
}
.bestfor-badge {
  display: inline-block;
  background: rgba(249, 115, 22, 0.15);
  color: #f97316;
  padding: 6px 15px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 700;
  margin-top: 15px;
  border: 1px solid rgba(249, 115, 22, 0.3);
}

.specs-section {
  margin-top: 40px;
}
.specs-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 15px;
  margin-top: 20px;
}
.spec-item {
  background: rgba(30, 41, 59, 0.5);
  padding: 15px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.05);
}
.spec-label {
  font-size: 12px;
  color: #94a3b8;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 5px;
}
.spec-value {
  font-size: 15px;
  color: #f8fafc;
  font-weight: 600;
}

.rating-stars {
  color: #fbce03;
  font-size: 20px;
  display: flex;
  align-items: center;
  gap: 5px;
  margin-bottom: 10px;
}
.rating-score {
  color: #94a3b8;
  font-size: 16px;
  font-weight: 700;
  margin-left: 10px;
}

/* Pros and Cons Box */
.proscons-box {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 25px;
  margin-top: 30px;
}
.pros, .cons {
  background: #0f172a;
  padding: 25px;
  border-radius: 16px;
  border: 1px solid rgba(255,255,255,0.05);
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.pros h2, .cons h2 {
  font-size: 20px;
  margin-top: 0;
  margin-bottom: 15px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.pros h2 { color: #22c55e; }
.cons h2 { color: #ef4444; }
.pros ul, .cons ul {
  padding-left: 20px;
  margin: 0;
}
.pros li, .cons li {
  margin-bottom: 10px;
  color: #cbd5e1;
  font-size: 15px;
  line-height: 1.5;
}

/* Premium Action Bar */
.premium-action-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 20px;
  background: #0f172a;
  padding: 20px 25px;
  border-radius: 16px;
  margin-top: 30px;
  border: 1px solid rgba(255,255,255,0.08);
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.buy-group {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.buy-btn {
  background: linear-gradient(135deg, #f97316, #ea580c);
  padding: 12px 28px;
  border-radius: 30px;
  color: #fff;
  text-decoration: none;
  font-weight: 700;
  font-size: 15px;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;
  box-shadow: 0 5px 15px rgba(249, 115, 22, 0.4);
}
.buy-btn:hover {
  transform: translateY(-2px) scale(1.02);
  box-shadow: 0 8px 25px rgba(249, 115, 22, 0.6);
}

.back-btn {
  background: #1e293b;
  padding: 12px 24px;
  border-radius: 30px;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: 0.3s;
  border: 1px solid rgba(255,255,255,0.1);
}
.back-btn:hover {
  background: #334155;
}

/* Share Suite */
.share-suite {
  display: flex;
  align-items: center;
  gap: 12px;
}
.share-suite span {
  font-weight: 600;
  color: #94a3b8;
  font-size: 14px;
}
.share-btn {
  width: 40px;
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  color: #fff;
  text-decoration: none;
  font-size: 18px;
  transition: 0.3s;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}
.share-btn:hover {
  transform: translateY(-3px) scale(1.1);
}
.share-wa { background: #25D366; box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3); }
.share-tg { background: #0088cc; box-shadow: 0 5px 15px rgba(0, 136, 204, 0.3); }
.share-fb { background: #1877F2; box-shadow: 0 5px 15px rgba(24, 119, 242, 0.3); }
.share-copy { background: #475569; cursor: pointer; border: none; outline: none; }

/* Sidebar */
.video-side {
  background: #0f172a;
  border-radius: 20px;
  padding: 25px;
  border: 1px solid rgba(255,255,255,0.05);
  box-shadow: 0 15px 40px rgba(0,0,0,0.4);
  height: fit-content;
  position: sticky;
  top: 20px;
}
.video-side h2 {
  font-size: 22px;
  margin-top: 0;
  margin-bottom: 20px;
  color: #f8fafc;
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Related Videos */
.related-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}
.related-item {
  display: flex;
  gap: 15px;
  transition: 0.3s;
  border-radius: 12px;
  padding: 10px;
  background: rgba(2, 6, 23, 0.4);
  border: 1px solid rgba(255,255,255,0.03);
}
.related-item:hover {
  background: rgba(30, 41, 59, 1);
  transform: translateX(5px);
  border-color: rgba(255,255,255,0.1);
}
.related-thumb {
  position: relative;
  width: 100px;
  height: 65px;
  flex-shrink: 0;
  border-radius: 8px;
  overflow: hidden;
}
.related-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}
.related-item:hover img {
  transform: scale(1.1);
}
.related-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
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

/* Disclaimer */
.disclaimer {
  margin-top: 40px;
  background: rgba(30, 41, 59, 0.5);
  padding: 20px 25px;
  border-radius: 12px;
  font-size: 13px;
  color: #94a3b8;
  border: 1px solid rgba(255,255,255,0.05);
  text-align: center;
  line-height: 1.6;
}
.disclaimer strong {
  color: #f97316;
}

/* Mobile Sticky Buy */
.mobile-buy {
  display: none;
}

@media(max-width: 900px) {
  .video-grid { grid-template-columns: 1fr; gap: 30px; }
  video, iframe { height: 260px; }
  .video-content h1 { font-size: 26px; }
  .video-side { position: static; }
}
@media(max-width: 700px) {
  .proscons-box { grid-template-columns: 1fr; }
  .premium-action-bar { flex-direction: column; align-items: stretch; text-align: center; }
  .buy-group { flex-direction: column; }
  .buy-btn, .back-btn { justify-content: center; width: 100%; box-sizing: border-box; }
  .share-suite { justify-content: center; margin-top: 10px; }
}
</style>

<div class="video-single-wrap">

<!-- Breadcrumb -->
<div class="breadcrumb">
  <a href="/Menshubprime/"><i class="fas fa-home"></i> Home</a> &raquo; 
  <a href="/Menshubprime/videos">Reviews</a> &raquo; 
  <?= htmlspecialchars($v['title']); ?>
</div>

<div class="video-grid">

<!-- LEFT COLUMN -->
<div>

  <!-- Video Player -->
  <div class="video-player">
  <?php 
    $final_url = getEmbedUrl($v['video_link']);
    if(strpos($final_url, 'http') === 0){ 
      // It's an external link (Embed or remote file)
      if(strpos($final_url, 'mp4') !== false){
        // Remote MP4
        echo '<video controls poster="uploads/thumbs/'.$v['thumb'].'"><source src="'.$final_url.'" type="video/mp4"></video>';
      } else {
        // Embed (YouTube/Insta/etc)
        echo '<iframe src="'.$final_url.'" frameborder="0" allowfullscreen loading="lazy"></iframe>';
      }
    } else { 
      // It's a local file
      echo '<video controls poster="uploads/thumbs/'.$v['thumb'].'" decoding="async">
              <source src="uploads/videos/'.$v['video_link'].'" type="video/mp4">
            </video>';
    } 
  ?>
  </div>

  <!-- Content -->
  <div class="video-content">
    <h1><?= htmlspecialchars($v['title']); ?></h1>
    
    <?php if($v['star_rating'] > 0){ ?>
    <div class="rating-stars">
      <?php 
        $full_stars = floor($v['star_rating']);
        $has_half = ($v['star_rating'] - $full_stars) >= 0.5;
        for($i=1; $i<=5; $i++){
          if($i <= $full_stars) echo '<i class="fas fa-star"></i>';
          elseif($i == $full_stars+1 && $has_half) echo '<i class="fas fa-star-half-alt"></i>';
          else echo '<i class="far fa-star"></i>';
        }
      ?>
      <span class="rating-score"><?= $v['star_rating']; ?> / 5.0</span>
    </div>
    <?php } ?>
    
    <div class="video-meta">
      <i class="fas fa-calendar-alt"></i> 
      <span>Published on <?= date("F j, Y", strtotime($v['created_at'] ?? date('Y-m-d'))); ?></span>
    </div>

    <div class="video-desc">
      <?= nl2br($v['description']); ?>
    </div>

    <?php if(!empty($v['verdict'])){ ?>
    <div class="verdict-card">
      <h2><i class="fas fa-gavel"></i> TheZayanWay Verdict</h2>
      <div class="verdict-text"><?= nl2br($v['verdict']); ?></div>
      <?php if(!empty($v['best_for'])){ ?>
        <div class="bestfor-badge"><i class="fas fa-user-check"></i> Best For: <?= htmlspecialchars($v['best_for']); ?></div>
      <?php } ?>
    </div>
    <?php } ?>

    <?php if(!empty($v['pros']) || !empty($v['cons'])){ ?>
    <div class="proscons-box">
      <div class="pros">
        <h2>✅ Pros</h2>
        <ul>
          <?php foreach(explode("\n",$v['pros']) as $p){ if(trim($p)){ ?>
            <li><?= $p; ?></li>
          <?php }} ?>
        </ul>
      </div>

      <div class="cons">
        <h2>❌ Cons</h2>
        <ul>
          <?php foreach(explode("\n",$v['cons']) as $c){ if(trim($c)){ ?>
            <li><?= $c; ?></li>
          <?php }} ?>
        </ul>
      </div>
    </div>
    <?php } ?>

    <?php if(!empty(trim($v['specs'] ?? ''))){ ?>
    <div class="specs-section">
      <h2 style="font-size:24px; margin-bottom:20px;"><i class="fas fa-microchip"></i> Technical Specifications</h2>
      <div class="specs-grid">
        <?php 
          $specs_lines = explode("\n", trim($v['specs']));
          foreach($specs_lines as $line){
            if(strpos($line, ':') !== false){
              list($label, $value) = explode(':', $line, 2);
              echo '<div class="spec-item">
                      <div class="spec-label">'.trim($label).'</div>
                      <div class="spec-value">'.trim($value).'</div>
                    </div>';
            }
          }
        ?>
      </div>
    </div>
    <?php } ?>

    <!-- Premium Action Bar -->
    <div class="premium-action-bar">
      <div class="buy-group">
        <?php if(!empty($v['buy_link'])): ?>
        <a href="<?= $v['buy_link']; ?>" target="_blank" rel="noopener" class="buy-btn">
          <i class="fas fa-shopping-cart"></i> Buy Now for Best Deal
        </a>
        <?php endif; ?>
        <a href="/Menshubprime/videos" class="back-btn"><i class="fas fa-arrow-left"></i> All Reviews</a>
      </div>

      <div class="share-suite">
        <span><i class="fas fa-share-alt"></i> Share:</span>
        <a class="share-btn share-wa" aria-label="Share on WhatsApp" href="https://wa.me/?text=<?= urlencode("Watch this review: ".$v['title']." - https://".$_SERVER['HTTP_HOST']."/Menshubprime/video/".$v['slug']); ?>" target="_blank" rel="noopener">
          <i class="fab fa-whatsapp"></i>
        </a>
        <a class="share-btn share-tg" aria-label="Share on Telegram" href="https://t.me/share/url?url=<?= urlencode("https://".$_SERVER['HTTP_HOST']."/Menshubprime/video/".$v['slug']); ?>&text=<?= urlencode($v['title']); ?>" target="_blank" rel="noopener">
          <i class="fab fa-telegram-plane"></i>
        </a>
        <a class="share-btn share-fb" aria-label="Share on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode("https://".$_SERVER['HTTP_HOST']."/Menshubprime/video/".$v['slug']); ?>" target="_blank" rel="noopener">
          <i class="fab fa-facebook-f"></i>
        </a>
        <button class="share-btn share-copy" aria-label="Copy Link" onclick="copyVideoLink()">
          <i class="fas fa-link"></i>
        </button>
      </div>
    </div>

    <script>
    function copyVideoLink(){
        var text = "<?= "https://".$_SERVER['HTTP_HOST']."/Menshubprime/video/".$v['slug']; ?>";
        var temp = document.createElement("input");
        document.body.appendChild(temp);
        temp.value = text;
        temp.select();
        document.execCommand("copy");
        document.body.removeChild(temp);
        alert("Video link copied to clipboard!");
    }
    </script>
  </div>
</div>

<!-- RIGHT SIDEBAR -->
<div class="video-side">
  <h2><i class="fas fa-fire" style="color:#f97316;"></i> Related Reviews</h2>
  <div class="related-list">
    <?php
    $r = mysqli_query($conn,"SELECT * FROM videos WHERE (status='1' OR status='active') AND id!='$id' ORDER BY RAND() LIMIT 8");
    while($rv = mysqli_fetch_assoc($r)){
    ?>
    <div class="related-item">
      <div class="related-thumb">
        <img loading="lazy" decoding="async" src="uploads/thumbs/<?= $rv['thumb']; ?>" alt="<?= htmlspecialchars($rv['title']); ?>">
      </div>
      <div class="related-info">
        <a href="/Menshubprime/video/<?= $rv['slug']; ?>" title="<?= htmlspecialchars($rv['title']); ?>">
          <?= htmlspecialchars($rv['title']); ?>
        </a>
      </div>
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
</div>

</div>

<div class="disclaimer">
<strong>Disclaimer:</strong> This post may contain affiliate links. If you purchase through these links, we may earn a small commission at no extra cost to you. We only recommend products that we trust and review honestly for our audience.
</div>

<!-- Premium Related Content (Blogs, Videos, Ebooks) -->
<?php include 'includes/related-content.php'; ?>

</div>

<!-- Sticky mobile buy -->
<div class="mobile-buy">
<a href="<?= $v['buy_link']; ?>" target="_blank">Buy Now</a>
</div>
<script type="application/ld+json">
{
"@context":"https://schema.org",
"@type":"VideoObject",
"name":"<?= addslashes($v['title']); ?>",
"description":"<?= addslashes(strip_tags($v['description'])); ?>",
"thumbnailUrl":"uploads/thumbs/<?= $v['thumb']; ?>",
"uploadDate":"<?= date('Y-m-d'); ?>",
"contentUrl":"<?= $v['video_link']; ?>",
"publisher":{
 "@type":"Organization",
 "name":"MenHub Prime"
}
}
</script>
<script type="application/ld+json">
{
"@context":"https://schema.org",
"@type":"FAQPage",
"mainEntity":[
<?php
if (!empty(trim($v['faq'] ?? ''))) {
    $faqs = array_filter(explode("\n", trim($v['faq'])));
    $valid_faqs = [];
    foreach($faqs as $f) {
        $parts = explode("|", $f);
        if (count($parts) >= 2) {
            $valid_faqs[] = $parts;
        }
    }
    
    foreach($valid_faqs as $i => $parts) {
        $q = trim($parts[0]);
        $a = trim($parts[1]);
?>
{
"@type":"Question",
"name":"<?= addslashes($q); ?>",
"acceptedAnswer":{"@type":"Answer","text":"<?= addslashes($a); ?>"}
}<?= $i < count($valid_faqs) - 1 ? ',' : '' ?>
<?php 
    } 
} 
?>
]
}
</script>

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
<img loading="lazy" decoding="async" src="assets/images/telegram.png" alt="Telegram" width="80" height="auto">
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
<hr>
<?php include ROOT_PATH . '/includes/footer.php'; ?>