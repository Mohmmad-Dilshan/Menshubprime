/**
 * Mobile App Experience Logic
 * Haptic feedback simulation and UI enhancements
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Haptic Feedback for all interactive elements
    const hapticElements = document.querySelectorAll('a, button, .nav-item, .cat-card, .popular-card, .prime-grab-btn, .scifi-btn, .grab-pill');

    hapticElements.forEach(item => {
        item.addEventListener('click', () => {
            if ('vibrate' in navigator) {
                navigator.vibrate(10); // Subtle haptic tap
            }
        });
    });

    // 2. Smart Header (Hide/Show on Scroll)
    let lastScrollY = window.scrollY;
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', () => {
        if (window.innerWidth > 991) return; // Only for mobile/tablet

        const currentScrollY = window.scrollY;
        if (currentScrollY > 100) {
            if (currentScrollY > lastScrollY) {
                // Scrolling down - Hide Header
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up - Show Header
                navbar.style.transform = 'translateY(0)';
                navbar.style.background = 'rgba(15, 23, 42, 0.95)';
                navbar.style.backdropFilter = 'blur(20px)';
            }
        } else {
            navbar.style.transform = 'translateY(0)';
            navbar.style.background = 'transparent';
        }
        lastScrollY = currentScrollY;
    }, { passive: true });

    // 3. PWA Install Logic
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        console.log('PWA Ready');
    });
});

/**
 * Toggle Search Overlay
 */
function toggleSearch() {
    const overlay = document.getElementById('searchOverlay');
    if (!overlay) return;
    overlay.classList.toggle('active');
    const isActive = overlay.classList.contains('active');
    
    // Lock body scroll
    document.body.style.overflow = isActive ? 'hidden' : 'auto';
    
    // Focus input if active
    if (isActive) {
        const input = overlay.querySelector('input');
        if (input) {
            setTimeout(() => input.focus(), 300);
            initLiveSearch(input);
        }
    }
    
    // Hide floating elements cleanly
    document.querySelectorAll(".mobile-sticky-bar, #topBtn").forEach(el => {
        el.style.opacity = isActive ? "0" : "1";
        el.style.pointerEvents = isActive ? "none" : "auto";
    });
}

/**
 * LIVE SEARCH LOGIC
 */
let searchTimeout = null;
function initLiveSearch(input) {
    if (input.dataset.liveInit) return;
    input.dataset.liveInit = "true";

    const resultsBox = document.getElementById('liveSearchResults');

    input.addEventListener('input', (e) => {
        const q = e.target.value.trim();
        clearTimeout(searchTimeout);

        if (q.length < 2) {
            resultsBox.classList.remove('active');
            resultsBox.innerHTML = '';
            return;
        }

        searchTimeout = setTimeout(async () => {
            try {
                const response = await fetch(`/Menshubprime/api/live-search.php?q=${encodeURIComponent(q)}`);
                const data = await response.json();

                if (data.success && data.total > 0) {
                    let html = '';
                    
                    // Products
                    data.products.forEach(p => {
                        html += `
                            <a href="/Menshubprime/product/${p.slug}" class="live-item">
                                <img src="/Menshubprime/assets/images/${p.image}" class="live-img">
                                <div class="live-info">
                                    <p class="live-title">${p.title}</p>
                                    <span class="live-meta">₹${p.price}</span>
                                </div>
                            </a>
                        `;
                    });

                    // Blogs
                    data.blogs.forEach(b => {
                        html += `
                            <a href="/Menshubprime/blog/${b.slug}" class="live-item">
                                <img src="/Menshubprime/assets/images/${b.image}" class="live-img">
                                <div class="live-info">
                                    <p class="live-title">${b.title}</p>
                                    <span class="live-meta" style="color:#94a3b8">Article</span>
                                </div>
                            </a>
                        `;
                    });

                    resultsBox.innerHTML = html;
                    resultsBox.classList.add('active');
                } else {
                    resultsBox.innerHTML = `
                        <div class="live-no-result">
                            <i class="fas fa-search-minus"></i>
                            <p>No results found for "${q}"</p>
                        </div>
                    `;
                    resultsBox.classList.add('active');
                }
            } catch (err) {
                console.error("Search error:", err);
            }
        }, 300);
    });
}
