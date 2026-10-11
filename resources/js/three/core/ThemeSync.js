import gsap from 'gsap';

export class ThemeSync {
    constructor(onThemeChange) {
        this.onThemeChange = onThemeChange;
        this.observer = null;
        this.currentTokens = this.readTokens();

        this.init();
    }

    readTokens() {
        const style = getComputedStyle(document.documentElement);
        return {
            bg: style.getPropertyValue('--scene-bg').trim() || '#1F1F1F',
            structure: style.getPropertyValue('--scene-structure').trim() || '#18424E',
            line: style.getPropertyValue('--scene-line').trim() || '#29665F',
            particle: style.getPropertyValue('--scene-particle').trim() || '#F49D07',
            glow: style.getPropertyValue('--scene-glow').trim() || 'rgba(244,157,7,0.3)',
        };
    }

    init() {
        this.observer = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                    const newTokens = this.readTokens();
                    this.currentTokens = newTokens;
                    if (this.onThemeChange) {
                        this.onThemeChange(newTokens);
                    }
                }
            }
        });

        this.observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-theme'],
        });

        window.addEventListener('amb:theme-changed', () => {
            const newTokens = this.readTokens();
            this.currentTokens = newTokens;
            if (this.onThemeChange) {
                this.onThemeChange(newTokens);
            }
        });
    }

    destroy() {
        if (this.observer) {
            this.observer.disconnect();
            this.observer = null;
        }
    }
}
