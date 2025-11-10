export default function (props = {}) {
    const mode = props.mode ?? 'range';
    const isSingleMode = mode === 'single';
    const defaultValue = isSingleMode ? (props.min ?? 0) : { min: props.min ?? 0, max: props.max ?? 100 };

    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue ?? defaultValue,
            inputSelector: '[data-strata-slider-input]',
            afterWatch: function(newValue) {
                this.display = this.computeDisplay(newValue);
            }
        }),

        min: props.min ?? 0,
        max: props.max ?? 100,
        step: props.step ?? 1,
        mode: mode,
        initialValue: props.initialValue ?? null,
        disabled: props.disabled ?? false,
        prefix: props.prefix ?? '',
        suffix: props.suffix ?? '',
        showValues: props.showValues ?? true,
        showLabels: props.showLabels ?? true,

        isDraggingSingle: false,
        isDraggingMin: false,
        isDraggingMax: false,
        isHoveringSingle: false,
        isHoveringMin: false,
        isHoveringMax: false,
        touchIdentifier: null,
        tooltipFlippedSingle: false,
        tooltipFlippedMin: false,
        tooltipFlippedMax: false,

        localValue: null,

        display: '',

        init() {
            this.initEntangleable();
            this.localValue = this.entangleable.value;
            this.display = this.computeDisplay(this.entangleable.value);

            this.$watch('entangleable.value', (newValue) => {
                if (!this.isDraggingSingle && !this.isDraggingMin && !this.isDraggingMax) {
                    this.localValue = newValue;
                }
            });
        },

        get singlePercent() {
            const range = this.max - this.min;
            if (range === 0) return 0;

            const value = this.localValue ?? this.min;
            return ((value - this.min) / range) * 100;
        },

        get minPercent() {
            const range = this.max - this.min;
            if (range === 0) return 0;

            const value = this.localValue?.min ?? this.min;
            return ((value - this.min) / range) * 100;
        },

        get maxPercent() {
            const range = this.max - this.min;
            if (range === 0) return 100;

            const value = this.localValue?.max ?? this.max;
            return ((value - this.min) / range) * 100;
        },

        computeDisplay(value) {
            if (this.mode === 'single') {
                if (value === null || value === undefined) return '';
                return this.formatValue(value);
            }

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

        checkTooltipOverflow(handle, isMin) {
            if (!handle) return;

            this.$nextTick(() => {
                const tooltip = handle.querySelector('[data-tooltip]');
                if (!tooltip) return;

                const tooltipRect = tooltip.getBoundingClientRect();
                const flipped = tooltipRect.top < 0;

                if (isMin) {
                    this.tooltipFlippedMin = flipped;
                } else {
                    this.tooltipFlippedMax = flipped;
                }
            });
        },

        handleMinMouseDown(e) {
            if (this.disabled) return;

            e.preventDefault();
            this.isDraggingMin = true;
            this.checkTooltipOverflow(this.$refs.minHandle, true);

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
            this.checkTooltipOverflow(this.$refs.maxHandle, false);

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

            const currentMax = this.localValue?.max ?? this.max;
            newValue = Math.max(this.min, Math.min(newValue, currentMax - this.step));

            const updatedValue = {
                min: newValue,
                max: currentMax
            };

            this.localValue = updatedValue;
            this.entangleable.set(updatedValue);
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

            const currentMin = this.localValue?.min ?? this.min;
            newValue = Math.min(this.max, Math.max(newValue, currentMin + this.step));

            const updatedValue = {
                min: currentMin,
                max: newValue
            };

            this.localValue = updatedValue;
            this.entangleable.set(updatedValue);
        },

        handleTrackClick(e) {
            if (this.disabled) return;
            if (e.target !== this.$refs.track && e.target !== this.$refs.range) return;

            const rect = this.$refs.track.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const percent = x / rect.width;

            const range = this.max - this.min;
            const clickValue = this.min + (percent * range);

            const currentMin = this.localValue?.min ?? this.min;
            const currentMax = this.localValue?.max ?? this.max;

            const distToMin = Math.abs(clickValue - currentMin);
            const distToMax = Math.abs(clickValue - currentMax);

            let updatedValue;
            if (distToMin < distToMax) {
                let newValue = Math.round(clickValue / this.step) * this.step;
                newValue = Math.max(this.min, Math.min(newValue, currentMax - this.step));

                updatedValue = {
                    min: newValue,
                    max: currentMax
                };
            } else {
                let newValue = Math.round(clickValue / this.step) * this.step;
                newValue = Math.min(this.max, Math.max(newValue, currentMin + this.step));

                updatedValue = {
                    min: currentMin,
                    max: newValue
                };
            }

            this.localValue = updatedValue;
            this.entangleable.set(updatedValue);
        },

        handleMinKeydown(e) {
            if (this.disabled) return;

            const currentMin = this.localValue?.min ?? this.min;
            const currentMax = this.localValue?.max ?? this.max;
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

            const updatedValue = {
                min: newValue,
                max: currentMax
            };

            this.localValue = updatedValue;
            this.entangleable.set(updatedValue);
        },

        handleMaxKeydown(e) {
            if (this.disabled) return;

            const currentMin = this.localValue?.min ?? this.min;
            const currentMax = this.localValue?.max ?? this.max;
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

            const updatedValue = {
                min: currentMin,
                max: newValue
            };

            this.localValue = updatedValue;
            this.entangleable.set(updatedValue);
        },

        handleSingleMouseDown(e) {
            if (this.disabled) return;

            e.preventDefault();
            this.isDraggingSingle = true;
            this.checkTooltipOverflow(this.$refs.singleHandle, true);

            const moveHandler = (e) => this.updateSingleValue(e);
            const upHandler = () => {
                this.isDraggingSingle = false;
                document.removeEventListener('mousemove', moveHandler);
                document.removeEventListener('mouseup', upHandler);
            };

            document.addEventListener('mousemove', moveHandler);
            document.addEventListener('mouseup', upHandler);
        },

        handleSingleTouchStart(e) {
            if (this.disabled) return;

            e.preventDefault();
            this.isDraggingSingle = true;

            const touch = e.changedTouches[0];
            this.touchIdentifier = touch.identifier;

            const moveHandler = (e) => this.handleSingleTouchMove(e);
            const endHandler = () => {
                this.isDraggingSingle = false;
                this.touchIdentifier = null;
                document.removeEventListener('touchmove', moveHandler);
                document.removeEventListener('touchend', endHandler);
            };

            document.addEventListener('touchmove', moveHandler);
            document.addEventListener('touchend', endHandler);
        },

        handleSingleTouchMove(e) {
            if (!this.isDraggingSingle) return;

            const touches = Array.from(e.changedTouches);
            const touch = touches.find(t => t.identifier === this.touchIdentifier);
            if (!touch) return;

            this.updateSingleValue({ clientX: touch.clientX });
        },

        updateSingleValue(e) {
            const track = this.$refs.track;
            if (!track) return;

            const rect = track.getBoundingClientRect();
            const x = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
            const percent = x / rect.width;

            const range = this.max - this.min;
            let newValue = this.min + (percent * range);

            newValue = Math.round(newValue / this.step) * this.step;
            newValue = Math.max(this.min, Math.min(newValue, this.max));

            this.localValue = newValue;
            this.entangleable.set(newValue);
        },

        handleSingleKeydown(e) {
            if (this.disabled) return;

            const currentValue = this.localValue ?? this.min;
            let newValue = currentValue;

            switch (e.key) {
                case 'ArrowLeft':
                case 'ArrowDown':
                    e.preventDefault();
                    newValue = Math.max(this.min, currentValue - this.step);
                    break;
                case 'ArrowRight':
                case 'ArrowUp':
                    e.preventDefault();
                    newValue = Math.min(this.max, currentValue + this.step);
                    break;
                case 'Home':
                    e.preventDefault();
                    newValue = this.min;
                    break;
                case 'End':
                    e.preventDefault();
                    newValue = this.max;
                    break;
                case 'PageDown':
                    e.preventDefault();
                    newValue = Math.max(this.min, currentValue - (this.step * 10));
                    break;
                case 'PageUp':
                    e.preventDefault();
                    newValue = Math.min(this.max, currentValue + (this.step * 10));
                    break;
                default:
                    return;
            }

            this.localValue = newValue;
            this.entangleable.set(newValue);
        }
    };
}
