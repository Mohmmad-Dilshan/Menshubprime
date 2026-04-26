<?php
session_start();
$page_title = "SEO Auto-Pilot Fix";
include 'admin_header.php';

/* helper to safely get count */
function safeCount($conn, $sql) {
    if(!$conn) return 0;
    $res = @mysqli_query($conn, $sql);
    if($res) {
        $data = mysqli_fetch_assoc($res);
        return $data['total'] ?? 0;
    }
    return 0;
}

if(isset($_POST['run_fix'])){
    $q = @mysqli_query($conn, "SELECT id, title FROM products WHERE description = '' OR description IS NULL");
    $fixed = 0;
    
    if($q) {
        while($row = mysqli_fetch_assoc($q)){
            $id = $row['id'];
            $title = $row['title'];
            $ai_desc = "Experience premium quality with the " . htmlspecialchars($title) . ". Meticulously curated by MensHub Prime, this product is designed for the modern man who values both style and durability. Whether you're upgrading your essentials or looking for the perfect gift, the " . htmlspecialchars($title) . " stands out as a top-tier choice in its category. Discover why smart shoppers trust MensHub for their lifestyle needs.";
            $safe_desc = mysqli_real_escape_string($conn, $ai_desc);
            mysqli_query($conn, "UPDATE products SET description = '$safe_desc' WHERE id = '$id'");
            $fixed++;
        }
    }
    
    // Also fix blogs
    $q2 = @mysqli_query($conn, "SELECT id, title FROM blogs WHERE meta_description = '' OR meta_description IS NULL");
    if($q2) {
        while($row = mysqli_fetch_assoc($q2)){
            $id = $row['id'];
            $title = $row['title'];
            $meta = "Explore the latest insights on " . htmlspecialchars($title) . ". MensHub Prime brings you the ultimate style guide and professional advice for the modern Indian man.";
            $safe_meta = mysqli_real_escape_string($conn, $meta);
            mysqli_query($conn, "UPDATE blogs SET meta_description = '$safe_meta' WHERE id = '$id'");
            $fixed++;
        }
    }

    echo "<div class='admin-card' style='background:rgba(34,197,94,0.1); border-color:#22c55e;'>
            <h2 style='color:#22c55e;'><i class='fas fa-magic'></i> Success!</h2>
            <p>Fixed <strong>$fixed</strong> items instantly. Your SEO score has been massivey boosted!</p>
            <a href='site-audit.php' class='admin-btn btn-primary' style='margin-top:20px;'>Return to Site Intelligence</a>
          </div>";
    include 'admin_footer.php';
    exit;
}

$empty_products = safeCount($conn, "SELECT COUNT(*) as total FROM products WHERE description = '' OR description IS NULL");
$empty_blogs = safeCount($conn, "SELECT COUNT(*) as total FROM blogs WHERE meta_description = '' OR meta_description IS NULL");
?>

<div class="admin-card" style="max-width:800px; margin: 0 auto; text-align:center; padding:60px 40px;">
    <div style="font-size:60px; color:#f97316; margin-bottom:30px;"><i class="fas fa-robot"></i></div>
    <h1 style="font-size:32px; font-weight:900; margin-bottom:15px;">SEO Auto-Pilot Booster</h1>
    <p style="color:var(--text-muted); font-size:18px; line-height:1.6; margin-bottom:40px;">
        We found <strong><?= $empty_products ?> products</strong> and <strong><?= $empty_blogs ?> blogs</strong> that are dragging down your SEO score. 
        Click the button below to generate professional, high-converting descriptions for all of them instantly.
    </p>
    
    <form action="" method="POST">
        <button type="submit" name="run_fix" class="admin-btn btn-primary" style="font-size:18px; padding:18px 40px; border-radius:100px; background:linear-gradient(135deg, #f97316, #fb923c); border:none; box-shadow:0 20px 40px rgba(249,115,22,0.3);">
           <i class="fas fa-bolt"></i> Run "Magic Fix" Now
        </button>
    </form>
    
    <p style="font-size:12px; color:var(--text-muted); margin-top:30px;">
        <i class="fas fa-info-circle"></i> This will use professional MensHub templates to fill in empty fields only. Your existing descriptions will not be changed.
    </p>
</div>

<?php include 'admin_footer.php'; ?>
