export default function (props = {}) {
    return {
        entangleable: null,
        positionable: null,
        open: false,
        mode: props.mode || 'single',
        initialValue: props.initialValue || null,
        minDate: props.minDate || null,
        maxDate: props.maxDate || null,
        placeholder: props.placeholder || 'Select date',
        disabled: props.disabled || false,
        clearable: props.clearable || false,
        display: '',

        init() {
            this.entangleable = new window.StrataEntangleable(this.initialValue);

            const input = this.$el.querySelector('[data-strata-datepicker-input]');
            if (input) {
                this.entangleable.setupLivewire(this, input);
            }

            this.entangleable.watch((newValue) => {
                this.display = this.computeDisplay(newValue);
                this.updateCalendarValue(newValue);
            });

            this.display = this.computeDisplay(this.entangleable.value);

            this.positionable = new window.StrataPositionable({
                placement: 'bottom-start',
                offset: 8,
                strategy: 'absolute',
                enableSize: true,
                maxHeight: true,
                matchReferenceWidth: false,
            });

            this.positionable.start(this, this.$refs.trigger, this.$refs.dropdown);

            this.$watch('open', (value) => {
                if (value) {
                    this.positionable.open();
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

        get calendarValue() {
            const value = this.entangleable.value;

            if (this.mode === 'single') {
                return value ? [value] : [];
            }

            if (this.mode === 'range') {
                if (value && typeof value === 'object' && value.start && value.end) {
                    return [value.start, value.end];
                }
                if (Array.isArray(value) && value.length === 2) {
                    return value;
                }
                return [];
            }

            return Array.isArray(value) ? value : [];
        },

        computeDisplay(value) {
            if (!value) return '';

            if (this.mode === 'single') {
                return this.formatDate(value);
            }

            if (this.mode === 'range') {
                if (typeof value === 'object' && value.start && value.end) {
                    return `${this.formatDate(value.start)} - ${this.formatDate(value.end)}`;
                }
                if (Array.isArray(value) && value.length === 2) {
                    return `${this.formatDate(value[0])} - ${this.formatDate(value[1])}`;
                }
                return '';
            }

            return '';
        },

        formatDate(dateString) {
            try {
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return dateString;

                return new Intl.DateTimeFormat('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric',
                }).format(date);
            } catch (e) {
                return dateString;
            }
        },

        handleDateSelected(detail) {
            const dates = detail.dates || detail;
            const mode = detail.mode || this.mode;

            if (!dates || (Array.isArray(dates) && dates.length === 0)) {
                return;
            }

            if (mode === 'single') {
                const selectedDate = Array.isArray(dates) ? dates[0] : dates;
                this.entangleable.set(selectedDate);
                this.open = false;
            } else if (mode === 'range') {
                if (Array.isArray(dates) && dates.length === 2) {
                    this.entangleable.set({
                        start: dates[0],
                        end: dates[1],
                    });
                    this.open = false;
                }
            }
        },

        selectPreset(presetName) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const presets = {
                today: () => {
                    if (this.mode === 'single') {
                        return this.toDateString(today);
                    }
                    return {
                        start: this.toDateString(today),
                        end: this.toDateString(today),
                    };
                },
                yesterday: () => {
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1);
                    return this.toDateString(yesterday);
                },
                tomorrow: () => {
                    const tomorrow = new Date(today);
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    return this.toDateString(tomorrow);
                },
                nextWeek: () => {
                    const nextWeek = new Date(today);
                    nextWeek.setDate(nextWeek.getDate() + 7);
                    return this.toDateString(nextWeek);
                },
                nextMonth: () => {
                    const nextMonth = new Date(today);
                    nextMonth.setMonth(nextMonth.getMonth() + 1);
                    return this.toDateString(nextMonth);
                },
                thisWeek: () => {
                    const startOfWeek = new Date(today);
                    startOfWeek.setDate(startOfWeek.getDate() - startOfWeek.getDay());
                    const endOfWeek = new Date(startOfWeek);
                    endOfWeek.setDate(endOfWeek.getDate() + 6);

                    return {
                        start: this.toDateString(startOfWeek),
                        end: this.toDateString(endOfWeek),
                    };
                },
                lastWeek: () => {
                    const startOfLastWeek = new Date(today);
                    startOfLastWeek.setDate(startOfLastWeek.getDate() - startOfLastWeek.getDay() - 7);
                    const endOfLastWeek = new Date(startOfLastWeek);
                    endOfLastWeek.setDate(endOfLastWeek.getDate() + 6);

                    return {
                        start: this.toDateString(startOfLastWeek),
                        end: this.toDateString(endOfLastWeek),
                    };
                },
                last7Days: () => {
                    const start = new Date(today);
                    start.setDate(start.getDate() - 6);

                    return {
                        start: this.toDateString(start),
                        end: this.toDateString(today),
                    };
                },
                last30Days: () => {
                    const start = new Date(today);
                    start.setDate(start.getDate() - 29);

                    return {
                        start: this.toDateString(start),
                        end: this.toDateString(today),
                    };
                },
                thisMonth: () => {
                    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

                    return {
                        start: this.toDateString(startOfMonth),
                        end: this.toDateString(endOfMonth),
                    };
                },
                lastMonth: () => {
                    const startOfLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    const endOfLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);

                    return {
                        start: this.toDateString(startOfLastMonth),
                        end: this.toDateString(endOfLastMonth),
                    };
                },
                thisYear: () => {
                    const startOfYear = new Date(today.getFullYear(), 0, 1);
                    const endOfYear = new Date(today.getFullYear(), 11, 31);

                    return {
                        start: this.toDateString(startOfYear),
                        end: this.toDateString(endOfYear),
                    };
                },
            };

            if (presets[presetName]) {
                const value = presets[presetName]();
                this.entangleable.set(value);
                this.open = false;
            }
        },

        toDateString(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        updateCalendarValue(newValue) {
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
