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
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$componentId = ComponentHelpers::generateId('date-picker', $id, $attributes);
$placeholder = $placeholder ?? ($mode === 'range' ? 'Select date range' : 'Select date');

$sizes = ComponentSizeConfig::inputSizes();

$states = ComponentStateConfig::pickerStates();

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
