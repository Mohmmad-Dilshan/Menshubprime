<?php
session_start();
$page_title = "Manage Digital Products";
include 'admin_header.php';

/* DELETE */
if(isset($_GET['delete'])){
  $id = intval($_GET['delete']);
  mysqli_query($conn,"DELETE FROM digital_products WHERE id='$id'");
  echo "<script>window.location='manage-digital-products.php';</script>";
  exit();
}

/* TOGGLE STATUS */
if(isset($_GET['status'])){
  $id = intval($_GET['status']);

  $q = mysqli_query($conn,"SELECT status FROM digital_products WHERE id='$id'");
  $row = mysqli_fetch_assoc($q);

  $newStatus = ($row['status']=='active') ? 'inactive' : 'active';
  mysqli_query($conn,"UPDATE digital_products SET status='$newStatus' WHERE id='$id'");

  echo "<script>window.location='manage-digital-products.php';</script>";
  exit();
}

/* FETCH PRODUCTS */
$products = mysqli_query($conn,"SELECT * FROM digital_products ORDER BY id DESC");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>📦 Digital Products List</h2>
    <a href="add-digital-products.php" class="admin-btn btn-primary"><i class="fas fa-plus"></i> Add New Product</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Title</th>
          <th>Price</th>
          <th>Old Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($p=mysqli_fetch_assoc($products)){ ?>
        <tr>
          <td>#<?= $p['id']; ?></td>
          <td>
            <img src="../uploads/digital_products/<?= $p['image']; ?>" style="width:60px; height:60px; object-fit:cover; border-radius:10px;">
          </td>
          <td style="font-weight:600;"><?= htmlspecialchars($p['title']); ?></td>
          <td style="color:#22c55e; font-weight:700;">₹<?= $p['price']; ?></td>
          <td style="color:#64748b; text-decoration:line-through;">₹<?= empty($p['old_price']) ? '--' : $p['old_price']; ?></td>
          <td>
            <?php if($p['status'] == 'active' || $p['status'] == '1'): ?>
              <span class="badge badge-success">Active</span>
            <?php else: ?>
              <span class="badge badge-warning">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <div style="display:flex; gap:10px;">
              <a href="?status=<?= $p['id']; ?>" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Status">
                <i class="fas fa-power-off"></i>
              </a>
              <a href="edit-digital-products.php?id=<?= $p['id']; ?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="?delete=<?= $p['id']; ?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;" onclick="return confirm('Delete this product?')">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'admin_footer.php'; ?>