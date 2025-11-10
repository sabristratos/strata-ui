@props([
    'id' => null,
    'name' => null,
    'format' => 'hex',
    'value' => null,
    'placeholder' => 'Select color',
    'state' => 'default',
    'size' => 'md',
    'variant' => 'faded',
    'disabled' => false,
    'clearable' => true,
    'allowAlpha' => false,
    'showPresets' => true,
    'presets' => [],
    'placement' => 'bottom-start',
    'offset' => 8,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Config\ComponentVariantConfig;
use Stratos\StrataUI\Support\ComponentHelpers;
use Stratos\StrataUI\Support\PositioningHelper;

$componentId = ComponentHelpers::generateId('color-picker', $id, $attributes);

$sizes = ComponentSizeConfig::inputSizes();

$states = ComponentStateConfig::pickerStates();

$variants = ComponentVariantConfig::inputVariants();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$stateClasses = $states[$state] ?? $states['default'];
$variantClasses = $variants[$variant] ?? $variants['faded'];

$defaultPresets = [
    '#09090b' => 'Primary',
    '#71717a' => 'Secondary',
    '#3b82f6' => 'Accent',
    '#ef4444' => 'Destructive',
    '#22c55e' => 'Success',
    '#f59e0b' => 'Warning',
    '#6b7280' => 'Muted',
    '#ffffff' => 'White',
];

$finalPresets = empty($presets) ? $defaultPresets : $presets;

$positioning = PositioningHelper::getAnchorPositioning($placement, $offset);
$positioningStyle = $positioning['style'];
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataColorPicker', window.strataColorPicker);
});
</script>
@endonce

<div
    x-data="window.strataColorPicker({
        format: '{{ $format }}',
        initialValue: {{ json_encode($value) }},
        placeholder: '{{ $placeholder }}',
        disabled: {{ $disabled ? 'true' : 'false' }},
        clearable: {{ $clearable ? 'true' : 'false' }},
        allowAlpha: {{ $allowAlpha ? 'true' : 'false' }},
        showPresets: {{ $showPresets ? 'true' : 'false' }},
        presets: {{ json_encode(array_keys($finalPresets)) }},
    })"
    x-id="['colorpicker-dropdown']"
    data-strata-colorpicker
    data-strata-field-type="color"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative overflow-visible']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="entangleable.value"
            data-strata-colorpicker-input
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    <div class="relative">
        <x-strata::color-picker.trigger
            :component-id="$componentId"
            :size="$size"
            :state="$state"
            :disabled="$disabled"
            :size-classes="$sizeClasses"
            :state-classes="$stateClasses"
            :variant-classes="$variantClasses"
        />

        @if($clearable)
        <div class="absolute right-10 top-1/2 -translate-y-1/2 pointer-events-auto">
            <x-strata::color-picker.clear size="sm" />
        </div>
        @endif
    </div>

    <x-strata::color-picker.dropdown
        :format="$format"
        :show-presets="$showPresets"
        :presets="$finalPresets"
        :allow-alpha="$allowAlpha"
        :placement="$placement"
        :positioning-style="$positioningStyle"
    />
</div>
