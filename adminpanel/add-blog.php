<?php
session_start();
$page_title = "Publish New Article";
include 'admin_header.php';

if(isset($_POST['submit'])){
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $content = mysqli_real_escape_string($conn, $_POST['content']); // HTML content from TinyMCE
  $category = mysqli_real_escape_string($conn, $_POST['category'] ?? 'Lifestyle');
  $date = date('Y-m-d');

  $image = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  move_uploaded_file($tmp,"../assets/images/".$image);

  // AUTO-GENERATE SLUG FROM TITLE
  $raw_slug = strtolower(trim($title));
  $raw_slug = preg_replace('/[^a-z0-9\s-]/', '', $raw_slug); // Remove special chars
  $raw_slug = preg_replace('/[\s-]+/', '-', $raw_slug);       // Replace spaces with -
  $raw_slug = trim($raw_slug, '-');                            // Trim leading/trailing -
  $raw_slug = $raw_slug ?: 'blog-' . time();                  // Fallback if empty

  // Make slug unique - check if it already exists
  $base_slug = $raw_slug;
  $counter = 1;
  while(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM blogs WHERE slug='$raw_slug'")) > 0) {
    $raw_slug = $base_slug . '-' . $counter;
    $counter++;
  }
  $slug = mysqli_real_escape_string($conn, $raw_slug);

  mysqli_query($conn,"INSERT INTO blogs(title,slug,image,content,date,status,category) VALUES('$title','$slug','$image','$content','$date','$status','$category')");
  $blog_id = mysqli_insert_id($conn);

  /* INSERT PRODUCTS */
  $titles = $_POST['product_title'];
  $descs = $_POST['product_desc'];
  $links = $_POST['product_link'];

  for($i=0;$i<count($titles);$i++){
    $ptitle = mysqli_real_escape_string($conn, $titles[$i]);
    $pdesc = mysqli_real_escape_string($conn, $descs[$i]);
    $plink = mysqli_real_escape_string($conn, $links[$i]);

    if($ptitle!=""){
      $pimg = $_FILES['product_image']['name'][$i];
      $tmp_p = $_FILES['product_image']['tmp_name'][$i];
      move_uploaded_file($tmp_p,"../assets/images/".$pimg);

      mysqli_query($conn,"INSERT INTO blog_products (blog_id,product_title,product_image,product_description,affiliate_link,product_order) VALUES('$blog_id','$ptitle','$pimg','$pdesc','$plink','$i')");
    }
  }
  echo "<script>alert('Blog Published! Slug: $raw_slug'); window.location='blogs.php'</script>";
}
?>

<div class="admin-card">
  <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    
    <div style="margin-bottom:40px; padding-bottom:30px; border-bottom:1px solid var(--glass-border);">
      <h3 style="margin-bottom:20px; color:var(--primary);"><i class="fas fa-edit"></i> Article Essentials</h3>
      
      <label>Article Title</label>
      <input type="text" name="title" id="blogTitleInput" placeholder="e.g. Top 10 Grooming Essentials for Men" required>

      <label>URL Slug (Auto-generated)</label>
      <input type="text" id="slugPreview" style="background:rgba(249,115,22,0.08); border:1px solid #f97316; color:#f97316; font-family:monospace; font-size:13px; cursor:default;" placeholder="slug will appear here..." readonly>
      <small style="color:#64748b; font-size:11px;">URL: yoursite.com/blog/<span id="slugPreviewText" style="color:#f97316;">slug-here</span></small>

      <label>Category</label>
      <select name="category">
        <option value="Lifestyle">Lifestyle</option>
        <option value="Grooming">Grooming</option>
        <option value="Fashion">Fashion</option>
        <option value="Tech">Tech</option>
        <option value="Fitness">Fitness</option>
        <option value="Deals">Deals</option>
        <option value="Review">Review</option>
      </select>

      <label>Featured Image</label>
      <input type="file" name="image" required>

      <label>Article Introduction / Content <small style="color:#64748b; font-weight:400;">(Formatting, headings, bold, lists — sab support karta hai)</small></label>
      <textarea name="content" id="blogContent" placeholder="Write a compelling introduction for your blog post..." required></textarea>

      <!-- TinyMCE Rich Text Editor (No API Key Required) -->
      <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
      <script>
      // Main Editor
      tinymce.init({
        selector: '#blogContent',
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

      <label><i class="fas fa-toggle-on"></i> Initial Publication Status</label>
      <select name="status">
        <option value="active">Active / Published</option>
        <option value="inactive">Inactive / Draft</option>
      </select>

      <script>
      document.getElementById('blogTitleInput').addEventListener('input', function() {
        var slug = this.value
          .toLowerCase()
          .replace(/[^a-z0-9\s-]/g, '')
          .replace(/[\s-]+/g, '-')
          .replace(/^-+|-+$/g, '');
        document.getElementById('slugPreview').value = slug;
        document.getElementById('slugPreviewText').innerText = slug || 'slug-here';
      });
      </script>
    </div>

    <div style="margin-bottom:30px;">
      <h3 style="margin-bottom:10px; color:#22c55e;"><i class="fas fa-shopping-cart"></i> Ranked Products (Top Picks)</h3>
      <p style="font-size:13px; color:var(--text-muted); margin-bottom:20px;">Add the products mentioned in your article. These will be displayed as a ranked list.</p>

      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        <?php for($i=1;$i<=6;$i++){ ?>
        <div style="background:rgba(255,255,255,0.02); border:1px solid var(--glass-border); padding:20px; border-radius:15px;">
          <h4 style="margin-bottom:15px; color:var(--primary);">#<?= $i; ?> Product</h4>
          
          <label>Product Title</label>
          <input type="text" name="product_title[]" placeholder="Product Name">

          <label>Product Image</label>
          <input type="file" name="product_image[]">

          <label>Description</label>
          <textarea name="product_desc[]" class="product-editor" rows="3" placeholder="Why is this a top pick?"></textarea>

          <label>Affiliate Link</label>
          <input type="text" name="product_link[]" placeholder="https://amazon.in/...">
        </div>
        <?php } ?>
      </div>
    </div>

    <div style="margin-top:40px; border-top:1px solid var(--glass-border); padding-top:20px; display:flex; justify-content:flex-end; gap:15px;">
      <a href="blogs.php" class="admin-btn btn-danger"><i class="fas fa-times"></i> Discard</a>
      <button type="submit" name="submit" class="admin-btn btn-primary" style="padding:15px 40px;">
        <i class="fas fa-upload"></i> Publish Article
      </button>
    </div>
  </form>
</div>

<?php include 'admin_footer.php'; ?>