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
        'outlined' => 'bg-transparent text-primary border border-primary-border',
        'soft' => 'bg-primary-subtle text-primary-subtle-foreground',
    ],
    'secondary' => [
        'filled' => 'bg-secondary text-secondary-foreground',
        'outlined' => 'bg-transparent text-secondary border border-secondary-border',
        'soft' => 'bg-secondary-subtle text-secondary-subtle-foreground',
    ],
    'success' => [
        'filled' => 'bg-success text-success-foreground',
        'outlined' => 'bg-transparent text-success border border-success-border',
        'soft' => 'bg-success-subtle text-success-subtle-foreground',
    ],
    'warning' => [
        'filled' => 'bg-warning text-warning-foreground',
        'outlined' => 'bg-transparent text-warning border border-warning-border',
        'soft' => 'bg-warning-subtle text-warning-subtle-foreground',
    ],
    'destructive' => [
        'filled' => 'bg-destructive text-destructive-foreground',
        'outlined' => 'bg-transparent text-destructive border border-destructive-border',
        'soft' => 'bg-destructive-subtle text-destructive-subtle-foreground',
    ],
    'info' => [
        'filled' => 'bg-info text-info-foreground',
        'outlined' => 'bg-transparent text-info border border-info-border',
        'soft' => 'bg-info-subtle text-info-subtle-foreground',
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
