<?php
session_start();
$page_title = "Manage Promotional Deals";
include 'admin_header.php';

/* DELETE */
if(isset($_GET['del'])){
  $id = mysqli_real_escape_string($conn, $_GET['del']);
  mysqli_query($conn,"DELETE FROM deals WHERE id='$id'");
  echo "<script>window.location='deals.php';</script>";
}

/* PAGINATION */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page-1) * $limit;

$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id) as total FROM deals"))['total'];
$pages = ceil($total / $limit);

/* FETCH DEALS */
$q = mysqli_query($conn,"
  SELECT deals.*, products.title AS product_title
  FROM deals
  LEFT JOIN products ON deals.product_id = products.id
  ORDER BY deals.id DESC
  LIMIT $start, $limit
");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>🔥 active Promotional Deals</h2>
    <a href="add-deal.php" class="admin-btn btn-primary"><i class="fas fa-fire"></i> Launch New Deal</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Visual</th>
          <th>Deal Headline</th>
          <th>Linked Product</th>
          <th>Deal Price</th>
          <th>Original Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($q)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td>
            <img src="../assets/images/<?= $row['image']; ?>" style="width:60px; height:60px; object-fit:cover; border-radius:8px; border:1px solid var(--glass-border);">
          </td>
          <td style="font-weight:600;"><?= htmlspecialchars($row['title']); ?></td>
          <td>
            <?php if($row['product_title']): ?>
              <span class="badge" style="background:rgba(34, 197, 94, 0.1); color:#22c55e; border:1px solid rgba(34, 197, 94, 0.2);">
                <i class="fas fa-link"></i> <?= htmlspecialchars($row['product_title']); ?>
              </span>
            <?php else: ?>
              <span class="badge" style="background:rgba(239, 68, 68, 0.1); color:#ef4444; border:1px solid rgba(239, 68, 68, 0.2);">
                <i class="fas fa-unlink"></i> Unlinked
              </span>
            <?php endif; ?>
          </td>
          <td style="color:#22c55e; font-weight:700;">₹<?= $row['price']; ?></td>
          <td style="text-decoration:line-through; color:var(--text-muted); font-size:13px;">₹<?= $row['old_price']; ?></td>
          <td>
            <div style="display:flex; gap:10px;">
              <a href="edit-deal.php?id=<?= $row['id']; ?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="?del=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;" onclick="return confirm('Delete this promotional deal?')">
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
    <a href="deals.php?page=<?= $i; ?>" class="admin-btn <?= ($i==$page)?'btn-primary':''; ?>" style="padding:8px 14px; min-width:40px; justify-content:center;">
      <?= $i; ?>
    </a>
    <?php } ?>
  </div>
  <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>