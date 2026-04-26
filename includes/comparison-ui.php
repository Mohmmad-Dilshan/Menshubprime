<?php
/**
 * Comparison Table Frontend UI Component
 * Usage: include 'includes/comparison-ui.php'; renderComparison($table_id);
 */

function renderComparison($id, $conn) {
    $q = mysqli_query($conn, "SELECT * FROM comparison_tables WHERE id=$id AND status='active'");
    $table = mysqli_fetch_assoc($q);
    if(!$table) return;

    $matrix = json_decode($table['comparison_data'], true) ?? [];
    
    // Fetch individual products
    $p1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT title, image, price, affiliate_link FROM products WHERE id=".$table['p1_id']));
    $p2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT title, image, price, affiliate_link FROM products WHERE id=".$table['p2_id']));
    $p3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT title, image, price, affiliate_link FROM products WHERE id=".$table['p3_id']));

    if(!$p1 || !$p2 || !$p3) return;
    ?>

    <style>
    .comp-wrap { 
        width: 100%; 
        margin: 20px 0; 
        overflow-x: auto; 
        background: rgba(15, 23, 42, 0.4); 
        backdrop-filter: blur(20px);
        border-radius: 32px; 
        box-shadow: 0 30px 60px rgba(0,0,0,0.4); 
        border: 1px solid rgba(255, 255, 255, 0.08); 
        scrollbar-width: thin;
        scrollbar-color: rgba(249, 115, 22, 0.3) transparent;
    }
    .comp-wrap::-webkit-scrollbar { height: 6px; }
    .comp-wrap::-webkit-scrollbar-thumb { background: rgba(249, 115, 22, 0.3); border-radius: 10px; }

    .comp-table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 800px; table-layout: fixed; }
    .comp-table th, .comp-table td { padding: 25px 20px; text-align: center; border-bottom: 1px solid rgba(255, 255, 255, 0.05); color: #94a3b8; font-size: 15px; }
    
    .comp-header-row th { background: rgba(255,255,255,0.02); vertical-align: top; border-bottom: 2px solid rgba(255, 255, 255, 0.1); }
    
    .comp-feature-name { 
        text-align: left !important; 
        font-weight: 800; 
        color: #fff !important; 
        background: rgba(15, 23, 42, 0.6) !important; 
        border-right: 1px solid rgba(255, 255, 255, 0.08); 
        width: 200px; 
        font-size: 13px !important;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .comp-product-img { 
        width: 120px; height: 120px; object-fit: contain; margin-bottom: 20px; 
        background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(255,255,255,0.01)); 
        border-radius: 20px; padding: 10px; border: 1px solid rgba(255,255,255,0.1);
        transition: transform 0.3s ease;
    }
    th:hover .comp-product-img { transform: scale(1.1) translateY(-5px); border-color: #f97316; }

    .comp-product-title { 
        font-size: 16px; font-weight: 800; color: #fff; margin-bottom: 15px; 
        min-height: 44px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; 
        line-height: 1.4;
    }

    .comp-badge { 
        display: inline-block; padding: 6px 14px; border-radius: 100px; font-size: 10px; font-weight: 950; 
        text-transform: uppercase; margin-bottom: 15px; letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .badge-p1 { background: linear-gradient(135deg, #fb923c, #f97316); color: #fff; border: 1px solid rgba(255,255,255,0.2); }
    .badge-p2 { background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59,130,246,0.3); }
    .badge-p3 { background: rgba(168, 85, 247, 0.1); color: #a855f7; border: 1px solid rgba(168,85,247,0.3); }
    
    .comp-price { font-size: 22px; font-weight: 900; color: #fff; margin-bottom: 20px; }
    
    .comp-buy-btn { 
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 24px; background: rgba(255,255,255,0.05); color: #fff; 
        text-decoration: none; border-radius: 14px; font-size: 13px; font-weight: 900; 
        transition: 0.4s; border: 1px solid rgba(255,255,255,0.1);
    }
    .comp-buy-btn:hover { background: #f97316; border-color: #f97316; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(249,115,22,0.3); }
    .comp-buy-btn.btn-p1 { background: #f97316; border-color: transparent; }
    
    .comp-value-cell { font-size: 14px; color: #e2e8f0; font-weight: 600; transition: background 0.3s; }
    tr:hover .comp-value-cell { background: rgba(255,255,255,0.02); }
    .comp-value-cell i { color: #f97316; margin-right: 5px; }

    @media(max-width: 768px) {
        .comp-wrap { border-radius: 20px; margin: 10px 0; }
        .comp-table { min-width: 700px; }
        .comp-table th, .comp-table td { padding: 15px 12px; }
        .comp-feature-name { width: 140px; font-size: 11px !important; sticky: left; left: 0; z-index: 5; }
        .comp-product-img { width: 80px; height: 80px; }
        .comp-product-title { font-size: 13px; min-height: 38px; }
        .comp-price { font-size: 18px; }
        .comp-buy-btn { font-size: 11px; padding: 10px 15px; border-radius: 10px; }
    }
    </style>

    <div class="comp-wrap">
        <table class="comp-table">
            <thead>
                <tr class="comp-header-row">
                    <th class="comp-feature-name">What's Inside?</th>
                    <!-- Product 1 Header -->
                    <th>
                        <div class="comp-badge badge-p1"><?= htmlspecialchars($table['p1_label']) ?></div>
                        <img src="assets/images/<?= $p1['image'] ?>" class="comp-product-img" alt="<?= htmlspecialchars($p1['title']) ?>">
                        <div class="comp-product-title"><?= htmlspecialchars($p1['title']) ?></div>
                        <div class="comp-price">₹<?= $p1['price'] ?></div>
                        <a href="<?= $p1['affiliate_link'] ?>" target="_blank" class="comp-buy-btn btn-p1">Check Price</a>
                    </th>
                    <!-- Product 2 Header -->
                    <th>
                        <div class="comp-badge badge-p2"><?= htmlspecialchars($table['p2_label']) ?></div>
                        <img src="assets/images/<?= $p2['image'] ?>" class="comp-product-img" alt="<?= htmlspecialchars($p2['title']) ?>">
                        <div class="comp-product-title"><?= htmlspecialchars($p2['title']) ?></div>
                        <div class="comp-price">₹<?= $p2['price'] ?></div>
                        <a href="<?= $p2['affiliate_link'] ?>" target="_blank" class="comp-buy-btn">Check Price</a>
                    </th>
                    <!-- Product 3 Header -->
                    <th>
                        <div class="comp-badge badge-p3"><?= htmlspecialchars($table['p3_label']) ?></div>
                        <img src="assets/images/<?= $p3['image'] ?>" class="comp-product-img" alt="<?= htmlspecialchars($p3['title']) ?>">
                        <div class="comp-product-title"><?= htmlspecialchars($p3['title']) ?></div>
                        <div class="comp-price">₹<?= $p3['price'] ?></div>
                        <a href="<?= $p3['affiliate_link'] ?>" target="_blank" class="comp-buy-btn">Check Price</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($matrix as $row): ?>
                <tr>
                    <td class="comp-feature-name"><?= htmlspecialchars($row['name']) ?></td>
                    <td class="comp-value-cell"><?= htmlspecialchars($row['p1']) ?></td>
                    <td class="comp-value-cell"><?= htmlspecialchars($row['p2']) ?></td>
                    <td class="comp-value-cell"><?= htmlspecialchars($row['p3']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
}
?>
