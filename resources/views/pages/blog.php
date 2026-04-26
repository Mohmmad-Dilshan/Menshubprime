<?php
// MENS HUB PRIME - Global Media Standard (V29 - Professional List)
if (!defined('ROOT_PATH')) {
    require_once __DIR__ . '/../../../src/bootstrap.php';
}

include_once ROOT_PATH . '/includes/header.php';

// Prepare Data
$q = mysqli_query($conn, "SELECT * FROM blogs WHERE status='active' ORDER BY id DESC");
$blog_count = ($q) ? mysqli_num_rows($q) : 0;
?>

<style>
:root { 
    --m-accent: #f97316; 
    --m-bg: #020617;
    --m-card: rgba(15, 23, 42, 0.4);
    --m-border: rgba(255, 255, 255, 0.08);
}

.media-hub-v29 { background: var(--m-bg); min-height: 100vh; font-family: 'Outfit', sans-serif; color: #fff; padding-bottom: 100px; }
.desktop-hidden { display: none; }

@media (max-width: 768px) {
    .desktop-hidden { display: flex; }
}

/* SIGNATURE HUB HERO */
.media-header { 
    height: 60vh; min-height: 500px; width: 100%; position: relative; 
    display: flex; align-items: center; justify-content: center; text-align: center;
    background: url('https://images.unsplash.com/photo-1491336477066-31156b5e4f35?w=1600&q=80') no-repeat center/cover;
    margin-bottom: 80px; overflow: hidden;
}
.media-header::after {
    content: ''; position: absolute; inset: 0; 
    background: linear-gradient(to bottom, rgba(2, 6, 23, 0.4), var(--m-bg));
    z-index: 1;
}

/* HERO RADIANT GLOWS */
.hero-glow-v29 {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; pointer-events: none;
    background: radial-gradient(circle at 10% 20%, rgba(249, 115, 22, 0.15), transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(37, 99, 235, 0.1), transparent 40%);
}

.hero-glass-v29 {
    position: relative; z-index: 3; max-width: 900px; padding: 60px;
    background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.08); border-radius: 50px;
    box-shadow: 0 40px 100px rgba(0,0,0,0.5);
}

.breadcrumb-v29 { 
    font-size: 11px; font-weight: 1000; color: var(--m-accent); text-transform: uppercase; 
    letter-spacing: 5px; margin-bottom: 25px; display: block; 
}

.media-header h1 { 
    font-size: clamp(40px, 10vw, 85px); font-weight: 1000; line-height: 0.85; 
    text-transform: uppercase; letter-spacing: -6px; color: #fff;
    filter: drop-shadow(0 0 20px rgba(0,0,0,0.5));
}
.media-header h1 span { color: var(--m-accent); }

.media-header p { 
    color: #94a3b8; font-size: 14px; font-weight: 800; text-transform: uppercase; 
    letter-spacing: 6px; margin-top: 25px; 
}

/* MAIN CONTENT WITH SIDEBAR */
.media-container { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 350px; gap: 60px; padding: 0 20px; }

/* LIST ITEMS */
.post-list { display: flex; flex-direction: column; gap: 50px; }
.post-item { display: grid; grid-template-columns: 380px 1fr; gap: 50px; text-decoration: none; transition: 0.3s; }
.post-img { width: 100%; aspect-ratio: 16/9; border-radius: 24px; overflow: hidden; border: 1px solid var(--m-border); position: relative; }
.post-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s cubic-bezier(0.19, 1, 0.22, 1); filter: brightness(0.8); }
.post-item:hover .post-img img { transform: scale(1.05); filter: brightness(1); }

.post-body h3 { font-size: 20px; font-weight: 400; color: #fff; margin-bottom: 15px; line-height: 1.25; transition: 0.3s; }
.post-item:hover .post-body h3 { color: var(--m-accent); }
.post-meta { display: flex; align-items: center; gap: 15px; font-size: 11px; font-weight: 1000; color: #64748b; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px; }
.post-body p { color: #94a3b8; font-size: 15px; line-height: 1.7; margin-bottom: 25px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.read-link { font-size: 12px; font-weight: 1000; color: #fff; display: flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 1px; }

/* SIDEBAR */
.media-sidebar { position: sticky; top: 100px; height: fit-content; }
.sb-box { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 25px; padding: 30px; margin-bottom: 40px; }
.sb-box h4 { font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px; color: var(--m-accent); }

.sb-search { background: rgba(255,255,255,0.03); border: 1px solid var(--m-border); border-radius: 12px; display: flex; align-items: center; padding: 0 15px; margin-bottom: 10px; }
.sb-search input { background: transparent; border: none; padding: 12px; width: 100%; outline: none; color: #fff; font-size: 14px; }

.tr-item { display: flex; gap: 15px; margin-bottom: 20px; text-decoration: none; align-items: center; }
.tr-num { font-size: 24px; font-weight: 1000; color: rgba(255,255,255,0.05); }
.tr-info h5 { font-size: 14px; font-weight: 800; color: #fff; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

.sb-join { text-align: center; }
.sb-join p { font-size: 13px; color: #94a3b8; margin-bottom: 20px; }
.sb-join input { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid var(--m-border); background: rgba(255,255,255,0.02); color: #fff; margin-bottom: 10px; }
.sb-join button { width: 100%; padding: 12px; border-radius: 10px; background: var(--m-accent); color: #000; border: none; font-weight: 900; text-transform: uppercase; cursor: pointer; }

@media (max-width: 400px) {
    .media-container { padding: 0 8px; }
    .post-list { gap: 8px; }
    .post-body { padding: 12px !important; }
    .post-body h3 { font-size: 13px; line-height: 1.2; }
    .app-header-v33 h2 { font-size: 32px; }
    .app-switcher-v32 { margin: 10px; }
    .app-switcher-v32 a { font-size: 9px; padding: 8px; }
}

@media (max-width: 1024px) { 
    .media-container { grid-template-columns: 1fr; gap: 40px; } 
    .media-sidebar { display: none; }
}

@media (max-width: 768px) { 
    .media-header { display: none; } 
    
    .blog-v29 { padding-top: 0; }

    /* MOBILE NATIVE APP COVER (V35) */
    .app-header-v33 {
        height: 60vh; min-height: 420px; width: 100%; position: relative; 
        display: flex; align-items: flex-end; justify-content: center; text-align: center;
        background: url('https://images.unsplash.com/photo-1491336477066-31156b5e4f35?w=800&q=80') no-repeat center/cover;
        margin-bottom: 25px; border-radius: 0 0 40px 40px; overflow: hidden;
    }
    .app-header-v33::after {
        content: ''; position: absolute; inset: 0; 
        background: linear-gradient(to bottom, rgba(2, 6, 23, 0.2), #010413);
        z-index: 1;
    }
    .app-hero-glow {
        position: absolute; inset: 0; z-index: 2;
        background: radial-gradient(circle at 10% 20%, rgba(249, 115, 22, 0.2), transparent 50%);
    }

    .app-glass-card {
        position: relative; z-index: 3; width: 100%; margin: 20px; padding: 40px 20px;
        background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(40px);
        border: 1px solid rgba(255,255,255,0.1); border-radius: 35px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.8);
    }
    
    .app-header-v33 .app-date { display: block; font-size: 10px; font-weight: 1000; color: var(--m-accent); letter-spacing: 4px; margin-bottom: 15px; text-transform: uppercase; }
    .app-header-v33 h2 { font-size: 44px; font-weight: 1000; letter-spacing: -3px; margin: 0; line-height: 0.9; text-transform: uppercase; }
    .app-header-v33 h2 span { color: var(--m-accent); }
    .app-header-v33 p { color: #64748b; font-size: 11px; margin-top: 15px; font-weight: 800; text-transform: uppercase; letter-spacing: 3px; }

    /* NATIVE APP SEGMENTED CONTROL */
    .app-switcher-v32 {
        display: flex; background: rgba(255,255,255,0.05); padding: 5px; margin: 15px 20px;
        border-radius: 15px; border: 1px solid var(--m-border);
    }
    .app-switcher-v32 a {
        flex: 1; text-align: center; padding: 10px; border-radius: 12px;
        font-size: 11px; font-weight: 900; color: #64748b; text-decoration: none; text-transform: uppercase;
    }
    .app-switcher-v32 a.active { background: #fff; color: #000; }

    .media-container { padding: 0 12px; gap: 12px; display: block; }
    
    /* 2-COLUMN APP GRID */
    .post-list { 
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
        padding-bottom: 50px;
    }
    
    .post-item { 
        display: block; background: var(--m-card); border: 1px solid var(--m-border);
        border-radius: 20px; overflow: hidden; padding: 0 !important;
        transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .post-item:active { transform: scale(0.95); } /* Haptic tap feel */

    .post-img { 
        height: 180px; width: 100%; border-radius: 0; filter: brightness(0.9);
        grid-column: auto; /* Reset desktop styles */
    }
    
    .post-body { padding: 15px !important; position: relative; }
    .post-body .post-meta { margin-bottom: 10px; font-size: 8px; color: var(--m-accent); display: flex; justify-content: space-between; align-items: center; }
    
    /* INTERACTION BAR */
    .app-actions-v36 { 
        display: flex; align-items: center; gap: 20px; margin-top: 15px; 
        padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.05);
    }
    .action-unit { display: flex; align-items: center; gap: 8px; color: #64748b; font-size: 14px; font-weight: 800; cursor: pointer; }
    .action-unit i { font-size: 20px; transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .action-unit.active i { color: #f97316; }

    /* FLOATING APP BADGES */
    .app-float-btn {
        position: absolute; top: 15px; right: 15px; width: 38px; height: 38px;
        background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.15); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; z-index: 10;
        color: #fff; font-size: 16px; transition: 0.3s;
    }
    .app-float-btn.active { background: #fff; color: #000; border-color: #fff; }

    /* APP-STYLE SEARCH DOCK (V44) */
    .app-search-dock-v44 { padding: 5px 20px 15px; background: var(--m-bg); }
    .search-wrapper-v44 { 
        background: rgba(255,255,255,0.03); border: 1px solid var(--m-border);
        border-radius: 100px; padding: 10px 20px; display: flex; align-items: center; gap: 12px;
        transition: 0.3s;
    }
    .search-wrapper-v44:focus-within { background: rgba(255,255,255,0.08); border-color: var(--m-accent); }
    .search-wrapper-v44 i { color: #475569; font-size: 14px; }
    .search-wrapper-v44 input { 
        background: transparent; border: none; width: 100%; color: #fff; 
        font-size: 13px; font-weight: 800; outline: none; 
    }
    .search-wrapper-v44 input::placeholder { color: #475569; letter-spacing: 0.5px; text-transform: uppercase; font-size: 10px; }

    /* APP-STYLE STORY CIRCLES (V43) */
    .story-hub-v43 { 
        display: flex; gap: 15px; overflow-x: auto; scrollbar-width: none; 
        padding: 5px 20px 20px; background: var(--m-bg); border-bottom: 1px solid var(--m-border);
    }
    .story-hub-v43::-webkit-scrollbar { display: none; }
    .story-item-v43 { display: flex; flex-direction: column; align-items: center; gap: 8px; min-width: 75px; flex-shrink: 0; }
    .story-circle-v43 { 
        width: 70px; height: 70px; border-radius: 50%; padding: 3px; 
        background: linear-gradient(45deg, #f97316, #fb923c, #fef08a);
        position: relative; overflow: hidden;
    }
    .story-inner-v43 { width: 100%; height: 100%; border-radius: 50%; border: 3px solid var(--m-bg); overflow: hidden; }
    .story-inner-v43 img { width: 100%; height: 100%; object-fit: cover; }
    .story-item-v43 span { font-size: 10px; font-weight: 1000; text-transform: uppercase; color: #fff; letter-spacing: 0.5px; opacity: 0.8; }

    .views-count { font-size: 11px; font-weight: 1000; color: #475569; margin-left: auto; letter-spacing: 0.5px; }
    .views-count i { color: #f97316; margin-right: 4px; }
    .c-tag-v36 { 
        position: absolute; top: 15px; left: 15px; background: rgba(0,0,0,0.6); 
        backdrop-filter: blur(10px); padding: 6px 14px; border-radius: 100px;
        font-size: 9px; font-weight: 1000; text-transform: uppercase; letter-spacing: 1px;
        color: #fff; border: 1px solid rgba(255,255,255,0.1); z-index: 5;
    }
}

/* GLOBAL APP TOAST (V42) */
.app-toast-v37 {
    position: fixed; top: -100px; left: 50%; transform: translateX(-50%);
    background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(40px);
    border: 1px solid #f97316; color: #fff; padding: 14px 30px;
    border-radius: 100px; font-size: 13px; font-weight: 1000; z-index: 10000;
    box-shadow: 0 40px 80px rgba(0,0,0,0.8); transition: 0.6s cubic-bezier(0.19, 1, 0.22, 1);
    display: flex; align-items: center; gap: 12px; pointer-events: none;
}
.app-toast-v37.show { top: 40px; }

@media (min-width: 769px) { 
    /* PRECISION ALIGNMENT (V41) */
    .post-item:hover { transform: translateY(-8px); }
    .post-item:hover .app-float-btn { opacity: 1; transform: scale(1); }
    
    .app-float-btn { 
        position: absolute; top: 20px; right: 20px; 
        cursor: pointer; opacity: 0; transform: scale(0.7); 
        transition: 0.4s cubic-bezier(0.19, 1, 0.22, 1); 
        width: 48px; height: 48px; font-size: 20px; z-index: 20;
    }
    .app-float-btn:hover { background: #fff !important; color: #000 !important; }
    
    .c-tag-v36 { 
        position: absolute; top: 20px; left: 20px; background: #000; 
        padding: 10px 18px; border-radius: 5px; font-size: 10px; font-weight: 1000;
        letter-spacing: 2px; z-index: 15; pointer-events: none; border: 1px solid rgba(255,255,255,0.1);
    }

    .app-actions-v36 { 
        display: flex; align-items: center; gap: 30px; margin-top: auto; 
        padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);
    }
    .action-unit { display: flex; align-items: center; gap: 8px; color: #64748b; font-size: 13px; font-weight: 1000; cursor: pointer; transition: 0.3s; }
    .action-unit:hover { color: #fff; }
    .action-unit.active i { color: #f97316; }

    .views-count { margin-left: auto; font-size: 11px; font-weight: 1000; color: #475569; letter-spacing: 1px; }
    .desktop-only-v39 { display: block; color: #94a3b8; font-size: 15px; line-height: 1.6; margin-bottom: 20px; }
}

@media (max-width: 768px) {
    .desktop-only-v39 { display: none; }
}

/* DESKTOP SIDEBAR HIDDEN ON MOBILE APP BUT SHOW IN MEDIA CONTAINER IF NEEDED */
@media (min-width: 769px) { .app-switcher-v32 { display: none; } }
</style>

<!-- REAL-TIME TOAST -->
<div id="appToast" class="app-toast-v37">
    <i class="fas fa-check-circle" style="color:var(--m-accent);"></i>
    <span id="toastMsg">Action Successful</span>
</div>

<div class="media-hub-v29">
    
    <header class="media-header">
        <div class="hero-glow-v29"></div>
        <div class="hero-glass-v29">
            <span class="breadcrumb-v29">Editorial Hub / Curated Intelligence</span>
            <h1>The <span>Prime</span> Feed</h1>
            <p>Mastering Style • Tech Deals • Grooming Secrets</p>
        </div>
    </header>

    <!-- MOBILE ONLY APP COVER (V35) -->
    <div class="app-header-v33 desktop-hidden">
        <div class="app-hero-glow"></div>
        <div class="app-glass-card">
            <span class="app-date"><?php echo date('l, M d'); ?></span>
            <h2>Prime <span>Feed</span></h2>
            <p>Mastering Style & Tech Intelligence</p>
        </div>
    </div>

    <!-- MOBILE SEARCH DOCK (V44) -->
    <div class="app-search-dock-v44 desktop-hidden">
        <div class="search-wrapper-v44">
            <i class="fas fa-search"></i>
            <input type="text" id="appSearchInput" placeholder="Explore Intelligence Hub...">
        </div>
    </div>

    <!-- APP-STYLE TRENDING STORIES (Mobile Only V43) -->
    <div class="story-hub-v43 desktop-hidden">
        <?php 
        $story_q = mysqli_query($conn, "SELECT * FROM blogs WHERE status='active' ORDER BY id ASC LIMIT 6");
        while($st = mysqli_fetch_assoc($story_q)): ?>
            <a href="/blog/<?php echo $st['slug']; ?>" class="story-item-v43" style="text-decoration:none;">
                <div class="story-circle-v43">
                    <div class="story-inner-v43">
                        <img src="/assets/images/<?php echo $st['image']; ?>" onerror="this.src='https://images.unsplash.com/photo-1491336477066-31156b5e4f35?w=200&q=80'">
                    </div>
                </div>
                <span><?php echo substr($st['category'] ?? 'Trending', 0, 8); ?></span>
            </a>
        <?php endwhile; ?>
    </div>

    <!-- NATIVE APP SEGMENTED CONTROL (Mobile Focused) -->
    <div class="app-switcher-v32">
        <a href="javascript:void(0)" class="active" onclick="filterAppFeed('latest', this)">Latest</a>
        <a href="javascript:void(0)" onclick="filterAppFeed('trending', this)">Trending</a>
        <a href="javascript:void(0)" onclick="filterAppFeed('highlights', this)">Highlights</a>
    </div>

<script>
// NATIVE APP FEED ENGINE
function filterAppFeed(type, el) {
    const postsContainer = document.querySelector('.post-list');
    const allPosts = Array.from(document.querySelectorAll('.post-item'));
    
    // Update Switcher UI
    document.querySelectorAll('.app-switcher-v32 a').forEach(a => a.classList.remove('active'));
    el.classList.add('active');

    // Simple Animation
    postsContainer.style.opacity = '0.3';
    
    setTimeout(() => {
        if(type === 'latest') {
            // Restore original order (already sorted by ID desc in PHP)
            allPosts.forEach(p => p.style.display = 'block');
        } 
        else if(type === 'trending') {
            // Simulate Trending by shuffling
            allPosts.forEach(p => p.style.display = 'block');
            allPosts.sort(() => Math.random() - 0.5);
            allPosts.forEach(p => postsContainer.appendChild(p));
        }
        else if(type === 'highlights') {
            // Show only first 3 as highlights
            allPosts.forEach((p, i) => {
                p.style.display = (i < 3) ? 'block' : 'none';
            });
        }
        
        postsContainer.style.opacity = '1';
        if(window.navigator.vibrate) window.navigator.vibrate(5);
    }, 300);
}
</script>

    <div class="media-container">
        <!-- Main Post Feed -->
        <main class="post-list">
            <?php 
            $q = mysqli_query($conn, "SELECT * FROM blogs WHERE status='active' ORDER BY id DESC");
            while($blog = mysqli_fetch_assoc($q)): 
                $read_val = ceil(str_word_count(strip_tags($blog['content'] ?? '')) / 200);
                $mock_views = rand(100, 999) + 400 . " ." . rand(1, 9) . "k";
                $mock_likes = rand(400, 900);
                ?>
                <div class="post-item">
                    <div class="post-img">
                        <div class="c-tag-v36"><?php echo $blog['category'] ?? 'Lifestyle'; ?></div>
                        
                        <!-- FLOATING SAVE BUTTON (V38) -->
                        <div class="app-float-btn" onclick="toggleAppSave(this, '<?php echo $blog['id']; ?>')">
                            <i class="far fa-bookmark"></i>
                        </div>

                        <a href="/blog/<?php echo $blog['slug']; ?>">
                            <img loading="lazy" src="/assets/images/<?php echo $blog['image']; ?>" onerror="this.src='https://images.unsplash.com/photo-1491336477066-31156b5e4f35?w=600&q=80'">
                        </a>
                    </div>
                    
                    <div class="post-body">
                        <div class="post-meta">
                            <span><?php echo date('M d, Y', strtotime($blog['date'] ?? 'now')); ?> • <?php echo $read_val; ?> MIN</span>
                        </div>
                        <a href="/blog/<?php echo $blog['slug']; ?>" style="text-decoration:none;">
                            <h3><?php echo htmlspecialchars($blog['title']); ?></h3>
                            <p class="desktop-only-v39"><?php echo substr(strip_tags($blog['content'] ?? ''), 0, 200); ?>...</p>
                        </a>
                        
                        <!-- REAL-TIME INTERACTION HUB (V39) -->
                        <div class="app-actions-v36">
                            <div class="action-unit" onclick="toggleAppLike(this, '<?php echo $blog['id']; ?>')">
                                <i class="fas fa-heart"></i>
                                <span class="like-count"><?php echo $mock_likes; ?></span>
                            </div>
                            <div class="action-unit" onclick="triggerNativeShare('<?php echo htmlspecialchars($blog['title']); ?>', '/blog/<?php echo $blog['slug']; ?>')">
                                <i class="fas fa-share-alt"></i>
                            </div>
                            <span class="views-count"><i class="fas fa-eye"></i> <?php echo $mock_views; ?> views</span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

<script>
// NATIVE APP REALITY ENGINE (V38)
function toggleAppSave(el, id) {
    const isSaved = el.classList.toggle('active');
    const icon = el.querySelector('i');
    
    if(isSaved) {
        icon.className = 'fas fa-bookmark';
        showAppToast('Saved to your Library!', 'fa-bookmark');
    } else {
        icon.className = 'far fa-bookmark';
    }
    if(window.navigator.vibrate) window.navigator.vibrate(15);
}

function triggerNativeShare(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            text: 'Check this story on MensHub Prime',
            url: window.location.origin + url
        }).then(() => {
            showAppToast('Story Shared!', 'fa-check');
        }).catch((error) => console.log('Error sharing', error));
    } else {
        showAppToast('Link copied to clipboard!', 'fa-link');
    }
}

function toggleAppLike(el, id) {
    const isLiked = el.classList.toggle('active');
    const countEl = el.querySelector('.like-count');
    let count = parseInt(countEl.innerText);

    if (isLiked) {
        count++;
        showAppToast('Story Liked!', 'fa-heart');
        if(window.navigator.vibrate) window.navigator.vibrate(10);
    } else {
        count--;
    }
    
    countEl.innerText = count;
    el.querySelector('i').style.transform = 'scale(1.4)';
    setTimeout(() => el.querySelector('i').style.transform = 'scale(1)', 200);
}

function showAppToast(msg, icon) {
    const toast = document.getElementById('appToast');
    const msgEl = document.getElementById('toastMsg');
    const iconEl = toast.querySelector('i');

    msgEl.innerText = msg;
    iconEl.className = `fas ${icon}`;
    
    toast.classList.add('show');
    if(window.navigator.vibrate) window.navigator.vibrate([10, 30, 10]);

    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}

function filterAppFeed(type, el) {
    const postsContainer = document.querySelector('.post-list');
    const allPosts = Array.from(document.querySelectorAll('.post-item'));
    document.querySelectorAll('.app-switcher-v32 a').forEach(a => a.classList.remove('active'));
    el.classList.add('active');
    postsContainer.style.opacity = '0.3';
    setTimeout(() => {
        if(type === 'latest') allPosts.forEach(p => p.style.display = 'block');
        else if(type === 'trending') {
            allPosts.forEach(p => p.style.display = 'block');
            allPosts.sort(() => Math.random() - 0.5);
            allPosts.forEach(p => postsContainer.appendChild(p));
        }
        else if(type === 'highlights') {
            allPosts.forEach((p, i) => p.style.display = (i < 3) ? 'block' : 'none');
        }
        postsContainer.style.opacity = '1';
    }, 300);
}
// LIVE ACTIVITY SIMULATOR (DEMO ONLY)
setInterval(() => {
    const units = document.querySelectorAll('.action-unit i.fa-heart');
    if(units.length > 0) {
        const randIndex = Math.floor(Math.random() * units.length);
        const countSpan = units[randIndex].parentElement.querySelector('.like-count');
        if(countSpan) {
            let current = parseInt(countSpan.innerText);
            countSpan.innerText = current + 1;
            countSpan.style.color = '#f97316';
            setTimeout(() => countSpan.style.color = '', 1000);
        }
    }
}, 5000); 
</script>
        </main>

        <!-- Sidebar Utilites -->
        <aside class="media-sidebar">
            
            <div class="sb-box">
                <h4>Search Media</h4>
                <div class="sb-search">
                    <i class="fas fa-search" style="color:#475569"></i>
                    <input type="text" id="blogSearchInput" placeholder="Topics, brands...">
                </div>
            </div>

            <div class="sb-box">
                <h4>Trending Stories</h4>
                <?php 
                $trend_q = mysqli_query($conn, "SELECT title, slug FROM blogs WHERE status='active' ORDER BY id ASC LIMIT 5");
                $rank = 0;
                while($tr = mysqli_fetch_assoc($trend_q)): $rank++; ?>
                    <a href="/blog/<?php echo $tr['slug']; ?>" class="tr-item">
                        <span class="tr-num">0<?php echo $rank; ?></span>
                        <div class="tr-info">
                            <h5><?php echo htmlspecialchars($tr['title']); ?></h5>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

            <div class="sb-box sb-join">
                <h4>Join the Hub</h4>
                <p>Get the week's best shopping guides in your inbox.</p>
                <form id="blogSubscribeForm">
                    <input type="email" name="email" id="subEmail" placeholder="Your email address" required>
                    <button type="submit" id="subBtn">Subscribe Free</button>
                    <div id="subStatus" style="font-size:12px; margin-top:10px; font-weight:700;"></div>
                </form>
            </div>

<script>
// REAL-TIME AJAX SUBSCRIPTION
const subForm = document.getElementById('blogSubscribeForm');
if(subForm) {
    subForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('subEmail').value;
        const btn = document.getElementById('subBtn');
        const status = document.getElementById('subStatus');

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Joining...';

        const formData = new FormData();
        formData.append('email', email);

        fetch('/subscribe.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            status.style.color = '#22c55e';
            status.innerText = '✨ Welcome to the Prime Club!';
            btn.innerHTML = 'Subscribed!';
            subForm.reset();
        })
        .catch(error => {
            status.style.color = '#ef4444';
            status.innerText = 'Connection error. Try again.';
            btn.disabled = false;
            btn.innerHTML = 'Subscribe Free';
        });
    });
}
</script>

        </aside>

    </div>

</div>

<?php include_once ROOT_PATH . '/includes/footer.php'; ?>

<script>
// UNIFIED HUB SEARCH (DESKTOP & MOBILE)
const desktopSearch = document.getElementById('blogSearchInput');
const mobileSearch = document.getElementById('appSearchInput');
const posts = document.querySelectorAll('.post-item');

function handleSearch(e) {
    const query = e.target.value.toLowerCase();
    let found = 0;

    posts.forEach(post => {
        const titleBody = post.querySelector('h3') ? post.querySelector('h3').innerText.toLowerCase() : '';
        const descMatch = post.querySelector('.desktop-only-v39') ? post.querySelector('.desktop-only-v39').innerText.toLowerCase() : '';
        
        if(titleBody.includes(query) || descMatch.includes(query)) {
            post.style.display = window.innerWidth > 768 ? 'grid' : 'block';
            found++;
        } else {
            post.style.display = 'none';
        }
    });

    const noResult = document.getElementById('noResultsMessage');
    const postsList = document.querySelector('.post-list');
    if(found === 0) {
        if(!noResult) {
            const msg = document.createElement('h3');
            msg.id = 'noResultsMessage';
            msg.style.textAlign = 'center';
            msg.style.padding = '100px 0';
            msg.style.color = '#475569';
            msg.innerText = 'No core matches found for "' + e.target.value + '"';
            postsList.appendChild(msg);
        }
    } else if(noResult) {
        noResult.remove();
    }
}

if(desktopSearch) desktopSearch.addEventListener('input', handleSearch);
if(mobileSearch) mobileSearch.addEventListener('input', handleSearch);
</script>
