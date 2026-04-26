<?php
session_start();
$page_title = "Edit Video Review";
include 'admin_header.php';

$id = intval($_GET['id']);
$q = mysqli_query($conn,"SELECT * FROM videos WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if(isset($_POST['submit'])){
  $title       = mysqli_real_escape_string($conn,$_POST['title']);
  $description = mysqli_real_escape_string($conn,$_POST['description']);
  $pros        = mysqli_real_escape_string($conn,$_POST['pros']);
  $cons        = mysqli_real_escape_string($conn,$_POST['cons']);
  $buy_link    = mysqli_real_escape_string($conn,$_POST['link']);
  $status      = (($_POST['status'] == 'active' || $_POST['status'] == '1') ? 1 : 0);
  $star_rating = floatval($_POST['star_rating']);
  $verdict     = mysqli_real_escape_string($conn,$_POST['verdict']);
  $best_for    = mysqli_real_escape_string($conn,$_POST['best_for']);
  $specs       = mysqli_real_escape_string($conn,$_POST['specs']);

  $video_link  = $data['video_link']; // default old
  $thumb       = $data['thumb'];

  // 1️⃣ URL update
  if(!empty($_POST['video_url'])){
    $video_link = mysqli_real_escape_string($conn,$_POST['video_url']);
  }
  // 2️⃣ MP4 upload
  elseif(!empty($_FILES['video']['name'])){
    $video_folder = "../uploads/videos/";
    if(!is_dir($video_folder)) mkdir($video_folder,0777,true);
    $new_video = time()."_".$_FILES['video']['name'];
    move_uploaded_file($_FILES['video']['tmp_name'],$video_folder.$new_video);
    $video_link = $new_video;
  }

  // 3️⃣ Thumb update
  if(!empty($_FILES['thumb']['name'])){
    $thumb_folder = "../uploads/thumbs/";
    if(!is_dir($thumb_folder)) mkdir($thumb_folder,0777,true);
    $new_thumb = time()."_".$_FILES['thumb']['name'];
    move_uploaded_file($_FILES['thumb']['tmp_name'],$thumb_folder.$new_thumb);
    $thumb = $new_thumb;
  }

  mysqli_query($conn,"UPDATE videos SET 
    title='$title', 
    description='$description',
    pros='$pros',
    cons='$cons',
    video_link='$video_link',
    thumb='$thumb',
    buy_link='$buy_link',
    status='$status',
    star_rating='$star_rating',
    verdict='$verdict',
    best_for='$best_for',
    specs='$specs'
    WHERE id='$id'");

  header("Location: manage-videos.php?updated=1&t=".time());
  exit();
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left side: Basic Info -->
      <div>
        <label>Video Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>

        <label>Star Rating (0 to 5)</label>
        <input type="number" step="0.1" name="star_rating" value="<?= $data['star_rating']; ?>">

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($data['description']); ?></textarea>

        <label>Final Verdict</label>
        <textarea name="verdict"><?= htmlspecialchars($data['verdict']); ?></textarea>
      </div>

      <!-- Right side: Links & Files -->
      <div>
        <label>Video URL (YouTube/Shorts/Insta)</label>
        <input type="text" name="video_url" value="<?= (strpos($data['video_link'],'http') === 0) ? htmlspecialchars($data['video_link']) : ''; ?>" placeholder="Paste link here">
        
        <p style="text-align:center; color:var(--text-muted); margin:15px 0; font-size:12px; font-weight:700;">— OR —</p>
        
        <label>Replace MP4 Video File</label>
        <input type="file" name="video">

        <label>Replace Thumbnail</label>
        <input type="file" name="thumb">

        <label>Affiliate Buy Link</label>
        <input type="text" name="link" value="<?= htmlspecialchars($data['buy_link']); ?>" placeholder="https://...">
        
        <label>Best For</label>
        <input type="text" name="best_for" value="<?= htmlspecialchars($data['best_for']); ?>">
      </div>

    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px; margin-top:30px;">
      <div>
        <label>Pros (Each line new)</label>
        <textarea name="pros"><?= htmlspecialchars($data['pros']); ?></textarea>
      </div>
      <div>
        <label>Cons (Each line new)</label>
        <textarea name="cons"><?= htmlspecialchars($data['cons']); ?></textarea>
      </div>
    </div>

    <label>Technical Specifications (Label: Value per line)</label>
    <textarea name="specs" style="min-height:80px;"><?= htmlspecialchars($data['specs']); ?></textarea>

    <div style="margin-top:30px; display:flex; justify-content:space-between; align-items:center;">
      <div style="display:flex; align-items:center; gap:20px;">
        <label style="margin:0;">Status:</label>
        <select name="status" style="width:150px;">
          <option value="1" <?= ($data['status']=='1' || $data['status']=='active')?'selected':''; ?>>Active</option>
          <option value="0" <?= ($data['status']=='0' || $data['status']=='inactive')?'selected':''; ?>>Inactive</option>
        </select>
      </div>
      <button type="submit" name="submit" class="admin-btn btn-primary" style="padding:12px 40px;">
        <i class="fas fa-save"></i> Save Changes
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>