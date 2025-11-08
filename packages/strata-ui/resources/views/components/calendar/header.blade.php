@props([
    'monthOffset' => 0,
])

@php
$pickerId = 'monthpicker-' . $monthOffset . '-' . uniqid();
@endphp

<div
    data-strata-calendar-header
    class="flex items-center justify-between mb-4"
    x-data="{
        showMonthPicker: false,
        years: [],
        selectedYear: null,
        selectedMonth: null,

        init() {
            for (let i = yearRangeStart; i <= yearRangeEnd; i++) {
                this.years.push(i);
            }

            const validMonth = (currentMonth && currentMonth instanceof Date) ? currentMonth : new Date();
            this.selectedYear = validMonth.getFullYear();
            this.selectedMonth = validMonth.getMonth() + {{ $monthOffset }};
        },

        toggleMonthPicker() {
            const dropdown = document.getElementById('{{ $pickerId }}');
            if (dropdown) {
                if (this.showMonthPicker) {
                    dropdown.hidePopover();
                } else {
                    dropdown.showPopover();
                }
            }
        },

        selectMonth(index) {
            this.selectedMonth = index;
            goToMonth(this.selectedMonth - {{ $monthOffset }}, this.selectedYear);
            const dropdown = document.getElementById('{{ $pickerId }}');
            if (dropdown) {
                dropdown.hidePopover();
            }
        },

        changeYear() {
            goToMonth(this.selectedMonth - {{ $monthOffset }}, this.selectedYear);
        }
    }"
>
    <x-strata::button.icon
        icon="chevron-left"
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="previousMonth()"
        aria-label="{{ __('Previous month') }}"
        x-show="{{ $monthOffset }} === 0"
    />

    <div class="flex-1 flex items-center justify-center gap-2 relative">
        <h2
            class="text-lg font-semibold text-foreground"
            x-text="formatMonthYear(new Date(currentMonth.getFullYear(), currentMonth.getMonth() + {{ $monthOffset }}, 1))"
        ></h2>

        <x-strata::button.icon
            x-ref="monthPickerButton{{ $monthOffset }}"
            style="anchor-name: --monthpicker-{{ $pickerId }};"
            icon="calendar"
            size="sm"
            variant="secondary"
            appearance="ghost"
            @click="toggleMonthPicker()"
            x-bind:aria-expanded="showMonthPicker"
            aria-label="{{ __('Select month and year') }}"
        />

        <x-strata::calendar.month-picker
            :month-offset="$monthOffset"
            :picker-id="$pickerId"
        />
    </div>

    <x-strata::button
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="goToToday()"
        x-show="{{ $monthOffset }} === (monthsToShow - 1)"
        class="mr-2"
    >
        {{ __('Today') }}
    </x-strata::button>

    <x-strata::button.icon
        icon="chevron-right"
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="nextMonth()"
        aria-label="{{ __('Next month') }}"
        x-show="{{ $monthOffset }} === (monthsToShow - 1)"
    />
</div>
