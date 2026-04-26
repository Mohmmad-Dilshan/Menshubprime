<?php
session_start();
$page_title = "Add New Video Review";
include 'admin_header.php';

if(isset($_POST['submit'])){
/* ... (logic remains same) ... */
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $pros = mysqli_real_escape_string($conn, $_POST['pros']);
  $cons = mysqli_real_escape_string($conn, $_POST['cons']);
  $buy_link = $_POST['buy_link'];
  $status = $_POST['status'];
  $star_rating = floatval($_POST['star_rating']);
  $verdict = mysqli_real_escape_string($conn,$_POST['verdict']);
  $best_for = mysqli_real_escape_string($conn,$_POST['best_for']);
  $specs = mysqli_real_escape_string($conn,$_POST['specs']);

  /* VIDEO */
  $video = $_FILES['video']['name'];
  $tmp_video = $_FILES['video']['tmp_name'];
  $video_url = $_POST['video_url'];

  /* THUMBNAIL */
  $thumb = $_FILES['thumb']['name'];
  $tmp_thumb = $_FILES['thumb']['tmp_name'];

  $video_folder = "../uploads/videos/";
  $thumb_folder = "../uploads/thumbs/";

  if(!is_dir($video_folder)) mkdir($video_folder,0777,true);
  if(!is_dir($thumb_folder)) mkdir($thumb_folder,0777,true);

  if(!empty($video)){
    $video_new = time()."_".$video;
    move_uploaded_file($tmp_video, $video_folder.$video_new);
    $video_link = $video_new;
  } else {
    $video_link = $video_url;
  }

  $thumb_new = time()."_".$thumb;
  move_uploaded_file($tmp_thumb, $thumb_folder.$thumb_new);

  mysqli_query($conn,"INSERT INTO videos(title,description,pros,cons,video_link,thumb,buy_link,status,star_rating,verdict,best_for,specs)
  VALUES('$title','$description','$pros','$cons','$video_link','$thumb_new','$buy_link','$status','$star_rating','$verdict','$best_for','$specs')");

  echo "<script>alert('Video Added Successfully'); window.location='manage-videos.php';</script>";
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left side: Basic Info -->
      <div>
        <label>Video Title</label>
        <input type="text" name="title" placeholder="Enter video title" required>

        <label>Star Rating (0 to 5)</label>
        <input type="number" step="0.1" name="star_rating" value="4.5">

        <label>Description</label>
        <textarea name="description" placeholder="Short introduction..."></textarea>

        <label>Final Verdict (Summary)</label>
        <textarea name="verdict" placeholder="TheZayanWay conclusion..."></textarea>
      </div>

      <!-- Right side: Links & Files -->
      <div>
        <label>Video URL (YouTube/Shorts/Insta)</label>
        <input type="text" name="video_url" placeholder="Paste link here">
        
        <p style="text-align:center; color:var(--text-muted); margin:15px 0; font-size:12px; font-weight:700;">— OR —</p>
        
        <label>Upload MP4 File</label>
        <input type="file" name="video">

        <label>Thumbnail Image</label>
        <input type="file" name="thumb" required>

        <label>Affiliate Buy Link</label>
        <input type="text" name="buy_link" placeholder="https://..." required>
        
        <label>Best For</label>
        <input type="text" name="best_for" placeholder="e.g. Students, Gamers">
      </div>

    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px; margin-top:30px;">
      <div>
        <label>Pros (Each line new)</label>
        <textarea name="pros" placeholder="List the pros..."></textarea>
      </div>
      <div>
        <label>Cons (Each line new)</label>
        <textarea name="cons" placeholder="List the cons..."></textarea>
      </div>
    </div>

    <label>Technical Specifications (Label: Value per line)</label>
    <textarea name="specs" placeholder="Battery: 5000mAh
Ram: 8GB" style="min-height:80px;"></textarea>

    <div style="margin-top:30px; display:flex; justify-content:space-between; align-items:center;">
      <div style="display:flex; align-items:center; gap:20px;">
        <label style="margin:0;">Status:</label>
        <select name="status" style="width:150px;">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>
      <button type="submit" name="submit" class="admin-btn btn-primary" style="padding:12px 40px;">
        <i class="fas fa-check-circle"></i> Save Video Review
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>