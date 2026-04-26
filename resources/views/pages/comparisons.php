<?php
// bootstrap removed
$page_title = "Expert Top Picks & Comparisons | MENHUB PRIME";
$page_description = "Check out our expert side-by-side product comparisons to find the best value, premium and budget choices for men's gear.";
include ROOT_PATH . '/includes/header.php';
include 'includes/comparison-ui.php';

$q = mysqli_query($conn, "SELECT * FROM comparison_tables WHERE status='active' ORDER BY id DESC");
?>

<style>
.comp-list-hero { 
    background: radial-gradient(circle at 50% 10%, rgba(249, 115, 22, 0.08) 0%, #000 80%); 
    padding: 120px 20px 100px; 
    text-align: center; 
    border-bottom: 1px solid rgba(255,255,255,0.05); 
    position: relative;
    overflow: hidden;
}
.comp-list-hero::before {
    content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle at 50% 50%, rgba(249, 115, 22, 0.03) 0%, transparent 50%);
    animation: slow-rotate 60s linear infinite;
}
@keyframes slow-rotate { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

.comp-list-hero h1 { 
    font-size: 56px; font-weight: 950; color: #fff; margin-bottom: 20px; 
    letter-spacing: -2px; position: relative; z-index: 2;
}
.comp-list-hero h1 span { background: linear-gradient(135deg, #f97316, #fb923c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.comp-list-hero p { color: #94a3b8; font-size: 20px; max-width: 750px; margin: auto; line-height: 1.6; font-weight: 500; position: relative; z-index: 2; }

.comp-list-container { max-width: 1250px; margin: -60px auto 100px; padding: 0 20px; position: relative; z-index: 10; }

.comp-card-item { 
    background: rgba(15, 23, 42, 0.4); 
    backdrop-filter: blur(30px);
    border-radius: 40px; 
    padding: 50px; 
    margin-bottom: 60px; 
    box-shadow: 0 40px 100px rgba(0,0,0,0.6); 
    border: 1px solid rgba(255, 255, 255, 0.08); 
    transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}
.comp-card-item:hover { transform: translateY(-10px); border-color: rgba(249, 115, 22, 0.3); }

.comp-card-title { 
    font-size: 36px; font-weight: 950; color: #fff; margin-bottom: 40px; 
    text-align: center; letter-spacing: -1px; 
}

@media(max-width: 768px) {
    .comp-list-hero { padding: 80px 20px 60px; }
    .comp-list-hero h1 { font-size: 34px; letter-spacing: -1px; }
    .comp-list-hero p { font-size: 16px; }
    .comp-list-container { margin: -20px auto 40px; }
    .comp-card-item { padding: 25px 15px; border-radius: 25px; margin-bottom: 40px; }
    .comp-card-title { font-size: 24px; margin-bottom: 25px; line-height: 1.3; }
}
</style>

<section class="comp-list-hero">
    <h1>🔥 Expert <span>Top Picks</span></h1>
    <p>We rigorously test and map the trending market so you don't have to. Only the best gear makes it to our prime selection.</p>
</section>

<div class="comp-list-container">
    <?php 
    if(mysqli_num_rows($q) > 0){
        while($row = mysqli_fetch_assoc($q)){
            echo '<div class="comp-card-item">';
            echo '<h2 class="comp-card-title">'.htmlspecialchars($row['title']).'</h2>';
            renderComparison($row['id'], $conn);
            echo '</div>';
        }
    } else {
        echo '<div style="text-align:center; padding:100px 0; color:#64748b;">';
        echo '<i class="fas fa-search" style="font-size:30px; margin-bottom:20px;"></i>';
        echo '<h3>No comparisons found. Check back soon!</h3>';
        echo '</div>';
    }
    ?>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
