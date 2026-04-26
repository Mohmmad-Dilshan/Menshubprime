<?php
session_start();
$page_title = "Add Mini Product Snippet";
include 'admin_header.php';

if(isset($_POST['submit'])){
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $link = mysqli_real_escape_string($conn, $_POST['link']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  $img = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  $newname = time()."_".$img;
  move_uploaded_file($tmp, "../assets/images/".$newname);

  mysqli_query($conn,"INSERT INTO mini_products (image,title,price,link,status) VALUES('$newname','$title','$price','$link','$status')");

  echo "<script>alert('Mini Product Added Successfully!'); window.location='mini-products.php';</script>";
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left Column -->
      <div>
        <label><i class="fas fa-tag"></i> Snippet Title</label>
        <input type="text" name="title" placeholder="e.g. Minimalist Watch" required>

        <label><i class="fas fa-rupee-sign"></i> Display Price (INR)</label>
        <input type="text" name="price" placeholder="e.g. 499" required>
      </div>

      <!-- Right Column -->
      <div>
        <label><i class="fas fa-link"></i> Affiliate/Product Link</label>
        <input type="url" name="link" placeholder="https://amazon.in/..." required>

        <label><i class="fas fa-image"></i> Snippet Image</label>
        <input type="file" name="image" required>

        <label><i class="fas fa-toggle-on"></i> Initial Status</label>
        <select name="status">
          <option value="active">Active / Visible</option>
          <option value="inactive">Inactive / Hidden</option>
        </select>
      </div>

    </div>

    <div style="margin-top:30px; border-top:1px solid var(--glass-border); padding-top:20px; display:flex; justify-content:flex-end; gap:15px;">
      <a href="mini-products.php" class="admin-btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
      <button type="submit" name="submit" class="admin-btn btn-primary">
        <i class="fas fa-save"></i> Save Mini Product
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>
