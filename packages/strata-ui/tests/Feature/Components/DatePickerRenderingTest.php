<?php

describe('Date Picker Component', function () {
    test('renders with default props', function () {
        expectComponent('date-picker')
            ->toHaveDataAttribute('strata-datepicker')
            ->toHaveDataAttribute('strata-field-type', 'date');
    });

    test('renders hidden input for Livewire binding', function () {
        expectComponent('date-picker')
            ->toContain('type="hidden"')
            ->toContain('data-strata-datepicker-input')
            ->toContain('x-bind:value="JSON.stringify(entangleable.value)"');
    });

    test('renders trigger with calendar icon', function () {
        expectComponent('date-picker')
            ->toContain('x-ref="trigger"')
            ->toContain('stroke="currentColor"');
    });

    test('renders dropdown with calendar', function () {
        expectComponent('date-picker')
            ->toContain('data-strata-datepicker-dropdown')
            ->toContain('popover="auto"')
            ->toContain('data-strata-calendar');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'date-picker', ['size' => 'sm'])
            ->toHaveClasses('h-9', 'px-3', 'text-sm');

        expectComponent($this, 'date-picker', ['size' => 'md'])
            ->toHaveClasses('h-10', 'px-3', 'text-base');

        expectComponent($this, 'date-picker', ['size' => 'lg'])
            ->toHaveClasses('h-11', 'px-4', 'text-lg');
    });

    test('renders all validation states', function () {
        expectComponent($this, 'date-picker', ['state' => 'default'])
            ->toContain('border-border')
            ->toContain('focus-within:ring-ring');

        expectComponent($this, 'date-picker', ['state' => 'success'])
            ->toContain('border-success')
            ->toContain('focus-within:ring-success/20');

        expectComponent($this, 'date-picker', ['state' => 'error'])
            ->toContain('border-destructive')
            ->toContain('focus-within:ring-destructive/20');

        expectComponent($this, 'date-picker', ['state' => 'warning'])
            ->toContain('border-warning')
            ->toContain('focus-within:ring-warning/20');
    });

    test('renders in single mode by default', function () {
        expectComponent('date-picker')
            ->toContain("mode: 'single'");
    });

    test('renders in range mode when specified', function () {
        expectComponent($this, 'date-picker', ['mode' => 'range'])
            ->toContain("mode: 'range'");
    });

    test('renders with custom placeholder', function () {
        expectComponent($this, 'date-picker', ['placeholder' => 'Choose a date'])
            ->toContain("placeholder: 'Choose a date'");
    });

    test('renders with default placeholder for single mode', function () {
        expectComponent($this, 'date-picker', ['mode' => 'single'])
            ->toContain('x-text="placeholder"');
    });

    test('renders with default placeholder for range mode', function () {
        expectComponent($this, 'date-picker', ['mode' => 'range', 'placeholder' => 'Select date range'])
            ->toContain("placeholder: 'Select date range'");
    });

    test('renders with min-date constraint', function () {
        expectComponent($this, 'date-picker', ['min-date' => '2025-01-01'])
            ->toContain('minDate:')
            ->toContain('2025-01-01');
    });

    test('renders with max-date constraint', function () {
        expectComponent($this, 'date-picker', ['max-date' => '2025-12-31'])
            ->toContain('maxDate:')
            ->toContain('2025-12-31');
    });

    test('renders with clearable button by default', function () {
        expectComponent('date-picker')
            ->toContain('@click.stop="clear()"')
            ->toContain('x-show="entangleable.value !== null"');
    });

    test('renders clear button when clearable is true', function () {
        expectComponent($this, 'date-picker', ['clearable' => true])
            ->toContain('@click.stop="clear()"')
            ->toContain('aria-label="Clear selection"');
    });

    test('renders with disabled state', function () {
        expectComponent($this, 'date-picker', ['disabled' => true])
            ->toContain('disabled: true')
            ->toContain('opacity-50');
    });

    test('renders with show-presets enabled', function () {
        expectComponent($this, 'date-picker', ['show-presets' => true, 'mode' => 'single'])
            ->toContain('Quick Select');
    });

    test('renders trigger with display value binding', function () {
        expectComponent('date-picker')
            ->toContain('x-show="display"')
            ->toContain('x-text="display"');
    });

    test('renders trigger with placeholder binding', function () {
        expectComponent('date-picker')
            ->toContain('x-show="!display"')
            ->toContain('x-text="placeholder"');
    });

    test('initializes Alpine component with strataDatePicker', function () {
        expectComponent('date-picker')
            ->toContain('x-data="window.strataDatePicker(');
    });

    test('passes mode to Alpine component', function () {
        expectComponent($this, 'date-picker', ['mode' => 'range'])
            ->toContain("mode: 'range'");
    });

    test('passes disabled state to Alpine component', function () {
        expectComponent($this, 'date-picker', ['disabled' => true])
            ->toContain('disabled: true');
    });

    test('trigger has role combobox', function () {
        expectComponent('date-picker')
            ->toContain('role="combobox"');
    });

    test('trigger has aria attributes', function () {
        expectComponent('date-picker')
            ->toContain('aria-haspopup="dialog"')
            ->toContain(':aria-expanded="open"')
            ->toContain(':aria-disabled="isDisabled()"')
            ->toContain(':aria-controls="$id(\'datepicker-dropdown\')"');
    });

    test('dropdown has dialog role', function () {
        expectComponent('date-picker')
            ->toContain('role="dialog"')
            ->toContain('aria-modal="true"');
    });

    test('generates unique ID when not provided', function () {
        expectComponent('date-picker')
            ->toContain('date-picker-')
            ->toContain('id="date-picker-');
    });

    test('uses provided ID', function () {
        expectComponent($this, 'date-picker', ['id' => 'my-date-picker'])
            ->toContain('id="my-date-picker"');
    });

    test('uses provided name attribute', function () {
        expectComponent($this, 'date-picker', ['name' => 'appointment_date'])
            ->toContain('name="appointment_date"');
    });

    test('trigger is clickable and opens dropdown', function () {
        expectComponent('date-picker')
            ->toContain('@click.prevent.stop="isDisabled() ? null : toggleDropdown()"');
    });

    test('trigger supports keyboard navigation', function () {
        expectComponent('date-picker')
            ->toContain('@keydown.enter.prevent="isDisabled() ? null : toggleDropdown()"')
            ->toContain('@keydown.space.prevent="isDisabled() ? null : toggleDropdown()"');
    });

    test('trigger has CSS anchor name', function () {
        expectComponent('date-picker')
            ->toContain('anchor-name: --datepicker-');
    });

    test('dropdown uses popover API for dismissal', function () {
        expectComponent('date-picker')
            ->toContain('popover="auto"');
    });

    test('dropdown closes on escape key', function () {
        expectComponent('date-picker')
            ->toContain('@keydown.escape.window="open = false"');
    });

    test('dropdown listens for date-selected event', function () {
        expectComponent('date-picker')
            ->toContain('@date-selected="handleDateSelected($event.detail)"');
    });

    test('trigger has hover effect when not disabled', function () {
        expectComponent($this, 'date-picker')
            ->toContain('hover:border-ring');
    });

    test('trigger is not clickable when disabled', function () {
        expectComponent($this, 'date-picker', ['disabled' => true])
            ->toContain('cursor-not-allowed');
    });

    test('default size is medium', function () {
        expectComponent('date-picker')
            ->toHaveClasses('h-10', 'px-3', 'text-base');
    });

    test('default state is default', function () {
        expectComponent('date-picker')
            ->toContain('border-border')
            ->toContain('focus-within:ring-ring');
    });

    test('falls back to default size for invalid size', function () {
        expectComponent($this, 'date-picker', ['size' => 'invalid'])
            ->toHaveClasses('h-10', 'px-3', 'text-base');
    });

    test('falls back to default state for invalid state', function () {
        expectComponent($this, 'date-picker', ['state' => 'invalid'])
            ->toContain('border-border')
            ->toContain('focus-within:ring-ring');
    });

    test('dropdown has CSS anchor positioning', function () {
        expectComponent('date-picker')
            ->toContain('position-anchor: --datepicker-');
    });

    test('dropdown has transition classes', function () {
        expectComponent('date-picker')
            ->toContain('transition-all')
            ->toContain('transition-discrete')
            ->toContain('duration-150');
    });

    test('dropdown has animation classes', function () {
        expectComponent('date-picker')
            ->toContain('opacity-100')
            ->toContain('scale-100')
            ->toContain('starting:opacity-0')
            ->toContain('starting:scale-95');
    });

    test('dropdown has proper background styling', function () {
        expectComponent('date-picker')
            ->toContain('bg-popover')
            ->toContain('text-popover-foreground');
    });

    test('dropdown has popover attributes', function () {
        expectComponent('date-picker')
            ->toContain('popover="auto"')
            ->toContain('@toggle="open = $event.newState === \'open\'"');
    });

    test('passes wire:model to hidden input only', function () {
        expectComponent($this, 'date-picker', ['wire:model' => 'appointmentDate'])
            ->toContain('wire:model="appointmentDate"');
    });

    test('merges custom classes on wrapper', function () {
        expectComponent($this, 'date-picker', ['class' => 'custom-picker'])
            ->toContain('class="relative custom-picker"');
    });

    test('hidden input is in hidden div', function () {
        expectComponent('date-picker')
            ->toContain('<div class="hidden" hidden>')
            ->toContain('type="hidden"');
    });

    test('trigger calendar icon has proper styling', function () {
        expectComponent('date-picker')
            ->toContain('size-4')
            ->toContain('text-muted-foreground');
    });

    test('clear button icon has proper styling', function () {
        expectComponent($this, 'date-picker', ['clearable' => true])
            ->toContain('size-4')
            ->toContain('text-muted-foreground')
            ->toContain('hover:text-destructive');
    });

    test('clear button has transition', function () {
        expectComponent($this, 'date-picker', ['clearable' => true])
            ->toContain('transition-colors')
            ->toContain('duration-150');
    });

    test('clear button has accessibility label', function () {
        expectComponent($this, 'date-picker', ['clearable' => true])
            ->toContain('aria-label="Clear selection"');
    });

    test('trigger has focus-within styles', function () {
        expectComponent('date-picker')
            ->toContain('focus-within:outline-none')
            ->toContain('focus-within:ring-2')
            ->toContain('focus-within:ring-offset-2');
    });

    test('passes initial value to Alpine component', function () {
        expectComponent('date-picker')
            ->toContain('initialValue:');
    });

    test('component has relative positioning', function () {
        expectComponent('date-picker')
            ->toContain('class="relative"');
    });

    test('single mode presets include Today and Tomorrow', function () {
        expectComponent($this, 'date-picker', ['mode' => 'single', 'show-presets' => true])
            ->toContain('Today')
            ->toContain('Tomorrow')
            ->toContain('Next Week')
            ->toContain('Next Month');
    });

    test('range mode presets include date ranges', function () {
        expectComponent($this, 'date-picker', ['mode' => 'range', 'show-presets' => true])
            ->toContain('Today')
            ->toContain('Yesterday')
            ->toContain('This Week')
            ->toContain('Last Week')
            ->toContain('Last 7 Days')
            ->toContain('Last 30 Days')
            ->toContain('This Month')
            ->toContain('Last Month')
            ->toContain('This Year');
    });

    test('preset buttons have click handlers', function () {
        expectComponent($this, 'date-picker', ['mode' => 'single', 'show-presets' => true])
            ->toContain("@click=\"selectPreset('today')")
            ->toContain("@click=\"selectPreset('tomorrow')");

        expectComponent($this, 'date-picker', ['mode' => 'range', 'show-presets' => true])
            ->toContain("@click=\"selectPreset('today')")
            ->toContain("@click=\"selectPreset('yesterday')");
    });

    test('all states have ring-offset-2', function () {
        expectComponent($this, 'date-picker', ['state' => 'default'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'date-picker', ['state' => 'success'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'date-picker', ['state' => 'error'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'date-picker', ['state' => 'warning'])
            ->toContain('focus-within:ring-offset-2');
    });

    test('trigger has tabindex when not disabled', function () {
        expectComponent('date-picker')
            ->toContain(':tabindex="isDisabled() ? -1 : 0"');
    });

    test('trigger has negative tabindex when disabled', function () {
        expectComponent($this, 'date-picker', ['disabled' => true])
            ->toContain(':tabindex="isDisabled() ? -1 : 0"');
    });

    test('component properly filters wire:model attributes', function () {
        expectComponent($this, 'date-picker', [
            'wire:model' => 'date',
            'wire:model.live' => 'date2',
            'class' => 'custom',
        ])
            ->toContain('class="relative custom"')
            ->toContain('wire:model="date"')
            ->toContain('wire:model.live="date2"');
    });
});
