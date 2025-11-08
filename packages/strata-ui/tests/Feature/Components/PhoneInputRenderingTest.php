<?php

describe('PhoneInput Component', function () {
    $countries = [
        ['code' => 'US', 'name' => 'United States', 'dialCode' => '+1', 'flag' => 'us'],
        ['code' => 'GB', 'name' => 'United Kingdom', 'dialCode' => '+44', 'flag' => 'gb'],
        ['code' => 'FR', 'name' => 'France', 'dialCode' => '+33', 'flag' => 'fr'],
    ];

    test('renders with default props', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toHaveDataAttribute('strata-phone-input')
            ->toHaveDataAttribute('strata-field-type', 'tel');
    });

    test('renders hidden input for Livewire binding', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('type="hidden"')
            ->toContain('data-strata-phone-input-value')
            ->toContain('x-bind:value="entangleable.value"');
    });

    test('hidden input is in hidden div', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('<div class="hidden" hidden>')
            ->toContain('type="hidden"');
    });

    test('renders country selector using select component', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('data-strata-phone-country-select');
    });

    test('renders phone number input', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('data-strata-phone-number-input')
            ->toContain('type="tel"');
    });

    test('initializes Alpine component with strataPhoneInput', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('x-data="window.strataPhoneInput(');
    });

    test('passes countries to Alpine component', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('United States')
            ->toContain('+1');
    });

    test('renders with custom placeholder', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'placeholder' => 'Enter your phone',
        ])
            ->toContain('Enter your phone');
    });

    test('renders with default placeholder', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('Enter phone number');
    });

    test('renders with disabled state', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'disabled' => true,
        ])
            ->toContain('false, true')
            ->toContain('data-disabled="true"');
    });

    test('renders with readonly state', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'readonly' => true,
        ])
            ->toContain('false, true');
    });

    test('renders with required attribute', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'required' => true,
        ])
            ->toContain('true');
    });

    test('renders with initial value', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'value' => '+15551234567',
        ])
            ->toContain('+15551234567');
    });

    test('renders with default country', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'defaultCountry' => 'GB',
        ])
            ->toContain('GB');
    });

    test('renders all sizes', function () use ($countries) {
        expectComponent($this, 'phone-input', ['countries' => $countries, 'size' => 'sm'])
            ->toContain('sm');

        expectComponent($this, 'phone-input', ['countries' => $countries, 'size' => 'md'])
            ->toContain('md');

        expectComponent($this, 'phone-input', ['countries' => $countries, 'size' => 'lg'])
            ->toContain('lg');
    });

    test('renders all validation states', function () use ($countries) {
        expectComponent($this, 'phone-input', ['countries' => $countries, 'state' => 'default'])
            ->toContain('default');

        expectComponent($this, 'phone-input', ['countries' => $countries, 'state' => 'success'])
            ->toContain('success');

        expectComponent($this, 'phone-input', ['countries' => $countries, 'state' => 'error'])
            ->toContain('error');

        expectComponent($this, 'phone-input', ['countries' => $countries, 'state' => 'warning'])
            ->toContain('warning');
    });

    test('generates unique ID when not provided', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('phone-input-')
            ->toContain('id="phone-input-');
    });

    test('uses provided ID', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'id' => 'my-phone',
        ])
            ->toContain('id="my-phone"');
    });

    test('uses provided name attribute', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'name' => 'contact_phone',
        ])
            ->toContain('name="contact_phone"');
    });

    test('passes wire:model to hidden input only', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'wire:model' => 'phone',
        ])
            ->toContain('wire:model="phone"');
    });

    test('merges custom classes on wrapper', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'class' => 'custom-phone',
        ])
            ->toContain('class="relative custom-phone"');
    });

    test('component has relative positioning', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('class="relative"');
    });

    test('country selector has fixed width', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('width: 130px');
    });

    test('phone number input uses flex-1', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('flex-1');
    });

    test('country selector and input are in flex container', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('flex');
    });

    test('country selector is rounded on right and input on left', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('!rounded-r-none')
            ->toContain('!rounded-l-none');
    });

    test('shows validation message template', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('validationMessage');
    });

    test('renders dial code prefix in input', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('dialCode');
    });

    test('handles input with handleNumberInput', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('@input="handleNumberInput"');
    });

    test('handles keydown with handleKeydown', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('@keydown="handleKeydown"');
    });

    test('country selector is searchable', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain(':searchable="true"');
    });

    test('country selector has search placeholder', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('Search countries...');
    });

    test('renders flag icon template', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('fi fis');
    });

    test('default size is medium', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('md');
    });

    test('default state is default', function () use ($countries) {
        expectComponent('phone-input', ['countries' => $countries])
            ->toContain('default');
    });

    test('component properly filters wire:model attributes', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'wire:model' => 'phone',
            'wire:model.live' => 'phone2',
            'class' => 'custom',
        ])
            ->toContain('class="relative custom"')
            ->toContain('wire:model="phone"')
            ->toContain('wire:model.live="phone2"');
    });

    test('throws exception when countries array is empty', function () {
        expectComponent($this, 'phone-input', ['countries' => []])
            ->throws(InvalidArgumentException::class, 'countries prop is required');
    });

    test('throws exception when country is missing required fields', function () {
        $invalidCountries = [
            ['code' => 'US', 'name' => 'United States'],
        ];

        expectComponent($this, 'phone-input', ['countries' => $invalidCountries])
            ->throws(InvalidArgumentException::class, 'missing required fields');
    });

    test('throws exception for invalid size', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'size' => 'invalid',
        ])
            ->throws(InvalidArgumentException::class, 'Invalid size');
    });

    test('throws exception for invalid state', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'state' => 'invalid',
        ])
            ->throws(InvalidArgumentException::class, 'Invalid state');
    });

    test('throws exception for invalid defaultCountry', function () use ($countries) {
        expectComponent($this, 'phone-input', [
            'countries' => $countries,
            'defaultCountry' => 'XX',
        ])
            ->throws(InvalidArgumentException::class, 'Invalid defaultCountry');
    });
});
