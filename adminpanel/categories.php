<?php
include '../config/db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

/* ADD CATEGORY */
if(isset($_POST['add'])){
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $slug = strtolower(str_replace(" ","-",$name));
  $img = $_FILES['image']['name'];
  $newname = time()."_".$img;
  move_uploaded_file($_FILES['image']['tmp_name'],"../assets/images/".$newname);
  $status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'active');
  mysqli_query($conn,"INSERT INTO categories(name,slug,image,status) VALUES('$name','$slug','$newname','$status')");
  echo "<script>window.location='categories.php?u=".time()."';</script>";
  exit();
}

/* DELETE */
if(isset($_GET['del'])){
  $id = (int)$_GET['del'];
  $q = mysqli_query($conn,"SELECT image FROM categories WHERE id=$id");
  $r = mysqli_fetch_assoc($q);
  if($r && !empty($r['image'])) @unlink("../assets/images/".$r['image']);
  mysqli_query($conn,"DELETE FROM categories WHERE id=$id");
  echo "<script>window.location='categories.php?u=".time()."';</script>";
  exit();
}

/* UPDATE */
if(isset($_POST['update'])){
  $id = (int)$_POST['id'];
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $slug = strtolower(str_replace(" ","-",$name));
  if(!empty($_FILES['image']['name'])){
    $newname = time()."_".$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/".$newname);
  } else {
    $q = mysqli_query($conn,"SELECT image FROM categories WHERE id=$id");
    $r = mysqli_fetch_assoc($q);
    $newname = $r['image'];
  }
  $status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'active');
  mysqli_query($conn,"UPDATE categories SET name='$name', slug='$slug', image='$newname', status='$status' WHERE id=$id");
  echo "<script>window.location='categories.php?u=".time()."';</script>";
  exit();
}

$page_title = "Manage Content Categories";
include 'admin_header.php';

/* EDIT FETCH */
$editData = null;
if(isset($_GET['edit'])){
  $eid = (int)$_GET['edit'];
  $e = mysqli_query($conn,"SELECT * FROM categories WHERE id=$eid");
  $editData = mysqli_fetch_assoc($e);
}

/* PAGINATION */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page-1) * $limit;

$total_res = mysqli_query($conn,"SELECT COUNT(id) as total FROM categories");
$totalResult = mysqli_fetch_assoc($total_res);
$total = $totalResult['total'];
$pages = ceil($total / $limit);

/* FETCH ALL WITH LIMIT */
$data = mysqli_query($conn,"SELECT * FROM categories ORDER BY id DESC LIMIT $start, $limit");
?>

<div style="display:grid; grid-template-columns: 300px 1fr; gap:30px; align-items: start;">
  
  <!-- Form Column -->
  <div class="admin-card">
    <h2 style="margin-bottom:20px; font-size:18px;">
      <i class="fas <?= $editData ? 'fa-edit' : 'fa-plus-circle' ?>"></i> 
      <?= $editData ? "Refine Category" : "Establish New Category" ?>
    </h2>
    
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

      <label><i class="fas fa-font"></i> Category Designation</label>
      <input type="text" name="name" value="<?= htmlspecialchars($editData['name'] ?? '') ?>" placeholder="e.g. Premium Grooming" required>

      <label><i class="fas fa-image"></i> Representational Visual</label>
      <?php if($editData): ?>
      <div style="margin-bottom:10px; border-radius:10px; overflow:hidden; border:1px solid var(--glass-border); width:100px; height:60px;">
        <img src="../assets/images/<?= $editData['image'] ?>" style="width:100%; height:100%; object-fit:cover;">
      </div>
      <?php endif; ?>
      <input type="file" name="image" <?= $editData?'':'required' ?>>
      
      <label><i class="fas fa-toggle-on"></i> Catalog Status</label>
      <select name="status">
        <option value="active" <?= ($editData && $editData['status']=='active')?'selected':'' ?>>Visible / Active</option>
        <option value="inactive" <?= ($editData && $editData['status']=='inactive')?'selected':'' ?>>Hidden / Archive</option>
      </select>

      <div style="margin-top:25px; display:flex; gap:10px;">
        <button type="submit" name="<?= $editData ? 'update' : 'add' ?>" class="admin-btn btn-primary" style="flex:1;">
          <i class="fas <?= $editData ? 'fa-save' : 'fa-plus' ?>"></i> 
          <?= $editData ? 'Sync Changes' : 'Initialize' ?>
        </button>
        <?php if($editData): ?>
        <a href="categories.php" class="admin-btn btn-danger" style="text-align:center;">Cancel</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Table Column -->
  <div class="admin-card" style="min-width:0;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
      <h2><i class="fas fa-th-large"></i> Taxonomy Registry</h2>
      <span class="badge" style="background:rgba(37, 99, 235, 0.1); color:var(--primary);"><?= $total ?> Categories</span>
    </div>

    <div class="admin-table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Visual</th>
            <th>Designation</th>
            <th>Identifier (Slug)</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($data)){ ?>
          <tr>
            <td>#<?= $row['id'] ?></td>
            <td>
              <div style="width:50px; height:50px; border-radius:8px; overflow:hidden; border:1px solid var(--glass-border); margin:0 auto;">
                <img src="../assets/images/<?= $row['image'] ?>" style="width:100%; height:100%; object-fit:cover;">
              </div>
            </td>
            <td style="font-weight:600;"><?= htmlspecialchars($row['name']) ?></td>
            <td><code style="background:rgba(255,255,255,0.05); padding:4px 8px; border-radius:4px; font-size:11px;"><?= $row['slug'] ?></code></td>
            <td>
              <?php if($row['status'] == 'active'): ?>
                <span class="badge badge-success">Active</span>
              <?php else: ?>
                <span class="badge badge-warning">Inactive</span>
              <?php endif; ?>
            </td>
            <td>
              <div style="display:flex; gap:8px; justify-content:center;">
                <a href="toggle-status.php?id=<?= $row['id']; ?>&table=categories" class="admin-btn" style="padding:6px 10px; font-size:12px; background:rgba(255,255,255,0.05); color:white;" title="Toggle Status">
                  <i class="fas fa-power-off"></i>
                </a>
                <a href="?edit=<?= $row['id'] ?>" class="admin-btn btn-primary" style="padding:6px 10px; font-size:12px;">
                  <i class="fas fa-pen-nib"></i>
                </a>
                <a href="?del=<?= $row['id'] ?>" class="admin-btn btn-danger" style="padding:6px 10px; font-size:12px;" onclick="return confirm('Eradicate this category?')">
                  <i class="fas fa-trash-alt"></i>
                </a>
              </div>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <?php if($pages > 1): ?>
    <div style="display:flex; justify-content:center; gap:8px; margin-top:25px;">
      <?php for($i=1;$i<=$pages;$i++){ ?>
      <a href="categories.php?page=<?= $i; ?>" class="admin-btn <?= ($i==$page)?'btn-primary':''; ?>" style="padding:6px 12px; min-width:35px; justify-content:center;">
        <?= $i; ?>
      </a>
      <?php } ?>
    </div>
    <?php endif; ?>
  </div>

</div>

<?php include 'admin_footer.php'; ?>