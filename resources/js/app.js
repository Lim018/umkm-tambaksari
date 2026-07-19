import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Fade-in on scroll (stagger per grup) — IntersectionObserver.
function setupReveal() {
    const els = Array.from(document.querySelectorAll('[data-reveal]'));
    if (!('IntersectionObserver' in window)) {
        els.forEach((e) => e.classList.add('shown'));
        return;
    }
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((en) => {
                if (!en.isIntersecting) return;
                const el = en.target;
                const sibs = Array.from(
                    el.parentElement.querySelectorAll(':scope > [data-reveal]')
                );
                const idx = Math.max(0, sibs.indexOf(el));
                el.style.transitionDelay = idx * 55 + 'ms';
                el.classList.add('shown');
                io.unobserve(el);
            });
        },
        { threshold: 0.08, rootMargin: '0px 0px -40px 0px' }
    );
    els.forEach((e) => io.observe(e));
}

document.addEventListener('DOMContentLoaded', setupReveal);
