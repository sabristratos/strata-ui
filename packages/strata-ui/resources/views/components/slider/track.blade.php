@props([
    'sizeConfig' => [],
    'stateConfig' => [],
])

<div
    x-ref="track"
    @click="handleTrackClick($event)"
    class="w-full rounded-full cursor-pointer z-0 {{ $sizeConfig['track'] }} {{ $stateConfig['track'] }}"
    data-strata-slider-track
></div>
