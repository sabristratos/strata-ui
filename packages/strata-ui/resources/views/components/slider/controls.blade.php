@props([
    'size' => 'md',
])

@php
$sizeClasses = match($size) {
    'sm' => 'p-2',
    'md' => 'p-2.5',
    'lg' => 'p-3',
    default => 'p-2.5',
};

$iconSizes = match($size) {
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
    default => 'w-5 h-5',
};
@endphp

<div
    {{ $attributes->merge([
        'data-strata-slider-controls' => true,
        'class' => 'flex items-center justify-center gap-2 mt-4',
        'role' => 'group',
        'aria-label' => 'Slider playback controls',
    ]) }}
>
    <button
        type="button"
        x-show="slider?.config.autoplay"
        x-on:click="if (slider?.togglePlayPause) slider.togglePlayPause()"
        x-bind:aria-label="slider?.isPlaying ? 'Stop slide rotation' : 'Start slide rotation'"
        x-bind:title="slider?.isPlaying ? 'Stop slide rotation' : 'Start slide rotation'"
        class="{{ $sizeClasses }} rounded-md bg-primary text-primary-foreground hover:bg-primary/90 disabled:opacity-30 disabled:cursor-not-allowed transition-all min-w-[44px] min-h-[44px] flex items-center justify-center"
        data-strata-slider-play-pause
    >
        <svg x-show="slider?.isPlaying" xmlns="http://www.w3.org/2000/svg" class="{{ $iconSizes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect width="4" height="16" x="6" y="4"></rect>
            <rect width="4" height="16" x="14" y="4"></rect>
        </svg>
        <svg x-show="!slider?.isPlaying" xmlns="http://www.w3.org/2000/svg" class="{{ $iconSizes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polygon points="5 3 19 12 5 21 5 3"></polygon>
        </svg>
    </button>
</div>
