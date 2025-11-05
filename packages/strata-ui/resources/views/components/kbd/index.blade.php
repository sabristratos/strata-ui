@props([
    'size' => 'md',
    'variant' => 'secondary',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$sizes = ComponentSizeConfig::kbdSizes();

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
