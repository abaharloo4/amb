export class Dispose {
    static cleanObject(obj) {
        if (!obj) return;

        if (obj.geometry) {
            obj.geometry.dispose();
        }

        if (obj.material) {
            if (Array.isArray(obj.material)) {
                obj.material.forEach((mat) => this.cleanMaterial(mat));
            } else {
                this.cleanMaterial(obj.material);
            }
        }

        if (obj.children) {
            while (obj.children.length > 0) {
                const child = obj.children[0];
                this.cleanObject(child);
                obj.remove(child);
            }
        }
    }

    static cleanMaterial(material) {
        if (!material) return;

        Object.keys(material).forEach((prop) => {
            if (!material[prop]) return;
            if (material[prop].isTexture) {
                material[prop].dispose();
            }
        });

        material.dispose();
    }
}
