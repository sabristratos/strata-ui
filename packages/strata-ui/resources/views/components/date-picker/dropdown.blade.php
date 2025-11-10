@props([
    'mode' => 'single',
    'showPresets' => false,
    'minDate' => null,
    'maxDate' => null,
    'placement' => 'bottom-start',
    'positioningStyle' => '',
])

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
    {{ $attributes->merge(['class' => 'animate-dropdown-bounce bg-popover text-popover-foreground border border-border rounded-lg shadow-lg']) }}
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
                <h3 class="text-sm font-semibold text-foreground mb-3">{{ __('Quick Select') }}</h3>

                <div class="space-y-1">
                    <button
                        type="button"
                        @click="selectPreset('today')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Today') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('yesterday')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Yesterday') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('thisWeek')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('This week') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('lastWeek')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Last Week') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('last7Days')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Last 7 days') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('last30Days')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Last 30 days') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('thisMonth')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('This month') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('lastMonth')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Last month') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('thisYear')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('This year') }}
                    </button>
                </div>
            </div>
        @endif

        @if ($showPresets && $mode === 'single')
            <div class="border-l border-border w-40 p-4">
                <h3 class="text-sm font-semibold text-foreground mb-3">{{ __('Quick Select') }}</h3>

                <div class="space-y-1">
                    <button
                        type="button"
                        @click="selectPreset('today')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Today') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('tomorrow')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Tomorrow') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('nextWeek')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Next Week') }}
                    </button>

                    <button
                        type="button"
                        @click="selectPreset('nextMonth')"
                        class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-accent hover:text-accent-foreground transition-colors duration-150"
                    >
                        {{ __('Next Month') }}
                    </button>
                </div>
            </div>
        @endif
        </div>
</div>
