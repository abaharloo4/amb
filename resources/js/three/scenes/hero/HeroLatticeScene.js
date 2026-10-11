import * as THREE from 'three';
import gsap from 'gsap';
import { SceneBase } from '../../core/SceneBase';

export class HeroLatticeScene extends SceneBase {
    buildScene() {
        this.camera.position.set(0, 5, 26);
        this.camera.lookAt(0, 0, 0);

        const rows = this.tier === 'high' ? 36 : this.tier === 'medium' ? 26 : 18;
        const cols = this.tier === 'high' ? 36 : this.tier === 'medium' ? 26 : 18;
        const total = rows * cols;

        this.gridCount = { rows, cols, total };

        // 1. Points Geometry
        const positions = new Float32Array(total * 3);
        const colors = new Float32Array(total * 3);
        const originalPositions = new Float32Array(total * 3);

        const spacing = 1.2;
        const xOffset = ((cols - 1) * spacing) / 2;
        const zOffset = ((rows - 1) * spacing) / 2;

        let index = 0;
        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < cols; j++) {
                const x = j * spacing - xOffset;
                const z = i * spacing - zOffset;
                const y = Math.sin((x + z) * 0.2) * 1.5;

                positions[index * 3] = x;
                positions[index * 3 + 1] = y;
                positions[index * 3 + 2] = z;

                originalPositions[index * 3] = x;
                originalPositions[index * 3 + 1] = y;
                originalPositions[index * 3 + 2] = z;

                // Color: majority deep teal/stormy teal, few golden orange highlights
                const isHighlight = Math.random() < 0.08;
                if (isHighlight) {
                    colors[index * 3] = 0.96;     // r
                    colors[index * 3 + 1] = 0.62; // g
                    colors[index * 3 + 2] = 0.03; // b (Golden Orange)
                } else {
                    colors[index * 3] = 0.16;     // r
                    colors[index * 3 + 1] = 0.40; // g
                    colors[index * 3 + 2] = 0.37; // b (Stormy Teal)
                }

                index++;
            }
        }

        this.positions = positions;
        this.originalPositions = originalPositions;

        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

        this.particleMaterial = new THREE.PointsMaterial({
            size: this.tier === 'high' ? 0.35 : 0.45,
            vertexColors: true,
            transparent: true,
            opacity: 0.85,
        });

        this.particles = new THREE.Points(geometry, this.particleMaterial);
        this.scene.add(this.particles);

        // 2. Subtle wireframe line mesh connecting the grid
        const lineGeometry = new THREE.PlaneGeometry(
            (cols - 1) * spacing,
            (rows - 1) * spacing,
            cols - 1,
            rows - 1
        );
        lineGeometry.rotateX(-Math.PI / 2);

        this.lineMaterial = new THREE.MeshBasicMaterial({
            color: 0x18424E,
            wireframe: true,
            transparent: true,
            opacity: 0.15,
        });

        this.lineMesh = new THREE.Mesh(lineGeometry, this.lineMaterial);
        this.scene.add(this.lineMesh);
    }

    update(dt, elapsed) {
        if (!this.positions) return;

        const { rows, cols, total } = this.gridCount;
        const pos = this.particles.geometry.attributes.position.array;
        const orig = this.originalPositions;
        const pointer = this.pointer ? { x: this.pointer.x * 12, z: -this.pointer.y * 12 } : { x: 0, z: 0 };

        for (let i = 0; i < total; i++) {
            const x = orig[i * 3];
            const z = orig[i * 3 + 2];

            // Wave motion
            const wave = Math.sin(x * 0.3 + elapsed * 1.5) * Math.cos(z * 0.3 + elapsed * 1.2) * 1.2;

            // Pointer proximity displacement
            const dx = x - pointer.x;
            const dz = z - pointer.z;
            const dist = Math.sqrt(dx * dx + dz * dz);
            const influence = Math.max(0, 1 - dist / 8) * 2.2;

            pos[i * 3 + 1] = wave + influence;
        }

        this.particles.geometry.attributes.position.needsUpdate = true;

        // Subtle camera swaying
        if (this.pointer) {
            this.camera.position.x = this.pointer.x * 3;
            this.camera.position.y = 5 + this.pointer.y * 2;
            this.camera.lookAt(0, 0, 0);
        }
    }

    setTheme(tokens) {
        if (!tokens || !this.lineMaterial) return;

        // Animate line color to match current theme
        const targetColor = new THREE.Color(tokens.line || '#29665F');
        gsap.to(this.lineMaterial.color, {
            r: targetColor.r,
            g: targetColor.g,
            b: targetColor.b,
            duration: 0.8,
        });
    }
}
