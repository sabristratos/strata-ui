export default function (props = {}) {
    return {
        entangleable: null,
        positionable: null,
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
            this.entangleable = new window.StrataEntangleable(this.initialValue);

            const input = this.$el.querySelector('[data-strata-timepicker-input]');
            if (input) {
                this.entangleable.setupLivewire(this, input);
            }

            this.entangleable.watch((newValue) => {
                this.display = this.computeDisplay(newValue);
            });

            this.display = this.computeDisplay(this.entangleable.value);

            this.positionable = new window.StrataPositionable({
                placement: 'bottom-start',
                offset: 8,
                strategy: 'absolute',
            });

            this.positionable.start(this, this.$refs.trigger, this.$refs.dropdown);

            this.$watch('open', (value) => {
                if (value) {
                    this.positionable.open();
                    this.$nextTick(() => {
                        this.scrollToSelected();
                    });
                } else {
                    this.positionable.close();
                }
            });

            this.positionable.watch((state) => {
                if (!state) {
                    this.open = false;
                }
            });
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

        scrollToSelected() {
            if (!this.$refs.timeList) return;

            const selectedValue = this.entangleable.value;
            if (!selectedValue) return;

            const buttons = this.$refs.timeList.querySelectorAll('button');
            const selectedButton = Array.from(buttons).find(
                (button) => button.textContent.trim() === this.display
            );

            if (selectedButton) {
                selectedButton.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                });
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
            if (this.positionable) {
                this.positionable.destroy();
            }
        },
    };
}
