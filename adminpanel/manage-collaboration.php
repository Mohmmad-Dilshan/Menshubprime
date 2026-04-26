<?php
session_start();
$page_title = "Brand Collaboration Requests";
include 'admin_header.php';

/* DELETE */
if(isset($_GET['delete'])){
  $id = intval($_GET['delete']);
  mysqli_query($conn,"DELETE FROM collaborations WHERE id=$id");
  echo "<script>window.location='manage-collaboration.php';</script>";
}

/* PAGINATION */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page-1) * $limit;

$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id) as total FROM collaborations"))['total'];
$pages = ceil($total / $limit);

$q = mysqli_query($conn,"SELECT * FROM collaborations ORDER BY id DESC LIMIT $start, $limit");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>🤝 Partnership & Collaboration Leads</h2>
    <span class="badge" style="background:rgba(34, 197, 94, 0.1); color:#22c55e; font-size:14px;">
      Total: <?= $total; ?> Requests
    </span>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Brand & Spokesperson</th>
          <th>Contact Info</th>
          <th>Lead Details</th>
          <th>Timestamp</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($q)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td>
            <div style="font-weight:700; color:var(--primary);"><?= htmlspecialchars($row['brand_name']); ?></div>
            <div style="font-size:12px; color:var(--text-muted);"><i class="fas fa-user"></i> <?= htmlspecialchars($row['your_name']); ?></div>
          </td>
          <td>
            <div style="font-size:13px;"><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']); ?></div>
            <?php if(!empty($row['product_link'])): ?>
            <div style="font-size:11px; margin-top:4px;">
              <a href="<?= htmlspecialchars($row['product_link']); ?>" target="_blank" style="color:var(--primary); text-decoration:none;">
                <i class="fas fa-external-link-alt"></i> View Product
              </a>
            </div>
            <?php endif; ?>
          </td>
          <td>
            <div style="max-width:300px; font-size:12px; line-height:1.5; background:rgba(255,255,255,0.03); padding:10px; border-radius:8px; border:1px solid var(--glass-border);">
              <?= nl2br(htmlspecialchars($row['message'])); ?>
            </div>
          </td>
          <td style="white-space:nowrap; font-size:12px; color:var(--text-muted);">
            <?= date('M d, Y', strtotime($row['created_at'])); ?><br>
            <small><?= date('h:i A', strtotime($row['created_at'])); ?></small>
          </td>
          <td style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="mailto:<?= htmlspecialchars($row['email']); ?>?subject=Re: Collaboration Request – <?= urlencode($row['brand_name']); ?> x MenHub Prime&body=Hi <?= urlencode($row['your_name']); ?>,%0A%0AThank you for your collaboration request! We are excited to explore this opportunity with you.%0A%0A" class="admin-btn btn-primary" style="padding:8px 12px; font-size:12px; background:#2563eb;" title="Reply via Email">
              <i class="fas fa-reply"></i> Reply
            </a>
            <a href="?delete=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:8px 12px; font-size:12px;" onclick="return confirm('Archive this collaboration request?')">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php if($pages > 1): ?>
  <div style="display:flex; justify-content:center; gap:10px; margin-top:30px;">
    <?php for($i=1;$i<=$pages;$i++){ ?>
    <a href="?page=<?= $i ?>" class="admin-btn <?= ($i==$page)?'btn-primary':''; ?>" style="padding:8px 14px; min-width:40px; justify-content:center;">
      <?= $i ?>
    </a>
    <?php } ?>
  </div>
  <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>