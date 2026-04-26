<?php
session_start();
$page_title = "Manage Official Sponsors & Partners";
include 'admin_header.php';

/* DELETE */
if(isset($_GET['del'])){
  $id = mysqli_real_escape_string($conn, $_GET['del']);
  mysqli_query($conn,"DELETE FROM sponsors WHERE id='$id'");
  echo "<script>window.location='sponsors.php';</script>";
}

/* STATUS TOGGLE */
if(isset($_GET['status'])){
  $id = mysqli_real_escape_string($conn, $_GET['id']);
  $status = mysqli_real_escape_string($conn, $_GET['status']);
  mysqli_query($conn,"UPDATE sponsors SET status='$status' WHERE id='$id'");
  echo "<script>window.location='sponsors.php';</script>";
}

/* FETCH SPONSORS */
$q = mysqli_query($conn,"SELECT * FROM sponsors ORDER BY id DESC");
$total = mysqli_num_rows($q);
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>🤝 Strategic Brand Partners</h2>
    <a href="add-sponsor.php" class="admin-btn btn-primary"><i class="fas fa-plus-circle"></i> Add New Partner</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Partner Logo</th>
          <th>Brand Name</th>
          <th>Destination Link</th>
          <th>Placement</th>
          <th>Visibility</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($q)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td>
            <div style="width:100px; height:50px; background:rgba(255,255,255,0.05); border:1px solid var(--glass-border); border-radius:8px; overflow:hidden; padding:5px; margin:0 auto;">
              <img src="../assets/images/<?= $row['image']; ?>" style="width:100%; height:100%; object-fit:contain;">
            </div>
          </td>
          <td style="font-weight:700; color:var(--primary);"><?= htmlspecialchars($row['title']); ?></td>
          <td>
            <div style="max-width:150px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-size:12px;">
              <a href="<?= htmlspecialchars($row['link']); ?>" target="_blank" style="color:var(--text-muted); text-decoration:none;">
                <i class="fas fa-link"></i> <?= htmlspecialchars($row['link']); ?>
              </a>
            </div>
          </td>
          <td>
            <span class="badge" style="background:rgba(37, 99, 235, 0.05); color:var(--primary); font-size:11px;">
              <?= strtoupper($row['position']); ?>
            </span>
          </td>
          <td>
            <?php if($row['status']=="active"): ?>
              <span class="badge badge-success">Active</span>
            <?php else: ?>
              <span class="badge badge-warning">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <div style="display:flex; gap:8px; justify-content:center;">
              <?php $newS = ($row['status'] == 'active') ? 'off' : 'active'; ?>
              <a href="?id=<?= $row['id']; ?>&status=<?= $newS; ?>" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Status">
                <i class="fas fa-power-off"></i>
              </a>
              <a href="edit-sponsor.php?id=<?= $row['id']; ?>" class="admin-btn btn-primary" style="padding:6px 10px; font-size:12px;">
                <i class="fas fa-pen"></i> Edit
              </a>
              <a href="?del=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:6px 10px; font-size:12px;" onclick="return confirm('Delete this brand partner?')">
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