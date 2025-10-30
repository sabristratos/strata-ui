@props([
    'mode' => 'single',
    'value' => null,
    'minDate' => null,
    'maxDate' => null,
    'disabledDates' => [],
    'weekStartsOn' => 0,
    'monthsToShow' => 1,
    'showPresets' => false,
    'variant' => 'default',
    'size' => 'md',
])

@php
$baseClasses = 'relative';

$sizes = [
    'sm' => 'text-sm',
    'md' => 'text-base',
    'lg' => 'text-lg',
];

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
    'multiple', 'range', 'week' => is_array($value) ? $value : ($value ? [$value] : []),
    default => [],
};
@endphp

<div
    data-strata-calendar-wrapper
    {{ $attributes->merge(['class' => $classes]) }}
    x-data="{
        mode: @js($mode),
        selectedDates: @js($initialValue),
        currentMonth: new Date(),
        focusedDate: null,
        minDate: @js($minDate),
        maxDate: @js($maxDate),
        disabledDates: @js($disabledDates),
        weekStartsOn: @js($weekStartsOn),
        monthsToShow: @js($monthsToShow),
        rangeStart: null,
        rangeEnd: null,

        init() {
            if (this.selectedDates.length > 0) {
                this.currentMonth = new Date(this.selectedDates[0]);
            }

            if (this.mode === 'range' && this.selectedDates.length === 2) {
                this.rangeStart = new Date(this.selectedDates[0]);
                this.rangeEnd = new Date(this.selectedDates[1]);
            }

            this.focusedDate = new Date();

            this.$watch('selectedDates', () => {
                this.syncToLivewire();
            });
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
                    this.selectedDates.splice(index, 1);
                } else {
                    this.selectedDates.push(formattedDate);
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
                    this.rangeStart = start;
                    this.rangeEnd = end;
                    this.selectedDates = [this.formatDate(start), this.formatDate(end)];
                    break;
                case 'lastMonth':
                    start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    end = new Date(today.getFullYear(), today.getMonth(), 0);
                    this.rangeStart = start;
                    this.rangeEnd = end;
                    this.selectedDates = [this.formatDate(start), this.formatDate(end)];
                    break;
            }
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
        },

        syncToLivewire() {
            if (!this.$wire) return;

            const wireModelAttribute = Array.from(this.$el.getAttributeNames())
                .find(attr => attr.startsWith('wire:model'));

            if (wireModelAttribute) {
                const propertyName = this.$el.getAttribute(wireModelAttribute);

                if (this.mode === 'single') {
                    this.$wire.set(propertyName, this.selectedDates[0] || null);
                } else {
                    this.$wire.set(propertyName, this.selectedDates);
                }
            }
        }
    }"
    @keydown="handleKeydown($event)"
    tabindex="0"
    role="application"
    aria-label="Calendar"
>
    @if($showPresets)
        <x-strata::calendar.presets />
    @endif

    <div class="flex gap-4">
        @for($i = 0; $i < $monthsToShow; $i++)
            <div class="flex-1">
                <x-strata::calendar.header :month-offset="$i" />
                <x-strata::calendar.grid :month-offset="$i" />
            </div>
        @endfor
    </div>
</div>
