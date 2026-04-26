<?php
session_start();
$page_title = "Refine Strategic Partnership";
include 'admin_header.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch sponsor data
$q = mysqli_query($conn,"SELECT * FROM sponsors WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if(!$data) {
  echo "<script>window.location='sponsors.php';</script>";
  exit();
}

// Update sponsor
if(isset($_POST['update'])){
  $title = mysqli_real_escape_string($conn,$_POST['title']);
  $link = mysqli_real_escape_string($conn,$_POST['link']);
  $position = mysqli_real_escape_string($conn, $_POST['position']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  // If new image uploaded
  if($_FILES['image']['name'] != ""){
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $newname = time()."_".$img;
    move_uploaded_file($tmp,"../assets/images/".$newname);
    
    mysqli_query($conn,"UPDATE sponsors SET title='$title', link='$link', position='$position', status='$status', image='$newname' WHERE id='$id'");
  } else {
    mysqli_query($conn,"UPDATE sponsors SET title='$title', link='$link', position='$position', status='$status' WHERE id='$id'");
  }

  echo "<script>window.location='sponsors.php';</script>";
  exit();
}
?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
  <div style="margin-bottom:25px; text-align:center;">
    <h2 style="font-size:24px; color:var(--primary); margin-bottom:10px;">✏ Update Partnership</h2>
    <p style="color:var(--text-muted); font-size:14px;">Modify brand visibility and placement details for <strong><?= htmlspecialchars($data['title']); ?></strong>.</p>
  </div>

  <form method="post" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
      <div style="grid-column: span 2;">
        <label><i class="fas fa-building"></i> Brand / Partner Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>
      </div>

      <div style="grid-column: span 2;">
        <label><i class="fas fa-link"></i> Active Destination Link</label>
        <input type="url" name="link" value="<?= htmlspecialchars($data['link']); ?>" required>
      </div>

      <div>
        <label><i class="fas fa-map-marker-alt"></i> Placement Strategy</label>
        <select name="position" required>
          <option value="home" <?=($data['position']=="home")?"selected":"";?> >Home Page Display</option>
          <option value="blog" <?=($data['position']=="blog")?"selected":"";?> >Blog Feed Sidebar</option>
          <option value="blog-single" <?=($data['position']=="blog-single")?"selected":"";?> >Single Post Footer</option>
        </select>
      </div>

      <div>
        <label><i class="fas fa-toggle-on"></i> Partnership Status</label>
        <select name="status" required>
          <option value="active" <?=($data['status']=="active")?"selected":"";?> >Live & Active</option>
          <option value="off" <?=($data['status']=="off")?"selected":"";?> >Paused / Hidden</option>
        </select>
      </div>

      <div style="grid-column: span 2;">
        <label><i class="fas fa-image"></i> Current Visual Identity</label>
        <div style="display:flex; gap:15px; align-items:center; background:rgba(255,255,255,0.03); padding:15px; border-radius:12px; border:1px solid var(--glass-border);">
          <img src="../assets/images/<?= $data['image']; ?>" style="height:60px; width:120px; object-fit:contain; background:rgba(255,255,255,0.05); padding:10px; border-radius:88px;">
          <div style="flex:1;">
            <input type="file" name="image" id="updateLogo" style="display:none;" onchange="document.getElementById('fileStatus').textContent = 'New file selected: ' + this.files[0].name">
            <label for="updateLogo" class="admin-btn" style="background:var(--primary); color:white; padding:8px 15px; margin-bottom:5px; font-size:12px; cursor:pointer; width:auto;">
              <i class="fas fa-sync-alt"></i> Change Logo
            </label>
            <p id="fileStatus" style="font-size:11px; color:var(--text-muted); margin:0;">Leave empty to retain current logo</p>
          </div>
        </div>
      </div>
    </div>

    <div style="margin-top:30px; display:flex; gap:15px;">
      <button type="submit" name="update" class="admin-btn btn-primary" style="flex:2; justify-content:center; padding:12px;">
        <i class="fas fa-save"></i> Synchronize Updates
      </button>
      <a href="sponsors.php" class="admin-btn btn-danger" style="flex:1; justify-content:center; padding:12px; text-decoration:none;">
        Exit Form
      </a>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>