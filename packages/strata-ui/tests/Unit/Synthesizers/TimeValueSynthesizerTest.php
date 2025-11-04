<?php

use Carbon\Carbon;
use Stratos\StrataUI\Data\TimeValue;
use Stratos\StrataUI\Synthesizers\TimeValueSynthesizer;

beforeEach(function () {
    Carbon::setTestNow('2024-11-04 14:30:45');
    $this->synthesizer = new TimeValueSynthesizer();
});

afterEach(function () {
    Carbon::setTestNow();
});

describe('TimeValueSynthesizer Match', function () {
    test('matches TimeValue instances', function () {
        $time = TimeValue::make('14:30');

        expect(TimeValueSynthesizer::match($time))->toBeTrue();
    });

    test('does not match non-TimeValue types', function () {
        expect(TimeValueSynthesizer::match('14:30'))->toBeFalse();
        expect(TimeValueSynthesizer::match(null))->toBeFalse();
        expect(TimeValueSynthesizer::match([]))->toBeFalse();
    });
});

describe('TimeValueSynthesizer Dehydrate', function () {
    test('dehydrates 24-hour TimeValue to string', function () {
        $time = TimeValue::make('14:30');
        [$value, $meta] = $this->synthesizer->dehydrate($time);

        expect($value)->toBe('14:30');
        expect($meta)->toBe([]);
    });

    test('dehydrates 12-hour TimeValue to string', function () {
        $time = TimeValue::make('2:30 PM');
        [$value, $meta] = $this->synthesizer->dehydrate($time);

        expect($value)->toBe('2:30 PM');
        expect($meta)->toBe([]);
    });

    test('dehydrates TimeValue with seconds', function () {
        $time = TimeValue::make('14:30:45');
        [$value, $meta] = $this->synthesizer->dehydrate($time);

        expect($value)->toBe('14:30:45');
        expect($meta)->toBe([]);
    });
});

describe('TimeValueSynthesizer Hydrate', function () {
    test('hydrates 24-hour string to TimeValue', function () {
        $result = $this->synthesizer->hydrate('14:30');

        expect($result)->toBeInstanceOf(TimeValue::class);
        expect($result->hour)->toBe(14);
        expect($result->minute)->toBe(30);
    });

    test('hydrates 12-hour string to TimeValue', function () {
        $result = $this->synthesizer->hydrate('2:30 PM');

        expect($result)->toBeInstanceOf(TimeValue::class);
        expect($result->hour)->toBe(2);
        expect($result->minute)->toBe(30);
        expect($result->meridiem)->toBe('PM');
    });

    test('hydrates time string with seconds', function () {
        $result = $this->synthesizer->hydrate('14:30:45');

        expect($result)->toBeInstanceOf(TimeValue::class);
        expect($result->hour)->toBe(14);
        expect($result->minute)->toBe(30);
        expect($result->second)->toBe(45);
    });

    test('hydrates array to TimeValue', function () {
        $data = [
            'hour' => 14,
            'minute' => 30,
            'second' => 45,
        ];

        $result = $this->synthesizer->hydrate($data);

        expect($result)->toBeInstanceOf(TimeValue::class);
        expect($result->hour)->toBe(14);
        expect($result->minute)->toBe(30);
        expect($result->second)->toBe(45);
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

    test('hydrates invalid time to null', function () {
        expect($this->synthesizer->hydrate('invalid-time'))->toBeNull();
    });
});

describe('TimeValueSynthesizer Get/Set', function () {
    test('gets property value', function () {
        $object = (object) ['time' => TimeValue::make('14:30')];

        $result = $this->synthesizer->get($object, 'time');

        expect($result)->toBeInstanceOf(TimeValue::class);
        expect($result->hour)->toBe(14);
        expect($result->minute)->toBe(30);
    });

    test('gets null for non-existent property', function () {
        $object = (object) [];

        $result = $this->synthesizer->get($object, 'time');

        expect($result)->toBeNull();
    });

    test('sets property value', function () {
        $object = (object) [];
        $time = TimeValue::make('14:30');

        $this->synthesizer->set($object, 'time', $time);

        expect($object->time)->toBe($time);
    });
});
