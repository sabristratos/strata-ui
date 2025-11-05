@props([
    'mode' => 'single',
    'value' => null,
    'minDate' => null,
    'maxDate' => null,
    'disabledDates' => [],
    'weekStartsOn' => 0,
    'monthsToShow' => 1,
    'showPresets' => false,
    'yearRangeStart' => null,
    'yearRangeEnd' => null,
    'variant' => 'default',
    'size' => 'md',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$baseClasses = 'relative';

$sizes = ComponentSizeConfig::calendarSizes();

$variants = [
    'default' => '',
    'bordered' => 'border border-border rounded-lg p-4',
    'card' => 'border border-border rounded-lg shadow-lg p-4',
    'minimal' => '',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$variantClasses = $variants[$variant] ?? $variants['default'];

$classes = trim("$baseClasses $sizeClasses $variantClasses");

$initialValue = match($mode) {
    'single' => $value ? [$value] : [],
    'range' => is_array($value)
        ? (isset($value['start']) && isset($value['end'])
            ? [$value['start'], $value['end']]
            : $value)
        : ($value ? [$value] : []),
    'multiple', 'week' => is_array($value) ? $value : ($value ? [$value] : []),
    default => [],
};

$currentYear = date('Y');
$yearRangeStart = $yearRangeStart ?? ($currentYear - 50);
$yearRangeEnd = $yearRangeEnd ?? ($currentYear + 10);

$inputAttributes = $attributes->except(['class']);
$wrapperAttributes = $attributes->only(['class']);
@endphp

<div
    data-strata-calendar-wrapper
    data-strata-field-type="calendar"
    {{ $wrapperAttributes->merge(['class' => $classes]) }}
    wire:ignore
    x-data="{
        ...window.createEntangleableMixin({
            initialValue: @js($initialValue),
            inputSelector: '[data-strata-calendar-input]',
            afterWatch: function(newValue) {
                this.syncFromEntangleable(newValue);
            }
        }),

        mode: @js($mode),
        selectedDates: @js($initialValue),
        currentMonth: new Date(),
        focusedDate: null,
        minDate: @js($minDate),
        maxDate: @js($maxDate),
        disabledDates: @js($disabledDates),
        weekStartsOn: @js($weekStartsOn),
        monthsToShow: @js($monthsToShow),
        yearRangeStart: @js($yearRangeStart),
        yearRangeEnd: @js($yearRangeEnd),
        rangeStart: null,
        rangeEnd: null,

        init() {
            const input = this.$el.querySelector('[data-strata-calendar-input]');
            if (input) {
                this.initEntangleable();

                const initialValue = this.entangleable.get();
                if (initialValue) {
                    this.syncFromEntangleable(initialValue);
                }
            } else {
                if (this.selectedDates.length > 0) {
                    const date = new Date(this.selectedDates[0]);
                    if (!isNaN(date.getTime())) {
                        this.currentMonth = date;
                    }
                }

                if (this.mode === 'range' && this.selectedDates.length === 2) {
                    this.rangeStart = new Date(this.selectedDates[0]);
                    this.rangeEnd = new Date(this.selectedDates[1]);
                }
            }

            this.focusedDate = new Date();
        },

        syncFromEntangleable(value) {
            if (this.mode === 'single') {
                this.selectedDates = value ? [value] : [];
            } else {
                this.selectedDates = Array.isArray(value) ? value : (value ? [value] : []);
            }

            if (this.selectedDates.length > 0) {
                const date = new Date(this.selectedDates[0]);
                if (!isNaN(date.getTime())) {
                    this.currentMonth = date;
                }
            }

            if (this.mode === 'range' && this.selectedDates.length === 2) {
                this.rangeStart = new Date(this.selectedDates[0]);
                this.rangeEnd = new Date(this.selectedDates[1]);
            }
        },

        syncToEntangleable() {
            if (!this.entangleable) return;

            if (this.mode === 'single') {
                this.entangleable.set(this.selectedDates[0] || null);
            } else {
                this.entangleable.set(this.selectedDates);
            }
        },

        selectDate(dateStr) {
            const date = new Date(dateStr);

            if (this.isDisabled(date)) return;

            if (this.mode === 'single') {
                this.selectedDates = [this.formatDate(date)];
            } else if (this.mode === 'multiple') {
                const formattedDate = this.formatDate(date);
                const index = this.selectedDates.indexOf(formattedDate);

                if (index > -1) {
                    this.selectedDates = this.selectedDates.filter((d, i) => i !== index);
                } else {
                    this.selectedDates = [...this.selectedDates, formattedDate];
                }
            } else if (this.mode === 'range') {
                if (!this.rangeStart || (this.rangeStart && this.rangeEnd)) {
                    this.rangeStart = date;
                    this.rangeEnd = null;
                    this.selectedDates = [this.formatDate(date)];
                } else {
                    if (date < this.rangeStart) {
                        this.rangeEnd = this.rangeStart;
                        this.rangeStart = date;
                    } else {
                        this.rangeEnd = date;
                    }
                    this.selectedDates = [
                        this.formatDate(this.rangeStart),
                        this.formatDate(this.rangeEnd)
                    ];
                }
            } else if (this.mode === 'week') {
                const weekDates = this.getWeekDates(date);
                this.selectedDates = weekDates.map(d => this.formatDate(d));
            }

            this.$dispatch('date-selected', {
                dates: this.selectedDates,
                mode: this.mode
            });

            this.syncToEntangleable();
        },

        getWeekDates(date) {
            const day = date.getDay();
            const diff = day - this.weekStartsOn;
            const weekStart = new Date(date);
            weekStart.setDate(date.getDate() - (diff < 0 ? diff + 7 : diff));

            const dates = [];
            for (let i = 0; i < 7; i++) {
                const d = new Date(weekStart);
                d.setDate(weekStart.getDate() + i);
                dates.push(d);
            }
            return dates;
        },

        isSelected(date) {
            const formattedDate = this.formatDate(date);

            if (this.mode === 'range' && this.rangeStart && this.rangeEnd) {
                return date >= this.rangeStart && date <= this.rangeEnd;
            }

            return this.selectedDates.includes(formattedDate);
        },

        isRangeStart(date) {
            if (this.mode !== 'range' || !this.rangeStart) return false;
            return this.isSameDay(date, this.rangeStart);
        },

        isRangeEnd(date) {
            if (this.mode !== 'range' || !this.rangeEnd) return false;
            return this.isSameDay(date, this.rangeEnd);
        },

        isInRange(date) {
            if (this.mode !== 'range' || !this.rangeStart || !this.rangeEnd) return false;
            return date > this.rangeStart && date < this.rangeEnd;
        },

        isToday(date) {
            const today = new Date();
            return this.isSameDay(date, today);
        },

        isSameDay(date1, date2) {
            return date1.getFullYear() === date2.getFullYear() &&
                   date1.getMonth() === date2.getMonth() &&
                   date1.getDate() === date2.getDate();
        },

        isDisabled(date) {
            if (this.minDate && date < new Date(this.minDate)) return true;
            if (this.maxDate && date > new Date(this.maxDate)) return true;

            const formattedDate = this.formatDate(date);
            return this.disabledDates.includes(formattedDate);
        },

        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        formatMonthYear(date) {
            const months = ['January', 'February', 'March', 'April', 'May', 'June',
                          'July', 'August', 'September', 'October', 'November', 'December'];
            return `${months[date.getMonth()]} ${date.getFullYear()}`;
        },

        previousMonth() {
            this.currentMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() - 1, 1);
        },

        nextMonth() {
            this.currentMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() + 1, 1);
        },

        goToMonth(month, year) {
            this.currentMonth = new Date(year, month, 1);
        },

        selectPreset(preset) {
            console.log('[Calendar] selectPreset called', {
                preset: preset,
                mode: this.mode,
                currentSelectedDates: this.selectedDates
            });

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            let start, end;

            switch(preset) {
                case 'today':
                    this.selectedDates = [this.formatDate(today)];
                    break;
                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(today.getDate() - 1);
                    this.selectedDates = [this.formatDate(yesterday)];
                    break;
                case 'thisWeek':
                    const weekDates = this.getWeekDates(today);
                    if (this.mode === 'multiple') {
                        this.selectedDates = weekDates.map(d => this.formatDate(d));
                    } else {
                        this.selectedDates = [this.formatDate(today)];
                    }
                    break;
                case 'last7days':
                    start = new Date(today);
                    start.setDate(today.getDate() - 6);
                    this.rangeStart = start;
                    this.rangeEnd = today;
                    this.selectedDates = [this.formatDate(start), this.formatDate(today)];
                    break;
                case 'last30days':
                    start = new Date(today);
                    start.setDate(today.getDate() - 29);
                    this.rangeStart = start;
                    this.rangeEnd = today;
                    this.selectedDates = [this.formatDate(start), this.formatDate(today)];
                    break;
                case 'thisMonth':
                    start = new Date(today.getFullYear(), today.getMonth(), 1);
                    end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    if (this.mode === 'range') {
                        this.rangeStart = start;
                        this.rangeEnd = end;
                        this.selectedDates = [this.formatDate(start), this.formatDate(end)];
                    } else if (this.mode === 'multiple') {
                        const dates = [];
                        const current = new Date(start);
                        while (current <= end) {
                            dates.push(this.formatDate(new Date(current)));
                            current.setDate(current.getDate() + 1);
                        }
                        this.selectedDates = dates;
                    } else {
                        this.selectedDates = [this.formatDate(today)];
                    }
                    break;
                case 'lastMonth':
                    start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    end = new Date(today.getFullYear(), today.getMonth(), 0);
                    this.rangeStart = start;
                    this.rangeEnd = end;
                    this.selectedDates = [this.formatDate(start), this.formatDate(end)];
                    break;
                case 'thisQuarter':
                    const quarter = Math.floor(today.getMonth() / 3);
                    start = new Date(today.getFullYear(), quarter * 3, 1);
                    end = new Date(today.getFullYear(), quarter * 3 + 3, 0);
                    this.rangeStart = start;
                    this.rangeEnd = end;
                    this.selectedDates = [this.formatDate(start), this.formatDate(end)];
                    break;
                case 'thisYear':
                    start = new Date(today.getFullYear(), 0, 1);
                    end = new Date(today.getFullYear(), 11, 31);
                    this.rangeStart = start;
                    this.rangeEnd = end;
                    this.selectedDates = [this.formatDate(start), this.formatDate(end)];
                    break;
            }

            console.log('[Calendar] Dispatching date-selected event', {
                selectedDates: this.selectedDates,
                mode: this.mode,
                rangeStart: this.rangeStart,
                rangeEnd: this.rangeEnd
            });

            this.$dispatch('date-selected', {
                dates: this.selectedDates,
                mode: this.mode
            });

            this.syncToEntangleable();
        },

        handleKeydown(event) {
            if (!this.focusedDate) this.focusedDate = new Date();

            const key = event.key;
            let handled = false;

            if (key === 'ArrowLeft') {
                this.focusedDate.setDate(this.focusedDate.getDate() - 1);
                handled = true;
            } else if (key === 'ArrowRight') {
                this.focusedDate.setDate(this.focusedDate.getDate() + 1);
                handled = true;
            } else if (key === 'ArrowUp') {
                this.focusedDate.setDate(this.focusedDate.getDate() - 7);
                handled = true;
            } else if (key === 'ArrowDown') {
                this.focusedDate.setDate(this.focusedDate.getDate() + 7);
                handled = true;
            } else if (key === 'Enter' || key === ' ') {
                this.selectDate(this.formatDate(this.focusedDate));
                handled = true;
            }

            if (handled) {
                event.preventDefault();

                if (this.focusedDate.getMonth() !== this.currentMonth.getMonth() ||
                    this.focusedDate.getFullYear() !== this.currentMonth.getFullYear()) {
                    this.currentMonth = new Date(this.focusedDate.getFullYear(), this.focusedDate.getMonth(), 1);
                }
            }
        }
    }"
    @keydown="handleKeydown($event)"
    tabindex="0"
    role="application"
    aria-label="Calendar"
>
    <input
        type="hidden"
        data-strata-calendar-input
        wire:ignore
        {{ $inputAttributes }}
    />

    <div class="flex gap-0">
        @if($showPresets)
            <x-strata::calendar.presets />
        @endif

        <div class="flex gap-4 flex-1">
            @for($i = 0; $i < $monthsToShow; $i++)
                <div class="flex-1">
                    <x-strata::calendar.header :month-offset="$i" />
                    <x-strata::calendar.grid :month-offset="$i" />
                </div>
            @endfor
        </div>
    </div>
</div>
