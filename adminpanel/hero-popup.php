<?php
session_start();
$page_title = "Hero Promo Popup";
include 'admin_header.php';

// Tables Setup
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS hero_popup (
  id INT AUTO_INCREMENT PRIMARY KEY,
  emoji VARCHAR(10) DEFAULT '🔥',
  title VARCHAR(100) DEFAULT 'Limited Deal!',
  description VARCHAR(200) DEFAULT 'Extra 10% OFF on all orders today only',
  btn_text VARCHAR(50) DEFAULT 'Grab',
  link VARCHAR(500) DEFAULT '/Menshubprime/deals',
  status ENUM('active','inactive') DEFAULT 'inactive'
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS hero_popup_slides (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image_path VARCHAR(500) NOT NULL,
  link VARCHAR(500) DEFAULT '#',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Migration for link column
mysqli_query($conn, "ALTER TABLE hero_popup_slides ADD COLUMN IF NOT EXISTS link VARCHAR(500) DEFAULT '#' AFTER image_path");

// Handle Delete Slide
if(isset($_GET['delete_slide'])){
  $id = (int)$_GET['delete_slide'];
  $slide = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_path FROM hero_popup_slides WHERE id=$id"));
  if($slide){
    @unlink("../" . $slide['image_path']);
    mysqli_query($conn, "DELETE FROM hero_popup_slides WHERE id=$id");
    echo "<script>window.location='hero-popup.php';</script>";
  }
}

// Handle Save Text Settings
if(isset($_POST['save_text'])){
  $emoji = mysqli_real_escape_string($conn, $_POST['emoji']);
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $btn_text = mysqli_real_escape_string($conn, $_POST['btn_text']);
  $link = mysqli_real_escape_string($conn, $_POST['link']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  $check = mysqli_query($conn, "SELECT id FROM hero_popup LIMIT 1");
  if(mysqli_num_rows($check) > 0){
    mysqli_query($conn, "UPDATE hero_popup SET emoji='$emoji', title='$title', description='$description', btn_text='$btn_text', link='$link', status='$status' WHERE 1");
  } else {
    mysqli_query($conn, "INSERT INTO hero_popup (emoji, title, description, btn_text, link, status) VALUES ('$emoji', '$title', '$description', '$btn_text', '$link', '$status')");
  }
  $success_msg = "✅ Popup settings updated successfully!";
}

// Add New Slide
if(isset($_POST['add_slide'])){
  $slide_link = mysqli_real_escape_string($conn, $_POST['slide_link']);
  if(isset($_FILES['slide_img']) && $_FILES['slide_img']['error'] == 0){
    $target_dir = "../assets/images/banners/";
    if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    $filename = "slide_" . time() . '_' . basename($_FILES["slide_img"]["name"]);
    $target_file = $target_dir . $filename;
    if(move_uploaded_file($_FILES["slide_img"]["tmp_name"], $target_file)){
       $img_path = "assets/images/banners/" . $filename;
       mysqli_query($conn, "INSERT INTO hero_popup_slides (image_path, link) VALUES ('$img_path', '$slide_link')");
       $success_msg = "✅ New slide with link added!";
    }
  }
}

$popup = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM hero_popup LIMIT 1"));
$slides = mysqli_query($conn, "SELECT * FROM hero_popup_slides ORDER BY id DESC");
?>

<?php if(isset($success_msg)): ?>
  <div style='background:rgba(34,197,94,0.15);border:1px solid #22c55e;color:#22c55e;padding:12px 18px;border-radius:10px;margin-bottom:20px;font-weight:600;'><?= $success_msg ?></div>
<?php endif; ?>

<div style="display:grid; grid-template-columns:1fr 400px; gap:25px; align-items:start;">

  <div>
    <!-- 1. TEXT SETTINGS -->
    <div class="admin-card" style="margin-bottom:25px;">
      <h2 style="color:var(--primary); font-size:18px; margin:0 0 20px;">📱 Notification Text Settings</h2>
      <form method="post" class="admin-form">
        <div style="display:grid; gap:18px;">
          <div style="display:grid; grid-template-columns:80px 1fr; gap:15px;">
            <div><label>Emoji</label><input type="text" name="emoji" value="<?= $popup['emoji'] ?>"></div>
            <div><label>Bold Title</label><input type="text" name="title" value="<?= $popup['title'] ?>" required></div>
          </div>
          <div><label>Description Text</label><input type="text" name="description" value="<?= $popup['description'] ?>" required></div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div><label>Button Text</label><input type="text" name="btn_text" value="<?= $popup['btn_text'] ?>" required></div>
            <div><label>Button Link</label><input type="text" name="link" value="<?= $popup['link'] ?>" required></div>
          </div>
          <div>
            <label>Status</label>
            <select name="status"><option value="active" <?= $popup['status']=='active'?'selected':'' ?>>✅ Active</option><option value="inactive" <?= $popup['status']=='inactive'?'selected':'' ?>>❌ Inactive</option></select>
          </div>
          <button type="submit" name="save_text" class="admin-btn btn-primary" style="justify-content:center;">Save Text Settings</button>
        </div>
      </form>
    </div>

    <!-- 2. SLIDER IMAGES -->
    <div class="admin-card">
      <h2 style="color:var(--primary); font-size:18px; margin:0 0 20px;">🖼️ Multi-Image Slider Management</h2>
      
      <form method="post" enctype="multipart/form-data" style="background:rgba(255,255,255,0.03); padding:20px; border-radius:12px; border:1px dashed rgba(255,255,255,0.1); margin-bottom:25px;">
        <label>Add New Slide with Link</label>
        <div style="display:grid; gap:12px; margin-top:8px;">
          <input type="file" name="slide_img" accept="image/*" required style="background:none; border:none; padding:0;">
          <input type="text" name="slide_link" placeholder="Paste link here (e.g. /Menshubprime/product/123)" required style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:10px; border-radius:8px; color:#fff;">
          <button type="submit" name="add_slide" class="admin-btn btn-secondary" style="justify-content:center;"><i class="fas fa-plus"></i> Add Slide to Slider</button>
        </div>
      </form>

      <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:15px;">
        <?php while($s = mysqli_fetch_assoc($slides)): ?>
          <div style="position:relative; border-radius:12px; overflow:hidden; border:1px solid rgba(255,255,255,0.1); background:#0b1220;">
            <img src="../<?= $s['image_path'] ?>" style="width:100%; height:110px; object-fit:cover; display:block;">
            <div style="background:rgba(0,0,0,0.5); padding:5px 10px; font-size:10px; color:#94a3b8; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">Link: <?= $s['link'] ?></div>
            <a href="?delete_slide=<?= $s['id'] ?>" onclick="return confirm('Delete this slide?')" style="position:absolute; top:5px; right:5px; background:#ef4444; color:#fff; width:22px; height:22px; border-radius:50%; display:flex; align-items:center; justify-content:center; text-decoration:none; font-size:10px;"><i class="fas fa-trash"></i></a>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>

  <!-- LIVE PREVIEW CONTAINER -->
  <div class="admin-card" style="position:sticky; top:20px;">
    <h3 style="color:var(--text-muted); font-size:14px; margin:0 0 15px; font-weight:600;">📱 PREVIEW STACK</h3>
    <div style="background:#0b1220; border-radius:20px; padding:15px; border:1px solid rgba(255,255,255,0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
       
       <!-- 1. Notification Bar Preview -->
       <div style="background:rgba(15,23,42,0.95); border-radius:12px; padding:10px; margin-bottom:10px; display:flex; align-items:center; gap:12px; border:1px solid rgba(255,255,255,0.1); position:relative;">
          <span style="font-size:22px;"><?= htmlspecialchars($popup['emoji']) ?></span>
          <div style="flex:1;">
            <div style="color:#fff; font-size:11px; font-weight:800;"><?= htmlspecialchars($popup['title']) ?></div>
            <div style="color:rgba(255,255,255,0.6); font-size:9px;"><?= htmlspecialchars($popup['description']) ?></div>
          </div>
          <span style="background:#fb923c; color:#fff; font-size:9px; font-weight:800; padding:4px 10px; border-radius:6px;"><?= htmlspecialchars($popup['btn_text']) ?></span>
       </div>

       <!-- 2. Lite Card Slider Preview -->
       <div style="height:120px; background:#1e293b; border-radius:12px; overflow:hidden; border:1px solid rgba(255,255,255,0.1); position:relative;">
          <?php 
          // Fetch first slide for preview
          $preview_slide = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_path FROM hero_popup_slides ORDER BY id DESC LIMIT 1"));
          if($preview_slide): ?>
            <img src="../<?= $preview_slide['image_path'] ?>" style="width:100%; height:100%; object-fit:cover;">
            <div style="position:absolute; bottom:8px; left:8px; background:rgba(0,0,0,0.6); padding:2px 8px; border-radius:10px; color:#fff; font-size:8px;">Live Preview</div>
          <?php else: ?>
            <div style="display:flex; align-items:center; justify-content:center; height:100%; color:rgba(255,255,255,0.2); font-size:10px; text-align:center;">
              NO IMAGES UPLOADED<br>Add slides to see preview
            </div>
          <?php endif; ?>
       </div>

    </div>
    <p style="color:var(--text-muted); font-size:11px; text-align:center; margin-top:15px;">
      Status: <strong style="color:<?= $popup['status']=='active'?'#22c55e':'#ef4444' ?>"><?= strtoupper($popup['status']) ?></strong>
    </p>
  </div>

</div>

<?php include 'admin_footer.php'; ?>
