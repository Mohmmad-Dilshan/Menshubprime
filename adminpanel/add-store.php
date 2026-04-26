<?php
session_start();
$page_title = "Add New Store";
include 'admin_header.php';

if(isset($_POST['add'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $status = isset($_POST['status']) ? 1 : 0;

    $sql = "INSERT INTO stores (name, slug, icon, color, status) VALUES ('$name', '$slug', '$icon', '$color', '$status')";
    if(mysqli_query($conn, $sql)){
        header("Location: manage-stores.php?msg=added&t=".time());
        exit();
    } else {
        $error = mysqli_real_escape_string($conn, mysqli_error($conn));
        echo "<script>window.addEventListener('load', () => showToast('Database Error', '$error', 'error'));</script>";
    }
}
?>

<div class="admin-card" style="max-width:600px; margin: 0 auto;">
    <h2 style="color:#fff; margin-bottom:30px;"><i class="fas fa-plus-circle"></i> Create New Store</h2>
    
    <form action="" method="POST" class="admin-form">
        <label>Store Name (e.g. Winter Sale 2024)</label>
        <input type="text" name="name" required placeholder="Enter store name">

        <label>Slug (e.g. winter-sale)</label>
        <input type="text" name="slug" required placeholder="URL friendly name (lowercase, no spaces)">

        <label>FontAwesome Icon (e.g. fas fa-snowflake)</label>
        <input type="text" name="icon" value="fas fa-store" placeholder="fas fa-store">

        <label>Accent Color (Hex)</label>
        <div style="display:flex; gap:10px;">
            <input type="color" name="color" value="#f97316" style="width:60px; height:45px; padding:5px;">
            <input type="text" name="color_hex" id="color_hex" value="#f97316" style="flex:1;">
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:20px; padding:20px; background:rgba(255,255,255,0.03); border-radius:12px;">
            <div>
                <strong style="color:#fff;">Active Status</strong><br>
                <small style="color:var(--text-muted);">Visible in the frontend hub</small>
            </div>
            <label class="switch">
                <input type="checkbox" name="status" checked>
                <span class="slider round"></span>
            </label>
        </div>

        <button type="submit" name="add" class="btn-primary" style="width:100%; margin-top:30px; padding:15px; border-radius:12px;">
            Create Store
        </button>
    </form>
</div>

<script>
document.querySelector('input[type="color"]').addEventListener('input', function(e) {
    document.getElementById('color_hex').value = e.target.value;
});
</script>

<?php include 'admin_footer.php'; ?>
