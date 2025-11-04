<?php

describe('Slider Component', function () {
    test('renders with default props', function () {
        expectComponent('slider', slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveDataAttribute('strata-slider', 'true')
            ->toHaveAttribute('role', 'region')
            ->toHaveAttribute('aria-roledescription', 'carousel')
            ->toHaveAttribute('aria-label', 'Content slider');
    });

    test('renders presentational mode by default', function () {
        $html = expectComponent('slider', slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->not->toContain('data-strata-slider-input')
            ->and($html)->not->toContain('data-strata-field-type');
    });

    test('renders form mode with hidden input', function () {
        expectComponent('slider', ['mode' => 'form', 'name' => 'test_slider'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveDataAttribute('strata-field-type', 'slider')
            ->toContain('data-strata-slider-input')
            ->toContain('type="hidden"')
            ->toContain('name="test_slider"');
    });

    test('renders all size variants', function () {
        expectComponent('slider', ['size' => 'sm'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveClasses('min-h-32');

        expectComponent('slider', ['size' => 'md'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveClasses('min-h-48');

        expectComponent('slider', ['size' => 'lg'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveClasses('min-h-64');
    });

    test('renders state classes in form mode', function () {
        expectComponent('slider', ['mode' => 'form', 'state' => 'default'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveClasses('border-border', 'border-2', 'rounded-lg');

        expectComponent('slider', ['mode' => 'form', 'state' => 'success'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveClasses('border-success', 'border-2', 'rounded-lg');

        expectComponent('slider', ['mode' => 'form', 'state' => 'error'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveClasses('border-destructive', 'border-2', 'rounded-lg');

        expectComponent('slider', ['mode' => 'form', 'state' => 'warning'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveClasses('border-warning', 'border-2', 'rounded-lg');
    });

    test('does not render state classes in presentational mode', function () {
        $html = expectComponent('slider', ['mode' => 'presentational', 'state' => 'error'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->not->toContain('border-destructive')
            ->and($html)->not->toContain('border-2');
    });

    test('renders with custom ID', function () {
        expectComponent('slider', ['id' => 'custom-slider'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveAttribute('id', 'custom-slider');
    });

    test('generates unique ID when not provided', function () {
        $html = expectComponent('slider', slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->toContain('id="slider-')
            ->and($html)->toMatch('/id="slider-[a-f0-9]+"/');
    });

    test('renders ARIA live region for accessibility', function () {
        expectComponent('slider', slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('data-strata-slider-live-region')
            ->toContain('aria-live="polite"')
            ->toContain('aria-atomic="true"')
            ->toContain('class="sr-only"');

        // Autoplay mode should have aria-live="off"
        expectComponent('slider', ['autoplay' => true], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('aria-live="off"');
    });

    test('renders slider container with proper attributes', function () {
        expectComponent('slider', slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('data-strata-slider-container')
            ->toContain('x-ref="container"');
    });

    test('renders navigation when showNavigation is true', function () {
        expectComponent('slider', ['showNavigation' => true], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('data-strata-slider-navigation');
    });

    test('does not render navigation when showNavigation is false', function () {
        $html = expectComponent('slider', ['showNavigation' => false], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->not->toContain('data-strata-slider-navigation');
    });

    test('renders dots when showDots is true', function () {
        expectComponent('slider', ['showDots' => true], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('data-strata-slider-dots');
    });

    test('does not render dots when showDots is false', function () {
        $html = expectComponent('slider', ['showDots' => false], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->not->toContain('data-strata-slider-dots');
    });

    test('passes size prop to navigation component', function () {
        $html = expectComponent('slider', ['size' => 'lg', 'showNavigation' => true], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->toContain('data-strata-slider-navigation');
    });

    test('passes size prop to dots component', function () {
        $html = expectComponent('slider', ['size' => 'sm', 'showDots' => true], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->toContain('data-strata-slider-dots');
    });

    test('renders slider config JSON', function () {
        $html = expectComponent('slider', [
            'mode' => 'form',
            'loop' => true,
            'autoplay' => true,
            'autoplayDelay' => 3000,
        ], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->toContain('new window.StrataSlider(')
            ->and($html)->toContain('"mode":"form"')
            ->and($html)->toContain('"loop":true')
            ->and($html)->toContain('"autoplay":true')
            ->and($html)->toContain('"autoplayDelay":3000');
    });

    test('renders with perView configuration', function () {
        $html = expectComponent('slider', ['perView' => 3], slot: '
            <x-strata::slider.item>Slide 1</x-strata::slider.item>
            <x-strata::slider.item>Slide 2</x-strata::slider.item>
            <x-strata::slider.item>Slide 3</x-strata::slider.item>
        ')->getHtml();

        expect($html)->toContain('data-strata-slider-item');
    });

    test('throws exception for invalid mode', function () {
        expect(fn () => expectComponent('slider', ['mode' => 'invalid'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>'))
            ->toThrow(\InvalidArgumentException::class, 'The "mode" prop must be one of: presentational, form');
    });

    test('throws exception for invalid size', function () {
        expect(fn () => expectComponent('slider', ['size' => 'invalid'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>'))
            ->toThrow(\InvalidArgumentException::class, 'The "size" prop must be one of: sm, md, lg');
    });

    test('throws exception for invalid state', function () {
        expect(fn () => expectComponent('slider', ['state' => 'invalid'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>'))
            ->toThrow(\InvalidArgumentException::class, 'The "state" prop must be one of: default, success, error, warning');
    });

    test('renders with custom classes merged', function () {
        expectComponent('slider', ['class' => 'custom-class'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toHaveClasses('custom-class', 'min-h-48');
    });

    test('initializes Alpine data with correct structure', function () {
        $html = expectComponent('slider', slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->toContain('x-data')
            ->and($html)->toContain('currentSlide:')
            ->and($html)->toContain('totalSlides:')
            ->and($html)->toContain('slider:')
            ->and($html)->toContain('init()')
            ->and($html)->toContain('destroy()');
    });

    test('has Alpine lifecycle hooks', function () {
        expectComponent('slider', slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('x-init="init()"')
            ->toContain('x-destroy="destroy()"');
    });

    test('renders with peek mode configuration', function () {
        $html = expectComponent('slider', ['peek' => true, 'peekAmount' => '15%'], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->getHtml();

        expect($html)->toContain('"peek":true');
    });

    test('renders gap classes', function () {
        expectComponent('slider', ['gap' => 4], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('gap-4');

        expectComponent('slider', ['gap' => 8], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('gap-8');
    });

    test('renders with value in form mode', function () {
        expectComponent('slider', ['mode' => 'form', 'value' => 2], slot: '<x-strata::slider.item>Slide 1</x-strata::slider.item>')
            ->toContain('value="2"')
            ->toContain('currentSlide: 2');
    });
});

describe('Slider Navigation Component', function () {
    test('renders with default props', function () {
        $html = '<div x-data="{ currentSlide: 0, totalSlides: 3, slider: { prev: () => {}, next: () => {}, config: { loop: false } } }">
            '.view('strata::components.slider.navigation')->render().'
        </div>';

        expect($html)->toContain('data-strata-slider-navigation')
            ->and($html)->toContain('role="group"')
            ->and($html)->toContain('aria-label="Slider navigation"')
            ->and($html)->toContain('data-strata-slider-navigation-prev')
            ->and($html)->toContain('data-strata-slider-navigation-next');
    });

    test('renders different sizes', function () {
        $htmlSm = view('strata::components.slider.navigation', ['size' => 'sm'])->render();
        $htmlMd = view('strata::components.slider.navigation', ['size' => 'md'])->render();
        $htmlLg = view('strata::components.slider.navigation', ['size' => 'lg'])->render();

        expect($htmlSm)->toContain('p-1.5')
            ->and($htmlMd)->toContain('p-2')
            ->and($htmlLg)->toContain('p-3');
    });

    test('renders different variants', function () {
        $htmlDefault = view('strata::components.slider.navigation', ['variant' => 'default'])->render();
        $htmlFloating = view('strata::components.slider.navigation', ['variant' => 'floating'])->render();
        $htmlMinimal = view('strata::components.slider.navigation', ['variant' => 'minimal'])->render();

        expect($htmlDefault)->toContain('bg-primary')
            ->and($htmlFloating)->toContain('bg-white/90')
            ->and($htmlMinimal)->toContain('hover:bg-muted');
    });

    test('renders different positions', function () {
        $htmlBottom = view('strata::components.slider.navigation', ['position' => 'bottom'])->render();
        $htmlTop = view('strata::components.slider.navigation', ['position' => 'top'])->render();
        $htmlSides = view('strata::components.slider.navigation', ['position' => 'sides'])->render();

        expect($htmlBottom)->toContain('mt-4')
            ->and($htmlTop)->toContain('mb-4')
            ->and($htmlSides)->toContain('absolute');
    });
});

describe('Slider Dots Component', function () {
    test('renders with default props', function () {
        $html = '<div x-data="{ currentSlide: 0, totalSlides: 3, slider: { goTo: () => {} } }">
            '.view('strata::components.slider.dots')->render().'
        </div>';

        expect($html)->toContain('data-strata-slider-dots')
            ->and($html)->toContain('role="tablist"')
            ->and($html)->toContain('aria-label="Slider pagination"')
            ->and($html)->toContain('data-strata-slider-dot');
    });

    test('renders different sizes', function () {
        $htmlSm = view('strata::components.slider.dots', ['size' => 'sm'])->render();
        $htmlMd = view('strata::components.slider.dots', ['size' => 'md'])->render();
        $htmlLg = view('strata::components.slider.dots', ['size' => 'lg'])->render();

        expect($htmlSm)->toContain('h-1.5')
            ->and($htmlMd)->toContain('h-2')
            ->and($htmlLg)->toContain('h-2.5');
    });

    test('renders different variants', function () {
        $htmlRound = view('strata::components.slider.dots', ['variant' => 'default'])->render();
        $htmlLine = view('strata::components.slider.dots', ['variant' => 'line'])->render();

        expect($htmlRound)->toContain('rounded-full')
            ->and($htmlLine)->toContain('rounded-sm');
    });
});

describe('Slider Item Component', function () {
    test('renders with default props', function () {
        $html = view('strata::components.slider.item', [], ['slot' => 'Test Content'])->render();

        expect($html)->toContain('data-strata-slider-item')
            ->and($html)->toContain('role="group"')
            ->and($html)->toContain('aria-roledescription="slide"')
            ->and($html)->toContain('Test Content')
            ->and($html)->toContain('flex-shrink-0');
    });

    test('has accessibility attributes', function () {
        $html = view('strata::components.slider.item')->render();

        expect($html)->toContain('aria-current')
            ->and($html)->toContain('aria-label')
            ->and($html)->toContain('tabindex="0"');
    });
});
