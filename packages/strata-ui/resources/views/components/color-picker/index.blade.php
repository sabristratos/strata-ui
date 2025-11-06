@props([
    'id' => null,
    'name' => null,
    'format' => 'hex',
    'value' => null,
    'placeholder' => 'Select color',
    'state' => 'default',
    'size' => 'md',
    'disabled' => false,
    'clearable' => true,
    'allowAlpha' => false,
    'showPresets' => true,
    'presets' => [],
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$componentId = ComponentHelpers::generateId('color-picker', $id, $attributes);

$sizes = ComponentSizeConfig::inputSizes();

$states = ComponentStateConfig::pickerStates();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$stateClasses = $states[$state] ?? $states['default'];

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
    />
</div>
