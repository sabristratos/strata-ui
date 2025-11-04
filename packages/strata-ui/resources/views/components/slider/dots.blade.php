@props([
    'variant' => 'default',
    'size' => 'md',
    'position' => 'bottom',
])

@php
$positionClasses = match($position) {
    'bottom' => 'flex items-center justify-center gap-2 mt-4',
    'top' => 'flex items-center justify-center gap-2 mb-4',
    default => 'flex items-center justify-center gap-2 mt-4',
};

$sizeClasses = match($size) {
    'sm' => 'h-1.5',
    'md' => 'h-2',
    'lg' => 'h-2.5',
    default => 'h-2',
};

$variantClasses = match($variant) {
    'line' => 'rounded-sm',
    default => 'rounded-full',
};
@endphp

<div
    {{ $attributes->merge([
        'data-strata-slider-dots' => true,
        'class' => $positionClasses,
        'role' => 'tablist',
        'aria-label' => 'Slider pagination',
    ]) }}
>
    <template x-for="(slide, index) in totalSlides" x-bind:key="index">
        <button
            type="button"
            x-on:click="pauseAutoplay(); goTo(index)"
            x-bind:class="currentSlide === index ? 'bg-primary w-8' : 'bg-white/40 w-2'"
            x-bind:aria-label="`Go to slide ${index + 1} of ${totalSlides}`"
            x-bind:aria-current="currentSlide === index ? 'true' : 'false'"
            x-bind:aria-selected="currentSlide === index ? 'true' : 'false'"
            class="{{ $sizeClasses }} {{ $variantClasses }} transition-all duration-200 cursor-pointer hover:bg-primary/70"
            role="tab"
            data-strata-slider-dot
        ></button>
    </template>
</div>
