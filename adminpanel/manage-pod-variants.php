<?php
session_start();
$page_title = "Manage POD Product Variants";
include 'admin_header.php';

$q = mysqli_query($conn,"
  SELECT v.*, p.title 
  FROM pod_variants v 
  JOIN pod_products p ON v.product_id = p.id
  ORDER BY v.id DESC
");
$total = mysqli_num_rows($q);
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <h2>💎 Print-on-Demand (POD) Variants</h2>
    <span class="badge" style="background:rgba(37, 99, 235, 0.1); color:var(--primary);">Total: <?= $total ?> variants</span>
  </div>

  <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:20px;">
    <?php while($v = mysqli_fetch_assoc($q)){ ?>
    <div style="background:rgba(255,255,255,0.03); border:1px solid var(--glass-border); border-radius:16px; padding:20px; transition:0.3s; position:relative; overflow:hidden;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
      
      <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:15px;">
        <div style="flex:1;">
          <h3 style="font-size:16px; margin-bottom:4px; color:var(--primary); font-weight:700;"><?= htmlspecialchars($v['title']); ?></h3>
          <code style="font-size:11px; background:rgba(255,255,255,0.05); padding:2px 6px; border-radius:4px; color:var(--text-muted);"><?= $v['sku']; ?></code>
        </div>
        <div style="font-size:18px; font-weight:800; color:#22c55e;">₹<?= $v['price']; ?></div>
      </div>

      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-bottom:20px; background:rgba(0,0,0,0.2); padding:10px; border-radius:10px;">
        <div style="text-align:center;">
          <small style="display:block; color:var(--text-muted); font-size:10px; text-transform:uppercase;">Size</small>
          <span style="font-weight:600; font-size:14px;"><?= $v['size']; ?></span>
        </div>
        <div style="text-align:center; border-left:1px solid var(--glass-border);">
          <small style="display:block; color:var(--text-muted); font-size:10px; text-transform:uppercase;">Color</small>
          <span style="font-weight:600; font-size:14px;"><?= $v['color']; ?></span>
        </div>
      </div>

      <div style="display:flex; gap:10px;">
        <a href="edit-pod-variant.php?id=<?= $v['id']; ?>" class="admin-btn btn-primary" style="flex:1; justify-content:center; font-size:12px; padding:8px;">
          <i class="fas fa-edit"></i> Edit
        </a>
        <a href="delete-pod-variant.php?id=<?= $v['id']; ?>" class="admin-btn btn-danger" style="flex:1; justify-content:center; font-size:12px; padding:8px;" onclick="return confirm('Delete this variant?')">
          <i class="fas fa-trash-alt"></i> Delete
        </a>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<?php include 'admin_footer.php'; ?>