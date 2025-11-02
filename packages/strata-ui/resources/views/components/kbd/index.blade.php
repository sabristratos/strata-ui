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
    'primary' => 'bg-primary/10 text-primary border-primary',
    'secondary' => 'bg-secondary/10 text-secondary-foreground border-secondary',
    'success' => 'bg-success/10 text-success border-success',
    'warning' => 'bg-warning/10 text-warning border-warning',
    'destructive' => 'bg-destructive/10 text-destructive border-destructive',
    'info' => 'bg-info/10 text-info border-info',
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
