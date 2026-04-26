<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}

include '../config/db.php';

/* VALIDATE ID */
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
  die("Invalid Product ID");
}

$id = intval($_GET['id']);

/* FETCH PRODUCT */
$q = mysqli_query($conn,"SELECT * FROM digital_products WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if(!$data){
  die("Product not found");
}

/* UPDATE */
if(isset($_POST['update_product'])){

  $title        = $_POST['title'];
  $description  = $_POST['description'];
  $features     = $_POST['features'];
  $what_you_get = $_POST['what_you_get'];
  $price        = $_POST['price'];
  $old_price    = $_POST['old_price'];
  $product_link = $_POST['product_link'];
  $razorpay_link = $_POST['razorpay_link'];
  $custom_label = $_POST['custom_label'];
  $status       = $_POST['status'];
  $badge_text   = $_POST['badge_text'];

  /* SLUG GENERATION */
  function slugify($text) {
    if(empty($text)) return 'n-a';
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text;
  }
  $badge_text   = mysqli_real_escape_string($conn,$_POST['badge_text']);

  $image = $data['image'];
  if(!empty($_FILES['image']['name'])){
    $newImg = time().'_'.$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],"../uploads/digital_products/".$newImg);
    $image = $newImg;
  }

  $product_link = $data['product_link'];
  
  $preview_images_string = $data['preview_images'] ?? '';
  if(!empty($_FILES['preview_imgs']['name'][0])){
    $preview_images_arr = [];
    foreach($_FILES['preview_imgs']['name'] as $key => $val){
      $tImgName = $_FILES['preview_imgs']['name'][$key];
      $tTmpName = $_FILES['preview_imgs']['tmp_name'][$key];
      if(!empty($tImgName)){
        $tNewImg = time().'_prv'.$key.'_'.preg_replace("/[^a-zA-Z0-9.-]/", "_", $tImgName);
        if(move_uploaded_file($tTmpName, "../uploads/digital_products/".$tNewImg)) {
          $preview_images_arr[] = $tNewImg;
        }
      }
    }
    if(count($preview_images_arr) > 0){
      $preview_images_string = implode(',', $preview_images_arr);
    }
  }
  if(!empty($_FILES['product_file']['name'])){
    $newFile = time().'_'.$_FILES['product_file']['name'];
    move_uploaded_file($_FILES['product_file']['tmp_name'],"../uploads/downloads/".$newFile);
    $product_link = $newFile;
  } elseif(!empty($_POST['product_link'])){
    $product_link = mysqli_real_escape_string($conn,$_POST['product_link']);
  }

  mysqli_query($conn,"UPDATE digital_products SET 
    title='$title', 
    description='$description',
    features='$features',
    what_you_get='$what_you_get',
    image='$image',
    preview_images='$preview_images_string',
    price='$price',
    old_price='$old_price',
    product_link='$product_link',
    razorpay_link='$razorpay_link',
    custom_label='$custom_label',
    status='$status',
    badge_text='$badge_text'
    WHERE id='$id'");

  echo "<script>alert('Updated Successfully'); window.location='manage-digital-products.php';</script>";
}

$page_title = "Edit Digital Product";
include 'admin_header.php';
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left: Content Info -->
      <div>
        <label>Product Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($data['description']); ?></textarea>

        <label>Key Features (One per line)</label>
        <textarea name="features" style="min-height:80px;"><?= htmlspecialchars($data['features']); ?></textarea>

        <label>What You Will Get (One per line)</label>
        <textarea name="what_you_get" style="min-height:80px;"><?= htmlspecialchars($data['what_you_get']); ?></textarea>

        <label>Offer Badge (e.g. 80% OFF)</label>
        <input type="text" name="badge_text" value="<?= htmlspecialchars($data['badge_text']); ?>">
      </div>

      <!-- Right: Pricing & Delivery -->
      <div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
          <div>
            <label>Current Price (₹)</label>
            <input type="text" name="price" value="<?= $data['price']; ?>" required>
          </div>
          <div>
            <label>Old Price (₹)</label>
            <input type="text" name="old_price" value="<?= $data['old_price']; ?>">
          </div>
        </div>

        <label>Replace Image</label>
        <input type="file" name="image">

        <label style="color:#0ea5e9; font-weight:700;">★ Replace Preview Images (Select up to 3 PDF pages)</label>
        <div style="display:flex; flex-direction:column; gap:5px; margin-bottom:15px;">
          <input type="file" name="preview_imgs[]" accept="image/*" style="margin:0;">
          <input type="file" name="preview_imgs[]" accept="image/*" style="margin:0;">
          <input type="file" name="preview_imgs[]" accept="image/*" style="margin:0;">
        </div>

        <label>Replace Product File (.pdf, .zip)</label>
        <input type="file" name="product_file">
        
        <p style="text-align:center; color:var(--text-muted); margin:10px 0; font-size:11px; font-weight:700;">— OR —</p>
        
        <label>Change Manual Link</label>
        <input type="text" name="product_link" value="<?= (strpos($data['product_link'],'.')!==false && strpos($data['product_link'],'_')===false) ? htmlspecialchars($data['product_link']) : ''; ?>">

        <label>Razorpay Payment Link</label>
        <input type="text" name="razorpay_link" value="<?= htmlspecialchars($data['razorpay_link']); ?>" required>

        <label>Custom User Field</label>
        <input type="text" name="custom_label" value="<?= htmlspecialchars($data['custom_label']); ?>">
      </div>

    </div>

    <div style="margin-top:30px; border-top:1px solid var(--glass-border); padding-top:25px; display:flex; justify-content:space-between; align-items:center;">
      <div style="display:flex; align-items:center; gap:15px;">
        <label style="margin:0;">Product Visibility:</label>
        <select name="status" style="width:160px;">
          <option value="active" <?= $data['status']=='active'?'selected':''; ?>>Active</option>
          <option value="inactive" <?= $data['status']=='inactive'?'selected':''; ?>>Inactive</option>
        </select>
      </div>
      <button type="submit" name="update_product" class="admin-btn btn-primary" style="padding:15px 50px;">
        <i class="fas fa-save"></i> Update Digital Product
      </button>
    </div>

  </form>
</div>

<?php include 'admin_footer.php'; ?>