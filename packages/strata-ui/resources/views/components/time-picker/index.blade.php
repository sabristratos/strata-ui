@props([
    'id' => null,
    'name' => null,
    'format' => '12',
    'value' => null,
    'stepMinutes' => 15,
    'minTime' => null,
    'maxTime' => null,
    'disabledTimes' => [],
    'showPresets' => false,
    'placeholder' => 'Select time',
    'state' => 'default',
    'size' => 'md',
    'disabled' => false,
    'clearable' => true,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$componentId = ComponentHelpers::generateId('time-picker', $id, $attributes);

$sizes = ComponentSizeConfig::inputSizes();

$states = ComponentStateConfig::pickerStates();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$stateClasses = $states[$state] ?? $states['default'];

if ($value instanceof \Stratos\StrataUI\Data\TimeValue) {
    $hour = $value->to24HourFormat();
    $initialValue = sprintf('%02d:%02d', $hour, $value->minute);
} else {
    $initialValue = $value;
}
@endphp

<div
    x-data="window.strataTimePicker({
        format: '{{ $format }}',
        initialValue: {{ json_encode($initialValue) }},
        stepMinutes: {{ $stepMinutes }},
        minTime: {{ json_encode($minTime) }},
        maxTime: {{ json_encode($maxTime) }},
        disabledTimes: {{ json_encode($disabledTimes) }},
        placeholder: '{{ $placeholder }}',
        disabled: {{ $disabled ? 'true' : 'false' }},
        clearable: {{ $clearable ? 'true' : 'false' }},
    })"
    data-strata-timepicker
    data-strata-field-type="time"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative overflow-visible']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="entangleable.value"
            data-strata-timepicker-input
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    <div class="relative">
        <x-strata::time-picker.trigger
            :component-id="$componentId"
            :size="$size"
            :state="$state"
            :disabled="$disabled"
            :clearable="$clearable"
            :size-classes="$sizeClasses"
            :state-classes="$stateClasses"
        />

        <div class="absolute right-10 top-1/2 -translate-y-1/2 pointer-events-auto">
            <x-strata::time-picker.clear size="sm" />
        </div>
    </div>

    <x-strata::time-picker.dropdown
        :format="$format"
        :show-presets="$showPresets"
    />
</div>
