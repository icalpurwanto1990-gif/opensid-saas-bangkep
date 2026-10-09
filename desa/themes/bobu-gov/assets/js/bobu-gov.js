/**
 * Tema Bobu Modern Government (bobu-gov.js)
 * Script interaktif & efek portal resmi pemerintahan desa Bobu
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Menu Drawer Toggle
    const mobileMenuBtn = document.getElementById('govMobileMenuBtn');
    const mobileDrawer = document.getElementById('govMobileDrawer');
    const mobileOverlay = document.getElementById('govMobileOverlay');
    const mobileCloseBtn = document.getElementById('govMobileCloseBtn');

    function openMobileMenu() {
        if (mobileDrawer && mobileOverlay) {
            mobileDrawer.classList.remove('-translate-x-full');
            mobileOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobileMenu() {
        if (mobileDrawer && mobileOverlay) {
            mobileDrawer.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', openMobileMenu);
    }
    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', closeMobileMenu);
    }
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeMobileMenu);
    }

    // 2. Animated Counter for Village Stats
    const counters = document.querySelectorAll('.gov-counter');
    if (counters.length > 0) {
        const observerOptions = {
            threshold: 0.2
        };

        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target') || counter.innerText.replace(/[^0-9]/g, ''));
                    if (!isNaN(target) && target > 0) {
                        let count = 0;
                        const duration = 1500;
                        const stepTime = Math.max(Math.floor(duration / target), 20);
                        const stepIncrement = Math.max(Math.ceil(target / (duration / stepTime)), 1);

                        const timer = setInterval(() => {
                            count += stepIncrement;
                            if (count >= target) {
                                count = target;
                                clearInterval(timer);
                            }
                            counter.innerText = count.toLocaleString('id-ID');
                        }, stepTime);
                    }
                    observer.unobserve(counter);
                }
            });
        }, observerOptions);

        counters.forEach(counter => counterObserver.observe(counter));
    }

    // 3. Sticky Navbar Elevation on Scroll
    const navbar = document.querySelector('.gov-navbar-wrap');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 120) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
    }

    // 4. Quick Search Auto Focus
    const searchInputs = document.querySelectorAll('.gov-search-input');
    searchInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-emerald-500');
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-emerald-500');
        });
    });
});
