<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    echo "AI Error: Unauthorized Access Detected. Intrusion blocked.";
    exit();
}
include '../config/db.php';

$cmd = $_POST['cmd'] ?? '';
$cmd = strtolower(trim($cmd));

if (!$conn) {
    echo "AI Error: Database connection lost.";
    exit;
}

// Logic to calculate Integrity Score
$total_p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM products"))['t'] ?? 0;
$p_pend = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM products WHERE status='inactive'"))['t'] ?? 0;
$missing_p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM products WHERE description = '' OR image = ''"))['t'] ?? 0;

$integrity = 100 - (round(($p_pend + $missing_p) / max(1, $total_p) * 100));

if (strpos($cmd, 'status') !== false || strpos($cmd, 'health') !== false) {
    echo "AI Brain: Your site integrity is currently at **$integrity%**. You have **$p_pend** pending products and **$missing_p** items with missing metadata.";
} 
else if (strpos($cmd, 'deal') !== false || strpos($cmd, 'product') !== false) {
    $latest = mysqli_query($conn, "SELECT title FROM products ORDER BY id DESC LIMIT 3");
    $list = "";
    while($row = mysqli_fetch_assoc($latest)) { $list .= "• " . $row['title'] . "<br>"; }
    echo "AI Brain: Here are the latest assets in the inventory:<br>$list";
}
else if (strpos($cmd, 'user') !== false || strpos($cmd, 'sub') !== false) {
    $subs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM subscribers WHERE DATE(date) = CURDATE()"))['t'] ?? 0;
    echo "AI Brain: You received **$subs** new subscribers today. The growth curve looks stable.";
}
else if (strpos($cmd, 'seo') !== false) {
    $seo_gaps = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM blogs WHERE meta_description = ''"))['t'] ?? 0;
    echo "AI Brain: I found **$seo_gaps** blogs without meta descriptions. They won't rank on Google until fixed.";
}
else if (strpos($cmd, 'get_real_logs') !== false) {
    $out = "";
    $visits = mysqli_query($conn, "SELECT ip_address, page_visited, visited_at FROM site_visits ORDER BY id DESC LIMIT 10");
    while($v = mysqli_fetch_assoc($visits)) {
        $out .= "<div style='border-left:2px solid #3b82f6; padding-left:10px; margin-bottom:10px;'>[VISIT] ". $v['ip_address'] ." viewed ". basename($v['page_visited']) ." at ". date('H:i:s', strtotime($v['visited_at'])) ."</div>";
    }
    
    $clicks = mysqli_query($conn, "SELECT target_url, clicked_at FROM link_clicks ORDER BY id DESC LIMIT 5");
    while($c = mysqli_fetch_assoc($clicks)) {
        $out .= "<div style='border-left:2px solid #22c55e; padding-left:10px; margin-bottom:10px; color:#fff;'>[CLICK] Affiliate: ". parse_url($c['target_url'], PHP_URL_HOST) ." at ". date('H:i:s', strtotime($c['clicked_at'])) ."</div>";
    }
    echo $out ?: "<div style='color:#64748b'>[SYS] No recent activity nodes... Site is quiet.</div>";
}
else {
    echo "AI Brain: I am monitoring your site. You can ask me about 'status', 'latest deals', 'seo gaps', or 'today's users'. How can I assist further?";
}
?>
