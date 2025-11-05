<?php

use Illuminate\View\ComponentAttributeBag;
use Stratos\StrataUI\Support\ComponentHelpers;

test('generateId returns custom ID when provided', function () {
    $id = ComponentHelpers::generateId('test', 'custom-id', null);

    expect($id)->toBe('custom-id');
});

test('generateId returns ID from attributes when no custom ID provided', function () {
    $attributes = new ComponentAttributeBag(['id' => 'attr-id']);

    $id = ComponentHelpers::generateId('test', null, $attributes);

    expect($id)->toBe('attr-id');
});

test('generateId generates ID with prefix when no ID or attributes provided', function () {
    $id = ComponentHelpers::generateId('test', null, null);

    expect($id)
        ->toStartWith('test-')
        ->toHaveLength(strlen('test-') + 13); // uniqid() generates 13 chars
});

test('generateId generates ID with prefix when attributes has no ID', function () {
    $attributes = new ComponentAttributeBag(['class' => 'foo']);

    $id = ComponentHelpers::generateId('test', null, $attributes);

    expect($id)
        ->toStartWith('test-')
        ->toHaveLength(strlen('test-') + 13);
});

test('generateId prioritizes custom ID over attributes', function () {
    $attributes = new ComponentAttributeBag(['id' => 'attr-id']);

    $id = ComponentHelpers::generateId('test', 'custom-id', $attributes);

    expect($id)->toBe('custom-id');
});

test('generateId works with different prefixes', function () {
    $ids = [
        ComponentHelpers::generateId('date-picker'),
        ComponentHelpers::generateId('select'),
        ComponentHelpers::generateId('dropdown'),
    ];

    expect($ids[0])->toStartWith('date-picker-')
        ->and($ids[1])->toStartWith('select-')
        ->and($ids[2])->toStartWith('dropdown-');
});

test('generateId generates unique IDs on multiple calls', function () {
    $id1 = ComponentHelpers::generateId('test');
    $id2 = ComponentHelpers::generateId('test');

    expect($id1)->not->toBe($id2)
        ->and($id1)->toStartWith('test-')
        ->and($id2)->toStartWith('test-');
});
