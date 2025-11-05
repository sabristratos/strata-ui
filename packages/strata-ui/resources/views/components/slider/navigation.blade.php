@props([
    'variant' => 'default',
    'position' => 'bottom',
    'size' => 'md',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$positionClasses = match($position) {
    'sides' => 'absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 pointer-events-none',
    'bottom' => 'flex items-center justify-center gap-2 mt-4',
    'top' => 'flex items-center justify-center gap-2 mb-4',
    default => 'flex items-center justify-center gap-2 mt-4',
};

$sizeClasses = match($size) {
    'sm' => 'p-1.5',
    'md' => 'p-2',
    'lg' => 'p-3',
    default => 'p-2',
};

$iconSizes = ComponentSizeConfig::iconSizes()[$size] ?? ComponentSizeConfig::iconSizes()['md'];

$buttonClasses = match($variant) {
    'floating' => $sizeClasses . ' rounded-full bg-white/90 text-neutral-900 shadow-lg backdrop-blur-sm hover:bg-white disabled:opacity-30 disabled:cursor-not-allowed transition-all pointer-events-auto',
    'minimal' => $sizeClasses . ' rounded-md text-foreground hover:bg-muted disabled:opacity-30 disabled:cursor-not-allowed transition-all',
    default => $sizeClasses . ' rounded-md bg-primary text-primary-foreground hover:bg-primary/90 disabled:opacity-30 disabled:cursor-not-allowed transition-all',
};
@endphp

<div
    {{ $attributes->merge([
        'data-strata-slider-navigation' => true,
        'class' => $positionClasses,
        'role' => 'group',
        'aria-label' => 'Slider navigation',
    ]) }}
>
    <button
        type="button"
        x-on:click="pauseAutoplay(); prev()"
        x-bind:disabled="!engine?.config.loop && currentSlide === 0"
        x-bind:aria-label="`Previous slide${(!engine?.config.loop && currentSlide === 0) ? ' (disabled - at first slide)' : ''}`"
        class="{{ $buttonClasses }}"
        data-strata-slider-navigation-prev
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconSizes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
    </button>

    <button
        type="button"
        x-on:click="pauseAutoplay(); next()"
        x-bind:disabled="!engine?.config.loop && currentSlide >= totalSlides - 1"
        x-bind:aria-label="`Next slide${(!engine?.config.loop && currentSlide >= totalSlides - 1) ? ' (disabled - at last slide)' : ''}`"
        class="{{ $buttonClasses }}"
        data-strata-slider-navigation-next
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconSizes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6"/>
        </svg>
    </button>
</div>
