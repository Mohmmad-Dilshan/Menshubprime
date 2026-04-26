<?php
session_start();
$page_title = "Manage Comparison Tables";
include 'admin_header.php';

/* FETCH DATA */
$q = mysqli_query($conn,"SELECT * FROM comparison_tables ORDER BY id DESC");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>📊 Comparison Tables</h2>
    <a href="add-comparison.php" class="admin-btn btn-primary"><i class="fas fa-plus"></i> Create New Table</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Products</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($q)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td style="font-weight:600;"><?= htmlspecialchars($row['title']); ?></td>
          <td>
            <div style="font-size:12px; color:var(--text-muted);">
              1. ID:<?= $row['p1_id']; ?><br>
              2. ID:<?= $row['p2_id']; ?><br>
              3. ID:<?= $row['p3_id']; ?>
            </div>
          </td>
          <td>
            <span class="badge <?= $row['status']=='active'?'badge-success':'badge-danger' ?>">
              <?= ucfirst($row['status']); ?>
            </span>
          </td>
          <td>
            <div style="display:flex; gap:10px;">
               <a href="toggle-status.php?id=<?= $row['id']; ?>&table=comparison_tables" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;">
                <i class="fas fa-power-off"></i>
              </a>
              <a href="edit-comparison.php?id=<?= $row['id']; ?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-comparison.php?id=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;" onclick="return confirm('Delete this table?')">
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
