export default function (props = {}) {
    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue || null,
            inputSelector: '[data-strata-timepicker-input]',
            afterWatch: function(newValue) {
                this.display = this.computeDisplay(newValue);
            }
        }),

        ...window.createPositionableMixin({
            placement: 'bottom-start',
            offset: 8,
            floatingRef: 'dropdown'
        }),

        open: false,
        format: props.format || '12',
        initialValue: props.initialValue || null,
        stepMinutes: props.stepMinutes || 15,
        minTime: props.minTime || null,
        maxTime: props.maxTime || null,
        disabledTimes: props.disabledTimes || [],
        placeholder: props.placeholder || 'Select time',
        disabled: props.disabled || false,
        clearable: props.clearable || false,
        display: '',

        init() {
            this.initEntangleable();
            this.initPositionable();
            this.display = this.computeDisplay(this.entangleable.value);
        },

        get times() {
            const times = [];
            const currentTime = new Date();
            const currentHour = currentTime.getHours();
            const currentMinute = currentTime.getMinutes();

            for (let hour = 0; hour < 24; hour++) {
                for (let minute = 0; minute < 60; minute += this.stepMinutes) {
                    const timeValue = this.to24HourFormat(hour, minute);

                    if (this.minTime && timeValue < this.minTime) continue;
                    if (this.maxTime && timeValue > this.maxTime) continue;

                    const isDisabled = this.disabledTimes.includes(timeValue);
                    const isCurrent = hour === currentHour && Math.abs(minute - currentMinute) < this.stepMinutes;

                    times.push({
                        value: timeValue,
                        label: this.formatTime(hour, minute),
                        disabled: isDisabled,
                        isCurrent: isCurrent,
                    });
                }
            }

            return times;
        },

        computeDisplay(value) {
            if (!value) return '';

            const [hours, minutes] = value.split(':').map(Number);
            return this.formatTime(hours, minutes);
        },

        formatTime(hour, minute) {
            if (this.format === '12') {
                const meridiem = hour < 12 ? 'AM' : 'PM';
                const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
                return `${displayHour}:${String(minute).padStart(2, '0')} ${meridiem}`;
            }

            return `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
        },

        to24HourFormat(hour, minute) {
            return `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
        },

        selectTime(timeValue) {
            this.entangleable.set(timeValue);
            this.open = false;
        },

        selectPreset(presetName) {
            const now = new Date();
            const currentHour = now.getHours();
            const currentMinute = now.getMinutes();
            const roundedMinute = Math.floor(currentMinute / this.stepMinutes) * this.stepMinutes;

            const presets = {
                now: () => this.to24HourFormat(currentHour, roundedMinute),
                morning: () => '09:00',
                noon: () => '12:00',
                afternoon: () => '13:00',
                evening: () => '17:00',
                endOfDay: () => '23:59',
            };

            if (presets[presetName]) {
                const value = presets[presetName]();

                if (this.disabledTimes.includes(value)) {
                    return;
                }

                this.entangleable.set(value);
                this.open = false;
            }
        },

        clear() {
            this.entangleable.set(null);
            this.open = false;
        },

        hasValue() {
            return this.entangleable.value !== null && this.entangleable.value !== '';
        },

        destroy() {
            if (this.entangleable) {
                this.entangleable.destroy();
            }
            this.destroyPositionable();
        },
    };
}
