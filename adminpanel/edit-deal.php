<?php
session_start();
$page_title = "Edit Promotional Deal";
include 'admin_header.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

/* FETCH DEAL DATA */
$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM deals WHERE id='$id'"));
if(!$data){
  echo "<div class='alert alert-danger'>Deal not found.</div>";
  include 'admin_footer.php';
  exit();
}

/* FETCH PRODUCTS FOR DROPDOWN */
$products = mysqli_query($conn,"SELECT id,title FROM products ORDER BY title ASC");

/* UPDATE */
if(isset($_POST['update'])){
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $old_price = mysqli_real_escape_string($conn, $_POST['old_price']);
  $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

  /* IMAGE CHECK */
  if(!empty($_FILES['image']['name'])){
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $newname = time()."_".$img;
    move_uploaded_file($tmp,"../assets/images/".$newname);
  } else {
    $newname = $data['image'];
  }

  mysqli_query($conn,"UPDATE deals SET 
    title='$title',
    product_id='$product_id',
    price='$price',
    old_price='$old_price',
    image='$newname'
    WHERE id='$id'");

  echo "<script>alert('Deal Updated Successfully!'); window.location='deals.php';</script>";
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left Column -->
      <div>
        <label><i class="fas fa-bullhorn"></i> Deal Headline</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>

        <label><i class="fas fa-rupee-sign"></i> Deal Price (INR)</label>
        <input type="text" name="price" value="<?= htmlspecialchars($data['price']); ?>" required>

        <label><i class="fas fa-tags"></i> Original Price (INR)</label>
        <input type="text" name="old_price" value="<?= htmlspecialchars($data['old_price']); ?>" required>
      </div>

      <!-- Right Column -->
      <div>
        <label><i class="fas fa-link"></i> Linked Product</label>
        <select name="product_id" required>
          <option value="">-- Choose Product --</option>
          <?php while($p=mysqli_fetch_assoc($products)){ ?>
          <option value="<?= $p['id']; ?>" <?= ($p['id']==$data['product_id'])?'selected':''; ?>>
            <?= htmlspecialchars($p['title']); ?>
          </option>
          <?php } ?>
        </select>

        <div style="margin-top:20px; display:flex; align-items:flex-end; gap:20px;">
          <div style="flex-shrink:0;">
            <label>Current Visual</label><br>
            <img src="../assets/images/<?= $data['image']; ?>" style="width:80px; height:80px; object-fit:cover; border-radius:12px; border:1px solid var(--glass-border);">
          </div>
          <div style="flex-grow:1;">
            <label><i class="fas fa-image"></i> Replace Deal Image</label>
            <input type="file" name="image">
          </div>
        </div>
      </div>

    </div>

    <div style="margin-top:40px; border-top:1px solid var(--glass-border); padding-top:20px; display:flex; justify-content:flex-end; gap:15px;">
      <a href="deals.php" class="admin-btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
      <button type="submit" name="update" class="admin-btn btn-primary">
        <i class="fas fa-save"></i> Save Deal Changes
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>