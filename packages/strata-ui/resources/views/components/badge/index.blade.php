@props([
    'variant' => 'secondary',
    'size' => 'md',
    'style' => 'filled',
    'icon' => null,
    'iconTrailing' => null,
])

@php
$variants = [
    'primary' => [
        'filled' => 'bg-primary text-primary-foreground',
        'outlined' => 'bg-transparent text-primary border border-primary',
        'soft' => 'bg-primary/10 text-primary',
    ],
    'secondary' => [
        'filled' => 'bg-secondary text-secondary-foreground',
        'outlined' => 'bg-transparent text-secondary border border-secondary',
        'soft' => 'bg-secondary/10 text-secondary-foreground',
    ],
    'success' => [
        'filled' => 'bg-success text-success-foreground',
        'outlined' => 'bg-transparent text-success border border-success',
        'soft' => 'bg-success/10 text-success',
    ],
    'warning' => [
        'filled' => 'bg-warning text-warning-foreground',
        'outlined' => 'bg-transparent text-warning border border-warning',
        'soft' => 'bg-warning/10 text-warning',
    ],
    'destructive' => [
        'filled' => 'bg-destructive text-destructive-foreground',
        'outlined' => 'bg-transparent text-destructive border border-destructive',
        'soft' => 'bg-destructive/10 text-destructive',
    ],
    'info' => [
        'filled' => 'bg-info text-info-foreground',
        'outlined' => 'bg-transparent text-info border border-info',
        'soft' => 'bg-info/10 text-info',
    ],
];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs gap-1',
    'md' => 'px-2.5 py-1 text-sm gap-1.5',
    'lg' => 'px-3 py-1.5 text-base gap-2',
];

$iconSizes = [
    'sm' => 'w-3 h-3',
    'md' => 'w-4 h-4',
    'lg' => 'w-5 h-5',
];

$variantClasses = $variants[$variant][$style] ?? $variants['secondary'][$style];
$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full font-medium ' . $variantClasses . ' ' . $sizeClasses]) }}>
    @if($icon)
        <x-dynamic-component :component="'strata::icon.' . $icon" :class="$iconSize" />
    @endif

    {{ $slot }}

    @if($iconTrailing)
        <x-dynamic-component :component="'strata::icon.' . $iconTrailing" :class="$iconSize" />
    @endif
</span>
