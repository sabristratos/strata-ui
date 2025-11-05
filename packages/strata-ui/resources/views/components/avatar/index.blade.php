@props([
    'src' => null,
    'alt' => null,
    'name' => null,
    'icon' => null,
    'size' => 'md',
    'shape' => 'circle',
    'variant' => 'secondary',
    'style' => 'filled',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$sizes = ComponentSizeConfig::avatarSizes();

$shapes = [
    'circle' => 'rounded-full',
    'square' => 'rounded-none',
    'rounded' => 'rounded-lg',
];

// Color variants (design system)
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

// Tailwind colors list
$tailwindColors = ['red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose', 'slate', 'gray', 'zinc', 'neutral', 'stone'];

// Calculate variant classes
$variantClasses = '';
if (array_key_exists($variant, $designSystemVariants)) {
    $variantClasses = $designSystemVariants[$variant][$style];
} elseif (in_array($variant, $tailwindColors)) {
    if ($style === 'filled') {
        $variantClasses = "bg-{$variant}-500 text-white/90";
    } elseif ($style === 'outlined') {
        $variantClasses = "bg-transparent text-{$variant}-600 border border-{$variant}-600";
    } elseif ($style === 'soft') {
        $variantClasses = "bg-{$variant}-100 text-{$variant}-700 dark:bg-{$variant}-500/10 dark:!text-{$variant}-950";
    }
} else {
    $variantClasses = $designSystemVariants['secondary'][$style];
}

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$shapeClasses = $shapes[$shape] ?? $shapes['circle'];

$initials = null;
if ($name) {
    $words = explode(' ', trim($name));
    $initials = strtoupper(
        ($words[0][0] ?? '') .
        ($words[1][0] ?? '')
    );
}
@endphp

<div data-strata-avatar {{ $attributes->merge(['class' => 'inline-flex items-center justify-center font-medium overflow-hidden ' . $sizeClasses . ' ' . $shapeClasses . ' ' . $variantClasses]) }}>
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
