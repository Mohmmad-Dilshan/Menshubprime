<?php
// MENS HUB PRIME - EDITORIAL VELOCITY (V435 - RESPONSIVE RECTIFIER)
if (!isset($conn)) { require_once ROOT_PATH . '/src/bootstrap.php'; }

if (isset($_GET['slug'])) {
    $slug = mysqli_real_escape_string($conn, $_GET['slug']);
    $r_m = mysqli_query($conn, "SELECT * FROM blogs WHERE slug='$slug' AND status='active'");
} elseif (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $r_m = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id AND status='active'");
} else {
    header("Location: /blog");
    exit();
}

$row = mysqli_fetch_assoc($r_m);
if (!$row) { header("Location: /blog"); exit(); }

$id = $row['id'];
$page_title = $row['title'] . " | Official MensHub Prime";

include ROOT_PATH . '/includes/header.php';

// Data Preparation
$p_res = mysqli_query($conn, "SELECT * FROM blog_products WHERE blog_id='$id' ORDER BY product_order ASC");
$prods_data = []; while($pp = mysqli_fetch_assoc($p_res)) { $prods_data[] = $pp; }

$store_items = mysqli_query($conn, "SELECT * FROM products WHERE status='active' AND in_deals_bag=1 ORDER BY id DESC LIMIT 6");
$rel_intel = mysqli_query($conn, "SELECT * FROM blogs WHERE id != '$id' AND status='active' ORDER BY id DESC LIMIT 4");

// Video Data
$feat_video = mysqli_query($conn, "SELECT * FROM videos WHERE status='active' OR status='1' ORDER BY id DESC LIMIT 1");
$v_row = mysqli_fetch_assoc($feat_video);

// Digital Access
$digital_desktop = mysqli_query($conn, "SELECT * FROM digital_products WHERE status='active' ORDER BY id DESC LIMIT 3");
$digital_mobile = mysqli_query($conn, "SELECT * FROM digital_products WHERE status='active' ORDER BY id DESC LIMIT 1");

// Keywords
$w_arr = explode(' ', $row['title']);
$display_tags = array_slice(array_filter($w_arr, function($w){return strlen($w)>4;}), 0, 5);

function sLabel($l) { return (stripos($l, 'amazon') !== false) ? 'Amazon' : ((stripos($l, 'flipkart') !== false) ? 'Flipkart' : 'Partner'); }
?>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
/* ⚡ VELOCITY V435 - RESPONSIVE RECTIFIER ⚡ */
:root { --p: #f97316; --b: #020617; --w: #ffffff; --t: #0f172a; --g: rgba(255,255,255,0.05); }
html { scroll-behavior: smooth; }
#vHub { background: var(--b); color: #fff; font-family: 'Outfit'; overflow-x: hidden; width: 100%; position: relative; }

/* 🌟 UNIVERSAL BRIEFING SUMMARY (ULTRA STABLE) */
.v-briefing { background: #f8fafc; border-left: 5px solid var(--p); padding: 30px; margin-bottom: 50px; border-radius: 0 15px 15px 0; box-sizing: border-box; width: 100%; position: relative; overflow: hidden; }
.v-briefing h5 { font-family:'Outfit'; font-weight:900; color:var(--t); margin-bottom:18px; text-transform:uppercase; font-size:11px; letter-spacing:3px; }
.v-briefing ul { list-style: none; padding: 0; margin: 0; }
.v-briefing li { font-family:'Outfit'; font-size:16px; color:#444; line-height:1.7; position: relative; padding-left: 25px; margin-bottom: 12px; word-break: break-word; }
.v-briefing li::before { content: '→'; position: absolute; left: 0; color: var(--p); font-weight: 900; }

/* 🌟 DESKTOP CORE (LOCKED) */
#pBar { position: fixed; top: 0; left: 0; height: 3px; background: var(--p); z-index: 10001; width: 0%; }
.h-sec { width: 100%; height: 75vh; position: relative; background: #000; overflow: hidden; display: flex; align-items: center; justify-content: center; }
.h-sec img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6); }
.h-ui { position: relative; z-index: 10; text-align: center; max-width: 1000px; padding: 0 20px; }
.h-ui span { font-family:'Outfit'; font-weight:900; letter-spacing:8px; color:var(--p); text-transform:uppercase; font-size:11px; margin-bottom: 20px; display: block; }
.h-ui h1 { font-family: 'Playfair Display'; font-size: clamp(33px, 6vw, 85px); font-weight: 900; line-height: 1.1; margin: 20px 0; letter-spacing: -3px; }

.g-main { max-width: 1450px; margin: 0 auto; display: grid; grid-template-columns: 1fr 380px; gap: 60px; padding: 0 40px 100px; align-items: start; }
.paper { background: var(--w); color: var(--t); margin-top: -40px; position: relative; z-index: 30; padding: 80px 75px; border-radius: 8px; box-shadow: 0 50px 100px rgba(0,0,0,0.5); background-image: url('https://www.transparenttextures.com/patterns/natural-paper.png'); overflow: hidden; }

.meta-hub { display: flex; align-items: flex-end; justify-content: space-between; padding-bottom: 25px; border-bottom: 1px solid #eee; margin-bottom: 40px; flex-wrap: wrap; gap: 20px; }
.meta-left { display: flex; flex-direction: column; gap: 4px; }
.author { font-size: 13px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: var(--p); }

.s-pin { position: sticky; top: 110px; height: fit-content; padding-top: 20px; display: flex; flex-direction: column; gap: 35px; }
.s-card { background: var(--g); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px; padding: 30px; backdrop-filter: blur(25px); position: relative; overflow: hidden; }
.s-head { font-family: 'Outfit'; font-weight: 900; font-size: 11px; color: var(--p); letter-spacing: 4px; text-transform: uppercase; margin-bottom: 25px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 15px; }

.side-item { display: flex; align-items: center; gap: 15px; text-decoration: none; color: #fff; margin-bottom: 20px; opacity: 0.7; transition: 0.3s; }
.side-item:hover { opacity: 1; transform: translateX(5px); }
.side-item img { width: 50px; height: 50px; border-radius: 8px; background: #fff; padding: 5px; object-fit: contain; flex-shrink: 0; }
.side-item-txt { font-family:'Outfit'; font-size:12px; font-weight:800; line-height:1.2; }

.b-txt { font-size: 20px; line-height: 2.05; font-family: 'Georgia', serif; word-wrap: break-word; }
.b-txt p:first-of-type::first-letter { float: left; font-family: 'Playfair Display'; font-size: 95px; line-height: 70px; padding: 10px 15px 0 0; color: var(--p); font-weight: 900; }
/* Rich content formatting — TinyMCE output */
.b-txt h2 { font-family: 'Playfair Display'; font-size: 36px; font-weight: 900; color: var(--t); margin: 50px 0 20px; line-height: 1.15; border-left: 5px solid var(--p); padding-left: 20px; }
.b-txt h3 { font-family: 'Outfit'; font-size: 26px; font-weight: 800; color: var(--t); margin: 40px 0 15px; }
.b-txt h4 { font-family: 'Outfit'; font-size: 21px; font-weight: 700; color: var(--t); margin: 30px 0 12px; }
.b-txt strong, .b-txt b { font-weight: 900; color: #0f172a; }
.b-txt em, .b-txt i { font-style: italic; color: #374151; }
.b-txt ul, .b-txt ol { padding-left: 30px; margin: 20px 0 25px; }
.b-txt ul li { list-style: disc; margin-bottom: 10px; font-size: 19px; line-height: 1.8; }
.b-txt ol li { list-style: decimal; margin-bottom: 10px; font-size: 19px; line-height: 1.8; }
.b-txt a { color: var(--p); text-decoration: underline; font-weight: 700; }
.b-txt blockquote { border-left: 5px solid var(--p); background: #fff8f4; padding: 25px 30px; margin: 35px 0; border-radius: 0 12px 12px 0; font-style: italic; font-size: 21px; color: #374151; }
@media (max-width: 1150px) {
  .b-txt h2 { font-size: 26px; padding-left: 14px; }
  .b-txt h3 { font-size: 22px; }
  .b-txt h4 { font-size: 19px; }
  .b-txt ul li, .b-txt ol li { font-size: 17px; }
}

.p-card { background: #fcfcfc; border: 1px solid #f0f0f0; border-radius: 15px; padding: 45px; margin: 60px 0; display: grid; grid-template-columns: 310px 1fr; gap: 40px; }
.p-vis { background: #fff; border-radius: 12px; padding: 25px; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center; }
.p-vis img { max-width: 100%; max-height: 240px; object-fit: contain; mix-blend-mode: multiply; }
.cta { background: var(--t); color: #fff; padding: 16px 35px; border-radius: 100px; font-family: 'Outfit'; font-weight: 900; text-decoration: none; display: inline-block; margin-top: 25px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; transition: 0.3s; }

.vid-brief { width: 100%; aspect-ratio: 16/9; border-radius: 12px; overflow: hidden; margin-bottom: 15px; position: relative; border: 1px solid rgba(255,255,255,0.1); }
.vid-brief img { width: 100%; height: 100%; object-fit: cover; }
.play-pulse { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 50px; height: 50px; background: var(--p); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; animation: p_anim 2s infinite; z-index: 10; cursor: pointer; }

.news-card { background: linear-gradient(135deg, #f97316, #ea580c); padding: 35px; border-radius: 24px; color: #fff; text-align: center; }
.news-btn { width: 85% !important; height: 45px; background: #fff; color: #000; border: none; border-radius: 100px; font-weight: 900; font-size: 11px; text-transform: uppercase; cursor: pointer; margin: 20px auto 0 !important; display: block !important; text-decoration: none; line-height: 45px; transition: 0.3s; }

/* 📱 MOBILE RESPONSIVE MASTER (V435 RECTIFIER) */
.m-only { display: none !important; }

@media (max-width: 1150px) {
    .m-only { display: block !important; }
    .h-sec { height: 55vh; }
    .g-main { grid-template-columns: 1fr; padding: 0; gap: 0; width: 100%; }
    .s-pin { display: none !important; }
    .paper { margin-top: -35px; padding: 35px 18px 60px; border-radius: 28px 28px 0 0; width: 100%; box-sizing: border-box; }
    
    /* Reponsive Briefing */
    .v-briefing { padding: 22px 18px; margin-bottom: 35px; width: 100% !important; box-sizing: border-box !important; }
    .v-briefing li { font-size: 15px; line-height: 1.5; padding-left: 20px; margin-bottom: 12px; }

    .b-txt { font-size: 18px; line-height: 1.8; overflow-wrap: break-word; }
    .p-card { grid-template-columns: 1fr; padding: 25px 15px; margin: 40px 0; border: 1px solid #f0f0f0; border-radius: 20px; width: 100% !important; box-sizing: border-box !important; }
    .p-vis { padding: 15px; height: 220px; width: 100%; box-sizing: border-box; }
    .p-vis img { max-width: 100%; height: 100%; object-fit: contain; }
    .p-info { text-align: center !important; width: 100%; box-sizing: border-box; }
    .cta { display: block !important; width: 90% !important; margin: 25px auto 0 !important; text-align: center !important; padding: 18px 5px !important; border-radius: 100px !important; }

    .meta-hub { flex-direction: column; align-items: flex-start; gap: 15px; padding-bottom: 20px; width: 100%; box-sizing: border-box; }
    .meta-right { display: flex; width: 100%; justify-content: flex-start; gap: 30px; padding-top: 15px; border-top: 1px solid #f1f5f9; }

    /* MOBILE SECTIONS REFINEMENT */
    .m-sec { padding: 50px 18px; background: var(--b); border-top: 1px solid rgba(255,255,255,0.08); width: 100%; box-sizing: border-box; }
    .m-sec-h { font-family: 'Outfit'; font-weight: 900; font-size: 13px; color: var(--p); letter-spacing: 5px; text-transform: uppercase; margin-bottom: 30px; text-align: center; }
    
    .m-digi-item { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 26px; padding: 22px; margin-bottom: 35px; text-align: center; width: 100%; box-sizing: border-box; }
    .m-digi-item img { width: 100%; border-radius: 16px; margin-bottom: 20px; aspect-ratio: 16/10; object-fit: cover; }
    .m-digi-btn { background: var(--p); color: #fff; width: 90% !important; display: block !important; padding: 16px 5px; border-radius: 100px; font-weight: 900; text-decoration: none; text-align: center; margin: 20px auto 0 !important; font-size: 11px; text-transform: uppercase; }

    .m-vid-box { background: #000; border-radius: 26px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); position: relative; margin-bottom: 45px; width: 100%; box-sizing: border-box; }
    .m-vid-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; opacity: 0.7; }
    .m-vid-info { padding: 20px; background: linear-gradient(0deg, #000 30%, transparent); position: absolute; bottom: 0; left: 0; right: 0; width: 100%; box-sizing: border-box; }

    .m-slider { display: flex; overflow-x: auto; gap: 15px; padding: 2px 18px 25px; scrollbar-width: none; margin: 0 -18px; width: auto; }
    .m-slider::-webkit-scrollbar { display: none; }
    .m-slide-card { flex-shrink: 0; width: 155px; background: rgba(255,255,255,0.04); border-radius: 18px; padding: 12px; border: 1px solid rgba(255,255,255,0.05); }
    .m-slide-card img { width: 100%; height: 100px; object-fit: contain; background: #fff; border-radius: 12px; margin-bottom: 12px; }

    .m-react { display: flex; justify-content: center; gap: 20px; padding: 35px 0; border-top: 1px solid #f1f5f9; margin-top: 55px; width: 100%; box-sizing: border-box; }
    .m-react-btn { cursor: pointer; }
    .m-strip { background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; padding: 35px 20px; border-radius: 26px; margin: 40px 0; text-align: center; width: 100% !important; box-sizing: border-box !important; }
    .m-strip-btn { width: 90% !important; height: 52px; line-height: 52px; background: #fff; color: #000; border-radius: 100px; display: block; margin: 25px auto 0; text-decoration: none; font-weight: 900; font-size: 13px; text-transform: uppercase; }
}
</style>

<div id="pBar"></div>

<div id="vHub">

<section class="h-sec">
    <img src="/assets/images/<?php echo $row['image']; ?>" alt="Hero">
    <div class="h-ui">
        <span>Official MensHub Prime</span>
        <h1><?php echo htmlspecialchars($row['title']); ?></h1>
    </div>
</section>

<div class="g-main">
    <main class="paper">
        <div class="meta-hub">
            <div class="meta-left">
                <span class="author">By MensHub Prime Team</span>
                <span class="date"><?php echo date('M d, Y', strtotime($row['date'] ?? 'now')); ?></span>
                <span class="admin-sign" style="font-size:10px; font-weight:800; text-transform:uppercase; color:var(--t); opacity:0.8; margin-top:5px; display:block;">Chief Editor: Dilshan</span>
            </div>
            <div class="meta-right">
                <i class="fas fa-share-alt" title="Share" onclick="uS()" style="color:#94a3b8; cursor:pointer;"></i>
                <i class="fab fa-whatsapp" title="WhatsApp" onclick="shWA()" style="color:#22c55e; cursor:pointer; font-size:18px; margin-left: 15px;"></i>
                <i class="fas fa-link" title="Copy Link" onclick="cpL()" style="color:#94a3b8; cursor:pointer; margin-left: 15px;"></i>
            </div>
        </div>

        <h2 class="inner-title" style="font-family:'Playfair Display'; font-size:36px; font-weight:900; margin-bottom:40px; color:var(--t); line-height:1.1;"><?php echo htmlspecialchars($row['title']); ?></h2>

        <!-- ULTIMATE BRIEFING SUMMARY (6 ELITE POINTS) -->
        <div class="v-briefing">
            <h5>Briefing Summary</h5>
            <ul>
                <li>Expert curated analysis of premium lifestyle essentials.</li>
                <li>Exclusive high-fidelity intelligence for the modern gentleman.</li>
                <li>Priority discovery of limited-edition store selections.</li>
                <li>Strategic insights into elite briefings and rare editorial verdicts.</li>
                <li>In-depth craftsmanship reviews and brand heritage tracking.</li>
                <li>Real-time style reactions from the global MensHub community.</li>
            </ul>
        </div>

        <article class="b-txt">
            <?php 
            $shown_c = 0; $chunks = preg_split('/(<\/p>)/i', $row['content'], -1, PREG_SPLIT_DELIM_CAPTURE);
            $para_idx = 0; $total_count = count($prods_data);

            foreach($chunks as $chunk) {
                echo $chunk;
                if(stripos($chunk, '</p>') !== false) {
                    $para_idx++;
                    if($para_idx % 2 == 0 && $shown_c < $total_count) {
                        $it = $prods_data[$shown_c]; $sn = sLabel($it['affiliate_link']);
                        ?>
                        <div class="p-card">
                            <div class="p-vis"><img loading="lazy" src="/assets/images/<?php echo $it['product_image']; ?>"></div>
                            <div class="p-info">
                                <span style="font-family:'Outfit'; font-weight:900; font-size:10px; color:var(--p); letter-spacing:3px; text-transform:uppercase;">MensHub Choice</span>
                                <h4 style="font-family:'Playfair Display'; font-size:34px; color:var(--t); margin:12px 0; line-height:1.1;"><?php echo $it['product_title']; ?></h4>
                                <p style="font-size:16px; font-family:'Outfit'; color:#555; line-height:1.7;"><?php echo $it['product_description']; ?></p>
                                <a href="<?php echo $it['affiliate_link']; ?>" target="_blank" class="cta">Buy via <?php echo $sn; ?> &rarr;</a>
                            </div>
                        </div>
                        <?php $shown_c++;
                    }
                }
            }
            ?>

            <div class="m-only m-react">
                <div class="m-react-btn" onclick="rt('elite')">🔥 <span>Elite</span></div>
                <div class="m-react-btn" onclick="rt('rare')">💎 <span>Rare</span></div>
                <div class="m-react-btn" onclick="rt('top')">🙌 <span>Top Tier</span></div>
            </div>

            <div class="m-only m-strip">
                <div class="m-strip-txt" style="font-weight:900; font-size:18px;">Join The MensHub Elite Club</div>
                <div style="font-size:12px; margin-top:5px; opacity:0.9;">Unlock exclusive style briefings and rare deals.</div>
                <a href="/telegram" class="m-strip-btn">Join Telegram &rarr;</a>
            </div>

            <?php 
            if($shown_c < $total_count) {
                echo '<div style="font-family:\'Outfit\'; font-weight:900; letter-spacing:5px; color:var(--p); text-align:center; padding-top:80px; margin-top:50px; border-top:1px solid #eee; text-transform:uppercase; font-size:11px;">MensHub Prime Discovery</div>';
                for($kv = $shown_c; $kv < $total_count; $kv++) {
                   $p_it = $prods_data[$kv];
                   ?>
                   <div class="p-card">
                        <div class="p-vis"><img loading="lazy" src="/assets/images/<?php echo $p_it['product_image']; ?>"></div>
                        <div class="p-info">
                            <h4 style="font-family:'Playfair Display'; font-size:30px; color:var(--t); line-height:1.1;"><?php echo $p_it['product_title']; ?></h4>
                            <p style="font-size:15px; font-family:'Outfit'; color:#555; margin-top:10px; line-height:1.6;"><?php echo $p_it['product_description']; ?></p>
                            <a href="<?php echo $p_it['affiliate_link']; ?>" target="_blank" class="cta">Acquire &rarr;</a>
                        </div>
                   </div>
                   <?php
                }
            }
            ?>
        </article>
    </main>

    <aside class="s-pin">
        <!-- 🌟 CLUB -->
        <div class="news-card">
            <i class="fas fa-crown" style="font-size:35px; margin-bottom:15px;"></i>
            <div class="news-title">MensHub Access</div>
            <p style="font-size:11px; opacity:0.8; line-height:1.6;">The most sophisticated style intel, weekly.</p>
            <a href="/telegram" class="news-btn">Join The Club &rarr;</a>
        </div>

        <div class="s-card">
            <div class="s-head">MensHub Masterclass</div>
            <?php mysqli_data_seek($digital_desktop, 0); while($dp = mysqli_fetch_assoc($digital_desktop)): ?>
                <a href="/digital-product/<?php echo $dp['slug']; ?>" class="side-item">
                    <img loading="lazy" src="/uploads/digital_products/<?php echo $dp['image']; ?>" style="border-radius:12px; padding:0; background:none; aspect-ratio:1/1; object-fit:cover;">
                    <div class="side-item-txt"><?php echo $dp['title']; ?></div>
                </a>
            <?php endwhile; ?>
        </div>

        <?php if($v_row): ?>
        <div class="s-card">
            <div class="s-head">MensHub Brief (Video)</div>
            <div class="vid-brief">
                 <img src="/uploads/thumbs/<?php echo $v_row['thumb']; ?>">
                 <div class="play-pulse"><i class="fas fa-play"></i></div>
                 <a href="/video/<?php echo $v_row['slug']; ?>" style="position:absolute; inset:0; z-index:15;"></a>
            </div>
            <div class="side-item-txt" style="font-weight:900; color:#fff; display:block;"><?php echo $v_row['title']; ?></div>
            <div style="font-size:10px; color:var(--p); font-weight:800; text-transform:uppercase; margin-top:8px;">Watch Exclusive Briefing &rarr;</div>
        </div>
        <?php endif; ?>

        <!-- BLOG PRODUCTS -->
        <?php if(!empty($prods_data)): ?>
        <div class="s-card">
            <div class="s-head">Selected Intelligence</div>
            <?php foreach($prods_data as $bp): ?>
                <a href="<?php echo $bp['affiliate_link']; ?>" target="_blank" class="side-item">
                    <img loading="lazy" src="/assets/images/<?php echo $bp['product_image']; ?>">
                    <div class="side-item-txt"><?php echo $bp['product_title']; ?></div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- RELATED -->
        <div class="s-card">
            <div class="s-head">Related Bolgs</div>
            <?php mysqli_data_seek($rel_intel, 0); while($ri = mysqli_fetch_assoc($rel_intel)): ?>
                <a href="/blog/<?php echo $ri['slug']; ?>" class="side-item">
                    <img loading="lazy" src="/assets/images/<?php echo $ri['image']; ?>" style="padding:0; background:none; aspect-ratio:1/1; object-fit:cover;">
                    <div class="side-item-txt"><?php echo $ri['title']; ?></div>
                </a>
            <?php endwhile; ?>
        </div>

        <div class="s-card">
            <div class="s-head">Trending Intelligence</div>
            <div class="tag-box">
                <?php foreach($display_tags as $tag): ?>
                    <span class="tag-pill"><?php echo htmlspecialchars($tag); ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="s-card" style="background:linear-gradient(135deg, #1e293b, #0f172a);">
            <div class="s-head" style="color:#fff;">MensHub Store</div>
            <?php mysqli_data_seek($store_items, 0); while($st_i = mysqli_fetch_assoc($store_items)): ?>
                <a href="<?php echo $st_i['affiliate_link']; ?>" target="_blank" class="side-item">
                    <img loading="lazy" src="/assets/images/<?php echo $st_i['image']; ?>">
                    <div class="side-item-txt" style="color:#fff;"><?php echo $st_i['title']; ?></div>
                </a>
            <?php endwhile; ?>
        </div>
    </aside>
</div>

<section class="m-only m-sec">
    <?php if($v_row): ?>
    <div class="m-sec-h">Exclusive Briefing</div>
    <div class="m-vid-box">
         <img src="/uploads/thumbs/<?php echo $v_row['thumb']; ?>" class="m-vid-img">
         <div class="play-pulse"><i class="fas fa-play" style="font-size:18px;"></i></div>
         <a href="/video/<?php echo $v_row['slug']; ?>" style="position:absolute; inset:0; z-index:20;"></a>
         <div class="m-vid-info">
            <div style="font-weight:900; font-size:18px; color:#fff; line-height:1.2;"><?php echo $v_row['title']; ?></div>
            <div style="color:var(--p); font-size:10px; font-weight:900; margin-top:10px; text-transform:uppercase; letter-spacing:1px;">Watch Exclusive Briefing &rarr;</div>
         </div>
    </div>
    <?php endif; ?>

    <div class="m-sec-h">MensHub Masterclass</div>
    <?php mysqli_data_seek($digital_mobile, 0); if($dm = mysqli_fetch_assoc($digital_mobile)): ?>
        <div class="m-digi-item">
            <img src="/uploads/digital_products/<?php echo $dm['image']; ?>">
            <div style="font-weight:900; font-size:19px; color:#fff; line-height:1.3; padding:0 5px;"><?php echo $dm['title']; ?></div>
            <div style="font-size:12px; color:#888; margin-top:8px; display:block;">Elite Digital Blueprint For Style Mastery.</div>
            <a href="/digital-product/<?php echo $dm['slug']; ?>" class="m-digi-btn">Acquire Blueprint &rarr;</a>
        </div>
    <?php endif; ?>

    <div class="m-sec-h">MensHub Store Selection</div>
    <div class="m-slider">
        <?php mysqli_data_seek($store_items, 0); while($si = mysqli_fetch_assoc($store_items)): ?>
            <a href="<?php echo $si['affiliate_link']; ?>" target="_blank" class="m-slide-card" style="text-decoration:none;">
                <img src="/assets/images/<?php echo $si['image']; ?>">
                <div style="font-weight:800; font-size:11px; color:#fff; line-height:1.2; height:28px; overflow:hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo $si['title']; ?></div>
            </a>
        <?php endwhile; ?>
    </div>

    <div class="m-sec-h">Related Intelligence</div>
    <?php mysqli_data_seek($rel_intel, 0); while($ri = mysqli_fetch_assoc($rel_intel)): ?>
        <a href="/blog/<?php echo $ri['slug']; ?>" style="text-decoration:none; display:flex; gap:15px; align-items:center; background:rgba(255,255,255,0.03); padding:18px; border-radius:22px; margin-bottom:15px; border:1px solid rgba(255,255,255,0.06);">
            <img src="/assets/images/<?php echo $ri['image']; ?>" style="width:75px; height:75px; object-fit:cover; border-radius:14px; background:#fff;">
            <div style="font-weight:800; font-size:15px; color:#fff; line-height:1.3;"><?php echo $ri['title']; ?></div>
        </a>
    <?php endwhile; ?>
</section>

</div>

<script>
window.onscroll = function() {
    let ws = document.body.scrollTop || document.documentElement.scrollTop;
    let h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    let s = (ws / h) * 100;
    const b = document.getElementById('pBar'); if(b) b.style.width = s + "%";
}
function uS() { if(navigator.share) { navigator.share({ title: document.title, url: window.location.href }); } else { cpL(); } }
function cpL() { navigator.clipboard.writeText(window.location.href); alert('MensHub link copied!'); }
function shWA() { window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(document.title + ' ' + window.location.href)); }
function rt(m) { alert('MensHub Vote Counts!'); }
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>