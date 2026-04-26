<?php
session_start();
$page_title = "Manage Products";
include 'admin_header.php';

/* PAGINATION SETUP */
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

/* CATEGORY FILTER SETUP */
$cat_filter = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';
$where_clause = $cat_filter ? "WHERE category='$cat_filter'" : "";

/* TOTAL RECORDS */
$total_query = mysqli_query($conn,"SELECT COUNT(id) as total FROM products $where_clause");
$total = mysqli_fetch_assoc($total_query)['total'];
$pages = ceil($total / $limit);

/* FETCH DATA */
$q = mysqli_query($conn,"SELECT * FROM products $where_clause ORDER BY id DESC LIMIT $start, $limit");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
    <div style="display:flex; align-items:center; gap:15px;">
      <h2>📦 Products List</h2>
      <form action="products.php" method="GET" id="catFilterForm">
        <select name="cat" onchange="this.form.submit()" style="background:rgba(255,255,255,0.05); color:white; border:1px solid var(--glass-border); padding:8px 15px; border-radius:8px; outline:none; cursor:pointer;">
          <option value="">All Categories</option>
          <?php
          $cats = mysqli_query($conn,"SELECT * FROM categories ORDER BY name ASC");
          while($c = mysqli_fetch_assoc($cats)){
            $selected = ($cat_filter == $c['slug']) ? 'selected' : '';
            echo "<option value='".$c['slug']."' $selected>".htmlspecialchars($c['name'])."</option>";
          }
          ?>
        </select>
      </form>
    </div>
    <a href="add-product.php" class="admin-btn btn-primary"><i class="fas fa-plus"></i> Add New Product</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Title</th>
          <th>Price</th>
          <th>Category</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($q)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td>
            <img src="../assets/images/<?= $row['image']; ?>" style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
          </td>
          <td style="font-weight:600;"><?= htmlspecialchars($row['title']); ?></td>
          <td style="color:#22c55e; font-weight:700;">₹<?= $row['price']; ?></td>
          <td>
            <span class="badge" style="background:rgba(255,255,255,0.05); color:white; border:1px solid var(--glass-border);">
              <?= htmlspecialchars($row['category']); ?>
            </span>
          </td>
          <td>
            <?php if($row['status'] == 'active' || $row['status'] == '1'): ?>
              <span class="badge badge-success">Active</span>
            <?php else: ?>
              <span class="badge badge-warning">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <div style="display:flex; gap:10px;">
              <a href="toggle-status.php?id=<?= $row['id']; ?>&table=products" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Status">
                <i class="fas fa-power-off"></i>
              </a>
              <a href="edit-product.php?id=<?= $row['id']; ?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-product.php?id=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;" onclick="return confirm('Delete this product?')">
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
    <a href="products.php?page=<?= $i; ?><?= ($cat_filter ? '&cat='.$cat_filter : ''); ?>" class="admin-btn <?= ($i==$page)?'btn-primary':''; ?>" style="padding:8px 14px; min-width:40px; justify-content:center;">
      <?= $i; ?>
    </a>
    <?php } ?>
  </div>
  <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>