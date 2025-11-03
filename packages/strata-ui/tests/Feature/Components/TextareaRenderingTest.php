<?php

describe('Textarea Component', function () {
    test('renders with default props', function () {
        expectComponent('textarea')
            ->toHaveTag('textarea')
            ->toContain('rows="4"')
            ->toHaveDataAttribute('strata-textarea')
            ->toHaveDataAttribute('strata-field-type', 'textarea')
            ->toHaveDataAttribute('strata-textarea-wrapper');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'textarea', ['size' => 'sm'])
            ->toHaveClasses('px-3', 'py-2', 'text-sm');

        expectComponent($this, 'textarea', ['size' => 'md'])
            ->toHaveClasses('px-3', 'py-2.5', 'text-base');

        expectComponent($this, 'textarea', ['size' => 'lg'])
            ->toHaveClasses('px-4', 'py-3', 'text-lg');
    });

    test('renders all validation states', function () {
        expectComponent($this, 'textarea', ['state' => 'default'])
            ->toHaveClasses('border-border')
            ->toContain('focus:ring-ring');

        expectComponent($this, 'textarea', ['state' => 'success'])
            ->toHaveClasses('border-success')
            ->toContain('focus:ring-success/20')
            ->toContain('m9 11 3 3L22 4');

        expectComponent($this, 'textarea', ['state' => 'error'])
            ->toHaveClasses('border-destructive')
            ->toContain('focus:ring-destructive/20')
            ->toContain('<circle cx="12" cy="12" r="10"/>');

        expectComponent($this, 'textarea', ['state' => 'warning'])
            ->toHaveClasses('border-warning')
            ->toContain('focus:ring-warning/20')
            ->toContain('m21.73 18-8-14a2');
    });

    test('renders all resize options', function () {
        expectComponent($this, 'textarea', ['resize' => 'none'])
            ->toContain('resize-none');

        expectComponent($this, 'textarea', ['resize' => 'vertical'])
            ->toContain('resize-y');

        expectComponent($this, 'textarea', ['resize' => 'horizontal'])
            ->toContain('resize-x');

        expectComponent($this, 'textarea', ['resize' => 'both'])
            ->toContain('resize');
    });

    test('renders custom row count', function () {
        expectComponent($this, 'textarea', ['rows' => 10])
            ->toContain('rows="10"');
    });

    test('renders disabled state', function () {
        expectComponent($this, 'textarea', ['disabled' => true])
            ->toContain('disabled')
            ->toHaveClasses('opacity-50', 'cursor-not-allowed');
    });

    test('state icons are positioned correctly', function () {
        expectComponent($this, 'textarea', ['state' => 'success'])
            ->toContain('absolute top-2 right-2')
            ->toContain('pointer-events-none');
    });

    test('state icons have correct colors', function () {
        expectComponent($this, 'textarea', ['state' => 'success'])
            ->toContain('text-success');

        expectComponent($this, 'textarea', ['state' => 'error'])
            ->toContain('text-destructive');

        expectComponent($this, 'textarea', ['state' => 'warning'])
            ->toContain('text-warning');
    });

    test('default state does not show icon', function () {
        expectComponent($this, 'textarea', ['state' => 'default'])
            ->not->toContain('m9 11 3 3L22 4')
            ->not->toContain('<circle cx="12" cy="12" r="10"/>')
            ->not->toContain('m21.73 18-8-14a2');
    });

    test('renders with slot content below textarea', function () {
        expectComponent($this, 'textarea', slot: '<span>Character count</span>')
            ->toRenderSlot('Character count')
            ->toContain('flex items-center justify-end gap-2 mt-1.5');
    });

    test('textarea has transparent background', function () {
        expectComponent('textarea')
            ->toContain('bg-transparent')
            ->toContain('border-0')
            ->toContain('outline-none');
    });

    test('textarea has minimum height', function () {
        expectComponent('textarea')
            ->toContain('min-h-20');
    });

    test('merges custom classes on wrapper', function () {
        expectComponent($this, 'textarea', ['class' => 'custom-wrapper'])
            ->toHaveClasses('custom-wrapper', 'w-full', 'bg-input');
    });

    test('renders with placeholder attribute', function () {
        expectComponent($this, 'textarea', ['placeholder' => 'Enter description'])
            ->toContain('placeholder="Enter description"');
    });

    test('wrapper has focus ring', function () {
        expectComponent($this, 'textarea', ['state' => 'default'])
            ->toContain('focus:ring-2')
            ->toContain('focus:ring-ring')
            ->toContain('focus:ring-offset-2');
    });
});
