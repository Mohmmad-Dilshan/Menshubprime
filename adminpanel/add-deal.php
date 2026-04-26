<?php
session_start();
$page_title = "Create New Promotional Deal";
include 'admin_header.php';

/* Fetch products for dropdown */
$products = mysqli_query($conn,"SELECT id,title FROM products ORDER BY id DESC");

if(isset($_POST['add'])){
  $title = mysqli_real_escape_string($conn,$_POST['title']);
  $price = mysqli_real_escape_string($conn,$_POST['price']);
  $old_price = mysqli_real_escape_string($conn,$_POST['old_price']);
  $product_id = mysqli_real_escape_string($conn,$_POST['product_id']);

  $img = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  $newname = time()."_".$img;
  move_uploaded_file($tmp,"../assets/images/".$newname);

  // Automatically set deal to expire exactly 24 hours from creation
  mysqli_query($conn,"INSERT INTO deals (title,price,old_price,product_id,image,end_time) VALUES('$title','$price','$old_price','$product_id','$newname', DATE_ADD(NOW(), INTERVAL 24 HOUR))");

  echo "<script>alert('Deal Launched Successfully!'); window.location='deals.php';</script>";
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left Column -->
      <div>
        <label><i class="fas fa-bullhorn"></i> Deal Headline</label>
        <input type="text" name="title" placeholder="e.g. Flash Sale: 50% Off Top Grooming Kits" required>

        <label><i class="fas fa-rupee-sign"></i> Deal Price (INR)</label>
        <input type="text" name="price" placeholder="e.g. 999" required>

        <label><i class="fas fa-tags"></i> Original Price (INR)</label>
        <input type="text" name="old_price" placeholder="e.g. 1999">
      </div>

      <!-- Right Column -->
      <div>
        <label><i class="fas fa-link"></i> Link to Existing Product</label>
        <select name="product_id" required>
          <option value="">-- Choose Product --</option>
          <?php while($p=mysqli_fetch_assoc($products)){ ?>
          <option value="<?=$p['id'];?>"><?=$p['title'];?></option>
          <?php } ?>
        </select>

        <label><i class="fas fa-image"></i> Deal Promo Image</label>
        <input type="file" name="image" required>
        
        <div style="margin-top:15px; background:rgba(34, 197, 94, 0.05); border:1px solid rgba(34, 197, 94, 0.2); border-radius:10px; padding:15px;">
          <p style="font-size:12px; color:#22c55e;"><i class="fas fa-clock"></i> <strong>Note:</strong> New deals are automatically set to expire in 24 hours to create urgency.</p>
        </div>
      </div>

    </div>

    <div style="margin-top:30px; border-top:1px solid var(--glass-border); padding-top:20px; display:flex; justify-content:flex-end; gap:15px;">
      <a href="deals.php" class="admin-btn btn-danger"><i class="fas fa-times"></i> Discard</a>
      <button type="submit" name="add" class="admin-btn btn-primary">
        <i class="fas fa-fire"></i> Launch Promotional Deal
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>