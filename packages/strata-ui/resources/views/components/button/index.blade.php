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
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Helpers\ButtonVariants;

$sizes = ComponentSizeConfig::buttonSizes();
$iconSizes = ComponentSizeConfig::iconSizes();

$variantMap = [
    'filled' => ButtonVariants::filled(),
    'outlined' => ButtonVariants::outlined(),
    'ghost' => ButtonVariants::ghost(),
    'link' => ButtonVariants::link(),
];

$variantClasses = $variantMap[$appearance][$variant] ?? ButtonVariants::filled()['primary'];
$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];

$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-150 focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 relative overflow-hidden';

if ($appearance === 'link') {
    $sizeClasses = str_replace(['px-3', 'px-4', 'px-5'], ['px-0', 'px-0', 'px-0'], $sizeClasses);
}

$disabledClasses = 'disabled:opacity-60 disabled:cursor-not-allowed disabled:pointer-events-none';

$isDisabled = $disabled || $loading;
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses . ' ' . $disabledClasses]) }}
    @disabled($isDisabled)
    @if($loading) aria-busy="true" @endif
    @if($appearance === 'filled') style="box-shadow: inset 0 2px color-mix(in oklab, white 20%, transparent)" @endif
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
