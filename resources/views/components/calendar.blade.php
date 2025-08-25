
<div
    x-data="dateRangePicker({
        value: {
            start: @js($startDate?->toDateString()),
            end: @js($endDate?->toDateString())
        },
        initialDate: @js($initialDate->toIso8601String()),
        weekStart: @js($weekStart),
        monthsToShow: @js($multiple ? $visibleMonths : 1),
        range: @js($range),
        locale: @js($locale),
        presets: @js($presets),
        initialSelecting: @js($selecting),
        initialUpdating: @js($updating),
        minDate: @js($minDate),
        maxDate: @js($maxDate),
        disabledDates: @js($disabledDates),
        showClearButton: @js($showClearButton),
        closeOnSelect: @js($closeOnSelect)
    })"
    x-modelable="value"
    {{ $attributes->wire('model') }}
    class="flex flex-col w-full mx-auto bg-card"
>
    <div class="flex flex-col md:flex-row flex-1">
        @if (!empty($presets))
        <div class="shrink-0 w-full md:w-48 p-4 border-b md:border-b-0 md:border-r border-border">
            <h4 class="text-base font-semibold mb-3 text-primary">{{ trans('strata::calendar.presets', [], $locale) }}</h4>
            <div class="flex flex-col space-y-1">
                @foreach ($presets as $label => $dates)
                    <button
                        x-on:click="setPreset(@js($label))"
                        type="button"
                        class="px-3 py-1.5 text-left text-sm rounded-[var(--radius-component)] hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors"
                        :class="{ 'bg-primary-50 dark:bg-primary-900/20 font-semibold text-primary-700 dark:text-primary-300': isPresetActive(@js($label)) }"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
        @endif

        <div class="p-4 w-full flex-1">
        <div class="flex items-center justify-between mb-4 px-2">
            <button
                x-on:click="prevMonths()"
                type="button"
                class="p-2 rounded-[var(--radius-component)] hover:bg-secondary-100 dark:hover:bg-secondary-800 transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div class="grow text-lg font-semibold text-center text-primary" x-text="headerText"></div>
            <button
                x-on:click="nextMonths()"
                type="button"
                class="p-2 rounded-[var(--radius-component)] hover:bg-secondary-100 dark:hover:bg-secondary-800 transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <div class="grid gap-6" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))">
            <template x-for="(monthData, index) in months" :key="index">
                <div class="w-full">
                    <h5 class="font-semibold text-center mb-2 text-primary" x-text="monthData.monthYear" x-show="$data.config.monthsToShow > 1"></h5>
                    <div class="grid grid-cols-7 gap-1 text-center">
                        @foreach ($getDayNames() as $dayName)
                            <div class="text-xs font-medium text-muted py-2">{{ $dayName }}</div>
                        @endforeach

                        <template x-for="day in monthData.days" :key="day.fullDate.getTime()">
                            <div
                                x-on:click="selectDate(day)"
                                :class="{
                                    'text-secondary-400 dark:text-secondary-600': !day.isCurrentMonth,
                                    'text-primary': day.isCurrentMonth && !day.isStartDate && !day.isEndDate && !day.isInRange && !day.isDisabled,
                                    'bg-primary-600 text-white font-semibold ring-2 ring-primary-200 dark:ring-primary-800': day.isStartDate && !day.isDisabled,
                                    'bg-primary-500 text-white font-semibold': day.isEndDate && !day.isDisabled,
                                    'bg-primary-100 dark:bg-primary-900/30': day.isInRange && !day.isDisabled,
                                    'rounded-l-[var(--radius-component-sm)]': day.isStartDate && !day.isEndDate,
                                    'rounded-r-[var(--radius-component-sm)]': day.isEndDate && !day.isStartDate,
                                    'rounded-[var(--radius-component-sm)]': day.isStartDate && day.isEndDate,
                                    'font-bold ring-2 ring-primary-300 dark:ring-primary-700 rounded-[var(--radius-component-sm)]': day.isToday && !day.isStartDate && !day.isEndDate && !day.isInRange && !this.selecting && !day.isDisabled,
                                    'cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-[var(--radius-component-sm)]': day.isCurrentMonth && !day.isStartDate && !day.isEndDate && !day.isInRange && !this.selecting && !this.updating && !day.isDisabled,
                                    'cursor-pointer hover:bg-primary-200 dark:hover:bg-primary-800 rounded-[var(--radius-component-sm)]': day.isCurrentMonth && this.selecting && !day.isStartDate && !this.updating && !day.isDisabled,
                                    'ring-2 ring-primary-400 dark:ring-primary-600 animate-pulse': (this.selecting && day.isStartDate) || (this.updating && (day.isStartDate || day.isEndDate)),
                                    'opacity-50': !day.isCurrentMonth && (this.selecting || this.updating),
                                    'text-gray-300 dark:text-gray-600 cursor-not-allowed': day.isDisabled,
                                    'line-through': day.isDisabled,
                                    'transition-all duration-200 ease-in-out': true
                                }"
                                class="aspect-square transition-colors duration-100 text-sm relative"
                            >
                                @isset($day)
                                    <div class="absolute top-1 left-1 text-xs font-medium leading-none" x-text="day.date"></div>
                                    <div class="w-full h-full p-1 pt-4">
                                        {{ $day }}
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span x-text="day.date"></span>
                                    </div>
                                @endisset
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
        </div>
    </div>

    @isset($footer)
        <div class="w-full border-t border-border p-4">
            {{ $footer }}
        </div>
    @else
        @if($showClearButton)
            <div class="w-full border-t border-border p-4">
                <div class="flex justify-end">
                    <button
                        x-on:click="clearSelection()"
                        type="button"
                        class="px-3 py-1.5 text-sm rounded-[var(--radius-component-sm)] text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                    >
                        {{ trans('strata::calendar.clear', [], $locale) }}
                    </button>
                </div>
            </div>
        @endif
    @endisset
</div>

<script>
document.addEventListener('alpine:initializing', () => {
    /**
     * Alpine.js date range picker component
     * @param {Object} config - Configuration object for the date picker
     * @param {Object} config.value - Initial date range value with start and end properties
     * @param {string} config.initialDate - Initial date to display in ISO string format
     * @param {number} config.weekStart - Week start day (0 for Sunday, 1 for Monday)
     * @param {number} config.monthsToShow - Number of months to display simultaneously
     * @param {boolean} config.range - Whether to allow range selection
     * @param {string} config.locale - Locale string for date formatting
     * @param {Object} config.presets - Predefined date range presets
     * @param {boolean} config.initialSelecting - Initial selecting state
     * @param {boolean} config.initialUpdating - Initial updating state
     * @param {string} config.minDate - Minimum selectable date
     * @param {string} config.maxDate - Maximum selectable date
     * @param {Array} config.disabledDates - Array of disabled date strings
     * @param {boolean} config.showClearButton - Whether to show clear button
     * @param {boolean} config.closeOnSelect - Whether to auto-close on selection
     * @returns {Object} Alpine.js data object
     */
    Alpine.data('dateRangePicker', (config) => {
        /**
         * Parse date strings as local dates to avoid timezone issues
         * @param {string} dateString - Date string in YYYY-MM-DD format
         * @returns {Date|null} Parsed date or null if invalid
         */
        const parseDate = (dateString) => {
            if (!dateString) return null;
            
            const [year, month, day] = dateString.split('-').map(Number);
            return new Date(year, month - 1, day);
        };

        /**
         * Format dates as YYYY-MM-DD without timezone conversion
         * @param {Date} date - Date object to format
         * @returns {string|null} Formatted date string or null if invalid
         */
        const toLocalDateString = (date) => {
            if (!date) return null;
            
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        return {
            value: config.value,
            config: config,
            currentDate: new Date(config.initialDate),
            startDate: config.value.start ? parseDate(config.value.start) : null,
            endDate: config.value.end ? parseDate(config.value.end) : null,
            selecting: config.initialSelecting || false,
            updating: config.initialUpdating || false,
            months: [],
            headerText: '',
            activePreset: '',

            init() {
                // Initialize Livewire state sync if available
                this.initializeLivewireSync();
                
                this.$watch('value', (newValue) => {
                    this.startDate = newValue.start ? parseDate(newValue.start) : null;
                    this.endDate = newValue.end ? parseDate(newValue.end) : null;
                    this.generateMonths();
                });
                this.generateMonths();
            },

            parseDate(dateString) {
                return parseDate(dateString);
            },

            formatLocalDate(date) {
                return toLocalDateString(date);
            },

        initializeLivewireSync() {
            // Only setup Livewire sync if $wire is available
            if (typeof $wire !== 'undefined' && $wire) {
                try {
                    this.selecting = $wire.entangle('selecting');
                    this.updating = $wire.entangle('updating');
                } catch (error) {
                    console.warn('Livewire entanglement failed, using local state:', error);
                }
            }
        },

        generateMonths() {
            const months = [];
            for (let i = 0; i < this.config.monthsToShow; i++) {
                const date = new Date(this.currentDate);
                date.setMonth(date.getMonth() + i);
                months.push(this.generateCalendarData(date));
            }
            this.months = months;
            this.updateHeaderText();
        },

        generateCalendarData(date) {
            const year = date.getFullYear();
            const month = date.getMonth();
            const monthYear = date.toLocaleDateString(this.config.locale, { month: 'long', year: 'numeric' });
            const firstDayOfMonth = new Date(year, month, 1);
            let dayOfWeek = firstDayOfMonth.getDay();

            if (this.config.weekStart === 'monday') {
                dayOfWeek = (dayOfWeek === 0) ? 6 : dayOfWeek - 1;
            }

            const days = [];

            // Add previous month's days
            for (let i = dayOfWeek; i > 0; i--) {
                days.push(this.formatDay(new Date(year, month, 1 - i), false));
            }

            // Add current month's days
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            for (let i = 1; i <= daysInMonth; i++) {
                days.push(this.formatDay(new Date(year, month, i), true));
            }

            // Add next month's days to complete the final week only
            const totalDaysNeeded = Math.ceil((dayOfWeek + daysInMonth) / 7) * 7;
            while (days.length < totalDaysNeeded) {
                const nextDate = days.length - dayOfWeek - daysInMonth + 1;
                days.push(this.formatDay(new Date(year, month + 1, nextDate), false));
            }

            return { monthYear, days };
        },

        formatDay(date, isCurrentMonth) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            date.setHours(0, 0, 0, 0);

            const isStartDate = this.startDate && date.getTime() === this.startDate.getTime();
            const isEndDate = this.endDate && date.getTime() === this.endDate.getTime();

            let isInRange = false;
            if (this.startDate && this.endDate) {
                isInRange = date > this.startDate && date < this.endDate;
            }

            const isDisabled = this.isDateDisabled(date);

            return {
                date: date.getDate(),
                fullDate: new Date(date),
                isCurrentMonth,
                isToday: date.getTime() === today.getTime(),
                isStartDate,
                isEndDate,
                isInRange,
                isSelecting: this.selecting,
                isUpdating: this.updating,
                isDisabled
            };
        },

        isDateDisabled(date) {
            const dateString = date.toISOString().split('T')[0];
            
            // Check min date
            if (this.config.minDate && date < this.parseDate(this.config.minDate)) {
                return true;
            }
            
            // Check max date
            if (this.config.maxDate && date > this.parseDate(this.config.maxDate)) {
                return true;
            }
            
            // Check disabled dates array
            if (this.config.disabledDates && this.config.disabledDates.includes(dateString)) {
                return true;
            }
            
            return false;
        },

        selectDate(day) {
            if (!day.isCurrentMonth || day.isDisabled) return;

            if (!this.config.range) {
                this.startDate = this.endDate = new Date(day.fullDate);
                this.selecting = false;
                this.updateValue();
                this.generateMonths();
                
                // Auto-close if enabled
                if (this.config.closeOnSelect) {
                    this.$dispatch('calendar-close');
                }
            } else if (!this.selecting || !this.startDate) {
                this.startDate = new Date(day.fullDate);
                this.endDate = null;
                this.selecting = true;
                this.activePreset = '';
                this.generateMonths();
                // Don't update value yet - wait for end date
            } else {
                if (day.fullDate < this.startDate) {
                    this.endDate = this.startDate;
                    this.startDate = new Date(day.fullDate);
                } else {
                    this.endDate = new Date(day.fullDate);
                }
                this.selecting = false;
                this.updateValue();
                this.generateMonths();
                
                // Auto-close if enabled and range is complete
                if (this.config.closeOnSelect) {
                    this.$dispatch('calendar-close');
                }
            }
        },

        clearSelection() {
            this.startDate = null;
            this.endDate = null;
            this.selecting = false;
            this.activePreset = '';
            this.updateValue();
            this.generateMonths();
        },

        setPreset(label) {
            if (!this.config.presets[label]) return;

            const [start, end] = this.config.presets[label];
            this.startDate = new Date(start);
            this.endDate = new Date(end);
            this.activePreset = label;
            this.selecting = false;
            this.currentDate = new Date(start);

            this.updateValue();
            this.generateMonths();
        },

        isPresetActive(label) {
            if (this.activePreset) return this.activePreset === label;

            if (!this.config.presets[label] || !this.startDate || !this.endDate) return false;

            const [start, end] = this.config.presets[label].map(d => {
                const date = new Date(d);
                date.setHours(0, 0, 0, 0);
                return date.getTime();
            });

            const currentStart = new Date(this.startDate);
            currentStart.setHours(0, 0, 0, 0);
            const currentEnd = new Date(this.endDate);
            currentEnd.setHours(0, 0, 0, 0);

            return currentStart.getTime() === start && currentEnd.getTime() === end;
        },

        updateHeaderText() {
            if (this.months.length === 0) return;

            const startMonth = this.months[0].monthYear;
            const endMonth = this.months[this.months.length - 1].monthYear;
            this.headerText = startMonth === endMonth ? startMonth : `${startMonth} - ${endMonth}`;
        },

        prevMonths() {
            this.currentDate = new Date(this.currentDate);
            this.currentDate.setMonth(this.currentDate.getMonth() - this.config.monthsToShow);
            this.generateMonths();
        },

        nextMonths() {
            this.currentDate = new Date(this.currentDate);
            this.currentDate.setMonth(this.currentDate.getMonth() + this.config.monthsToShow);
            this.generateMonths();
        },

        updateValue() {
            this.updating = true;
            this.value = {
                start: this.startDate ? toLocalDateString(this.startDate) : null,
                end: this.endDate ? toLocalDateString(this.endDate) : null
            };
            this.updating = false;
        }
    };
    });
});
</script>
