<?php
session_start();
$page_title = "Edit Comparison Table";
include 'admin_header.php';

if(!isset($_GET['id'])){
    header("Location: comparisons.php");
    exit();
}

$id = intval($_GET['id']);
$table_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM comparison_tables WHERE id=$id"));

if(!$table_data){
    die("Table not found");
}

$comp_matrix = json_decode($table_data['comparison_data'], true) ?? [];

if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);
    $p1 = intval($_POST['p1_id']);
    $p1_l = mysqli_real_escape_string($conn, $_POST['p1_label']);
    $p2 = intval($_POST['p2_id']);
    $p2_l = mysqli_real_escape_string($conn, $_POST['p2_label']);
    $p3 = intval($_POST['p3_id']);
    $p3_l = mysqli_real_escape_string($conn, $_POST['p3_label']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Process dynamic features
    $features = $_POST['features'] ?? [];
    $p1_vals = $_POST['p1_vals'] ?? [];
    $p2_vals = $_POST['p2_vals'] ?? [];
    $p3_vals = $_POST['p3_vals'] ?? [];

    $comp_json = [];
    foreach($features as $i => $feat_name){
        if(!empty($feat_name)){
            $comp_json[] = [
                'name' => mysqli_real_escape_string($conn, $feat_name),
                'p1' => mysqli_real_escape_string($conn, $p1_vals[$i] ?? ''),
                'p2' => mysqli_real_escape_string($conn, $p2_vals[$i] ?? ''),
                'p3' => mysqli_real_escape_string($conn, $p3_vals[$i] ?? '')
            ];
        }
    }
    $comparison_data = mysqli_real_escape_string($conn, json_encode($comp_json));

    $q = "UPDATE comparison_tables SET 
            title='$title', 
            category='$cat', 
            p1_id=$p1, 
            p1_label='$p1_l', 
            p2_id=$p2, 
            p2_label='$p2_l', 
            p3_id=$p3, 
            p3_label='$p3_l', 
            comparison_data='$comparison_data', 
            status='$status' 
          WHERE id=$id";
    
    if(mysqli_query($conn, $q)){
        header("Location: comparisons.php?msg=updated");
        exit();
    }
}

// Fetch products for dropdowns
$prods = mysqli_query($conn, "SELECT id, title FROM products WHERE status='active' ORDER BY title ASC");
$all_prods = [];
while($p = mysqli_fetch_assoc($prods)) $all_prods[] = $p;
?>

<div class="admin-card">
  <h2>Edit Comparison Table</h2>

  <form method="POST" class="admin-form">
    <div style="display:grid; grid-template-columns:1.5fr 1fr; gap:25px; margin-bottom:30px;">
      <div>
        <label>Table Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($table_data['title']); ?>" required>
      </div>
      <div>
        <label>Category Reference</label>
        <select name="category">
          <option value="">Select Category</option>
          <?php
          $cats = mysqli_query($conn, "SELECT name, slug FROM categories ORDER BY name ASC");
          while($c = mysqli_fetch_assoc($cats)){
              $sel = ($table_data['category'] == $c['slug']) ? 'selected' : '';
              echo "<option value='".$c['slug']."' $sel>".$c['name']."</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <!-- Product Selection Row -->
    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; margin-bottom:30px;">
      <!-- Product 1 -->
      <div style="padding:15px; background:rgba(99, 102, 241, 0.05); border-radius:12px; border:1px solid rgba(99, 102, 241, 0.2);">
        <h3 style="font-size:14px; color:var(--primary); margin-bottom:15px;"><i class="fas fa-crown"></i> Choice #1</h3>
        <select name="p1_id" required style="margin-bottom:10px;">
          <?php foreach($all_prods as $p){
              $sel = ($table_data['p1_id'] == $p['id']) ? 'selected' : '';
              echo "<option value='".$p['id']."' $sel>#".$p['id']." - ".$p['title']."</option>";
          } ?>
        </select>
        <label>Badge Label</label>
        <input type="text" name="p1_label" value="<?= htmlspecialchars($table_data['p1_label']); ?>">
      </div>

      <!-- Product 2 -->
      <div style="padding:15px; background:rgba(245, 158, 11, 0.05); border-radius:12px; border:1px solid rgba(245, 158, 11, 0.2);">
        <h3 style="font-size:14px; color:var(--accent); margin-bottom:15px;"><i class="fas fa-thumbs-up"></i> Choice #2</h3>
        <select name="p2_id" required style="margin-bottom:10px;">
          <?php foreach($all_prods as $p){
              $sel = ($table_data['p2_id'] == $p['id']) ? 'selected' : '';
              echo "<option value='".$p['id']."' $sel>#".$p['id']." - ".$p['title']."</option>";
          } ?>
        </select>
        <label>Badge Label</label>
        <input type="text" name="p2_label" value="<?= htmlspecialchars($table_data['p2_label']); ?>">
      </div>

      <!-- Product 3 -->
      <div style="padding:15px; background:rgba(168, 85, 247, 0.05); border-radius:12px; border:1px solid rgba(168, 85, 247, 0.2);">
        <h3 style="font-size:14px; color:#a855f7; margin-bottom:15px;"><i class="fas fa-gem"></i> Choice #3</h3>
        <select name="p3_id" required style="margin-bottom:10px;">
          <?php foreach($all_prods as $p){
              $sel = ($table_data['p3_id'] == $p['id']) ? 'selected' : '';
              echo "<option value='".$p['id']."' $sel>#".$p['id']." - ".$p['title']."</option>";
          } ?>
        </select>
        <label>Badge Label</label>
        <input type="text" name="p3_label" value="<?= htmlspecialchars($table_data['p3_label']); ?>">
      </div>
    </div>

    <!-- Comparison Matrix -->
    <div class="matrix-wrap" style="background:rgba(255,255,255,0.02); padding:20px; border-radius:15px; border:1px solid var(--glass-border);">
      <h3 style="margin-bottom:20px; font-size:18px;">🛠 Comparison Matrix</h3>
      <table style="width:100%; border-collapse:separate; border-spacing:0 10px;">
        <tbody id="featureMatrix">
          <?php if(empty($comp_matrix)): ?>
          <tr class="feature-row">
            <td><input type="text" name="features[]" placeholder="Feature name" required></td>
            <td><input type="text" name="p1_vals[]" placeholder="value"></td>
            <td><input type="text" name="p2_vals[]" placeholder="value"></td>
            <td><input type="text" name="p3_vals[]" placeholder="value"></td>
            <td style="text-align:center;"><button type="button" class="admin-btn btn-danger" onclick="removeRow(this)" style="padding:8px;"><i class="fas fa-times"></i></button></td>
          </tr>
          <?php else: foreach($comp_matrix as $item): ?>
          <tr class="feature-row">
            <td><input type="text" name="features[]" value="<?= htmlspecialchars($item['name']) ?>" required></td>
            <td><input type="text" name="p1_vals[]" value="<?= htmlspecialchars($item['p1']) ?>"></td>
            <td><input type="text" name="p2_vals[]" value="<?= htmlspecialchars($item['p2']) ?>"></td>
            <td><input type="text" name="p3_vals[]" value="<?= htmlspecialchars($item['p3']) ?>"></td>
            <td style="text-align:center;"><button type="button" class="admin-btn btn-danger" onclick="removeRow(this)" style="padding:8px;"><i class="fas fa-times"></i></button></td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
      <button type="button" class="admin-btn btn-primary" onclick="addRow()" style="margin-top:10px; font-size:12px; padding:8px 15px;">
        <i class="fas fa-plus"></i> Add Comparison Row
      </button>
    </div>

    <div style="margin-top:30px; display:flex; justify-content:space-between; align-items:center;">
      <div style="width:200px;">
        <label>Table Status</label>
        <select name="status">
          <option value="active" <?= $table_data['status']=='active'?'selected':'' ?>>Active</option>
          <option value="inactive" <?= $table_data['status']=='inactive'?'selected':'' ?>>Inactive</option>
        </select>
      </div>
      <button type="submit" name="submit" class="admin-btn btn-primary" style="padding:15px 40px; font-size:16px;">Update Table Now</button>
    </div>
  </form>
</div>

<script>
function addRow(){
    const tbody = document.getElementById('featureMatrix');
    const row = document.createElement('tr');
    row.className = 'feature-row';
    row.innerHTML = `
        <td><input type="text" name="features[]" placeholder="Feature name" required></td>
        <td><input type="text" name="p1_vals[]" placeholder="value"></td>
        <td><input type="text" name="p2_vals[]" placeholder="value"></td>
        <td><input type="text" name="p3_vals[]" placeholder="value"></td>
        <td style="text-align:center;"><button type="button" class="admin-btn btn-danger" onclick="removeRow(this)" style="padding:8px;"><i class="fas fa-times"></i></button></td>
    `;
    tbody.appendChild(row);
}

function removeRow(btn){
    if(document.querySelectorAll('.feature-row').length > 1){
        btn.closest('tr').remove();
    } else {
        alert("At least one comparison row is required.");
    }
}
</script>

<?php include 'admin_footer.php'; ?>
