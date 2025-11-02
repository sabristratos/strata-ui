@props([
    'variant' => 'primary',
    'appearance' => 'filled',
    'size' => 'md',
    'icon' => null,
    'iconTrailing' => null,
    'loading' => false,
    'disabled' => false,
    'type' => 'button',
])

@php
$filledVariants = [
    'primary' => 'bg-primary text-primary-foreground hover:bg-primary/90 active:bg-primary/80 shadow-sm',
    'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/90 active:bg-secondary/80 shadow-sm',
    'success' => 'bg-success text-success-foreground hover:bg-success/90 active:bg-success/80 shadow-sm',
    'warning' => 'bg-warning text-warning-foreground hover:bg-warning/90 active:bg-warning/80 shadow-sm',
    'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/90 active:bg-destructive/80 shadow-sm',
    'info' => 'bg-info text-info-foreground hover:bg-info/90 active:bg-info/80 shadow-sm',
];

$outlinedVariants = [
    'primary' => 'bg-transparent text-primary border-2 border-primary hover:bg-primary/10 active:bg-primary/20',
    'secondary' => 'bg-transparent text-secondary border-2 border-secondary hover:bg-secondary/10 active:bg-secondary/20',
    'success' => 'bg-transparent text-success border-2 border-success hover:bg-success/10 active:bg-success/20',
    'warning' => 'bg-transparent text-warning border-2 border-warning hover:bg-warning/10 active:bg-warning/20',
    'destructive' => 'bg-transparent text-destructive border-2 border-destructive hover:bg-destructive/10 active:bg-destructive/20',
    'info' => 'bg-transparent text-info border-2 border-info hover:bg-info/10 active:bg-info/20',
];

$ghostVariants = [
    'primary' => 'bg-transparent text-primary hover:bg-primary/10 active:bg-primary/20',
    'secondary' => 'bg-transparent text-secondary hover:bg-secondary/10 active:bg-secondary/20',
    'success' => 'bg-transparent text-success hover:bg-success/10 active:bg-success/20',
    'warning' => 'bg-transparent text-warning hover:bg-warning/10 active:bg-warning/20',
    'destructive' => 'bg-transparent text-destructive hover:bg-destructive/10 active:bg-destructive/20',
    'info' => 'bg-transparent text-info hover:bg-info/10 active:bg-info/20',
];

$linkVariants = [
    'primary' => 'bg-transparent text-primary hover:underline active:opacity-70',
    'secondary' => 'bg-transparent text-secondary hover:underline active:opacity-70',
    'success' => 'bg-transparent text-success hover:underline active:opacity-70',
    'warning' => 'bg-transparent text-warning hover:underline active:opacity-70',
    'destructive' => 'bg-transparent text-destructive hover:underline active:opacity-70',
    'info' => 'bg-transparent text-info hover:underline active:opacity-70',
];

$sizes = [
    'sm' => 'h-9 px-3 text-sm gap-1.5',
    'md' => 'h-10 px-3 text-base gap-2',
    'lg' => 'h-11 px-4 text-lg gap-2.5',
];

$iconSizes = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
];

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

if ($appearance === 'link') {
    $sizeClasses = str_replace(['px-3', 'px-4', 'px-5'], ['px-0', 'px-0', 'px-0'], $sizeClasses);
}

$disabledClasses = 'disabled:opacity-70 disabled:cursor-not-allowed disabled:pointer-events-none disabled:!border-neutral-400 disabled:!text-neutral-500';

$isDisabled = $disabled || $loading;
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses . ' ' . $disabledClasses]) }}
    @disabled($isDisabled)
    @if($loading) aria-busy="true" @endif
    @if($appearance === 'filled') style="box-shadow: inset 0 1px color-mix(in oklab, white 20%, transparent)" @endif
>

    @if($loading)
        <x-strata::icon.loader-2 :class="'animate-spin ' . $iconSize" />
    @elseif($icon)
        <x-dynamic-component :component="'strata::icon.' . $icon" :class="$iconSize" />
    @endif

    <span class="relative">{{ $slot }}</span>

    @if(!$loading && $iconTrailing)
        <x-dynamic-component :component="'strata::icon.' . $iconTrailing" :class="$iconSize" />
    @endif
</button>
