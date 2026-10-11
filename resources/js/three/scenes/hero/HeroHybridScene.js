import * as THREE from 'three';
import gsap from 'gsap';
import { SceneBase } from '../../core/SceneBase';

export class HeroHybridScene extends SceneBase {
    buildScene() {
        this.camera.position.set(0, 4, 26);
        this.camera.lookAt(0, 0, 0);

        // --- Part 1: Signal Lattice (Foundation Wave) ---
        const rows = this.tier === 'high' ? 32 : this.tier === 'medium' ? 24 : 16;
        const cols = this.tier === 'high' ? 32 : this.tier === 'medium' ? 24 : 16;
        const total = rows * cols;
        this.gridCount = { rows, cols, total };

        const positions = new Float32Array(total * 3);
        const colors = new Float32Array(total * 3);
        const originalPositions = new Float32Array(total * 3);

        const spacing = 1.3;
        const xOffset = ((cols - 1) * spacing) / 2;
        const zOffset = ((rows - 1) * spacing) / 2;

        let index = 0;
        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < cols; j++) {
                const x = j * spacing - xOffset;
                const z = i * spacing - zOffset;
                const y = -4 + Math.sin((x + z) * 0.2) * 1.2;

                positions[index * 3] = x;
                positions[index * 3 + 1] = y;
                positions[index * 3 + 2] = z;

                originalPositions[index * 3] = x;
                originalPositions[index * 3 + 1] = y;
                originalPositions[index * 3 + 2] = z;

                const isHighlight = Math.random() < 0.07;
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

        const latticeGeom = new THREE.BufferGeometry();
        latticeGeom.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        latticeGeom.setAttribute('color', new THREE.BufferAttribute(colors, 3));

        this.latticeMat = new THREE.PointsMaterial({
            size: this.tier === 'high' ? 0.32 : 0.42,
            vertexColors: true,
            transparent: true,
            opacity: 0.75,
        });

        this.latticePoints = new THREE.Points(latticeGeom, this.latticeMat);
        this.scene.add(this.latticePoints);

        // Fine wireframe grid plane under the lattice
        const lineGeom = new THREE.PlaneGeometry(
            (cols - 1) * spacing,
            (rows - 1) * spacing,
            cols - 1,
            rows - 1
        );
        lineGeom.rotateX(-Math.PI / 2);
        lineGeom.translate(0, -4, 0);

        this.lineMat = new THREE.MeshBasicMaterial({
            color: 0x18424E,
            wireframe: true,
            transparent: true,
            opacity: 0.12,
        });

        this.lineMesh = new THREE.Mesh(lineGeom, this.lineMat);
        this.scene.add(this.lineMesh);

        // --- Part 2: Orbital Core (Architectural Rings & Pulses) ---
        this.rings = [];
        const ringConfigs = [
            { radius: 4.5, tube: 0.03, speed: 0.35, color: 0x18424E },
            { radius: 7.2, tube: 0.025, speed: -0.25, color: 0x29665F },
            { radius: 9.8, tube: 0.03, speed: 0.18, color: 0x18424E },
        ];

        ringConfigs.forEach((cfg) => {
            const geom = new THREE.TorusGeometry(cfg.radius, cfg.tube, 16, 90);
            const mat = new THREE.MeshBasicMaterial({
                color: cfg.color,
                transparent: true,
                opacity: 0.6,
                wireframe: true,
            });
            const mesh = new THREE.Mesh(geom, mat);
            mesh.rotation.x = Math.random() * Math.PI;
            mesh.rotation.y = Math.random() * Math.PI;

            this.scene.add(mesh);
            this.rings.push({ mesh, mat, speed: cfg.speed });
        });

        // Golden Orange traveling pulses on orbital core
        const pulseCount = this.tier === 'high' ? 140 : this.tier === 'medium' ? 90 : 50;
        const pGeom = new THREE.BufferGeometry();
        const pulsePositions = new Float32Array(pulseCount * 3);
        const radiusList = new Float32Array(pulseCount);
        const speedList = new Float32Array(pulseCount);
        const angleList = new Float32Array(pulseCount);

        for (let i = 0; i < pulseCount; i++) {
            const r = 4.5 + Math.random() * 5.3;
            const a = Math.random() * Math.PI * 2;
            radiusList[i] = r;
            angleList[i] = a;
            speedList[i] = (0.2 + Math.random() * 0.3) * (Math.random() < 0.5 ? 1 : -1);

            pulsePositions[i * 3] = Math.cos(a) * r;
            pulsePositions[i * 3 + 1] = Math.sin(a) * r;
            pulsePositions[i * 3 + 2] = (Math.random() - 0.5) * 3;
        }

        pGeom.setAttribute('position', new THREE.BufferAttribute(pulsePositions, 3));
        this.pulseData = { radiusList, speedList, angleList };

        this.pulseMat = new THREE.PointsMaterial({
            color: 0xF49D07,
            size: 0.36,
            transparent: true,
            opacity: 0.95,
        });

        this.pulsePoints = new THREE.Points(pGeom, this.pulseMat);
        this.scene.add(this.pulsePoints);
    }

    update(dt, elapsed) {
        // 1. Update Lattice Wave
        if (this.positions) {
            const { total } = this.gridCount;
            const pos = this.latticePoints.geometry.attributes.position.array;
            const orig = this.originalPositions;
            const pointer = this.pointer ? { x: this.pointer.x * 10, z: -this.pointer.y * 10 } : { x: 0, z: 0 };

            for (let i = 0; i < total; i++) {
                const x = orig[i * 3];
                const z = orig[i * 3 + 2];
                const wave = Math.sin(x * 0.28 + elapsed * 1.4) * Math.cos(z * 0.28 + elapsed * 1.1) * 1.0;

                const dx = x - pointer.x;
                const dz = z - pointer.z;
                const dist = Math.sqrt(dx * dx + dz * dz);
                const influence = Math.max(0, 1 - dist / 7) * 1.8;

                pos[i * 3 + 1] = -4 + wave + influence;
            }
            this.latticePoints.geometry.attributes.position.needsUpdate = true;
        }

        // 2. Rotate Orbital Rings
        this.rings.forEach((r) => {
            r.mesh.rotation.x += r.speed * dt * 0.45;
            r.mesh.rotation.y += r.speed * dt * 0.65;
        });

        // 3. Move Traveling Pulses
        if (this.pulsePoints) {
            const pos = this.pulsePoints.geometry.attributes.position.array;
            const { radiusList, speedList, angleList } = this.pulseData;

            for (let i = 0; i < radiusList.length; i++) {
                angleList[i] += speedList[i] * dt;
                const r = radiusList[i];
                const a = angleList[i];

                pos[i * 3] = Math.cos(a) * r;
                pos[i * 3 + 1] = Math.sin(a) * r;
            }
            this.pulsePoints.geometry.attributes.position.needsUpdate = true;
        }

        // 4. Subtle Damped Camera Drift
        if (this.pointer) {
            this.camera.position.x = this.pointer.x * 3;
            this.camera.position.y = 4 + this.pointer.y * 2;
            this.camera.lookAt(0, 0, 0);
        }
    }

    setTheme(tokens) {
        if (!tokens) return;
        const targetColor = new THREE.Color(tokens.line || '#29665F');

        if (this.lineMat) {
            gsap.to(this.lineMat.color, {
                r: targetColor.r,
                g: targetColor.g,
                b: targetColor.b,
                duration: 0.8,
            });
        }

        this.rings.forEach((r) => {
            gsap.to(r.mat.color, {
                r: targetColor.r,
                g: targetColor.g,
                b: targetColor.b,
                duration: 0.8,
            });
        });
    }
}
