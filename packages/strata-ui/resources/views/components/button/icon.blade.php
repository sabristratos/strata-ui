@props([
    'variant' => 'secondary',
    'appearance' => 'filled',
    'size' => 'md',
    'icon' => null,
    'loading' => false,
    'disabled' => false,
    'type' => 'button',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$filledVariants = [
    'primary' => 'bg-primary text-primary-foreground hover:bg-primary/90 active:bg-primary/80 shadow-sm',
    'secondary' => 'bg-secondary text-secondary-foreground hover:bg-neutral-300 active:bg-neutral-400 shadow-sm',
    'success' => 'bg-success text-success-foreground hover:bg-success/90 active:bg-success/80 shadow-sm',
    'warning' => 'bg-warning text-warning-foreground hover:bg-warning/90 active:bg-warning/80 shadow-sm',
    'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/90 active:bg-destructive/80 shadow-sm',
    'info' => 'bg-info text-info-foreground hover:bg-info/90 active:bg-info/80 shadow-sm',
];

$outlinedVariants = [
    'primary' => 'bg-transparent text-primary border border-primary hover:bg-primary/10 active:bg-primary/20',
    'secondary' => 'bg-transparent text-secondary-foreground border border-secondary-foreground hover:bg-neutral-200 active:bg-neutral-300',
    'success' => 'bg-transparent text-success border border-success hover:bg-success/10 active:bg-success/20',
    'warning' => 'bg-transparent text-warning border border-warning hover:bg-warning/10 active:bg-warning/20',
    'destructive' => 'bg-transparent text-destructive border border-destructive hover:bg-destructive/10 active:bg-destructive/20',
    'info' => 'bg-transparent text-info border border-info hover:bg-info/10 active:bg-info/20',
];

$ghostVariants = [
    'primary' => 'bg-transparent text-primary hover:bg-primary/10 active:bg-primary/20',
    'secondary' => 'bg-transparent text-secondary-foreground hover:bg-neutral-200 active:bg-neutral-300',
    'success' => 'bg-transparent text-success hover:bg-success/10 active:bg-success/20',
    'warning' => 'bg-transparent text-warning hover:bg-warning/10 active:bg-warning/20',
    'destructive' => 'bg-transparent text-destructive hover:bg-destructive/10 active:bg-destructive/20',
    'info' => 'bg-transparent text-info hover:bg-info/10 active:bg-info/20',
];

$linkVariants = [
    'primary' => 'bg-transparent text-primary hover:underline active:opacity-70',
    'secondary' => 'bg-transparent text-secondary-foreground hover:underline active:opacity-70',
    'success' => 'bg-transparent text-success hover:underline active:opacity-70',
    'warning' => 'bg-transparent text-warning hover:underline active:opacity-70',
    'destructive' => 'bg-transparent text-destructive hover:underline active:opacity-70',
    'info' => 'bg-transparent text-info hover:underline active:opacity-70',
];

$sizes = ComponentSizeConfig::buttonIconSizes();
$iconSizes = ComponentSizeConfig::iconSizes();

$variantMap = [
    'filled' => $filledVariants,
    'outlined' => $outlinedVariants,
    'ghost' => $ghostVariants,
    'link' => $linkVariants,
];

$variantClasses = $variantMap[$appearance][$variant] ?? $filledVariants['primary'];
$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];

$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 relative overflow-hidden';

$disabledClasses = 'disabled:opacity-60 disabled:cursor-not-allowed disabled:pointer-events-none';

$isDisabled = $disabled || $loading;
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses . ' ' . $disabledClasses]) }}
    @disabled($isDisabled)
    @if($loading) aria-busy="true" @endif
    @if($appearance === 'filled') style="box-shadow: inset 0 1px color-mix(in oklab, white 20%, transparent)" @endif
    aria-label="{{ $attributes->get('aria-label', 'Icon button') }}"
>

    @if($loading)
        <x-strata::icon.loader-2 :class="'animate-spin ' . $iconSize" />
    @elseif($icon)
        <x-dynamic-component :component="'strata::icon.' . $icon" :class="$iconSize" />
    @endif
</button>
