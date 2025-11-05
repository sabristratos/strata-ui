<?php

describe('Range Slider Component', function () {
    test('renders with default props', function () {
        expectComponent('range-slider')
            ->toHaveDataAttribute('strata-range-slider')
            ->toHaveDataAttribute('strata-field-type', 'range');
    });

    test('renders hidden input for Livewire binding', function () {
        expectComponent('range-slider')
            ->toContain('type="hidden"')
            ->toContain('data-strata-range-slider-input')
            ->toContain('x-bind:value="JSON.stringify(entangleable.value)"');
    });

    test('renders track element', function () {
        expectComponent('range-slider')
            ->toContain('data-strata-range-slider-track')
            ->toContain('x-ref="track"')
            ->toContain('@click="handleTrackClick($event)"');
    });

    test('renders range highlight', function () {
        expectComponent('range-slider')
            ->toContain('data-strata-range-slider-range')
            ->toContain('x-ref="range"')
            ->toContain(':style="`left: ${minPercent}%; width: ${maxPercent - minPercent}%`"');
    });

    test('renders both handles', function () {
        expectComponent('range-slider')
            ->toContain('data-strata-range-slider-handle-type="min"')
            ->toContain('data-strata-range-slider-handle-type="max"')
            ->toContain('x-ref="minHandle"')
            ->toContain('x-ref="maxHandle"')
            ->toContain('@mousedown="handleMinMouseDown($event)"')
            ->toContain('@mousedown="handleMaxMouseDown($event)"')
            ->toContain('@keydown="handleMinKeydown($event)"')
            ->toContain('@keydown="handleMaxKeydown($event)"');
    });

    test('renders ARIA attributes on handles', function () {
        expectComponent('range-slider')
            ->toContain('role="slider"')
            ->toContain(':aria-label="\'Minimum value\'"')
            ->toContain(':aria-label="\'Maximum value\'"')
            ->toContain(':aria-valuemin="min"')
            ->toContain(':aria-valuemax="max"')
            ->toContain(':aria-valuenow="entangleable.value?.min ?? min"')
            ->toContain(':aria-valuenow="entangleable.value?.max ?? max"');
    });

    test('renders value displays when showValues is true', function () {
        expectComponent('range-slider', ['showValues' => true])
            ->toContain('x-show="showValues"')
            ->toContain('x-text="formatValue(entangleable.value?.min ?? min)"')
            ->toContain('x-text="formatValue(entangleable.value?.max ?? max)"');
    });

    test('renders min/max labels when showLabels is true', function () {
        expectComponent('range-slider', [':showLabels' => 'true', ':min' => '0', ':max' => '100'])
            ->toContain('x-show="showLabels"')
            ->toContain('<span>0</span>')
            ->toContain('<span>100</span>');
    });

    test('renders with custom min, max, and step', function () {
        expectComponent('range-slider', [':min' => '10', ':max' => '500', ':step' => '5'])
            ->toContain('min: 10')
            ->toContain('max: 500')
            ->toContain('step: 5');
    });

    test('renders with prefix', function () {
        expectComponent('range-slider', ['prefix' => '$'])
            ->toContain('prefix: \'$\'');
    });

    test('renders with suffix', function () {
        expectComponent('range-slider', ['suffix' => '%'])
            ->toContain('suffix: \'%\'');
    });

    test('renders all track sizes', function () {
        expectComponent('range-slider', ['size' => 'sm'])
            ->toContain('h-1');

        expectComponent('range-slider', ['size' => 'md'])
            ->toContain('h-2');

        expectComponent('range-slider', ['size' => 'lg'])
            ->toContain('h-3');
    });

    test('renders all handle sizes', function () {
        expectComponent('range-slider', ['size' => 'sm'])
            ->toContain('w-4 h-4');

        expectComponent('range-slider', ['size' => 'md'])
            ->toContain('w-5 h-5');

        expectComponent('range-slider', ['size' => 'lg'])
            ->toContain('w-6 h-6');
    });

    test('renders all validation states for track', function () {
        expectComponent('range-slider', ['state' => 'default'])
            ->toContain('bg-muted');

        expectComponent('range-slider', ['state' => 'success'])
            ->toContain('bg-muted');

        expectComponent('range-slider', ['state' => 'error'])
            ->toContain('bg-muted');

        expectComponent('range-slider', ['state' => 'warning'])
            ->toContain('bg-muted');
    });

    test('renders all validation states for range', function () {
        expectComponent('range-slider', ['state' => 'default'])
            ->toContain('bg-primary');

        expectComponent('range-slider', ['state' => 'success'])
            ->toContain('bg-success');

        expectComponent('range-slider', ['state' => 'error'])
            ->toContain('bg-destructive');

        expectComponent('range-slider', ['state' => 'warning'])
            ->toContain('bg-warning');
    });

    test('renders all validation states for handles', function () {
        expectComponent('range-slider', ['state' => 'default'])
            ->toContain('border-primary');

        expectComponent('range-slider', ['state' => 'success'])
            ->toContain('border-success');

        expectComponent('range-slider', ['state' => 'error'])
            ->toContain('border-destructive');

        expectComponent('range-slider', ['state' => 'warning'])
            ->toContain('border-warning');
    });

    test('renders disabled state', function () {
        expectComponent('range-slider', [':disabled' => 'true'])
            ->toContain('disabled: true')
            ->toContain(':disabled="disabled"')
            ->toContain(':aria-disabled="disabled"')
            ->toContain('opacity-50 cursor-not-allowed');
    });

    test('renders with initial value', function () {
        expectComponent('range-slider')
            ->toContain('initialValue: null');
    });

    test('renders with custom id', function () {
        expectComponent('range-slider', ['id' => 'custom-slider'])
            ->toContain('id="custom-slider"');
    });

    test('renders with custom name', function () {
        expectComponent('range-slider', ['name' => 'price_range'])
            ->toContain('name="price_range"');
    });

    test('initializes Alpine component', function () {
        expectComponent('range-slider')
            ->toContain('x-data="window.strataRangeSlider({')
            ->toContain('min: 0')
            ->toContain('max: 100')
            ->toContain('step: 1')
            ->toContain('showValues: true')
            ->toContain('showLabels: true')
            ->toContain('disabled: false');
    });

    test('filters wire:model from wrapper', function () {
        $html = test()->renderComponent('range-slider', ['wire:model' => 'range']);

        $firstDiv = substr($html, 0, strpos($html, '<div class="hidden"'));
        expect($firstDiv)->not->toContain('wire:model');
    });

    test('applies wire:model to hidden input', function () {
        expectComponent('range-slider', ['wire:model' => 'range'])
            ->toContain('type="hidden"')
            ->toContain('wire:model="range"');
    });

    test('merges custom classes', function () {
        expectComponent('range-slider', ['class' => 'custom-class'])
            ->toContain('custom-class');
    });

    test('renders with e-commerce example props', function () {
        expectComponent('range-slider', [':min' => '0', ':max' => '1000', ':step' => '10', 'prefix' => '$'])
            ->toContain('min: 0')
            ->toContain('max: 1000')
            ->toContain('step: 10')
            ->toContain('prefix: \'$\'');
    });

    test('renders with percentage example props', function () {
        expectComponent('range-slider', [':min' => '0', ':max' => '100', ':step' => '5', 'suffix' => '%'])
            ->toContain('suffix: \'%\'');
    });

    test('renders with temperature example props', function () {
        expectComponent('range-slider', [':min' => '-20', ':max' => '50', ':step' => '1', 'suffix' => '°C'])
            ->toContain('min: -20')
            ->toContain('max: 50')
            ->toContain('suffix: \'°C\'');
    });

    test('renders with rating example props', function () {
        expectComponent('range-slider', [':min' => '1', ':max' => '5', ':step' => '0.5'])
            ->toContain('min: 1')
            ->toContain('max: 5')
            ->toContain('step: 0.5');
    });
});
