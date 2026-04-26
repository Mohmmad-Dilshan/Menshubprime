<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit'])){
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $link = mysqli_real_escape_string($conn, $_POST['link']);
  $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);
  $video_url_mockup = mysqli_real_escape_string($conn, $_POST['video_url_mockup']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $in_bag = isset($_POST['in_deals_bag']) ? 1 : 0;

  // Price Comparison Fields
  $flipkart_price = mysqli_real_escape_string($conn, $_POST['flipkart_price']);
  $flipkart_link = mysqli_real_escape_string($conn, $_POST['flipkart_link']);
  $myntra_price = mysqli_real_escape_string($conn, $_POST['myntra_price']);
  $myntra_link = mysqli_real_escape_string($conn, $_POST['myntra_link']);
  $other_platform_name = mysqli_real_escape_string($conn, $_POST['other_platform_name']);
  $other_platform_price = mysqli_real_escape_string($conn, $_POST['other_platform_price']);
  $other_platform_link = mysqli_real_escape_string($conn, $_POST['other_platform_link']);

  $image = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  if($image) move_uploaded_file($tmp,"../assets/images/".$image);

  $image2 = $_FILES['image2']['name'];
  $tmp2 = $_FILES['image2']['tmp_name'];
  if($image2) move_uploaded_file($tmp2,"../assets/images/".$image2);

  $image3 = $_FILES['image3']['name'];
  $tmp3 = $_FILES['image3']['tmp_name'];
  if($image3) move_uploaded_file($tmp3,"../assets/images/".$image3);

  $image4 = $_FILES['image4']['name'];
  $tmp4 = $_FILES['image4']['tmp_name'];
  if($image4) move_uploaded_file($tmp4,"../assets/images/".$image4);

  $image5 = $_FILES['image5']['name'];
  $tmp5 = $_FILES['image5']['tmp_name'];
  if($image5) move_uploaded_file($tmp5,"../assets/images/".$image5);

  $video_file = $_FILES['video_file']['name'];
  $vtmp = $_FILES['video_file']['tmp_name'];
  if($video_file) move_uploaded_file($vtmp,"../assets/images/".$video_file);

  $show_in_bag = isset($_POST['in_deals_bag']) ? 1 : 0;
  $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : 'NULL';
  
  // Create URL Slug from Title
  $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));

  $sql = "INSERT INTO products (title,slug,price,category,affiliate_link,video_url,video_url_mockup,video_file,image,image2,image3,image4,image5,description,status,in_deals_bag,flipkart_price,flipkart_link,myntra_price,myntra_link,other_platform_name,other_platform_price,other_platform_link,store_id) 
  VALUES('$title','$slug','$price','$category','$link','$video_url','$video_url_mockup','$video_file','$image','$image2','$image3','$image4','$image5','$description','$status','$show_in_bag','$flipkart_price','$flipkart_link','$myntra_price','$myntra_link','$other_platform_name','$other_platform_price','$other_platform_link',$store_id)";
  
  if(mysqli_query($conn, $sql)){
      header("Location: products.php?msg=added&t=" . time());
      exit();
  }
}

$page_title = "Add Standard Product";
include 'admin_header.php';
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left Column -->
      <div>
        <label><i class="fas fa-tag"></i> Product Title</label>
        <input type="text" name="title" placeholder="e.g. Premium Leather Wallet" required>

        <label><i class="fas fa-rupee-sign"></i> Listing Price (INR)</label>
        <input type="text" name="price" placeholder="e.g. 1499" required>

        <label><i class="fas fa-list"></i> Select Category</label>
        <select name="category" required>
          <option value="">-- Choose Category --</option>
          <?php
          $cat = mysqli_query($conn,"SELECT * FROM categories");
          while($row=mysqli_fetch_assoc($cat)){
          ?>
          <option value="<?= $row['slug']?>"><?= $row['name']?></option>
          <?php } ?>
        </select>

        <label><i class="fas fa-store"></i> Associate with Store/Sale</label>
        <select name="store_id">
          <option value="">-- Select Store (Optional) --</option>
          <?php
          $sts = mysqli_query($conn,"SELECT * FROM stores WHERE status=1");
          while($s=mysqli_fetch_assoc($sts)){
          ?>
          <option value="<?= $s['id']?>"><?= $s['name']?></option>
          <?php } ?>
        </select>
      </div>

      <!-- Right Column -->
      <div>
        <label><i class="fas fa-external-link-alt"></i> Affiliate/Purchase Link</label>
        <input type="url" name="link" placeholder="https://amazon.in/..." required>

        <label><i class="fas fa-video"></i> Video File (MP4 - Optional)</label>
        <input type="file" name="video_file" accept="video/mp4">

        <label><i class="fas fa-image"></i> Product Main Image</label>
        <input type="file" name="image" required>

        <label><i class="fas fa-images"></i> Additional Mockup Images (Max 4)</label>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
          <input type="file" name="image2">
          <input type="file" name="image3">
          <input type="file" name="image4">
          <input type="file" name="image5">
        </div>

        <label><i class="fas fa-video"></i> Select Internal Video Review (Watch Review)</label>
        <select name="video_url">
          <option value="">-- No Internal Review --</option>
          <?php
          $vids = mysqli_query($conn,"SELECT title, slug FROM videos WHERE status='active' OR status='1'");
          while($v=mysqli_fetch_assoc($vids)){
          ?>
            <option value="<?= $v['slug']?>"><?= $v['title']?></option>
          <?php } ?>
        </select>

        <label><i class="fab fa-instagram"></i> Mockup/Gallery Video URL (Embed)</label>
        <input type="text" name="video_url_mockup" placeholder="Instagram Reel, TikTok or direct Link">

        <label><i class="fas fa-toggle-on"></i> Initial Status</label>
        <select name="status">
          <option value="active">Active / Visible</option>
          <option value="inactive">Inactive / Hidden</option>
        </select>

        <div style="margin-top:20px; padding:15px; background:rgba(251, 146, 60, 0.05); border-radius:10px; border:1px solid rgba(251, 146, 60, 0.1);">
          <label class="switch-wrap" style="display:flex; align-items:center; justify-content:space-between; cursor:pointer;">
            <span><i class="fas fa-shopping-bag" style="color:#fb923c;"></i> Add to Mobile Deals Bag</span>
            <input type="checkbox" name="in_deals_bag" style="width:20px; height:20px;">
          </label>
        </div>
      </div>

    </div>

    <!-- Pricing Comparison Section -->
    <div style="margin-top:30px; padding:20px; background:rgba(255,255,255,0.05); border:1px solid var(--glass-border); border-radius:15px;">
      <h3 style="margin-bottom:20px; font-size:18px; color:var(--primary);"><i class="fas fa-chart-line"></i> Price Comparison (Optional)</h3>
      <div class="mb-3">
          <label class="form-label">Product Short Description (40-50 words)</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Enter short description..."></textarea>
      </div>
      
      <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:20px;">
        <!-- Flipkart -->
        <div>
          <label><i class="fab fa-product-hunt"></i> Flipkart Price</label>
          <input type="text" name="flipkart_price" placeholder="e.g. 1599">
          <label>Flipkart Link</label>
          <input type="url" name="flipkart_link" placeholder="https://flipkart.com/...">
        </div>

        <!-- Myntra -->
        <div>
          <label><i class="fas fa-shopping-bag"></i> Myntra Price</label>
          <input type="text" name="myntra_price" placeholder="e.g. 1650">
          <label>Myntra Link</label>
          <input type="url" name="myntra_link" placeholder="https://myntra.com/...">
        </div>

        <!-- Other -->
        <div>
          <label><i class="fas fa-store"></i> Other Platform Name</label>
          <input type="text" name="other_platform_name" placeholder="e.g. Ajio">
          <label>Other Price</label>
          <input type="text" name="other_platform_price" placeholder="e.g. 1400">
          <label>Other Link</label>
          <input type="url" name="other_platform_link" placeholder="https://ajio.com/...">
        </div>
      </div>

    <div style="margin-top:30px; border-top:1px solid var(--glass-border); padding-top:20px; display:flex; justify-content:flex-end; gap:15px;">
      <a href="products.php" class="admin-btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
      <button type="submit" name="submit" class="admin-btn btn-primary">
        <i class="fas fa-plus"></i> Create Standard Product Listing
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>
