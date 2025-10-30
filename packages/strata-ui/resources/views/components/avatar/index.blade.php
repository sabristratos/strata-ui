@props([
    'src' => null,
    'alt' => null,
    'name' => null,
    'icon' => null,
    'size' => 'md',
    'shape' => 'circle',
])

@php
$sizes = [
    'xs' => 'w-6 h-6 text-xs',
    'sm' => 'w-8 h-8 text-sm',
    'md' => 'w-10 h-10 text-base',
    'lg' => 'w-12 h-12 text-lg',
    'xl' => 'w-14 h-14 text-xl',
    '2xl' => 'w-16 h-16 text-2xl',
];

$shapes = [
    'circle' => 'rounded-full',
    'square' => 'rounded-none',
    'rounded' => 'rounded-lg',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$shapeClasses = $shapes[$shape] ?? $shapes['circle'];

$initials = null;
if ($name) {
    $words = explode(' ', trim($name));
    $initials = strtoupper(
        (isset($words[0][0]) ? $words[0][0] : '') .
        (isset($words[1][0]) ? $words[1][0] : '')
    );
}
@endphp

<div data-strata-avatar {{ $attributes->merge(['class' => 'inline-flex items-center justify-center bg-muted text-muted-foreground font-medium overflow-hidden ' . $sizeClasses . ' ' . $shapeClasses]) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt ?? '' }}" class="w-full h-full object-cover" />
    @elseif($icon)
        <x-dynamic-component :component="'strata::icon.' . $icon" class="w-1/2 h-1/2" />
    @elseif($initials)
        {{ $initials }}
    @else
        <x-strata::icon.user class="w-1/2 h-1/2" />
    @endif
</div>
