<?php
session_start();
$page_title = "Website Settings";
include 'admin_header.php';

$data = mysqli_query($conn,"SELECT * FROM settings LIMIT 1");

// TEMPORARY AUTO-MIGRATION
function columnExists($conn, $table, $column) {
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return mysqli_num_rows($res) > 0;
}
if(!columnExists($conn, 'settings', 'show_blog_widgets')) mysqli_query($conn, "ALTER TABLE settings ADD COLUMN show_blog_widgets INT DEFAULT 1");
if(!columnExists($conn, 'settings', 'blog_products_position')) mysqli_query($conn, "ALTER TABLE settings ADD COLUMN blog_products_position VARCHAR(50) DEFAULT 'middle'");
if(!columnExists($conn, 'settings', 'active_sale_event')) mysqli_query($conn, "ALTER TABLE settings ADD COLUMN active_sale_event VARCHAR(50) DEFAULT 'none'");
if(!columnExists($conn, 'settings', 'show_wishlist')) mysqli_query($conn, "ALTER TABLE settings ADD COLUMN show_wishlist INT DEFAULT 1");
if(!columnExists($conn, 'settings', 'sale_title')) mysqli_query($conn, "ALTER TABLE settings ADD COLUMN sale_title VARCHAR(255) DEFAULT ''");
if(!columnExists($conn, 'settings', 'sale_end_date')) mysqli_query($conn, "ALTER TABLE settings ADD COLUMN sale_end_date DATETIME NULL");
if(!columnExists($conn, 'settings', 'hide_mobile_nav_on_menu')) mysqli_query($conn, "ALTER TABLE settings ADD COLUMN hide_mobile_nav_on_menu INT DEFAULT 1");
if(!columnExists($conn, 'settings', 'show_promotional_offers')) mysqli_query($conn, "ALTER TABLE settings ADD COLUMN show_promotional_offers INT DEFAULT 1");

$data = mysqli_query($conn,"SELECT * FROM settings LIMIT 1");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){
  $name = mysqli_real_escape_string($conn, $_POST['site_name']);
  $email = mysqli_real_escape_string($conn, $_POST['admin_email']);
  $footer = mysqli_real_escape_string($conn, $_POST['footer_text']);
  $rzp_id = mysqli_real_escape_string($conn, $_POST['razorpay_key_id']);
  $rzp_secret = mysqli_real_escape_string($conn, $_POST['razorpay_key_secret']);
  $app_mode = isset($_POST['mobile_app_mode']) ? 1 : 0;
  $deals_bag = isset($_POST['show_deals_bag']) ? 1 : 0;
  $blog_widgets = isset($_POST['show_blog_widgets']) ? 1 : 0;
  $wishlist = isset($_POST['show_wishlist']) ? 1 : 0;
  $blog_pos = mysqli_real_escape_string($conn, $_POST['blog_products_position']);
  $sale_event = mysqli_real_escape_string($conn, $_POST['active_sale_event']);
  $sale_title = mysqli_real_escape_string($conn, $_POST['sale_title']);
  $show_amazon = isset($_POST['show_amazon']) ? 1 : 0;
  $show_flipkart = isset($_POST['show_flipkart']) ? 1 : 0;
  $show_myntra = isset($_POST['show_myntra']) ? 1 : 0;
  $show_ajio = isset($_POST['show_ajio']) ? 1 : 0;
  $hide_on_menu = isset($_POST['hide_mobile_nav_on_menu']) ? 1 : 0;
  $show_promo = isset($_POST['show_promotional_offers']) ? 1 : 0;

  if(!empty($_FILES['logo']['name'])){
    $img = $_FILES['logo']['name'];
    $tmp = $_FILES['logo']['tmp_name'];
    if(!is_dir("uploads")) mkdir("uploads");
    $new = time().$img;
    move_uploaded_file($tmp, "uploads/".$new);

    mysqli_query($conn,"UPDATE settings SET 
      site_name='$name',
      logo='$new',
      admin_email='$email',
      footer_text='$footer',
      razorpay_key_id='$rzp_id',
      razorpay_key_secret='$rzp_secret',
      mobile_app_mode='$app_mode',
      show_deals_bag='$deals_bag',
      show_blog_widgets='$blog_widgets',
      show_wishlist='$wishlist',
      blog_products_position='$blog_pos',
      active_sale_event='$sale_event',
      sale_title='$sale_title',
      show_amazon='$show_amazon',
      show_flipkart='$show_flipkart',
      show_myntra='$show_myntra',
      show_ajio='$show_ajio',
      hide_mobile_nav_on_menu='$hide_on_menu',
      show_promotional_offers='$show_promo'") or die(mysqli_error($conn));
  } else {
    mysqli_query($conn,"UPDATE settings SET 
      site_name='$name',
      admin_email='$email',
      footer_text='$footer',
      razorpay_key_id='$rzp_id',
      razorpay_key_secret='$rzp_secret',
      mobile_app_mode='$app_mode',
      show_deals_bag='$deals_bag',
      show_blog_widgets='$blog_widgets',
      show_wishlist='$wishlist',
      blog_products_position='$blog_pos',
      active_sale_event='$sale_event',
      sale_title='$sale_title',
      show_amazon='$show_amazon',
      show_flipkart='$show_flipkart',
      show_myntra='$show_myntra',
      show_ajio='$show_ajio',
      hide_mobile_nav_on_menu='$hide_on_menu',
      show_promotional_offers='$show_promo'") or die(mysqli_error($conn));
  }
  ?>
  /* CINEMATIC SUCCESS POPUP */
  .admin-success-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 999999; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(15px); animation: fadeIn 0.4s ease; }
  .admin-success-box { background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 30px; padding: 50px 40px; text-align: center; box-shadow: 0 40px 100px rgba(0,0,0,0.8), 0 0 60px rgba(34, 197, 94, 0.1); animation: popScale 0.6s cubic-bezier(0.19, 1, 0.22, 1) forwards; max-width: 400px; width: 90%; position: relative; overflow: hidden; }
  .admin-success-box::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(34, 197, 94, 0.1) 0%, transparent 70%); pointer-events: none; }
  .admin-success-icon { width: 100px; height: 100px; background: #22c55e; color: #fff; border-radius: 50%; font-size: 45px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 25px; box-shadow: 0 0 30px rgba(34, 197, 94, 0.4); animation: iconPulse 2s infinite; }
  .admin-success-box h3 { color: #fff; font-size: 28px; font-weight: 900; margin-bottom: 12px; letter-spacing: -0.5px; }
  .admin-success-box p { color: #94a3b8; font-size: 15px; margin-bottom: 30px; line-height: 1.6; }
  .admin-success-btn { background: #22c55e; color: #000; border: none; padding: 16px 40px; border-radius: 16px; font-size: 16px; font-weight: 800; cursor: pointer; transition: 0.3s; width: 100%; box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3); text-transform: uppercase; letter-spacing: 1px; }
  .admin-success-btn:hover { background: #4ade80; transform: translateY(-3px); box-shadow: 0 15px 35px rgba(34, 197, 94, 0.5); }
  
  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
  @keyframes popScale { from { transform: scale(0.7) translateY(30px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }
  @keyframes iconPulse { 0%, 100% { transform: scale(1); box-shadow: 0 0 30px rgba(34, 197, 94, 0.4); } 50% { transform: scale(1.1); box-shadow: 0 0 50px rgba(34, 197, 94, 0.6); } }

  /* Premium Theme Cards UI */
  .theme-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px; margin-top: 10px; }
  .theme-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 15px; padding: 15px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden; text-align: left; }
  .theme-card:hover { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1); transform: translateY(-2px); }
  .theme-card.active { background: rgba(255,255,255,0.08); border-color: var(--p-color); box-shadow: 0 10px 25px -10px var(--p-color); }
  .theme-card .t-icon { font-size: 24px; margin-bottom: 8px; display: block; }
  .theme-card .t-name { font-size: 13px; font-weight: 700; color: #fff; display: block; }
  .theme-card .t-check { position: absolute; top: 12px; right: 12px; font-size: 12px; color: var(--p-color); opacity: 0; transform: scale(0.5); transition: 0.3s; }
  .theme-card.active .t-check { opacity: 1; transform: scale(1); }
  
  .tc-none { --p-color: #94a3b8; }
  .tc-summer { --p-color: #fbbf24; }
  .tc-winter { --p-color: #38bdf8; }
  .tc-festival { --p-color: #f43f5e; }

  /* Premium Select Styling */
  .premium-select-wrapper { position: relative; margin-bottom: 25px; }
  .premium-select { width: 100%; padding: 15px 20px 15px 50px; background: rgba(15, 23, 42, 0.6); border: 2px solid rgba(255,255,255,0.05); color: #fff !important; border-radius: 15px; font-size: 15px; font-weight: 600; appearance: none; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
  .premium-select:focus { border-color: var(--primary); background: rgba(15, 23, 42, 0.8); outline: none; }
  .premium-select-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--primary); font-size: 18px; pointer-events: none; z-index: 5; }
  .premium-select-arrow { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; transition: 0.3s; }
  
  /* Admin Theme Injection */
  body.admin-winter { --primary: #38bdf8 !important; }
  body.admin-summer { --primary: #ea580c !important; }
  body.admin-festival { --primary: #f43f5e !important; }
  
  .premium-save-bar { position: sticky; bottom: 20px; right: 0; left: 0; background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); padding: 15px 30px; border-radius: 20px; display: flex; align-items: center; justify-content: space-between; z-index: 100; box-shadow: 0 -10px 30px rgba(0,0,0,0.5), 0 20px 40px rgba(0,0,0,0.4); margin-top: 40px; }
  .save-info { display: flex; align-items: center; gap: 15px; color: #fff; }
  .save-info i { font-size: 20px; color: #22c55e !important; }
  .save-info-text b { display: block; font-size: 14px; }
  .save-info-text small { color: var(--text-muted); font-size: 11px; }
  .admin-btn-save { transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
  
  /* ICON FIX: Ensure FontAwesome always visible */
  i.fas, i.fab, i.far { font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important; font-weight: 900 !important; }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('admin-<?= $row["active_sale_event"] ?>');
    });
  </script>
  <div class="admin-success-overlay">
    <div class="admin-success-box">
        <div class="admin-success-icon"><i class="fas fa-check"></i></div>
        <h3>Mission Accomplished</h3>
        <p>Your platform configurations have been synchronized with the live storefront successfully.</p>
        <button class="admin-success-btn" onclick="window.location='settings.php'">Return to Dashboard</button>
    </div>
  </div>
  <?php
  exit;
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:40px;">
      
      <!-- Left: General Config -->
      <div>
        <h3 style="margin-bottom:20px; color:var(--primary);"><i class="fas fa-globe"></i> General Configuration</h3>
        
        <label>Site Name</label>
        <input type="text" name="site_name" value="<?= htmlspecialchars($row['site_name']); ?>" placeholder="MensHubPrime">

        <label>Admin Email</label>
        <input type="email" name="admin_email" value="<?= htmlspecialchars($row['admin_email']); ?>" placeholder="admin@example.com">

        <label>Footer Credit Text</label>
        <input type="text" name="footer_text" value="<?= htmlspecialchars($row['footer_text']); ?>" placeholder="© 2024 MensHubPrime">
        
        <div style="margin-top:20px;">
          <label>Current Logo</label><br>
          <div style="background:var(--bg-dark); padding:10px; border-radius:10px; display:inline-block; margin-bottom:10px;">
            <img src="uploads/<?= $row['logo']; ?>" style="height:50px; object-fit:contain;">
          </div>
          <label>Update Logo Image</label>
          <input type="file" name="logo">
        </div>
      </div>

      <!-- Right: API & Payment -->
      <div>
        <h3 style="margin-bottom:20px; color:#22c55e;"><i class="fas fa-credit-card"></i> Payment Gateway (Razorpay)</h3>
        
        <div class="alert" style="background:rgba(34, 197, 94, 0.1); border:1px solid rgba(34, 197, 94, 0.2); color:#22c55e; padding:15px; border-radius:10px; margin-bottom:20px; font-size:13px;">
          <i class="fas fa-info-circle"></i> These keys are used for processing digital product payments. Ensure you use the correct environment keys.
        </div>

        <label>Razorpay Key ID</label>
        <input type="text" name="razorpay_key_id" value="<?= htmlspecialchars($row['razorpay_key_id']); ?>" placeholder="rzp_test_...">

        <label>Razorpay Key Secret</label>
        <input type="password" name="razorpay_key_secret" value="<?= htmlspecialchars($row['razorpay_key_secret']); ?>" placeholder="••••••••••••••••">
        
        <div style="margin-top:40px; padding:20px; background:rgba(255,255,255,0.03); border-radius:15px; border:1px dashed var(--glass-border);">
          <p style="font-size:12px; color:var(--text-muted); line-height:1.6;">
            <strong>Pro Tip:</strong> When switching from Test to Live mode, make sure to update BOTH the Key ID and the Key Secret simultaneously to avoid transaction failures.
          </p>
        </div>

        <h3 style="margin-top:40px; margin-bottom:20px; color:#fb923c;"><i class="fas fa-mobile-alt"></i> Mobile App Experience</h3>
        <div style="background:rgba(251, 146, 60, 0.05); padding:20px; border-radius:15px; border:1px solid rgba(251, 146, 60, 0.1);">
          <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
              <strong style="display:block; color:#fff; margin-bottom:5px;">Premium App Mode</strong>
              <small style="color:var(--text-muted);">Enable PWA features, bottom navigation, and premium mobile layout.</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="mobile_app_mode" <?= ($row['mobile_app_mode'] ?? 0) ? 'checked' : '' ?>>
              <span class="slider round"></span>
            </label>
          </div>

          <div style="display:flex; align-items:center; justify-content:space-between; margin-top:20px; padding-top:20px; border-top:1px solid rgba(251, 146, 60, 0.1);">
            <div>
              <strong style="display:block; color:#fff; margin-bottom:5px;">Mobile Deals Bag</strong>
              <small style="color:var(--text-muted);">Show a curated "Bag" icon next to search for top value deals.</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="show_deals_bag" <?= ($row['show_deals_bag'] ?? 0) ? 'checked' : '' ?>>
              <span class="slider round"></span>
            </label>
          </div>

          <div style="display:flex; align-items:center; justify-content:space-between; margin-top:20px; padding-top:20px; border-top:1px solid rgba(251, 146, 60, 0.1);">
            <div>
              <strong style="display:block; color:#fff; margin-bottom:5px;">Distraction-Free Overlays</strong>
              <small style="color:var(--text-muted);">Hide bottom nav when Menu, Search, or Deals Bag is open.</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="hide_mobile_nav_on_menu" <?= ($row['hide_mobile_nav_on_menu'] ?? 1) ? 'checked' : '' ?>>
              <span class="slider round"></span>
            </label>
          </div>
        </div>

        <h3 style="margin-top:40px; margin-bottom:20px; color:#8b5cf6;"><i class="fas fa-chart-line"></i> Strategic Growth & Sales</h3>
        <div style="background:rgba(139, 92, 246, 0.05); padding:20px; border-radius:15px; border:1px solid rgba(139, 92, 246, 0.1);">
          
          <!-- Blog High-Conversion -->
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div>
              <strong style="display:block; color:#fff; margin-bottom:5px;">Blog High-Conversion Tools</strong>
              <small style="color:var(--text-muted);">Enable floating "Hot Deal" widgets in blogs.</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="show_blog_widgets" <?= ($row['show_blog_widgets'] ?? 0) ? 'checked' : '' ?>>
              <span class="slider round"></span>
            </label>
          </div>

          <!-- Promotional Offers Slider -->
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; padding-top:20px; border-top:1px solid rgba(139, 92, 246, 0.1);">
            <div>
              <strong style="display:block; color:#fff; margin-bottom:5px;">Auto-Sliding Promotional Offers</strong>
              <small style="color:var(--text-muted);">Global toggle for the sliding banner cards on the categories page.</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="show_promotional_offers" <?= ($row['show_promotional_offers'] ?? 1) ? 'checked' : '' ?>>
              <span class="slider round"></span>
            </label>
          </div>

          <label>Blog Product Position</label>
          <select name="blog_products_position" style="width:100%; padding:10px; background:var(--bg-dark); color:#fff; border:1px solid var(--glass-border); border-radius:8px; margin-bottom:20px;">
            <option value="bottom" <?= ($row['blog_products_position'] == 'bottom') ? 'selected' : '' ?>>Bottom of Post (Default)</option>
            <option value="middle" <?= ($row['blog_products_position'] == 'middle') ? 'selected' : '' ?>>After 2 Paragraphs (High Conversion)</option>
            <option value="top" <?= ($row['blog_products_position'] == 'top') ? 'selected' : '' ?>>Top of Post (Aggressive)</option>
          </select>

          <!-- Seasonal Sale Hub -->
          <label style="display:flex; align-items:center; gap:8px; color:#fff; font-size:13px; margin-bottom:12px; font-weight:700;">
            <i class="fas fa-meteor"></i> Active Season Campaign
          </label>
          
          <div class="premium-select-wrapper">
            <i class="fas fa-calendar-check premium-select-icon"></i>
            <select name="active_sale_event" id="themeSelect" class="premium-select" onchange="updateThemePreview(this.value)">
                <option value="none" <?= ($row['active_sale_event'] == 'none') ? 'selected' : '' ?>>🚫 No Active Campaign (Standard)</option>
                <option value="winter" <?= ($row['active_sale_event'] == 'winter') ? 'selected' : '' ?>>❄️ Winter Mega Sale (Blue Aesthetic)</option>
                <option value="summer" <?= ($row['active_sale_event'] == 'summer') ? 'selected' : '' ?>>☀️ Summer Clearance (Orange Aesthetic)</option>
                <option value="festival" <?= ($row['active_sale_event'] == 'festival') ? 'selected' : '' ?>>🎆 Festival Bonanza (Rose Aesthetic)</option>
            </select>
            <i class="fas fa-chevron-down premium-select-arrow"></i>
          </div>

          <label style="font-size:12px; color:var(--text-muted); margin-bottom:8px; display:block;">Sale Tagline / Headline</label>
          <input type="text" name="sale_title" value="<?= htmlspecialchars($row['sale_title'] ?? ''); ?>" placeholder="e.g. End of Season Sale - 50% Off" style="margin-bottom:20px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); padding:15px; border-radius:12px; color:#fff; width:100%;">

          <script>
          function updateThemePreview(val) {
            // Live Admin Theme Preview
            document.body.className = ''; 
            document.body.classList.add('admin-' + val);
            
            // Visual feedback on save button
            const btn = document.querySelector('.admin-btn-save');
            if(btn) {
              btn.classList.add('pulse-save');
              setTimeout(() => btn.classList.remove('pulse-save'), 1000);
            }
          }
          </script>

          <script>
          function setTheme(val) {
            document.getElementById('themeInput').value = val;
            document.querySelectorAll('.theme-card').forEach(c => c.classList.remove('active'));
            const activeCard = document.querySelector('.tc-' + val);
            if(activeCard) activeCard.classList.add('active');
            
            // Live Admin Theme Preview
            document.body.className = ''; 
            document.body.classList.add('admin-' + val);
            
            // Pulse the Save button to remind them
            const btn = document.querySelector('.admin-btn-save');
            if(btn) {
              btn.style.transform = 'scale(1.05)';
              setTimeout(() => { btn.style.transform = 'scale(1)'; }, 200);
            }
          }
          </script>

          <!-- Brand Affiliate Hub -->
          <div style="display:flex; align-items:center; justify-content:space-between; padding-top:20px; border-top:1px solid rgba(139, 92, 246, 0.1);">
            <div>
              <strong style="display:block; color:#fff; margin-bottom:5px;">Brand Affiliate Hub (Stores)</strong>
              <small style="color:var(--text-muted);">Enable the premium 'Stores' page to show deals by Amazon, Flipkart, etc.</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="show_wishlist" <?= ($row['show_wishlist'] ?? 0) ? 'checked' : '' ?>>
              <span class="slider round"></span>
            </label>
          </div>

          <!-- Individual Brands Control -->
          <div style="margin-top:20px; padding:15px; background:rgba(255,255,255,0.03); border-radius:12px; border:1px solid rgba(255,255,255,0.05);">
            <p style="color:#fff; font-size:13px; font-weight:700; margin-bottom:15px; text-transform:uppercase; letter-spacing:1px; opacity:0.7;">Active Stores</p>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
              <div style="display:flex; align-items:center; justify-content:space-between; background:var(--bg-dark); padding:10px 15px; border-radius:8px;">
                <span style="color:#cbd5e1; font-size:13px;"><i class="fab fa-amazon" style="color:#ff9900; margin-right:8px;"></i> Amazon</span>
                <label class="switch" style="transform:scale(0.8);">
                  <input type="checkbox" name="show_amazon" <?= ($row['show_amazon'] ?? 1) ? 'checked' : '' ?>>
                  <span class="slider round"></span>
                </label>
              </div>
              <div style="display:flex; align-items:center; justify-content:space-between; background:var(--bg-dark); padding:10px 15px; border-radius:8px;">
                <span style="color:#cbd5e1; font-size:13px;"><i class="fas fa-shopping-cart" style="color:#2874f0; margin-right:8px;"></i> Flipkart</span>
                <label class="switch" style="transform:scale(0.8);">
                  <input type="checkbox" name="show_flipkart" <?= ($row['show_flipkart'] ?? 1) ? 'checked' : '' ?>>
                  <span class="slider round"></span>
                </label>
              </div>
              <div style="display:flex; align-items:center; justify-content:space-between; background:var(--bg-dark); padding:10px 15px; border-radius:8px;">
                <span style="color:#cbd5e1; font-size:13px;"><i class="fas fa-shopping-bag" style="color:#ff3f6c; margin-right:8px;"></i> Myntra</span>
                <label class="switch" style="transform:scale(0.8);">
                  <input type="checkbox" name="show_myntra" <?= ($row['show_myntra'] ?? 1) ? 'checked' : '' ?>>
                  <span class="slider round"></span>
                </label>
              </div>
              <div style="display:flex; align-items:center; justify-content:space-between; background:var(--bg-dark); padding:10px 15px; border-radius:8px;">
                <span style="color:#cbd5e1; font-size:13px;"><i class="fas fa-tshirt" style="color:#0f172a; margin-right:8px;"></i> Ajio</span>
                <label class="switch" style="transform:scale(0.8);">
                  <input type="checkbox" name="show_ajio" <?= ($row['show_ajio'] ?? 1) ? 'checked' : '' ?>>
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
          </div>

        </div>

      </div>


    </div>

    <div class="premium-save-bar">
      <div class="save-info">
        <i class="fas fa-shield-alt"></i>
        <div class="save-info-text">
          <b>Global Configuration Safe</b>
          <small>Changes will be applied instantly to the storefront.</small>
        </div>
      </div>
      <button type="submit" name="update" class="admin-btn btn-primary admin-btn-save" style="padding:15px 50px; font-size:15px; border-radius:12px; margin:0;">
        <i class="fas fa-cloud-upload-alt"></i> Update Platform
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>
