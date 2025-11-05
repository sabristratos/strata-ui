@props([
    'variant' => 'secondary',
    'size' => 'md',
    'style' => 'filled',
    'icon' => null,
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
$isTailwindColor = in_array($variant, $tailwindColors);

if (array_key_exists($variant, $designSystemVariants)) {
    $variantClasses = $designSystemVariants[$variant][$style];
} elseif ($isTailwindColor) {
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

$xIconColor = '';
if ($style === 'filled' && $variant !== 'secondary') {
    $xIconColor = 'text-white/90';
} elseif ($style === 'outlined' || $style === 'soft') {
    if ($variant === 'secondary') {
        $xIconColor = 'text-secondary-foreground';
    } elseif (array_key_exists($variant, $designSystemVariants)) {
        $xIconColor = "text-{$variant}";
    } elseif ($isTailwindColor) {
        $xIconColor = $style === 'outlined' ? "text-{$variant}-600" : "text-{$variant}-700 dark:!text-{$variant}-950";
    } else {
        $xIconColor = 'text-secondary-foreground';
    }
} else {
    $xIconColor = 'text-secondary-foreground';
}

$sizes = ComponentSizeConfig::badgeSizes();
$iconSizes = ComponentSizeConfig::checkboxIconSizes();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];
@endphp

<span {{ $attributes->except(['wire:click'])->merge(['class' => 'inline-flex items-center font-medium rounded-lg ' . $variantClasses . ' ' . $sizeClasses]) }}>
    @if($icon)
        <x-dynamic-component :component="'strata::icon.' . $icon" :class="$iconSize" />
    @endif

    {{ $slot }}

    <button
        type="button"
        {{ $attributes->only(['wire:click']) }}
        aria-label="Remove"
        class="ml-0.5 p-0 hover:opacity-70 transition-opacity {{ $xIconColor }}"
    >
        <x-strata::icon.x :class="$iconSize" />
    </button>
</span>
