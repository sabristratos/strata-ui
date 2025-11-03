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
    'name' => null,
])

@php
$id = $attributes->get('id', 'date-picker-' . uniqid());

$inputAttributes = $attributes->except(['class', 'id']);
$wrapperAttributes = $attributes->only(['class', 'id']);
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataDatePicker', (initialValue, mode, disabled, clearable) => ({
        entangleable: null,
        positionable: null,
        mode: mode,
        disabled: disabled,
        clearable: clearable,

        get displayValue() {
            return this.entangleable?.get() ?? (mode === 'single' ? null : []);
        },

        set displayValue(value) {
            this.entangleable?.set(value);
        },

        init() {
            this.entangleable = new window.StrataEntangleable(initialValue);
            this.positionable = new window.StrataPositionable({
                placement: 'bottom-start',
                offset: 8,
                strategy: 'absolute',
                enableSize: true,
                maxHeight: true,
                matchReferenceWidth: false
            });

            this.dropdown = this.$refs.dropdown;
            this.trigger = this.$refs.trigger;

            if (this.dropdown && this.trigger) {
                this.positionable.start(this, this.trigger, this.dropdown);
            }

            const input = this.$el.querySelector('[data-strata-date-picker-input]');
            if (input) {
                this.entangleable.setupLivewire(this, input);
            }

            this.positionable.watch((state) => {
                if (state) {
                    this.$nextTick(() => {
                        if (this.dropdown) {
                            this.dropdown.focus();
                        }
                    });
                }
            });

            this.$el.addEventListener('date-selected', (e) => {
                const { dates, mode } = e.detail;

                if (mode === 'single') {
                    this.displayValue = dates[0] || null;
                } else {
                    this.displayValue = dates;
                }

                if (mode === 'single' || (mode === 'range' && dates.length === 2)) {
                    this.$nextTick(() => {
                        this.positionable.close();
                    });
                }
            });
        },

        formatDisplayValue() {
            if (!this.displayValue) return '';

            if (this.mode === 'single') {
                return new Date(this.displayValue).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            } else if (this.mode === 'range' && Array.isArray(this.displayValue) && this.displayValue.length === 2) {
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

        toggle() {
            if (!this.disabled) {
                this.positionable.toggle();
            }
        },

        clearValue() {
            this.displayValue = this.mode === 'single' ? null : [];
        }
    }));
});
</script>
@endonce

<div
    data-strata-date-picker-wrapper
    data-strata-field-type="date-picker"
    {{ $wrapperAttributes->merge(['class' => 'relative']) }}
    x-data="strataDatePicker(@js($value), @js($mode), {{ $disabled ? 'true' : 'false' }}, {{ $clearable ? 'true' : 'false' }})"
>
    <input
        type="hidden"
        data-strata-date-picker-input
        {{ $inputAttributes }}
    />

    <div x-ref="trigger" class="relative">
        <x-strata::input
            type="text"
            :id="$id"
            :placeholder="$placeholder"
            :size="$size"
            :variant="$variant"
            :state="$state"
            :disabled="$disabled"
            readonly
            @click="toggle()"
            x-bind:value="formatDisplayValue()"
            class="cursor-pointer pr-20"
        />

        <div class="absolute inset-y-0 right-0 flex items-center pr-3 gap-1">
            @if($clearable)
                <x-strata::button.icon
                    icon="x"
                    size="sm"
                    variant="secondary"
                    appearance="ghost"
                    @click.stop="clearValue()"
                    x-show="displayValue && (Array.isArray(displayValue) ? displayValue.length > 0 : true)"
                    aria-label="Clear selection"
                    class="!p-1"
                />
            @endif

            <x-strata::button.icon
                icon="calendar"
                size="sm"
                variant="secondary"
                appearance="ghost"
                @click.stop="toggle()"
                aria-label="Toggle calendar"
                class="!p-1"
            />
        </div>
    </div>

    <div
        x-ref="dropdown"
        x-cloak
        x-show="positionable.state"
        :style="positionable.styles"
        class="absolute top-0 left-0 z-50"
    >
        <div
            x-trap.nofocus="positionable.state"
            @click.outside="positionable.close()"
            @keydown.escape="positionable.close()"
            data-strata-date-picker-dropdown
            wire:ignore.self
            tabindex="-1"
            class="p-4 bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm ring-1 ring-black/5 dark:ring-white/10 m-0 transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95"
        >
            <div wire:ignore>
                <x-strata::calendar
                    :mode="$mode"
                    :value="$value"
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
</div>
