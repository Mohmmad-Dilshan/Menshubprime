<?php
session_start();
$page_title = "Edit Mobile Banner";
include 'admin_header.php';

$id = (int)$_GET['id'];
$banner = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM mobile_banners WHERE id=$id"));
if(!$banner){ header("Location: mobile-banners.php"); exit(); }

if(isset($_POST['submit'])){
  $title  = mysqli_real_escape_string($conn, $_POST['title']);
  $link   = mysqli_real_escape_string($conn, $_POST['link']);
  $order  = (int)$_POST['sort_order'];
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  if($_FILES['image']['name']){
    $newname = time()."_".$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/".$newname);
    if(file_exists("../assets/images/".$banner['image'])) unlink("../assets/images/".$banner['image']);
    mysqli_query($conn,"UPDATE mobile_banners SET title='$title',image='$newname',link='$link',sort_order=$order,status='$status' WHERE id=$id");
  } else {
    mysqli_query($conn,"UPDATE mobile_banners SET title='$title',link='$link',sort_order=$order,status='$status' WHERE id=$id");
  }
  echo "<script>window.location='mobile-banners.php';</script>";
  exit();
}
?>

<div class="admin-card" style="max-width:620px; margin:0 auto;">
  <div style="text-align:center; margin-bottom:25px;">
    <h2 style="color:var(--primary); font-size:22px; margin:0;">✏️ Edit Mobile Banner</h2>
  </div>

  <form method="post" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; gap:18px;">

      <div>
        <label><i class="fas fa-heading"></i> Badge Title <span style="color:var(--text-muted); font-size:11px; font-weight:400;">(optional — leave empty to hide badge)</span></label>
        <input type="text" name="title" value="<?= htmlspecialchars($banner['title']) ?>" placeholder="Leave empty to hide badge">
      </div>

      <div>
        <label><i class="fas fa-link"></i> Link URL</label>
        <input type="text" name="link" value="<?= htmlspecialchars($banner['link']) ?>" required>
        <small style="color:var(--text-muted); font-size:11px;">Example: <code>/Menshubprime/deals</code> or <code>https://amazon.in</code></small>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        <div>
          <label><i class="fas fa-sort-numeric-up"></i> Sort Order</label>
          <input type="number" name="sort_order" value="<?= $banner['sort_order'] ?>">
        </div>
        <div>
          <label><i class="fas fa-toggle-on"></i> Status</label>
          <select name="status">
            <option value="active" <?= $banner['status']=='active'?'selected':'' ?>>Active</option>
            <option value="inactive" <?= $banner['status']=='inactive'?'selected':'' ?>>Inactive</option>
          </select>
        </div>
      </div>

      <div>
        <label><i class="fas fa-image"></i> Current Banner</label>
        <img src="../assets/images/<?= htmlspecialchars($banner['image']) ?>" 
             style="width:100%; max-height:150px; object-fit:cover; border-radius:12px; margin-bottom:10px;">
        <label><i class="fas fa-upload"></i> Replace Image (leave empty to keep current)</label>
        <input type="file" name="image" accept="image/*" onchange="previewImg(this)">
        <img id="preview" src="" style="display:none; width:100%; margin-top:10px; border-radius:10px; max-height:120px; object-fit:cover;">
      </div>

    </div>

    <div style="margin-top:25px; display:flex; gap:12px;">
      <button type="submit" name="submit" class="admin-btn btn-primary" style="flex:2; justify-content:center; padding:13px;">
        <i class="fas fa-save"></i> Save Changes
      </button>
      <a href="mobile-banners.php" class="admin-btn btn-danger" style="flex:1; justify-content:center; padding:13px; text-decoration:none;">
        Cancel
      </a>
    </div>
  </form>
</div>

<script>
function previewImg(input){
  if(input.files && input.files[0]){
    var r = new FileReader();
    r.onload = function(e){
      document.getElementById('preview').src = e.target.result;
      document.getElementById('preview').style.display = 'block';
    };
    r.readAsDataURL(input.files[0]);
  }
}
</script>

<?php include 'admin_footer.php'; ?>
