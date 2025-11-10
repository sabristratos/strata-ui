@props([
    'id' => null,
    'size' => 'md',
    'loop' => false,
    'autoplay' => false,
    'autoplayDelay' => 3000,
    'arrows' => true,
    'dots' => true,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$componentId = ComponentHelpers::generateId('carousel', $id, $attributes);

$sizes = ComponentSizeConfig::carouselSizes();
$states = ComponentStateConfig::carouselStates();

$sizeConfig = $sizes[$size] ?? $sizes['md'];
$stateConfig = $states['default'];
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataCarousel', window.strataCarousel);
});
</script>
@endonce

<div
    x-data="window.strataCarousel({
        loop: {{ $loop ? 'true' : 'false' }},
        autoplay: {{ $autoplay ? 'true' : 'false' }},
        autoplayDelay: {{ $autoplayDelay }},
        startIndex: {{ $startIndex }},
        playOnInit: {{ $playOnInit ? 'true' : 'false' }},
        stopOnInteraction: {{ $stopOnInteraction ? 'true' : 'false' }},
        stopOnLastSnap: {{ $stopOnLastSnap ? 'true' : 'false' }},
        jump: {{ $jump ? 'true' : 'false' }},
    })"
    x-on:mouseenter="pauseAutoplay"
    x-on:mouseleave="resumeAutoplay"
    x-on:click.capture="if (preventClick) { $event.preventDefault(); $event.stopPropagation(); }"
    data-strata-carousel
    {{ $attributes->merge(['class' => $sizeConfig['wrapper']]) }}
    role="region"
    aria-roledescription="carousel"
    :aria-label="'Carousel'"
>
    <div
        x-ref="viewport"
        class="overflow-hidden {{ $sizeConfig['viewport'] }}"
        data-strata-carousel-viewport
        x-on:touchstart.passive="handleDragStart"
        x-on:touchmove.passive="handleDragMove"
        x-on:touchend.passive="handleDragEnd"
        x-on:mousedown="handleDragStart"
        tabindex="0"
        x-on:keydown.left.prevent="prev()"
        x-on:keydown.right.prevent="next()"
        x-on:keydown.home.prevent="scrollToSlide(0)"
        x-on:keydown.end.prevent="scrollToSlide(totalSlides - 1)"
    >
        <div
            x-ref="container"
            class="flex {{ $sizeConfig['container'] }}"
            data-strata-carousel-container
            x-on:mousemove="handleDragMove"
            x-on:mouseup="handleDragEnd"
            x-on:mouseleave="handleDragEnd"
            x-bind:style="{ transform: `translateX(${-currentPosition}px)`, willChange: isDragging ? 'transform' : 'auto' }"
        >
            {{ $slot }}
        </div>
    </div>

    @if($dots || $arrows)
    <div class="flex items-center justify-between {{ $sizeConfig['controls-wrapper'] }} mt-4">
        @if($dots)
        <div
            class="flex items-center {{ $sizeConfig['dots-gap'] }}"
            role="group"
            aria-label="Carousel navigation"
            data-strata-carousel-dots
        >
            <template x-for="(slide, index) in totalSlides" :key="index">
                <button
                    type="button"
                    x-on:click="scrollToSlide(index)"
                    :class="currentIndex === index ? '{{ $stateConfig['dot-active'] }}' : '{{ $stateConfig['dot-inactive'] }}'"
                    class="rounded-full transition-all duration-200 {{ $sizeConfig['dot-size'] }}"
                    :aria-label="`Go to slide ${index + 1}`"
                    :aria-current="currentIndex === index ? 'true' : 'false'"
                ></button>
            </template>
        </div>
        @else
        <div></div>
        @endif

        @if($arrows)
        <div class="flex flex-row {{ $sizeConfig['dots-gap'] }}">
            <x-strata::button.icon
                icon="chevron-left"
                :size="$size"
                variant="secondary"
                appearance="outlined"
                x-on:click="prev()"
                ::disabled="!canScrollPrev"
                aria-label="Previous slide"
                data-strata-carousel-prev
            />
            <x-strata::button.icon
                icon="chevron-right"
                :size="$size"
                variant="secondary"
                appearance="outlined"
                x-on:click="next()"
                ::disabled="!canScrollNext"
                aria-label="Next slide"
                data-strata-carousel-next
            />
        </div>
        @endif
    </div>
    @endif
</div>
