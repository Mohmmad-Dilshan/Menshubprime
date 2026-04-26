<?php
session_start();
$page_title = "Add Offer";
include 'admin_header.php';

if(isset($_POST['add'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $button_text = mysqli_real_escape_string($conn, $_POST['button_text']);
    $button_link = mysqli_real_escape_string($conn, $_POST['button_link']);
    
    $banner = $_FILES['banner']['name'];
    $tmp = $_FILES['banner']['tmp_name'];
    
    $banner_name = '';
    if(!empty($banner)){
        $banner_name = time().$banner;
        move_uploaded_file($tmp, "../uploads/".$banner_name);
    }

    mysqli_query($conn, "INSERT INTO promotional_offers (title, subtitle, button_text, button_link, banner_image) VALUES ('$title', '$subtitle', '$button_text', '$button_link', '$banner_name')");
    echo "<script>alert('Offer added successfully'); window.location='promotional-offers.php';</script>";
}
?>
<div class="admin-card">
    <h2>Add New Offer</h2>
    <form action="" method="POST" enctype="multipart/form-data" class="admin-form" style="max-width:600px; margin-top:20px;">
        <label>Title (Optional)</label>
        <input type="text" name="title" placeholder="e.g., Winter Sale">
        
        <label>Subtitle / Description (Optional)</label>
        <input type="text" name="subtitle" placeholder="e.g., Up to 50% Off on Premium Jackets">
        
        <label>Button Text (Optional)</label>
        <input type="text" name="button_text" placeholder="e.g., Shop Now">
        
        <label>Button Link (Optional)</label>
        <input type="text" name="button_link" placeholder="e.g., https://link.com">
        
        <label>Banner Background Image (Landscape)</label>
        <input type="file" name="banner" required accept="image/*">
        
        <button type="submit" name="add" class="admin-btn btn-primary" style="margin-top:20px;">Add Offer</button>
    </form>
</div>
<?php include 'admin_footer.php'; ?>
