@props([
    'variant' => 'secondary',
    'size' => 'md',
    'style' => 'filled',
    'icon' => null,
    'iconTrailing' => null,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$designSystemVariants = [
    'primary' => [
        'filled' => 'bg-primary text-white/90',
        'outlined' => 'bg-transparent text-primary border border-primary',
        'soft' => 'bg-primary/10 text-primary dark:text-primary',
    ],
    'secondary' => [
        'filled' => 'bg-secondary text-secondary-foreground',
        'outlined' => 'bg-transparent text-secondary-foreground border border-secondary-foreground',
        'soft' => 'bg-secondary/10 text-secondary-foreground',
    ],
    'success' => [
        'filled' => 'bg-success text-white/90',
        'outlined' => 'bg-transparent text-success border border-success',
        'soft' => 'bg-success/10 text-success dark:text-success',
    ],
    'warning' => [
        'filled' => 'bg-warning text-white/90',
        'outlined' => 'bg-transparent text-warning border border-warning',
        'soft' => 'bg-warning/10 text-warning dark:text-warning',
    ],
    'destructive' => [
        'filled' => 'bg-destructive text-white/90',
        'outlined' => 'bg-transparent text-destructive border border-destructive',
        'soft' => 'bg-destructive/10 text-destructive dark:text-destructive',
    ],
    'info' => [
        'filled' => 'bg-info text-white/90',
        'outlined' => 'bg-transparent text-info border border-info',
        'soft' => 'bg-info/10 text-info dark:text-info',
    ],
];

$tailwindColors = ['red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose', 'slate', 'gray', 'zinc', 'neutral', 'stone'];

$variantClasses = '';

if (array_key_exists($variant, $designSystemVariants)) {
    $variantClasses = $designSystemVariants[$variant][$style];
} elseif (in_array($variant, $tailwindColors)) {
    if ($style === 'filled') {
        $variantClasses = "bg-{$variant}-500 text-white/90";
    } elseif ($style === 'outlined') {
        $variantClasses = "bg-transparent text-{$variant}-600 border border-{$variant}-600";
    } elseif ($style === 'soft') {
        $variantClasses = "bg-{$variant}-100 text-{$variant}-700 bg-{$variant}-200 text-{$variant}-600";
    }
} else {
    $variantClasses = $designSystemVariants['secondary'][$style];
}

$sizes = ComponentSizeConfig::badgeSizes();
$iconSizes = ComponentSizeConfig::badgeIconSizes();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center font-medium rounded-lg ' . $variantClasses . ' ' . $sizeClasses]) }}>
    @if($icon)
        <x-dynamic-component :component="'strata::icon.' . $icon" :class="$iconSize" />
    @endif

    {{ $slot }}

    @if($iconTrailing)
        <x-dynamic-component :component="'strata::icon.' . $iconTrailing" :class="$iconSize" />
    @endif
</span>
