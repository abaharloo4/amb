import { HeroLatticeScene } from './scenes/hero/HeroLatticeScene';
import { HeroOrbitalScene } from './scenes/hero/HeroOrbitalScene';
import { HeroTerrainScene } from './scenes/hero/HeroTerrainScene';

export class HeroLab {
    constructor(container) {
        this.container = container;
        this.currentScene = null;
        this.currentDirection = 'A';
        this.currentTier = 'high';

        // Performance monitor
        this.fps = 60;
        this.frames = 0;
        this.prevTime = performance.now();

        this.startFpsMonitor();
    }

    startFpsMonitor() {
        const updateFps = () => {
            this.frames++;
            const time = performance.now();
            if (time >= this.prevTime + 1000) {
                this.fps = Math.round((this.frames * 1000) / (time - this.prevTime));
                this.frames = 0;
                this.prevTime = time;

                window.dispatchEvent(
                    new CustomEvent('amb:fps-updated', {
                        detail: {
                            fps: this.fps,
                            direction: this.currentDirection,
                            tier: this.currentTier,
                        },
                    })
                );
            }
            requestAnimationFrame(updateFps);
        };
        requestAnimationFrame(updateFps);
    }

    loadDirection(direction) {
        if (this.currentScene) {
            this.currentScene.dispose();
            this.currentScene = null;
        }

        this.currentDirection = direction;

        if (this.currentTier === 'static') {
            this.renderStaticFallback();
            return;
        }

        switch (direction) {
            case 'A':
                this.currentScene = new HeroLatticeScene(this.container, { tier: this.currentTier });
                break;
            case 'B':
                this.currentScene = new HeroOrbitalScene(this.container, { tier: this.currentTier });
                break;
            case 'C':
                this.currentScene = new HeroTerrainScene(this.container, { tier: this.currentTier });
                break;
            default:
                this.currentScene = new HeroLatticeScene(this.container, { tier: this.currentTier });
        }

        this.currentScene.init();
    }

    setQuality(tier) {
        this.currentTier = tier;
        if (tier === 'static') {
            if (this.currentScene) {
                this.currentScene.dispose();
                this.currentScene = null;
            }
            this.renderStaticFallback();
        } else {
            this.loadDirection(this.currentDirection);
        }
    }

    renderStaticFallback() {
        this.container.innerHTML = `
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-80 h-80 rounded-full bg-gradient-to-tr from-brand to-brand-accent opacity-20 blur-3xl animate-pulse"></div>
            </div>
        `;
    }

    destroy() {
        if (this.currentScene) {
            this.currentScene.dispose();
            this.currentScene = null;
        }
    }
}
