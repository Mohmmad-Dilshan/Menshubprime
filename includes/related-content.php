<?php
// includes/related-content.php - v3 Clean Fix
if (!isset($id)) $id = 0;
if (!isset($conn)) { return; }
?>
<!-- RELATED CONTENT SECTION -->
<style>
.rc-section-wrap { max-width:1100px; margin:60px auto 20px; padding:0 20px; box-sizing:border-box; font-family:inherit; }
.rc-main-heading { font-size:22px; font-weight:800; color:#f8fafc; border-left:5px solid #2563eb; padding-left:14px; margin-bottom:30px; }
.rc-block { margin-bottom:44px; }
.rc-block-header { display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e2e8f0; padding-bottom:10px; margin-bottom:18px; }
.rc-block-title { font-size:18px; font-weight:700; color:#e2e8f0; margin:0; }
.rc-viewall-link { font-size:13px; color:#fb923c; text-decoration:none; font-weight:600; white-space:nowrap; }
.rc-viewall-link:hover { opacity:0.7; }
.rc-cards-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
.rc-item-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; display:flex; flex-direction:column; text-decoration:none; box-shadow:0 2px 8px rgba(0,0,0,.06); transition:transform .3s,box-shadow .3s; }
.rc-item-card:hover { transform:translateY(-5px); box-shadow:0 12px 28px rgba(0,0,0,.1); }
.rc-thumb-wrap { width:100%; height:180px; overflow:hidden; background:#e2e8f0; position:relative; flex-shrink:0; }
.rc-thumb-img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .5s; }
.rc-item-card:hover .rc-thumb-img { transform:scale(1.06); }
.rc-no-img { width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#0f172a,#1e293b); color:#64748b; font-size:13px; font-weight:600; }
.rc-play-badge { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:44px; height:44px; background:rgba(0,0,0,.65); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:18px; }
.rc-item-body { padding:14px 16px; display:flex; flex-direction:column; flex-grow:1; }
.rc-item-title { font-size:15px; font-weight:700; color:#1e293b !important; margin:0 0 12px; line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.rc-badge { display:inline-block; font-size:11px; font-weight:700; padding:3px 8px; border-radius:5px; margin-bottom:8px; }
.rc-badge-blue { background:#eff6ff; color:#2563eb; }
.rc-badge-orange { background:#fff7ed; color:#9a3412; }
.rc-badge-red { background:#fef2f2; color:#991b1b; }
.rc-cta-btn { margin-top:auto; display:inline-block; padding:7px 16px; border-radius:8px; font-size:12px; font-weight:700; color:#fff; text-decoration:none; align-self:flex-start; transition:.2s; }
.rc-cta-btn.rc-blue { background:#2563eb; color:#fff !important; } .rc-cta-btn.rc-blue:hover { background:#1d4ed8; }
.rc-cta-btn.rc-orange { background:#f97316; color:#020617 !important; } .rc-cta-btn.rc-orange:hover { background:#ea580c; }
.rc-cta-btn.rc-red { background:#dc2626; color:#fff !important; } .rc-cta-btn.rc-red:hover { background:#dc2626; }
@media(max-width:900px){ .rc-cards-grid { grid-template-columns:repeat(2,1fr); gap:16px; } }
@media(max-width:600px){
    .rc-section-wrap { padding:0 14px; margin:40px auto 10px; }
    .rc-main-heading { font-size:18px; }
    .rc-block-title { font-size:16px; }
    .rc-cards-grid { grid-template-columns:1fr; gap:12px; }
    .rc-item-card { flex-direction:row; min-height:105px; border-radius:10px; }
    .rc-thumb-wrap { width:110px; min-width:110px; height:auto; min-height:105px; border-radius:10px 0 0 10px; }
    .rc-thumb-img { border-radius:10px 0 0 10px; height:100%; }
    .rc-item-body { padding:10px 12px; justify-content:center; }
    .rc-item-title { font-size:13px; margin-bottom:6px; }
    .rc-cta-btn { font-size:11px; padding:5px 12px; }
    .rc-play-badge { width:32px; height:32px; font-size:13px; }
}
</style>
<div class="rc-section-wrap">
<h2 class="rc-main-heading">&#128293; Explore More Related Content</h2>

<?php
if(isset($is_blog_page) && $is_blog_page === true):
  $prod_where = "WHERE 1=1";
  if(!empty($related_cat)){ $prod_where .= " AND category='$related_cat'"; }
  $rc_prods = mysqli_query($conn,"SELECT id,title,slug,image,price FROM products $prod_where AND status='active' ORDER BY RAND() LIMIT 3");
  if(!$rc_prods || mysqli_num_rows($rc_prods)<3){
      $rc_prods = mysqli_query($conn,"SELECT id,title,slug,image,price FROM products WHERE status='active' ORDER BY RAND() LIMIT 3");
  }
  if($rc_prods && mysqli_num_rows($rc_prods)>0):
?>
<div class="rc-block">
  <div class="rc-block-header">
    <h3 class="rc-block-title">&#128293; Best Products for You</h3>
    <a href="/Menshubprime/deals" class="rc-viewall-link">Shop More &rarr;</a>
  </div>
  <div class="rc-cards-grid">
  <?php while($rp=mysqli_fetch_assoc($rc_prods)):
    $rp_url="/Menshubprime/product/".(!empty($rp['slug'])?$rp['slug']:$rp['id']); ?>
  <a href="<?=htmlspecialchars($rp_url)?>" class="rc-item-card">
    <div class="rc-thumb-wrap">
      <?php if(!empty($rp['image'])): ?>
      <img src="/Menshubprime/assets/images/<?=htmlspecialchars($rp['image'])?>" alt="<?=htmlspecialchars($rp['title'])?>" class="rc-thumb-img" loading="lazy">
      <?php else: ?><div class="rc-no-img">No Image</div><?php endif; ?>
    </div>
    <div class="rc-item-body">
      <span class="rc-badge rc-badge-orange">Featured Deal</span>
      <h4 class="rc-item-title"><?=htmlspecialchars($rp['title'])?></h4>
      <div style="margin-top:auto; display:flex; justify-content:space-between; align-items:center;">
        <span style="font-weight:700; color:#16a34a;">₹<?=htmlspecialchars($rp['price'])?></span>
        <span class="rc-cta-btn rc-orange" style="margin:0; padding:5px 12px; font-size:11px;">View Deal</span>
      </div>
    </div>
  </a>
  <?php endwhile; ?>
  </div>
</div>
<?php endif; endif; ?>

<?php
$where_blog = "WHERE id!={$id}";
if (!empty($related_cat)) {
    $where_blog .= " AND (title LIKE '%$related_cat%' OR content LIKE '%$related_cat%')";
}
$rc_blogs = mysqli_query($conn,"SELECT id,title,slug,image FROM blogs $where_blog AND status='active' ORDER BY RAND() LIMIT 3");

// Fallback if no category matches found
if(!$rc_blogs || mysqli_num_rows($rc_blogs) == 0){
    $rc_blogs = mysqli_query($conn,"SELECT id,title,slug,image FROM blogs WHERE id!={$id} AND status='active' ORDER BY RAND() LIMIT 3");
}

if($rc_blogs && mysqli_num_rows($rc_blogs)>0): ?>
<div class="rc-block">
  <div class="rc-block-header">
    <h3 class="rc-block-title">&#128240; Trending Articles</h3>
    <a href="/Menshubprime/blog" class="rc-viewall-link">View All &rarr;</a>
  </div>
  <div class="rc-cards-grid">
  <?php while($rb=mysqli_fetch_assoc($rc_blogs)):
    $rb_url="/Menshubprime/blog/".(!empty($rb['slug'])?$rb['slug']:$rb['id']); ?>
  <a href="<?=htmlspecialchars($rb_url)?>" class="rc-item-card" rel="noopener">
    <div class="rc-thumb-wrap">
      <?php if(!empty($rb['image'])): ?>
      <img src="/Menshubprime/assets/images/<?=htmlspecialchars($rb['image'])?>" alt="<?=htmlspecialchars($rb['title'])?>" class="rc-thumb-img" loading="lazy" decoding="async">
      <?php else: ?><div class="rc-no-img">No Image</div><?php endif; ?>
    </div>
    <div class="rc-item-body">
      <span class="rc-badge rc-badge-blue">Article</span>
      <h4 class="rc-item-title"><?=htmlspecialchars($rb['title'])?></h4>
      <span class="rc-cta-btn rc-blue">Read Article</span>
    </div>
  </a>
  <?php endwhile; ?>
  </div>
</div>
<?php endif; ?>

<?php
$where_eb = "1=1";
if (!empty($related_cat)) {
    $where_eb .= " AND (title LIKE '%$related_cat%')";
}
$rc_ebooks = @mysqli_query($conn,"SELECT id,title,slug,image FROM digital_products WHERE $where_eb AND status='active' ORDER BY RAND() LIMIT 3");
if(!$rc_ebooks || mysqli_num_rows($rc_ebooks)==0){
    $rc_ebooks = @mysqli_query($conn,"SELECT id,title,slug,thumbnail AS image FROM digital_products WHERE $where_eb AND status='active' ORDER BY RAND() LIMIT 3");
}
// Final fallback for ebooks
if(!$rc_ebooks || mysqli_num_rows($rc_ebooks) == 0){
    $rc_ebooks = @mysqli_query($conn,"SELECT id,title,slug,image FROM digital_products WHERE status='active' ORDER BY RAND() LIMIT 3");
}

if($rc_ebooks && mysqli_num_rows($rc_ebooks)>0): ?>
<div class="rc-block">
  <div class="rc-block-header">
    <h3 class="rc-block-title">&#128218; Top Ebooks &amp; Guides</h3>
    <a href="/Menshubprime/digital-products" class="rc-viewall-link">View All &rarr;</a>
  </div>
  <div class="rc-cards-grid">
  <?php while($re=mysqli_fetch_assoc($rc_ebooks)):
    $re_url="/Menshubprime/digital-product/".(!empty($re['slug'])?$re['slug']:$re['id']); ?>
  <a href="<?=htmlspecialchars($re_url)?>" class="rc-item-card">
    <div class="rc-thumb-wrap">
      <?php if(!empty($re['image'])): ?>
      <img src="/Menshubprime/uploads/digital_products/<?=htmlspecialchars($re['image'])?>" alt="<?=htmlspecialchars($re['title'])?>" class="rc-thumb-img" loading="lazy">
      <?php else: ?><div class="rc-no-img">No Image</div><?php endif; ?>
    </div>
    <div class="rc-item-body">
      <span class="rc-badge rc-badge-orange">Ebook</span>
      <h4 class="rc-item-title"><?=htmlspecialchars($re['title'])?></h4>
      <span class="rc-cta-btn rc-orange">Download Now</span>
    </div>
  </a>
  <?php endwhile; ?>
  </div>
</div>
<?php endif; ?>

<?php
$where_vid = "WHERE status = 1";
if (!empty($related_cat)) {
    $where_vid .= " AND (title LIKE '%$related_cat%')";
}
$rc_vids = mysqli_query($conn,"SELECT id,title,slug,thumb FROM videos $where_vid ORDER BY RAND() LIMIT 3");

// Fallback for videos
if(!$rc_vids || mysqli_num_rows($rc_vids) == 0){
    $rc_vids = mysqli_query($conn,"SELECT id,title,slug,thumb FROM videos WHERE status = 1 ORDER BY RAND() LIMIT 3");
}

if($rc_vids && mysqli_num_rows($rc_vids)>0): ?>
<div class="rc-block">
  <div class="rc-block-header">
    <h3 class="rc-block-title">&#127909; Must-Watch Videos</h3>
    <a href="/Menshubprime/videos" class="rc-viewall-link">View All &rarr;</a>
  </div>
  <div class="rc-cards-grid">
  <?php while($rv=mysqli_fetch_assoc($rc_vids)):
    $rv_url="/Menshubprime/video/".(!empty($rv['slug'])?$rv['slug']:$rv['id']); ?>
  <a href="<?=htmlspecialchars($rv_url)?>" class="rc-item-card">
    <div class="rc-thumb-wrap">
      <?php if(!empty($rv['thumb'])): ?>
      <img src="/Menshubprime/uploads/thumbs/<?=htmlspecialchars($rv['thumb'])?>" alt="<?=htmlspecialchars($rv['title'])?>" class="rc-thumb-img" loading="lazy">
      <?php else: ?><div class="rc-no-img">No Preview</div><?php endif; ?>
      <div class="rc-play-badge">&#9654;</div>
    </div>
    <div class="rc-item-body">
      <span class="rc-badge rc-badge-red">Video</span>
      <h4 class="rc-item-title"><?=htmlspecialchars($rv['title'])?></h4>
      <span class="rc-cta-btn rc-red">Watch Now</span>
    </div>
  </a>
  <?php endwhile; ?>
  </div>
</div>
<?php endif; ?>
</div>