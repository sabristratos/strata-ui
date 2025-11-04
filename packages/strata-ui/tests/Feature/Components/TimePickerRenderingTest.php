<?php

describe('Time Picker Component', function () {
    test('renders with default props', function () {
        expectComponent('time-picker')
            ->toHaveDataAttribute('strata-timepicker')
            ->toHaveDataAttribute('strata-field-type', 'time');
    });

    test('renders hidden input for Livewire binding', function () {
        expectComponent('time-picker')
            ->toContain('type="hidden"')
            ->toContain('data-strata-timepicker-input')
            ->toContain('x-bind:value="entangleable.value"');
    });

    test('renders trigger with clock icon', function () {
        expectComponent('time-picker')
            ->toContain('x-ref="trigger"')
            ->toContain('stroke="currentColor"')
            ->toContain('M12 6v6h4.5m4.5');
    });

    test('renders dropdown with time list', function () {
        expectComponent('time-picker')
            ->toContain('x-ref="dropdown"')
            ->toContain('x-ref="timeList"');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'time-picker', ['size' => 'sm'])
            ->toHaveClasses('h-9', 'px-3', 'text-sm');

        expectComponent($this, 'time-picker', ['size' => 'md'])
            ->toHaveClasses('h-10', 'px-3', 'text-base');

        expectComponent($this, 'time-picker', ['size' => 'lg'])
            ->toHaveClasses('h-11', 'px-4', 'text-lg');
    });

    test('renders all validation states', function () {
        expectComponent($this, 'time-picker', ['state' => 'default'])
            ->toContain('border-border')
            ->toContain('focus-within:ring-ring');

        expectComponent($this, 'time-picker', ['state' => 'success'])
            ->toContain('border-success')
            ->toContain('focus-within:ring-success/20');

        expectComponent($this, 'time-picker', ['state' => 'error'])
            ->toContain('border-destructive')
            ->toContain('focus-within:ring-destructive/20');

        expectComponent($this, 'time-picker', ['state' => 'warning'])
            ->toContain('border-warning')
            ->toContain('focus-within:ring-warning/20');
    });

    test('renders in 12-hour format by default', function () {
        expectComponent('time-picker')
            ->toContain("format: '12'");
    });

    test('renders in 24-hour format when specified', function () {
        expectComponent($this, 'time-picker', ['format' => '24'])
            ->toContain("format: '24'");
    });

    test('renders with custom placeholder', function () {
        expectComponent($this, 'time-picker', ['placeholder' => 'Choose a time'])
            ->toContain("placeholder: 'Choose a time'");
    });

    test('renders with default placeholder', function () {
        expectComponent('time-picker')
            ->toContain("placeholder: 'Select time'");
    });

    test('renders with step-minutes configuration', function () {
        expectComponent($this, 'time-picker', ['step-minutes' => 30])
            ->toContain('stepMinutes: 30');
    });

    test('renders with default step-minutes of 15', function () {
        expectComponent('time-picker')
            ->toContain('stepMinutes: 15');
    });

    test('renders with min-time constraint', function () {
        expectComponent($this, 'time-picker', ['min-time' => '09:00'])
            ->toContain('minTime:')
            ->toContain('09:00');
    });

    test('renders with max-time constraint', function () {
        expectComponent($this, 'time-picker', ['max-time' => '17:00'])
            ->toContain('maxTime:')
            ->toContain('17:00');
    });

    test('passes disabled-times configuration to Alpine', function () {
        expectComponent('time-picker')
            ->toContain('disabledTimes:');
    });

    test('renders with clearable button by default', function () {
        expectComponent('time-picker')
            ->toContain('@click.stop="clear()"')
            ->toContain('x-show="entangleable.value !== null"');
    });

    test('renders clear button when clearable is true', function () {
        expectComponent($this, 'time-picker', ['clearable' => true])
            ->toContain('@click.stop="clear()"')
            ->toContain('aria-label="Clear selection"');
    });

    test('renders with disabled state', function () {
        expectComponent($this, 'time-picker', ['disabled' => true])
            ->toContain('disabled: true')
            ->toContain('opacity-50');
    });

    test('renders with show-presets enabled', function () {
        expectComponent($this, 'time-picker', ['show-presets' => true])
            ->toContain('Quick Select');
    });

    test('renders trigger with display value binding', function () {
        expectComponent('time-picker')
            ->toContain('x-show="display"')
            ->toContain('x-text="display"');
    });

    test('renders trigger with placeholder binding', function () {
        expectComponent('time-picker')
            ->toContain('x-show="!display"')
            ->toContain('x-text="placeholder"');
    });

    test('initializes Alpine component with strataTimePicker', function () {
        expectComponent('time-picker')
            ->toContain('x-data="window.strataTimePicker(');
    });

    test('passes format to Alpine component', function () {
        expectComponent($this, 'time-picker', ['format' => '24'])
            ->toContain("format: '24'");
    });

    test('passes disabled state to Alpine component', function () {
        expectComponent($this, 'time-picker', ['disabled' => true])
            ->toContain('disabled: true');
    });

    test('trigger has role button', function () {
        expectComponent('time-picker')
            ->toContain('role="button"');
    });

    test('trigger has aria attributes', function () {
        expectComponent('time-picker')
            ->toContain('aria-haspopup="true"')
            ->toContain(':aria-expanded="open"')
            ->toContain(':aria-disabled="disabled"');
    });

    test('dropdown has dialog role', function () {
        expectComponent('time-picker')
            ->toContain('role="dialog"')
            ->toContain('aria-modal="true"');
    });

    test('generates unique ID when not provided', function () {
        expectComponent('time-picker')
            ->toContain('time-picker-')
            ->toContain('id="time-picker-');
    });

    test('uses provided ID', function () {
        expectComponent($this, 'time-picker', ['id' => 'my-time-picker'])
            ->toContain('id="my-time-picker"');
    });

    test('uses provided name attribute', function () {
        expectComponent($this, 'time-picker', ['name' => 'appointment_time'])
            ->toContain('name="appointment_time"');
    });

    test('trigger is clickable and opens dropdown', function () {
        expectComponent('time-picker')
            ->toContain('@click="disabled ? null : (open = true)"');
    });

    test('trigger supports keyboard navigation', function () {
        expectComponent('time-picker')
            ->toContain('@keydown.enter.prevent="disabled ? null : (open = true)"')
            ->toContain('@keydown.space.prevent="disabled ? null : (open = true)"');
    });

    test('dropdown closes on click outside', function () {
        expectComponent('time-picker')
            ->toContain('@click.outside="open = false"');
    });

    test('dropdown closes on escape key', function () {
        expectComponent('time-picker')
            ->toContain('@keydown.escape.window="open = false"');
    });

    test('trigger has hover effect when not disabled', function () {
        expectComponent($this, 'time-picker')
            ->toContain('hover:border-ring');
    });

    test('trigger is not clickable when disabled', function () {
        expectComponent($this, 'time-picker', ['disabled' => true])
            ->toContain('cursor-not-allowed');
    });

    test('default size is medium', function () {
        expectComponent('time-picker')
            ->toHaveClasses('h-10', 'px-3', 'text-base');
    });

    test('default state is default', function () {
        expectComponent('time-picker')
            ->toContain('border-border')
            ->toContain('focus-within:ring-ring');
    });

    test('falls back to default size for invalid size', function () {
        expectComponent($this, 'time-picker', ['size' => 'invalid'])
            ->toHaveClasses('h-10', 'px-3', 'text-base');
    });

    test('falls back to default state for invalid state', function () {
        expectComponent($this, 'time-picker', ['state' => 'invalid'])
            ->toContain('border-border')
            ->toContain('focus-within:ring-ring');
    });

    test('dropdown has positioned styles binding', function () {
        expectComponent('time-picker')
            ->toContain(':style="positionable.styles"');
    });

    test('dropdown has transition classes', function () {
        expectComponent('time-picker')
            ->toContain('transition-all')
            ->toContain('transition-discrete')
            ->toContain('duration-150');
    });

    test('dropdown has animation classes', function () {
        expectComponent('time-picker')
            ->toContain('opacity-100')
            ->toContain('scale-100')
            ->toContain('starting:opacity-0')
            ->toContain('starting:scale-95');
    });

    test('dropdown has proper background styling', function () {
        expectComponent('time-picker')
            ->toContain('bg-popover')
            ->toContain('text-popover-foreground');
    });

    test('dropdown has proper positioning classes', function () {
        expectComponent('time-picker')
            ->toContain('absolute z-50');
    });

    test('passes wire:model to hidden input only', function () {
        expectComponent($this, 'time-picker', ['wire:model' => 'appointmentTime'])
            ->toContain('wire:model="appointmentTime"');
    });

    test('merges custom classes on wrapper', function () {
        expectComponent($this, 'time-picker', ['class' => 'custom-picker'])
            ->toContain('class="relative custom-picker"');
    });

    test('hidden input is in hidden div', function () {
        expectComponent('time-picker')
            ->toContain('<div class="hidden" hidden>')
            ->toContain('type="hidden"');
    });

    test('trigger clock icon has proper styling', function () {
        expectComponent('time-picker')
            ->toContain('size-4')
            ->toContain('text-muted-foreground');
    });

    test('clear button icon has proper styling', function () {
        expectComponent($this, 'time-picker', ['clearable' => true])
            ->toContain('size-4')
            ->toContain('text-muted-foreground')
            ->toContain('hover:text-destructive');
    });

    test('clear button has transition', function () {
        expectComponent($this, 'time-picker', ['clearable' => true])
            ->toContain('transition-colors')
            ->toContain('duration-150');
    });

    test('clear button has accessibility label', function () {
        expectComponent($this, 'time-picker', ['clearable' => true])
            ->toContain('aria-label="Clear selection"');
    });

    test('trigger has focus-within styles', function () {
        expectComponent('time-picker')
            ->toContain('focus-within:outline-none')
            ->toContain('focus-within:ring-2')
            ->toContain('focus-within:ring-offset-2');
    });

    test('passes initial value to Alpine component', function () {
        expectComponent('time-picker')
            ->toContain('initialValue:');
    });

    test('component has relative positioning', function () {
        expectComponent('time-picker')
            ->toContain('class="relative"');
    });

    test('presets include common time options', function () {
        expectComponent($this, 'time-picker', ['show-presets' => true])
            ->toContain('Now')
            ->toContain('Morning')
            ->toContain('Noon')
            ->toContain('Afternoon')
            ->toContain('Evening')
            ->toContain('End of Day');
    });

    test('preset buttons have click handlers', function () {
        expectComponent($this, 'time-picker', ['show-presets' => true])
            ->toContain("@click=\"selectPreset('now')")
            ->toContain("@click=\"selectPreset('morning')")
            ->toContain("@click=\"selectPreset('noon')");
    });

    test('all states have ring-offset-2', function () {
        expectComponent($this, 'time-picker', ['state' => 'default'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'time-picker', ['state' => 'success'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'time-picker', ['state' => 'error'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'time-picker', ['state' => 'warning'])
            ->toContain('focus-within:ring-offset-2');
    });

    test('trigger has tabindex when not disabled', function () {
        expectComponent('time-picker')
            ->toContain('tabindex="0"');
    });

    test('trigger has negative tabindex when disabled', function () {
        expectComponent($this, 'time-picker', ['disabled' => true])
            ->toContain('tabindex="-1"');
    });

    test('component properly filters wire:model attributes', function () {
        expectComponent($this, 'time-picker', [
            'wire:model' => 'time',
            'wire:model.live' => 'time2',
            'class' => 'custom',
        ])
            ->toContain('class="relative custom"')
            ->toContain('wire:model="time"')
            ->toContain('wire:model.live="time2"');
    });

    test('time list has proper scrolling styles', function () {
        expectComponent('time-picker')
            ->toContain('overflow-y-auto')
            ->toContain('max-h-80');
    });

    test('time buttons have click handlers', function () {
        expectComponent('time-picker')
            ->toContain('@click="selectTime(time.value)"');
    });

    test('time buttons have proper styling', function () {
        expectComponent('time-picker')
            ->toContain('hover:bg-accent')
            ->toContain('rounded-md');
    });

    test('time buttons show disabled state', function () {
        expectComponent('time-picker')
            ->toContain('opacity-40 cursor-not-allowed')
            ->toContain('time.disabled');
    });

    test('time buttons show selected state', function () {
        expectComponent('time-picker')
            ->toContain('bg-primary text-primary-foreground')
            ->toContain('time.value === entangleable.value');
    });

    test('time buttons show current time indicator', function () {
        expectComponent('time-picker')
            ->toContain('ring-2 ring-primary ring-inset')
            ->toContain('time.isCurrent');
    });

    test('dropdown has proper border and shadow', function () {
        expectComponent('time-picker')
            ->toContain('border-border')
            ->toContain('shadow-lg');
    });

    test('component has proper z-index', function () {
        expectComponent('time-picker')
            ->toContain('z-50');
    });

    test('uses x-cloak on dropdown', function () {
        expectComponent('time-picker')
            ->toContain('x-cloak');
    });

    test('preset section has proper divider', function () {
        expectComponent($this, 'time-picker', ['show-presets' => true])
            ->toContain('border-r')
            ->toContain('border-border');
    });

    test('preset buttons have proper styling', function () {
        expectComponent($this, 'time-picker', ['show-presets' => true])
            ->toContain('hover:bg-accent')
            ->toContain('text-sm');
    });
});
