<?php
session_start();
$page_title = "Manage Blog Posts";
include 'admin_header.php';

/* PAGINATION */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page-1) * $limit;

/* TOTAL BLOGS */
$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id) as total FROM blogs"))['total'];
$pages = ceil($total / $limit);

/* FETCH BLOGS */
$result = mysqli_query($conn,"SELECT * FROM blogs ORDER BY id DESC LIMIT $start, $limit");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>📚 Blog Article Management</h2>
    <a href="add-blog.php" class="admin-btn btn-primary"><i class="fas fa-pen"></i> Write New Article</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Feature Image</th>
          <th>Article Title</th>
          <th>Published Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($result)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td>
            <div style="width:80px; height:50px; border-radius:8px; overflow:hidden; border:1px solid var(--glass-border);">
              <img src="../assets/images/<?= $row['image']; ?>" style="width:100%; height:100%; object-fit:cover;">
            </div>
          </td>
          <td style="font-weight:600; max-width:400px;"><?= htmlspecialchars($row['title']); ?></td>
          <td style="color:var(--text-muted); font-size:13px;"><i class="far fa-calendar-alt"></i> <?= $row['date']; ?></td>
          <td>
            <?php if($row['status'] == 'active'): ?>
              <span class="badge" style="background:rgba(16,185,129,0.1); color:#10b981; border:1px solid rgba(16,185,129,0.2);">Active</span>
            <?php else: ?>
              <span class="badge" style="background:rgba(239,68,68,0.1); color:#ef4444; border:1px solid rgba(239,68,68,0.2);">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <div style="display:flex; gap:10px;">
              <a href="toggle-status.php?id=<?= $row['id']; ?>&table=blogs" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Status">
                <i class="fas fa-power-off"></i>
              </a>
              <a href="edit-blog.php?id=<?= $row['id']; ?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="delete-blog.php?id=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;" onclick="return confirm('Delete this blog post?')">
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
    <a href="blogs.php?page=<?= $i; ?>" class="admin-btn <?= ($i==$page)?'btn-primary':''; ?>" style="padding:8px 14px; min-width:40px; justify-content:center;">
      <?= $i; ?>
    </a>
    <?php } ?>
  </div>
  <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>