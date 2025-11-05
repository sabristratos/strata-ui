export default function (props = {}) {
    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue || null,
            inputSelector: '[data-strata-colorpicker-input]',
            afterWatch: function(newValue) {
                if (newValue && !this.isDraggingSL && !this.isDraggingHue && !this.isDraggingAlpha) {
                    this.parseColor(newValue);
                }
                this.display = this.computeDisplay(newValue);
            }
        }),

        ...window.createPositionableMixin({
            placement: 'bottom-start',
            offset: 8,
            floatingRef: 'dropdown'
        }),
        format: props.format || 'hex',
        initialValue: props.initialValue || null,
        placeholder: props.placeholder || 'Select color',
        disabled: props.disabled || false,
        clearable: props.clearable || false,
        allowAlpha: props.allowAlpha || false,
        showPresets: props.showPresets !== false,
        presets: props.presets || [],
        display: '',

        hue: 0,
        saturation: 100,
        lightness: 50,
        alpha: 100,

        isDraggingSL: false,
        isDraggingHue: false,
        isDraggingAlpha: false,

        init() {
            this.initEntangleable();
            this.initPositionable();

            if (this.initialValue) {
                this.parseColor(this.initialValue);
            }

            this.display = this.computeDisplay(this.entangleable.value);
        },

        computeDisplay(value) {
            if (!value) return '';
            return this.formatColorForDisplay(value);
        },

        formatColorForDisplay(value) {
            if (!value) return '';

            if (this.format === 'hex') {
                if (value.startsWith('hsl')) {
                    return this.hslToHex(value);
                }
                return value;
            } else if (this.format === 'hsl') {
                if (value.startsWith('#')) {
                    return this.hexToHsl(value);
                }
                return value;
            }

            return value;
        },

        parseColor(color) {
            if (!color) return;

            if (color.startsWith('#')) {
                const hsl = this.hexToHslComponents(color);
                this.hue = hsl.h;
                this.saturation = hsl.s;
                this.lightness = hsl.l;
                this.alpha = hsl.a || 100;
            } else if (color.startsWith('hsl')) {
                const hsl = this.parseHslString(color);
                this.hue = hsl.h;
                this.saturation = hsl.s;
                this.lightness = hsl.l;
                this.alpha = hsl.a || 100;
            }
        },

        updateColor() {
            let color;

            if (this.format === 'hex') {
                color = this.hslToHex(`hsl(${this.hue}, ${this.saturation}%, ${this.lightness}%)`);
                if (this.allowAlpha && this.alpha < 100) {
                    const alphaHex = Math.round((this.alpha / 100) * 255).toString(16).padStart(2, '0');
                    color = color + alphaHex;
                }
            } else {
                if (this.allowAlpha && this.alpha < 100) {
                    color = `hsla(${this.hue}, ${this.saturation}%, ${this.lightness}%, ${(this.alpha / 100).toFixed(2)})`;
                } else {
                    color = `hsl(${this.hue}, ${this.saturation}%, ${this.lightness}%)`;
                }
            }

            this.entangleable.set(color);
        },

        selectColor(color) {
            if (this.disabled) return;
            this.parseColor(color);
            this.updateColor();
            this.open = false;
        },

        clear() {
            if (!this.disabled) {
                this.entangleable.set(null);
                this.hue = 0;
                this.saturation = 100;
                this.lightness = 50;
                this.alpha = 100;
                this.open = false;
            }
        },

        hasValue() {
            return this.entangleable.value !== null && this.entangleable.value !== '';
        },

        handleSLMouseDown(e) {
            if (this.disabled) return;
            this.isDraggingSL = true;
            this.updateSL(e);

            const moveHandler = (e) => this.updateSL(e);
            const upHandler = () => {
                this.isDraggingSL = false;
                this.updateColor();
                document.removeEventListener('mousemove', moveHandler);
                document.removeEventListener('mouseup', upHandler);
            };

            document.addEventListener('mousemove', moveHandler);
            document.addEventListener('mouseup', upHandler);
        },

        updateSL(e) {
            const rect = this.$refs.slArea.getBoundingClientRect();
            const x = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
            const y = Math.max(0, Math.min(e.clientY - rect.top, rect.height));

            this.saturation = Math.round((x / rect.width) * 100);
            this.lightness = Math.round(100 - (y / rect.height) * 100);

            if (!this.isDraggingSL) {
                this.updateColor();
            }
        },

        handleHueMouseDown(e) {
            if (this.disabled) return;
            this.isDraggingHue = true;
            this.updateHue(e);

            const moveHandler = (e) => this.updateHue(e);
            const upHandler = () => {
                this.isDraggingHue = false;
                this.updateColor();
                document.removeEventListener('mousemove', moveHandler);
                document.removeEventListener('mouseup', upHandler);
            };

            document.addEventListener('mousemove', moveHandler);
            document.addEventListener('mouseup', upHandler);
        },

        updateHue(e) {
            const rect = this.$refs.hueSlider.getBoundingClientRect();
            const x = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
            this.hue = Math.round((x / rect.width) * 360);

            if (!this.isDraggingHue) {
                this.updateColor();
            }
        },

        handleAlphaMouseDown(e) {
            if (this.disabled || !this.allowAlpha) return;
            this.isDraggingAlpha = true;
            this.updateAlpha(e);

            const moveHandler = (e) => this.updateAlpha(e);
            const upHandler = () => {
                this.isDraggingAlpha = false;
                this.updateColor();
                document.removeEventListener('mousemove', moveHandler);
                document.removeEventListener('mouseup', upHandler);
            };

            document.addEventListener('mousemove', moveHandler);
            document.addEventListener('mouseup', upHandler);
        },

        updateAlpha(e) {
            const rect = this.$refs.alphaSlider.getBoundingClientRect();
            const x = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
            this.alpha = Math.round((x / rect.width) * 100);

            if (!this.isDraggingAlpha) {
                this.updateColor();
            }
        },

        getCurrentColor() {
            return `hsl(${this.hue}, ${this.saturation}%, ${this.lightness}%)`;
        },

        getCurrentColorWithAlpha() {
            if (this.allowAlpha) {
                return `hsla(${this.hue}, ${this.saturation}%, ${this.lightness}%, ${(this.alpha / 100).toFixed(2)})`;
            }
            return this.getCurrentColor();
        },

        hexToHsl(hex) {
            const hsl = this.hexToHslComponents(hex);
            if (this.allowAlpha && hsl.a < 100) {
                return `hsla(${hsl.h}, ${hsl.s}%, ${hsl.l}%, ${(hsl.a / 100).toFixed(2)})`;
            }
            return `hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)`;
        },

        hexToHslComponents(hex) {
            hex = hex.replace('#', '');

            let r, g, b, a = 100;
            if (hex.length === 8) {
                r = parseInt(hex.substring(0, 2), 16) / 255;
                g = parseInt(hex.substring(2, 4), 16) / 255;
                b = parseInt(hex.substring(4, 6), 16) / 255;
                a = Math.round((parseInt(hex.substring(6, 8), 16) / 255) * 100);
            } else {
                r = parseInt(hex.substring(0, 2), 16) / 255;
                g = parseInt(hex.substring(2, 4), 16) / 255;
                b = parseInt(hex.substring(4, 6), 16) / 255;
            }

            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;

            if (max === min) {
                h = s = 0;
            } else {
                const d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

                switch (max) {
                    case r: h = ((g - b) / d + (g < b ? 6 : 0)) / 6; break;
                    case g: h = ((b - r) / d + 2) / 6; break;
                    case b: h = ((r - g) / d + 4) / 6; break;
                }
            }

            return {
                h: Math.round(h * 360),
                s: Math.round(s * 100),
                l: Math.round(l * 100),
                a: a
            };
        },

        hslToHex(hsl) {
            const match = hsl.match(/hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)/);
            if (!match) return '#000000';

            const h = parseInt(match[1]) / 360;
            const s = parseInt(match[2]) / 100;
            const l = parseInt(match[3]) / 100;

            let r, g, b;

            if (s === 0) {
                r = g = b = l;
            } else {
                const hue2rgb = (p, q, t) => {
                    if (t < 0) t += 1;
                    if (t > 1) t -= 1;
                    if (t < 1/6) return p + (q - p) * 6 * t;
                    if (t < 1/2) return q;
                    if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                    return p;
                };

                const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
                const p = 2 * l - q;

                r = hue2rgb(p, q, h + 1/3);
                g = hue2rgb(p, q, h);
                b = hue2rgb(p, q, h - 1/3);
            }

            const toHex = (x) => {
                const hex = Math.round(x * 255).toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            };

            return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
        },

        parseHslString(hsl) {
            const match = hsl.match(/hsla?\((\d+),\s*(\d+)%,\s*(\d+)%(?:,\s*([\d.]+))?\)/);
            if (!match) return { h: 0, s: 100, l: 50, a: 100 };

            return {
                h: parseInt(match[1]),
                s: parseInt(match[2]),
                l: parseInt(match[3]),
                a: match[4] ? Math.round(parseFloat(match[4]) * 100) : 100
            };
        },

        destroy() {
            if (this.entangleable) {
                this.entangleable.destroy();
            }
            this.destroyPositionable();
        },
    };
}
