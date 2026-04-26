<?php
session_start();
$page_title = "Manage Affiliate Stores";
include 'admin_header.php';

// Handle Status Toggle
if(isset($_GET['type']) && $_GET['type'] == 'status'){
    $id = $_GET['id'];
    $status = $_GET['status'] == 1 ? 0 : 1;
    mysqli_query($conn, "UPDATE stores SET status='$status' WHERE id='$id'");
    echo "<script>window.location='manage-stores.php';</script>";
}

// Handle Delete
if(isset($_GET['type']) && $_GET['type'] == 'delete'){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM stores WHERE id='$id'");
    echo "<script>window.location='manage-stores.php';</script>";
}

$stores = mysqli_query($conn, "SELECT * FROM stores ORDER BY id DESC");
?>

<div class="admin-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h2><i class="fas fa-store"></i> Affiliate Stores & Sales</h2>
        <a href="add-store.php" class="admin-btn btn-primary">
            <i class="fas fa-plus"></i> Add New Store
        </a>
    </div>

    <div class="admin-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Slug</th>
                    <th>Icon</th>
                    <th>Color</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($stores)): ?>
                <tr>
                    <td style="font-weight:600; color:#fff;"><?= $row['name'] ?></td>
                    <td style="opacity:0.6;"><?= $row['slug'] ?></td>
                    <td><i class="<?= $row['icon'] ?>" style="color:<?= $row['color'] ?>; font-size:20px;"></i></td>
                    <td>
                        <span style="display:inline-block; width:16px; height:16px; border-radius:50%; background:<?= $row['color'] ?>; box-shadow: 0 0 10px <?= $row['color'] ?>44;"></span>
                    </td>
                    <td>
                        <?php if($row['status'] == 1): ?>
                          <span class="badge badge-success">Active</span>
                        <?php else: ?>
                          <span class="badge badge-warning">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex; gap:12px;">
                          <a href="?type=status&id=<?= $row['id'] ?>&status=<?= $row['status'] ?>" style="color:#fff; background:rgba(255,255,255,0.05); padding:6px 12px; border-radius:8px;"><i class="fas fa-power-off"></i></a>
                          <a href="edit-store.php?id=<?= $row['id'] ?>" style="color:#3b82f6;"><i class="fas fa-edit"></i></a>
                          <a href="?type=delete&id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" style="color:#ef4444;"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
