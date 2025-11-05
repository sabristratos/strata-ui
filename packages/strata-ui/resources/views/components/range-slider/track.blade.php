@props([
    'sizeConfig' => [],
    'stateConfig' => [],
])

<div
    x-ref="track"
    @click="handleTrackClick($event)"
    class="relative w-full rounded-full cursor-pointer {{ $sizeConfig['track'] }} {{ $stateConfig['track'] }}"
    data-strata-range-slider-track
></div>
