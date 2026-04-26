<?php
session_start();
$page_title = "Mobile Banners";
include 'admin_header.php';

// Create table if not exists
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS mobile_banners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  link VARCHAR(500) DEFAULT '#',
  status ENUM('active','inactive') DEFAULT 'active',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Toggle status
if(isset($_GET['toggle'])){
  $id = (int)$_GET['toggle'];
  $r = mysqli_fetch_assoc(mysqli_query($conn,"SELECT status FROM mobile_banners WHERE id=$id"));
  $new = ($r['status']=='active') ? 'inactive' : 'active';
  mysqli_query($conn,"UPDATE mobile_banners SET status='$new' WHERE id=$id");
  header("Location: mobile-banners.php"); exit();
}

// Delete
if(isset($_GET['delete'])){
  $id = (int)$_GET['delete'];
  $r = mysqli_fetch_assoc(mysqli_query($conn,"SELECT image FROM mobile_banners WHERE id=$id"));
  if($r && file_exists("../assets/images/".$r['image'])) unlink("../assets/images/".$r['image']);
  mysqli_query($conn,"DELETE FROM mobile_banners WHERE id=$id");
  header("Location: mobile-banners.php"); exit();
}

$banners = mysqli_query($conn,"SELECT * FROM mobile_banners ORDER BY sort_order ASC, id DESC");
?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
  <div>
    <h2 style="color:#fff; margin:0; font-size:20px;">📱 Mobile Banner Slider</h2>
    <p style="color:var(--text-muted); font-size:13px; margin:5px 0 0;">Banners shown on home page mobile slider</p>
  </div>
  <a href="add-mobile-banner.php" class="admin-btn btn-primary">
    <i class="fas fa-plus"></i> Add Banner
  </a>
</div>

<div class="admin-card">
  <table style="width:100%; border-collapse:collapse;">
    <thead>
      <tr style="border-bottom:1px solid var(--glass-border);">
        <th style="padding:12px; text-align:left; color:var(--text-muted); font-size:13px;">Banner</th>
        <th style="padding:12px; text-align:left; color:var(--text-muted); font-size:13px;">Title</th>
        <th style="padding:12px; text-align:left; color:var(--text-muted); font-size:13px;">Link</th>
        <th style="padding:12px; text-align:left; color:var(--text-muted); font-size:13px;">Order</th>
        <th style="padding:12px; text-align:left; color:var(--text-muted); font-size:13px;">Status</th>
        <th style="padding:12px; text-align:left; color:var(--text-muted); font-size:13px;">Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php while($b = mysqli_fetch_assoc($banners)): ?>
      <tr style="border-bottom:1px solid var(--glass-border);">
        <td style="padding:12px;">
          <img src="../assets/images/<?= htmlspecialchars($b['image']) ?>" 
               style="width:100px; height:45px; object-fit:cover; border-radius:8px; border:1px solid var(--glass-border);">
        </td>
        <td style="padding:12px; color:#fff; font-weight:600;"><?= htmlspecialchars($b['title']) ?></td>
        <td style="padding:12px;">
          <a href="<?= htmlspecialchars($b['link']) ?>" target="_blank" 
             style="color:var(--primary); font-size:12px; text-decoration:none;">
            <?= strlen($b['link']) > 40 ? substr($b['link'],0,40).'...' : htmlspecialchars($b['link']) ?>
          </a>
        </td>
        <td style="padding:12px; color:var(--text-muted);"><?= $b['sort_order'] ?></td>
        <td style="padding:12px;">
            <?php if($b['status']=='active'): ?>
              <span class="badge badge-success">Active</span>
            <?php else: ?>
              <span class="badge badge-warning">Inactive</span>
            <?php endif; ?>
        </td>
        <td style="padding:12px;">
          <div style="display:flex; gap:8px;">
            <a href="?toggle=<?= $b['id'] ?>" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Status">
              <i class="fas fa-power-off"></i>
            </a>
            <a href="edit-mobile-banner.php?id=<?= $b['id'] ?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
              <i class="fas fa-edit"></i> Edit
            </a>
            <a href="?delete=<?= $b['id'] ?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;"
               onclick="return confirm('Delete this banner?')">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
  <?php if(mysqli_num_rows(mysqli_query($conn,"SELECT id FROM mobile_banners")) == 0): ?>
    <div style="text-align:center; padding:40px; color:var(--text-muted);">
      <i class="fas fa-image" style="font-size:40px; margin-bottom:15px; display:block; opacity:0.3;"></i>
      No banners yet. <a href="add-mobile-banner.php" style="color:var(--primary);">Add your first banner</a>
    </div>
  <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>
