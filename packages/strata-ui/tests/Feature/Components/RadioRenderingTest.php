<?php

describe('Radio Component', function () {
    test('renders default variant with correct structure', function () {
        expectComponent($this, 'radio', ['label' => 'Option 1', 'name' => 'option'])
            ->toHaveTag('input')
            ->toContain('type="radio"')
            ->toContain('name="option"')
            ->toHaveDataAttribute('strata-radio')
            ->toHaveDataAttribute('strata-field-type', 'radio')
            ->toHaveDataAttribute('strata-radio-wrapper')
            ->toRenderSlot('Option 1');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'radio', ['size' => 'sm', 'label' => 'Small', 'name' => 'test'])
            ->toHaveClasses('w-4', 'h-4');

        expectComponent($this, 'radio', ['size' => 'md', 'label' => 'Medium', 'name' => 'test'])
            ->toHaveClasses('w-5', 'h-5');

        expectComponent($this, 'radio', ['size' => 'lg', 'label' => 'Large', 'name' => 'test'])
            ->toHaveClasses('w-6', 'h-6');
    });

    test('renders all variants', function () {
        expectComponent($this, 'radio', ['variant' => 'default', 'label' => 'Default', 'name' => 'test'])
            ->toContain('inline-flex items-center gap-3');

        expectComponent($this, 'radio', ['variant' => 'bordered', 'label' => 'Bordered', 'name' => 'test'])
            ->toContain('p-4 border border-border rounded-lg');

        expectComponent($this, 'radio', ['variant' => 'card', 'label' => 'Card', 'name' => 'test'])
            ->toHaveDataAttribute('strata-radio-card')
            ->toContain('flex flex-col p-6 border');

        expectComponent($this, 'radio', ['variant' => 'pill', 'label' => 'Pill', 'name' => 'test'])
            ->toContain('rounded-full border border-border');
    });

    test('renders checked state', function () {
        expectComponent($this, 'radio', ['checked' => true, 'label' => 'Checked', 'name' => 'test'])
            ->toContain('checked');
    });

    test('renders disabled state', function () {
        expectComponent($this, 'radio', ['disabled' => true, 'label' => 'Disabled', 'name' => 'test'])
            ->toContain('disabled')
            ->toContain('opacity-50')
            ->toContain('cursor-not-allowed');
    });

    test('renders with label and description', function () {
        expectComponent($this, 'radio', [
            'label' => 'Standard shipping',
            'description' => 'Delivery in 5-7 business days',
            'name' => 'shipping',
        ])
            ->toRenderSlot('Standard shipping')
            ->toRenderSlot('Delivery in 5-7 business days');
    });

    test('generates unique ID when not provided', function () {
        $rendered = expectComponent('radio', ['label' => 'Test', 'name' => 'test']);
        $rendered->toContain('radio-');
    });

    test('uses provided ID', function () {
        expectComponent($this, 'radio', ['id' => 'custom-id', 'label' => 'Custom', 'name' => 'test'])
            ->toContain('id="custom-id"')
            ->toContain('for="custom-id"');
    });

    test('renders dot indicator with correct classes', function () {
        expectComponent($this, 'radio', ['label' => 'Radio', 'name' => 'test'])
            ->toContain('rounded-full bg-primary-foreground')
            ->toContain('opacity-0')
            ->toContain('group-has-[:checked]:opacity-100');
    });

    test('dot sizes match radio sizes', function () {
        expectComponent($this, 'radio', ['size' => 'sm', 'label' => 'Small', 'name' => 'test'])
            ->toContain('w-1.5 h-1.5');

        expectComponent($this, 'radio', ['size' => 'md', 'label' => 'Medium', 'name' => 'test'])
            ->toContain('w-2 h-2');

        expectComponent($this, 'radio', ['size' => 'lg', 'label' => 'Large', 'name' => 'test'])
            ->toContain('w-2.5 h-2.5');
    });

    test('card variant has indicator in correct position', function () {
        expectComponent($this, 'radio', ['variant' => 'card', 'label' => 'Card', 'name' => 'test'])
            ->toContain('absolute top-4 right-4')
            ->toHaveDataAttribute('strata-radio-indicator');
    });

    test('pill variant has responsive sizing', function () {
        expectComponent($this, 'radio', ['variant' => 'pill', 'size' => 'sm', 'label' => 'Small Pill', 'name' => 'test'])
            ->toContain('px-3 py-1 text-xs');

        expectComponent($this, 'radio', ['variant' => 'pill', 'size' => 'md', 'label' => 'Medium Pill', 'name' => 'test'])
            ->toContain('px-4 py-1.5 text-sm');

        expectComponent($this, 'radio', ['variant' => 'pill', 'size' => 'lg', 'label' => 'Large Pill', 'name' => 'test'])
            ->toContain('px-6 py-2 text-base');
    });

    test('bordered and card variants show hover effects when not disabled', function () {
        expectComponent($this, 'radio', ['variant' => 'bordered', 'label' => 'Hover', 'name' => 'test'])
            ->toContain('hover:border-primary/50')
            ->toContain('hover:bg-accent/5')
            ->toContain('has-[:checked]:border-primary');

        expectComponent($this, 'radio', ['variant' => 'bordered', 'disabled' => true, 'label' => 'No Hover', 'name' => 'test'])
            ->toContain('bg-muted')
            ->not->toContain('hover:border-primary/50');
    });

    test('radio uses sr-only for accessibility', function () {
        expectComponent($this, 'radio', ['label' => 'Accessible', 'name' => 'test'])
            ->toContain('sr-only peer');
    });

    test('renders slot content when no label provided', function () {
        expectComponent($this, 'radio', ['name' => 'test'], '<strong>Custom content</strong>')
            ->toRenderSlot('Custom content');
    });

    test('description has correct sizing', function () {
        expectComponent($this, 'radio', [
            'size' => 'sm',
            'label' => 'Small',
            'description' => 'Small desc',
            'name' => 'test',
        ])
            ->toContain('text-xs');

        expectComponent($this, 'radio', [
            'size' => 'lg',
            'label' => 'Large',
            'description' => 'Large desc',
            'name' => 'test',
        ])
            ->toContain('text-base');
    });

    test('checked state changes background and border', function () {
        expectComponent($this, 'radio', ['label' => 'Test', 'name' => 'test'])
            ->toContain('group-has-[:checked]:bg-primary')
            ->toContain('group-has-[:checked]:border-primary');
    });

    test('radio is rounded full', function () {
        expectComponent($this, 'radio', ['label' => 'Test', 'name' => 'test'])
            ->toContain('rounded-full');
    });

    test('name attribute is required for radio groups', function () {
        expectComponent($this, 'radio', ['label' => 'Test', 'name' => 'group1'])
            ->toContain('name="group1"');
    });
});
