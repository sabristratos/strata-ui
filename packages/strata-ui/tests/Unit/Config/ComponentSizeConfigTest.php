<?php

use Stratos\StrataUI\Config\ComponentSizeConfig;

test('inputSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::inputSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('h-9 px-3 text-sm')
        ->and($sizes['md'])->toBe('h-10 px-3 text-base')
        ->and($sizes['lg'])->toBe('h-11 px-4 text-lg');
});

test('textareaSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::textareaSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('px-3 py-2 text-sm')
        ->and($sizes['md'])->toBe('px-3 py-2.5 text-base')
        ->and($sizes['lg'])->toBe('px-4 py-3 text-lg');
});

test('buttonSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::buttonSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('h-9 px-3 text-sm gap-1.5')
        ->and($sizes['md'])->toBe('h-10 px-3 text-base gap-2')
        ->and($sizes['lg'])->toBe('h-11 px-4 text-lg gap-2.5');
});

test('buttonIconSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::buttonIconSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('p-1.5')
        ->and($sizes['md'])->toBe('p-2')
        ->and($sizes['lg'])->toBe('p-2.5');
});

test('iconSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::iconSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('w-4 h-4')
        ->and($sizes['md'])->toBe('w-5 h-5')
        ->and($sizes['lg'])->toBe('w-6 h-6');
});

test('checkboxSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::checkboxSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('w-4 h-4')
        ->and($sizes['md'])->toBe('w-5 h-5')
        ->and($sizes['lg'])->toBe('w-6 h-6');
});

test('checkboxIconSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::checkboxIconSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('w-3 h-3')
        ->and($sizes['md'])->toBe('w-3.5 h-3.5')
        ->and($sizes['lg'])->toBe('w-4 h-4');
});

test('labelSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::labelSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('text-sm')
        ->and($sizes['md'])->toBe('text-base')
        ->and($sizes['lg'])->toBe('text-lg');
});

test('descriptionSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::descriptionSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('text-xs')
        ->and($sizes['md'])->toBe('text-sm')
        ->and($sizes['lg'])->toBe('text-base');
});

test('badgeSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::badgeSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('px-2 py-0.5 text-xs gap-1')
        ->and($sizes['md'])->toBe('px-2.5 py-1 text-sm gap-1.5')
        ->and($sizes['lg'])->toBe('px-3 py-1.5 text-base gap-2');
});

test('badgeIconSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::badgeIconSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('w-3 h-3')
        ->and($sizes['md'])->toBe('w-4 h-4')
        ->and($sizes['lg'])->toBe('w-5 h-5');
});

test('badgeDotSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::badgeDotSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('w-1.5 h-1.5')
        ->and($sizes['md'])->toBe('w-2 h-2')
        ->and($sizes['lg'])->toBe('w-2.5 h-2.5');
});

test('badgeDotTextSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::badgeDotTextSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('text-xs gap-1.5')
        ->and($sizes['md'])->toBe('text-sm gap-2')
        ->and($sizes['lg'])->toBe('text-base gap-2.5');
});

test('badgeContainerDotSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::badgeContainerDotSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('w-3 h-3')
        ->and($sizes['md'])->toBe('w-4 h-4')
        ->and($sizes['lg'])->toBe('w-5 h-5');
});

test('avatarSizes returns correct size classes including xs and xl', function () {
    $sizes = ComponentSizeConfig::avatarSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['xs', 'sm', 'md', 'lg', 'xl', '2xl'])
        ->and($sizes['xs'])->toBe('w-6 h-6 text-xs')
        ->and($sizes['sm'])->toBe('w-8 h-8 text-sm')
        ->and($sizes['md'])->toBe('w-10 h-10 text-base')
        ->and($sizes['lg'])->toBe('w-12 h-12 text-lg')
        ->and($sizes['xl'])->toBe('w-14 h-14 text-xl')
        ->and($sizes['2xl'])->toBe('w-16 h-16 text-2xl');
});

test('toggleSizes returns correct multi-part size structure', function () {
    $sizes = ComponentSizeConfig::toggleSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['track', 'handle'])
        ->and($sizes['track'])->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['handle'])->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['track']['sm'])->toBe('h-5 w-9')
        ->and($sizes['track']['md'])->toBe('h-7 w-12')
        ->and($sizes['track']['lg'])->toBe('h-9 w-16')
        ->and($sizes['handle']['sm'])->toBe('w-3 h-3')
        ->and($sizes['handle']['md'])->toBe('w-4 h-4')
        ->and($sizes['handle']['lg'])->toBe('w-5 h-5');
});

test('dropdownSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::dropdownSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('min-w-48 max-w-64')
        ->and($sizes['md'])->toBe('min-w-64 max-w-96')
        ->and($sizes['lg'])->toBe('min-w-80 max-w-lg');
});

test('selectSizes returns correct multi-part size structure', function () {
    $sizes = ComponentSizeConfig::selectSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toHaveKeys(['trigger', 'icon', 'dropdown'])
        ->and($sizes['md'])->toHaveKeys(['trigger', 'icon', 'dropdown'])
        ->and($sizes['lg'])->toHaveKeys(['trigger', 'icon', 'dropdown'])
        ->and($sizes['sm']['trigger'])->toBe('h-9 px-3 text-sm')
        ->and($sizes['sm']['icon'])->toBe('w-4 h-4')
        ->and($sizes['sm']['dropdown'])->toBe('min-w-48 max-w-64')
        ->and($sizes['md']['trigger'])->toBe('h-10 px-3 text-base')
        ->and($sizes['md']['icon'])->toBe('w-5 h-5')
        ->and($sizes['md']['dropdown'])->toBe('min-w-64 max-w-96')
        ->and($sizes['lg']['trigger'])->toBe('h-11 px-4 text-lg')
        ->and($sizes['lg']['icon'])->toBe('w-6 h-6')
        ->and($sizes['lg']['dropdown'])->toBe('min-w-80 max-w-lg');
});

test('modalSizes returns correct size classes including xl', function () {
    $sizes = ComponentSizeConfig::modalSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg', 'xl'])
        ->and($sizes['sm'])->toBe('max-w-sm')
        ->and($sizes['md'])->toBe('max-w-xl')
        ->and($sizes['lg'])->toBe('max-w-3xl')
        ->and($sizes['xl'])->toBe('max-w-5xl');
});

test('breadcrumbsSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::breadcrumbsSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('text-sm gap-1.5')
        ->and($sizes['md'])->toBe('text-base gap-2')
        ->and($sizes['lg'])->toBe('text-lg gap-2.5');
});

test('breadcrumbsIconSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::breadcrumbsIconSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('w-3.5 h-3.5')
        ->and($sizes['md'])->toBe('w-4 h-4')
        ->and($sizes['lg'])->toBe('w-5 h-5');
});

test('tableSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::tableSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('text-sm')
        ->and($sizes['md'])->toBe('text-base')
        ->and($sizes['lg'])->toBe('text-lg');
});

test('calendarSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::calendarSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('text-sm')
        ->and($sizes['md'])->toBe('text-base')
        ->and($sizes['lg'])->toBe('text-lg');
});

test('editorSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::editorSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('min-h-32 text-sm')
        ->and($sizes['md'])->toBe('min-h-60 text-base')
        ->and($sizes['lg'])->toBe('min-h-96 text-lg');
});

test('fileInputSizes returns correct multi-part size structure', function () {
    $sizes = ComponentSizeConfig::fileInputSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toHaveKeys(['wrapper', 'icon', 'label', 'hint'])
        ->and($sizes['md'])->toHaveKeys(['wrapper', 'icon', 'label', 'hint'])
        ->and($sizes['lg'])->toHaveKeys(['wrapper', 'icon', 'label', 'hint'])
        ->and($sizes['sm']['wrapper'])->toBe('px-4 py-6 gap-2')
        ->and($sizes['sm']['icon'])->toBe('w-8 h-8')
        ->and($sizes['sm']['label'])->toBe('text-sm')
        ->and($sizes['sm']['hint'])->toBe('text-xs')
        ->and($sizes['md']['wrapper'])->toBe('px-6 py-8 gap-3')
        ->and($sizes['md']['icon'])->toBe('w-10 h-10')
        ->and($sizes['md']['label'])->toBe('text-base')
        ->and($sizes['md']['hint'])->toBe('text-sm')
        ->and($sizes['lg']['wrapper'])->toBe('px-8 py-10 gap-4')
        ->and($sizes['lg']['icon'])->toBe('w-12 h-12')
        ->and($sizes['lg']['label'])->toBe('text-lg')
        ->and($sizes['lg']['hint'])->toBe('text-base');
});

test('rangeSliderSizes returns correct multi-part size structure', function () {
    $sizes = ComponentSizeConfig::rangeSliderSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toHaveKeys(['track', 'handle', 'text'])
        ->and($sizes['md'])->toHaveKeys(['track', 'handle', 'text'])
        ->and($sizes['lg'])->toHaveKeys(['track', 'handle', 'text'])
        ->and($sizes['sm']['track'])->toBe('h-1')
        ->and($sizes['sm']['handle'])->toBe('w-4 h-4')
        ->and($sizes['sm']['text'])->toBe('text-xs')
        ->and($sizes['md']['track'])->toBe('h-2')
        ->and($sizes['md']['handle'])->toBe('w-5 h-5')
        ->and($sizes['md']['text'])->toBe('text-sm')
        ->and($sizes['lg']['track'])->toBe('h-3')
        ->and($sizes['lg']['handle'])->toBe('w-6 h-6')
        ->and($sizes['lg']['text'])->toBe('text-base');
});

test('bottomNavSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::bottomNavSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('px-2 py-2 gap-1')
        ->and($sizes['md'])->toBe('px-3 py-2.5 gap-2')
        ->and($sizes['lg'])->toBe('px-4 py-3 gap-3');
});

test('bottomNavItemSizes returns correct multi-part size structure', function () {
    $sizes = ComponentSizeConfig::bottomNavItemSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toHaveKeys(['container', 'icon'])
        ->and($sizes['md'])->toHaveKeys(['container', 'icon'])
        ->and($sizes['lg'])->toHaveKeys(['container', 'icon'])
        ->and($sizes['sm']['container'])->toBe('min-h-11 px-3 py-2 gap-1.5 text-xs')
        ->and($sizes['sm']['icon'])->toBe('w-4 h-4')
        ->and($sizes['md']['container'])->toBe('min-h-14 px-4 py-2.5 gap-2 text-sm')
        ->and($sizes['md']['icon'])->toBe('w-5 h-5')
        ->and($sizes['lg']['container'])->toBe('min-h-16 px-5 py-3 gap-2.5 text-base')
        ->and($sizes['lg']['icon'])->toBe('w-6 h-6');
});

test('popoverContentSizes returns correct size classes with normal variant', function () {
    $sizes = ComponentSizeConfig::popoverContentSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'normal', 'lg'])
        ->and($sizes['sm'])->toBe('p-3')
        ->and($sizes['normal'])->toBe('p-4')
        ->and($sizes['lg'])->toBe('p-6');
});

test('radioInnerDotSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::radioInnerDotSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('w-1.5 h-1.5')
        ->and($sizes['md'])->toBe('w-2 h-2')
        ->and($sizes['lg'])->toBe('w-2.5 h-2.5');
});

test('sliderSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::sliderSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('min-h-32')
        ->and($sizes['md'])->toBe('min-h-48')
        ->and($sizes['lg'])->toBe('min-h-64');
});

test('flyoutSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::flyoutSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg', 'xl'])
        ->and($sizes['sm'])->toBe('max-w-sm')
        ->and($sizes['md'])->toBe('max-w-md')
        ->and($sizes['lg'])->toBe('max-w-lg')
        ->and($sizes['xl'])->toBe('max-w-xl');
});

test('kbdSizes returns correct size classes', function () {
    $sizes = ComponentSizeConfig::kbdSizes();

    expect($sizes)->toBeArray()
        ->and($sizes)->toHaveKeys(['sm', 'md', 'lg'])
        ->and($sizes['sm'])->toBe('px-1.5 py-0.5 text-xs min-h-5 min-w-5')
        ->and($sizes['md'])->toBe('px-2 py-1 text-sm min-h-6 min-w-6')
        ->and($sizes['lg'])->toBe('px-3 py-1.5 text-base min-h-8 min-w-8');
});

test('getSize returns correct size with default fallback', function () {
    $sizes = ['sm' => 'small', 'md' => 'medium', 'lg' => 'large'];

    expect(ComponentSizeConfig::getSize($sizes, 'md'))->toBe('medium')
        ->and(ComponentSizeConfig::getSize($sizes, 'lg'))->toBe('large')
        ->and(ComponentSizeConfig::getSize($sizes, 'invalid'))->toBe('medium')
        ->and(ComponentSizeConfig::getSize($sizes, 'invalid', 'sm'))->toBe('small');
});

test('getSize returns empty string when size and default not found', function () {
    $sizes = ['sm' => 'small'];

    expect(ComponentSizeConfig::getSize($sizes, 'invalid', 'invalid'))->toBe('');
});

test('getSizePart returns correct size part with default fallback', function () {
    $sizes = [
        'sm' => ['trigger' => 'h-9', 'icon' => 'w-4'],
        'md' => ['trigger' => 'h-10', 'icon' => 'w-5'],
        'lg' => ['trigger' => 'h-11', 'icon' => 'w-6'],
    ];

    expect(ComponentSizeConfig::getSizePart($sizes, 'md', 'trigger'))->toBe('h-10')
        ->and(ComponentSizeConfig::getSizePart($sizes, 'lg', 'icon'))->toBe('w-6')
        ->and(ComponentSizeConfig::getSizePart($sizes, 'invalid', 'trigger'))->toBe('h-10')
        ->and(ComponentSizeConfig::getSizePart($sizes, 'invalid', 'trigger', 'sm'))->toBe('h-9');
});

test('getSizePart returns empty string when size part and default not found', function () {
    $sizes = [
        'sm' => ['trigger' => 'h-9'],
    ];

    expect(ComponentSizeConfig::getSizePart($sizes, 'invalid', 'invalid', 'invalid'))->toBe('');
});
