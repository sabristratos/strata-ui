@props([
    'id' => null,
    'name' => null,
    'mode' => 'single',
    'value' => null,
    'minDate' => null,
    'maxDate' => null,
    'showPresets' => false,
    'placeholder' => null,
    'state' => 'default',
    'size' => 'md',
    'disabled' => false,
    'clearable' => true,
])

@php
$componentId = $id ?? $attributes->get('id') ?? 'date-picker-' . uniqid();
$placeholder = $placeholder ?? ($mode === 'range' ? 'Select date range' : 'Select date');

$sizes = [
    'sm' => 'h-9 px-3 text-sm',
    'md' => 'h-10 px-3 text-base',
    'lg' => 'h-11 px-4 text-lg',
];

$states = [
    'default' => 'border-border focus-within:ring-ring',
    'success' => 'border-success focus-within:ring-success/20',
    'error' => 'border-destructive focus-within:ring-destructive/20',
    'warning' => 'border-warning focus-within:ring-warning/20',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$stateClasses = $states[$state] ?? $states['default'];

$initialValue = $value instanceof \Stratos\StrataUI\Data\DateValue
    ? $value->toString()
    : ($value instanceof \Stratos\StrataUI\Data\DateRange
        ? ['start' => $value->start->toDateString(), 'end' => $value->end->toDateString()]
        : $value);
@endphp

<div
    x-data="window.strataDatePicker({
        mode: '{{ $mode }}',
        initialValue: {{ json_encode($initialValue) }},
        minDate: {{ json_encode($minDate) }},
        maxDate: {{ json_encode($maxDate) }},
        placeholder: '{{ $placeholder }}',
        disabled: {{ $disabled ? 'true' : 'false' }},
        clearable: {{ $clearable ? 'true' : 'false' }},
    })"
    data-strata-datepicker
    data-strata-field-type="date"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="JSON.stringify(entangleable.value)"
            data-strata-datepicker-input
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    <div class="relative">
        <x-strata::date-picker.trigger
            :component-id="$componentId"
            :size="$size"
            :state="$state"
            :disabled="$disabled"
            :clearable="$clearable"
            :size-classes="$sizeClasses"
            :state-classes="$stateClasses"
        />

        <div class="absolute right-10 top-1/2 -translate-y-1/2 pointer-events-auto">
            <x-strata::date-picker.clear size="sm" />
        </div>
    </div>

    <x-strata::date-picker.dropdown
        :mode="$mode"
        :show-presets="$showPresets"
        :min-date="$minDate"
        :max-date="$maxDate"
    />
</div>
