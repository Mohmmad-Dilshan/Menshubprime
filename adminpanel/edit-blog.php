<?php
session_start();
$page_title = "Edit Blog Post";
include 'admin_header.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM blogs WHERE id='$id'"));
if(!$data){
  echo "<div class='alert alert-danger'>Blog post not found.</div>";
  include 'admin_footer.php';
  exit();
}

$products = mysqli_query($conn,"SELECT * FROM blog_products WHERE blog_id='$id' ORDER BY product_order ASC");

if(isset($_POST['update'])){
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $content = mysqli_real_escape_string($conn, $_POST['content']); // HTML from TinyMCE
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  // SLUG: Use manually entered slug, or generate from title if empty
  $input_slug = trim($_POST['slug'] ?? '');
  if (!empty($input_slug)) {
    $raw_slug = strtolower($input_slug);
    $raw_slug = preg_replace('/[^a-z0-9\s-]/', '', $raw_slug);
    $raw_slug = preg_replace('/[\s-]+/', '-', $raw_slug);
    $raw_slug = trim($raw_slug, '-');
  } else {
    // Auto-generate from title
    $raw_slug = strtolower(trim($title));
    $raw_slug = preg_replace('/[^a-z0-9\s-]/', '', $raw_slug);
    $raw_slug = preg_replace('/[\s-]+/', '-', $raw_slug);
    $raw_slug = trim($raw_slug, '-');
    $raw_slug = $raw_slug ?: 'blog-' . time();
  }
  // Make unique (ignore current blog's own slug)
  $base_slug = $raw_slug;
  $counter = 1;
  while(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM blogs WHERE slug='$raw_slug' AND id!='$id'")) > 0) {
    $raw_slug = $base_slug . '-' . $counter;
    $counter++;
  }
  $slug = mysqli_real_escape_string($conn, $raw_slug);

  if(!empty($_FILES['image']['name'])){
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp,"../assets/images/".$img);
  } else {
    $img = $data['image'];
  }

  mysqli_query($conn,"UPDATE blogs SET title='$title', slug='$slug', content='$content', image='$img', status='$status' WHERE id='$id'");
  echo "<script>alert('Blog Updated! New URL: /blog/$raw_slug');</script>";

  $product_ids = $_POST['product_id'];
  $product_titles = $_POST['product_title'];
  $product_desc = $_POST['product_desc'];
  $product_links = $_POST['product_link'];

  for($i=0;$i<count($product_ids);$i++){
    $pid = mysqli_real_escape_string($conn, $product_ids[$i]);
    $ptitle = mysqli_real_escape_string($conn, $product_titles[$i]);
    $pdesc = mysqli_real_escape_string($conn, $product_desc[$i]);
    $plink = mysqli_real_escape_string($conn, $product_links[$i]);

    if(!empty($_FILES['product_image']['name'][$i])){
      $pimg = $_FILES['product_image']['name'][$i];
      $tmp_p = $_FILES['product_image']['tmp_name'][$i];
      move_uploaded_file($tmp_p,"../assets/images/".$pimg);

      mysqli_query($conn,"UPDATE blog_products SET product_title='$ptitle', product_description='$pdesc', affiliate_link='$plink', product_image='$pimg' WHERE id='$pid'");
    } else {
      mysqli_query($conn,"UPDATE blog_products SET product_title='$ptitle', product_description='$pdesc', affiliate_link='$plink' WHERE id='$pid'");
    }
  }
  echo "<script>alert('Blog Updated Successfully'); window.location='blogs.php'</script>";
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    
    <!-- Blog Essentials -->
    <div style="margin-bottom:40px; padding-bottom:30px; border-bottom:1px solid var(--glass-border);">
      <h3 style="margin-bottom:20px; color:var(--primary);"><i class="fas fa-edit"></i> Edit Article Essentials</h3>
      
      <label>Article Title</label>
      <input type="text" name="title" id="editTitleInput" value="<?= htmlspecialchars($data['title']); ?>" required>

      <label>URL Slug <small style="color:#64748b; font-weight:400;">(blog ka URL — sirf lowercase letters, numbers aur - allowed hain)</small></label>
      <input type="text" name="slug" id="editSlugInput"
        value="<?= htmlspecialchars($data['slug'] ?? ''); ?>"
        placeholder="e.g. best-grooming-tips-for-men"
        style="font-family:monospace; color:#f97316; background:rgba(249,115,22,0.08); border:1px solid #f97316;">
      <small style="color:#64748b; font-size:11px;">Current URL: <strong style="color:#f97316;">/blog/<?= htmlspecialchars($data['slug'] ?? 'NOT SET - will auto-generate on save'); ?></strong></small>

      <script>
      // Auto-generate slug from title only if slug field is empty
      document.getElementById('editTitleInput').addEventListener('input', function() {
        var slugField = document.getElementById('editSlugInput');
        if (slugField.value === '' || slugField.dataset.autoMode === 'true') {
          slugField.dataset.autoMode = 'true';
          slugField.value = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        }
      });
      document.getElementById('editSlugInput').addEventListener('input', function() {
        this.dataset.autoMode = 'false';
      });
      </script>

      <div style="margin:20px 0; display:flex; align-items:flex-end; gap:20px;">
        <div style="flex-shrink:0;">
          <label>Current Banner</label><br>
          <img src="../assets/images/<?= $data['image'] ?>" style="width:120px; height:80px; object-fit:cover; border-radius:10px; border:1px solid var(--glass-border);">
        </div>
        <div style="flex-grow:1;">
          <label>Change Featured Image</label>
          <input type="file" name="image">
        </div>
      </div>

      <label>Article Introduction / Content <small style="color:#64748b; font-weight:400;">(Formatting, headings, bold, lists — sab support karta hai)</small></label>
      <textarea name="content" id="editBlogContent" required><?= htmlspecialchars($data['content']); ?></textarea>

      <!-- TinyMCE Rich Text Editor (No API Key Required) -->
      <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
      <script>
      // Main Editor
      tinymce.init({
        selector: '#editBlogContent',
        height: 500,
        menubar: false,
        plugins: 'lists link image code wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link | removeformat | code',
        block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4',
        content_style: 'body { font-family: Georgia, serif; font-size: 18px; line-height: 2; color: #1e293b; padding: 20px; background: #fff; }',
        skin: 'oxide',
        content_css: 'default',
        branding: false,
        promotion: false,
        paste_as_text: false,
        smart_paste: true,
        setup: function(editor) {
          editor.on('init', function() {
            var raw = document.getElementById('editBlogContent').value;
            editor.setContent(raw);
          });
        }
      });

      // Product Editors (Smaller)
      tinymce.init({
        selector: '.product-editor',
        height: 250,
        menubar: false,
        plugins: 'lists link code',
        toolbar: 'bold italic | bullist numlist | removeformat | code',
        content_style: 'body { font-family: sans-serif; font-size: 14px; color: #1e293b; padding: 10px; background: #fff; }',
        skin: 'oxide',
        content_css: 'default',
        branding: false,
        promotion: false
      });
      </script>

      <label><i class="fas fa-toggle-on"></i> Publication Status</label>
      <select name="status">
        <option value="active" <?= ($data['status']=='active')?'selected':'' ?>>Active / Published</option>
        <option value="inactive" <?= ($data['status']=='inactive')?'selected':'' ?>>Inactive / Draft</option>
      </select>
    </div>

    <!-- Linked Products -->
    <div style="margin-bottom:30px;">
      <h3 style="margin-bottom:20px; color:#22c55e;"><i class="fas fa-shopping-cart"></i> Manage Top Picks</h3>
      
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:25px;">
        <?php 
        $count = 1;
        while($p=mysqli_fetch_assoc($products)){ 
        ?>
        <div style="background:rgba(255,255,255,0.02); border:1px solid var(--glass-border); padding:20px; border-radius:15px;">
          <input type="hidden" name="product_id[]" value="<?= $p['id'] ?>">
          <h4 style="margin-bottom:15px; color:var(--primary);">#<?= $count++; ?> Product</h4>
          
          <label>Product Title</label>
          <input type="text" name="product_title[]" value="<?= htmlspecialchars($p['product_title']); ?>">

          <div style="margin:15px 0; display:flex; align-items:center; gap:15px;">
            <img src="../assets/images/<?= $p['product_image']; ?>" style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
            <div style="flex-grow:1;">
              <label>Replace Image</label>
              <input type="file" name="product_image[]">
            </div>
          </div>

          <label>Description</label>
          <textarea name="product_desc[]" class="product-editor" rows="3"><?= htmlspecialchars($p['product_description']); ?></textarea>

          <label>Affiliate Link</label>
          <input type="text" name="product_link[]" value="<?= htmlspecialchars($p['affiliate_link']); ?>">
        </div>
        <?php } ?>
      </div>
    </div>

    <div style="margin-top:40px; border-top:1px solid var(--glass-border); padding-top:20px; display:flex; justify-content:flex-end; gap:15px;">
      <a href="blogs.php" class="admin-btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
      <button type="submit" name="update" class="admin-btn btn-primary" style="padding:15px 40px;">
        <i class="fas fa-save"></i> Save Blog Changes
      </button>
    </div>

  </form>
</div>

<?php include 'admin_footer.php'; ?>