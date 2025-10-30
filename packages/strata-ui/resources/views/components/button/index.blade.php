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
    'primary' => 'bg-primary text-primary-foreground border-primary hover:bg-primary-hover active:bg-primary-active shadow-sm',
    'secondary' => 'bg-secondary text-secondary-foreground border-secondary hover:bg-secondary-hover active:bg-secondary-active shadow-sm',
    'success' => 'bg-success text-success-foreground border-success hover:bg-success-hover active:bg-success-active shadow-sm',
    'warning' => 'bg-warning text-warning-foreground border-warning hover:bg-warning-hover active:bg-warning-active shadow-sm',
    'destructive' => 'bg-destructive text-destructive-foreground border-destructive hover:bg-destructive-hover active:bg-destructive-active shadow-sm',
    'info' => 'bg-info text-info-foreground border-info hover:bg-info-hover active:bg-info-active shadow-sm',
];

$outlinedVariants = [
    'primary' => 'bg-transparent text-primary border-2 border-primary-border hover:bg-primary-subtle active:bg-primary-subtle/50',
    'secondary' => 'bg-transparent text-secondary border-2 border-secondary-border hover:bg-secondary-subtle active:bg-secondary-subtle/50',
    'success' => 'bg-transparent text-success border-2 border-success-border hover:bg-success-subtle active:bg-success-subtle/50',
    'warning' => 'bg-transparent text-warning border-2 border-warning-border hover:bg-warning-subtle active:bg-warning-subtle/50',
    'destructive' => 'bg-transparent text-destructive border-2 border-destructive-border hover:bg-destructive-subtle active:bg-destructive-subtle/50',
    'info' => 'bg-transparent text-info border-2 border-info-border hover:bg-info-subtle active:bg-info-subtle/50',
];

$ghostVariants = [
    'primary' => 'bg-transparent text-primary hover:bg-primary-subtle active:bg-primary-subtle/50',
    'secondary' => 'bg-transparent text-secondary hover:bg-secondary-subtle active:bg-secondary-subtle/50',
    'success' => 'bg-transparent text-success hover:bg-success-subtle active:bg-success-subtle/50',
    'warning' => 'bg-transparent text-warning hover:bg-warning-subtle active:bg-warning-subtle/50',
    'destructive' => 'bg-transparent text-destructive hover:bg-destructive-subtle active:bg-destructive-subtle/50',
    'info' => 'bg-transparent text-info hover:bg-info-subtle active:bg-info-subtle/50',
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
    'sm' => 'px-3 py-1.5 text-sm gap-1.5',
    'md' => 'px-4 py-2 text-base gap-2',
    'lg' => 'px-5 py-2.5 text-lg gap-2.5',
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

if ($appearance === 'filled') {
    $baseClasses .= ' border-2';
}

if ($appearance === 'link') {
    $sizeClasses = str_replace(['px-3', 'px-4', 'px-5'], ['px-0', 'px-0', 'px-0'], $sizeClasses);
}

$disabledClasses = 'disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none';

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
