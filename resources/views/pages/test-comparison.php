<?php
include 'config/db.php';
$page_title = "Gadget Comparison Showdown";
include ROOT_PATH . '/includes/header.php';
include 'includes/comparison-ui.php';
?>

<div style="max-width:1200px; margin:60px auto; padding:0 20px;">
    <div style="text-align:center; margin-bottom:40px;">
        <h1 style="font-size:36px; color:#1e293b; margin-bottom:15px;">🔥 The Ultimate Gadget Showdown 2026</h1>
        <p style="color:#64748b; font-size:18px;">We compared the top 3 trending gadgets so you don't have to!</p>
    </div>

    <?php 
    // Render the sample table we just created (assuming ID 1 since we dropped/recreated)
    renderComparison(1, $conn); 
    ?>

    <div style="margin-top:60px; background:#f8fafc; padding:40px; border-radius:18px; text-align:center; border:1px solid #e2e8f0;">
        <h2 style="color:#1e293b; margin-bottom:20px;">Why this matters?</h2>
        <p style="color:#475569; line-height:1.7; max-width:800px; margin:auto;">
            By providing clear side-by-side comparisons, you help your users make faster buying decisions. 
            This "Best Overall" vs "Best Budget" strategy is what drives the highest affiliate conversion rates for professional blogs.
        </p>
    </div>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
