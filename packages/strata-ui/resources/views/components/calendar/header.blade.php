@props([
    'monthOffset' => 0,
])

<div
    data-strata-calendar-header
    class="flex items-center justify-between mb-4"
    x-data="{ showMonthPicker: false }"
>
    <x-strata::button.icon
        icon="chevron-left"
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="previousMonth()"
        aria-label="Previous month"
        x-show="{{ $monthOffset }} === 0"
    />

    <div class="flex-1 flex items-center justify-center gap-2 relative">
        <h2
            class="text-lg font-semibold"
            x-text="formatMonthYear(new Date(currentMonth.getFullYear(), currentMonth.getMonth() + {{ $monthOffset }}, 1))"
        ></h2>

        <x-strata::button.icon
            icon="calendar"
            size="sm"
            variant="secondary"
            appearance="ghost"
            @click="showMonthPicker = !showMonthPicker"
            aria-label="Select month and year"
        />

        <x-strata::calendar.month-picker
            :month-offset="$monthOffset"
            x-show="showMonthPicker"
            @click.away="showMonthPicker = false"
        />
    </div>

    <x-strata::button.icon
        icon="chevron-right"
        size="sm"
        variant="secondary"
        appearance="ghost"
        @click="nextMonth()"
        aria-label="Next month"
        x-show="{{ $monthOffset }} === monthsToShow - 1"
    />
</div>
