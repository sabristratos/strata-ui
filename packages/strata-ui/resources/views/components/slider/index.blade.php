@props([
    'id' => null,
    'name' => null,
    'value' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'mode' => 'range',
    'state' => 'default',
    'size' => 'md',
    'disabled' => false,
    'showValues' => true,
    'showLabels' => true,
    'showTooltips' => true,
    'prefix' => '',
    'suffix' => '',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$componentId = ComponentHelpers::generateId('slider', $id, $attributes);

if (!in_array($mode, ['single', 'range'])) {
    throw new \InvalidArgumentException("Invalid mode '{$mode}'. Must be 'single' or 'range'.");
}

$isSingleMode = $mode === 'single';

$sizes = ComponentSizeConfig::sliderSizes();

$states = ComponentStateConfig::sliderStates();

$sizeConfig = $sizes[$size] ?? $sizes['md'];
$stateConfig = $states[$state] ?? $states['default'];
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataSlider', window.strataSlider);
});
</script>
@endonce

<div
    x-data="window.strataSlider({
        min: {{ $min }},
        max: {{ $max }},
        step: {{ $step }},
        mode: '{{ $mode }}',
        initialValue: {{ json_encode($value) }},
        disabled: {{ $disabled ? 'true' : 'false' }},
        prefix: '{{ $prefix }}',
        suffix: '{{ $suffix }}',
        showValues: {{ $showValues ? 'true' : 'false' }},
        showLabels: {{ $showLabels ? 'true' : 'false' }},
    })"
    data-strata-slider
    data-strata-field-type="slider"
    data-strata-slider-mode="{{ $mode }}"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative space-y-3']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="JSON.stringify(entangleable.value)"
            data-strata-slider-input
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    @if($showValues && !$showTooltips)
    <div class="flex items-center {{ $isSingleMode ? 'justify-center' : 'justify-between' }} {{ $sizeConfig['text'] }} font-medium text-foreground">
        @if($isSingleMode)
        <span x-text="formatValue(localValue ?? min)"></span>
        @else
        <span x-text="formatValue(localValue?.min ?? min)"></span>
        <span x-text="formatValue(localValue?.max ?? max)"></span>
        @endif
    </div>
    @endif

    <div class="relative" :class="{ 'my-2': !{{ $showTooltips ? 'true' : 'false' }}, 'mt-10 mb-2': {{ $showTooltips ? 'true' : 'false' }} }">
        <x-strata::slider.track
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
        />

        <x-strata::slider.range
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
        />

        @if($isSingleMode)
        <x-strata::slider.handle
            handle-type="single"
            :component-id="$componentId"
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
            :disabled="$disabled"
            :show-tooltip="$showTooltips"
        />
        @else
        <x-strata::slider.handle
            handle-type="min"
            :component-id="$componentId"
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
            :disabled="$disabled"
            :show-tooltip="$showTooltips"
        />

        <x-strata::slider.handle
            handle-type="max"
            :component-id="$componentId"
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
            :disabled="$disabled"
            :show-tooltip="$showTooltips"
        />
        @endif
    </div>

    <div x-show="showLabels" class="flex items-center justify-between {{ $sizeConfig['text'] }} text-muted-foreground">
        <span>{{ $prefix }}{{ $min }}{{ $suffix }}</span>
        <span>{{ $prefix }}{{ $max }}{{ $suffix }}</span>
    </div>
</div>
