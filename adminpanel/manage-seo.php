<?php
session_start();
$page_title = "Search Engine Optimization (SEO) Console";
include 'admin_header.php';

/* DELETE */
if(isset($_GET['delete'])){
  $id = mysqli_real_escape_string($conn, $_GET['delete']);
  mysqli_query($conn,"DELETE FROM seo_pages WHERE id='$id'");
  echo "<script>window.location='manage-seo.php';</script>";
}

/* ADD / UPDATE */
if(isset($_POST['save'])){
  $page = mysqli_real_escape_string($conn, $_POST['page_name']);
  $title = mysqli_real_escape_string($conn, $_POST['meta_title']);
  $description = mysqli_real_escape_string($conn, $_POST['meta_description']);
  $keywords = mysqli_real_escape_string($conn, $_POST['meta_keywords']);

  if($_POST['id']==""){
    mysqli_query($conn,"INSERT INTO seo_pages(page_name,meta_title,meta_description,meta_keywords) VALUES('$page','$title','$description','$keywords')");
  }else{
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    mysqli_query($conn,"UPDATE seo_pages SET page_name='$page', meta_title='$title', meta_description='$description', meta_keywords='$keywords' WHERE id='$id'");
  }

  echo "<script>window.location='manage-seo.php';</script>";
}

/* EDIT FETCH */
$edit = null;
if(isset($_GET['edit'])){
  $eid = mysqli_real_escape_string($conn, $_GET['edit']);
  $edit = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM seo_pages WHERE id='$eid'"));
}

$data = mysqli_query($conn,"SELECT * FROM seo_pages ORDER BY id DESC");
$total = mysqli_num_rows($data);
?>

<div style="display:grid; grid-template-columns: 400px 1fr; gap:30px; align-items: start;">
  
  <!-- Form Column -->
  <div class="admin-card">
    <h2 style="margin-bottom:20px; font-size:18px;">
      <i class="fas <?= $edit ? 'fa-pen-fancy' : 'fa-search-plus' ?>"></i> 
      <?= $edit ? "Refine Meta Metadata" : "Configure Page SEO" ?>
    </h2>
    
    <form method="post" class="admin-form">
      <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

      <label><i class="fas fa-file-code"></i> Page File Reference</label>
      <input type="text" name="page_name" placeholder="e.g. index.php or blogs.php" value="<?= htmlspecialchars($edit['page_name'] ?? '') ?>" required>

      <label><i class="fas fa-heading"></i> Primary Meta Title</label>
      <input type="text" name="meta_title" placeholder="Crucial SEO Heading" value="<?= htmlspecialchars($edit['meta_title'] ?? '') ?>" required>

      <label><i class="fas fa-align-left"></i> Summary Metadata (Description)</label>
      <textarea name="meta_description" placeholder="Compelling snippet for search results..." required style="min-height:100px;"><?= htmlspecialchars($edit['meta_description'] ?? '') ?></textarea>

      <label><i class="fas fa-tags"></i> Taxonomic Keywords</label>
      <textarea name="meta_keywords" placeholder="Keyword 1, Keyword 2, Keyword 3..." required style="min-height:80px;"><?= htmlspecialchars($edit['meta_keywords'] ?? '') ?></textarea>

      <div style="margin-top:25px; display:flex; gap:10px;">
        <button type="submit" name="save" class="admin-btn btn-primary" style="flex:1; justify-content:center;">
          <i class="fas <?= $edit ? 'fa-sync' : 'fa-save' ?>"></i> 
          <?= $edit ? 'Apply Updates' : 'Commit Configuration' ?>
        </button>
        <?php if($edit): ?>
        <a href="manage-seo.php" class="admin-btn btn-danger" style="text-align:center;">Abort</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Table Column -->
  <div class="admin-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
      <h2><i class="fas fa-globe"></i> SEO Strategy Registry</h2>
      <span class="badge" style="background:rgba(245, 158, 11, 0.1); color:#f59e0b;"><?= $total ?> Indexed Routes</span>
    </div>

    <div class="admin-table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Page Route</th>
            <th>Search Title</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($data)){ ?>
          <tr>
            <td>#<?= $row['id'] ?></td>
            <td style="font-weight:600; color:var(--primary);"><i class="fas fa-link" style="font-size:10px; opacity:0.5;"></i> <?= htmlspecialchars($row['page_name']) ?></td>
            <td style="font-size:13px; color:var(--text-muted); max-width:250px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
              <?= htmlspecialchars($row['meta_title']) ?>
            </td>
            <td>
              <div style="display:flex; gap:8px; justify-content:center;">
                <a href="?edit=<?= $row['id'] ?>" class="admin-btn btn-primary" style="padding:6px 10px; font-size:12px;">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="?delete=<?= $row['id'] ?>" class="admin-btn btn-danger" style="padding:6px 10px; font-size:12px;" onclick="return confirm('Eradicate SEO configuration for this page?')">
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

</div>

<?php include 'admin_footer.php'; ?>