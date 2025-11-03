@props([
    'variant' => 'pulse',
    'rounded' => null,
])

@php
$roundedClass = match($rounded) {
    'none' => 'rounded-none',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    'full' => 'rounded-full',
    default => '',
};

$variantClass = match($variant) {
    'wave' => 'animate-wave',
    'shimmer' => 'animate-shimmer',
    default => 'animate-pulse',
};
@endphp

<div
    data-strata-image-skeleton
    {{ $attributes->merge(['class' => "w-full h-full bg-muted {$roundedClass} {$variantClass}"]) }}
></div>
