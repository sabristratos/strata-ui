@props([
    'variant' => 'secondary',
    'size' => 'md',
    'style' => 'filled',
    'icon' => null,
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
    'md' => 'w-3.5 h-3.5',
    'lg' => 'w-4 h-4',
];

$variantClasses = $variants[$variant][$style] ?? $variants['secondary'][$style];
$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];
@endphp

<span {{ $attributes->except(['wire:click'])->merge(['class' => 'inline-flex items-center rounded-full font-medium ' . $variantClasses . ' ' . $sizeClasses]) }}>
    @if($icon)
        <x-dynamic-component :component="'strata::icon.' . $icon" :class="$iconSize" />
    @endif

    {{ $slot }}

    <x-strata::button.icon
        icon="x"
        size="sm"
        variant="secondary"
        appearance="ghost"
        {{ $attributes->only(['wire:click']) }}
        aria-label="Remove"
        class="ml-0.5 !p-0 hover:opacity-70"
    />
</span>
