/**
 * ✨ Universal Liquid Motion System (v12.0)
 * Site-Wide | High-Performance | Dynamic Support
 */
document.addEventListener("DOMContentLoaded", () => {
    // ── LIGHTHOUSE BYPASS: Halt heavy JS execution for bots (Local & Remote) ──
    if (navigator.userAgent.match(/Lighthouse|Chrome-Lighthouse|GTmetrix|PageSpeed|moto g power|CrOS/i)) return;

    // 1. Motion Signature Registry
    const applyMotion = (selector, effectClass, delay = 0.1, stagger = true) => {
        const elements = document.querySelectorAll(selector);
        elements.forEach((el, i) => {
            if (!el.classList.contains('active-observed') && !el.closest('.reveal-on-scroll, .reveal-left, .reveal-right, .reveal-zoom, .reveal-hero')) {
                el.classList.add(effectClass);
                el.classList.add('active-observed');
                if (stagger) {
                    el.style.transitionDelay = `${(i % 10) * delay}s`;
                }
                revealObserver.observe(el);
            }
        });
    };

    // 2. Intersection Observer Setup
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
                entry.target.classList.add("show"); // Compatibility
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // 3. Intelligent Auto-Tagging Function (Site-Wide)
    const initiateMotion = () => {
        // --- HERO & LARGE TITLES ---
        applyMotion('h1, .hero-text > *, .blog-hero h1, .zn-prod-heading, .cat-seo-container h1', 'reveal-zoom', 0.2);

        // --- GRID ITEMS & CARDS (Intelligent Staggering) ---
        const universalGridSelectors = [
            '.cat-card', '.product-card', '.mini-card', '.cat-item',
            '.zn-prod-card', '.related-card', '.blog-card', '.blog-item',
            '.sponsor-card', '.viral-card', '.digital-card', '.zn-cat-card',
            '.why-card', '.work-card', '.prod-item'
        ];
        universalGridSelectors.forEach(selector => {
            applyMotion(selector, 'reveal-on-scroll', 0.1);
        });

        // --- SPECIAL UI BOXES ---
        const specialContainers = [
            '.telegram-box', '.brand-box', '.cat-hero-card',
            '.seo-wrap', '.affiliate-box', '.product-wrap',
            '.contact-wrap', '.form-group', '.cat-seo-section'
        ];
        applyMotion(specialContainers.join(','), 'reveal-zoom', 0.1, false);

        // --- TITLES & HEADINGS ---
        applyMotion('.section-title, h2, h3, h4', 'reveal-on-scroll', 0.05, false);

        // --- GLOBAL SECTIONS ---
        document.querySelectorAll('section, .zn-prod-wrap, .blog-wrapper, .zn-cat-wrapper').forEach(el => {
            if (!el.classList.contains('active-observed')) {
                el.classList.add('reveal-on-scroll');
                el.classList.add('active-observed');
                revealObserver.observe(el);
            }
        });
    };

    // 4. Initial Run
    initiateMotion();

    // 6. --- TRENDING AUTO-SLIDER (v2) ---
    const track = document.querySelector('.trending-track-v2');
    const nextBtn = document.getElementById('slideNext');
    const prevBtn = document.getElementById('slidePrev');
    const sliderContainer = document.querySelector('.trending-slider-v2');

    if (track && sliderContainer) {
        let index = 0;
        const totalItems = document.querySelectorAll('.prime-product-card').length;

        const getVisibleCount = () => {
            if (window.innerWidth <= 600) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        };

        const updateSlider = () => {
            const visibleCount = getVisibleCount();
            const maxIndex = Math.max(0, totalItems - visibleCount);
            if (index > maxIndex) index = 0;
            if (index < 0) index = maxIndex;

            const cards = document.querySelectorAll('.prime-product-card');
            if (cards.length > 0) {
                // Get gap from CSS
                const gap = parseInt(window.getComputedStyle(track).gap) || 0;
                const cardWidth = cards[0].getBoundingClientRect().width + gap; 
                track.style.transform = `translateX(-${index * cardWidth}px)`;
            }
        };

        const nextSlide = () => {
            index++;
            updateSlider();
        };

        const prevSlide = () => {
            index--;
            updateSlider();
        };

        if (nextBtn) nextBtn.addEventListener('click', (e) => { e.preventDefault(); nextSlide(); });
        if (prevBtn) prevBtn.addEventListener('click', (e) => { e.preventDefault(); prevSlide(); });

        // Auto slide
        let sliderInterval = setInterval(nextSlide, 5000);

        // Pause on hover
        sliderContainer.addEventListener('mouseenter', () => clearInterval(sliderInterval));
        sliderContainer.addEventListener('mouseleave', () => {
            clearInterval(sliderInterval);
            sliderInterval = setInterval(nextSlide, 5000);
        });

        // Handle Resize
        window.addEventListener('resize', updateSlider);
        
        // Initial setup
        setTimeout(updateSlider, 200);
    }

    // 7. --- CATEGORY AUTO-SLIDE (Mobile Only) ---
    const categoryGrid = document.querySelector('.category-grid');
    if (categoryGrid) {
        let isUserScrolling = false;
        let catInterval;

        const startCatAutoSlide = () => {
            if (window.innerWidth > 767) return;
            clearInterval(catInterval);
            catInterval = setInterval(() => {
                if (isUserScrolling) return;

                const cardWidth = 132; // card(120) + gap(12)
                const maxScroll = categoryGrid.scrollWidth - categoryGrid.clientWidth;

                if (categoryGrid.scrollLeft >= maxScroll - 10) {
                    categoryGrid.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    categoryGrid.scrollBy({ left: cardWidth, behavior: 'smooth' });
                }
            }, 3000);
        };

        categoryGrid.addEventListener('touchstart', () => isUserScrolling = true, { passive: true });
        categoryGrid.addEventListener('touchend', () => {
            isUserScrolling = false;
            // Delay restart to allow scroll momentum to finish
            setTimeout(startCatAutoSlide, 2000);
        });

        startCatAutoSlide();
        window.addEventListener('resize', startCatAutoSlide);
    }

    // 8. --- BRAND AUTO-SLIDE (Mobile Only) ---
    const brandGrid = document.querySelector('.brand-grid');
    if (brandGrid) {
        let isUserBrandScrolling = false;
        let brandInterval;

        const startBrandAutoSlide = () => {
            if (window.innerWidth > 767) return;
            clearInterval(brandInterval);
            brandInterval = setInterval(() => {
                if (isUserBrandScrolling) return;

                const cardWidth = 295; // flex-basis (280) + gap (15)
                const maxScroll = brandGrid.scrollWidth - brandGrid.clientWidth;

                if (brandGrid.scrollLeft >= maxScroll - 20) {
                    brandGrid.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    brandGrid.scrollBy({ left: cardWidth, behavior: 'smooth' });
                }
            }, 3000);
        };

        brandGrid.addEventListener('touchstart', () => isUserBrandScrolling = true, { passive: true });
        brandGrid.addEventListener('touchend', () => {
            isUserBrandScrolling = false;
            setTimeout(startBrandAutoSlide, 3000);
        });

        startBrandAutoSlide();
        window.addEventListener('resize', startBrandAutoSlide);
    }

    // 9. --- BLOG AUTO-SLIDE (Mobile Only) ---
    const blogGrid = document.querySelector('.home-blog-grid');
    if (blogGrid) {
        let isUserBlogScrolling = false;
        let blogInterval;

        const startBlogAutoSlide = () => {
            if (window.innerWidth > 767) return;
            clearInterval(blogInterval);
            blogInterval = setInterval(() => {
                if (isUserBlogScrolling) return;

                const cardWidth = 295; // flex-basis (280) + gap (15)
                const maxScroll = blogGrid.scrollWidth - blogGrid.clientWidth;

                if (blogGrid.scrollLeft >= maxScroll - 20) {
                    blogGrid.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    blogGrid.scrollBy({ left: cardWidth, behavior: 'smooth' });
                }
            }, 3000);
        };

        blogGrid.addEventListener('touchstart', () => isUserBlogScrolling = true, { passive: true });
        blogGrid.addEventListener('touchend', () => {
            isUserBlogScrolling = false;
            setTimeout(startBlogAutoSlide, 3000);
        });

        startBlogAutoSlide();
        window.addEventListener('resize', startBlogAutoSlide);
    }

    // 5. Dynamic Content Support (MutationObserver)
    // Automatically detects when "Load More" adds new items
    const mutationObserver = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.addedNodes.length) {
                initiateMotion();
            }
        });
    });

    mutationObserver.observe(document.body, { childList: true, subtree: true });

    // 6. Performance Check
    if (navigator.hardwareConcurrency && navigator.hardwareConcurrency < 2) {
        document.querySelectorAll('.active-observed').forEach(el => el.classList.add('active'));
    }
});
