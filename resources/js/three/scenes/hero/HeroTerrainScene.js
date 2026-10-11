import * as THREE from 'three';
import gsap from 'gsap';
import { SceneBase } from '../../core/SceneBase';

export class HeroTerrainScene extends SceneBase {
    buildScene() {
        this.camera.position.set(0, 10, 22);
        this.camera.lookAt(0, -2, 0);

        const widthSegments = this.tier === 'high' ? 48 : this.tier === 'medium' ? 36 : 24;
        const heightSegments = this.tier === 'high' ? 36 : this.tier === 'medium' ? 24 : 16;

        this.planeGeom = new THREE.PlaneGeometry(36, 26, widthSegments, heightSegments);
        this.planeGeom.rotateX(-Math.PI / 2.5);

        this.origPositions = this.planeGeom.attributes.position.array.slice();

        this.terrainMat = new THREE.MeshBasicMaterial({
            color: 0x18424E,
            wireframe: true,
            transparent: true,
            opacity: 0.35,
        });

        this.mesh = new THREE.Mesh(this.planeGeom, this.terrainMat);
        this.scene.add(this.mesh);

        // Peak accent particles
        const peakCount = Math.floor(widthSegments * 1.5);
        const pGeom = new THREE.BufferGeometry();
        const pPos = new Float32Array(peakCount * 3);

        for (let i = 0; i < peakCount; i++) {
            pPos[i * 3] = (Math.random() - 0.5) * 32;
            pPos[i * 3 + 1] = Math.random() * 3;
            pPos[i * 3 + 2] = (Math.random() - 0.5) * 22;
        }

        pGeom.setAttribute('position', new THREE.BufferAttribute(pPos, 3));
        this.pMat = new THREE.PointsMaterial({
            color: 0xF49D07,
            size: 0.45,
            transparent: true,
            opacity: 0.9,
        });

        this.peaks = new THREE.Points(pGeom, this.pMat);
        this.scene.add(this.peaks);
    }

    update(dt, elapsed) {
        if (!this.planeGeom) return;

        const pos = this.planeGeom.attributes.position.array;
        const orig = this.origPositions;

        for (let i = 0; i < pos.length; i += 3) {
            const x = orig[i];
            const z = orig[i + 2];

            // Undulating terrain motion
            const y = Math.sin(x * 0.25 + elapsed * 1.2) * Math.cos(z * 0.2 + elapsed * 0.9) * 2.2;
            pos[i + 1] = orig[i + 1] + y;
        }

        this.planeGeom.attributes.position.needsUpdate = true;

        if (this.pointer) {
            this.camera.position.x = this.pointer.x * 4;
            this.camera.position.y = 10 + this.pointer.y * 2;
            this.camera.lookAt(0, -2, 0);
        }
    }

    setTheme(tokens) {
        if (!tokens || !this.terrainMat) return;
        const targetColor = new THREE.Color(tokens.line || '#29665F');
        gsap.to(this.terrainMat.color, {
            r: targetColor.r,
            g: targetColor.g,
            b: targetColor.b,
            duration: 0.8,
        });
    }
}
