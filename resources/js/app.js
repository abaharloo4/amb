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

// Hero 3D Lab Alpine Component
Alpine.data('heroLab', () => ({
    lab: null,
    direction: 'Hybrid',
    tier: 'high',
    fps: 60,

    init() {
        const container = this.$refs.canvasContainer;
        if (container) {
            import('./three/HeroLab').then(({ HeroLab }) => {
                this.lab = new HeroLab(container);
                this.lab.loadDirection(this.direction);
            });

            window.addEventListener('amb:fps-updated', (e) => {
                this.fps = e.detail.fps;
            });
        }
    },

    setDirection(dir) {
        this.direction = dir;
        if (this.lab) this.lab.loadDirection(dir);
    },

    setTier(t) {
        this.tier = t;
        if (this.lab) this.lab.setQuality(t);
    },
}));

Alpine.start();

// Initialize GSAP presets on load
document.addEventListener('DOMContentLoaded', () => {
    scanMotion();
});
