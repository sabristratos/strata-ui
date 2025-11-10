@props([
    'carousel',
    'variant' => 'bar',
    'size' => 'md',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentVariantConfig;

$sizes = ComponentSizeConfig::carouselSizes();
$variants = ComponentVariantConfig::carouselProgressVariants();

$sizeConfig = $sizes[$size] ?? $sizes['md'];
$variantConfig = $variants[$variant] ?? $variants['bar'];
@endphp

<div
    x-data="{ store: $store['carousel-{{ $carousel }}'] || {} }"
    {{ $attributes->merge(['class' => $variantConfig['wrapper']]) }}
    data-strata-carousel-progress
>
    @if($variant === 'bar')
        <div class="{{ $variantConfig['track'] }} {{ $sizeConfig['progress-height'] }}">
            <div
                class="{{ $variantConfig['fill'] }} {{ $sizeConfig['progress-height'] }} transition-all duration-200"
                :style="`width: ${(store.scrollProgress || 0) * 100}%`"
                role="progressbar"
                :aria-valuenow="Math.round((store.scrollProgress || 0) * 100)"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>
    @elseif($variant === 'percentage')
        <span class="{{ $variantConfig['text'] }}" x-text="`${Math.round((store.scrollProgress || 0) * 100)}%`"></span>
    @elseif($variant === 'ring')
        <svg class="{{ $variantConfig['ring'] }} {{ $sizeConfig['progress-ring-size'] }}" viewBox="0 0 36 36">
            <path
                class="{{ $variantConfig['ring-track'] }}"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke-width="3"
            />
            <path
                class="{{ $variantConfig['ring-fill'] }}"
                :stroke-dasharray="`${(store.scrollProgress || 0) * 100}, 100`"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke-width="3"
            />
        </svg>
    @endif
</div>
