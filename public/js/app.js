// ==================== CURSOR ====================
(function initCursor() {
    if (window.innerWidth <= 768) return;
    const dot = document.getElementById("cursorDot");
    const ring = document.getElementById("cursorRing");
    const text = document.getElementById("cursorText");
    if (!dot || !ring) return;

    let mouseX = window.innerWidth / 2,
        mouseY = window.innerHeight / 2;
    let ringX = mouseX,
        ringY = mouseY;

    let activated = false;
    document.addEventListener("mousemove", (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        if (!activated) {
            activated = true;
            ringX = mouseX;
            ringY = mouseY;
            document.body.classList.add("cursor-active");
        }
    });

    function tick() {
        dot.style.transform = `translate(${mouseX}px,${mouseY}px) translate(-50%,-50%)`;
        ringX += (mouseX - ringX) * 0.14;
        ringY += (mouseY - ringY) * 0.14;
        ring.style.transform = `translate(${ringX}px,${ringY}px) translate(-50%,-50%)`;
        if (text) {
            text.style.transform = `translate(${ringX}px,${ringY}px) translate(-50%,-50%)`;
        }
        requestAnimationFrame(tick);
    }
    tick();

    const observer = new MutationObserver(() => {
        document
            .querySelectorAll("a,button,.btn,.card,.gallery-item,[data-page]")
            .forEach((el) => {
                if (!el.dataset.cursorBound) {
                    el.dataset.cursorBound = "1";
                    el.addEventListener("mouseenter", () =>
                        document.body.classList.add("cursor-hover"),
                    );
                    el.addEventListener("mouseleave", () =>
                        document.body.classList.remove("cursor-hover"),
                    );
                }
            });

        document.querySelectorAll(".produk-card, .project-card").forEach((el) => {
            if (!el.dataset.cursorBoundProject) {
                el.dataset.cursorBoundProject = "1";
                el.addEventListener("mouseenter", () => {
                    document.body.classList.add("cursor-hover-project");
                    if (text) text.classList.add("visible");
                });
                el.addEventListener("mouseleave", () => {
                    document.body.classList.remove("cursor-hover-project");
                    if (text) text.classList.remove("visible");
                });
            }
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });
    document.addEventListener("mousedown", () => {
        document.body.classList.add("cursor-click");
        setTimeout(() => document.body.classList.remove("cursor-click"), 150);
    });
})();

// ==================== LIGHTBOX ====================
function showLightbox(src) {
    let lb = document.getElementById("globalLightbox");
    if (!lb) {
        lb = document.createElement("div");
        lb.id = "globalLightbox";
        lb.style.cssText =
            "position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(5,8,16,.92);z-index:10000;display:none;align-items:center;justify-content:center;cursor:pointer;backdrop-filter:blur(12px);";
        lb.innerHTML =
            '<div><img id="lightboxImg" style="max-width:90vw;max-height:85vh;border-radius:20px;box-shadow:0 40px 80px rgba(0,0,0,.5);"></div>';
        document.body.appendChild(lb);
        lb.addEventListener("click", () => {
            lb.style.opacity = "0";
            setTimeout(() => (lb.style.display = "none"), 300);
        });
    }
    document.getElementById("lightboxImg").src = src;
    lb.style.display = "flex";
    lb.style.opacity = "0";
    lb.style.transition = "opacity .35s ease";
    requestAnimationFrame(() => (lb.style.opacity = "1"));
}

// ==================== COUNTERS ====================
function animateCounters() {
    document.querySelectorAll(".stat-number[data-target]").forEach((el) => {
        const target = parseFloat(el.dataset.target);
        const suffix = el.dataset.suffix || "";
        const prefix = el.dataset.prefix || "";
        const duration = 2000;
        const startTime = performance.now();
        function update(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            el.textContent = prefix + Math.floor(ease * target) + suffix;
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    });
}

// ==================== NILAI CAROUSEL ====================
function initNilaiCarousel() {
    const carousel = document.querySelector(".nilai-carousel-track");
    const prevBtn = document.querySelector(".carousel-btn-prev");
    const nextBtn = document.querySelector(".carousel-btn-next");
    const dotsWrap = document.querySelector(".carousel-dots");
    if (!carousel) return;

    const cards = Array.from(carousel.children);
    let currentIdx = 0;
    let isDragging = false;
    let startX = 0;
    let scrollStart = 0;

    // Build dots
    if (dotsWrap) {
        dotsWrap.innerHTML = "";
        cards.forEach((_, i) => {
            const dot = document.createElement("button");
            dot.className = "carousel-dot" + (i === 0 ? " active" : "");
            dot.setAttribute("aria-label", `Nilai ${i + 1}`);
            dot.addEventListener("click", () => goTo(i));
            dotsWrap.appendChild(dot);
        });
    }

    function getCardWidth() {
        if (!cards[0]) return 320;
        const style = window.getComputedStyle(carousel);
        const gap = parseFloat(style.gap) || 24;
        return cards[0].offsetWidth + gap;
    }

    function goTo(idx) {
        currentIdx = Math.max(0, Math.min(idx, cards.length - 1));
        const offset = currentIdx * getCardWidth();
        carousel.scrollTo({ left: offset, behavior: "smooth" });
        updateUI();
    }

    function updateUI() {
        if (prevBtn) prevBtn.classList.toggle("disabled", currentIdx === 0);
        if (nextBtn)
            nextBtn.classList.toggle("disabled", currentIdx >= cards.length - 1);
        if (dotsWrap) {
            dotsWrap
                .querySelectorAll(".carousel-dot")
                .forEach((d, i) => d.classList.toggle("active", i === currentIdx));
        }
        cards.forEach((c, i) => {
            c.classList.toggle("nilai-card-active", i === currentIdx);
        });
    }

    function syncFromScroll() {
        const cardW = getCardWidth();
        const nearest = Math.round(carousel.scrollLeft / cardW);
        if (nearest !== currentIdx) {
            currentIdx = Math.max(0, Math.min(nearest, cards.length - 1));
            updateUI();
        }
    }

    if (prevBtn) prevBtn.addEventListener("click", () => goTo(currentIdx - 1));
    if (nextBtn) nextBtn.addEventListener("click", () => goTo(currentIdx + 1));

    // Mouse drag
    carousel.addEventListener("mousedown", (e) => {
        isDragging = true;
        startX = e.pageX;
        scrollStart = carousel.scrollLeft;
        carousel.style.cursor = "grabbing";
        carousel.style.scrollSnapType = "none";
        e.preventDefault();
    });
    document.addEventListener("mousemove", (e) => {
        if (!isDragging) return;
        const dx = e.pageX - startX;
        carousel.scrollLeft = scrollStart - dx;
    });
    document.addEventListener("mouseup", (e) => {
        if (!isDragging) return;
        isDragging = false;
        carousel.style.cursor = "";
        carousel.style.scrollSnapType = "";
        const dx = e.pageX - startX;
        if (Math.abs(dx) > 40) {
            goTo(dx < 0 ? currentIdx + 1 : currentIdx - 1);
        } else {
            goTo(currentIdx);
        }
    });

    // Touch swipe
    let touchStartX = 0;
    carousel.addEventListener("touchstart", (e) => {
        touchStartX = e.touches[0].clientX;
    }, { passive: true });
    carousel.addEventListener("touchend", (e) => {
        const dx = e.changedTouches[0].clientX - touchStartX;
        if (Math.abs(dx) > 40) goTo(dx < 0 ? currentIdx + 1 : currentIdx - 1);
    }, { passive: true });

    carousel.addEventListener("scroll", syncFromScroll, { passive: true });

    carousel.addEventListener("keydown", (e) => {
        if (e.key === "ArrowLeft") goTo(currentIdx - 1);
        if (e.key === "ArrowRight") goTo(currentIdx + 1);
    });

    let autoInterval = setInterval(() => {
        const next = currentIdx + 1 < cards.length ? currentIdx + 1 : 0;
        goTo(next);
    }, 4500);
    const carouselSection = document.querySelector(".nilai-carousel-section");
    if (carouselSection) {
        carouselSection.addEventListener("mouseenter", () => clearInterval(autoInterval));
        carouselSection.addEventListener("mouseleave", () => {
            clearInterval(autoInterval);
            autoInterval = setInterval(() => {
                const next = currentIdx + 1 < cards.length ? currentIdx + 1 : 0;
                goTo(next);
            }, 4500);
        });
    }

    updateUI();
}

// ==================== MULTI-STEP FORM ====================
let step = 1;
function initMultiStep() {
    const steps = document.querySelectorAll(".step-form");
    const fill = document.querySelector(".progress-fill");
    function update() {
        steps.forEach((st, idx) => st.classList.toggle("active-step", idx + 1 === step));
        if (fill) fill.style.width = ((step - 1) / (steps.length - 1)) * 100 + "%";
    }
    window.nextStep = function () {
        if (step < steps.length) {
            step++;
            update();
        }
    };
    window.prevStep = function () {
        if (step > 1) {
            step--;
            update();
        }
    };
    const form = document.getElementById("regForm");
    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            if (step === steps.length) alert("✅ Pendaftaran berhasil! Admin akan menghubungi Anda.");
            else nextStep();
        });
    }
    update();
}

// ==================== REVEAL ====================
function initRevealObserver() {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: "0px 0px -40px 0px" },
    );
    document.querySelectorAll(".reveal").forEach((el) => observer.observe(el));
}

function initStaggered() {
    document.querySelectorAll(".stagger-children").forEach((parent) => {
        Array.from(parent.children).forEach((child, i) => {
            child.style.animationDelay = `${i * 0.1}s`;
        });
    });
}

// ==================== GSAP GLOBAL ANIMATIONS ====================
function initGSAPAnimations() {
    if (typeof gsap === 'undefined') return;
    gsap.registerPlugin(ScrollTrigger);

    // ── Beranda Hero ──
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        const cssAnimatedEls = heroSection.querySelectorAll(
            '.hero-accent-line, .hero-eyebrow, .hero-title, .hero-sub, .hero-buttons, .hero-stats, .hero-visual, .hero-scroll-hint'
        );
        cssAnimatedEls.forEach(el => {
            el.style.animation = 'none';
        });

        gsap.set(cssAnimatedEls, { opacity: 1 });

        const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });
        heroTl
            .fromTo('.hero-accent-line', { opacity: 0, scaleX: 0 }, { opacity: 1, scaleX: 1, duration: 0.6 }, 0.1)
            .fromTo('.hero-eyebrow', { opacity: 0, y: 28 }, { opacity: 1, y: 0, duration: 0.6 }, 0.2)
            .fromTo('.hero-title', { opacity: 0, y: 32 }, { opacity: 1, y: 0, duration: 0.85 }, 0.3)
            .fromTo('.hero-sub', { opacity: 0, y: 24 }, { opacity: 1, y: 0, duration: 0.7 }, 0.45)
            .fromTo('.hero-buttons', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.7 }, 0.55)
            .fromTo('.hero-stats', { opacity: 0, y: 24 }, { opacity: 1, y: 0, duration: 0.7 }, 0.7)
            .fromTo('.hero-visual', { opacity: 0, scale: 0.85 }, { opacity: 1, scale: 1, duration: 0.9 }, 0.3)
            .fromTo('.hero-scroll-hint', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.5 }, 1.0);
    }

    // ── Scroll-triggered reveals for all non-hero sections ──
    gsap.utils.toArray('section:not(.hero):not(.page-hero)').forEach(section => {
        const headers = section.querySelectorAll('.section-header, .section-tag');
        if (headers.length) {
            headers.forEach(h => h.classList.remove('reveal'));
            gsap.from(headers, {
                y: 40, opacity: 0, duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: section,
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });
        }

        const cards = section.querySelectorAll('.card, .card-program');
        if (cards.length) {
            cards.forEach(c => c.classList.remove('reveal'));
            gsap.from(cards, {
                y: 60, opacity: 0, duration: 0.7,
                stagger: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: section,
                    start: 'top 75%',
                    toggleActions: 'play none none none'
                }
            });
        }
    });

    // ── Page hero parallax ──
    const pageHeroBg = document.querySelector('.page-hero-bg');
    if (pageHeroBg) {
        gsap.to(pageHeroBg, {
            yPercent: 30,
            ease: 'none',
            scrollTrigger: {
                trigger: '.page-hero',
                start: 'top top',
                end: 'bottom top',
                scrub: 1.5
            }
        });
    }

    // ── Footer entrance ──
    const footer = document.querySelector('.footer');
    if (footer) {
        gsap.from('.footer-grid > *', {
            y: 30, opacity: 0, duration: 0.6,
            stagger: 0.08,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: footer,
                start: 'top 88%',
                toggleActions: 'play none none none'
            }
        });
    }

    // ── CTA section ──
    const ctaSection = document.querySelector('.cta-section');
    if (ctaSection) {
        gsap.from(ctaSection, {
            y: 40, opacity: 0, scale: 0.97,
            duration: 0.9,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: ctaSection,
                start: 'top 82%',
                toggleActions: 'play none none none'
            }
        });
    }

    // ── Gallery items ──
    gsap.utils.toArray('.gallery-item').forEach((item, i) => {
        gsap.from(item, {
            y: 40, opacity: 0, scale: 0.95,
            duration: 0.6,
            delay: (i % 4) * 0.08,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: item,
                start: 'top 88%',
                toggleActions: 'play none none none'
            }
        });
    });
}

// ==================== NAVBAR SCROLL ====================
window.addEventListener("scroll", () => {
    const navbar = document.getElementById("navbar");
    if (navbar) {
        navbar.classList.toggle("scrolled", window.scrollY > 30);
    }
}, { passive: true });

// ==================== DOM READY ====================
document.addEventListener("DOMContentLoaded", () => {
    // Burger menu
    const menuIcon = document.getElementById("menuIcon");
    const navLinks = document.getElementById("navLinks");

    if (menuIcon && navLinks) {
        menuIcon.addEventListener("click", () => {
            navLinks.classList.toggle("active");
            menuIcon.classList.toggle("active");
        });
        navLinks.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", () => {
                navLinks.classList.remove("active");
                menuIcon.classList.remove("active");
            });
        });
        document.addEventListener("click", (e) => {
            if (!navLinks.contains(e.target) && !menuIcon.contains(e.target)) {
                navLinks.classList.remove("active");
                menuIcon.classList.remove("active");
            }
        });
    }

    initRevealObserver();
    initStaggered();
    animateCounters();
    initNilaiCarousel();
    initMultiStep();
    initGSAPAnimations();

    // Gallery lightbox
    document.querySelectorAll(".gallery-item").forEach((item) => {
        item.addEventListener("click", () => {
            const img = item.querySelector("img");
            if (img) showLightbox(img.src);
        });
    });
});
