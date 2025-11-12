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
use Stratos\StrataUI\Helpers\ButtonVariants;

$sizes = ComponentSizeConfig::buttonIconSizes();
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
