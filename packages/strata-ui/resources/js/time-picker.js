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
        placeholder: props.placeholder || null,
        disabled: props.disabled || false,
        readonly: props.readonly || false,
        required: props.required || false,
        clearable: props.clearable || false,
        displayMode: props.displayMode || 'clock',
        locale: props.locale || null,
        display: '',
        _disabledObserver: null,

        getPlaceholder() {
            return this.placeholder !== null ? this.placeholder : this.$__('Select time');
        },

        clockMode: 'hour',
        selectedHour: null,
        selectedMinute: null,
        selectedPeriod: null,
        highlightedClockValue: null,
        hoveredClockValue: null,
        clockAnnouncement: '',
        clockSize: 280,

        init() {
            this.initEntangleable();
            this.initKeyboardNavigation();
            this.display = this.computeDisplay(this.entangleable.value);

            this.initializeClockState(this.entangleable.value);

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
                        if (this.displayMode === 'list') {
                            this.collectKeyboardItems();
                            this.scrollToSelected();
                            this.focusTimeList();
                        } else if (this.displayMode === 'clock') {
                            this.updateClockSize();
                            this.initializeClockState(this.entangleable.value);
                            this.clockMode = 'hour';
                            this.$refs.hourInput?.focus();
                        }
                    });
                } else {
                    this.highlighted = -1;
                    this.clockMode = 'hour';
                    this.$nextTick(() => {
                        this.$refs.trigger?.focus();
                    });
                }
            });

            this.$watch('entangleable.value', (newValue) => {
                this.initializeClockState(newValue);
            });

            this.$watch('selectedHour', () => {
                if (this.selectedHour !== null && this.selectedMinute !== null && this.selectedPeriod !== null) {
                    this.updateTimeValue();
                }
            });

            this.$watch('selectedMinute', () => {
                if (this.selectedHour !== null && this.selectedMinute !== null && this.selectedPeriod !== null) {
                    this.updateTimeValue();
                }
            });

            this.$watch('selectedPeriod', () => {
                if (this.selectedHour !== null && this.selectedMinute !== null && this.selectedPeriod !== null) {
                    this.updateTimeValue();
                }
            });
        },

        updateClockSize() {
            if (this.$refs.clockFace) {
                const rect = this.$refs.clockFace.getBoundingClientRect();
                this.clockSize = Math.min(rect.width, rect.height);
            }
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
                const meridiem = hour < 12 ? this.$__('AM') : this.$__('PM');
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

        initializeClockState(value) {
            if (!value) {
                this.selectedHour = null;
                this.selectedMinute = null;
                this.selectedPeriod = 'AM';
                return;
            }

            const [hours, minutes] = value.split(':').map(Number);

            this.selectedPeriod = hours < 12 ? 'AM' : 'PM';
            this.selectedHour = hours === 0 ? 12 : hours > 12 ? hours - 12 : hours;
            this.selectedMinute = minutes;
        },

        get clockHours() {
            const hours = [];
            const center = this.clockSize / 2;
            const radius = this.clockSize * 0.40;

            for (let i = 0; i < 12; i++) {
                const hourValue = i === 0 ? 12 : i;
                const angle = (i * 30 - 90) * (Math.PI / 180);

                const x = center + radius * Math.cos(angle);
                const y = center + radius * Math.sin(angle);

                const hour24 = this.selectedPeriod === 'PM'
                    ? (hourValue === 12 ? 12 : hourValue + 12)
                    : (hourValue === 12 ? 0 : hourValue);

                const timeValue = this.to24HourFormat(hour24, 0);
                const isDisabled = (this.minTime && timeValue < this.minTime.substring(0, 2) + ':00') ||
                                 (this.maxTime && timeValue > this.maxTime.substring(0, 2) + ':59');

                hours.push({
                    value: hourValue,
                    label: String(hourValue),
                    x,
                    y,
                    angle,
                    disabled: isDisabled
                });
            }

            return hours;
        },

        get clockMinutes() {
            const minutes = [];
            const center = this.clockSize / 2;
            const radius = this.clockSize * 0.40;
            const step = this.stepMinutes;

            for (let i = 0; i < 60; i += step) {
                const angle = (i * 6 - 90) * (Math.PI / 180);
                const x = center + radius * Math.cos(angle);
                const y = center + radius * Math.sin(angle);

                const hour24 = this.format === '12' && this.selectedHour !== null
                    ? (this.selectedPeriod === 'PM' ? (this.selectedHour === 12 ? 12 : this.selectedHour + 12) : (this.selectedHour === 12 ? 0 : this.selectedHour))
                    : this.selectedHour;

                const timeValue = this.to24HourFormat(hour24 || 0, i);
                const isDisabled = this.disabledTimes.includes(timeValue) ||
                                 (this.minTime && timeValue < this.minTime) ||
                                 (this.maxTime && timeValue > this.maxTime);

                minutes.push({
                    value: i,
                    label: String(i).padStart(2, '0'),
                    x,
                    y,
                    angle,
                    disabled: isDisabled
                });
            }

            return minutes;
        },

        get clockDisplay() {
            const hour = this.selectedHour !== null ? String(this.selectedHour).padStart(2, '0') : '--';
            const minute = this.selectedMinute !== null ? String(this.selectedMinute).padStart(2, '0') : '--';

            if (this.format === '12') {
                const period = this.selectedPeriod || '--';
                return `${hour}:${minute} ${period}`;
            }

            return `${hour}:${minute}`;
        },

        get clockHandAngle() {
            if (this.selectedHour === null || this.selectedMinute === null) {
                return 0;
            }

            if (this.clockMode === 'hour') {
                const hourValue = this.selectedHour === 12 ? 0 : this.selectedHour;
                return hourValue * 30 - 90;
            } else {
                return this.selectedMinute * 6 - 90;
            }
        },

        get clockHandLength() {
            return '40%';
        },

        selectClockHour(hour) {
            const clockHour = this.clockHours.find(h => h.value === hour);
            if (clockHour && clockHour.disabled) return;

            this.selectedHour = hour;
            this.selectedMinute = null;
            this.clockMode = 'minute';
            this.clockAnnouncement = `${hour} ${this.$__('o\'clock selected. Now select minutes.')}`;

            if (this.selectedPeriod === null) {
                this.selectedPeriod = this.$__('AM');
            }
        },

        selectClockMinute(minute) {
            const clockMinute = this.clockMinutes.find(m => m.value === minute);
            if (clockMinute && clockMinute.disabled) return;

            this.selectedMinute = minute;
            this.clockAnnouncement = `${minute} ${this.$__('minutes selected.')}`;

            if (this.selectedHour !== null) {
                this.finalizeClockSelection();
            }
        },

        selectPeriod(period) {
            if (this.selectedPeriod === period) return;

            this.selectedPeriod = period;
            this.clockAnnouncement = `${period} ${this.$__('selected.')}`;

            if (this.selectedHour !== null && this.selectedMinute !== null) {
                this.updateTimeValue();
            }
        },

        updateTimeValue() {
            if (this.selectedHour === null || this.selectedMinute === null) return;

            let hour24 = this.selectedHour;

            if (this.format === '12') {
                if (this.selectedPeriod === 'PM') {
                    hour24 = this.selectedHour === 12 ? 12 : this.selectedHour + 12;
                } else {
                    hour24 = this.selectedHour === 12 ? 0 : this.selectedHour;
                }
            }

            const timeValue = this.to24HourFormat(hour24, this.selectedMinute);

            if (this.disabledTimes.includes(timeValue)) {
                return;
            }

            if (this.minTime && timeValue < this.minTime) {
                return;
            }

            if (this.maxTime && timeValue > this.maxTime) {
                return;
            }

            this.entangleable.set(timeValue);
        },

        finalizeClockSelection() {
            this.updateTimeValue();

            const dropdown = document.getElementById(this.$id('timepicker-dropdown'));
            if (dropdown) {
                dropdown.hidePopover();
            }
        },

        handleClockKeydown(event) {
            if (this.disabled || this.readonly) return;

            const key = event.key;

            if (key === 'Escape') {
                const dropdown = document.getElementById(this.$id('timepicker-dropdown'));
                if (dropdown) {
                    dropdown.hidePopover();
                }
                return;
            }

            if (key === 'Tab') {
                event.preventDefault();
                this.clockMode = this.clockMode === 'hour' ? 'minute' : 'hour';
                return;
            }

            if (this.clockMode === 'hour') {
                this.handleHourKeydown(event);
            } else {
                this.handleMinuteKeydown(event);
            }
        },

        handleHourKeydown(event) {
            const key = event.key;
            const totalHours = this.format === '12' ? 12 : 24;
            let newHour = this.selectedHour;

            if (key === 'ArrowRight' || key === 'ArrowUp') {
                event.preventDefault();
                newHour = this.selectedHour === null ? 1 : this.selectedHour + 1;
                if (this.format === '12') {
                    if (newHour > 12) newHour = 1;
                } else {
                    if (newHour >= 24) newHour = 0;
                }
            } else if (key === 'ArrowLeft' || key === 'ArrowDown') {
                event.preventDefault();
                newHour = this.selectedHour === null ? (this.format === '12' ? 12 : 23) : this.selectedHour - 1;
                if (this.format === '12') {
                    if (newHour < 1) newHour = 12;
                } else {
                    if (newHour < 0) newHour = 23;
                }
            } else if (key === 'Home') {
                event.preventDefault();
                newHour = this.format === '12' ? 1 : 0;
            } else if (key === 'End') {
                event.preventDefault();
                newHour = this.format === '12' ? 12 : 23;
            } else if (key === 'Enter' || key === ' ') {
                event.preventDefault();
                if (this.selectedHour !== null) {
                    this.clockMode = 'minute';
                }
                return;
            } else {
                return;
            }

            const clockHour = this.clockHours.find(h => h.value === newHour);
            if (clockHour && !clockHour.disabled) {
                this.selectedHour = newHour;
                this.highlightedClockValue = newHour;

                if (this.format === '12' && this.selectedPeriod === null) {
                    this.selectedPeriod = 'AM';
                }
            }
        },

        handleMinuteKeydown(event) {
            const key = event.key;
            let newMinute = this.selectedMinute;

            if (key === 'ArrowRight' || key === 'ArrowUp') {
                event.preventDefault();
                newMinute = this.selectedMinute === null ? 0 : this.selectedMinute + this.stepMinutes;
                if (newMinute >= 60) newMinute = 0;
            } else if (key === 'ArrowLeft' || key === 'ArrowDown') {
                event.preventDefault();
                newMinute = this.selectedMinute === null ? (60 - this.stepMinutes) : this.selectedMinute - this.stepMinutes;
                if (newMinute < 0) newMinute = 60 - this.stepMinutes;
            } else if (key === 'Home') {
                event.preventDefault();
                newMinute = 0;
            } else if (key === 'End') {
                event.preventDefault();
                newMinute = 60 - this.stepMinutes;
            } else if (key === 'Enter' || key === ' ') {
                event.preventDefault();
                if (this.selectedHour !== null && this.selectedMinute !== null) {
                    this.finalizeClockSelection();
                }
                return;
            } else {
                return;
            }

            const clockMinute = this.clockMinutes.find(m => m.value === newMinute);
            if (clockMinute && !clockMinute.disabled) {
                this.selectedMinute = newMinute;
                this.highlightedClockValue = newMinute;
            }
        },
    };
}
