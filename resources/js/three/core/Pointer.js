export class Pointer {
    constructor(element = window) {
        this.element = element;
        this.x = 0;
        this.y = 0;
        this.targetX = 0;
        this.targetY = 0;
        this.damping = 0.05;

        this.onPointerMove = this.handlePointerMove.bind(this);
        this.bindEvents();
    }

    bindEvents() {
        window.addEventListener('pointermove', this.onPointerMove, { passive: true });
    }

    handlePointerMove(event) {
        // Normalized coordinates between -1 and 1
        this.targetX = (event.clientX / window.innerWidth) * 2 - 1;
        this.targetY = -(event.clientY / window.innerHeight) * 2 + 1;
    }

    update() {
        this.x += (this.targetX - this.x) * this.damping;
        this.y += (this.targetY - this.y) * this.damping;
        return { x: this.x, y: this.y };
    }

    destroy() {
        window.removeEventListener('pointermove', this.onPointerMove);
    }
}
