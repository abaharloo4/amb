import './bootstrap';
import Alpine from 'alpinejs';
import { scanMotion } from './motion/core/gsap-setup';

window.Alpine = Alpine;

// Theme Controller Store
Alpine.store('theme', {
    current: document.documentElement.getAttribute('data-theme') || 'light',

    init() {
        const saved = localStorage.getItem('amb_theme');
        if (saved) {
            this.setTheme(saved);
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            this.setTheme('dark');
        }
    },

    toggle() {
        const next = this.current === 'dark' ? 'light' : 'dark';
        this.setTheme(next);
    },

    setTheme(theme) {
        this.current = theme;
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.classList.toggle('dark', theme === 'dark');
        localStorage.setItem('amb_theme', theme);
        window.dispatchEvent(new CustomEvent('amb:theme-changed', { detail: { theme } }));
    },
});

// Direction Controller Store
Alpine.store('locale', {
    dir: document.documentElement.getAttribute('dir') || 'rtl',
    lang: document.documentElement.getAttribute('lang') || 'fa',

    toggle() {
        const nextLang = this.lang === 'fa' ? 'en' : 'fa';
        const nextDir = nextLang === 'fa' ? 'rtl' : 'ltr';
        this.lang = nextLang;
        this.dir = nextDir;
        document.documentElement.setAttribute('dir', nextDir);
        document.documentElement.setAttribute('lang', nextLang);
        window.dispatchEvent(new CustomEvent('amb:dir-changed', { detail: { dir: nextDir, lang: nextLang } }));
    },
});

// Hero 3D Lab non-reactive instance (prevents Alpine reactivity proxy on Three.js objects)
let activeHeroLab = null;

Alpine.data('heroLab', () => ({
    direction: 'Hybrid',
    tier: 'high',
    fps: 60,

    init() {
        const container = this.$refs.canvasContainer;
        if (container) {
            import('./three/HeroLab').then(({ HeroLab }) => {
                if (activeHeroLab) {
                    activeHeroLab.destroy();
                }
                activeHeroLab = new HeroLab(container);
                activeHeroLab.loadDirection(this.direction);
            });

            window.addEventListener('amb:fps-updated', (e) => {
                this.fps = e.detail.fps;
            });
        }
    },

    setDirection(dir) {
        this.direction = dir;
        if (activeHeroLab) {
            activeHeroLab.loadDirection(dir);
        }
    },

    setTier(t) {
        this.tier = t;
        if (activeHeroLab) {
            activeHeroLab.setQuality(t);
        }
    },
}));

// Export Hero Hybrid runner for landing page
window.initHeroHybrid = async function(container, onFps) {
    if (!container) return;
    try {
        const { HeroHybridScene } = await import('./three/scenes/hero/HeroHybridScene.js');
        const scene = new HeroHybridScene(container);
        scene.init();

        // FPS calculation using ticker
        if (onFps) {
            let frames = 0;
            let prevTime = performance.now();
            const fpsTicker = () => {
                frames++;
                const time = performance.now();
                if (time >= prevTime + 1000) {
                    const fps = Math.round((frames * 1000) / (time - prevTime));
                    frames = 0;
                    prevTime = time;
                    onFps(fps);
                }
                if (!scene.isDisposed) {
                    requestAnimationFrame(fpsTicker);
                }
            };
            requestAnimationFrame(fpsTicker);
        }

        return scene;
    } catch (err) {
        console.warn('Hero Hybrid 3D scene initialization error:', err);
    }
};

Alpine.start();

// Initialize GSAP presets on load
document.addEventListener('DOMContentLoaded', () => {
    scanMotion();
});
