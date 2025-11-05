@props([
    'id' => null,
    'name' => null,
    'value' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
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

$componentId = ComponentHelpers::generateId('range-slider', $id, $attributes);

$sizes = ComponentSizeConfig::rangeSliderSizes();

$states = ComponentStateConfig::rangeSliderStates();

$sizeConfig = $sizes[$size] ?? $sizes['md'];
$stateConfig = $states[$state] ?? $states['default'];
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataRangeSlider', window.strataRangeSlider);
});
</script>
@endonce

<div
    x-data="window.strataRangeSlider({
        min: {{ $min }},
        max: {{ $max }},
        step: {{ $step }},
        initialValue: {{ json_encode($value) }},
        disabled: {{ $disabled ? 'true' : 'false' }},
        prefix: '{{ $prefix }}',
        suffix: '{{ $suffix }}',
        showValues: {{ $showValues ? 'true' : 'false' }},
        showLabels: {{ $showLabels ? 'true' : 'false' }},
    })"
    data-strata-range-slider
    data-strata-field-type="range"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative space-y-3']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="JSON.stringify(entangleable.value)"
            data-strata-range-slider-input
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    @if($showValues && !$showTooltips)
    <div class="flex items-center justify-between {{ $sizeConfig['text'] }} font-medium text-foreground">
        <span x-text="formatValue(entangleable.value?.min ?? min)"></span>
        <span x-text="formatValue(entangleable.value?.max ?? max)"></span>
    </div>
    @endif

    <div class="relative" :class="{ 'py-2': !{{ $showTooltips ? 'true' : 'false' }}, 'pt-10 pb-2': {{ $showTooltips ? 'true' : 'false' }} }">
        <x-strata::range-slider.track
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
        />

        <x-strata::range-slider.range
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
        />

        <x-strata::range-slider.handle
            handle-type="min"
            :component-id="$componentId"
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
            :disabled="$disabled"
            :show-tooltip="$showTooltips"
        />

        <x-strata::range-slider.handle
            handle-type="max"
            :component-id="$componentId"
            :size-config="$sizeConfig"
            :state-config="$stateConfig"
            :disabled="$disabled"
            :show-tooltip="$showTooltips"
        />
    </div>

    <div x-show="showLabels" class="flex items-center justify-between {{ $sizeConfig['text'] }} text-muted-foreground">
        <span>{{ $prefix }}{{ $min }}{{ $suffix }}</span>
        <span>{{ $prefix }}{{ $max }}{{ $suffix }}</span>
    </div>
</div>
