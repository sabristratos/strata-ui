<?php

describe('Button Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'button', slot: 'Click Me')
            ->toHaveTag('button')
            ->toContain('type="button"')
            ->toHaveClasses('bg-primary', 'text-primary-foreground', 'h-10')
            ->toRenderSlot('Click Me');
    });

    test('renders all variant types', function () {
        $variants = ['primary', 'secondary', 'success', 'warning', 'destructive', 'info'];

        foreach ($variants as $variant) {
            expectComponent($this, 'button', ['variant' => $variant], 'Test')
                ->toHaveClasses("bg-{$variant}", "text-{$variant}-foreground");
        }
    });

    test('renders all appearances', function () {
        expectComponent($this, 'button', ['appearance' => 'filled'], 'Filled')
            ->toHaveClasses('bg-primary', 'shadow-sm');

        expectComponent($this, 'button', ['appearance' => 'outlined'], 'Outlined')
            ->toHaveClasses('bg-transparent', 'border-2', 'border-primary');

        expectComponent($this, 'button', ['appearance' => 'ghost'], 'Ghost')
            ->toHaveClasses('bg-transparent')
            ->toContain('hover:bg-primary/10');

        expectComponent($this, 'button', ['appearance' => 'link'], 'Link')
            ->toHaveClasses('bg-transparent')
            ->toContain('hover:underline');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'button', ['size' => 'sm'], 'Small')
            ->toHaveClasses('h-9', 'px-3', 'text-sm');

        expectComponent($this, 'button', ['size' => 'md'], 'Medium')
            ->toHaveClasses('h-10', 'px-3', 'text-base');

        expectComponent($this, 'button', ['size' => 'lg'], 'Large')
            ->toHaveClasses('h-11', 'px-4', 'text-lg');
    });

    test('renders with leading icon', function () {
        expectComponent($this, 'button', ['icon' => 'check'], 'Confirm')
            ->toContain('<svg')
            ->toContain('M20 6 9 17l-5-5')
            ->toRenderSlot('Confirm');
    });

    test('renders with trailing icon', function () {
        expectComponent($this, 'button', ['iconTrailing' => 'arrow-right'], 'Next')
            ->toContain('<svg')
            ->toContain('M5 12h14')
            ->toRenderSlot('Next');
    });

    test('renders loading state', function () {
        expectComponent($this, 'button', ['loading' => true], 'Processing')
            ->toContain('M21 12a9 9 0 1 1-6.219-8.56')
            ->toContain('animate-spin')
            ->toContain('disabled')
            ->toContain('aria-busy="true"');
    });

    test('renders disabled state', function () {
        expectComponent($this, 'button', ['disabled' => true], 'Disabled')
            ->toContain('disabled')
            ->toHaveClasses('disabled:opacity-60', 'disabled:cursor-not-allowed');
    });

    test('renders different button types', function () {
        expectComponent($this, 'button', ['type' => 'submit'], 'Submit')
            ->toContain('type="submit"');

        expectComponent($this, 'button', ['type' => 'reset'], 'Reset')
            ->toContain('type="reset"');
    });

    test('merges custom classes', function () {
        expectComponent($this, 'button', ['class' => 'custom-class'], 'Custom')
            ->toHaveClasses('custom-class', 'bg-primary');
    });

    test('renders with focus visible styles', function () {
        expectComponent($this, 'button', slot: 'Focus')
            ->toContain('focus-visible:outline-none')
            ->toContain('focus-visible:ring-2')
            ->toContain('focus-visible:ring-ring');
    });

    test('loading state prevents icon display', function () {
        $rendered = expectComponent('button', [
            'loading' => true,
            'icon' => 'check',
            'iconTrailing' => 'arrow-right',
        ], 'Processing');

        $rendered->toContain('M21 12a9 9 0 1 1-6.219-8.56');
        $rendered->not->toContain('M20 6 9 17l-5-5');
        $rendered->not->toContain('M5 12h14');
    });

    test('link appearance removes padding', function () {
        expectComponent($this, 'button', ['appearance' => 'link'], 'Link')
            ->toContain('px-0');
    });

    test('renders with inset shadow for filled appearance', function () {
        expectComponent($this, 'button', ['appearance' => 'filled'], 'Filled')
            ->toContain('style="box-shadow: inset 0 1px color-mix(in oklab, white 20%, transparent)"');

        expectComponent($this, 'button', ['appearance' => 'outlined'], 'Outlined')
            ->not->toContain('inset');
    });
});
