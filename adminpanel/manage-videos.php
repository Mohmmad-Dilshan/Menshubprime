<?php
// Bulletproof forced output buffering
ob_start();

// Ensure DB and Session are initialized silently
include_once '../config/db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

/**
 * ------------------------------------------------------------------
 * LOGIC PROCESSING - NO OUTPUT BEFORE THIS
 * ------------------------------------------------------------------
 */
if(isset($_GET['delete']) || isset($_GET['status'])){
  
  if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM videos WHERE id='$id'");
  }
  
  if(isset($_GET['status'])){
    $id = intval($_GET['status']);

    // Strictly fetch and toggle ONLY this record
    $q = mysqli_query($conn, "SELECT status FROM videos WHERE id='$id'");
    if($row = mysqli_fetch_assoc($q)){
        // If current status is 1, set to 0. Otherwise set to 1.
        $newStatus = ($row['status'] == 1) ? 0 : 1;
        mysqli_query($conn, "UPDATE videos SET status='$newStatus' WHERE id='$id'");
    }
  }
  
  // Use JS Redirect to bypass ALL possible header issues
  echo "<script>window.location.replace('manage-videos.php?upd=".time()."');</script>";
  exit();
}

/**
 * ------------------------------------------------------------------
 * UI RENDERING - HEADER ALLOWED HERE
 * ------------------------------------------------------------------
 */
$page_title = "Manage Video Reviews";
include 'admin_header.php';
include_once '../helpers/functions.php';

/* PAGINATION */
$limit = 10;
$page  = isset($_GET['page']) ? max(1,intval($_GET['page'])) : 1;
$start = ($page-1) * $limit;

/* TOTAL ROWS */
$totalRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) as total FROM videos"));
$total = $totalRow['total'];
$pages = ceil($total / $limit);

/* FETCH VIDEOS */
$videos = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC LIMIT $start,$limit");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>📹 Video Reviews List</h2>
    <a href="add-video.php" class="admin-btn btn-primary"><i class="fas fa-plus"></i> Add New Review</a>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Preview</th>
          <th>Details</th>
          <th>Rating</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($videos)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td>
            <div style="position:relative; width:120px; height:70px; border-radius:10px; overflow:hidden;">
              <img src="../uploads/thumbs/<?= $row['thumb']; ?>" style="width:100%; height:100%; object-fit:cover;">
              <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,0.3);">
                <i class="fas fa-play" style="color:white; font-size:20px;"></i>
              </div>
            </div>
          </td>
          <td>
            <div style="font-weight:600; font-size:15px;"><?= htmlspecialchars($row['title']); ?></div>
            <div style="color:var(--text-muted); font-size:12px; margin-top:4px;">
              <i class="fas fa-link"></i> <?= (strpos($row['video_link'],'http')===0) ? 'External Link' : 'Local MP4'; ?>
            </div>
          </td>
          <td>
            <div style="color:#fbce03; font-weight:700;">
              <i class="fas fa-star"></i> <?= $row['star_rating']; ?>
            </div>
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
              <a href="?status=<?= $row['id']; ?>" class="admin-btn" style="padding:6px 12px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Status">
                <i class="fas fa-power-off"></i>
              </a>
              <a href="edit-video.php?id=<?= $row['id']; ?>" class="admin-btn btn-primary" style="padding:6px 12px; font-size:12px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="?delete=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:6px 12px; font-size:12px;" onclick="return confirm('Delete this video?')">
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
    <a href="?page=<?= $i; ?>" class="admin-btn <?= ($i==$page)?'btn-primary':''; ?>" style="padding:8px 14px; min-width:40px; justify-content:center;">
      <?= $i; ?>
    </a>
    <?php } ?>
  </div>
  <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>