export default function (props = {}) {
    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue || null,
            inputSelector: '[data-strata-datepicker-input]',
            afterWatch: function(newValue) {
                this.display = this.computeDisplay(newValue);
                this.updateCalendarValue(newValue);
            }
        }),

        open: false,
        mode: props.mode || 'single',
        initialValue: props.initialValue || null,
        minDate: props.minDate || null,
        maxDate: props.maxDate || null,
        placeholder: props.placeholder || 'Select date',
        disabled: props.disabled || false,
        clearable: props.clearable || false,
        chips: props.chips || false,
        display: '',
        _disabledObserver: null,

        init() {
            this.initEntangleable();
            this.display = this.computeDisplay(this.entangleable.value);

            this.disabled = this.$el?.dataset?.disabled === 'true';

            this._disabledObserver = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-disabled') {
                        this.disabled = this.$el?.dataset?.disabled === 'true';
                    }
                }
            });

            this._disabledObserver.observe(this.$el, {
                attributes: true,
                attributeFilter: ['data-disabled']
            });

            this.$watch('open', (isOpen) => {
                if (!isOpen) {
                    this.$nextTick(() => {
                        this.$refs.trigger?.focus();
                    });
                }
            });
        },

        isDisabled() {
            return this.disabled === true;
        },

        get dates() {
            const value = this.entangleable?.get();
            if (this.mode === 'multiple' && !value) return [];
            return value ?? null;
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

            if (this.mode === 'multiple') {
                if (!Array.isArray(value) || value.length === 0) return '';

                if (this.chips) {
                    return '';
                }

                return `${value.length} ${value.length === 1 ? 'date' : 'dates'}`;
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

        formatDateShort(dateString) {
            try {
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return dateString;

                return new Intl.DateTimeFormat('en-US', {
                    month: 'short',
                    day: 'numeric',
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
                const dropdown = document.getElementById(this.$id('datepicker-dropdown'));
                if (dropdown) dropdown.hidePopover();
            } else if (mode === 'range') {
                if (Array.isArray(dates) && dates.length === 2) {
                    this.entangleable.set({
                        start: dates[0],
                        end: dates[1],
                    });
                    const dropdown = document.getElementById(this.$id('datepicker-dropdown'));
                    if (dropdown) dropdown.hidePopover();
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
                const dropdown = document.getElementById(this.$id('datepicker-dropdown'));
                if (dropdown) dropdown.hidePopover();
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
            const dropdown = document.getElementById(this.$id('datepicker-dropdown'));
            if (dropdown) dropdown.hidePopover();
        },

        hasValue() {
            return this.entangleable.value !== null && this.entangleable.value !== '';
        },

        toggleDropdown() {
            const dropdown = document.getElementById(this.$id('datepicker-dropdown'));
            if (dropdown) {
                if (this.open) {
                    dropdown.hidePopover();
                } else {
                    dropdown.showPopover();
                }
            }
        },

        destroy() {
            if (this.entangleable) {
                this.entangleable.destroy();
            }
            if (this._disabledObserver) {
                this._disabledObserver.disconnect();
            }
        },
    };
}
