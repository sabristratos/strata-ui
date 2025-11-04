<?php

use Carbon\Carbon;
use Stratos\StrataUI\Data\DateValue;
use Stratos\StrataUI\Synthesizers\DateValueSynthesizer;

beforeEach(function () {
    Carbon::setTestNow('2024-11-04 12:00:00');
    $this->synthesizer = new DateValueSynthesizer();
});

afterEach(function () {
    Carbon::setTestNow();
});

describe('DateValueSynthesizer Match', function () {
    test('matches DateValue instances', function () {
        $date = DateValue::make('2024-11-04');

        expect(DateValueSynthesizer::match($date))->toBeTrue();
    });

    test('does not match non-DateValue types', function () {
        expect(DateValueSynthesizer::match('2024-11-04'))->toBeFalse();
        expect(DateValueSynthesizer::match(null))->toBeFalse();
        expect(DateValueSynthesizer::match([]))->toBeFalse();
    });
});

describe('DateValueSynthesizer Dehydrate', function () {
    test('dehydrates DateValue to string', function () {
        $date = DateValue::make('2024-11-04');
        [$value, $meta] = $this->synthesizer->dehydrate($date);

        expect($value)->toBe('2024-11-04');
        expect($meta)->toBe([]);
    });
});

describe('DateValueSynthesizer Hydrate', function () {
    test('hydrates string to DateValue', function () {
        $result = $this->synthesizer->hydrate('2024-11-04');

        expect($result)->toBeInstanceOf(DateValue::class);
        expect($result->toDateString())->toBe('2024-11-04');
    });

    test('hydrates null to null', function () {
        expect($this->synthesizer->hydrate(null))->toBeNull();
    });

    test('hydrates empty string to null', function () {
        expect($this->synthesizer->hydrate(''))->toBeNull();
    });

    test('hydrates empty array to null', function () {
        expect($this->synthesizer->hydrate([]))->toBeNull();
    });

    test('hydrates invalid date to null', function () {
        expect($this->synthesizer->hydrate('invalid-date'))->toBeNull();
    });

    test('handles various date formats', function () {
        $result = $this->synthesizer->hydrate('2024-11-04');
        expect($result->toDateString())->toBe('2024-11-04');

        $result = $this->synthesizer->hydrate('November 4, 2024');
        expect($result->toDateString())->toBe('2024-11-04');
    });
});

describe('DateValueSynthesizer Get/Set', function () {
    test('gets property value', function () {
        $object = (object) ['date' => DateValue::make('2024-11-04')];

        $result = $this->synthesizer->get($object, 'date');

        expect($result)->toBeInstanceOf(DateValue::class);
        expect($result->toDateString())->toBe('2024-11-04');
    });

    test('gets null for non-existent property', function () {
        $object = (object) [];

        $result = $this->synthesizer->get($object, 'date');

        expect($result)->toBeNull();
    });

    test('sets property value', function () {
        $object = (object) [];
        $date = DateValue::make('2024-11-04');

        $this->synthesizer->set($object, 'date', $date);

        expect($object->date)->toBe($date);
    });
});
