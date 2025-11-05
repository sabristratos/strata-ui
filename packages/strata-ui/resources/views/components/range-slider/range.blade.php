@props([
    'sizeConfig' => [],
    'stateConfig' => [],
])

<div
    x-ref="range"
    @click="handleTrackClick($event)"
    class="absolute top-1/2 -translate-y-1/2 rounded-full pointer-events-none z-[5] {{ $sizeConfig['track'] }} {{ $stateConfig['range'] }}"
    :style="`left: ${minPercent}%; width: ${maxPercent - minPercent}%`"
    data-strata-range-slider-range
></div>
