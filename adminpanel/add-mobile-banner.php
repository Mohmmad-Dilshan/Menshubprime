<?php
session_start();
$page_title = "Add Mobile Banner";
include 'admin_header.php';

if(isset($_POST['submit'])){
  $title  = mysqli_real_escape_string($conn, $_POST['title']);
  $link   = mysqli_real_escape_string($conn, $_POST['link']);
  $order  = (int)$_POST['sort_order'];
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  $image = $_FILES['image']['name'];
  $tmp   = $_FILES['image']['tmp_name'];
  $newname = time()."_".$image;
  move_uploaded_file($tmp, "../assets/images/".$newname);

  mysqli_query($conn,"INSERT INTO mobile_banners (title,image,link,sort_order,status) 
                      VALUES ('$title','$newname','$link',$order,'$status')");
  echo "<script>window.location='mobile-banners.php';</script>";
  exit();
}
?>

<div class="admin-card" style="max-width:620px; margin:0 auto;">
  <div style="text-align:center; margin-bottom:25px;">
    <h2 style="color:var(--primary); font-size:22px; margin:0;">📱 Add Mobile Banner</h2>
    <p style="color:var(--text-muted); font-size:13px; margin:8px 0 0;">Add a new banner to the home page mobile slider</p>
  </div>

  <form method="post" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; gap:18px;">

      <div>
        <label><i class="fas fa-heading"></i> Badge Title <span style="color:var(--text-muted); font-size:11px; font-weight:400;">(optional — leave empty to hide badge)</span></label>
        <input type="text" name="title" placeholder="e.g. 🔥 Summer Sale - 50% OFF (optional)">
      </div>

      <div>
        <label><i class="fas fa-link"></i> Link URL (page ya external link)</label>
        <input type="text" name="link" placeholder="e.g. /Menshubprime/deals or https://amazon.in/..." value="/Menshubprime/deals" required>
        <small style="color:var(--text-muted); font-size:11px; margin-top:4px; display:block;">
          💡 Internal link example: <code>/Menshubprime/deals</code> &nbsp;|&nbsp; External: <code>https://amazon.in</code>
        </small>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        <div>
          <label><i class="fas fa-sort-numeric-up"></i> Sort Order</label>
          <input type="number" name="sort_order" value="0" min="0" placeholder="0">
          <small style="color:var(--text-muted); font-size:11px;">Lower = first</small>
        </div>
        <div>
          <label><i class="fas fa-toggle-on"></i> Status</label>
          <select name="status">
            <option value="active">Active (Visible)</option>
            <option value="inactive">Inactive (Hidden)</option>
          </select>
        </div>
      </div>

      <div>
        <label><i class="fas fa-image"></i> Banner Image</label>
        <div style="border:2px dashed var(--glass-border); padding:30px; border-radius:14px; text-align:center; cursor:pointer; transition:0.3s;"
             id="dropzone"
             onmouseover="this.style.borderColor='var(--primary)'"
             onmouseout="this.style.borderColor='var(--glass-border)'">
          <input type="file" name="image" id="bannerImg" required accept="image/*" 
                 style="display:none;" onchange="previewImg(this)">
          <label for="bannerImg" style="cursor:pointer; margin:0; display:block;">
            <i class="fas fa-cloud-upload-alt" style="font-size:35px; color:var(--primary); display:block; margin-bottom:10px;"></i>
            <span id="fileLabel" style="color:var(--text-muted); font-size:13px;">Click to upload banner image<br><small>Recommended: 800×300px or 1200×400px</small></span>
          </label>
          <img id="preview" src="" style="display:none; max-width:100%; margin-top:15px; border-radius:10px; max-height:150px; object-fit:cover;">
        </div>
      </div>

    </div>

    <div style="margin-top:25px; display:flex; gap:12px;">
      <button type="submit" name="submit" class="admin-btn btn-primary" style="flex:2; justify-content:center; padding:13px;">
        <i class="fas fa-plus-circle"></i> Add Banner
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
      document.getElementById('fileLabel').textContent = input.files[0].name;
    };
    r.readAsDataURL(input.files[0]);
  }
}
</script>

<?php include 'admin_footer.php'; ?>
