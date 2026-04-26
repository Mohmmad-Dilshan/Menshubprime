<?php
session_start();
$page_title = "Onboard New Strategic Partner";
include 'admin_header.php';

if(isset($_POST['submit'])){
  $title = mysqli_real_escape_string($conn,$_POST['title']);
  $link = mysqli_real_escape_string($conn,$_POST['link']);
  $position = mysqli_real_escape_string($conn, $_POST['position']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  /* IMAGE UPLOAD */
  $image = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  $newname = time()."_".$image;
  move_uploaded_file($tmp,"../assets/images/".$newname);

  /* INSERT */
  mysqli_query($conn,"INSERT INTO sponsors (title,link,image,position,status) VALUES ('$title','$link','$newname','$position','$status')");

  echo "<script>window.location='sponsors.php';</script>";
  exit();
}
?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
  <div style="margin-bottom:25px; text-align:center;">
    <h2 style="font-size:24px; color:var(--primary); margin-bottom:10px;">🤝 Partner Onboarding</h2>
    <p style="color:var(--text-muted); font-size:14px;">Establish a new strategic brand presence across the platform.</p>
  </div>

  <form method="post" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
      <div style="grid-column: span 2;">
        <label><i class="fas fa-building"></i> Brand / Partner Name</label>
        <input type="text" name="title" placeholder="e.g. Premium Tech Solutions" required>
      </div>

      <div style="grid-column: span 2;">
        <label><i class="fas fa-link"></i> Destination URL</label>
        <input type="url" name="link" placeholder="https://partner-website.com" required>
      </div>

      <div>
        <label><i class="fas fa-map-marker-alt"></i> Placement Position</label>
        <select name="position" required>
          <option value="home">Home Page Feed</option>
          <option value="blog">Main Blog Sidebar</option>
          <option value="blog-single">Individual Post Footer</option>
        </select>
      </div>

      <div>
        <label><i class="fas fa-toggle-on"></i> Initial Visibility</label>
        <select name="status" required>
          <option value="active">Live & Visible</option>
          <option value="off">Hidden / Draft</option>
        </select>
      </div>

      <div style="grid-column: span 2;">
        <label><i class="fas fa-image"></i> Official Brand Logo</label>
        <div style="border:2px dashed var(--glass-border); padding:20px; border-radius:12px; text-align:center; transition:0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--glass-border)'">
          <input type="file" name="image" id="partnerLogo" required style="display:none;" onchange="document.getElementById('fileName').textContent = this.files[0].name">
          <label for="partnerLogo" style="cursor:pointer; margin-bottom:0;">
            <i class="fas fa-cloud-upload-alt" style="font-size:30px; color:var(--primary); margin-bottom:10px; display:block;"></i>
            <span id="fileName" style="font-size:13px; color:var(--text-muted);">Choose a high-resolution logo (PNG/SVG)</span>
          </label>
        </div>
      </div>
    </div>

    <div style="margin-top:30px; display:flex; gap:15px;">
      <button type="submit" name="submit" class="admin-btn btn-primary" style="flex:2; justify-content:center; padding:12px;">
        <i class="fas fa-check-circle"></i> Initialize Partnership
      </button>
      <a href="sponsors.php" class="admin-btn btn-danger" style="flex:1; justify-content:center; padding:12px; text-decoration:none;">
        Discard
      </a>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>