<?php
session_start();
$page_title = "Manage Mini Products";
include 'admin_header.php';

/* PAGINATION */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page-1) * $limit;

/* TOTAL RECORDS */
$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id) as total FROM mini_products"))['total'];
$pages = ceil($total / $limit);

/* FETCH DATA */
$result = mysqli_query($conn,"SELECT * FROM mini_products ORDER BY id DESC LIMIT $start, $limit");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>🔥 Mini Product Snippets</h2>
    <a href="add-mini.php" class="admin-btn btn-primary"><i class="fas fa-plus-circle"></i> Add Mini Product</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Preview</th>
          <th>Snippet Title</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($result)){ ?>
        <tr>
          <td>#<?= $row['id'] ?></td>
          <td>
            <div style="width:60px; height:60px; border-radius:8px; overflow:hidden; border:1px solid var(--glass-border);">
              <img src="../assets/images/<?= $row['image']; ?>" style="width:100%; height:100%; object-fit:cover;">
            </div>
          </td>
          <td style="font-weight:600;"><?= htmlspecialchars($row['title']) ?></td>
          <td style="color:#22c55e; font-weight:700;">₹<?= $row['price'] ?></td>
          <td>
            <?php if($row['status'] == 'active' || $row['status'] == '1'): ?>
              <span class="badge badge-success">Active</span>
            <?php else: ?>
              <span class="badge badge-warning">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <div style="display:flex; gap:10px;">
              <a href="toggle-status.php?id=<?= $row['id']; ?>&table=mini_products" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Status">
                <i class="fas fa-power-off"></i>
              </a>
              <a href="edit-mini.php?id=<?= $row['id'] ?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-mini.php?id=<?= $row['id'] ?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;" onclick="return confirm('Delete this mini product snippet?')">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php if($pages > 1): ?>
  <div style="display:flex; justify-content:center; gap:10px; margin-top:30px;">
    <?php for($i=1;$i<=$pages;$i++){ ?>
    <a href="mini-products.php?page=<?= $i; ?>" class="admin-btn <?= ($i==$page)?'btn-primary':''; ?>" style="padding:8px 14px; min-width:40px; justify-content:center;">
      <?= $i; ?>
    </a>
    <?php } ?>
  </div>
  <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>