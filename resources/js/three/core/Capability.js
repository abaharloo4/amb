export class Capability {
    static isWebGLAvailable() {
        try {
            const canvas = document.createElement('canvas');
            return !!(
                window.WebGLRenderingContext &&
                (canvas.getContext('webgl') || canvas.getContext('experimental-webgl'))
            );
        } catch {
            return false;
        }
    }

    static isWebGL2Available() {
        try {
            const canvas = document.createElement('canvas');
            return !!(window.WebGL2RenderingContext && canvas.getContext('webgl2'));
        } catch {
            return false;
        }
    }

    static getTier() {
        if (!this.isWebGLAvailable()) return 'static';

        const concurrency = navigator.hardwareConcurrency || 4;
        const width = window.innerWidth;

        if (width < 768 || concurrency < 4) {
            return 'low';
        } else if (width < 1280 || concurrency < 6) {
            return 'medium';
        }
        return 'high';
    }
}
