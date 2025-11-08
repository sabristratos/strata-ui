@props([])

<style>
    [data-strata-timepicker] input[type="number"]::-webkit-inner-spin-button,
    [data-strata-timepicker] input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    [data-strata-timepicker] input[type="number"] {
        -moz-appearance: textfield;
        appearance: textfield;
    }
</style>

<div class="flex flex-col gap-4 p-4">
    <div class="text-center">
        <div class="text-sm font-medium text-muted-foreground mb-3">Enter time</div>
        <div class="flex items-center justify-center gap-2">
            <x-strata::input
                type="number"
                min="1"
                max="12"
                x-model.number="selectedHour"
                x-ref="hourInput"
                @input="if ($event.target.value > 12) $event.target.value = 12; if ($event.target.value < 1) $event.target.value = null"
                @focus="clockMode = 'hour'"
                placeholder="HH"
                class="w-14 text-center"
            />
            <span class="text-xl font-semibold text-muted-foreground">:</span>
            <x-strata::input
                type="number"
                min="0"
                max="59"
                x-model.number="selectedMinute"
                @input="if ($event.target.value > 59) $event.target.value = 59; if ($event.target.value < 0) $event.target.value = 0"
                @focus="clockMode = 'minute'"
                placeholder="MM"
                class="w-14 text-center"
            />
            <x-strata::group>
                <button
                    type="button"
                    @click="selectedPeriod = 'AM'"
                    :aria-pressed="selectedPeriod === 'AM'"
                    :class="{
                        'bg-primary text-primary-foreground': selectedPeriod === 'AM',
                        'bg-secondary text-secondary-foreground': selectedPeriod !== 'AM'
                    }"
                    class="h-10 px-4 rounded-lg font-medium transition-colors hover:opacity-90 border border-border focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
                >
                    AM
                </button>
                <button
                    type="button"
                    @click="selectedPeriod = 'PM'"
                    :aria-pressed="selectedPeriod === 'PM'"
                    :class="{
                        'bg-primary text-primary-foreground': selectedPeriod === 'PM',
                        'bg-secondary text-secondary-foreground': selectedPeriod !== 'PM'
                    }"
                    class="h-10 px-4 rounded-lg font-medium transition-colors hover:opacity-90 border border-border focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
                >
                    PM
                </button>
            </x-strata::group>
        </div>
    </div>

    <div class="sr-only" aria-live="assertive" role="alert" x-text="clockAnnouncement"></div>

    <div id="clock-instructions" class="sr-only">
        Use arrow keys to select hour or minute. Press Tab to switch between hour and minute selection. Press Enter to confirm selection. Press Escape to close.
    </div>

    <div
        class="relative mx-auto w-full max-w-[280px]"
        style="aspect-ratio: 1;"
        @keydown="handleClockKeydown($event)"
        role="group"
        :aria-label="clockMode === 'hour' ? 'Select hour on clock' : 'Select minute on clock'"
        aria-describedby="clock-instructions"
        tabindex="0"
        x-ref="clockFace"
    >
        <div class="absolute inset-0 rounded-full bg-muted/30 border-2 border-border"></div>

        <div class="absolute top-1/2 left-1/2 w-3 h-3 -ml-1.5 -mt-1.5 rounded-full bg-primary z-20"></div>

        <template x-for="item in (clockMode === 'hour' ? clockHours : clockMinutes)" :key="item.value">
            <button
                type="button"
                @click="clockMode === 'hour' ? selectClockHour(item.value) : selectClockMinute(item.value)"
                :style="`left: ${item.x}px; top: ${item.y}px;`"
                :disabled="item.disabled"
                :class="{
                    'bg-primary text-primary-foreground': (clockMode === 'hour' ? selectedHour : selectedMinute) === item.value,
                    'bg-muted hover:bg-muted/80 text-foreground': (clockMode === 'hour' ? selectedHour : selectedMinute) !== item.value && !item.disabled,
                    'bg-muted/30 text-muted-foreground cursor-not-allowed': item.disabled,
                    'ring-2 ring-ring ring-offset-2 ring-offset-background': highlightedClockValue === item.value
                }"
                class="absolute rounded-full flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 z-10 w-9 h-9 -ml-4.5 -mt-4.5 text-sm"
                @mouseenter="!item.disabled && (hoveredClockValue = item.value)"
                @mouseleave="hoveredClockValue = null"
                x-text="item.label"
            ></button>
        </template>

        <div
            x-show="selectedHour !== null && selectedMinute !== null"
            :style="`transform: rotate(${clockHandAngle}deg); transform-origin: left center; width: ${clockHandLength};`"
            class="absolute top-1/2 left-1/2 h-0.5 bg-primary -mt-px pointer-events-none z-[1]"
        >
            <div class="absolute right-0 top-1/2 w-2 h-2 -mt-1 -mr-1 rounded-full bg-primary"></div>
        </div>
    </div>
</div>
