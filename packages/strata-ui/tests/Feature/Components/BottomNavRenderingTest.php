<?php

describe('Bottom Navigation Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'bottom-nav', slot: '<div>Nav Items</div>')
            ->toHaveTag('nav')
            ->toHaveDataAttribute('strata-bottom-nav')
            ->toContain('role="navigation"')
            ->toContain('aria-label="Bottom navigation"')
            ->toHaveClasses('bg-background/80', 'backdrop-blur-lg', 'rounded-full', 'border', 'border-border', 'shadow-lg')
            ->toRenderSlot('<div>Nav Items</div>');
    });

    test('renders all position types', function () {
        expectComponent($this, 'bottom-nav', ['position' => 'fixed'], '<div>Items</div>')
            ->toHaveClasses('fixed', 'bottom-4', 'left-1/2', '-translate-x-1/2');

        expectComponent($this, 'bottom-nav', ['position' => 'sticky'], '<div>Items</div>')
            ->toHaveClasses('sticky', 'bottom-4', 'left-1/2', '-translate-x-1/2');

        expectComponent($this, 'bottom-nav', ['position' => 'static'], '<div>Items</div>')
            ->toHaveClasses('relative');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'bottom-nav', ['size' => 'sm'], '<div>Items</div>')
            ->toHaveClasses('px-2', 'py-2', 'gap-1');

        expectComponent($this, 'bottom-nav', ['size' => 'md'], '<div>Items</div>')
            ->toHaveClasses('px-3', 'py-2.5', 'gap-2');

        expectComponent($this, 'bottom-nav', ['size' => 'lg'], '<div>Items</div>')
            ->toHaveClasses('px-4', 'py-3', 'gap-3');
    });

    test('merges custom classes', function () {
        expectComponent($this, 'bottom-nav', ['class' => 'custom-class'], '<div>Items</div>')
            ->toHaveClasses('custom-class', 'bg-background/80', 'rounded-full');
    });

    test('renders with z-index for layering', function () {
        expectComponent($this, 'bottom-nav', slot: '<div>Items</div>')
            ->toHaveClasses('z-50');
    });
});

describe('Bottom Navigation Item Component', function () {
    test('renders as button with default props', function () {
        expectComponent($this, 'bottom-nav.item', slot: 'Home')
            ->toHaveTag('button')
            ->toContain('type="button"')
            ->toHaveDataAttribute('strata-bottom-nav-item')
            ->toHaveClasses('inline-flex', 'items-center', 'justify-center', 'rounded-full', 'transition-all')
            ->toRenderSlot('Home');
    });

    test('renders as link when href is provided', function () {
        expectComponent($this, 'bottom-nav.item', ['href' => '/home'], 'Home')
            ->toHaveTag('a')
            ->toContain('href="/home"')
            ->toRenderSlot('Home');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'bottom-nav.item', ['size' => 'sm'], 'Home')
            ->toHaveClasses('px-3', 'py-2', 'gap-1.5', 'text-xs');

        expectComponent($this, 'bottom-nav.item', ['size' => 'md'], 'Home')
            ->toHaveClasses('px-4', 'py-2.5', 'gap-2', 'text-sm');

        expectComponent($this, 'bottom-nav.item', ['size' => 'lg'], 'Home')
            ->toHaveClasses('px-5', 'py-3', 'gap-2.5', 'text-base');
    });

    test('renders active state', function () {
        expectComponent($this, 'bottom-nav.item', ['active' => true], 'Home')
            ->toHaveClasses('bg-primary', 'text-primary-foreground')
            ->toContain('aria-current="page"');
    });

    test('renders inactive state', function () {
        expectComponent($this, 'bottom-nav.item', slot: 'Home')
            ->toHaveClasses('bg-transparent', 'text-muted-foreground')
            ->toContain('hover:text-foreground')
            ->not->toContain('aria-current="page"');
    });

    test('renders with icon', function () {
        expectComponent($this, 'bottom-nav.item', ['icon' => 'home'], 'Home')
            ->toContain('<svg')
            ->toContain('aria-hidden="true"')
            ->toRenderSlot('Home');
    });

    test('renders with show label true', function () {
        expectComponent($this, 'bottom-nav.item', ['icon' => 'home', 'showLabel' => true], 'Home')
            ->toContain('<span class="font-medium">Home</span>');
    });

    test('renders label accessibility for icon-only mode', function () {
        expectComponent($this, 'bottom-nav.item', ['icon' => 'home'], 'Home')
            ->toContain('<span class="font-medium">Home</span>');
    });

    test('merges custom classes', function () {
        expectComponent($this, 'bottom-nav.item', ['class' => 'custom-class'], 'Home')
            ->toHaveClasses('custom-class', 'inline-flex', 'rounded-full');
    });

    test('renders focus visible styles', function () {
        expectComponent($this, 'bottom-nav.item', slot: 'Home')
            ->toContain('focus-visible:outline-none')
            ->toContain('focus-visible:ring-2')
            ->toContain('focus-visible:ring-ring');
    });

    test('icon sizes match container sizes', function () {
        expectComponent($this, 'bottom-nav.item', ['icon' => 'home', 'size' => 'sm'], 'Home')
            ->toContain('w-4')
            ->toContain('h-4');

        expectComponent($this, 'bottom-nav.item', ['icon' => 'home', 'size' => 'md'], 'Home')
            ->toContain('w-5')
            ->toContain('h-5');

        expectComponent($this, 'bottom-nav.item', ['icon' => 'home', 'size' => 'lg'], 'Home')
            ->toContain('w-6')
            ->toContain('h-6');
    });

    test('transition classes are present', function () {
        expectComponent($this, 'bottom-nav.item', slot: 'Home')
            ->toHaveClasses('transition-all', 'duration-200');
    });

    test('renders as button without href attribute', function () {
        expectComponent($this, 'bottom-nav.item', slot: 'Home')
            ->not->toContain('href=');
    });

    test('renders as link with href and not button type', function () {
        expectComponent($this, 'bottom-nav.item', ['href' => '/home'], 'Home')
            ->not->toContain('type="button"');
    });

    test('renders disabled state', function () {
        expectComponent($this, 'bottom-nav.item', ['disabled' => true], 'Home')
            ->toContain('disabled')
            ->toHaveClasses('disabled:opacity-60', 'disabled:cursor-not-allowed', 'disabled:pointer-events-none');
    });

    test('renders loading state', function () {
        expectComponent($this, 'bottom-nav.item', ['loading' => true, 'icon' => 'home'], 'Home')
            ->toContain('M21 12a9 9 0 1 1-6.219-8.56')
            ->toContain('animate-spin')
            ->toContain('disabled')
            ->toContain('aria-busy="true"');
    });

    test('loading state replaces icon', function () {
        $rendered = expectComponent($this, 'bottom-nav.item', ['loading' => true, 'icon' => 'home'], 'Home');

        $rendered->toContain('M21 12a9 9 0 1 1-6.219-8.56');
        $rendered->not->toContain('M3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z');
    });

    test('renders with badge', function () {
        expectComponent($this, 'bottom-nav.item', ['icon' => 'bell', 'badge' => '5'], 'Notifications')
            ->toContain('<svg')
            ->toContain('5')
            ->toContain('inline-flex items-center rounded-full');
    });

    test('renders with badge variant', function () {
        expectComponent($this, 'bottom-nav.item', ['icon' => 'bell', 'badge' => '3', 'badgeVariant' => 'destructive'], 'Alerts')
            ->toContain('3')
            ->toContain('bg-destructive')
            ->toContain('text-destructive-foreground');
    });

    test('renders badge dot', function () {
        expectComponent($this, 'bottom-nav.item', ['icon' => 'inbox', 'badgeDot' => true], 'Messages')
            ->toContain('w-2')
            ->toContain('h-2')
            ->toContain('bg-destructive')
            ->toContain('rounded-full');
    });

    test('renders target attribute for links', function () {
        expectComponent($this, 'bottom-nav.item', ['href' => 'https://example.com', 'target' => '_blank'], 'External')
            ->toContain('target="_blank"');
    });

    test('touch target minimum height', function () {
        expectComponent($this, 'bottom-nav.item', ['size' => 'sm'], 'Home')
            ->toHaveClasses('min-h-11');

        expectComponent($this, 'bottom-nav.item', ['size' => 'md'], 'Home')
            ->toHaveClasses('min-h-11');

        expectComponent($this, 'bottom-nav.item', ['size' => 'lg'], 'Home')
            ->toHaveClasses('min-h-12');
    });

    test('has relative positioning for badge', function () {
        expectComponent($this, 'bottom-nav.item', slot: 'Home')
            ->toHaveClasses('relative');
    });
});

describe('Bottom Navigation Safe Area', function () {
    test('renders with safe area insets by default', function () {
        expectComponent($this, 'bottom-nav', slot: '<div>Items</div>')
            ->toContain('pb-[calc(1rem+env(safe-area-inset-bottom))]');
    });

    test('can disable safe area insets', function () {
        expectComponent($this, 'bottom-nav', [':respectSafeArea' => 'false'], '<div>Items</div>')
            ->toContain('data-strata-bottom-nav')
            ->not->toContain('pb-[calc(1rem+env(safe-area-inset-bottom))]');
    });

    test('safe area only applies to fixed and sticky positions', function () {
        expectComponent($this, 'bottom-nav', ['position' => 'static'], '<div>Items</div>')
            ->not->toContain('safe-area-inset');
    });

    test('generates unique ID', function () {
        expectComponent($this, 'bottom-nav', slot: '<div>Items</div>')
            ->toContain('id="bottom-nav-');
    });
});
