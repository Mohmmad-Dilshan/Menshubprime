</main>

<footer class="prime-footer-v2">
  <div class="footer-container">
    <div class="footer-main-grid">
      <!-- Section 1: Brand -->
      <div class="footer-brand-col">
        <h2 class="footer-logo">MENSHUB <span class="accent">PRIME</span></h2>
        <p class="footer-tagline">Curating the finest deals and style guides for the modern Indian man. Join the elite club of smart shoppers.</p>
        <div class="footer-social-premium">
          <a href="https://www.facebook.com/share/1DGFK21wGf/" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/thezayanway/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://x.com/Thezayanway" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="https://t.me/thezayanway" target="_blank" aria-label="Telegram"><i class="fab fa-telegram-plane"></i></a>
        </div>
      </div>

      <!-- Section 2: Explore -->
      <div class="footer-links-col">
        <h3>Explore</h3>
        <div class="footer-nav-list">
          <a href="/about">About Us</a>
          <a href="/blog">Style Blog</a>
          <a href="/deals">Hot Deals</a>
          <a href="/collaboration">Work With Us</a>
        </div>
      </div>

      <!-- Section 3: Legal -->
      <div class="footer-links-col">
        <h3>Trust & Legal</h3>
        <div class="footer-nav-list">
          <a href="/privacy">Privacy Policy</a>
          <a href="/terms">Terms of Service</a>
          <a href="/affiliate">Affiliate Disclosure</a>
          <a href="/cookies">Cookies</a>
        </div>
      </div>

      <!-- Section 4: Support -->
      <div class="footer-links-col">
        <h3>Support</h3>
        <div class="footer-nav-list">
          <a href="/contact">Contact Us</a>
          <a href="/faq">Help Center</a>
          <a href="/sitemap">Sitemap</a>
          <a href="mailto:thezayanway@gmail.com">Email Us</a>
        </div>
      </div>
    </div>

    <!-- Bottom Strip -->
    <div class="footer-bottom-v2">
      <p class="copyright-v2">© 2026 <span class="accent">MensHub Prime</span>. All Rights Reserved.</p>
      <div class="footer-badges">
        <span class="badge-item"><i class="fas fa-shield-alt"></i> 100% Secure</span>
        <span class="badge-item"><i class="fas fa-check-circle"></i> Verified Deals</span>
      </div>
    </div>
  </div>
</footer>

<style>
/* ============================================
   PREMIUM FOOTER v2 - SYSTEM
   ============================================ */
.prime-footer-v2 { background: #020617; padding: 100px 0 40px; border-top: 1px solid rgba(255,255,255,0.05); position: relative; overflow: hidden; margin-top: auto; }
.footer-container { max-width: 1200px; margin: auto; padding: 0 20px; }

/* Sticky Footer Fix */
body { display: flex; flex-direction: column; min-height: 100vh; background: #0b1220; }
main#main-content { flex: 1 0 auto; }
footer { flex-shrink: 0; }


.footer-main-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 60px; margin-bottom: 80px; }

.footer-logo { font-size: 26px; font-weight: 900; color: #fff; margin-bottom: 25px; letter-spacing: -1px; }
.footer-logo .accent { color: #f97316; }
.footer-tagline { color: #94a3b8; font-size: 15px; line-height: 1.8; margin-bottom: 30px; max-width: 320px; }

.footer-social-premium { display: flex; gap: 15px; }
.footer-social-premium a { width: 45px; height: 45px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: 0.3s; }
.footer-social-premium a:hover { background: #f97316; border-color: #f97316; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(249,115,22,0.3); }

.footer-links-col h3 { font-size: 14px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 30px; }
.footer-nav-list { display: flex; flex-direction: column; gap: 18px; }
.footer-nav-list a { color: #94a3b8; text-decoration: none; font-size: 15px; font-weight: 600; transition: 0.3s; width: max-content; }
.footer-nav-list a:hover { color: #f97316; padding-left: 8px; }

.footer-bottom-v2 { border-top: 1px solid rgba(255,255,255,0.05); padding-top: 40px; display: flex; flex-direction: column; gap: 20px; align-items: center; text-align: center; }
.copyright-v2 { color: #94a3b8; font-size: 14px; margin: 0; }
.copyright-v2 .accent { color: #94a3b8; font-weight: 700; }

.footer-badges { display: flex; gap: 30px; }
.badge-item { font-size: 12px; font-weight: 800; color: #94a3b8; display: flex; align-items: center; gap: 8px; }
.badge-item i { color: #f97316; }

/* Mobile Optimized Layout */
@media (max-width: 768px) {
    .prime-footer-v2 { padding: 60px 0 120px; text-align: center; }
    .footer-main-grid { grid-template-columns: 1fr; gap: 50px; margin-bottom: 50px; }
    .footer-brand-col { display: flex; flex-direction: column; align-items: center; }
    .footer-tagline { max-width: 100%; font-size: 14px; }
    .footer-nav-list a { width: auto; font-size: 14px; }
    .footer-links-col h4 { margin-bottom: 20px; }
    .footer-bottom-v2 { flex-direction: column; gap: 25px; }
    .footer-badges { gap: 15px; }
}
</style>


<!-- Scroll To Top Button -->
<button id="topBtn" aria-label="Scroll to Top"><i class="fas fa-arrow-up"></i></button>

<style>
#topBtn {
  display: flex !important;
  opacity: 0;
  visibility: hidden;
  position: fixed;
  bottom: 25px; /* Default for Desktop */
  right: 25px;
  width: 50px;
  height: 50px;
  background: rgba(15, 23, 42, 0.8);
  backdrop-filter: blur(15px);
  -webkit-backdrop-filter: blur(15px);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.4), inset 0 0 10px rgba(255,255,255,0.05);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  z-index: 999998;
  transform: translateY(20px);
}

@media (max-width: 768px) {
  #topBtn {
    bottom: 100px; /* Offset for Mobile Bottom Nav */
  }
}

#topBtn.visible {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

#topBtn:hover {
  background: #fb923c;
  color: #020617;
  transform: scale(1.1) translateY(-5px);
  box-shadow: 0 15px 35px rgba(251, 146, 60, 0.4);
  border-color: #fb923c;
}

#topBtn i {
  transition: 0.3s;
}

#topBtn:hover i {
  transform: translateY(-2px);
}

#topBtn:active {
  transform: scale(0.9) translateY(0);
  background: #f97316;
  transition: 0.1s;
}
</style>

<script>
// Throttle function for scroll events
function throttle(func, limit) {
  let inThrottle;
  return function() {
    const args = arguments;
    const context = this;
    if (!inThrottle) {
      func.apply(context, args);
      inThrottle = true;
      setTimeout(() => inThrottle = false, limit);
    }
  }
}

let topBtn = document.getElementById("topBtn");

function handleScroll() {
  // Hide on custom pages like product (with hpSliderWrap), search, or checkout
  const isSearchPage = window.location.pathname.includes('/search');
  const isCheckoutPage = window.location.pathname.includes('/checkout');
  
  if (document.getElementById('hpSliderWrap') || isSearchPage || isCheckoutPage) {
    topBtn.classList.remove("visible");
    return;
  }

  if (window.pageYOffset > 300) {
    topBtn.classList.add("visible");
  } else {
    topBtn.classList.remove("visible");
  }
}

window.addEventListener("scroll", throttle(handleScroll, 100));

topBtn.onclick = function() {
  window.scrollTo({ top: 0, behavior: "smooth" });
};
</script>

<!-- <p class="footer-copy">
© 2026 TheZayanWay. All Rights Reserved.
</p> -->

</footer>

<!-- ===== PREMIUM TELEGRAM POPUP ===== -->
<div class="entry-popup" id="entryPopup">
  <div class="popup-backdrop" onclick="closeEntryPopup()"></div>
  <div class="popup-container">

    <button class="popup-close" onclick="closeEntryPopup()" aria-label="Close">
      <i class="fas fa-times"></i>
    </button>

    <div class="popup-icon-wrap">
      <div class="popup-tg-icon"><i class="fab fa-telegram-plane"></i></div>
      <span class="popup-badge">🔥 Limited Spots</span>
    </div>

    <h2 class="popup-title">Join Our VIP<br><span>Deals Club</span></h2>
    <p class="popup-sub">Get exclusive men's deals, viral products &amp; secret discounts before everyone else.</p>

    <div class="popup-proof">✅ 5,000+ Smart Shoppers Already Joined</div>

    <a href="https://t.me/thezayanway" target="_blank" rel="noopener" class="popup-telegram">
      <i class="fab fa-telegram-plane"></i> Join Telegram Now
    </a>

    <div class="popup-divider"><span>OR</span></div>

    <form method="post" action="subscribe.php" class="popup-form">
      <input type="email" name="email" placeholder="Enter email for updates" autocomplete="email" required>
      <button type="submit">Get Deals</button>
    </form>

    <p class="popup-skip" onclick="closeEntryPopup()">No thanks, I'll miss out</p>

  </div>
</div>
<!-- ===== ENTRY POPUP END ===== -->

<script>
(function(){
  var COOLDOWN_MS = 12 * 60 * 60 * 1000; // 12 hours

  function shouldShow() {
    var last = localStorage.getItem("popupTime");
    if (!last) return true;
    return (Date.now() - parseInt(last)) > COOLDOWN_MS;
  }

  function showPopup() {
    if (!document.getElementById("entryPopup")) return;
    document.getElementById("entryPopup").classList.add("active");
    localStorage.setItem("popupTime", Date.now());
    // Remove scroll/timer listeners after shown
    window.removeEventListener("scroll", onScroll);
    clearTimeout(fallbackTimer);
  }

  if (!shouldShow()) return; // Already shown recently — do nothing

  var shown = false;
  var fallbackTimer;

  function onScroll() {
    if (shown) return;
    var scrolled = window.scrollY || document.documentElement.scrollTop;
    var total = document.body.scrollHeight - window.innerHeight;
    if (total > 0 && scrolled / total > 0.30) { // 30% scrolled
      shown = true;
      showPopup();
    }
  }

  // Wait for loader to finish (loader runs ~3.4s), then set triggers
  setTimeout(function(){
    // Scroll trigger: shows when user scrolls 30% of the page
    window.addEventListener("scroll", onScroll, { passive: true });

    // Fallback: show after 12 seconds if user hasn't scrolled enough
    fallbackTimer = setTimeout(function(){
      if (!shown) {
        shown = true;
        showPopup();
      }
    }, 12000);
  }, 4000); // Wait 4s for loader to finish first
})();

// Global close function (called by popup button onclick)
function closeEntryPopup() {
  var popup = document.getElementById("entryPopup");
  if (popup) popup.classList.remove("active");
}
</script>
<!-- ===== PREMIUM BOTTOM NAVIGATION (Mobile Only) ===== -->
<?php if (($sys['mobile_app_mode'] ?? 0) == 1): ?>
<div class="bottom-nav">
  <a href="/" class="nav-item <?= ($current_page_name == 'index.php' || $current_page_name == 'home.php') ? 'active' : '' ?>">
    <i class="fas fa-home"></i>
    <span>Home</span>
  </a>
  <a href="/brands" class="nav-item <?= ($current_page_name == 'brands.php' || $current_page_name == 'brand-store.php') ? 'active' : '' ?>">
    <i class="fas fa-store"></i>
    <span>Stores</span>
  </a>
  <a href="/deals" class="nav-item <?= ($current_page_name == 'deals.php') ? 'active' : '' ?>">
    <i class="fas fa-bolt"></i>
    <span>Deals</span>
  </a>
  <a href="/categories" class="nav-item <?= ($current_page_name == 'categories.php') ? 'active' : '' ?>">
    <i class="fas fa-th-large"></i>
    <span>Categories</span>
  </a>
  <button class="nav-item menu-trigger" onclick="toggleMenu()" aria-label="Toggle Menu">
    <i class="fas fa-bars"></i>
    <span>Menu</span>
  </button>
</div>

<style>
.bottom-nav {
  display: none;
  position: fixed;
  bottom: 25px;
  left: 50%;
  transform: translateX(-50%);
  width: 92%;
  max-width: 500px;
  background: rgba(15, 23, 42, 0.8);
  backdrop-filter: blur(20px) saturate(180%);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 24px;
  height: 70px;
  z-index: 1000000;
  justify-content: space-around;
  align-items: center;
  box-shadow: 0 20px 40px rgba(0,0,0,0.4), inset 0 0 0 1px rgba(255,255,255,0.05);
  animation: slideUpNav 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Hide bottom nav while loader is active */
#site-loader:not(.hide) ~ .bottom-nav {
  display: none !important;
}

<?php if (($sys['hide_mobile_nav_on_menu'] ?? 0) == 1): ?>
/* Hide bottom nav when mobile menu or other overlays are open */
#mobileMenu.show ~ .bottom-nav,
#dealsSidebar.active ~ .bottom-nav,
#searchOverlay.active ~ .bottom-nav {
  display: none !important;
}
<?php endif; ?>

@keyframes slideUpNav {
  from { transform: translate(-50%, 100px); opacity: 0; }
  to { transform: translate(-50%, 0); opacity: 1; }
}

@media (max-width: 991px) {
  .bottom-nav { display: flex; }
  
  #topBtn {
    bottom: 110px !important;
    z-index: 999998 !important;
  }
  
  body.page-product #topBtn {
    bottom: 180px !important;
  }
}

.nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  color: #94a3b8;
  gap: 5px;
  flex: 1;
  transition: all 0.3s;
  cursor: pointer;
}

.nav-item i {
  font-size: 18px;
  transition: all 0.3s;
}

.nav-item span {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.nav-item.active {
  color: #fb923c;
}

.nav-item.active i {
  transform: translateY(-5px);
  text-shadow: 0 0 15px rgba(251, 146, 60, 0.5);
}

.nav-item:hover {
  color: #fff;
}
</style>
<?php endif; ?>

<!-- ===== MOBILE DEALS BAG POPUP ===== -->
<?php if (($sys['show_deals_bag'] ?? 0) == 1): ?>
<div class="deals-sidebar" id="dealsSidebar">
  <div class="sidebar-header">
    <h3><i class="fas fa-shopping-bag"></i> My Smart Bag</h3>
    <button class="close-sidebar" onclick="toggleDealsBag()" aria-label="Close Bag"><i class="fas fa-times"></i></button>
  </div>
  
  <div class="sidebar-info">
    <p>Exclusive men's gear curated for high-value shoppers.</p>
  </div>

  <div class="deals-grid">
    <?php
    $bag_items = mysqli_query($conn, "SELECT * FROM products WHERE in_deals_bag = 1 AND status = 'active' ORDER BY id DESC LIMIT 10");
    $delay = 0;
    if(mysqli_num_rows($bag_items) > 0):
      while($item = mysqli_fetch_assoc($bag_items)):
        $delay += 0.1;
    ?>
      <div class="deal-card" style="--d: <?= $delay ?>s">
        <div class="deal-badge"><i class="fas fa-bolt"></i> HOT</div>
        <div class="deal-img">
          <img src="/Menshubprime/assets/images/<?= $item['image']; ?>" alt="<?= htmlspecialchars($item['title']); ?>" loading="lazy">
        </div>
        <div class="deal-details">
          <h4><?= htmlspecialchars($item['title']); ?></h4>
          <div class="deal-footer">
            <span class="deal-price">₹<?= $item['price']; ?></span>
            <a href="<?= $item['affiliate_link']; ?>" target="_blank" class="deal-btn stretched-link">
              <i class="fas fa-external-link-alt"></i>
            </a>
          </div>
        </div>
      </div>
    <?php 
      endwhile;
    else:
      echo '<div class="empty-bag"><i class="fas fa-shopping-basket"></i><p>Bag is empty. Check back later!</p></div>';
    endif;
    ?>
  </div>
</div>
<?php endif; ?>

<script>
function toggleDealsBag() {
  const sidebar = document.getElementById('dealsSidebar');
  const overlay = document.querySelector('.overlay');
  if(!sidebar) return;
  
  sidebar.classList.toggle('active');
  const isActive = sidebar.classList.contains('active');
  document.body.style.overflow = isActive ? 'hidden' : 'auto';
  
  if(overlay) {
    if(isActive) overlay.classList.add('show');
    else if(!document.getElementById('mobileMenu').classList.contains('show')) overlay.classList.remove('show');
  }

  document.querySelectorAll(".mobile-sticky-bar, #topBtn").forEach(el => {
    el.style.opacity = isActive ? "0" : "1";
    el.style.pointerEvents = isActive ? "none" : "auto";
  });
}
</script>

<style>
/* ============================================
   QUICK-PEEK BOTTOM SHEET (App Style)
   ============================================ */
#prime-quick-peek {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 20000000;
    background: rgba(15, 23, 42, 0.98);
    backdrop-filter: blur(40px);
    -webkit-backdrop-filter: blur(40px);
    border-radius: 32px 32px 0 0;
    border: 1px solid rgba(255,255,255,0.1);
    transform: translateY(100%);
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    padding: 20px 20px 140px; /* Increased bottom padding for nav clearance */
    box-shadow: 0 -20px 50px rgba(0,0,0,0.6);
    display: none;
    box-sizing: border-box;
}
@media (max-width: 991px) { #prime-quick-peek { display: block; } }

#prime-quick-peek.active { transform: translateY(0); }

.peek-handle { width: 50px; height: 4px; background: rgba(255,255,255,0.25); border-radius: 10px; margin: 0 auto 25px; cursor: pointer; }

.peek-content { display: flex; gap: 15px; align-items: center; width: 100%; }
.peek-img { width: 90px; height: 90px; border-radius: 16px; object-fit: cover; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.1); }
.peek-info { flex: 1; min-width: 0; }
.peek-title { color: #fff; font-size: 15px; font-weight: 800; margin: 0 0 4px; line-height: 1.3; word-break: break-word; }
.peek-price { color: #fb923c; font-size: 19px; font-weight: 900; }

.peek-btns { display: flex; gap: 10px; margin-top: 25px; width: 100%; }
.peek-btn-primary { 
    flex: 1; background: #fb923c; color: #000; padding: 15px 10px; border-radius: 16px; 
    text-align: center; text-decoration: none; font-weight: 800; font-size: 13px;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.peek-btn-outline { 
    flex: 1; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; 
    padding: 15px 10px; border-radius: 16px; text-align: center; text-decoration: none; 
    font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: center;
}

#peek-overlay { 
    position: fixed; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); 
    z-index: 19999999; opacity: 0; visibility: hidden; transition: 0.3s;
}
#peek-overlay.active { opacity: 1; visibility: visible; }

/* Loader Inside Peek */
.peek-loading { display: flex; align-items:center; justify-content:center; padding: 40px 0; color: #fb923c; }

/* QUICK PEEK BUTTON ON IMAGE (GLOBAL) */
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
    transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    opacity: 0;
    transform: translateY(10px);
    z-index: 10;
}

/* Show on hover for desktop, always visible or on tap for mobile cards */
.app-card:hover .card-peek-btn, .prime-product-card:hover .card-peek-btn {
    opacity: 1;
    transform: translateY(0);
}

.card-peek-btn:hover { background: #fb923c; color: #000; }

@media (max-width: 991px) {
    .card-peek-btn { opacity: 1; transform: translateY(0); width: 32px; height: 32px; }
}

/* ============================================
   GLOBAL HAPTIC FEEDBACK (App Touch Response)
   ============================================ */
.btn, .prime-grab-btn, .grab-pill, .card-btn, .all-btn, .cat-btn, .peek-btn-primary, .peek-btn-outline, 
.mobile-search-btn, .mobile-bag-btn, .app-card, .deal-card, .cv-card, .popular-card, .nav-item, 
.category-pill, .p-pill {
    transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    -webkit-tap-highlight-color: transparent;
}

.btn:active, .prime-grab-btn:active, .grab-pill:active, .card-btn:active, .all-btn:active, 
.cat-btn:active, .peek-btn-primary:active, .peek-btn-outline:active, .mobile-search-btn:active, 
.mobile-bag-btn:active, .app-card:active, .deal-card:active, .cv-card:active, .popular-card:active, 
.nav-item:active, .category-pill:active, .p-pill:active {
    transform: scale(0.94);
}

/* ============================================
   SKELETON LOADERS (The Speed Hack)
   ============================================ */
.skeleton {
    background: linear-gradient(90deg, rgba(255,255,255,0.03) 25%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 75%);
    background-size: 200% 100%;
    animation: skeleton-pulse 1.5s infinite linear;
    border-radius: 12px;
}

@keyframes skeleton-pulse {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.skeleton-box { width: 100%; height: 20px; margin-bottom: 10px; }
.skeleton-img-lg { width: 100%; height: 160px; border-radius: 24px; margin-bottom: 20px; }
.skeleton-circle { width: 40px; height: 40px; border-radius: 50%; }
.skeleton-btn { height: 45px; border-radius: 16px; margin-top: 20px; }
</style>

<!-- QUICK PEEK STRUCTURE -->
<div id="peek-overlay" onclick="closeQuickPeek()"></div>
<div id="prime-quick-peek">
    <div class="peek-handle" onclick="closeQuickPeek()"></div>
    <div id="peek-dynamic-body">
        <!-- Data injected here -->
    </div>
</div>

<script>
function openQuickPeek(slug) {
    const sheet = document.getElementById('prime-quick-peek');
    const overlay = document.getElementById('peek-overlay');
    const body = document.getElementById('peek-dynamic-body');

    sheet.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';

    // Show Skeleton Loader for premium feel
    body.innerHTML = `
        <div style="display: flex; gap: 15px; align-items: center;">
            <div class="skeleton" style="width: 90px; height: 90px; border-radius: 16px; flex-shrink: 0;"></div>
            <div style="flex: 1;">
                <div class="skeleton" style="width: 80%; height: 16px; margin-bottom: 8px;"></div>
                <div class="skeleton" style="width: 40%; height: 20px;"></div>
            </div>
        </div>
        <div style="margin-top: 25px;">
            <div class="skeleton" style="width: 30%; height: 10px; margin-bottom: 12px;"></div>
            <div class="skeleton" style="width: 100%; height: 45px; border-radius: 14px; margin-bottom: 8px;"></div>
            <div class="skeleton" style="width: 100%; height: 45px; border-radius: 14px; margin-bottom: 8px;"></div>
        </div>
        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <div class="skeleton" style="flex: 1; height: 50px; border-radius: 16px;"></div>
            <div class="skeleton" style="flex: 1; height: 50px; border-radius: 16px;"></div>
        </div>
    `;

    fetch(`/api/quick-peek.php?slug=${slug}`)
        .then(res => res.json())
        .then(data => {
            if(data.error) {
                body.innerHTML = `<p style="color:#fff; text-align:center;">${data.error}</p>`;
                return;
            }
            let compsHtml = '';
            data.comparisons.forEach(c => {
                if(c.price) {
                    compsHtml += `
                        <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.04); padding: 8px 12px; border-radius: 12px; margin-bottom: 8px; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <img src="assets/images/${c.icon}" style="width: 20px; height: 20px; object-fit: contain;">
                                <span style="color: #fff; font-size: 13px; font-weight: 700;">${c.name}</span>
                            </div>
                            <div style="color: #fb923c; font-size: 14px; font-weight: 900;">₹${c.price}</div>
                        </div>
                    `;
                }
            });

            body.innerHTML = `
                <div class="peek-content">
                    <img src="assets/images/${data.image}" class="peek-img">
                    <div class="peek-info">
                        <div style="color: #64748b; font-size: 10px; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">${data.category}</div>
                        <h3 class="peek-title">${data.title}</h3>
                        <div class="peek-price">₹${data.price}</div>
                    </div>
                </div>
                
                <div style="margin-top: 20px;">
                    <div style="color: #64748b; font-size: 10px; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px;">Live Comparisons</div>
                    ${compsHtml}
                </div>

                <div class="peek-btns">
                    <a href="${data.affiliate_link}" target="_blank" class="peek-btn-primary">Buy Now <i class="fas fa-bolt"></i></a>
                    <a href="${data.link}" class="peek-btn-outline">Full Review</a>
                </div>
            `;
        });
}

function closeQuickPeek() {
    document.getElementById('prime-quick-peek').classList.remove('active');
    document.getElementById('peek-overlay').classList.remove('active');
    document.body.style.overflow = 'auto';
}
</script>

<script src="assets/js/mobile-app.js?v=1.0" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isMobile = window.innerWidth <= 991;
    const curtain = document.getElementById('prime-lx-curtain');
    if (!curtain || !isMobile) return;

    // 1. Initial Reveal (On Page Load)
    if (sessionStorage.getItem('prime-lx-active')) {
        curtain.style.transform = 'translateY(0)';
        curtain.style.transition = 'none';
        
        // Force reflow
        curtain.offsetHeight;
        
        curtain.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
        curtain.style.transform = 'translateY(100%)';
        sessionStorage.removeItem('prime-lx-active');
    }

    // 2. Intercept Links for Outbound Transition
    document.querySelectorAll('a').forEach(link => {
        const href = link.getAttribute('href');
        if (!href || 
            href.startsWith('http') || 
            href.startsWith('#') || 
            link.getAttribute('target') === '_blank' ||
            link.getAttribute('download') !== null ||
            !href.startsWith('/')) {
            return;
        }

        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetUrl = this.href;

            // Trigger Curtain
            curtain.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
            curtain.style.transform = 'translateY(0)';
            sessionStorage.setItem('prime-lx-active', '1');

            setTimeout(() => {
                window.location.href = targetUrl;
            }, 600);
        });
    });

    // 3. FIX: Back Button / BFcache Issue
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            curtain.style.transition = 'none';
            curtain.style.transform = 'translateY(-100%)';
            sessionStorage.removeItem('prime-lx-active');
        }
    });

    // 4. Smart Scroll Progress Tracking
    const progressBar = document.getElementById('prime-scroll-progress');
    if (progressBar) {
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progressBar.style.width = scrolled + "%";
        }, { passive: true });
    }
    
    // SMART INTEREST TRACKING (PERSONALIZATION)
    const urlPath = window.location.pathname;
    const searchParams = new URLSearchParams(window.location.search);
    let currentInterest = '';
    
    if(urlPath.includes('/category/')) {
        currentInterest = urlPath.split('/category/')[1].split('/')[0];
    } else if(urlPath.includes('/product/')) {
        // We might need to fetch the category from the UI or just wait for the user to visit category
        // For now, if we are on a categories page we track it.
    }
    
    if(currentInterest) {
        let interests = JSON.parse(localStorage.getItem('mh_interests') || '[]');
        if(!interests.includes(currentInterest)) {
            interests.unshift(currentInterest);
            interests = interests.slice(0, 3);
            localStorage.setItem('mh_interests', JSON.stringify(interests));
        }
    }
});
</script>

<?php
// FOMO DATA
$fomoQ = mysqli_query($conn, "SELECT title, image FROM products WHERE status='active' ORDER BY RAND() LIMIT 10");
$fItems = [];
if($fomoQ) { while($f = mysqli_fetch_assoc($fomoQ)) { $fItems[] = $f; } }
?>

<div id="prime-fomo-toast">
    <img src="" class="fomo-img" id="f-img" alt="Purchased">
    <div class="fomo-content">
        <span class="fomo-user" id="f-user">User from City</span>
        <div class="fomo-title" id="f-product">Just grabbed a deal!</div>
        <span class="fomo-time" id="f-time">Just now</span>
    </div>
</div>

<style>
#prime-fomo-toast {
    position: fixed; bottom: <?= (($sys['mobile_app_mode'] ?? 0) == 1) ? '125px' : '40px'; ?>;
    left: 20px; z-index: 150000; background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px;
    padding: 12px 18px; display: flex; align-items: center; gap: 15px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.6); transform: translateY(200%) scale(0.8);
    opacity: 0; transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    max-width: 330px; pointer-events: none;
}
#prime-fomo-toast.active { transform: translateY(0) scale(1); opacity: 1; pointer-events: auto; }
.fomo-img { width: 45px; height: 45px; border-radius: 12px; object-fit: cover; flex-shrink: 0; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
.fomo-content { flex: 1; min-width: 0; }
.fomo-user { color: #fb923c; font-size: 10px; font-weight: 800; text-transform: uppercase; display: block; margin-bottom: 2px; }
.fomo-title { 
    color: #fff; 
    font-size: 12px; 
    font-weight: 700; 
    line-height: 1.3; 
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.fomo-time { color: #64748b; font-size: 9px; margin-top: 4px; display: block; }

@media (max-width: 768px) {
    #prime-fomo-toast { left: 12px; right: 12px; max-width: none; bottom: 105px; gap: 10px; padding: 10px 12px; }
    .fomo-title { font-size: 11px; }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const toast = document.getElementById('prime-fomo-toast');
    const items = <?= json_encode($fItems); ?>;
    const names = ["Aaryan", "Vihaan", "Ishaan", "Sai", "Arjun", "Kabir", "Rohan", "Siddharth", "Nitesh", "Zayan", "Rahul", "Sameer", "Aditya"];
    const cities = ["Delhi", "Mumbai", "Bangalore", "Pune", "Jaipur", "Ahmedabad", "Lucknow", "Hyderabad", "Chandigarh", "Kolkata"];
    
    if (!items || items.length === 0) return;

    function runFomo() {
        const p = items[Math.floor(Math.random() * items.length)];
        const n = names[Math.floor(Math.random() * names.length)];
        const c = cities[Math.floor(Math.random() * cities.length)];
        document.getElementById('f-img').src = "assets/images/" + p.image;
        document.getElementById('f-user').innerText = `${n} from ${c}`;
        document.getElementById('f-product').innerText = `Just grabbed ${p.title}!`;
        document.getElementById('f-time').innerText = `🔥 Purchased ${Math.floor(Math.random() * 8) + 1}m ago`;
        toast.classList.add('active');
        setTimeout(() => toast.classList.remove('active'), 6000);
    }
    setTimeout(() => {
        runFomo();
        setInterval(() => {
            const extraWait = Math.floor(Math.random() * 8000); // More frequent
            setTimeout(runFomo, extraWait);
        }, 25000); // Show every 25 seconds
    }, 4000); // Start after 4 seconds
});
</script>

<div id="prime-pull-refresh">
    <div class="pull-ring">
        <div class="pull-mascot"><i class="fas fa-heart"></i></div>
    </div>
    <span class="pull-label">Pull to Refresh</span>
</div>

<style>
#prime-pull-refresh {
    position: fixed; top: 0; left: 0; width: 100%; height: 110px;
    display: flex; flex-direction: column; justify-content: center; align-items: center;
    z-index: 200000; pointer-events: none; transform: translateY(-110%);
    transition: transform 0.15s cubic-bezier(0.165, 0.84, 0.44, 1);
    gap: 10px; opacity: 0;
}
.pull-ring {
    width: 55px; height: 55px; background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.25); border-radius: 50%;
    display: flex; justify-content: center; align-items: center;
    box-shadow: 0 15px 35px rgba(0,0,0,0.6);
}
.pull-mascot { color: #fb923c; font-size: 22px; transition: transform 0.1s linear; }
.pull-label { color: #fff; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; opacity: 0.7; }
.pull-refreshing .pull-mascot { animation: pull-spin 0.8s infinite linear; }
@keyframes pull-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

<script>
(function() {
    let startY = 0; let pulling = false;
    const refreshUI = document.getElementById('prime-pull-refresh');
    const mascot = refreshUI.querySelector('.pull-mascot');
    const label = refreshUI.querySelector('.pull-label');

    function start(y) {
        if (window.scrollY <= 1) { startY = y; pulling = true; refreshUI.style.opacity = '1'; }
    }

    function move(y) {
        if (!pulling || window.scrollY > 5) return;
        const diff = y - startY;
        if (diff > 0) {
            const dist = Math.min(diff * 0.4, 90);
            refreshUI.style.transform = `translateY(${dist - 110}px)`;
            mascot.style.transform = `rotate(${dist * 5}deg) scale(${0.5 + (dist/90)})`;
            label.innerText = dist > 65 ? "Release to Refresh" : "Pull to Refresh";
            label.style.color = dist > 65 ? "#fb923c" : "#fff";
        }
    }

    function end(y) {
        if (!pulling) return; pulling = false;
        const diff = y - startY;
        const dist = Math.min(diff * 0.4, 90);
        if (dist >= 65) {
            refreshUI.classList.add('pull-refreshing');
            refreshUI.style.transform = `translateY(20px)`;
            label.innerText = "Refreshing...";
            setTimeout(() => { location.reload(); }, 900);
        } else {
            refreshUI.style.transform = `translateY(-110%)`;
            refreshUI.style.opacity = '0';
        }
    }

    window.addEventListener('touchstart', e => start(e.touches[0].pageY), {passive:true});
    window.addEventListener('touchmove', e => move(e.touches[0].pageY), {passive:true});
    window.addEventListener('touchend', e => end(e.changedTouches[0].pageY));
    
    // Desktop Mouse Fallback for testing
    window.addEventListener('mousedown', e => start(e.pageY));
    window.addEventListener('mousemove', e => move(e.pageY));
    window.addEventListener('mouseup', e => end(e.pageY));
})();

// ============================================
// HAPTIC REWARD SYSTEM (Confetti + Success Toast)
// ============================================
function triggerConfetti(e) {
    const parent = document.body;
    const colors = ['#fb923c', '#f97316', '#fff', '#38bdf8', '#fbbf24', '#f87171'];
    const x = e.clientX || (e.touches && e.touches[0].clientX);
    const y = e.clientY || (e.touches && e.touches[0].clientY);

    if(!x || !y) return;

    // TRIGGER INTENSE PARTICLES (30 Particles)
    for (let i = 0; i < 30; i++) {
        const p = document.createElement('div');
        const size = Math.random() * 8 + 3;
        const color = colors[Math.floor(Math.random() * colors.length)];
        
        p.style.cssText = `
            position: fixed; left: ${x}px; top: ${y}px;
            width: ${size}px; height: ${size}px;
            background: ${color}; border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
            z-index: 300000; pointer-events: none;
            transform: translate(-50%, -50%);
        `;
        parent.appendChild(p);

        const angle = Math.random() * Math.PI * 2;
        const velocity = Math.random() * 120 + 60; // Increased velocity
        const vx = Math.cos(angle) * velocity;
        const vy = Math.sin(angle) * velocity - 60; // Bigger pop up

        p.animate([
            { transform: 'translate(-50%, -50%) scale(1) rotate(0deg)', opacity: 1 },
            { transform: `translate(calc(-50% + ${vx}px), calc(-50% + ${vy + 180}px)) scale(0) rotate(${Math.random() * 360}deg)`, opacity: 0 }
        ], {
            duration: 900 + Math.random() * 500,
            easing: 'cubic-bezier(0.1, 0.8, 0.3, 1)',
            fill: 'forwards'
        }).onfinish = () => p.remove();
    }
}

// Global Tap/Click Reward (Confetti everywhere)
document.addEventListener('click', (e) => triggerConfetti(e));

// SCROLL/TOUCH TRAIL EFFECT
let lastMoveX = 0;
let lastMoveY = 0;

function handleMove(e) {
    const x = e.clientX || (e.touches && e.touches[0].clientX);
    const y = e.clientY || (e.touches && e.touches[0].clientY);
    
    // Check distance to avoid too many particles
    const dist = Math.hypot(x - lastMoveX, y - lastMoveY);
    if (dist > 25) {
        lastMoveX = x;
        lastMoveY = y;
        triggerConfettiSmall({ clientX: x, clientY: y });
    }
}

window.addEventListener('mousemove', handleMove, { passive: true });
window.addEventListener('touchmove', handleMove, { passive: true });

function triggerConfettiSmall(e) {
    const parent = document.body;
    const colors = ['#fb923c', '#f97316', '#fff', '#38bdf8', '#fbbf24'];
    const x = e.clientX;
    const y = e.clientY;

    if(!x || !y) return;

    // Trigger many particles (12 per move step)
    for (let i = 0; i < 12; i++) {
        const p = document.createElement('div');
        const size = Math.random() * 6 + 2;
        const color = colors[Math.floor(Math.random() * colors.length)];
        p.style.cssText = `position:fixed; left:${x}px; top:${y}px; width:${size}px; height:${size}px; background:${color}; border-radius:50%; z-index:300000; pointer-events:none; transform:translate(-50%,-50%);`;
        parent.appendChild(p);

        const angle = Math.random() * Math.PI * 2;
        const velocity = Math.random() * 70 + 30;
        const vx = Math.cos(angle) * velocity;
        const vy = Math.sin(angle) * velocity;

        p.animate([
            { transform: 'translate(-50%, -50%) scale(1)', opacity: 1 },
            { transform: `translate(calc(-50% + ${vx}px), calc(-50% + ${vy + 120}px)) scale(0)`, opacity: 0 }
        ], { duration: 700 + Math.random() * 400, easing: 'ease-out', fill: 'forwards' }).onfinish = () => p.remove();
    }
}
</script>

<style>
@keyframes prime-float-up {
    0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0; }
    20% { transform: translate(-50%, -100%) scale(1.1); opacity: 1; }
    100% { transform: translate(-50%, -200%) scale(1); opacity: 0; }
}
</style>

<script>
// Global Tap/Click Reward (Confetti everywhere)
document.addEventListener('click', function(e) {
    // Har jagah confetti burst hoga
    triggerConfetti(e);
});
</script>
</body></html>