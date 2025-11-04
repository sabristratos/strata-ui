<?php

describe('Select Component', function () {
    $slot = '<x-strata::select.option value="1" label="Option 1" /><x-strata::select.option value="2" label="Option 2" />';

    test('renders with default props', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toHaveDataAttribute('strata-select')
            ->toHaveDataAttribute('strata-field-type', 'select');
    });

    test('renders hidden input for Livewire binding', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('type="hidden"')
            ->toContain('data-strata-select-input')
            ->toContain('x-bind:value=');
    });

    test('hidden input is in hidden div', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('<div class="hidden" hidden>')
            ->toContain('type="hidden"');
    });

    test('renders trigger with chevron icon', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('x-ref="trigger"')
            ->toContain('stroke="currentColor"');
    });

    test('renders dropdown with options', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('x-ref="dropdown"')
            ->toContain('data-strata-select-option');
    });

    test('renders all sizes', function () use ($slot) {
        expectComponent($this, 'select', ['size' => 'sm'], $slot)
            ->toHaveClasses('h-9', 'px-3', 'text-sm');

        expectComponent($this, 'select', ['size' => 'md'], $slot)
            ->toHaveClasses('h-10', 'px-3', 'text-base');

        expectComponent($this, 'select', ['size' => 'lg'], $slot)
            ->toHaveClasses('h-11', 'px-4', 'text-lg');
    });

    test('renders all validation states', function () use ($slot) {
        expectComponent($this, 'select', ['state' => 'default'], $slot)
            ->toContain('border-border')
            ->toContain('focus:ring-ring');

        expectComponent($this, 'select', ['state' => 'success'], $slot)
            ->toContain('border-success')
            ->toContain('focus:ring-success/20');

        expectComponent($this, 'select', ['state' => 'error'], $slot)
            ->toContain('border-destructive')
            ->toContain('focus:ring-destructive/20');

        expectComponent($this, 'select', ['state' => 'warning'], $slot)
            ->toContain('border-warning')
            ->toContain('focus:ring-warning/20');
    });

    test('renders in single mode by default', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('strataSelect(');
    });

    test('renders in multiple mode when specified', function () use ($slot) {
        expectComponent($this, 'select', ['multiple' => true], $slot)
            ->toContain('strataSelect(')
            ->toContain('true');
    });

    test('renders with custom placeholder', function () use ($slot) {
        expectComponent($this, 'select', ['placeholder' => 'Choose an option'], $slot)
            ->toContain('Choose an option');
    });

    test('renders with default placeholder for single mode', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('Select an option');
    });

    test('renders with clearable button when enabled', function () use ($slot) {
        expectComponent($this, 'select', ['clearable' => true], $slot)
            ->toContain(', true)');
    });

    test('renders with disabled state', function () use ($slot) {
        expectComponent($this, 'select', ['disabled' => true], $slot)
            ->toContain('false, true')
            ->toContain('cursor-not-allowed');
    });

    test('renders with searchable functionality', function () use ($slot) {
        expectComponent($this, 'select', ['searchable' => true], $slot)
            ->toContain('x-model="search"')
            ->toContain('type="text"')
            ->toContain('Search...');
    });

    test('renders trigger with display value binding', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('selectedLabels');
    });

    test('renders trigger with placeholder binding', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('text-muted-foreground');
    });

    test('initializes Alpine component with strataSelect', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('x-data="strataSelect(');
    });

    test('passes disabled state to Alpine component', function () use ($slot) {
        expectComponent($this, 'select', ['disabled' => true], $slot)
            ->toContain('false, true');
    });

    test('trigger is a button element', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('<button')
            ->toContain('type="button"');
    });

    test('trigger has aria attributes', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('aria-haspopup="listbox"')
            ->toContain(':aria-expanded="positionable.state"');
    });

    test('dropdown has listbox role', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('role="listbox"');
    });

    test('generates unique ID when not provided', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('select-')
            ->toContain('id="select-');
    });

    test('uses provided ID', function () use ($slot) {
        expectComponent($this, 'select', ['id' => 'my-select'], $slot)
            ->toContain('id="my-select"');
    });

    test('uses provided name attribute', function () use ($slot) {
        expectComponent($this, 'select', ['name' => 'category'], $slot)
            ->toContain('name="category"');
    });

    test('trigger is clickable and opens dropdown', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('@click.prevent.stop="toggle()"');
    });

    test('trigger supports keyboard navigation', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('@keydown="handleKeydown"');
    });

    test('dropdown closes on click outside', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('@click.outside="positionable.close()"');
    });

    test('dropdown closes on escape key', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('@keydown.escape="positionable.close()"');
    });

    test('trigger has hover effect when not disabled', function () use ($slot) {
        expectComponent($this, 'select', [], $slot)
            ->toContain('hover:border-primary/50');
    });

    test('trigger is not clickable when disabled', function () use ($slot) {
        expectComponent($this, 'select', ['disabled' => true], $slot)
            ->toContain('cursor-not-allowed');
    });

    test('default size is medium', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toHaveClasses('h-10', 'px-3', 'text-base');
    });

    test('default state is default', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('border-border')
            ->toContain('focus:ring-ring');
    });

    test('falls back to default size for invalid size', function () use ($slot) {
        expectComponent($this, 'select', ['size' => 'invalid'], $slot)
            ->toHaveClasses('h-10', 'px-3', 'text-base');
    });

    test('falls back to default state for invalid state', function () use ($slot) {
        expectComponent($this, 'select', ['state' => 'invalid'], $slot)
            ->toContain('border-border')
            ->toContain('focus:ring-ring');
    });

    test('dropdown has positioned styles binding', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain(':style="positionable.styles"');
    });

    test('dropdown has transition classes', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('transition-all')
            ->toContain('transition-discrete')
            ->toContain('duration-150');
    });

    test('dropdown has animation classes', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('opacity-100')
            ->toContain('scale-100')
            ->toContain('starting:opacity-0')
            ->toContain('starting:scale-95');
    });

    test('dropdown has proper background styling', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('bg-popover')
            ->toContain('text-popover-foreground');
    });

    test('dropdown has proper positioning classes', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('absolute')
            ->toContain('z-50');
    });

    test('passes wire:model to hidden input only', function () use ($slot) {
        expectComponent($this, 'select', ['wire:model' => 'selectedOption'], $slot)
            ->toContain('wire:model="selectedOption"');
    });

    test('merges custom classes on wrapper', function () use ($slot) {
        expectComponent($this, 'select', ['class' => 'custom-select'], $slot)
            ->toContain('class="relative custom-select"');
    });

    test('trigger chevron icon has proper styling', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('text-muted-foreground');
    });

    test('clear button renders when clearable', function () use ($slot) {
        expectComponent($this, 'select', ['clearable' => true], $slot)
            ->toContain(', true)');
    });

    test('component has relative positioning', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('class="relative"');
    });

    test('all states have ring-offset-2', function () use ($slot) {
        expectComponent($this, 'select', ['state' => 'default'], $slot)
            ->toContain('ring-offset-2');

        expectComponent($this, 'select', ['state' => 'success'], $slot)
            ->toContain('ring-offset-2');

        expectComponent($this, 'select', ['state' => 'error'], $slot)
            ->toContain('ring-offset-2');

        expectComponent($this, 'select', ['state' => 'warning'], $slot)
            ->toContain('ring-offset-2');
    });

    test('component properly filters wire:model attributes', function () use ($slot) {
        expectComponent($this, 'select', [
            'wire:model' => 'option',
            'wire:model.live' => 'option2',
            'class' => 'custom',
        ], $slot)
            ->toContain('class="relative custom"')
            ->toContain('wire:model="option"')
            ->toContain('wire:model.live="option2"');
    });

    test('option buttons have click handlers', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('data-strata-select-option');
    });

    test('option buttons have proper styling', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('data-strata-select-option');
    });

    test('dropdown has proper border and shadow', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('border-border')
            ->toContain('shadow-xl');
    });

    test('component has proper z-index', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('z-50');
    });

    test('uses x-cloak on dropdown', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('x-cloak');
    });

    test('does not use wire:ignore directive', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->not->toContain('wire:ignore');
    });

    test('option list has scrollable container', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('overflow-y-auto')
            ->toContain('max-h-');
    });

    test('passes initial value to Alpine component', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('strataSelect(');
    });

    test('multiple mode uses JSON.stringify for value binding', function () use ($slot) {
        expectComponent($this, 'select', ['multiple' => true], $slot)
            ->toContain('JSON.stringify');
    });

    test('single mode uses direct value binding', function () use ($slot) {
        expectComponent('select', [], $slot)
            ->toContain('x-bind:value="entangleable.value"');
    });
});
