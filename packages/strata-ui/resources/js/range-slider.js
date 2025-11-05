export default function (props = {}) {
    const defaultValue = { min: props.min ?? 0, max: props.max ?? 100 };

    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue || defaultValue,
            inputSelector: '[data-strata-range-slider-input]',
            afterWatch: function(newValue) {
                this.display = this.computeDisplay(newValue);
            }
        }),

        min: props.min ?? 0,
        max: props.max ?? 100,
        step: props.step ?? 1,
        initialValue: props.initialValue ?? null,
        disabled: props.disabled ?? false,
        prefix: props.prefix ?? '',
        suffix: props.suffix ?? '',
        showValues: props.showValues ?? true,
        showLabels: props.showLabels ?? true,

        isDraggingMin: false,
        isDraggingMax: false,
        isHoveringMin: false,
        isHoveringMax: false,
        touchIdentifier: null,

        display: '',

        init() {
            this.initEntangleable();
            this.display = this.computeDisplay(this.entangleable.value);
        },

        get minPercent() {
            const range = this.max - this.min;
            if (range === 0) return 0;

            const value = this.entangleable?.value?.min ?? this.min;
            return ((value - this.min) / range) * 100;
        },

        get maxPercent() {
            const range = this.max - this.min;
            if (range === 0) return 100;

            const value = this.entangleable?.value?.max ?? this.max;
            return ((value - this.min) / range) * 100;
        },

        computeDisplay(value) {
            if (!value || typeof value !== 'object') {
                return '';
            }

            const minFormatted = this.formatValue(value.min);
            const maxFormatted = this.formatValue(value.max);

            return `${minFormatted} - ${maxFormatted}`;
        },

        formatValue(value) {
            if (value === null || value === undefined) return '';

            const formatted = Number(value).toLocaleString();
            return `${this.prefix}${formatted}${this.suffix}`;
        },

        handleMinMouseDown(e) {
            if (this.disabled) return;

            e.preventDefault();
            this.isDraggingMin = true;

            const moveHandler = (e) => this.updateMinValue(e);
            const upHandler = () => {
                this.isDraggingMin = false;
                document.removeEventListener('mousemove', moveHandler);
                document.removeEventListener('mouseup', upHandler);
            };

            document.addEventListener('mousemove', moveHandler);
            document.addEventListener('mouseup', upHandler);
        },

        handleMaxMouseDown(e) {
            if (this.disabled) return;

            e.preventDefault();
            this.isDraggingMax = true;

            const moveHandler = (e) => this.updateMaxValue(e);
            const upHandler = () => {
                this.isDraggingMax = false;
                document.removeEventListener('mousemove', moveHandler);
                document.removeEventListener('mouseup', upHandler);
            };

            document.addEventListener('mousemove', moveHandler);
            document.addEventListener('mouseup', upHandler);
        },

        handleMinTouchStart(e) {
            if (this.disabled) return;

            e.preventDefault();
            this.isDraggingMin = true;

            const touch = e.changedTouches[0];
            this.touchIdentifier = touch.identifier;

            const moveHandler = (e) => this.handleMinTouchMove(e);
            const endHandler = () => {
                this.isDraggingMin = false;
                this.touchIdentifier = null;
                document.removeEventListener('touchmove', moveHandler);
                document.removeEventListener('touchend', endHandler);
            };

            document.addEventListener('touchmove', moveHandler);
            document.addEventListener('touchend', endHandler);
        },

        handleMinTouchMove(e) {
            if (!this.isDraggingMin) return;

            const touches = Array.from(e.changedTouches);
            const touch = touches.find(t => t.identifier === this.touchIdentifier);
            if (!touch) return;

            this.updateMinValue({ clientX: touch.clientX });
        },

        handleMaxTouchStart(e) {
            if (this.disabled) return;

            e.preventDefault();
            this.isDraggingMax = true;

            const touch = e.changedTouches[0];
            this.touchIdentifier = touch.identifier;

            const moveHandler = (e) => this.handleMaxTouchMove(e);
            const endHandler = () => {
                this.isDraggingMax = false;
                this.touchIdentifier = null;
                document.removeEventListener('touchmove', moveHandler);
                document.removeEventListener('touchend', endHandler);
            };

            document.addEventListener('touchmove', moveHandler);
            document.addEventListener('touchend', endHandler);
        },

        handleMaxTouchMove(e) {
            if (!this.isDraggingMax) return;

            const touches = Array.from(e.changedTouches);
            const touch = touches.find(t => t.identifier === this.touchIdentifier);
            if (!touch) return;

            this.updateMaxValue({ clientX: touch.clientX });
        },

        updateMinValue(e) {
            const track = this.$refs.track;
            if (!track) return;

            const rect = track.getBoundingClientRect();
            const x = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
            const percent = x / rect.width;

            const range = this.max - this.min;
            let newValue = this.min + (percent * range);

            newValue = Math.round(newValue / this.step) * this.step;

            const currentMax = this.entangleable.value?.max ?? this.max;
            newValue = Math.max(this.min, Math.min(newValue, currentMax - this.step));

            this.entangleable.set({
                min: newValue,
                max: currentMax
            });
        },

        updateMaxValue(e) {
            const track = this.$refs.track;
            if (!track) return;

            const rect = track.getBoundingClientRect();
            const x = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
            const percent = x / rect.width;

            const range = this.max - this.min;
            let newValue = this.min + (percent * range);

            newValue = Math.round(newValue / this.step) * this.step;

            const currentMin = this.entangleable.value?.min ?? this.min;
            newValue = Math.min(this.max, Math.max(newValue, currentMin + this.step));

            this.entangleable.set({
                min: currentMin,
                max: newValue
            });
        },

        handleTrackClick(e) {
            if (this.disabled) return;
            if (e.target !== this.$refs.track && e.target !== this.$refs.range) return;

            const rect = this.$refs.track.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const percent = x / rect.width;

            const range = this.max - this.min;
            const clickValue = this.min + (percent * range);

            const currentMin = this.entangleable.value?.min ?? this.min;
            const currentMax = this.entangleable.value?.max ?? this.max;

            const distToMin = Math.abs(clickValue - currentMin);
            const distToMax = Math.abs(clickValue - currentMax);

            if (distToMin < distToMax) {
                let newValue = Math.round(clickValue / this.step) * this.step;
                newValue = Math.max(this.min, Math.min(newValue, currentMax - this.step));

                this.entangleable.set({
                    min: newValue,
                    max: currentMax
                });
            } else {
                let newValue = Math.round(clickValue / this.step) * this.step;
                newValue = Math.min(this.max, Math.max(newValue, currentMin + this.step));

                this.entangleable.set({
                    min: currentMin,
                    max: newValue
                });
            }
        },

        handleMinKeydown(e) {
            if (this.disabled) return;

            const currentMin = this.entangleable.value?.min ?? this.min;
            const currentMax = this.entangleable.value?.max ?? this.max;
            let newValue = currentMin;

            switch (e.key) {
                case 'ArrowLeft':
                case 'ArrowDown':
                    e.preventDefault();
                    newValue = Math.max(this.min, currentMin - this.step);
                    break;
                case 'ArrowRight':
                case 'ArrowUp':
                    e.preventDefault();
                    newValue = Math.min(currentMax - this.step, currentMin + this.step);
                    break;
                case 'Home':
                    e.preventDefault();
                    newValue = this.min;
                    break;
                case 'End':
                    e.preventDefault();
                    newValue = currentMax - this.step;
                    break;
                case 'PageDown':
                    e.preventDefault();
                    newValue = Math.max(this.min, currentMin - (this.step * 10));
                    break;
                case 'PageUp':
                    e.preventDefault();
                    newValue = Math.min(currentMax - this.step, currentMin + (this.step * 10));
                    break;
                default:
                    return;
            }

            this.entangleable.set({
                min: newValue,
                max: currentMax
            });
        },

        handleMaxKeydown(e) {
            if (this.disabled) return;

            const currentMin = this.entangleable.value?.min ?? this.min;
            const currentMax = this.entangleable.value?.max ?? this.max;
            let newValue = currentMax;

            switch (e.key) {
                case 'ArrowLeft':
                case 'ArrowDown':
                    e.preventDefault();
                    newValue = Math.max(currentMin + this.step, currentMax - this.step);
                    break;
                case 'ArrowRight':
                case 'ArrowUp':
                    e.preventDefault();
                    newValue = Math.min(this.max, currentMax + this.step);
                    break;
                case 'Home':
                    e.preventDefault();
                    newValue = currentMin + this.step;
                    break;
                case 'End':
                    e.preventDefault();
                    newValue = this.max;
                    break;
                case 'PageDown':
                    e.preventDefault();
                    newValue = Math.max(currentMin + this.step, currentMax - (this.step * 10));
                    break;
                case 'PageUp':
                    e.preventDefault();
                    newValue = Math.min(this.max, currentMax + (this.step * 10));
                    break;
                default:
                    return;
            }

            this.entangleable.set({
                min: currentMin,
                max: newValue
            });
        }
    };
}
