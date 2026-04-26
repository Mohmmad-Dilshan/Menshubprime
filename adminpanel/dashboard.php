<?php
session_start();
$page_title = "Admin Dashboard";
include 'admin_header.php';

/* COUNTS */
$p = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM products"));
$b = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM blogs"));
$c = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM categories"));
$m = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM messages"));
$v = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM videos"));
$d = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM digital_products"));
$mini = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM mini_products"));
$col = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM collaborations"));
$subs = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM subscribers"));
$app_subs = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM app_subscribers"));
$hire = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM hire_requests"));
$v_hits = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(hit_count) as total FROM visitor_stats"))['total'] ?? 0;

/* DATA FOR GRAPHS (Last 7 Days) */
$labels = [];
$sales_data = [];
$leads_data = [];
$visitor_data = [];

for($i=6; $i>=0; $i--){
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('D, d M', strtotime($date));

    // Sales
    $q_sales = mysqli_query($conn, "SELECT 
        (SELECT COUNT(*) FROM digital_orders WHERE DATE(created_at) = '$date') + 
        (SELECT COUNT(*) FROM pod_orders WHERE DATE(created_at) = '$date') as total");
    $sales_data[] = mysqli_fetch_assoc($q_sales)['total'];

    // Leads
    $q_leads = mysqli_query($conn, "SELECT 
        (SELECT COUNT(*) FROM messages WHERE DATE(date) = '$date') + 
        (SELECT COUNT(*) FROM collaborations WHERE DATE(created_at) = '$date') as total");
    $leads_data[] = mysqli_fetch_assoc($q_leads)['total'];

    // Visitors
    $q_visitors = mysqli_query($conn, "SELECT hit_count FROM visitor_stats WHERE visit_date = '$date'");
    $visitor_data[] = mysqli_fetch_assoc($q_visitors)['hit_count'] ?? 0;
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="stats-grid">

  <div class="stat-box">
    <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
    <div class="stat-info">
      <h3>Products</h3>
      <p><?= $p ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#6366f1; background:rgba(99,102,241,0.1);"><i class="fas fa-box-open"></i></div>
    <div class="stat-info">
      <h3>Mini Products</h3>
      <p><?= $mini ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#10b981; background:rgba(16,185,129,0.1);"><i class="fas fa-newspaper"></i></div>
    <div class="stat-info">
      <h3>Blogs</h3>
      <p><?= $b ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#3b82f6; background:rgba(59,130,246,0.1);"><i class="fas fa-tags"></i></div>
    <div class="stat-info">
      <h3>Categories</h3>
      <p><?= $c ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#f59e0b; background:rgba(245,158,11,0.1);"><i class="fas fa-video"></i></div>
    <div class="stat-info">
      <h3>Video Reviews</h3>
      <p><?= $v ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#8b5cf6; background:rgba(139,92,246,0.1);"><i class="fas fa-download"></i></div>
    <div class="stat-info">
      <h3>Digital Products</h3>
      <p><?= $d ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#ec4899; background:rgba(236,72,153,0.1);"><i class="fas fa-envelope"></i></div>
    <div class="stat-info">
      <h3>Messages</h3>
      <p><?= $m ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#06b6d4; background:rgba(6,182,212,0.1);"><i class="fas fa-handshake"></i></div>
    <div class="stat-info">
      <h3>Collabs</h3>
      <p><?= $col ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#f59e0b; background:rgba(245,158,11,0.1);"><i class="fas fa-eye"></i></div>
    <div class="stat-info">
      <h3>Total Visits</h3>
      <p><?= number_format($v_hits) ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#22c55e; background:rgba(34,197,94,0.1);"><i class="fas fa-paper-plane"></i></div>
    <div class="stat-info">
      <h3>Subscribers</h3>
      <p><?= $subs ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#a855f7; background:rgba(168,85,247,0.1);"><i class="fas fa-mobile-alt"></i></div>
    <div class="stat-info">
      <h3>App Waitlist</h3>
      <p><?= $app_subs ?></p>
    </div>
  </div>

  <div class="stat-box">
    <div class="stat-icon" style="color:#f97316; background:rgba(249,115,22,0.1);"><i class="fas fa-briefcase"></i></div>
    <div class="stat-info">
      <h3>Hire Leads</h3>
      <p><?= $hire ?></p>
    </div>
  </div>

</div>

<!-- Analytics Row -->
<div style="display:grid; grid-template-columns: 1.5fr 1fr; gap:30px; margin-top:30px;">
  
  <div class="admin-card" style="margin-bottom:0;">
    <h2>📈 Platform Growth (7 Days)</h2>
    <div style="height:300px; margin-top:20px;">
      <canvas id="growthChart"></canvas>
    </div>
  </div>

  <div class="admin-card" style="margin-bottom:0;">
    <h2>⚡ Recent Leads</h2>
    <div style="margin-top:20px;">
      <?php
      $recent = mysqli_query($conn,"(SELECT 'Message' as type, name, date as created_at FROM messages) 
                UNION (SELECT 'Collab' as type, your_name as name, created_at FROM collaborations)
                ORDER BY created_at DESC LIMIT 5");
      while($r=mysqli_fetch_assoc($recent)){
      ?>
      <div style="display:flex; align-items:center; gap:15px; padding:12px 0; border-bottom:1px solid var(--glass-border);">
        <div style="width:10px; height:10px; border-radius:50%; background:<?= $r['type']=='Message'?'#ec4899':'#06b6d4' ?>"></div>
        <div style="flex-grow:1;">
          <p style="font-weight:600; font-size:14px;"><?= htmlspecialchars($r['name']) ?></p>
          <p style="font-size:12px; color:var(--text-muted);"><?= $r['type'] ?> • <?= date('d M, h:i A', strtotime($r['created_at'])) ?></p>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>

</div>


<div class="admin-card">
  <h2>🚀 Quick Actions</h2>
  <div style="display:flex; gap:15px; margin-top:20px; flex-wrap:wrap;">
    <a href="add-product.php" class="admin-btn btn-primary"><i class="fas fa-plus"></i> New Product</a>
    <a href="add-mini.php" class="admin-btn btn-primary" style="background:#6366f1;"><i class="fas fa-box"></i> New Mini Product</a>
    <a href="add-blog.php" class="admin-btn btn-primary" style="background:#10b981;"><i class="fas fa-pen"></i> New Blog</a>
    <a href="add-digital-products.php" class="admin-btn btn-primary" style="background:#8b5cf6;"><i class="fas fa-cloud-upload-alt"></i> New Digital Product</a>
    <a href="add-video.php" class="admin-btn btn-primary" style="background:#f59e0b;"><i class="fas fa-video"></i> New Video Review</a>
  </div>
</div>

<script>
const ctx = document.getElementById('growthChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [
      {
        label: 'Visitors',
        data: <?= json_encode($visitor_data) ?>,
        borderColor: '#f59e0b',
        backgroundColor: 'rgba(245,158,11,0.1)',
        fill: true,
        tension: 0.4
      },
      {
        label: 'Leads',
        data: <?= json_encode($leads_data) ?>,
        borderColor: '#06b6d4',
        backgroundColor: 'transparent',
        tension: 0.4
      },
      {
        label: 'Sales',
        data: <?= json_encode($sales_data) ?>,
        borderColor: '#10b981',
        backgroundColor: 'transparent',
        tension: 0.4
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        labels: { color: '#e0e0e0', font: { family: 'Inter' } }
      }
    },
    scales: {
      y: {
        ticks: { color: '#a0a0a0' },
        grid: { color: 'rgba(255,255,255,0.05)' }
      },
      x: {
        ticks: { color: '#a0a0a0' },
        grid: { display: false }
      }
    }
  }
});
</script>

<?php include 'admin_footer.php'; ?>