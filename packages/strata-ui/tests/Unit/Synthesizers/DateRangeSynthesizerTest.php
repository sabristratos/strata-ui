<?php

use Carbon\Carbon;
use Stratos\StrataUI\Data\DateRange;
use Stratos\StrataUI\Enums\DateRangePreset;
use Stratos\StrataUI\Synthesizers\DateRangeSynthesizer;

beforeEach(function () {
    Carbon::setTestNow('2024-11-04 12:00:00');
    $this->synthesizer = new DateRangeSynthesizer();
});

afterEach(function () {
    Carbon::setTestNow();
});

describe('DateRangeSynthesizer Match', function () {
    test('matches DateRange instances', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');

        expect(DateRangeSynthesizer::match($range))->toBeTrue();
    });

    test('does not match non-DateRange types', function () {
        expect(DateRangeSynthesizer::match(['2024-11-01', '2024-11-10']))->toBeFalse();
        expect(DateRangeSynthesizer::match(null))->toBeFalse();
        expect(DateRangeSynthesizer::match('2024-11-01'))->toBeFalse();
    });
});

describe('DateRangeSynthesizer Dehydrate', function () {
    test('dehydrates DateRange to array', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');
        [$value, $meta] = $this->synthesizer->dehydrate($range);

        expect($value)->toBeArray();
        expect($value)->toHaveKey('start');
        expect($value)->toHaveKey('end');
        expect($value)->toHaveKey('preset');
        expect($value['start'])->toBe('2024-11-01');
        expect($value['end'])->toBe('2024-11-10');
        expect($meta)->toBe([]);
    });

    test('dehydrates DateRange with preset', function () {
        $range = DateRange::last7Days();
        [$value, $meta] = $this->synthesizer->dehydrate($range);

        expect($value['preset'])->toBe('last-7-days');
    });
});

describe('DateRangeSynthesizer Hydrate', function () {
    test('hydrates array to DateRange', function () {
        $data = [
            'start' => '2024-11-01',
            'end' => '2024-11-10',
        ];

        $result = $this->synthesizer->hydrate($data);

        expect($result)->toBeInstanceOf(DateRange::class);
        expect($result->getStartDate()->toDateString())->toBe('2024-11-01');
        expect($result->getEndDate()->toDateString())->toBe('2024-11-10');
    });

    test('hydrates array with preset to DateRange', function () {
        $data = [
            'start' => '2024-10-29',
            'end' => '2024-11-04',
            'preset' => 'last-7-days',
        ];

        $result = $this->synthesizer->hydrate($data);

        expect($result)->toBeInstanceOf(DateRange::class);
        expect($result->preset())->toBe(DateRangePreset::Last7Days);
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

    test('hydrates non-array to null', function () {
        expect($this->synthesizer->hydrate('2024-11-01'))->toBeNull();
    });
});

describe('DateRangeSynthesizer Get/Set', function () {
    test('gets property value', function () {
        $object = (object) ['range' => DateRange::last7Days()];

        $result = $this->synthesizer->get($object, 'range');

        expect($result)->toBeInstanceOf(DateRange::class);
    });

    test('gets null for non-existent property', function () {
        $object = (object) [];

        $result = $this->synthesizer->get($object, 'range');

        expect($result)->toBeNull();
    });

    test('sets property value', function () {
        $object = (object) [];
        $range = DateRange::last7Days();

        $this->synthesizer->set($object, 'range', $range);

        expect($object->range)->toBe($range);
    });
});
