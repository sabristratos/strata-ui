<?php

namespace Stratos\StrataUI\Tests\Feature;

test('all translation keys exist in English translation file', function () {
    $enTranslations = json_decode(file_get_contents(__DIR__.'/../../lang/en.json'), true);

    expect($enTranslations)->toBeArray()
        ->and($enTranslations)->toHaveKeys([
            'Today',
            'Yesterday',
            'Tomorrow',
            'Select date',
            'Select time',
            'AM',
            'PM',
            'Uploading...',
            'Search countries...',
            'Add link',
            'Add image',
            'Previous image',
            'Next image',
            'Remove',
            'Clear',
            'Close',
            'Show password',
            'Hide password',
        ]);
});

test('all translation keys exist in French translation file', function () {
    $frTranslations = json_decode(file_get_contents(__DIR__.'/../../lang/fr.json'), true);

    expect($frTranslations)->toBeArray()
        ->and($frTranslations)->toHaveKeys([
            'Today',
            'Yesterday',
            'Tomorrow',
            'Select date',
            'Select time',
            'AM',
            'PM',
            'Uploading...',
            'Search countries...',
            'Add link',
            'Add image',
            'Previous image',
            'Next image',
            'Remove',
            'Clear',
            'Close',
            'Show password',
            'Hide password',
        ]);
});

test('all translation keys exist in Arabic translation file', function () {
    $arTranslations = json_decode(file_get_contents(__DIR__.'/../../lang/ar.json'), true);

    expect($arTranslations)->toBeArray()
        ->and($arTranslations)->toHaveKeys([
            'Today',
            'Yesterday',
            'Tomorrow',
            'Select date',
            'Select time',
            'AM',
            'PM',
            'Uploading...',
            'Search countries...',
            'Add link',
            'Add image',
            'Previous image',
            'Next image',
            'Remove',
            'Clear',
            'Close',
            'Show password',
            'Hide password',
        ]);
});

test('all three translation files have the same number of keys', function () {
    $enTranslations = json_decode(file_get_contents(__DIR__.'/../../lang/en.json'), true);
    $frTranslations = json_decode(file_get_contents(__DIR__.'/../../lang/fr.json'), true);
    $arTranslations = json_decode(file_get_contents(__DIR__.'/../../lang/ar.json'), true);

    expect(count($enTranslations))
        ->toBe(count($frTranslations))
        ->toBe(count($arTranslations));
});
