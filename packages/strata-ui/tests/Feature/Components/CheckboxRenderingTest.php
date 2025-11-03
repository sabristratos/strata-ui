<?php

describe('Checkbox Component', function () {
    test('renders default variant with correct structure', function () {
        expectComponent($this, 'checkbox', ['label' => 'Accept terms'])
            ->toHaveTag('input')
            ->toContain('type="checkbox"')
            ->toHaveDataAttribute('strata-checkbox')
            ->toHaveDataAttribute('strata-field-type', 'checkbox')
            ->toHaveDataAttribute('strata-checkbox-wrapper')
            ->toRenderSlot('Accept terms');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'checkbox', ['size' => 'sm', 'label' => 'Small'])
            ->toHaveClasses('w-4', 'h-4');

        expectComponent($this, 'checkbox', ['size' => 'md', 'label' => 'Medium'])
            ->toHaveClasses('w-5', 'h-5');

        expectComponent($this, 'checkbox', ['size' => 'lg', 'label' => 'Large'])
            ->toHaveClasses('w-6', 'h-6');
    });

    test('renders all variants', function () {
        expectComponent($this, 'checkbox', ['variant' => 'default', 'label' => 'Default'])
            ->toContain('inline-flex items-center gap-3');

        expectComponent($this, 'checkbox', ['variant' => 'bordered', 'label' => 'Bordered'])
            ->toContain('p-4 border border-border rounded-lg');

        expectComponent($this, 'checkbox', ['variant' => 'card', 'label' => 'Card'])
            ->toHaveDataAttribute('strata-checkbox-card')
            ->toContain('flex flex-col p-6 border');

        expectComponent($this, 'checkbox', ['variant' => 'pill', 'label' => 'Pill'])
            ->toContain('rounded-full border border-border');
    });

    test('renders checked state', function () {
        expectComponent($this, 'checkbox', ['checked' => true, 'label' => 'Checked'])
            ->toContain('checked');
    });

    test('renders disabled state', function () {
        expectComponent($this, 'checkbox', ['disabled' => true, 'label' => 'Disabled'])
            ->toContain('disabled')
            ->toContain('opacity-50')
            ->toContain('cursor-not-allowed');
    });

    test('renders with label and description', function () {
        expectComponent($this, 'checkbox', [
            'label' => 'Email notifications',
            'description' => 'Receive email updates about your account',
        ])
            ->toRenderSlot('Email notifications')
            ->toRenderSlot('Receive email updates about your account');
    });

    test('generates unique ID when not provided', function () {
        $rendered = expectComponent('checkbox', ['label' => 'Test']);
        $rendered->toContain('checkbox-');
    });

    test('uses provided ID', function () {
        expectComponent($this, 'checkbox', ['id' => 'custom-id', 'label' => 'Custom'])
            ->toContain('id="custom-id"')
            ->toContain('for="custom-id"');
    });

    test('renders check icon with correct classes', function () {
        expectComponent($this, 'checkbox', ['label' => 'Check'])
            ->toContain('M20 6 9 17l-5-5')
            ->toContain('text-primary-foreground')
            ->toContain('opacity-0')
            ->toContain('group-has-[:checked]:opacity-100');
    });

    test('renders indeterminate state with Alpine data', function () {
        expectComponent($this, 'checkbox', ['indeterminate' => true, 'label' => 'Indeterminate'])
            ->toContain('x-data')
            ->toContain('indeterminate: true');
    });

    test('card variant has indicator in correct position', function () {
        expectComponent($this, 'checkbox', ['variant' => 'card', 'label' => 'Card'])
            ->toContain('absolute top-4 right-4')
            ->toHaveDataAttribute('strata-checkbox-indicator');
    });

    test('pill variant has responsive sizing', function () {
        expectComponent($this, 'checkbox', ['variant' => 'pill', 'size' => 'sm', 'label' => 'Small Pill'])
            ->toContain('px-3 py-1 text-xs');

        expectComponent($this, 'checkbox', ['variant' => 'pill', 'size' => 'md', 'label' => 'Medium Pill'])
            ->toContain('px-4 py-1.5 text-sm');

        expectComponent($this, 'checkbox', ['variant' => 'pill', 'size' => 'lg', 'label' => 'Large Pill'])
            ->toContain('px-6 py-2 text-base');
    });

    test('bordered and card variants show hover effects when not disabled', function () {
        expectComponent($this, 'checkbox', ['variant' => 'bordered', 'label' => 'Hover'])
            ->toContain('hover:border-primary/50')
            ->toContain('hover:bg-accent/5')
            ->toContain('has-[:checked]:border-primary');

        expectComponent($this, 'checkbox', ['variant' => 'bordered', 'disabled' => true, 'label' => 'No Hover'])
            ->toContain('bg-muted')
            ->not->toContain('hover:border-primary/50');
    });

    test('checkbox uses sr-only for accessibility', function () {
        expectComponent($this, 'checkbox', ['label' => 'Accessible'])
            ->toContain('sr-only peer');
    });

    test('renders slot content when no label provided', function () {
        expectComponent($this, 'checkbox', slot: '<strong>Custom content</strong>')
            ->toRenderSlot('Custom content');
    });

    test('description has correct sizing', function () {
        expectComponent($this, 'checkbox', [
            'size' => 'sm',
            'label' => 'Small',
            'description' => 'Small desc',
        ])
            ->toContain('text-xs');

        expectComponent($this, 'checkbox', [
            'size' => 'lg',
            'label' => 'Large',
            'description' => 'Large desc',
        ])
            ->toContain('text-base');
    });

    test('checked state changes background and border', function () {
        expectComponent($this, 'checkbox', ['label' => 'Test'])
            ->toContain('group-has-[:checked]:bg-primary')
            ->toContain('group-has-[:checked]:border-primary');
    });
});
