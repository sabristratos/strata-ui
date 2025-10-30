@props([
    'src' => null,
    'alt' => '',
    'aspectRatio' => 'video',
])

@php
$aspectRatios = [
    'square' => 'aspect-square',
    'video' => 'aspect-video',
    'wide' => 'aspect-[21/9]',
    'portrait' => 'aspect-[3/4]',
    'auto' => 'aspect-auto',
];

$aspectClass = $aspectRatios[$aspectRatio] ?? $aspectRatios['video'];
$classes = "w-full $aspectClass object-cover";
@endphp

<div data-strata-card-image {{ $attributes->only('class') }}>
    @if($src)
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            {{ $attributes->except('class')->merge(['class' => $classes]) }}
        />
    @else
        <div {{ $attributes->except('class')->merge(['class' => "$classes bg-muted flex items-center justify-center"]) }}>
            <span class="text-muted-foreground text-sm">No image</span>
        </div>
    @endif
</div>
