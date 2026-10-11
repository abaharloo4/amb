import * as THREE from 'three';

export class RendererManager {
    static create(container, options = {}) {
        const width = container.clientWidth || window.innerWidth;
        const height = container.clientHeight || window.innerHeight;

        const renderer = new THREE.WebGLRenderer({
            alpha: true,
            antialias: options.antialias !== undefined ? options.antialias : true,
            powerPreference: 'high-performance',
            preserveDrawingBuffer: false,
        });

        const maxDpr = options.maxDpr || 1.75;
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, maxDpr));
        renderer.setSize(width, height);
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.0;

        container.appendChild(renderer.domElement);
        return renderer;
    }

    static resize(renderer, camera, container) {
        if (!renderer || !camera || !container) return;

        const width = container.clientWidth || window.innerWidth;
        const height = container.clientHeight || window.innerHeight;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();

        renderer.setSize(width, height);
    }

    static dispose(renderer) {
        if (!renderer) return;

        if (renderer.domElement && renderer.domElement.parentNode) {
            renderer.domElement.parentNode.removeChild(renderer.domElement);
        }

        renderer.dispose();
        renderer.forceContextLoss();
    }
}
