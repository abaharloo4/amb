import * as THREE from 'three';
import gsap from 'gsap';
import { RendererManager } from './RendererManager';
import { Pointer } from './Pointer';
import { Visibility } from './Visibility';
import { ThemeSync } from './ThemeSync';
import { Dispose } from './Dispose';
import { Capability } from './Capability';

export class SceneBase {
    constructor(container, options = {}) {
        this.container = container;
        this.options = options;
        this.tier = options.tier || Capability.getTier();

        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.pointer = null;
        this.visibility = null;
        this.themeSync = null;

        this.isRunning = false;
        this.isDisposed = false;
        this.clock = new THREE.Clock();

        this.onResizeBound = this.resize.bind(this);
    }

    init() {
        if (!Capability.isWebGLAvailable() || this.tier === 'static') {
            this.renderStaticFallback();
            return;
        }

        // Setup Three.js Core
        this.scene = new THREE.Scene();
        const width = this.container.clientWidth || window.innerWidth;
        const height = this.container.clientHeight || window.innerHeight;

        this.camera = new THREE.PerspectiveCamera(60, width / height, 0.1, 1000);
        this.camera.position.z = 25;

        const maxDpr = this.tier === 'high' ? 2 : this.tier === 'medium' ? 1.5 : 1;
        this.renderer = RendererManager.create(this.container, {
            antialias: this.tier !== 'low',
            maxDpr,
        });

        // Utilities
        this.pointer = new Pointer(this.container);
        this.visibility = new Visibility(this.container, (canRender) => {
            if (canRender) {
                this.resume();
            } else {
                this.pause();
            }
        });

        this.themeSync = new ThemeSync((tokens) => this.setTheme(tokens));

        window.addEventListener('resize', this.onResizeBound, { passive: true });

        // Build Scene Content (Implemented in subclasses)
        this.buildScene();

        // Apply Initial Theme
        this.setTheme(this.themeSync.currentTokens);

        this.resume();
    }

    buildScene() {
        // Abstract method to be overridden by subclasses
    }

    renderStaticFallback() {
        // Fallback placeholder when WebGL is unavailable or reduced-motion is active
        if (this.container) {
            this.container.innerHTML = `
                <div class="absolute inset-0 flex items-center justify-center opacity-20 pointer-events-none">
                    <div class="w-96 h-96 rounded-full bg-gradient-to-tr from-brand-primary to-brand-accent blur-3xl"></div>
                </div>
            `;
        }
    }

    resize() {
        if (this.isDisposed || !this.renderer) return;
        RendererManager.resize(this.renderer, this.camera, this.container);
    }

    update(dt, elapsed) {
        // Abstract method to be overridden by subclasses
    }

    render() {
        if (!this.isRunning || this.isDisposed) return;

        const dt = this.clock.getDelta();
        const elapsed = this.clock.getElapsedTime();

        if (this.pointer) {
            this.pointer.update();
        }

        this.update(dt, elapsed);

        if (this.renderer && this.scene && this.camera) {
            this.renderer.render(this.scene, this.camera);
        }
    }

    pause() {
        if (!this.isRunning) return;
        this.isRunning = false;
        gsap.ticker.remove(this.renderLoop);
    }

    resume() {
        if (this.isRunning || this.isDisposed || !this.renderer) return;
        this.isRunning = true;
        this.renderLoop = () => this.render();
        gsap.ticker.add(this.renderLoop);
    }

    setQuality(tier) {
        this.tier = tier;
        if (this.renderer) {
            const maxDpr = tier === 'high' ? 2 : tier === 'medium' ? 1.5 : 1;
            this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, maxDpr));
        }
    }

    setTheme(tokens) {
        // Overridden by subclasses to animate/update uniforms & materials
    }

    dispose() {
        this.isDisposed = true;
        this.pause();

        window.removeEventListener('resize', this.onResizeBound);

        if (this.themeSync) {
            this.themeSync.destroy();
            this.themeSync = null;
        }

        if (this.visibility) {
            this.visibility.destroy();
            this.visibility = null;
        }

        if (this.pointer) {
            this.pointer.destroy();
            this.pointer = null;
        }

        if (this.scene) {
            Dispose.cleanObject(this.scene);
            this.scene = null;
        }

        if (this.renderer) {
            RendererManager.dispose(this.renderer);
            this.renderer = null;
        }

        this.camera = null;
    }
}
