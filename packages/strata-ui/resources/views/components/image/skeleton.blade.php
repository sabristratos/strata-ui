@props([
    'aspect' => null,
    'rounded' => 'rounded-md',
    'width' => null,
    'height' => null,
])

<div
    {{ $attributes->merge(['class' => "bg-[color:var(--color-muted)] animate-pulse {$rounded}"]) }}
    @if ($aspect)
        style="aspect-ratio: {{ $aspect }};"
    @elseif ($width && $height)
        style="width: {{ $width }}px; height: {{ $height }}px;"
    @else
        style="min-height: 200px;"
    @endif
></div>
