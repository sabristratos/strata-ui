export default function (props = {}) {
    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue || null,
            inputSelector: '[data-strata-timepicker-input]',
            afterWatch: function(newValue) {
                this.display = this.computeDisplay(newValue);
            }
        }),

        ...window.createKeyboardNavigationMixin({
            itemSelector: '[data-strata-time-option]:not([disabled])',
            itemsProperty: 'timeItems',
            highlightedProperty: 'highlighted',
            openProperty: 'open',
            enableTypeahead: false,
            onActivate: function(item) {
                if (item.value) {
                    this.selectTime(item.value);
                }
            },
            onClose: function() {
                const dropdown = document.getElementById(this.$id('timepicker-dropdown'));
                if (dropdown) {
                    dropdown.hidePopover();
                }
            },
            generateItemId: (item, index) => `time-option-${index}`,
            collectItems: function() {
                return this.times.map((time, index) => ({
                    value: time.value,
                    label: time.label,
                    disabled: time.disabled,
                    element: null
                }));
            }
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
        readonly: props.readonly || false,
        required: props.required || false,
        clearable: props.clearable || false,
        display: '',
        _disabledObserver: null,

        init() {
            this.initEntangleable();
            this.initKeyboardNavigation();
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
                if (isOpen) {
                    this.$nextTick(() => {
                        this.collectKeyboardItems();
                        this.scrollToSelected();
                        this.focusTimeList();
                    });
                } else {
                    this.highlighted = -1;
                    this.$nextTick(() => {
                        this.$refs.trigger?.focus();
                    });
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

        toggleDropdown() {
            const dropdown = document.getElementById(this.$id('timepicker-dropdown'));
            if (dropdown) {
                if (this.open) {
                    dropdown.hidePopover();
                } else {
                    dropdown.showPopover();
                }
            }
        },

        selectTime(timeValue) {
            this.entangleable.set(timeValue);
            const dropdown = document.getElementById(this.$id('timepicker-dropdown'));
            if (dropdown) {
                dropdown.hidePopover();
            }
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
                const dropdown = document.getElementById(this.$id('timepicker-dropdown'));
                if (dropdown) {
                    dropdown.hidePopover();
                }
            }
        },

        clear() {
            this.entangleable.set(null);
            const dropdown = document.getElementById(this.$id('timepicker-dropdown'));
            if (dropdown) {
                dropdown.hidePopover();
            }
        },

        hasSelection() {
            return this.entangleable.value !== null && this.entangleable.value !== '';
        },

        isDisabled() {
            return this.disabled === true || this.readonly === true;
        },

        scrollToSelected() {
            const timeList = this.$refs.timeList;
            if (!timeList) return;

            const selectedValue = this.entangleable.value;
            if (!selectedValue) {
                const currentTime = this.times.find(t => t.isCurrent);
                if (currentTime) {
                    const currentIndex = this.times.indexOf(currentTime);
                    const currentButton = timeList.querySelector(`[data-strata-time-option]:nth-child(${currentIndex + 1})`);
                    currentButton?.scrollIntoView({ block: 'center', behavior: 'instant' });
                }
                return;
            }

            const selectedIndex = this.times.findIndex(t => t.value === selectedValue);
            if (selectedIndex !== -1) {
                const selectedButton = timeList.querySelector(`[data-strata-time-option]:nth-child(${selectedIndex + 1})`);
                selectedButton?.scrollIntoView({ block: 'center', behavior: 'instant' });
            }
        },

        focusTimeList() {
            const timeList = this.$refs.timeList;
            if (timeList) {
                timeList.focus();
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
