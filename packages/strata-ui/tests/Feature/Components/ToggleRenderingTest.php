<?php

describe('Toggle Component', function () {
    test('renders with correct structure', function () {
        expectComponent($this, 'toggle', ['label' => 'Enable notifications'])
            ->toHaveTag('input')
            ->toContain('type="checkbox"')
            ->toHaveDataAttribute('strata-toggle')
            ->toHaveDataAttribute('strata-field-type', 'toggle')
            ->toHaveDataAttribute('strata-toggle-wrapper')
            ->toRenderSlot('Enable notifications');
    });

    test('renders all track sizes', function () {
        expectComponent($this, 'toggle', ['size' => 'sm', 'label' => 'Small'])
            ->toHaveClasses('h-5', 'w-9');

        expectComponent($this, 'toggle', ['size' => 'md', 'label' => 'Medium'])
            ->toHaveClasses('h-7', 'w-12');

        expectComponent($this, 'toggle', ['size' => 'lg', 'label' => 'Large'])
            ->toHaveClasses('h-9', 'w-16');
    });

    test('renders all thumb sizes', function () {
        expectComponent($this, 'toggle', ['size' => 'sm', 'label' => 'Small'])
            ->toContain('w-3 h-3');

        expectComponent($this, 'toggle', ['size' => 'md', 'label' => 'Medium'])
            ->toContain('w-4 h-4');

        expectComponent($this, 'toggle', ['size' => 'lg', 'label' => 'Large'])
            ->toContain('w-5 h-5');
    });

    test('thumb translations match sizes', function () {
        expectComponent($this, 'toggle', ['size' => 'sm', 'label' => 'Small'])
            ->toContain('translate-x-1')
            ->toContain('group-has-[:checked]:translate-x-5');

        expectComponent($this, 'toggle', ['size' => 'md', 'label' => 'Medium'])
            ->toContain('translate-x-1')
            ->toContain('group-has-[:checked]:translate-x-7');

        expectComponent($this, 'toggle', ['size' => 'lg', 'label' => 'Large'])
            ->toContain('translate-x-1')
            ->toContain('group-has-[:checked]:translate-x-[2.5rem]');
    });

    test('renders all rounded variants', function () {
        expectComponent($this, 'toggle', ['rounded' => 'full', 'label' => 'Full'])
            ->toContain('rounded-full');

        expectComponent($this, 'toggle', ['rounded' => 'lg', 'label' => 'Large'])
            ->toContain('rounded-lg');

        expectComponent($this, 'toggle', ['rounded' => 'none', 'label' => 'None'])
            ->toContain('rounded-none');
    });

    test('renders all states', function () {
        expectComponent($this, 'toggle', ['state' => 'default', 'label' => 'Default'])
            ->toContain('group-has-[:checked]:bg-primary')
            ->toContain('focus:ring-primary');

        expectComponent($this, 'toggle', ['state' => 'success', 'label' => 'Success'])
            ->toContain('group-has-[:checked]:bg-success')
            ->toContain('focus:ring-success');

        expectComponent($this, 'toggle', ['state' => 'error', 'label' => 'Error'])
            ->toContain('group-has-[:checked]:bg-destructive')
            ->toContain('focus:ring-destructive');

        expectComponent($this, 'toggle', ['state' => 'warning', 'label' => 'Warning'])
            ->toContain('group-has-[:checked]:bg-warning')
            ->toContain('focus:ring-warning');
    });

    test('renders checked state', function () {
        expectComponent($this, 'toggle', ['checked' => true, 'label' => 'Checked'])
            ->toContain('checked');
    });

    test('renders disabled state', function () {
        expectComponent($this, 'toggle', ['disabled' => true, 'label' => 'Disabled'])
            ->toContain('disabled')
            ->toContain('opacity-50')
            ->toContain('cursor-not-allowed');
    });

    test('renders with label and description', function () {
        expectComponent($this, 'toggle', [
            'label' => 'Dark mode',
            'description' => 'Switch between light and dark themes',
        ])
            ->toRenderSlot('Dark mode')
            ->toRenderSlot('Switch between light and dark themes');
    });

    test('generates unique ID when not provided', function () {
        $rendered = expectComponent('toggle', ['label' => 'Test']);
        $rendered->toContain('toggle-');
    });

    test('uses provided ID', function () {
        expectComponent($this, 'toggle', ['id' => 'custom-id', 'label' => 'Custom'])
            ->toContain('id="custom-id"')
            ->toContain('for="custom-id"');
    });

    test('label has role switch for accessibility', function () {
        expectComponent($this, 'toggle', ['label' => 'Accessible'])
            ->toContain('role="switch"');
    });

    test('toggle uses sr-only for input accessibility', function () {
        expectComponent($this, 'toggle', ['label' => 'Accessible'])
            ->toContain('sr-only peer');
    });

    test('renders slot content when no label provided', function () {
        expectComponent($this, 'toggle', slot: '<strong>Custom content</strong>')
            ->toRenderSlot('Custom content');
    });

    test('description has correct sizing', function () {
        expectComponent($this, 'toggle', [
            'size' => 'sm',
            'label' => 'Small',
            'description' => 'Small desc',
        ])
            ->toContain('text-xs');

        expectComponent($this, 'toggle', [
            'size' => 'lg',
            'label' => 'Large',
            'description' => 'Large desc',
        ])
            ->toContain('text-base');
    });

    test('track has transition classes', function () {
        expectComponent($this, 'toggle', ['label' => 'Test'])
            ->toContain('transition ease-in-out duration-150');
    });

    test('thumb has transition classes', function () {
        expectComponent($this, 'toggle', ['label' => 'Test'])
            ->toContain('transition ease-in-out duration-200');
    });

    test('wrapper is flex justify between for label and toggle', function () {
        expectComponent($this, 'toggle', ['label' => 'Test'])
            ->toContain('flex items-center justify-between gap-3 w-full');
    });

    test('track has focus ring', function () {
        expectComponent($this, 'toggle', ['label' => 'Test'])
            ->toContain('focus:ring-2')
            ->toContain('focus:ring-offset-2');
    });

    test('thumb has correct background color', function () {
        expectComponent($this, 'toggle', ['label' => 'Test'])
            ->toContain('bg-body');
    });

    test('unchecked state has muted background', function () {
        expectComponent($this, 'toggle', ['label' => 'Test'])
            ->toContain('bg-muted');
    });

    test('toggle is shrink-0 to prevent squishing', function () {
        expectComponent($this, 'toggle', ['label' => 'Test'])
            ->toContain('shrink-0');
    });
});
