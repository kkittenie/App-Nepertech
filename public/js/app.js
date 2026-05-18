// ==================== CURSOR ====================
(function initCursor() {
    if (window.innerWidth <= 768) return;
    const dot = document.getElementById("cursorDot");
    const ring = document.getElementById("cursorRing");
    if (!dot || !ring) return;
    let mouseX = window.innerWidth / 2,
        mouseY = window.innerHeight / 2;
    let ringX = mouseX,
        ringY = mouseY;
    document.addEventListener("mousemove", (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });
    function tick() {
        dot.style.transform = `translate(${mouseX}px,${mouseY}px) translate(-50%,-50%)`;
        ringX += (mouseX - ringX) * 0.1;
        ringY += (mouseY - ringY) * 0.1;
        ring.style.transform = `translate(${ringX}px,${ringY}px) translate(-50%,-50%)`;
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
    });
    observer.observe(document.body, { childList: true, subtree: true });
    document.addEventListener("mousedown", () => {
        document.body.classList.add("cursor-click");
        setTimeout(() => document.body.classList.remove("cursor-click"), 150);
    });
})();

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
            nextBtn.classList.toggle(
                "disabled",
                currentIdx >= cards.length - 1,
            );
        if (dotsWrap) {
            dotsWrap
                .querySelectorAll(".carousel-dot")
                .forEach((d, i) =>
                    d.classList.toggle("active", i === currentIdx),
                );
        }
        // Highlight active card
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
        // snap to nearest
        const dx = e.pageX - startX;
        if (Math.abs(dx) > 40) {
            goTo(dx < 0 ? currentIdx + 1 : currentIdx - 1);
        } else {
            goTo(currentIdx);
        }
    });

    // Touch swipe
    let touchStartX = 0;
    carousel.addEventListener(
        "touchstart",
        (e) => {
            touchStartX = e.touches[0].clientX;
        },
        { passive: true },
    );
    carousel.addEventListener(
        "touchend",
        (e) => {
            const dx = e.changedTouches[0].clientX - touchStartX;
            if (Math.abs(dx) > 40)
                goTo(dx < 0 ? currentIdx + 1 : currentIdx - 1);
        },
        { passive: true },
    );

    // Scroll sync
    carousel.addEventListener("scroll", syncFromScroll, { passive: true });

    // Keyboard
    carousel.addEventListener("keydown", (e) => {
        if (e.key === "ArrowLeft") goTo(currentIdx - 1);
        if (e.key === "ArrowRight") goTo(currentIdx + 1);
    });

    // Auto progress (pauses on hover)
    let autoInterval = setInterval(() => {
        const next = currentIdx + 1 < cards.length ? currentIdx + 1 : 0;
        goTo(next);
    }, 4500);
    const carouselSection = document.querySelector(".nilai-carousel-section");
    if (carouselSection) {
        carouselSection.addEventListener("mouseenter", () =>
            clearInterval(autoInterval),
        );
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

let step = 1;
function initMultiStep() {
    const steps = document.querySelectorAll(".step-form");
    const fill = document.querySelector(".progress-fill");
    function update() {
        steps.forEach((st, idx) =>
            st.classList.toggle("active-step", idx + 1 === step),
        );
        if (fill)
            fill.style.width = ((step - 1) / (steps.length - 1)) * 100 + "%";
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
            if (step === steps.length)
                alert("✅ Pendaftaran berhasil! Admin akan menghubungi Anda.");
            else nextStep();
        });
    }
    update();
}

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

window.addEventListener("scroll", () => {
    const navbar = document.getElementById("navbar");

    if (navbar) {
        navbar.classList.toggle("scrolled", window.scrollY > 30);
    }
});

document.addEventListener("DOMContentLoaded", () => {
    // ── Burger menu toggle ──
    const menuIcon = document.getElementById("menuIcon");
    const navLinks = document.getElementById("navLinks");

    if (menuIcon && navLinks) {
        menuIcon.addEventListener("click", () => {
            navLinks.classList.toggle("active");
            menuIcon.classList.toggle("active");
        });

        // Close menu when clicking a link
        navLinks.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", () => {
                navLinks.classList.remove("active");
                menuIcon.classList.remove("active");
            });
        });

        // Close menu when clicking outside
        document.addEventListener("click", (e) => {
            if (!navLinks.contains(e.target) && !menuIcon.contains(e.target)) {
                navLinks.classList.remove("active");
                menuIcon.classList.remove("active");
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    initRevealObserver();

    initStaggered();

    animateCounters();

    initNilaiCarousel();

    initMultiStep();

    // GALLERY LIGHTBOX
    document.querySelectorAll(".gallery-item").forEach((item) => {
        item.addEventListener("click", () => {
            const img = item.querySelector("img");

            if (img) {
                showLightbox(img.src);
            }
        });
    });
});
