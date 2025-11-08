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
    'chips' => false,
    'placement' => 'bottom-start',
    'offset' => 8,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;
use Stratos\StrataUI\Support\PositioningHelper;

$componentId = ComponentHelpers::generateId('date-picker', $id, $attributes);
$placeholder = $placeholder ?? ($mode === 'range' ? 'Select date range' : 'Select date');

$sizes = $chips
    ? ComponentSizeConfig::datePickerSizesWithChips()
    : ComponentSizeConfig::inputSizes();

$states = ComponentStateConfig::pickerStates();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$stateClasses = $states[$state] ?? $states['default'];

$initialValue = $value instanceof \Stratos\StrataUI\Data\DateValue
    ? $value->toString()
    : ($value instanceof \Stratos\StrataUI\Data\DateRange
        ? ['start' => $value->start->toDateString(), 'end' => $value->end->toDateString()]
        : $value);

$positioning = PositioningHelper::getAnchorPositioning($placement, $offset);
$positioningStyle = $positioning['style'];

$animationClasses = '[&[popover]]:[transition:opacity_150ms,transform_150ms,overlay_150ms_allow-discrete,display_150ms_allow-discrete] ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95';
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
        chips: {{ $chips ? 'true' : 'false' }},
    })"
    x-id="['datepicker-dropdown']"
    data-strata-datepicker
    data-strata-field-type="date"
    data-disabled="{{ $disabled ? 'true' : 'false' }}"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative overflow-visible']) }}
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
            :chips="$chips"
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
        :placement="$placement"
        :positioning-style="$positioningStyle"
        :animation-classes="$animationClasses"
    />
</div>
