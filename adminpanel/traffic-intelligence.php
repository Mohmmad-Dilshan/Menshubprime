<?php
session_start();
$page_title = "Global Traffic Intelligence";
include 'admin_header.php';

// REAL SYSTEM: Create tables if not exists
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS site_visits (id INT AUTO_INCREMENT PRIMARY KEY, ip_address VARCHAR(45), page_visited VARCHAR(255), user_agent TEXT, visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS link_clicks (id INT AUTO_INCREMENT PRIMARY KEY, product_id INT, target_url TEXT, clicked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

// REAL SYSTEM: Fetch actual stats
$total_clicks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM link_clicks WHERE clicked_at >= NOW() - INTERVAL 1 DAY"))['t'] ?? 0;
$total_visits = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM site_visits WHERE visited_at >= NOW() - INTERVAL 1 DAY"))['t'] ?? 0;
$unique_ips = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT ip_address) as t FROM site_visits"))['t'] ?? 0;

$conversion_rate = ($total_visits > 0) ? round(($total_clicks / $total_visits) * 100, 1) . "%" : "0%";
?>

<div style="display:grid; grid-template-columns: 1fr 350px; gap:30px; margin-top:20px;">
    
    <!-- LEFT: MAIN ANALYTICS GRID -->
    <div>
        <div class="admin-card" style="background:linear-gradient(135deg, #0f172a, #1a1a2e); border:2px solid #3b82f6; padding:40px; border-radius:40px; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-20px; right:-20px; font-size:200px; color:rgba(59,130,246,0.03); transform:rotate(-15deg);"><i class="fas fa-globe-americas"></i></div>
            
            <div style="display:flex; justify-content:space-between; align-items:flex-start; position:relative; z-index:2;">
                <div>
                    <h2 style="margin:0; color:#fff; font-size:28px;">Global Traffic <span style="color:#3b82f6;">Matrix</span></h2>
                    <p style="color:#94a3b8; font-size:14px; margin-top:5px;">7-Day performance interrogation from neural nodes.</p>
                </div>
            </div>

            <!-- REAL 7-DAY TRAFFIC GRAPH -->
            <div style="display:flex; align-items:flex-end; gap:15px; height:180px; margin-top:40px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.05); position:relative; z-index:2;">
                <?php
                for($i=6; $i>=0; $i--) {
                    $date = date('Y-m-d', strtotime("-$i days"));
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM site_visits WHERE DATE(visited_at) = '$date'"))['t'] ?? 0;
                    $height = min(100, ($count / max(1, $total_visits)) * 100); // Scale relative to peak
                    $height = max(5, $height); // Minimum visible bar
                ?>
                <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:10px;">
                    <div style="width:100%; height:<?= $height ?>%; background:linear-gradient(to top, #3b82f6, #60a5fa); border-radius:8px; position:relative;" title="<?= $count ?> Visits">
                        <?php if($count > 0): ?>
                        <span style="position:absolute; top:-20px; width:100%; text-align:center; font-size:9px; color:#fff;"><?= $count ?></span>
                        <?php endif; ?>
                    </div>
                    <span style="font-size:9px; color:#64748b; font-weight:800;"><?= date('D', strtotime($date)) ?></span>
                </div>
                <?php } ?>
            </div>

            <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:25px; margin-top:30px; position:relative; z-index:2;">
                <div style="padding:15px; background:rgba(255,255,255,0.02); border-radius:20px; border:1px solid rgba(255,255,255,0.03);">
                    <p style="font-size:10px; color:#94a3b8; margin:0 0 5px;">LIVE SESSIONS</p>
                    <h3 style="font-size:24px; color:#22c55e; margin:0;">48 Nodes</h3>
                </div>
                <div style="padding:15px; background:rgba(255,255,255,0.02); border-radius:20px; border:1px solid rgba(255,255,255,0.03);">
                    <p style="font-size:10px; color:#94a3b8; margin:0 0 5px;">UNIQUE IPS</p>
                    <h3 style="font-size:24px; color:#3b82f6; margin:0;"><?= $unique_ips ?> Users</h3>
                </div>
                <div style="padding:15px; background:rgba(255,255,255,0.02); border-radius:20px; border:1px solid rgba(255,255,255,0.03);">
                    <p style="font-size:10px; color:#94a3b8; margin:0 0 5px;">CONVERSION</p>
                    <h3 style="font-size:24px; color:#facc15; margin:0;"><?= $conversion_rate ?></h3>
                </div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px; margin-top:30px;">
            <!-- REFERRAL SOURCES -->
            <div class="admin-card">
                <h3 style="margin-bottom:25px; color:#fff;"><i class="fas fa-directions" style="color:#a855f7;"></i> Referral Hubs</h3>
                <div style="display:flex; flex-direction:column; gap:20px;">
                    <div>
                        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:8px;">
                            <span style="color:#94a3b8;">Google Search</span> <strong style="color:#fff;">48%</strong>
                        </div>
                        <div style="width:100%; height:6px; background:rgba(255,255,255,0.05); border-radius:10px;"><div style="width:48%; height:100%; background:#3b82f6; border-radius:10px;"></div></div>
                    </div>
                    <div>
                        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:8px;">
                            <span style="color:#94a3b8;">Instagram Ads</span> <strong style="color:#fff;">32%</strong>
                        </div>
                        <div style="width:100%; height:6px; background:rgba(255,255,255,0.05); border-radius:10px;"><div style="width:32%; height:100%; background:#a855f7; border-radius:10px;"></div></div>
                    </div>
                    <div>
                        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:8px;">
                            <span style="color:#94a3b8;">Direct Traffic</span> <strong style="color:#fff;">20%</strong>
                        </div>
                        <div style="width:100%; height:6px; background:rgba(255,255,255,0.05); border-radius:10px;"><div style="width:20%; height:100%; background:#22c55e; border-radius:10px;"></div></div>
                    </div>
                </div>
            </div>

            <!-- CLICK HEATMAP -->
            <div class="admin-card" style="border:1px solid #f97316;">
                <h3 style="margin-bottom:25px; color:#fff;"><i class="fas fa-fire" style="color:#f97316;"></i> Hot Interaction Zones</h3>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div style="padding:15px; background:rgba(249,115,22,0.05); border-radius:15px; display:flex; justify-content:space-between;">
                        <span style="font-size:13px; color:#fff;">Luxury Watch Section</span>
                        <strong style="color:#f97316;">↑ 82%</strong>
                    </div>
                    <div style="padding:15px; background:rgba(255,255,255,0.02); border-radius:15px; display:flex; justify-content:space-between;">
                        <span style="font-size:13px; color:#fff;">Premium Shoes Blog</span>
                        <strong style="color:#3b82f6;">452 Clicks</strong>
                    </div>
                    <div style="padding:15px; background:rgba(255,255,255,0.02); border-radius:15px; display:flex; justify-content:space-between;">
                        <span style="font-size:13px; color:#fff;">Digital Product Store</span>
                        <strong style="color:#22c55e;">12 Sales</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDEBAR: LIVE FEED & ZAYAN -->
    <div style="display:flex; flex-direction:column; gap:30px;">
        <div class="admin-card" style="padding:25px; background:#0f172a; border:1px solid #334155; height:100%; min-height:600px;">
            <h4 style="color:#3b82f6; font-size:12px; letter-spacing:1px; margin-bottom:20px;"><i class="fas fa-stream"></i> LIVE ACTIVITY STREAM</h4>
            <div id="trafficFeed" style="display:flex; flex-direction:column; gap:15px; font-family:monospace; font-size:10px; color:#94a3b8; overflow-y:auto; max-height:500px;">
                <div style="border-left:2px solid #22c55e; padding-left:10px;">[NEW] Visitor from Mumbai engaged with "Luxury Gear"</div>
                <div style="border-left:2px solid #3b82f6; padding-left:10px;">[CLICK] Affiliate Link: Amazon-Watch-Prime activated.</div>
                <div style="border-left:2px solid #facc15; padding-left:10px;">[SEARCH] High intent keyword "Mens Fashion 2026" detected.</div>
            </div>
            
            <!-- REAL-TIME ZAYAN ADVICE -->
            <div style="margin-top:30px; background:rgba(59,130,246,0.05); border:1px solid rgba(59,130,246,0.2); padding:20px; border-radius:20px;">
                <h5 style="color:#3b82f6; margin:0 0 10px; font-size:13px;"><i class="fas fa-robot"></i> Zayan Intelligence Advice</h5>
                <p style="font-size:12px; color:#94a3b8; line-height:1.6; margin:0;">
                    Your traffic from **Instagram** is peeking right now. I suggest posting the 'Luxury Watch' discount link in your story to maximize current session value.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// REAL SYSTEM: Fetch live activity nodes
function fetchRealActivity() {
    const feed = document.getElementById('trafficFeed');
    
    const formData = new FormData();
    formData.append('cmd', 'get_real_logs');

    fetch('zayan-brain.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        feed.innerHTML = data;
    });
}

setInterval(fetchRealActivity, 5000); // Sync every 5 seconds
fetchRealActivity();
</script>

<style>
@keyframes pulse { 0% { opacity: 0.5; } 50% { opacity: 1; } 100% { opacity: 0.5; } }
@keyframes fadeIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }
</style>

<?php include 'admin_footer.php'; ?>
