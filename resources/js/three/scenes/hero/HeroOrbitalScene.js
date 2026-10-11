import * as THREE from 'three';
import gsap from 'gsap';
import { SceneBase } from '../../core/SceneBase';

export class HeroOrbitalScene extends SceneBase {
    buildScene() {
        this.camera.position.set(0, 0, 24);
        this.camera.lookAt(0, 0, 0);

        this.rings = [];
        const ringConfigs = [
            { radius: 4, tube: 0.04, speed: 0.4, color: 0x18424E },
            { radius: 6.5, tube: 0.03, speed: -0.3, color: 0x29665F },
            { radius: 9, tube: 0.04, speed: 0.2, color: 0x18424E },
            { radius: 11.5, tube: 0.03, speed: -0.15, color: 0x29665F },
        ];

        ringConfigs.forEach((cfg) => {
            const geom = new THREE.TorusGeometry(cfg.radius, cfg.tube, 16, 100);
            const mat = new THREE.MeshBasicMaterial({
                color: cfg.color,
                transparent: true,
                opacity: 0.65,
                wireframe: true,
            });
            const mesh = new THREE.Mesh(geom, mat);
            mesh.rotation.x = Math.random() * Math.PI;
            mesh.rotation.y = Math.random() * Math.PI;

            this.scene.add(mesh);
            this.rings.push({ mesh, mat, speed: cfg.speed });
        });

        // Orbital particles (Golden Orange pulses)
        const particleCount = this.tier === 'high' ? 300 : this.tier === 'medium' ? 180 : 100;
        const pGeom = new THREE.BufferGeometry();
        const positions = new Float32Array(particleCount * 3);
        const radiusList = new Float32Array(particleCount);
        const speedList = new Float32Array(particleCount);
        const angleList = new Float32Array(particleCount);

        for (let i = 0; i < particleCount; i++) {
            const r = 3 + Math.random() * 9;
            const a = Math.random() * Math.PI * 2;
            radiusList[i] = r;
            angleList[i] = a;
            speedList[i] = (0.2 + Math.random() * 0.4) * (Math.random() < 0.5 ? 1 : -1);

            positions[i * 3] = Math.cos(a) * r;
            positions[i * 3 + 1] = Math.sin(a) * r;
            positions[i * 3 + 2] = (Math.random() - 0.5) * 4;
        }

        pGeom.setAttribute('position', new THREE.BufferAttribute(positions, 3));

        this.particleData = { radiusList, speedList, angleList };

        this.particleMat = new THREE.PointsMaterial({
            color: 0xF49D07,
            size: 0.35,
            transparent: true,
            opacity: 0.9,
        });

        this.particles = new THREE.Points(pGeom, this.particleMat);
        this.scene.add(this.particles);
    }

    update(dt, elapsed) {
        // Rotate orbital rings
        this.rings.forEach((r) => {
            r.mesh.rotation.x += r.speed * dt * 0.5;
            r.mesh.rotation.y += r.speed * dt * 0.7;
        });

        // Update traveling particles
        if (this.particles) {
            const pos = this.particles.geometry.attributes.position.array;
            const { radiusList, speedList, angleList } = this.particleData;

            for (let i = 0; i < radiusList.length; i++) {
                angleList[i] += speedList[i] * dt;
                const r = radiusList[i];
                const a = angleList[i];

                pos[i * 3] = Math.cos(a) * r;
                pos[i * 3 + 1] = Math.sin(a) * r;
            }

            this.particles.geometry.attributes.position.needsUpdate = true;
        }

        // Camera gentle drift
        if (this.pointer) {
            this.camera.position.x = this.pointer.x * 2.5;
            this.camera.position.y = this.pointer.y * 2.5;
            this.camera.lookAt(0, 0, 0);
        }
    }

    setTheme(tokens) {
        if (!tokens) return;
        const targetColor = new THREE.Color(tokens.line || '#29665F');
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
