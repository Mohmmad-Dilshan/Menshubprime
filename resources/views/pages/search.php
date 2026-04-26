<?php
$page_title = "Search – MenHub Prime";
include ROOT_PATH . '/includes/header.php';

$query = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'all';
$cat_filter = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

// Base SQL logic for Products
$where_clauses = ["status='active'"];
if ($query) $where_clauses[] = "(title LIKE '%$query%' OR description LIKE '%$query%')";
if ($cat_filter) $where_clauses[] = "category = '$cat_filter'";

$where_sql = implode(" AND ", $where_clauses);

if ($sort === 'trending' && !$cat_filter) {
    // Trending Logic: Popular mix (Union) or specific order
    $sql_filter = $query ? "AND (title LIKE '%$query%' OR description LIKE '%$query%')" : "";
    $products_sql = "(SELECT * FROM products WHERE category = 'shoes' AND status='active' $sql_filter LIMIT 6)
                    UNION
                    (SELECT * FROM products WHERE category = 'watches' AND status='active' $sql_filter LIMIT 6)
                    UNION
                    (SELECT * FROM products WHERE category = 'grooming' AND status='active' $sql_filter LIMIT 6)
                    ORDER BY id DESC";
} elseif ($sort === 'newest') {
    $products_sql = "SELECT * FROM products WHERE $where_sql ORDER BY id DESC LIMIT 20";
} else {
    $products_sql = "SELECT * FROM products WHERE $where_sql ORDER BY id DESC";
}

$products_res = mysqli_query($conn, $products_sql);

// Search Blogs (Include query search)
$blogs_sql = "SELECT * FROM blogs WHERE (title LIKE '%$query%' OR content LIKE '%$query%') AND status='active' ".($sort === 'newest' ? "ORDER BY id DESC" : "ORDER BY RAND()")." LIMIT 10";
$blogs_res = mysqli_query($conn, $blogs_sql);

$total_results = mysqli_num_rows($products_res) + mysqli_num_rows($blogs_res);

// Fetch Categories for Filter
$all_cats = mysqli_query($conn, "SELECT name, slug FROM categories WHERE status='active' ORDER BY name ASC");
?>

<style>
:root {
  --app-bg: #020617;
  --app-accent: #fb923c;
  --app-glass: rgba(15, 23, 42, 0.7);
  --app-border: rgba(255, 255, 255, 0.08);
  --app-radius: 24px;
}

body {
  background: var(--app-bg);
}

.search-results-page {
  padding: 110px 16px 120px; /* Adjusted for mobile app feels */
  min-height: 100vh;
}

.app-search-wrapper {
  max-width: 800px;
  margin: 0 auto;
}

/* --- APP SEARCH BAR --- */
.app-search-header {
  position: sticky;
  top: 90px;
  z-index: 100;
  background: rgba(2, 6, 23, 0.8);
  backdrop-filter: blur(20px);
  margin: -10px -16px 25px;
  padding: 15px 16px;
  border-bottom: 1px solid var(--app-border);
}

.search-field-pill {
  background: var(--app-glass);
  border: 1px solid var(--app-border);
  border-radius: 100px;
  display: flex;
  align-items: center;
  padding: 0 20px;
  height: 52px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  transition: 0.3s;
}

.search-field-pill:focus-within {
  border-color: var(--app-accent);
  box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.15);
}

.search-field-pill i {
  color: var(--app-accent);
  font-size: 18px;
  margin-right: 12px;
}

.search-field-pill input {
  background: transparent;
  border: none;
  color: #fff;
  font-size: 16px;
  font-weight: 600;
  width: 100%;
  outline: none;
}

/* --- FILTER PILLS --- */
.filter-pills-row {
  display: flex;
  gap: 10px;
  overflow-x: auto;
  padding: 5px 0 20px;
  scrollbar-width: none;
  -ms-overflow-style: none;
}
.filter-pills-row::-webkit-scrollbar { display: none; }

.filter-pill {
  white-space: nowrap;
  padding: 10px 22px;
  background: var(--app-glass);
  border: 1px solid var(--app-border);
  border-radius: 100px;
  color: rgba(255,255,255,0.7);
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  transition: 0.3s;
}

.filter-pill.active {
  background: var(--app-accent);
  color: #000;
  border-color: var(--app-accent);
}

/* --- RESULTS INFO --- */
.results-status {
  font-size: 13px;
  font-weight: 800;
  color: var(--app-accent);
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.results-status span {
  flex: 1;
  height: 1px;
  background: linear-gradient(to right, rgba(251, 146, 60, 0.3), transparent);
}

/* --- APP GRID (2 COLUMNS MOBILE) --- */
.app-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
  margin-bottom: 60px;
}

@media (min-width: 768px) {
  .app-grid { grid-template-columns: repeat(3, 1fr); gap: 20px; }
}
@media (min-width: 1024px) {
  .app-grid { grid-template-columns: repeat(4, 1fr); }
}

/* --- APP CARD STYLE --- */
.app-card {
  background: var(--app-glass);
  border: 1px solid var(--app-border);
  border-radius: var(--app-radius);
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  display: flex;
  flex-direction: column;
  position: relative;
}

.app-card:hover {
  transform: translateY(-8px);
  border-color: rgba(251, 146, 60, 0.3);
}

.card-img-wrap {
  position: relative;
  width: 100%;
  aspect-ratio: 1/1;
  background: #000;
}

.card-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: 0.8s;
}

.card-badge {
  position: absolute;
  top: 10px;
  right: 10px;
  background: rgba(0,0,0,0.6);
  backdrop-filter: blur(10px);
  color: #fff;
  padding: 4px 10px;
  border-radius: 8px;
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
}

.card-body {
  padding: 12px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.card-title {
  color: #fff;
  font-size: 14px;
  font-weight: 700;
  line-height: 1.3;
  margin-bottom: 10px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  height: 36px;
}

.card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: auto;
}

.card-price {
  color: var(--app-accent);
  font-size: 16px;
  font-weight: 900;
}

.card-btn {
  background: rgba(255,255,255,0.08);
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 12px;
  transition: 0.3s;
}

.app-card:hover .card-btn {
  background: var(--app-accent);
  color: #000;
}

/* QUICK PEEK BUTTON ON IMAGE */
.card-peek-btn {
    position: absolute;
    bottom: 12px;
    left: 12px;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s;
    opacity: 0;
    transform: translateY(10px);
}

.app-card:hover .card-peek-btn {
    opacity: 1;
    transform: translateY(0);
}

.card-peek-btn:hover {
    background: var(--app-accent);
    color: #000;
}

/* --- BLOG ARTICLE LIST (APP STYLE) --- */
.app-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.app-list-item {
  display: flex;
  gap: 15px;
  background: var(--app-glass);
  border: 1px solid var(--app-border);
  border-radius: 20px;
  padding: 10px;
}

.list-img {
  width: 90px;
  height: 90px;
  border-radius: 12px;
  overflow: hidden;
  flex-shrink: 0;
}
.list-img img { width: 100%; height: 100%; object-fit: cover; }

.list-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.list-title {
  color: #fff;
  font-size: 15px;
  font-weight: 700;
  margin-bottom: 5px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.list-meta {
  font-size: 12px;
  color: rgba(255,255,255,0.4);
  font-weight: 600;
}

/* --- EMPTY STATE --- */
.empty-app-state {
  text-align: center;
  padding: 80px 20px;
}
.empty-icon {
  font-size: 60px;
  color: var(--app-accent);
  margin-bottom: 20px;
  opacity: 0.5;
}
.empty-title { color: #fff; font-size: 22px; font-weight: 800; margin-bottom: 10px; }
.empty-sub { color: rgba(255,255,255,0.5); font-size: 15px; margin-bottom: 30px; }

</style>

<div class="search-results-page">
    <div class="app-search-wrapper">

        <!-- Header Heading Section -->
        <div class="app-page-header" style="margin-bottom: 25px; animation: fadeInDown 0.6s ease both;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <span style="color: var(--app-accent); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; display: block; margin-bottom: 8px; opacity: 0.8;">
                        <?= $query ? ($sort !== 'all' ? ucfirst($sort).' Selection' : 'Search Intelligence') : 'Global Discovery' ?>
                    </span>
                    <h1 id="main-search-title" style="color: #fff; font-size: clamp(24px, 6vw, 38px); font-weight: 950; letter-spacing: -1.5px; line-height: 1; margin: 0;">
                        <?php if($query): ?>
                            Found For <span style="color: var(--app-accent);">"<?= htmlspecialchars($query) ?>"</span>
                        <?php else: ?>
                            MensHub <span style="color: var(--app-accent);">Intelligence</span>
                        <?php endif; ?>
                    </h1>
                </div>
                <div id="live-count-badge" class="search-count-pill" style="margin-bottom: 5px;">
                    <?= $total_results ?> results
                </div>
            </div>
            <p id="search-subtext" style="color: rgba(255,255,255,0.4); font-size: 14px; margin-top: 10px; font-weight: 500;">
                <?= $query ? "Analyzing results from across the Prime ecosystem." : "Access our entire database of premium gear and guides." ?>
            </p>
        </div>
        
        <!-- App Search Header (Sticky) -->
        <div class="app-search-header" style="top: 80px;">
            <form action="/Menshubprime/search" method="GET" class="search-field-pill" id="liveSearchForm">
                <i class="fas fa-search" id="search-icon"></i>
                <input type="text" name="q" id="search-input" value="<?= htmlspecialchars($query) ?>" placeholder="Search gear, fashion, tips..." autocomplete="off">
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                <div id="search-loader" style="display:none;"><i class="fas fa-spinner fa-spin" style="color:var(--app-accent)"></i></div>
            </form>
            
            <!-- Recent Searches -->
            <div id="recent-searches-box" style="margin-top: 15px; display: none;">
                <span style="font-size: 10px; color: rgba(255,255,255,0.4); font-weight: 800; text-transform: uppercase;">Recent</span>
                <div id="recent-pills" style="display: flex; gap: 8px; margin-top: 5px; flex-wrap: wrap;"></div>
            </div>
        </div>

        <!-- Power Filters Row -->
        <div class="filter-pills-row">
            <a href="/Menshubprime/search?q=<?= urlencode($query) ?>&sort=<?= $sort ?>&cat=" class="filter-pill <?= !$cat_filter ? 'active' : '' ?>">All Gear</a>
            <?php while($c = mysqli_fetch_assoc($all_cats)): ?>
                <a href="/Menshubprime/search?q=<?= urlencode($query) ?>&sort=<?= $sort ?>&cat=<?= $c['slug'] ?>" 
                   class="filter-pill <?= $cat_filter === $c['slug'] ? 'active' : '' ?>">
                   <?= htmlspecialchars($c['name']) ?>
                </a>
            <?php endwhile; ?>
            <a href="/Menshubprime/search?q=<?= urlencode($query) ?>&sort=trending" class="filter-pill <?= $sort === 'trending' ? 'active' : '' ?>">🔥 Trending</a>
            <a href="/Menshubprime/search?q=<?= urlencode($query) ?>&sort=newest" class="filter-pill <?= $sort === 'newest' ? 'active' : '' ?>">✨ Newest</a>
        </div>

        <!-- LIVE RESULTS CONTAINER (Used by JS) -->
        <div id="search-results-dynamic">
            <?php if($total_results > 0): ?>
                
                <!-- Products Section -->
                <?php if(mysqli_num_rows($products_res) > 0): ?>
                    <div class="results-status" id="deals-anchor">🛍️ <?= $sort === 'trending' ? 'Popular Recommendations' : 'Matching Deals' ?> <span></span></div>
                    <div class="app-grid">
                        <?php while($p = mysqli_fetch_assoc($products_res)): ?>
                            <div class="app-card">
                                <div class="card-img-wrap">
                                    <span class="card-badge"><?= $sort === 'trending' ? 'POPULAR' : 'PRIME' ?></span>
                                    <a href="/Menshubprime/product/<?= $p['slug'] ?>"><img src="assets/images/<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy"></a>
                                    <!-- QUICK PEEK TRIGGER -->
                                    <button onclick="openQuickPeek('<?= $p['slug'] ?>')" class="card-peek-btn" aria-label="Quick Peek"><i class="fas fa-eye"></i></button>
                                </div>
                                <div class="card-body">
                                    <a href="/Menshubprime/product/<?= $p['slug'] ?>" style="text-decoration: none;"><h3 class="card-title"><?= htmlspecialchars($p['title']) ?></h3></a>
                                    <div class="card-footer">
                                        <span class="card-price">₹<?= number_format($p['price']) ?></span>
                                        <div style="display: flex; gap: 8px;">
                                            <button onclick="openQuickPeek('<?= $p['slug'] ?>')" class="card-btn" style="border:none; cursor:pointer;" aria-label="Quick Peek"><i class="fas fa-eye"></i></button>
                                            <a href="/Menshubprime/product/<?= $p['slug'] ?>" class="card-btn" aria-label="View Details"><i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <!-- Blogs Section -->
                <?php if(mysqli_num_rows($blogs_res) > 0): ?>
                    <div class="results-status" id="blogs-anchor">📰 Related Content <span></span></div>
                    <div class="app-list">
                        <?php while($b = mysqli_fetch_assoc($blogs_res)): ?>
                            <a href="/Menshubprime/blog/<?= $b['slug'] ?>" style="text-decoration: none;">
                                <div class="app-list-item">
                                    <div class="list-img">
                                        <img src="assets/images/<?= $b['image'] ?>" alt="<?= htmlspecialchars($b['title']) ?>" loading="lazy">
                                    </div>
                                    <div class="list-info">
                                        <h3 class="list-title"><?= htmlspecialchars($b['title']) ?></h3>
                                        <div class="list-meta">
                                            <?= date('M d, Y', strtotime($b['date'] ?? 'now')) ?> &bull; Reading Time 3m
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-app-state" id="empty-state">
                    <div class="empty-icon"><i class="fas fa-ghost"></i></div>
                    <h2 class="empty-title">Nothing Found</h2>
                    <p class="empty-sub">We couldn't find matches for this. Try something like "sneakers" or "style".</p>
                    <a href="/Menshubprime/search?q=" class="filter-pill active" style="display:inline-block; text-decoration:none;">Reset Search</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('search-input');
    const dynamicResults = document.getElementById('search-results-dynamic');
    const loader = document.getElementById('search-loader');
    const icon = document.getElementById('search-icon');
    const mainTitle = document.getElementById('main-search-title');
    const countBadge = document.getElementById('live-count-badge');
    const recentBox = document.getElementById('recent-searches-box');
    const recentPills = document.getElementById('recent-pills');

    // 1. Recent Searches Logic
    function updateRecentUI() {
        const history = JSON.parse(localStorage.getItem('mh_search_history') || '[]');
        if (history.length > 0) {
            recentBox.style.display = 'block';
            recentPills.innerHTML = history.map(h => `<a href="/Menshubprime/search?q=${encodeURIComponent(h)}" class="filter-pill" style="font-size:10px; padding:6px 12px; opacity:0.7;">${h}</a>`).join('');
        }
    }
    updateRecentUI();

    function saveToHistory(q) {
        if (!q || q.length < 2) return;
        let history = JSON.parse(localStorage.getItem('mh_search_history') || '[]');
        history = [q, ...history.filter(h => h !== q)].slice(0, 4);
        localStorage.setItem('mh_search_history', JSON.stringify(history));
    }

    // 2. Live Search Logic
    let debounceTimer;
    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const q = this.value.trim();

        if (q.length === 0) {
            // Restore original results if needed or show default?
            // For now, keep as is or reload
            return;
        }

        loader.style.display = 'block';
        icon.style.display = 'none';

        // SHOW SKELETONS WHILE SEARCHING
        dynamicResults.innerHTML = `
            <div class="results-status">🔍 Seeking Prime Deals... <span></span></div>
            <div class="app-grid">
                ${Array(4).fill().map(() => `
                    <div class="app-card" style="opacity:0.6;">
                        <div class="skeleton-img-lg skeleton"></div>
                        <div class="card-body">
                            <div class="skeleton" style="width: 80%; height: 16px; margin-bottom: 10px;"></div>
                            <div class="skeleton" style="width: 40%; height: 20px;"></div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;

        debounceTimer = setTimeout(() => {
            fetch(`/Menshubprime/api/live-search.php?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    loader.style.display = 'none';
                    icon.style.display = 'block';
                    renderResults(data, q);
                    saveToHistory(q);
                })
                .catch(err => {
                    console.error("Search failed", err);
                    loader.style.display = 'none';
                    icon.style.display = 'block';
                });
        }, 400);
    });

    function renderResults(data, query) {
        if (data.products.length === 0 && data.blogs.length === 0) {
            dynamicResults.innerHTML = `<div class="empty-app-state"><div class="empty-icon"><i class="fas fa-search-minus"></i></div><h2 class="empty-title">No Instant Matches</h2><p class="empty-sub">Press Enter to perform a deep search.</p></div>`;
            countBadge.innerText = '0 results';
            return;
        }

        let html = '';
        if (data.products.length > 0) {
            html += `<div class="results-status">🛍️ Live Matches <span></span></div><div class="app-grid">`;
            data.products.forEach(p => {
                html += `
                <div class="app-card" style="animation: zoomIn 0.3s ease both;">
                    <a href="/Menshubprime/product/${p.slug}" style="text-decoration: none;">
                        <div class="card-img-wrap"><span class="card-badge">LIVE</span><img src="assets/images/${p.image}"></div>
                        <div class="card-body">
                            <h3 class="card-title">${p.title}</h3>
                            <div class="card-footer"><span class="card-price">₹${p.price}</span><div class="card-btn"><i class="fas fa-arrow-right"></i></div></div>
                        </div>
                    </a>
                </div>`;
            });
            html += `</div>`;
        }

        if (data.blogs.length > 0) {
            html += `<div class="results-status" style="margin-top:30px">📰 Related Guides <span></span></div><div class="app-list">`;
            data.blogs.forEach(b => {
                html += `
                <a href="/Menshubprime/blog/${b.slug}" style="text-decoration: none;">
                    <div class="app-list-item" style="animation: slideInRight 0.3s ease both;">
                        <div class="list-img"><img src="assets/images/${b.image}"></div>
                        <div class="list-info">
                            <h3 class="list-title">${b.title}</h3>
                            <div class="list-meta">Featured Guide &bull; Instant Result</div>
                        </div>
                    </div>
                </a>`;
            });
            html += `</div>`;
        }

        dynamicResults.innerHTML = html;
        mainTitle.innerHTML = `Searching for <span style="color:var(--app-accent)">"${query}"</span>`;
        countBadge.innerText = (data.products.length + data.blogs.length) + '+ matches';
    }
});
</script>

<style>
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}
</style>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
