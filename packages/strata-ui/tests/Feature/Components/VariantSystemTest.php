<?php

describe('Variant System', function () {
    test('input renders faded variant by default', function () {
        expectComponent('input')
            ->toHaveClasses('bg-input', 'border', 'border-border');
    });

    test('input renders flat variant', function () {
        expectComponent($this, 'input', ['variant' => 'flat'])
            ->toHaveClasses('bg-input', 'border-transparent');
    });

    test('input renders bordered variant', function () {
        expectComponent($this, 'input', ['variant' => 'bordered'])
            ->toHaveClasses('bg-transparent', 'border', 'border-border');
    });

    test('input renders underlined variant', function () {
        expectComponent($this, 'input', ['variant' => 'underlined'])
            ->toHaveClasses('bg-transparent', 'border-b-0', 'relative', 'after:absolute');
    });

    test('textarea renders all variants', function () {
        expectComponent($this, 'textarea', ['variant' => 'faded'])
            ->toHaveClasses('bg-input', 'border', 'border-border');

        expectComponent($this, 'textarea', ['variant' => 'flat'])
            ->toHaveClasses('bg-input', 'border-transparent');

        expectComponent($this, 'textarea', ['variant' => 'bordered'])
            ->toHaveClasses('bg-transparent', 'border', 'border-border');

        expectComponent($this, 'textarea', ['variant' => 'underlined'])
            ->toHaveClasses('bg-transparent', 'border-b-0', 'relative');
    });

    test('select renders all variants', function () {
        expectComponent($this, 'select', ['variant' => 'faded'])
            ->toHaveClasses('bg-input', 'border', 'border-border');

        expectComponent($this, 'select', ['variant' => 'flat'])
            ->toHaveClasses('bg-input', 'border-transparent');

        expectComponent($this, 'select', ['variant' => 'bordered'])
            ->toHaveClasses('bg-transparent', 'border', 'border-border');

        expectComponent($this, 'select', ['variant' => 'underlined'])
            ->toHaveClasses('bg-transparent', 'border-b-0', 'relative');
    });

    test('date-picker renders all variants', function () {
        expectComponent($this, 'date-picker', ['variant' => 'faded'])
            ->toHaveClasses('bg-input', 'border', 'border-border');

        expectComponent($this, 'date-picker', ['variant' => 'flat'])
            ->toHaveClasses('bg-input', 'border-transparent');

        expectComponent($this, 'date-picker', ['variant' => 'bordered'])
            ->toHaveClasses('bg-transparent', 'border', 'border-border');

        expectComponent($this, 'date-picker', ['variant' => 'underlined'])
            ->toHaveClasses('bg-transparent', 'border-b-0', 'relative');
    });

    test('time-picker renders all variants', function () {
        expectComponent($this, 'time-picker', ['variant' => 'faded'])
            ->toHaveClasses('bg-input', 'border', 'border-border');

        expectComponent($this, 'time-picker', ['variant' => 'flat'])
            ->toHaveClasses('bg-input', 'border-transparent');

        expectComponent($this, 'time-picker', ['variant' => 'bordered'])
            ->toHaveClasses('bg-transparent', 'border', 'border-border');

        expectComponent($this, 'time-picker', ['variant' => 'underlined'])
            ->toHaveClasses('bg-transparent', 'border-b-0', 'relative');
    });

    test('color-picker renders all variants', function () {
        expectComponent($this, 'color-picker', ['variant' => 'faded'])
            ->toHaveClasses('bg-input', 'border', 'border-border');

        expectComponent($this, 'color-picker', ['variant' => 'flat'])
            ->toHaveClasses('bg-input', 'border-transparent');

        expectComponent($this, 'color-picker', ['variant' => 'bordered'])
            ->toHaveClasses('bg-transparent', 'border', 'border-border');

        expectComponent($this, 'color-picker', ['variant' => 'underlined'])
            ->toHaveClasses('bg-transparent', 'border-b-0', 'relative');
    });

    test('variant works with validation states', function () {
        expectComponent($this, 'input', ['variant' => 'bordered', 'state' => 'error'])
            ->toHaveClasses('bg-transparent', 'border', 'border-destructive');

        expectComponent($this, 'input', ['variant' => 'flat', 'state' => 'success'])
            ->toHaveClasses('bg-input', 'border-transparent', 'border-success');
    });

    test('variant works with different sizes', function () {
        expectComponent($this, 'input', ['variant' => 'underlined', 'size' => 'sm'])
            ->toHaveClasses('bg-transparent', 'h-9', 'px-3');

        expectComponent($this, 'input', ['variant' => 'bordered', 'size' => 'lg'])
            ->toHaveClasses('bg-transparent', 'h-11', 'px-4');
    });
});
