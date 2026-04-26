<?php
session_start();
$page_title = "Edit Mini Product Snippet";
include 'admin_header.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

/* FETCH DATA */
$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM mini_products WHERE id='$id'"));
if(!$data){
  echo "<div class='alert alert-danger'>Mini Product Snippet not found.</div>";
  include 'admin_footer.php';
  exit();
}

/* UPDATE */
if(isset($_POST['update'])){
  $title = mysqli_real_escape_string($conn,$_POST['title']);
  $price = mysqli_real_escape_string($conn,$_POST['price']);
  $link  = mysqli_real_escape_string($conn,$_POST['link']);
  $status = mysqli_real_escape_string($conn,$_POST['status']);

  /* Image check */
  if(!empty($_FILES['image']['name'])){
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $newname = time()."_".$img;
    move_uploaded_file($tmp,"../assets/images/".$newname);

    mysqli_query($conn,"UPDATE mini_products SET title='$title', price='$price', link='$link', image='$newname', status='$status' WHERE id='$id'");
  } else {
    mysqli_query($conn,"UPDATE mini_products SET title='$title', price='$price', link='$link', status='$status' WHERE id='$id'");
  }

  echo "<script>alert('Mini Product Updated Successfully!'); window.location='mini-products.php';</script>";
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left Column -->
      <div>
        <label><i class="fas fa-tag"></i> Snippet Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>

        <label><i class="fas fa-rupee-sign"></i> Display Price (INR)</label>
        <input type="text" name="price" value="<?= htmlspecialchars($data['price']); ?>" required>
      </div>

      <!-- Right Column -->
      <div>
        <label><i class="fas fa-link"></i> Affiliate/Product Link</label>
        <input type="url" name="link" value="<?= htmlspecialchars($data['link']); ?>" required>

        <label><i class="fas fa-toggle-on"></i> Snippet Status</label>
        <select name="status">
          <option value="active" <?= ($data['status']=='active')?'selected':'' ?>>Active / Visible</option>
          <option value="inactive" <?= ($data['status']=='inactive')?'selected':'' ?>>Inactive / Hidden</option>
        </select>

        <div style="margin-top:20px; display:flex; align-items:flex-end; gap:20px;">
          <div style="flex-shrink:0;">
            <label>Current Visual</label><br>
            <img src="../assets/images/<?= $data['image']; ?>" style="width:70px; height:70px; object-fit:cover; border-radius:10px; border:1px solid var(--glass-border);">
          </div>
          <div style="flex-grow:1;">
            <label><i class="fas fa-image"></i> Replace Snippet Image</label>
            <input type="file" name="image">
          </div>
        </div>
      </div>

    </div>

    <div style="margin-top:40px; border-top:1px solid var(--glass-border); padding-top:20px; display:flex; justify-content:flex-end; gap:15px;">
      <a href="mini-products.php" class="admin-btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
      <button type="submit" name="update" class="admin-btn btn-primary">
        <i class="fas fa-save"></i> Save Snippet Changes
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>
