<?php
session_start();
$page_title = "Manage Promotional Banners";
include 'admin_header.php';

/* DELETE LOGIC */
if(isset($_GET['delete'])){
  $id = intval($_GET['delete']);
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT banner_image FROM promotional_offers WHERE id='$id'"));
  if($r && file_exists("../uploads/".$r['banner_image'])) @unlink("../uploads/".$r['banner_image']);
  mysqli_query($conn, "DELETE FROM promotional_offers WHERE id='$id'");
  header("Location: promotional-offers.php?msg=deleted&t=".time());
  exit();
}

$q = mysqli_query($conn, "SELECT * FROM promotional_offers ORDER BY id DESC");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <div>
      <h2 style="color:var(--text-main); margin:0;"><i class="fas fa-gift"></i> Promotional Offers</h2>
      <p style="color:var(--text-muted); font-size:13px; margin-top:5px;">Banners shown across the homepage & category landing pages</p>
    </div>
    <a href="add-offer.php" class="admin-btn btn-primary"><i class="fas fa-plus-circle"></i> Create New Offer</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>Visual</th>
          <th>Headline & Details</th>
          <th>CTA Button</th>
          <th>Current Status</th>
          <th>Actions Control</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($q)){ ?>
        <tr>
          <td>
            <div style="width:120px; height:60px; border-radius:12px; overflow:hidden; border:1px solid var(--glass-border); background:rgba(255,255,255,0.03);">
              <img src="../uploads/<?=$row['banner_image'];?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy">
            </div>
          </td>
          <td>
            <div style="font-weight:700; color:#fff; font-size:15px;"><?= htmlspecialchars($row['title']); ?></div>
            <div style="color:var(--text-muted); font-size:12px; margin-top:4px;"><?= htmlspecialchars($row['subtitle']); ?></div>
          </td>
          <td>
            <span class="badge" style="background:rgba(99, 102, 241, 0.1); color:var(--primary); font-size:11px; border:1px solid rgba(99, 102, 241, 0.2);">
              <i class="fas fa-mouse-pointer"></i> <?= htmlspecialchars($row['button_text']); ?>
            </span>
          </td>
          <td>
            <?php if($row['status'] == 1): ?>
              <span class="badge badge-success">Active</span>
            <?php else: ?>
              <span class="badge badge-warning">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <div style="display:flex; gap:10px;">
              <a href="toggle-offer.php?id=<?=$row['id'];?>" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Visibility">
                <i class="fas fa-power-off"></i>
              </a>
              <a href="edit-offer.php?id=<?=$row['id'];?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="?delete=<?=$row['id'];?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;" onclick="return confirm('Eradicate this promotional offer?')">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </td>
        </tr>
        <?php } ?>
        <?php if(mysqli_num_rows($q)==0): ?>
        <tr>
          <td colspan="5" style="text-align:center; padding:50px; color:var(--text-muted);">
            <i class="fas fa-gift" style="font-size:40px; margin-bottom:15px; display:block; opacity:0.2;"></i>
            No active promotional offers found.
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
