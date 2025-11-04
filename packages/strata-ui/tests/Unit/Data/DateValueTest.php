<?php

use Carbon\Carbon;
use Stratos\StrataUI\Data\DateValue;

beforeEach(function () {
    Carbon::setTestNow('2024-11-04 12:00:00');
});

afterEach(function () {
    Carbon::setTestNow();
});

describe('DateValue Factory Methods', function () {
    test('creates from string', function () {
        $date = DateValue::make('2024-11-04');

        expect($date->toDateString())->toBe('2024-11-04');
    });

    test('creates from Carbon instance', function () {
        $carbon = Carbon::parse('2024-11-04');
        $date = DateValue::make($carbon);

        expect($date->toDateString())->toBe('2024-11-04');
    });

    test('creates today', function () {
        $date = DateValue::today();

        expect($date->toDateString())->toBe('2024-11-04');
        expect($date->isToday())->toBeTrue();
    });

    test('creates tomorrow', function () {
        $date = DateValue::tomorrow();

        expect($date->toDateString())->toBe('2024-11-05');
    });

    test('creates yesterday', function () {
        $date = DateValue::yesterday();

        expect($date->toDateString())->toBe('2024-11-03');
    });
});

describe('DateValue Formatting', function () {
    test('formats with default format', function () {
        $date = DateValue::make('2024-11-04');

        expect($date->format())->toBe('2024-11-04');
    });

    test('formats with custom format', function () {
        $date = DateValue::make('2024-11-04');

        expect($date->format('d/m/Y'))->toBe('04/11/2024');
        expect($date->format('F j, Y'))->toBe('November 4, 2024');
    });

    test('converts to date string', function () {
        $date = DateValue::make('2024-11-04');

        expect($date->toDateString())->toBe('2024-11-04');
    });

    test('converts to string', function () {
        $date = DateValue::make('2024-11-04');

        expect((string) $date)->toBe('2024-11-04');
    });
});

describe('DateValue Comparison Methods', function () {
    test('checks if date is today', function () {
        expect(DateValue::today()->isToday())->toBeTrue();
        expect(DateValue::yesterday()->isToday())->toBeFalse();
        expect(DateValue::tomorrow()->isToday())->toBeFalse();
    });

    test('checks if date is in future', function () {
        expect(DateValue::tomorrow()->isFuture())->toBeTrue();
        expect(DateValue::today()->isFuture())->toBeFalse();
        expect(DateValue::yesterday()->isFuture())->toBeFalse();
    });

    test('checks if date is in past', function () {
        expect(DateValue::yesterday()->isPast())->toBeTrue();
        expect(DateValue::tomorrow()->isPast())->toBeFalse();
    });

    test('checks if date is weekend', function () {
        $saturday = DateValue::make('2024-11-02');
        $sunday = DateValue::make('2024-11-03');
        $monday = DateValue::make('2024-11-04');

        expect($saturday->isWeekend())->toBeTrue();
        expect($sunday->isWeekend())->toBeTrue();
        expect($monday->isWeekend())->toBeFalse();
    });

    test('checks if date is weekday', function () {
        $saturday = DateValue::make('2024-11-02');
        $monday = DateValue::make('2024-11-04');

        expect($saturday->isWeekday())->toBeFalse();
        expect($monday->isWeekday())->toBeTrue();
    });
});

describe('DateValue Date Math', function () {
    test('calculates diff in days', function () {
        $date1 = DateValue::make('2024-11-04');
        $date2 = DateValue::make('2024-11-10');

        expect($date1->diffInDays($date2))->toBe(6);
    });

    test('calculates diff with DateValue instance', function () {
        $date1 = DateValue::make('2024-11-04');
        $date2 = DateValue::make('2024-11-10');

        expect($date1->diffInDays($date2))->toBe(6);
    });

    test('calculates diff with Carbon instance', function () {
        $date = DateValue::make('2024-11-04');
        $carbon = Carbon::parse('2024-11-10');

        expect($date->diffInDays($carbon))->toBe(6);
    });

    test('adds days', function () {
        $date = DateValue::make('2024-11-04');
        $newDate = $date->addDays(5);

        expect($newDate->toDateString())->toBe('2024-11-09');
        expect($date->toDateString())->toBe('2024-11-04');
    });

    test('subtracts days', function () {
        $date = DateValue::make('2024-11-04');
        $newDate = $date->subDays(3);

        expect($newDate->toDateString())->toBe('2024-11-01');
        expect($date->toDateString())->toBe('2024-11-04');
    });
});

describe('DateValue Serialization', function () {
    test('converts to array', function () {
        $date = DateValue::make('2024-11-04');
        $array = $date->toArray();

        expect($array)->toHaveKey('date');
        expect($array)->toHaveKey('formatted');
        expect($array)->toHaveKey('timestamp');
        expect($array['date'])->toBe('2024-11-04');
    });

    test('creates from array', function () {
        $array = ['date' => '2024-11-04'];
        $date = DateValue::fromArray($array);

        expect($date->toDateString())->toBe('2024-11-04');
    });

    test('creates from array with formatted key', function () {
        $array = ['formatted' => '2024-11-04'];
        $date = DateValue::fromArray($array);

        expect($date->toDateString())->toBe('2024-11-04');
    });
});

describe('DateValue Livewire Integration', function () {
    test('converts to Livewire format', function () {
        $date = DateValue::make('2024-11-04');

        expect($date->toLivewire())->toBe('2024-11-04');
    });

    test('creates from Livewire value as string', function () {
        $date = DateValue::fromLivewire('2024-11-04');

        expect($date->toDateString())->toBe('2024-11-04');
    });

    test('creates from Livewire value as DateValue instance', function () {
        $original = DateValue::make('2024-11-04');
        $date = DateValue::fromLivewire($original);

        expect($date->toDateString())->toBe('2024-11-04');
    });
});

describe('DateValue Carbon Integration', function () {
    test('converts to Carbon instance', function () {
        $date = DateValue::make('2024-11-04');
        $carbon = $date->toCarbon();

        expect($carbon)->toBeInstanceOf(Carbon::class);
        expect($carbon->toDateString())->toBe('2024-11-04');
    });
});
