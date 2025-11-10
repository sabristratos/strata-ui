<?php

describe('Carousel Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'carousel')
            ->toHaveDataAttribute('strata-carousel')
            ->toContain('role="region"')
            ->toContain('aria-roledescription="carousel"');
    });

    test('renders viewport with scroll-snap styling', function () {
        expectComponent($this, 'carousel')
            ->toHaveDataAttribute('strata-carousel-viewport')
            ->toContain('x-ref="viewport"')
            ->toContain('overflow-x-auto')
            ->toContain('scroll-snap-type: x mandatory');
    });

    test('renders container element', function () {
        expectComponent($this, 'carousel')
            ->toHaveDataAttribute('strata-carousel-container')
            ->toContain('x-ref="container"')
            ->toContain('flex');
    });

    test('renders navigation arrows by default', function () {
        expectComponent($this, 'carousel')
            ->toHaveDataAttribute('strata-carousel-prev')
            ->toHaveDataAttribute('strata-carousel-next')
            ->toContain('@click="prev()"')
            ->toContain('@click="next()"')
            ->toContain('aria-label="Previous slide"')
            ->toContain('aria-label="Next slide"');
    });

    test('hides arrows when arrows prop is false', function () {
        expectComponent('carousel', [':arrows' => 'false'])
            ->not->toHaveDataAttribute('strata-carousel-prev')
            ->not->toHaveDataAttribute('strata-carousel-next');
    });

    test('renders dots navigation by default', function () {
        expectComponent($this, 'carousel')
            ->toHaveDataAttribute('strata-carousel-dots')
            ->toContain('role="group"')
            ->toContain('aria-label="Carousel navigation"')
            ->toContain('x-for="(slide, index) in totalSlides"')
            ->toContain('@click="scrollToSlide(index)"');
    });

    test('hides dots when dots prop is false', function () {
        expectComponent('carousel', [':dots' => 'false'])
            ->not->toHaveDataAttribute('strata-carousel-dots');
    });

    test('renders keyboard navigation handlers', function () {
        expectComponent($this, 'carousel')
            ->toContain('x-on:keydown.left.prevent="prev()"')
            ->toContain('x-on:keydown.right.prevent="next()"')
            ->toContain('x-on:keydown.home.prevent="scrollToSlide(0)"')
            ->toContain('x-on:keydown.end.prevent="scrollToSlide(totalSlides - 1)"');
    });

    test('renders drag handlers', function () {
        expectComponent($this, 'carousel')
            ->toContain('x-on:touchstart.passive="handleDragStart"')
            ->toContain('x-on:touchmove.passive="handleDragMove"')
            ->toContain('x-on:touchend.passive="handleDragEnd"')
            ->toContain('x-on:mousedown="handleDragStart"')
            ->toContain('x-on:mousemove="handleDragMove"')
            ->toContain('x-on:mouseup="handleDragEnd"')
            ->toContain('x-on:mouseleave="handleDragEnd"');
    });

    test('renders scroll handler', function () {
        expectComponent($this, 'carousel')
            ->toContain('x-on:scroll.passive="handleScroll"');
    });

    test('renders autoplay pause/resume handlers', function () {
        expectComponent($this, 'carousel')
            ->toContain('x-on:mouseenter="pauseAutoplay"')
            ->toContain('x-on:mouseleave="resumeAutoplay"');
    });

    test('initializes Alpine component with default props', function () {
        expectComponent($this, 'carousel')
            ->toContain('x-data="window.strataCarousel({')
            ->toContain('loop: false')
            ->toContain('autoplay: false')
            ->toContain('autoplayDelay: 3000');
    });

    test('initializes Alpine component with loop enabled', function () {
        expectComponent('carousel', [':loop' => 'true'])
            ->toContain('loop: true');
    });

    test('initializes Alpine component with autoplay enabled', function () {
        expectComponent('carousel', [':autoplay' => 'true'])
            ->toContain('autoplay: true');
    });

    test('initializes Alpine component with custom autoplay delay', function () {
        expectComponent('carousel', [':autoplayDelay' => '5000'])
            ->toContain('autoplayDelay: 5000');
    });

    test('renders with custom id', function () {
        expectComponent('carousel', ['id' => 'hero-carousel'])
            ->toContain('id="hero-carousel"');
    });

    test('renders xs size variant', function () {
        expectComponent('carousel', ['size' => 'xs'])
            ->toContain('w-8 h-8')
            ->toContain('w-4 h-4')
            ->toContain('w-1.5 h-1.5')
            ->toContain('gap-1.5')
            ->toContain('gap-2');
    });

    test('renders sm size variant', function () {
        expectComponent('carousel', ['size' => 'sm'])
            ->toContain('w-9 h-9')
            ->toContain('w-4 h-4')
            ->toContain('w-2 h-2')
            ->toContain('gap-2')
            ->toContain('gap-3');
    });

    test('renders md size variant (default)', function () {
        expectComponent($this, 'carousel')
            ->toContain('w-10 h-10')
            ->toContain('w-5 h-5')
            ->toContain('gap-4');
    });

    test('renders lg size variant', function () {
        expectComponent('carousel', ['size' => 'lg'])
            ->toContain('w-11 h-11')
            ->toContain('w-6 h-6')
            ->toContain('gap-5');
    });

    test('renders xl size variant', function () {
        expectComponent('carousel', ['size' => 'xl'])
            ->toContain('w-12 h-12')
            ->toContain('w-7 h-7')
            ->toContain('gap-6');
    });

    test('renders control buttons with state styling', function () {
        expectComponent($this, 'carousel')
            ->toContain('bg-background/80')
            ->toContain('backdrop-blur-sm')
            ->toContain('hover:bg-background')
            ->toContain('text-foreground')
            ->toContain('border-border')
            ->toContain('shadow-lg');
    });

    test('renders active dot styling', function () {
        expectComponent($this, 'carousel')
            ->toContain('bg-primary');
    });

    test('renders inactive dot styling', function () {
        expectComponent($this, 'carousel')
            ->toContain('bg-muted-foreground/30');
    });

    test('renders arrows with disabled state binding', function () {
        expectComponent($this, 'carousel')
            ->toContain(':disabled="!canScrollPrev"')
            ->toContain(':disabled="!canScrollNext"')
            ->toContain(':class="{ \'opacity-50 cursor-not-allowed\': !canScrollPrev }"')
            ->toContain(':class="{ \'opacity-50 cursor-not-allowed\': !canScrollNext }"');
    });

    test('renders dot with aria-current binding', function () {
        expectComponent($this, 'carousel')
            ->toContain(':aria-current="currentIndex === index ? \'true\' : \'false\'"');
    });

    test('renders dot with dynamic aria-label', function () {
        expectComponent($this, 'carousel')
            ->toContain(':aria-label="`Go to slide ${index + 1}`"');
    });

    test('merges custom classes', function () {
        expectComponent('carousel', ['class' => 'custom-carousel'])
            ->toContain('custom-carousel');
    });

    test('throws exception for invalid size', function () {
        expect(fn () => $this->renderComponent('carousel', ['size' => 'invalid']))
            ->toThrow(\InvalidArgumentException::class);
    });

    test('throws exception for invalid autoplay delay', function () {
        expect(fn () => $this->renderComponent('carousel', [':autoplayDelay' => '0']))
            ->toThrow(\InvalidArgumentException::class);
    });

    test('renders with viewport tabindex for keyboard navigation', function () {
        expectComponent($this, 'carousel')
            ->toContain('tabindex="0"');
    });

    test('renders control buttons with transition', function () {
        expectComponent($this, 'carousel')
            ->toContain('transition-all')
            ->toContain('duration-200');
    });

    test('renders dots with transition', function () {
        expectComponent($this, 'carousel')
            ->toContain('transition-all')
            ->toContain('duration-200');
    });

    test('renders relative positioning on wrapper', function () {
        expectComponent($this, 'carousel')
            ->toContain('relative');
    });

    test('renders navigation arrows with z-index', function () {
        expectComponent($this, 'carousel')
            ->toContain('z-10');
    });

    test('renders carousel with all features enabled', function () {
        expectComponent('carousel', [
            ':loop' => 'true',
            ':autoplay' => 'true',
            ':autoplayDelay' => '5000',
            'size' => 'lg',
            'id' => 'featured-carousel',
        ])
            ->toContain('loop: true')
            ->toContain('autoplay: true')
            ->toContain('autoplayDelay: 5000')
            ->toContain('w-11 h-11')
            ->toContain('id="featured-carousel"');
    });
});
