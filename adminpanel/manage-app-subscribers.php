<?php
session_start();
$page_title = "Manage App User Subscribers";
include 'admin_header.php';

/* FETCH DATA */
$data = mysqli_query($conn,"SELECT * FROM app_subscribers ORDER BY id DESC");
$total = mysqli_num_rows($data);
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>📱 App User Subscriptions</h2>
    <span class="badge" style="background:rgba(16, 185, 129, 0.1); color:#10b981; font-size:14px;">
      Total: <?= $total; ?> Mobile App Users
    </span>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>User Email Address</th>
          <th>Subscription Date</th>
          <th>Platform</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($data)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td style="font-weight:600; color:var(--primary); text-align:left;">
            <i class="fas fa-mobile-alt" style="margin-right:10px; opacity:0.6;"></i>
            <?= htmlspecialchars($row['email']); ?>
          </td>
          <td style="font-size:13px; color:var(--text-muted);">
            <?= date('M d, Y', strtotime($row['created_at'])); ?>
            <div style="font-size:11px; opacity:0.7;"><?= date('h:i A', strtotime($row['created_at'])); ?></div>
          </td>
          <td>
            <span class="badge" style="background:rgba(37, 99, 235, 0.05); color:var(--primary); font-size:11px;">Mobile App</span>
          </td>
          <td style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="mailto:<?= htmlspecialchars($row['email']); ?>?subject=MenHub Prime App – Big News!&body=Hi there,%0A%0AThank you for signing up for the MenHub Prime app waitlist!%0A%0AWe have exciting updates to share with you soon. Stay tuned!%0A%0AVisit us: https://menshubprime.com%0A%0A– Team MenHub Prime" class="admin-btn btn-primary" style="padding:8px 12px; font-size:12px; background:#2563eb;" title="Send Email">
              <i class="fas fa-paper-plane"></i> Mail
            </a>
            <a href="delete-app-subscriber.php?id=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:8px 12px; font-size:12px;" onclick="return confirm('Permanently remove this app subscriber?')">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'admin_footer.php'; ?>