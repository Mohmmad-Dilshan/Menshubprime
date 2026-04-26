<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);

// fetch product for initial load and logic
$q = mysqli_query($conn,"SELECT * FROM products WHERE id=$id");
$data = mysqli_fetch_assoc($q);

if(!$data){
  header("Location: products.php?err=notfound");
  exit();
}

if(isset($_POST['update'])){
  $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
  $price = mysqli_real_escape_string($conn, $_POST['price'] ?? '0');
  $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
  $link = mysqli_real_escape_string($conn, $_POST['link'] ?? '');
  $video_url = mysqli_real_escape_string($conn, $_POST['video_url'] ?? '');
  $video_url_mockup = mysqli_real_escape_string($conn, $_POST['video_url_mockup'] ?? '');
  $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
  $status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'active');
  $in_bag = isset($_POST['in_deals_bag']) ? 1 : 0;

  // Price Comparison Fields
  $flipkart_price = mysqli_real_escape_string($conn, $_POST['flipkart_price'] ?? '');
  $flipkart_link = mysqli_real_escape_string($conn, $_POST['flipkart_link'] ?? '');
  $myntra_price = mysqli_real_escape_string($conn, $_POST['myntra_price'] ?? '');
  $myntra_link = mysqli_real_escape_string($conn, $_POST['myntra_link'] ?? '');
  $other_platform_name = mysqli_real_escape_string($conn, $_POST['other_platform_name'] ?? '');
  $other_platform_price = mysqli_real_escape_string($conn, $_POST['other_platform_price'] ?? '');
  $other_platform_link = mysqli_real_escape_string($conn, $_POST['other_platform_link'] ?? '');

  // Media upload handling
  $img = !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : $data['image'];
  if(!empty($_FILES['image']['name'])) move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/".$img);

  $img2 = !empty($_FILES['image2']['name']) ? $_FILES['image2']['name'] : $data['image2'];
  if(!empty($_FILES['image2']['name'])) move_uploaded_file($_FILES['image2']['tmp_name'], "../assets/images/".$img2);

  $img3 = !empty($_FILES['image3']['name']) ? $_FILES['image3']['name'] : $data['image3'];
  if(!empty($_FILES['image3']['name'])) move_uploaded_file($_FILES['image3']['tmp_name'], "../assets/images/".$img3);

  $img4 = !empty($_FILES['image4']['name']) ? $_FILES['image4']['name'] : $data['image4'];
  if(!empty($_FILES['image4']['name'])) move_uploaded_file($_FILES['image4']['tmp_name'], "../assets/images/".$img4);

  $img5 = !empty($_FILES['image5']['name']) ? $_FILES['image5']['name'] : $data['image5'];
  if(!empty($_FILES['image5']['name'])) move_uploaded_file($_FILES['image5']['tmp_name'], "../assets/images/".$img5);

  $vid = !empty($_FILES['video_file']['name']) ? $_FILES['video_file']['name'] : $data['video_file'];
  if(!empty($_FILES['video_file']['name'])) move_uploaded_file($_FILES['video_file']['tmp_name'], "../assets/images/".$vid);

  $in_bag = isset($_POST['in_deals_bag']) ? 1 : 0;
  $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : 'NULL';

  // Generate Slug
  $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));

  // update query
  $sql = "UPDATE products SET
    title='$title',
    slug='$slug',
    price='$price',
    category='$category',
    affiliate_link='$link',
    video_url='$video_url',
    video_url_mockup='$video_url_mockup',
    video_file='$vid',
    image='$img',
    image2='$img2',
    image3='$img3',
    image4='$img4',
    image5='$img5',
    description='$description',
    status='$status',
    in_deals_bag='$in_bag',
    flipkart_price='$flipkart_price',
    flipkart_link='$flipkart_link',
    myntra_price='$myntra_price',
    myntra_link='$myntra_link',
    other_platform_name='$other_platform_name',
    other_platform_price='$other_platform_price',
    other_platform_link='$other_platform_link',
    store_id=$store_id
    WHERE id=$id";

  if(mysqli_query($conn,$sql)){
      header("Location: products.php?msg=updated&t=" . time());
      exit();
  }
}

$page_title = "Edit Standard Product";
include 'admin_header.php';
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">

      <!-- Left Column -->
      <div>
        <label><i class="fas fa-tag"></i> Product Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>

        <label><i class="fas fa-rupee-sign"></i> Listing Price (INR)</label>
        <input type="text" name="price" value="<?= htmlspecialchars($data['price']); ?>" required>

        <label><i class="fas fa-list"></i> Select Category</label>
        <select name="category" required>
          <?php
          $cat = mysqli_query($conn,"SELECT * FROM categories");
          while($crow=mysqli_fetch_assoc($cat)){
          ?>
          <option value="<?= $crow['slug']?>" <?= ($data['category'] == $crow['slug']) ? 'selected' : ''; ?>><?= $crow['name']?></option>
          <?php } ?>
        </select>

        <label><i class="fas fa-store"></i> Associate with Store/Sale</label>
        <select name="store_id">
          <option value="">-- Select Store (Optional) --</option>
          <?php
          $sts = mysqli_query($conn,"SELECT * FROM stores WHERE status=1");
          while($s=mysqli_fetch_assoc($sts)){
          ?>
          <option value="<?= $s['id']?>" <?= ($data['store_id'] == $s['id']) ? 'selected' : ''; ?>><?= $s['name']?></option>
          <?php } ?>
        </select>
      </div>

      <!-- Right Column -->
      <div>
        <label><i class="fas fa-external-link-alt"></i> Affiliate/Purchase Link</label>
        <input type="url" name="link" value="<?= htmlspecialchars($data['affiliate_link']); ?>" required>

        <label><i class="fas fa-video"></i> Video File (MP4 - Optional)</label>
        <?php if($data['video_file']): ?>
          <div style="margin-bottom:10px;"><small>Current: <?= $data['video_file'] ?></small></div>
        <?php endif; ?>
        <input type="file" name="video_file" accept="video/mp4">

        <label><i class="fas fa-video"></i> Select Internal Video Review (Watch Review)</label>
        <select name="video_url">
          <option value="">-- No Internal Review --</option>
          <?php
          $vids = mysqli_query($conn,"SELECT title, slug FROM videos WHERE status='active' OR status='1'");
          while($v=mysqli_fetch_assoc($vids)){
          ?>
            <option value="<?= $v['slug']?>" <?= ($data['video_url'] == $v['slug']) ? 'selected' : ''; ?>><?= $v['title']?></option>
          <?php } ?>
        </select>

        <label><i class="fab fa-instagram"></i> Mockup/Gallery Video URL (Embed)</label>
        <input type="text" name="video_url_mockup" value="<?= htmlspecialchars($data['video_url_mockup'] ?? '') ?>" placeholder="Instagram Reel, TikTok or direct Link">

        <label><i class="fas fa-toggle-on"></i> Product Status</label>
        <select name="status" required>
          <option value="active" <?= ($data['status']=='active')?'selected':'' ?>>Active / Visible</option>
          <option value="inactive" <?= ($data['status']=='inactive')?'selected':'' ?>>Inactive / Hidden</option>
        </select>

        <div style="margin-top:20px; padding:15px; background:rgba(251, 146, 60, 0.05); border-radius:10px; border:1px solid rgba(251, 146, 60, 0.1);">
          <label class="switch-wrap" style="display:flex; align-items:center; justify-content:space-between; cursor:pointer;">
            <span><i class="fas fa-shopping-bag" style="color:#fb923c;"></i> Show in Mobile Deals Bag</span>
            <input type="checkbox" name="in_deals_bag" value="1" <?= ($data['in_deals_bag'] == 1) ? 'checked' : '' ?> style="width:20px; height:20px;">
          </label>
        </div>
      </div>

    </div>

    <div style="margin-top:30px;">
      <label><i class="fas fa-align-left"></i> Product Short Description (40-50 words)</label>
      <textarea name="description" rows="3" placeholder="Enter short description..."><?= htmlspecialchars($data['description'] ?? ''); ?></textarea>
    </div>

    <!-- Pricing Comparison Section -->
    <div style="margin-top:30px; padding:20px; background:rgba(255,255,255,0.05); border:1px solid var(--glass-border); border-radius:15px;">
      <h3 style="margin-bottom:20px; font-size:18px; color:var(--primary);"><i class="fas fa-chart-line"></i> Price Comparison (Optional)</h3>

      <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:20px;">
        <!-- Flipkart -->
        <div>
          <label><i class="fab fa-product-hunt"></i> Flipkart Price</label>
          <input type="text" name="flipkart_price" value="<?= htmlspecialchars($data['flipkart_price'] ?? ''); ?>" placeholder="e.g. 1599">
          <label>Flipkart Link</label>
          <input type="url" name="flipkart_link" value="<?= htmlspecialchars($data['flipkart_link'] ?? ''); ?>" placeholder="https://flipkart.com/...">
        </div>

        <!-- Myntra -->
        <div>
          <label><i class="fas fa-shopping-bag"></i> Myntra Price</label>
          <input type="text" name="myntra_price" value="<?= htmlspecialchars($data['myntra_price'] ?? ''); ?>" placeholder="e.g. 1650">
          <label>Myntra Link</label>
          <input type="url" name="myntra_link" value="<?= htmlspecialchars($data['myntra_link'] ?? ''); ?>" placeholder="https://myntra.com/...">
        </div>

        <!-- Other -->
        <div>
          <label><i class="fas fa-store"></i> Other Platform Name</label>
          <input type="text" name="other_platform_name" value="<?= htmlspecialchars($data['other_platform_name'] ?? ''); ?>" placeholder="e.g. Ajio">
          <label>Other Price</label>
          <input type="text" name="other_platform_price" value="<?= htmlspecialchars($data['other_platform_price'] ?? ''); ?>" placeholder="e.g. 1400">
          <label>Other Link</label>
          <input type="url" name="other_platform_link" value="<?= htmlspecialchars($data['other_platform_link'] ?? ''); ?>" placeholder="https://ajio.com/...">
        </div>
      </div>
    </div>

    <div style="margin-top:20px;">
      <label><i class="fas fa-images"></i> Product Media & Mockups</label>
      <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap:20px; margin-top:10px;">
        
        <!-- Main Image -->
        <div style="background:rgba(255,255,255,0.02); padding:10px; border-radius:10px; border:1px solid var(--glass-border);">
          <small>Main Image</small>
          <img src="../assets/images/<?= $data['image']?>" style="width:100%; height:100px; object-fit:cover; border-radius:5px; margin:5px 0;">
          <input type="file" name="image" style="font-size:10px;">
        </div>

        <!-- Image 2 -->
        <div style="background:rgba(255,255,255,0.02); padding:10px; border-radius:10px; border:1px solid var(--glass-border);">
          <small>Mockup 2</small>
          <?php if($data['image2']): ?>
            <img src="../assets/images/<?= $data['image2']?>" style="width:100%; height:100px; object-fit:cover; border-radius:5px; margin:5px 0;">
          <?php else: ?><div style="height:100px; display:flex; align-items:center; justify-content:center; opacity:0.3;"><i class="fas fa-image"></i></div><?php endif; ?>
          <input type="file" name="image2" style="font-size:10px;">
        </div>

        <!-- Image 3 -->
        <div style="background:rgba(255,255,255,0.02); padding:10px; border-radius:10px; border:1px solid var(--glass-border);">
          <small>Mockup 3</small>
          <?php if($data['image3']): ?>
            <img src="../assets/images/<?= $data['image3']?>" style="width:100%; height:100px; object-fit:cover; border-radius:5px; margin:5px 0;">
          <?php else: ?><div style="height:100px; display:flex; align-items:center; justify-content:center; opacity:0.3;"><i class="fas fa-image"></i></div><?php endif; ?>
          <input type="file" name="image3" style="font-size:10px;">
        </div>

        <!-- Image 4 -->
        <div style="background:rgba(255,255,255,0.02); padding:10px; border-radius:10px; border:1px solid var(--glass-border);">
          <small>Mockup 4</small>
          <?php if($data['image4']): ?>
            <img src="../assets/images/<?= $data['image4']?>" style="width:100%; height:100px; object-fit:cover; border-radius:5px; margin:5px 0;">
          <?php else: ?><div style="height:100px; display:flex; align-items:center; justify-content:center; opacity:0.3;"><i class="fas fa-image"></i></div><?php endif; ?>
          <input type="file" name="image4" style="font-size:10px;">
        </div>

        <!-- Image 5 -->
        <div style="background:rgba(255,255,255,0.02); padding:10px; border-radius:10px; border:1px solid var(--glass-border);">
          <small>Mockup 5</small>
          <?php if($data['image5']): ?>
            <img src="../assets/images/<?= $data['image5']?>" style="width:100%; height:100px; object-fit:cover; border-radius:5px; margin:5px 0;">
          <?php else: ?><div style="height:100px; display:flex; align-items:center; justify-content:center; opacity:0.3;"><i class="fas fa-image"></i></div><?php endif; ?>
          <input type="file" name="image5" style="font-size:10px;">
        </div>

      </div>
    </div>

    <div style="margin-top:30px; border-top:1px solid var(--glass-border); padding-top:20px; display:flex; justify-content:flex-end; gap:15px;">
      <a href="products.php" class="admin-btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
      <button type="submit" name="update" class="admin-btn btn-primary">
        <i class="fas fa-save"></i> Save Changes
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>