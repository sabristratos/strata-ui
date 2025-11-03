<?php

describe('Input Component', function () {
    test('renders with default props', function () {
        expectComponent('input')
            ->toHaveTag('input')
            ->toContain('type="text"')
            ->toHaveDataAttribute('strata-input')
            ->toHaveDataAttribute('strata-field-type', 'input')
            ->toHaveDataAttribute('strata-input-wrapper');
    });

    test('renders all input types', function () {
        $types = ['text', 'email', 'password', 'number', 'tel', 'url'];

        foreach ($types as $type) {
            expectComponent($this, 'input', ['type' => $type])
                ->toContain("type=\"{$type}\"");
        }
    });

    test('renders all sizes', function () {
        expectComponent($this, 'input', ['size' => 'sm'])
            ->toHaveClasses('h-9', 'px-3', 'text-sm');

        expectComponent($this, 'input', ['size' => 'md'])
            ->toHaveClasses('h-10', 'px-3', 'text-base');

        expectComponent($this, 'input', ['size' => 'lg'])
            ->toHaveClasses('h-11', 'px-4', 'text-lg');
    });

    test('renders all validation states', function () {
        expectComponent($this, 'input', ['state' => 'default'])
            ->toHaveClasses('border-border')
            ->toContain('focus-within:ring-ring');

        expectComponent($this, 'input', ['state' => 'success'])
            ->toHaveClasses('border-success')
            ->toContain('focus-within:ring-success/20')
            ->toContain('m9 11 3 3L22 4');

        expectComponent($this, 'input', ['state' => 'error'])
            ->toHaveClasses('border-destructive')
            ->toContain('focus-within:ring-destructive/20')
            ->toContain('<circle cx="12" cy="12" r="10"/>');

        expectComponent($this, 'input', ['state' => 'warning'])
            ->toHaveClasses('border-warning')
            ->toContain('focus-within:ring-warning/20')
            ->toContain('m21.73 18-8-14a2');
    });

    test('renders with left icon', function () {
        expectComponent($this, 'input', ['iconLeft' => 'mail'])
            ->toContain('m22 7-8.97 5.7')
            ->toContain('w-5 h-5 text-muted-foreground');
    });

    test('renders with right icon', function () {
        expectComponent($this, 'input', ['iconRight' => 'search'])
            ->toContain('m21 21-4.3-4.3')
            ->toContain('w-5 h-5 text-muted-foreground');
    });

    test('renders with prefix', function () {
        expectComponent($this, 'input', ['prefix' => '$'])
            ->toContain('<span class="text-muted-foreground flex-shrink-0">$</span>');
    });

    test('renders with suffix', function () {
        expectComponent($this, 'input', ['suffix' => '.com'])
            ->toContain('<span class="text-muted-foreground flex-shrink-0">.com</span>');
    });

    test('renders disabled state', function () {
        expectComponent($this, 'input', ['disabled' => true])
            ->toContain('disabled')
            ->toHaveClasses('opacity-50', 'cursor-not-allowed');
    });

    test('renders with slot content', function () {
        expectComponent($this, 'input', slot: '<button>Clear</button>')
            ->toRenderSlot('Clear');
    });

    test('merges custom classes on wrapper', function () {
        expectComponent($this, 'input', ['class' => 'custom-wrapper'])
            ->toHaveClasses('custom-wrapper', 'flex', 'items-center');
    });

    test('state icons have correct colors', function () {
        expectComponent($this, 'input', ['state' => 'success'])
            ->toContain('text-success');

        expectComponent($this, 'input', ['state' => 'error'])
            ->toContain('text-destructive');

        expectComponent($this, 'input', ['state' => 'warning'])
            ->toContain('text-warning');
    });

    test('default state does not show icon', function () {
        expectComponent($this, 'input', ['state' => 'default'])
            ->not->toContain('m9 11 3 3L22 4')
            ->not->toContain('<circle cx="12" cy="12" r="10"/>')
            ->not->toContain('m21.73 18-8-14a2');
    });

    test('renders with placeholder attribute', function () {
        expectComponent($this, 'input', ['placeholder' => 'Enter text'])
            ->toContain('placeholder="Enter text"');
    });

    test('input has transparent background', function () {
        expectComponent('input')
            ->toContain('bg-transparent')
            ->toContain('border-0')
            ->toContain('outline-none');
    });

    test('wrapper has focus-within ring', function () {
        expectComponent($this, 'input', ['state' => 'default'])
            ->toContain('focus-within:ring-2')
            ->toContain('focus-within:ring-ring')
            ->toContain('focus-within:ring-offset-2');
    });

    test('renders with all decorations combined', function () {
        expectComponent($this, 'input', [
            'iconLeft' => 'mail',
            'prefix' => 'https://',
            'suffix' => '.com',
            'iconRight' => 'external-link',
            'state' => 'success',
        ])
            ->toContain('m22 7-8.97 5.7')
            ->toContain('https://')
            ->toContain('.com')
            ->toContain('M15 3h6v6')
            ->toContain('m9 11 3 3L22 4');
    });
});
