@props([
    'mode' => 'single',
    'showPresets' => false,
    'minDate' => null,
    'maxDate' => null,
    'placement' => 'bottom-start',
    'positioningStyle' => '',
    'animationClasses' => '',
])

@php
$dropdownClasses = [
    'bg-popover text-popover-foreground border border-border rounded-lg shadow-lg',
    $animationClasses,
];
@endphp

<div
    :id="$id('datepicker-dropdown')"
    popover="auto"
    @toggle="open = $event.newState === 'open'"
    :style="`{{ $positioningStyle }} position-anchor: --datepicker-${$id('datepicker-dropdown')};`"
    @keydown.escape.window="open = false"
    @date-selected="handleDateSelected($event.detail)"
    data-strata-datepicker-dropdown
    data-placement="{{ $placement }}"
    x-trap.nofocus="open"
    wire:ignore.self
    tabindex="-1"
    {{ $attributes->merge(['class' => implode(' ', $dropdownClasses)]) }}
    role="dialog"
    aria-modal="true"
>
        <div class="flex">
        <div class="flex-1 p-4">
            <x-strata::calendar
                :mode="$mode"
                :min-date="$minDate"
                :max-date="$maxDate"
                variant="minimal"
                size="md"
            />
        </div>

        @if ($showPresets && $mode === 'range')
            <div class="border-l border-border w-48 p-4">
                <h3 class="text-sm font-semibold text-foreground mb-3">Quick Select</h3>

                <div class="space-y-1">
                    <button
                        type="button"
                        @click="selectPreset('today')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Today
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('yesterday')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Yesterday
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('thisWeek')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        This Week
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('lastWeek')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Last Week
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('last7Days')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Last 7 Days
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('last30Days')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Last 30 Days
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('thisMonth')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        This Month
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('lastMonth')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Last Month
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('thisYear')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        This Year
                    </button>
                </div>
            </div>
        @endif

        @if ($showPresets && $mode === 'single')
            <div class="border-l border-border w-40 p-4">
                <h3 class="text-sm font-semibold text-foreground mb-3">Quick Select</h3>

                <div class="space-y-1">
                    <button
                        type="button"
                        @click="selectPreset('today')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Today
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('tomorrow')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Tomorrow
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('nextWeek')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Next Week
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('nextMonth')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        Next Month
                    </button>
                </div>
            </div>
        @endif
        </div>
</div>
