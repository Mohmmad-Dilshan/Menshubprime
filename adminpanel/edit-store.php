<?php
session_start();
$page_title = "Edit Store";
include 'admin_header.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM stores WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $status = isset($_POST['status']) ? 1 : 0;

    $sql = "UPDATE stores SET name='$name', slug='$slug', icon='$icon', color='$color', status='$status' WHERE id='$id'";
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Store Updated'); window.location='manage-stores.php';</script>";
    } else {
        echo "<script>alert('Error: ".mysqli_error($conn)."');</script>";
    }
}
?>

<div class="admin-card" style="max-width:600px; margin: 0 auto;">
    <h2 style="color:#fff; margin-bottom:30px;"><i class="fas fa-edit"></i> Edit Store</h2>
    
    <form action="" method="POST" class="admin-form">
        <label>Store Name</label>
        <input type="text" name="name" value="<?= $row['name'] ?>" required>

        <label>Slug</label>
        <input type="text" name="slug" value="<?= $row['slug'] ?>" required>

        <label>FontAwesome Icon</label>
        <input type="text" name="icon" value="<?= $row['icon'] ?>">

        <label>Accent Color</label>
        <div style="display:flex; gap:10px;">
            <input type="color" name="color" value="<?= $row['color'] ?>" style="width:60px; height:45px; padding:5px;">
            <input type="text" name="color_hex" id="color_hex" value="<?= $row['color'] ?>" style="flex:1;">
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:20px; padding:20px; background:rgba(255,255,255,0.03); border-radius:12px;">
            <div>
                <strong style="color:#fff;">Active Status</strong><br>
                <small style="color:var(--text-muted);">Visible in the frontend hub</small>
            </div>
            <label class="switch">
                <input type="checkbox" name="status" <?= $row['status'] == 1 ? 'checked' : '' ?>>
                <span class="slider round"></span>
            </label>
        </div>

        <button type="submit" name="update" class="btn-primary" style="width:100%; margin-top:30px; padding:15px; border-radius:12px;">
            Update Store
        </button>
    </form>
</div>

<script>
document.querySelector('input[type="color"]').addEventListener('input', function(e) {
    document.getElementById('color_hex').value = e.target.value;
});
</script>

<?php include 'admin_footer.php'; ?>
