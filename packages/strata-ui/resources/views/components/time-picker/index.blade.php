{{--
/**
 * Time Picker Component
 *
 * Interactive time selection component with keyboard navigation, presets, and constraints.
 * Uses Popover API for top-layer management and CSS Anchor Positioning for layout.
 *
 * @props
 * @prop string|null $id - Unique component ID (default: auto-generated)
 * @prop string|null $name - Form input name (default: null)
 * @prop string $format - Time format: '12'|'24' (default: '12')
 * @prop string|null $value - Selected time in HH:MM format (default: null)
 * @prop int $stepMinutes - Minute interval for time list: 15|30|60 (default: 15)
 * @prop string|null $minTime - Minimum selectable time in HH:MM format (default: null)
 * @prop string|null $maxTime - Maximum selectable time in HH:MM format (default: null)
 * @prop array $disabledTimes - Array of disabled times in HH:MM format (default: [])
 * @prop bool $showPresets - Show preset time buttons (Now, Morning, Noon, etc.) (default: false)
 * @prop string $placeholder - Placeholder text (default: 'Select time')
 * @prop string $state - Validation state: 'default'|'success'|'error'|'warning' (default: 'default')
 * @prop string $size - Component size: 'sm'|'md'|'lg' (default: 'md')
 * @prop bool $disabled - Disable the time picker (default: false)
 * @prop bool $readonly - Make time picker read-only (default: false)
 * @prop bool $required - Mark as required field (default: false)
 * @prop bool $clearable - Show clear button to reset selection (default: true)
 * @prop string $placement - Popover placement: 'bottom-start'|'bottom-end'|'top-start'|'top-end' (default: 'bottom-start')
 * @prop int $offset - Offset from anchor element in pixels (default: 8)
 *
 * @slots
 * @slot default - Not used, times are generated automatically
 *
 * @example Basic usage
 * <x-strata::time-picker wire:model="meetingTime" />
 *
 * @example 24-hour format with 30-minute steps
 * <x-strata::time-picker
 *     wire:model="appointmentTime"
 *     format="24"
 *     :step-minutes="30"
 * />
 *
 * @example Business hours only (9 AM - 5 PM)
 * <x-strata::time-picker
 *     wire:model="workTime"
 *     min-time="09:00"
 *     max-time="17:00"
 *     placeholder="Select business hours"
 * />
 *
 * @example With presets for quick selection
 * <x-strata::time-picker
 *     wire:model="reminderTime"
 *     :show-presets="true"
 *     :clearable="true"
 * />
 *
 * @example Required field with validation
 * <x-strata::time-picker
 *     wire:model="requiredTime"
 *     :required="true"
 *     state="error"
 *     placeholder="Time is required"
 * />
 */
--}}

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
    'variant' => 'faded',
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'clearable' => true,
    'placement' => 'bottom-start',
    'offset' => 8,
    'displayMode' => 'clock',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Config\ComponentVariantConfig;
use Stratos\StrataUI\Support\ComponentHelpers;
use Stratos\StrataUI\Support\PositioningHelper;

$componentId = ComponentHelpers::generateId('time-picker', $id, $attributes);

$sizes = ComponentSizeConfig::inputSizes();

$states = ComponentStateConfig::pickerStates();

$variants = ComponentVariantConfig::inputVariants();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$stateClasses = $states[$state] ?? $states['default'];
$variantClasses = $variants[$variant] ?? $variants['faded'];

if ($value instanceof \Stratos\StrataUI\Data\TimeValue) {
    $hour = $value->to24HourFormat();
    $initialValue = sprintf('%02d:%02d', $hour, $value->minute);
} else {
    $initialValue = $value;
}

$positioning = PositioningHelper::getAnchorPositioning($placement, $offset);
$positioningStyle = $positioning['style'];
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
        readonly: {{ $readonly ? 'true' : 'false' }},
        required: {{ $required ? 'true' : 'false' }},
        clearable: {{ $clearable ? 'true' : 'false' }},
        displayMode: '{{ $displayMode }}',
    })"
    x-id="['timepicker-dropdown']"
    data-strata-timepicker
    data-strata-field-type="time"
    data-disabled="{{ $disabled ? 'true' : 'false' }}"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative overflow-visible']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="entangleable?.value !== undefined ? JSON.stringify(entangleable.value) : ''"
            data-strata-timepicker-input
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    <x-strata::time-picker.trigger
        :component-id="$componentId"
        :size="$size"
        :state="$state"
        :disabled="$disabled"
        :readonly="$readonly"
        :required="$required"
        :clearable="$clearable"
        :size-classes="$sizeClasses"
        :state-classes="$stateClasses"
        :variant-classes="$variantClasses"
    />

    <x-strata::time-picker.dropdown
        :format="$format"
        :show-presets="$showPresets"
        :positioning-style="$positioningStyle"
        :placement="$placement"
        :display-mode="$displayMode"
    />
</div>
