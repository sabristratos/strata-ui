@props([
    'size' => 'md',
    'variant' => 'secondary',
])

@php
$sizes = [
    'sm' => 'px-1.5 py-0.5 text-xs min-h-5 min-w-5',
    'md' => 'px-2 py-1 text-sm min-h-6 min-w-6',
    'lg' => 'px-3 py-1.5 text-base min-h-8 min-w-8',
];

$variants = [
    'primary' => 'bg-primary-subtle text-primary-subtle-foreground border-primary-border',
    'secondary' => 'bg-secondary-subtle text-secondary-subtle-foreground border-secondary-border',
    'success' => 'bg-success-subtle text-success-subtle-foreground border-success-border',
    'warning' => 'bg-warning-subtle text-warning-subtle-foreground border-warning-border',
    'destructive' => 'bg-destructive-subtle text-destructive-subtle-foreground border-destructive-border',
    'info' => 'bg-info-subtle text-info-subtle-foreground border-info-border',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$variantClasses = $variants[$variant] ?? $variants['secondary'];

$classes = trim('inline-flex items-center justify-center font-mono font-medium rounded border border-b-2 shadow-sm ' . $sizeClasses . ' ' . $variantClasses);
@endphp

<kbd
    data-strata-kbd
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</kbd>
