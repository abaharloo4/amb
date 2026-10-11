export class Visibility {
    constructor(element, onVisibilityChange) {
        this.element = element;
        this.onVisibilityChange = onVisibilityChange;
        this.isTabVisible = !document.hidden;
        this.isIntersecting = true;

        this.init();
    }

    init() {
        // Tab visibility
        document.addEventListener('visibilitychange', () => {
            this.isTabVisible = !document.hidden;
            this.notify();
        });

        // Viewport intersection
        if ('IntersectionObserver' in window && this.element) {
            this.observer = new IntersectionObserver((entries) => {
                for (const entry of entries) {
                    this.isIntersecting = entry.isIntersecting;
                    this.notify();
                }
            }, { threshold: 0.05 });

            this.observer.observe(this.element);
        }
    }

    notify() {
        const canRender = this.isTabVisible && this.isIntersecting;
        if (this.onVisibilityChange) {
            this.onVisibilityChange(canRender);
        }
    }

    destroy() {
        if (this.observer) {
            this.observer.disconnect();
            this.observer = null;
        }
    }
}
