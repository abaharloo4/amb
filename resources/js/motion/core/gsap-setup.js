import gsap from 'gsap';

export const isReducedMotion = () => {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
};

export const isRTL = () => {
    return document.documentElement.dir === 'rtl' || document.documentElement.getAttribute('dir') === 'rtl';
};

export const presets = {
    reveal: (element, options = {}) => {
        if (isReducedMotion()) {
            element.style.opacity = '1';
            return;
        }

        const delay = options.delay || 0;
        const duration = options.duration || 0.6;
        const yOffset = options.y !== undefined ? options.y : 24;

        gsap.fromTo(
            element,
            { opacity: 0, y: yOffset },
            {
                opacity: 1,
                y: 0,
                duration,
                delay,
                ease: 'power3.out',
                clearProps: 'transform',
            }
        );
    },

    stagger: (container, options = {}) => {
        if (isReducedMotion()) return;

        const children = container.querySelectorAll(options.selector || ':scope > *');
        if (!children.length) return;

        gsap.fromTo(
            children,
            { opacity: 0, y: 16 },
            {
                opacity: 1,
                y: 0,
                duration: 0.5,
                stagger: options.stagger || 0.08,
                ease: 'power2.out',
                clearProps: 'transform',
            }
        );
    },

    counter: (element, options = {}) => {
        const target = parseFloat(element.getAttribute('data-counter-target') || element.textContent || 0);
        if (isNaN(target)) return;

        if (isReducedMotion()) {
            element.textContent = target.toLocaleString(isRTL() ? 'fa-IR' : 'en-US');
            return;
        }

        const obj = { val: 0 };
        gsap.to(obj, {
            val: target,
            duration: options.duration || 1.5,
            ease: 'power2.out',
            onUpdate: () => {
                const rounded = Math.floor(obj.val);
                element.textContent = rounded.toLocaleString(isRTL() ? 'fa-IR' : 'en-US');
            },
        });
    },

    scrollReveal: (element, options = {}) => {
        if (isReducedMotion()) {
            element.style.opacity = '1';
            return;
        }

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    presets.reveal(entry.target, options);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: options.threshold || 0.15 });

        observer.observe(element);
    },

    cardHover: (element) => {
        if (isReducedMotion()) return;

        element.addEventListener('mousemove', (e) => {
            const rect = element.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;

            gsap.to(element, {
                rotateY: x * 8,
                rotateX: -y * 8,
                transformPerspective: 800,
                duration: 0.3,
                ease: 'power1.out',
            });
        });

        element.addEventListener('mouseleave', () => {
            gsap.to(element, {
                rotateY: 0,
                rotateX: 0,
                duration: 0.5,
                ease: 'power2.out',
            });
        });
    },
};

export const scanMotion = (root = document) => {
    if (isReducedMotion()) return;

    const elements = root.querySelectorAll('[data-motion]');
    elements.forEach((el) => {
        const type = el.getAttribute('data-motion');
        if (presets[type]) {
            presets[type](el);
        }
    });
};

export default gsap;
