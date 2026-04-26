<?php
// admin_header.php
if(!isset($_SESSION['admin_id'])){
  header("Location: login.php");
  exit();
}
// Prevent caching for real-time admin updates
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../config/db.php';

// Get current page for active link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?? 'Admin Dashboard'; ?> | MenHub Prime</title>
  
  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Main Admin CSS -->
  <link rel="stylesheet" href="modern-admin.css?v=<?= time(); ?>">
  <style>
    /* Sidebar Logic */
    .sidebar-footer { margin-top: auto; padding-top: 20px; border-top: 1px solid var(--glass-border); }
    .has-submenu { position: relative; }
    .submenu { list-style: none; padding-left: 45px; margin-top: 5px; display: none; }
    .has-submenu.open .submenu { display: block; }
    .submenu li a { padding: 8px 0; font-size: 13px; color: var(--text-muted); display: block; transition: 0.3s; }
    .submenu li a:hover, .submenu li a.active { color: #f97316; }
    
    /* Top Profile Greeting */
    .admin-profile-top {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 15px;
      color: #94a3b8;
    }
    .admin-profile-top strong { color: #f97316; }
    .status-pulse {
      width: 10px; height: 10px;
      background: #22c55e;
      border-radius: 50%;
      box-shadow: 0 0 10px #22c55e;
      position: relative;
    }
    .status-pulse::after {
      content: "";
      position: absolute;
      inset: -4px;
      border-radius: 50%;
      border: 2px solid #22c55e;
      animation: pulse 1.5s infinite;
      opacity: 0;
    }
    @keyframes pulse {
      0% { transform: scale(1); opacity: 0.5; }
      100% { transform: scale(1.8); opacity: 0; }
    }
  </style>
</head>
<body>

<aside class="admin-sidebar">
  <h2>MensHub <span style="color:var(--text-main);">Prime</span></h2>
  
  <ul class="nav-links">
    <li><a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : ''; ?>">
      <i class="fas fa-chart-line"></i> <span>Dashboard</span>
    </a></li>

    <li class="nav-section">Commerce & Sales</li>
    <li><a href="manage-stores.php" class="<?= ($current_page == 'manage-stores.php' || $current_page == 'add-store.php') ? 'active' : ''; ?>">
      <i class="fas fa-store"></i> <span>Affiliate Stores</span>
    </a></li>
    <li><a href="products.php" class="<?= ($current_page == 'products.php' || $current_page == 'add-product.php') ? 'active' : ''; ?>">
      <i class="fas fa-shopping-bag"></i> <span>Main Products</span>
    </a></li>
    <li><a href="mini-products.php" class="<?= ($current_page == 'mini-products.php' || $current_page == 'add-mini.php') ? 'active' : ''; ?>">
      <i class="fas fa-box-open"></i> <span>Mini Products</span>
    </a></li>
    <li><a href="manage-digital-products.php" class="<?= $current_page == 'manage-digital-products.php' ? 'active' : ''; ?>">
      <i class="fas fa-download"></i> <span>Digital Products</span>
    </a></li>
    <li><a href="deals.php" class="<?= $current_page == 'deals.php' ? 'active' : ''; ?>">
      <i class="fas fa-bolt"></i> <span>Daily Deals</span>
    </a></li>

    <li class="nav-section">Content Hub</li>
    <li><a href="manage-videos.php" class="<?= $current_page == 'manage-videos.php' ? 'active' : ''; ?>">
      <i class="fas fa-video"></i> <span>Video Reviews</span>
    </a></li>
    <li><a href="blogs.php" class="<?= $current_page == 'blogs.php' ? 'active' : ''; ?>">
      <i class="fas fa-newspaper"></i> <span>Style Blogs</span>
    </a></li>
    <li><a href="comparisons.php" class="<?= $current_page == 'comparisons.php' ? 'active' : ''; ?>">
      <i class="fas fa-columns"></i> <span>Comparison Tables</span>
    </a></li>
    <li><a href="categories.php" class="<?= $current_page == 'categories.php' ? 'active' : ''; ?>">
      <i class="fas fa-tags"></i> <span>Categories</span>
    </a></li>

    <li class="nav-section">Marketing & Users</li>
    <li><a href="ai-creative-hub.php" class="<?= $current_page == 'ai-creative-hub.php' ? 'active' : ''; ?>">
      <i class="fas fa-wand-magic-sparkles"></i> <span>AI Creative Hub</span>
    </a></li>
    <li><a href="promotional-offers.php" class="<?= $current_page == 'promotional-offers.php' ? 'active' : ''; ?>">
      <i class="fas fa-gift"></i> <span>Promocodes</span>
    </a></li>
    <li><a href="mobile-banners.php" class="<?= ($current_page == 'mobile-banners.php' || $current_page == 'add-mobile-banner.php') ? 'active' : ''; ?>">
      <i class="fas fa-images"></i> <span>Mobile Banners</span>
    </a></li>
    <li><a href="hero-popup.php" class="<?= $current_page == 'hero-popup.php' ? 'active' : ''; ?>">
      <i class="fas fa-bell"></i> <span>Hero Popup</span>
    </a></li>
    <li><a href="subscribers.php" class="<?= $current_page == 'subscribers.php' ? 'active' : ''; ?>">
      <i class="fas fa-paper-plane"></i> <span>Mailing List</span>
    </a></li>
    <li><a href="sponsors.php" class="<?= $current_page == 'sponsors.php' ? 'active' : ''; ?>">
      <i class="fas fa-handshake"></i> <span>Partner Brands</span>
    </a></li>

    <li class="nav-section">Lead Intelligence</li>
    <li><a href="manage-hire.php" class="<?= $current_page == 'manage-hire.php' ? 'active' : ''; ?>">
      <i class="fas fa-user-tie"></i> <span>Hire Inquiries</span>
    </a></li>
    <li><a href="manage-collaboration.php" class="<?= $current_page == 'manage-collaboration.php' ? 'active' : ''; ?>">
      <i class="fas fa-handshake"></i> <span>Brand Collabs</span>
    </a></li>
    <li><a href="manage-app-subscribers.php" class="<?= $current_page == 'manage-app-subscribers.php' ? 'active' : ''; ?>">
      <i class="fas fa-mobile-alt"></i> <span>App Leads</span>
    </a></li>

    <li class="nav-section">System Control</li>
    <li><a href="site-audit.php" class="<?= $current_page == 'site-audit.php' ? 'active' : ''; ?>">
      <i class="fas fa-brain"></i> <span>Site Intelligence</span>
    </a></li>
    <li><a href="traffic-intelligence.php" class="<?= $current_page == 'traffic-intelligence.php' ? 'active' : ''; ?>">
      <i class="fas fa-location-arrow"></i> <span>Global Tracking</span>
    </a></li>
    <li><a href="messages.php" class="<?= $current_page == 'messages.php' ? 'active' : ''; ?>">
      <i class="fas fa-envelope"></i> <span>Support Inbox</span>
    </a></li>
    <li><a href="manage-seo.php" class="<?= $current_page == 'manage-seo.php' ? 'active' : ''; ?>">
      <i class="fas fa-search-plus"></i> <span>SEO Engine</span>
    </a></li>
    <li><a href="settings.php" class="<?= $current_page == 'settings.php' ? 'active' : ''; ?>">
      <i class="fas fa-cog"></i> <span>Global Settings</span>
    </a></li>
  </ul>

  <div class="sidebar-footer">
    <a href="profile.php" style="display:flex; align-items:center; gap:10px; text-decoration:none; color:var(--text-main); margin-bottom:15px;">
      <i class="fas fa-user-circle" style="font-size:24px; color:#f97316;"></i>
      <span style="font-size:14px; font-weight:600;">Admin Central</span>
    </a>
    <a href="logout.php" style="color:#ef4444; text-decoration:none; font-size:14px; font-weight:600; display:flex; align-items:center; gap:8px;">
      <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
    </a>
  </div>
</aside>

<main class="admin-main">
  <div class="page-header">
    <h1><?= $page_title ?? 'Dashboard'; ?></h1>
    <div class="admin-profile-top">
      <span>Welcome, <strong>Dilshan</strong></span>
      <div class="status-pulse"></div>
    </div>
  </div>

<!-- Premium Toast Container -->
<div id="toastContainer" class="toast-container"></div>

<script>
  function showToast(title, message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    toast.innerHTML = `
      <div class="toast-icon"><i class="fas ${icon}"></i></div>
      <div class="toast-content">
        <h4>${title}</h4>
        <p>${message}</p>
      </div>
    `;
    
    container.appendChild(toast);
    
    // Trigger animation
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Auto remove
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 500);
    }, 4000);
    
    // Close on click
    toast.onclick = () => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 500);
    };
  }

  // Auto-check for URL-based messages
  window.addEventListener('load', () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('msg') || urlParams.has('updated') || urlParams.has('upd')) {
      const msg = urlParams.get('msg') || 'Update';
      const title = (msg.includes('added')) ? 'Content Created' : 'System Updated';
      const text = (msg.includes('added')) ? 'New record has been successfully published.' : 'Changes have been saved to the database.';
      showToast(title, text, 'success');
    }
  });

  // Simple submenu toggle
  document.querySelectorAll('.has-submenu > a').forEach(item => {
    item.addEventListener('click', function(e) {
      this.parentElement.classList.toggle('open'); 
    });
  });
</script>
</body>
</html>
