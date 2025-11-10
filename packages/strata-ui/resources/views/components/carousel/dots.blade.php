@props([
    'carousel',
    'size' => 'md',
    'variant' => 'dots',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Config\ComponentVariantConfig;

$sizes = ComponentSizeConfig::carouselSizes();
$states = ComponentStateConfig::carouselStates();
$variants = ComponentVariantConfig::carouselDotsVariants();

$sizeConfig = $sizes[$size] ?? $sizes['md'];
$stateConfig = $states['default'];
$variantConfig = $variants[$variant] ?? $variants['dots'];
@endphp

<div
    x-data="{ store: $store['carousel-{{ $carousel }}'] || {} }"
    {{ $attributes->merge(['class' => 'flex items-center ' . $sizeConfig['dots-gap']]) }}
    role="group"
    aria-label="Carousel navigation"
    data-strata-carousel-dots
>
    <template x-for="(slide, index) in store.totalSlides" :key="index">
        <button
            type="button"
            x-on:click="store.scrollToSlide(index)"
            :class="store.currentIndex === index ? '{{ $variantConfig['active'] }}' : '{{ $variantConfig['inactive'] }}'"
            class="transition-all duration-200 {{ $variantConfig['base'] }} {{ $sizeConfig['dot-size'] }}"
            :aria-label="`Go to slide ${index + 1}`"
            :aria-current="store.currentIndex === index ? 'true' : 'false'"
        >
            <span x-show="'{{ $variant }}' === 'numbers'" x-text="index + 1"></span>
        </button>
    </template>
</div>
