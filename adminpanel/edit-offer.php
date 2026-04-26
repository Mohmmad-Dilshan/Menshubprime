<?php
session_start();
$page_title = "Edit Offer";
include 'admin_header.php';

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM promotional_offers WHERE id='$id'"));

if(isset($_POST['edit'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $button_text = mysqli_real_escape_string($conn, $_POST['button_text']);
    $button_link = mysqli_real_escape_string($conn, $_POST['button_link']);
    
    $banner = $_FILES['banner']['name'];
    $tmp = $_FILES['banner']['tmp_name'];
    
    if(!empty($banner)){
        $banner_name = time().$banner;
        move_uploaded_file($tmp, "../uploads/".$banner_name);
        if(!empty($data['banner_image']) && file_exists("../uploads/".$data['banner_image'])){
            unlink("../uploads/".$data['banner_image']);
        }
    } else {
        $banner_name = $data['banner_image'];
    }

    mysqli_query($conn, "UPDATE promotional_offers SET title='$title', subtitle='$subtitle', button_text='$button_text', button_link='$button_link', banner_image='$banner_name' WHERE id='$id'");
    echo "<script>alert('Offer updated successfully'); window.location='promotional-offers.php';</script>";
}
?>
<div class="admin-card">
    <h2>Edit Offer</h2>
    <form action="" method="POST" enctype="multipart/form-data" class="admin-form" style="max-width:600px; margin-top:20px;">
        <label>Title (Optional)</label>
        <input type="text" name="title" value="<?=htmlspecialchars($data['title'] ?? '');?>">
        
        <label>Subtitle / Description (Optional)</label>
        <input type="text" name="subtitle" value="<?=htmlspecialchars($data['subtitle'] ?? '');?>">
        
        <label>Button Text (Optional)</label>
        <input type="text" name="button_text" value="<?=htmlspecialchars($data['button_text'] ?? '');?>">
        
        <label>Button Link (Optional)</label>
        <input type="text" name="button_link" value="<?=htmlspecialchars($data['button_link'] ?? '');?>">
        
        <label>Banner Background Image</label>
        <?php if(!empty($data['banner_image'])): ?>
            <div style="margin-bottom:10px;">
                <img src="../uploads/<?=$data['banner_image'];?>" style="max-width:100%; height:150px; object-fit:cover; border-radius:10px;">
            </div>
        <?php endif; ?>
        <input type="file" name="banner" accept="image/*">
        <small style="color:var(--text-muted);">Leave empty to keep existing banner.</small>
        
        <button type="submit" name="edit" class="admin-btn btn-primary" style="margin-top:20px;">Update Offer</button>
    </form>
</div>
<?php include 'admin_footer.php'; ?>
