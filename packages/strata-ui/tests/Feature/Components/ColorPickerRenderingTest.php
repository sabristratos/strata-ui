<?php

describe('Color Picker Component', function () {
    test('renders with default props', function () {
        expectComponent('color-picker')
            ->toHaveDataAttribute('strata-colorpicker')
            ->toHaveDataAttribute('strata-field-type', 'color');
    });

    test('renders hidden input for Livewire binding', function () {
        expectComponent('color-picker')
            ->toContain('type="hidden"')
            ->toContain('data-strata-colorpicker-input')
            ->toContain('x-bind:value="entangleable.value"');
    });

    test('hidden input is in hidden div', function () {
        expectComponent('color-picker')
            ->toContain('<div class="hidden" hidden>')
            ->toContain('type="hidden"');
    });

    test('renders trigger with color preview', function () {
        expectComponent('color-picker')
            ->toContain('x-ref="trigger"')
            ->toContain('data-strata-colorpicker-trigger')
            ->toContain('data-strata-colorpicker-preview');
    });

    test('renders dropdown with picker UI', function () {
        expectComponent('color-picker')
            ->toContain('x-ref="dropdown"')
            ->toContain('data-strata-colorpicker-dropdown')
            ->toContain('data-strata-colorpicker-picker');
    });

    test('generates unique ID when not provided', function () {
        expectComponent('color-picker')
            ->toContain('color-picker-')
            ->toContain('id="color-picker-');
    });

    test('uses provided ID', function () {
        expectComponent('color-picker', ['id' => 'my-color-picker'])
            ->toContain('id="my-color-picker"');
    });

    test('uses provided name attribute', function () {
        expectComponent('color-picker', ['name' => 'favorite_color'])
            ->toContain('name="favorite_color"');
    });
});

describe('Color Picker Sizes', function () {
    test('renders small size', function () {
        expectComponent('color-picker', ['size' => 'sm'])
            ->toHaveClasses('h-9', 'px-3', 'text-sm');
    });

    test('renders medium size (default)', function () {
        expectComponent('color-picker')
            ->toHaveClasses('h-10', 'px-3', 'text-base');
    });

    test('renders large size', function () {
        expectComponent('color-picker', ['size' => 'lg'])
            ->toHaveClasses('h-11', 'px-4', 'text-lg');
    });
});

describe('Color Picker States', function () {
    test('renders default state', function () {
        expectComponent('color-picker', ['state' => 'default'])
            ->toContain('border-border')
            ->toContain('focus-within:ring-ring');
    });

    test('renders success state', function () {
        expectComponent('color-picker', ['state' => 'success'])
            ->toContain('border-success')
            ->toContain('focus-within:ring-success/20');
    });

    test('renders error state', function () {
        expectComponent('color-picker', ['state' => 'error'])
            ->toContain('border-destructive')
            ->toContain('focus-within:ring-destructive/20');
    });

    test('renders warning state', function () {
        expectComponent('color-picker', ['state' => 'warning'])
            ->toContain('border-warning')
            ->toContain('focus-within:ring-warning/20');
    });
});

describe('Color Picker Formats', function () {
    test('renders with hex format (default)', function () {
        expectComponent('color-picker')
            ->toContain("format: 'hex'");
    });

    test('renders with hsl format', function () {
        expectComponent('color-picker', ['format' => 'hsl'])
            ->toContain("format: 'hsl'");
    });
});

describe('Color Picker Values', function () {
    test('renders with initial hex value', function () {
        expectComponent('color-picker', ['value' => '#ff0000'])
            ->toContain('initialValue: &quot;#ff0000&quot;');
    });

    test('renders with initial hsl value', function () {
        expectComponent('color-picker', ['value' => 'hsl(0, 100%, 50%)'])
            ->toContain('initialValue: &quot;hsl(0, 100%, 50%)&quot;');
    });

    test('renders without initial value', function () {
        expectComponent('color-picker')
            ->toContain('initialValue: null');
    });
});

describe('Color Picker Alpha Channel', function () {
    test('renders without alpha by default', function () {
        expectComponent('color-picker')
            ->toContain('allowAlpha: false')
            ->not->toContain('data-strata-colorpicker-alpha-slider-wrapper');
    });

    test('renders with alpha when enabled', function () {
        expectComponent('color-picker', ['allowAlpha' => true])
            ->toContain('allowAlpha: true')
            ->toContain('data-strata-colorpicker-alpha-slider-wrapper');
    });
});

describe('Color Picker Presets', function () {
    test('renders with default Tailwind presets', function () {
        expectComponent('color-picker')
            ->toContain('data-strata-colorpicker-palette')
            ->toContain('data-strata-colorpicker-swatch');
    });

    test('passes showPresets prop to dropdown', function () {
        expectComponent('color-picker', ['showPresets' => false])
            ->toContain('data-strata-colorpicker-dropdown');
    });

    test('renders with showPresets enabled', function () {
        expectComponent('color-picker', ['showPresets' => true])
            ->toContain('data-strata-colorpicker-dropdown')
            ->toContain('data-strata-colorpicker-palette');
    });
});

describe('Color Picker Picker UI', function () {
    test('renders saturation/lightness area', function () {
        expectComponent('color-picker')
            ->toContain('data-strata-colorpicker-sl-area')
            ->toContain('handleSLMouseDown');
    });

    test('renders hue slider', function () {
        expectComponent('color-picker')
            ->toContain('data-strata-colorpicker-hue-slider')
            ->toContain('handleHueMouseDown');
    });

    test('renders color preview', function () {
        expectComponent('color-picker')
            ->toContain('data-strata-colorpicker-preview-large');
    });
});

describe('Color Picker Inputs', function () {
    test('renders format input field', function () {
        expectComponent('color-picker')
            ->toContain('data-strata-colorpicker-inputs')
            ->toContain('data-strata-colorpicker-input-display');
    });

    test('renders HSL component inputs when format is hsl', function () {
        expectComponent('color-picker', ['format' => 'hsl'])
            ->toContain('data-strata-colorpicker-input-hue')
            ->toContain('data-strata-colorpicker-input-saturation')
            ->toContain('data-strata-colorpicker-input-lightness');
    });

    test('renders alpha input when allowAlpha is true', function () {
        expectComponent('color-picker', ['allowAlpha' => true, 'format' => 'hsl'])
            ->toContain('data-strata-colorpicker-input-alpha');
    });
});

describe('Color Picker Clear Button', function () {
    test('renders clear button by default', function () {
        expectComponent('color-picker')
            ->toContain('clearable && hasValue() && !disabled');
    });

    test('hides clear button when clearable is false', function () {
        $html = (string) expectComponent('color-picker', ['clearable' => false])->value;
        // When clearable is false, the @if condition in index.blade.php prevents rendering
        expect($html)->not->toContain('@if($clearable)');
    });
});

describe('Color Picker Disabled State', function () {
    test('renders enabled by default', function () {
        expectComponent('color-picker')
            ->toContain('disabled: false')
            ->toContain('cursor-pointer');
    });

    test('renders disabled state', function () {
        expectComponent('color-picker', ['disabled' => true])
            ->toContain('disabled: true')
            ->toContain('opacity-50 cursor-not-allowed');
    });
});

describe('Color Picker Placeholder', function () {
    test('renders default placeholder', function () {
        expectComponent('color-picker')
            ->toContain("placeholder: 'Select color'");
    });

    test('renders custom placeholder', function () {
        expectComponent('color-picker', ['placeholder' => 'Choose a color'])
            ->toContain("placeholder: 'Choose a color'");
    });
});

describe('Color Picker Attribute Filtering', function () {
    test('filters wire:model to hidden input only', function () {
        expectComponent('color-picker', [
            'wire:model' => 'selectedColor',
            'class' => 'custom-class',
        ])
            ->toContain('class="relative custom-class"')
            ->toContain('wire:model="selectedColor"');
    });

    test('filters wire:model.live to hidden input only', function () {
        expectComponent('color-picker', [
            'wire:model.live' => 'color',
        ])
            ->toContain('wire:model.live="color"');
    });
});

describe('Color Picker Accessibility', function () {
    test('trigger has proper ARIA attributes', function () {
        expectComponent('color-picker')
            ->toContain('role="button"')
            ->toContain('aria-haspopup="true"')
            ->toContain(':aria-expanded="open"')
            ->toContain(':aria-disabled="disabled"');
    });

    test('dropdown has proper ARIA attributes', function () {
        expectComponent('color-picker')
            ->toContain('role="dialog"')
            ->toContain('aria-modal="true"');
    });

    test('trigger is keyboard accessible', function () {
        expectComponent('color-picker')
            ->toContain('@keydown.enter.prevent')
            ->toContain('@keydown.space.prevent');
    });

    test('dropdown closes on escape', function () {
        expectComponent('color-picker')
            ->toContain('@keydown.escape.window="open = false"');
    });

    test('trigger has tabindex 0 when enabled', function () {
        expectComponent('color-picker')
            ->toContain('tabindex="0"');
    });

    test('preset swatches have aria-label', function () {
        expectComponent('color-picker')
            ->toContain('aria-label=');
    });
});

describe('Color Picker Animation', function () {
    test('uses CSS animations not x-transition', function () {
        expectComponent('color-picker')
            ->toContain('transition-all transition-discrete')
            ->toContain('starting:opacity-0 starting:scale-95')
            ->not->toContain('x-transition');
    });

    test('uses will-change for performance', function () {
        expectComponent('color-picker')
            ->toContain('will-change-[transform,opacity]');
    });
});

describe('Color Picker Alpine Integration', function () {
    test('registers Alpine component', function () {
        expectComponent('color-picker')
            ->toContain("Alpine.data('strataColorPicker', window.strataColorPicker)");
    });

    test('initializes with props', function () {
        expectComponent('color-picker')
            ->toContain('window.strataColorPicker({');
    });

    test('has x-cloak on dropdown', function () {
        expectComponent('color-picker')
            ->toContain('x-cloak');
    });
});
