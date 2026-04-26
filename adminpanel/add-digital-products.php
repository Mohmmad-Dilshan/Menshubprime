<?php
session_start();
$page_title = "Add Digital Product";
include 'admin_header.php';

if(isset($_POST['submit'])){
  $title        = mysqli_real_escape_string($conn,$_POST['title']);
  $description  = mysqli_real_escape_string($conn,$_POST['description']);
  $features     = mysqli_real_escape_string($conn,$_POST['features']);
  $what_you_get = mysqli_real_escape_string($conn,$_POST['what_you_get']);
  $price        = mysqli_real_escape_string($conn,$_POST['price']);
  $old_price    = mysqli_real_escape_string($conn,$_POST['old_price']);
  $razorpay_link = mysqli_real_escape_string($conn,$_POST['razorpay_link']);
  $custom_label = mysqli_real_escape_string($conn,$_POST['custom_label']);
  $status       = $_POST['status'];
  $badge_text   = mysqli_real_escape_string($conn,$_POST['badge_text']);

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
  $slug = slugify($title);

  /* IMAGE UPLOAD */
  $imageName = $_FILES['image']['name'];
  $tmpImage  = $_FILES['image']['tmp_name'];
  $imgFolder = "../uploads/digital_products/";
  if(!is_dir($imgFolder)) mkdir($imgFolder,0777,true);
  $newImage = time().'_'.$imageName;
  move_uploaded_file($tmpImage,$imgFolder.$newImage);

  /* PREVIEW IMAGES */
  $preview_images_arr = [];
  if(!empty($_FILES['preview_imgs']['name'][0])){
    foreach($_FILES['preview_imgs']['name'] as $key => $val){
      $tImgName = $_FILES['preview_imgs']['name'][$key];
      $tTmpName = $_FILES['preview_imgs']['tmp_name'][$key];
      if(!empty($tImgName)){
        $tNewImg = time().'_prv'.$key.'_'.preg_replace("/[^a-zA-Z0-9.-]/", "_", $tImgName);
        if(move_uploaded_file($tTmpName, $imgFolder.$tNewImg)) {
          $preview_images_arr[] = $tNewImg;
        }
      }
    }
  }
  $preview_images_string = implode(',', $preview_images_arr);

  /* FILE UPLOAD */
  $pdfName = $_FILES['product_file']['name'];
  $tmpPdf  = $_FILES['product_file']['tmp_name'];
  $pdfFolder = "../uploads/downloads/";
  if(!is_dir($pdfFolder)) mkdir($pdfFolder,0777,true);

  if(!empty($pdfName)){
    $newPdf = time().'_'.$pdfName;
    if(move_uploaded_file($tmpPdf, $pdfFolder.$newPdf)) {
      chmod($pdfFolder.$newPdf, 0644);
      $product_link = $newPdf;
    }
  } else {
    $product_link = mysqli_real_escape_string($conn,$_POST['product_link']);
  }

  $sql = "INSERT INTO digital_products 
  (title,description,features,what_you_get,image,preview_images,price,old_price,product_link,razorpay_link,custom_label,status,badge_text,slug) 
  VALUES 
  ('$title','$description','$features','$what_you_get','$newImage','$preview_images_string','$price','$old_price','$product_link','$razorpay_link','$custom_label','$status','$badge_text','$slug')";

  if(mysqli_query($conn,$sql)){
    echo "<script>window.location='manage-digital-products.php';</script>";
    exit();
  }
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
      
      <!-- Left: Content Info -->
      <div>
        <label>Product Title</label>
        <input type="text" name="title" placeholder="Digital Masterclass" required>

        <label>Description</label>
        <textarea name="description" placeholder="Short summary of the product..."></textarea>

        <label>Key Features (One per line)</label>
        <textarea name="features" style="min-height:80px;" placeholder="Lifetime Access
Fast Support"></textarea>

        <label>What You Will Get (One per line)</label>
        <textarea name="what_you_get" style="min-height:80px;" placeholder="PDF Guide
Video Links"></textarea>

        <label>Offer Badge (e.g. 80% OFF)</label>
        <input type="text" name="badge_text" placeholder="Limited Offer">
      </div>

      <!-- Right: Pricing & Delivery -->
      <div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
          <div>
            <label>Current Price (₹)</label>
            <input type="text" name="price" placeholder="199" required>
          </div>
          <div>
            <label>Old Price (₹)</label>
            <input type="text" name="old_price" placeholder="999">
          </div>
        </div>

        <label>Product Image (Thumbnail)</label>
        <input type="file" name="image" required>

        <label style="color:#0ea5e9; font-weight:700;">★ Preview Images (Select up to 3 PDF pages)</label>
        <div style="display:flex; flex-direction:column; gap:5px; margin-bottom:15px;">
          <input type="file" name="preview_imgs[]" accept="image/*" style="margin:0;">
          <input type="file" name="preview_imgs[]" accept="image/*" style="margin:0;">
          <input type="file" name="preview_imgs[]" accept="image/*" style="margin:0;">
        </div>

        <label>Upload File (.pdf, .zip)</label>
        <input type="file" name="product_file">
        
        <p style="text-align:center; color:var(--text-muted); margin:10px 0; font-size:11px; font-weight:700;">— OR —</p>
        
        <label>Direct Internal/External Link</label>
        <input type="text" name="product_link" placeholder="External Drive Link">

        <label>Razorpay Payment Link</label>
        <input type="text" name="razorpay_link" placeholder="https://rzp.io/..." required>

        <label>Custom User Field (Optional)</label>
        <input type="text" name="custom_label" placeholder="e.g. Instagram Username">
      </div>

    </div>

    <div style="margin-top:30px; border-top:1px solid var(--glass-border); padding-top:25px; display:flex; justify-content:space-between; align-items:center;">
      <div style="display:flex; align-items:center; gap:15px;">
        <label style="margin:0;">Product Visibility:</label>
        <select name="status" style="width:160px;">
          <option value="active">Active (Visible)</option>
          <option value="inactive">Inactive (Hidden)</option>
        </select>
      </div>
      <button type="submit" name="submit" class="admin-btn btn-primary" style="padding:15px 50px;">
        <i class="fas fa-cloud-upload-alt"></i> Publish Digital Product
      </button>
    </div>

  </form>
</div>

<?php include 'admin_footer.php'; ?>