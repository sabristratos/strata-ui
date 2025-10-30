@props([
    'mode' => 'single',
    'value' => null,
    'placeholder' => 'Select date...',
    'minDate' => null,
    'maxDate' => null,
    'disabledDates' => [],
    'weekStartsOn' => 0,
    'monthsToShow' => 1,
    'showPresets' => false,
    'variant' => 'default',
    'size' => 'md',
    'state' => 'default',
    'disabled' => false,
    'clearable' => true,
])

@php
$id = $attributes->get('id', 'calendar-input-' . uniqid());

$baseClasses = 'relative';

$inputAttributes = $attributes->except(['class', 'id']);
@endphp

<div
    data-strata-calendar-input-wrapper
    {{ $attributes->only(['class', 'id']) }}
    x-data="{
        open: false,
        displayValue: @js($value),

        init() {
            this.$watch('displayValue', (value) => {
                this.syncToLivewire();
            });
        },

        formatDisplayValue() {
            if (!this.displayValue) return '';

            if (@js($mode) === 'single') {
                return new Date(this.displayValue).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            } else if (@js($mode) === 'range' && Array.isArray(this.displayValue) && this.displayValue.length === 2) {
                const start = new Date(this.displayValue[0]).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric'
                });
                const end = new Date(this.displayValue[1]).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
                return `${start} - ${end}`;
            } else if (Array.isArray(this.displayValue)) {
                return `${this.displayValue.length} dates selected`;
            }

            return '';
        },

        clearValue() {
            this.displayValue = @js($mode) === 'single' ? null : [];
            this.syncToLivewire();
        },

        syncToLivewire() {
            if (!this.$wire) return;

            const wireModelAttribute = Array.from(this.$el.getAttributeNames())
                .find(attr => attr.startsWith('wire:model'));

            if (wireModelAttribute) {
                const propertyName = this.$el.getAttribute(wireModelAttribute);
                this.$wire.set(propertyName, this.displayValue);
            }
        }
    }"
    @click.away="open = false"
>
    <div class="relative">
        <x-strata::input
            type="text"
            :id="$id"
            :placeholder="$placeholder"
            :size="$size"
            :variant="$variant"
            :state="$state"
            :disabled="$disabled"
            readonly
            @click="if (!{{ $disabled ? 'true' : 'false' }}) open = !open"
            x-bind:value="formatDisplayValue()"
            class="cursor-pointer pr-20"
        />

        <div class="absolute inset-y-0 right-0 flex items-center pr-3 gap-1">
            @if($clearable)
                <button
                    type="button"
                    @click.stop="clearValue()"
                    x-show="displayValue && (Array.isArray(displayValue) ? displayValue.length > 0 : true)"
                    class="p-1 hover:bg-muted rounded transition-colors"
                    aria-label="Clear selection"
                >
                    <x-strata::icon.x class="w-4 h-4 text-muted-foreground" />
                </button>
            @endif

            <button
                type="button"
                @click.stop="if (!{{ $disabled ? 'true' : 'false' }}) open = !open"
                class="p-1 hover:bg-muted rounded transition-colors"
                aria-label="Toggle calendar"
            >
                <x-strata::icon.calendar class="w-4 h-4 text-muted-foreground" />
            </button>
        </div>
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 p-4 bg-background border border-border rounded-lg shadow-lg"
        @click.stop
    >
        <div
            x-data="{
                calendarValue: displayValue,

                init() {
                    this.$watch('calendarValue', (value) => {
                        displayValue = value;

                        if (@js($mode) === 'single' || (@js($mode) === 'range' && Array.isArray(value) && value.length === 2)) {
                            setTimeout(() => { open = false; }, 100);
                        }
                    });
                }
            }"
        >
            <x-strata::calendar
                :mode="$mode"
                x-model="calendarValue"
                :min-date="$minDate"
                :max-date="$maxDate"
                :disabled-dates="$disabledDates"
                :week-starts-on="$weekStartsOn"
                :months-to-show="$monthsToShow"
                :show-presets="$showPresets"
                variant="minimal"
            />
        </div>
    </div>
</div>
