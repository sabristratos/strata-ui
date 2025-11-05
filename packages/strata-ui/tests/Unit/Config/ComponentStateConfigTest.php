<?php

use Stratos\StrataUI\Config\ComponentStateConfig;

test('inputStates returns correct state classes', function () {
    $states = ComponentStateConfig::inputStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toBe('border-border focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2')
        ->and($states['success'])->toBe('border-success focus-within:ring-2 focus-within:ring-success/20 focus-within:ring-offset-2')
        ->and($states['error'])->toBe('border-destructive focus-within:ring-2 focus-within:ring-destructive/20 focus-within:ring-offset-2')
        ->and($states['warning'])->toBe('border-warning focus-within:ring-2 focus-within:ring-warning/20 focus-within:ring-offset-2');
});

test('focusableStates returns correct state classes', function () {
    $states = ComponentStateConfig::focusableStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toBe('border-border focus:ring-2 focus:ring-ring focus:ring-offset-2')
        ->and($states['success'])->toBe('border-success focus:ring-2 focus:ring-success/20 focus:ring-offset-2')
        ->and($states['error'])->toBe('border-destructive focus:ring-2 focus:ring-destructive/20 focus:ring-offset-2')
        ->and($states['warning'])->toBe('border-warning focus:ring-2 focus:ring-warning/20 focus:ring-offset-2');
});

test('pickerStates returns correct state classes', function () {
    $states = ComponentStateConfig::pickerStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toBe('border-border focus-within:ring-ring')
        ->and($states['success'])->toBe('border-success focus-within:ring-success/20')
        ->and($states['error'])->toBe('border-destructive focus-within:ring-destructive/20')
        ->and($states['warning'])->toBe('border-warning focus-within:ring-warning/20');
});

test('checkableStates returns correct state classes', function () {
    $states = ComponentStateConfig::checkableStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toBe('border-border hover:border-primary/50 focus:ring-ring accent-primary')
        ->and($states['success'])->toBe('border-success hover:border-success/80 focus:ring-success accent-success')
        ->and($states['error'])->toBe('border-destructive hover:border-destructive/80 focus:ring-destructive accent-destructive')
        ->and($states['warning'])->toBe('border-warning hover:border-warning/80 focus:ring-warning accent-warning');
});

test('toggleStates returns correct nested state structure', function () {
    $states = ComponentStateConfig::toggleStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toHaveKeys(['track', 'thumb'])
        ->and($states['success'])->toHaveKeys(['track', 'thumb'])
        ->and($states['error'])->toHaveKeys(['track', 'thumb'])
        ->and($states['warning'])->toHaveKeys(['track', 'thumb'])
        ->and($states['default']['track'])->toBe('bg-muted group-has-[:checked]:bg-primary focus:ring-primary')
        ->and($states['default']['thumb'])->toBe('bg-body')
        ->and($states['success']['track'])->toBe('bg-muted group-has-[:checked]:bg-success focus:ring-success')
        ->and($states['error']['track'])->toBe('bg-muted group-has-[:checked]:bg-destructive focus:ring-destructive')
        ->and($states['warning']['track'])->toBe('bg-muted group-has-[:checked]:bg-warning focus:ring-warning');
});

test('rangeSliderStates returns correct nested state structure', function () {
    $states = ComponentStateConfig::rangeSliderStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toHaveKeys(['track', 'range', 'handle'])
        ->and($states['success'])->toHaveKeys(['track', 'range', 'handle'])
        ->and($states['error'])->toHaveKeys(['track', 'range', 'handle'])
        ->and($states['warning'])->toHaveKeys(['track', 'range', 'handle'])
        ->and($states['default']['track'])->toBe('bg-muted')
        ->and($states['default']['range'])->toBe('bg-primary')
        ->and($states['default']['handle'])->toBe('bg-primary border-2 border-background ring-offset-background focus-visible:ring-2 focus-visible:ring-ring')
        ->and($states['success']['range'])->toBe('bg-success')
        ->and($states['error']['range'])->toBe('bg-destructive')
        ->and($states['warning']['range'])->toBe('bg-warning');
});

test('ratingStates returns correct state classes', function () {
    $states = ComponentStateConfig::ratingStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toBe('text-yellow-400')
        ->and($states['success'])->toBe('text-success')
        ->and($states['error'])->toBe('text-destructive')
        ->and($states['warning'])->toBe('text-warning');
});

test('fileInputStates returns correct state classes', function () {
    $states = ComponentStateConfig::fileInputStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toBe('border-border bg-secondary hover:border-primary hover:bg-muted/50')
        ->and($states['success'])->toBe('border-success bg-success/5 hover:bg-success/10')
        ->and($states['error'])->toBe('border-destructive bg-destructive/5 hover:bg-destructive/10')
        ->and($states['warning'])->toBe('border-warning bg-warning/5 hover:bg-warning/10');
});

test('sliderStates returns correct state classes', function () {
    $states = ComponentStateConfig::sliderStates();

    expect($states)->toBeArray()
        ->and($states)->toHaveKeys(['default', 'success', 'error', 'warning'])
        ->and($states['default'])->toBe('border-border')
        ->and($states['success'])->toBe('border-success')
        ->and($states['error'])->toBe('border-destructive')
        ->and($states['warning'])->toBe('border-warning');
});
