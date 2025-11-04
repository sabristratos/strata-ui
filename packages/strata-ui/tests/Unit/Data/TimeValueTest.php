<?php

use Carbon\Carbon;
use Stratos\StrataUI\Data\TimeValue;

beforeEach(function () {
    Carbon::setTestNow('2024-11-04 14:30:45');
});

afterEach(function () {
    Carbon::setTestNow();
});

describe('TimeValue Factory Methods', function () {
    test('creates from 24-hour format without seconds', function () {
        $time = TimeValue::make('14:30');

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(0);
        expect($time->meridiem)->toBeNull();
    });

    test('creates from 24-hour format with seconds', function () {
        $time = TimeValue::make('14:30:45');

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
        expect($time->meridiem)->toBeNull();
    });

    test('creates from 12-hour format without seconds', function () {
        $time = TimeValue::make('2:30 PM');

        expect($time->hour)->toBe(2);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(0);
        expect($time->meridiem)->toBe('PM');
    });

    test('creates from 12-hour format with seconds', function () {
        $time = TimeValue::make('2:30:45 PM');

        expect($time->hour)->toBe(2);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
        expect($time->meridiem)->toBe('PM');
    });

    test('creates from lowercase meridiem', function () {
        $time = TimeValue::make('2:30 pm');

        expect($time->meridiem)->toBe('PM');
    });

    test('creates now', function () {
        $time = TimeValue::now();

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
        expect($time->meridiem)->toBeNull();
    });

    test('creates from 24-hour components', function () {
        $time = TimeValue::from24Hour(14, 30, 45);

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
        expect($time->meridiem)->toBeNull();
    });

    test('creates from 12-hour components', function () {
        $time = TimeValue::from12Hour(2, 30, 'PM', 45);

        expect($time->hour)->toBe(2);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
        expect($time->meridiem)->toBe('PM');
    });

    test('throws exception for invalid time format', function () {
        expect(fn () => TimeValue::make('invalid'))
            ->toThrow(InvalidArgumentException::class);
    });
});

describe('TimeValue Validation', function () {
    test('validates 24-hour format hour range', function () {
        expect(fn () => new TimeValue(24, 0))
            ->toThrow(InvalidArgumentException::class, 'Hour must be between 0 and 23');

        expect(fn () => new TimeValue(-1, 0))
            ->toThrow(InvalidArgumentException::class, 'Hour must be between 0 and 23');
    });

    test('validates 12-hour format hour range', function () {
        expect(fn () => new TimeValue(13, 0, 0, 'PM'))
            ->toThrow(InvalidArgumentException::class, 'Hour must be between 1 and 12');

        expect(fn () => new TimeValue(0, 0, 0, 'AM'))
            ->toThrow(InvalidArgumentException::class, 'Hour must be between 1 and 12');
    });

    test('validates minute range', function () {
        expect(fn () => new TimeValue(14, 60))
            ->toThrow(InvalidArgumentException::class, 'Minute must be between 0 and 59');

        expect(fn () => new TimeValue(14, -1))
            ->toThrow(InvalidArgumentException::class, 'Minute must be between 0 and 59');
    });

    test('validates second range', function () {
        expect(fn () => new TimeValue(14, 30, 60))
            ->toThrow(InvalidArgumentException::class, 'Second must be between 0 and 59');
    });

    test('validates meridiem values', function () {
        expect(fn () => new TimeValue(2, 30, 0, 'XM'))
            ->toThrow(InvalidArgumentException::class, 'Meridiem must be AM or PM');
    });
});

describe('TimeValue Format Conversion', function () {
    test('converts 12-hour AM to 24-hour', function () {
        $time = TimeValue::make('2:30 AM');

        expect($time->to24HourFormat())->toBe(2);
    });

    test('converts 12-hour PM to 24-hour', function () {
        $time = TimeValue::make('2:30 PM');

        expect($time->to24HourFormat())->toBe(14);
    });

    test('converts 12:00 AM to 24-hour (midnight)', function () {
        $time = TimeValue::make('12:00 AM');

        expect($time->to24HourFormat())->toBe(0);
    });

    test('converts 12:00 PM to 24-hour (noon)', function () {
        $time = TimeValue::make('12:00 PM');

        expect($time->to24HourFormat())->toBe(12);
    });

    test('converts 24-hour to 12-hour format', function () {
        $time = TimeValue::make('14:30');

        expect($time->to12HourFormat())->toBe('2:30 PM');
    });

    test('converts midnight to 12-hour format', function () {
        $time = TimeValue::make('00:30');

        expect($time->to12HourFormat())->toBe('12:30 AM');
    });

    test('converts noon to 12-hour format', function () {
        $time = TimeValue::make('12:30');

        expect($time->to12HourFormat())->toBe('12:30 PM');
    });

    test('includes seconds in 12-hour format when present', function () {
        $time = TimeValue::make('14:30:45');

        expect($time->to12HourFormat())->toBe('2:30:45 PM');
    });
});

describe('TimeValue String Output', function () {
    test('outputs 24-hour format without seconds', function () {
        $time = TimeValue::make('14:30');

        expect($time->toString())->toBe('14:30');
    });

    test('outputs 24-hour format with seconds', function () {
        $time = TimeValue::make('14:30:45');

        expect($time->toString(true, true))->toBe('14:30:45');
    });

    test('outputs 12-hour format', function () {
        $time = TimeValue::make('14:30');

        expect($time->toString(false))->toBe('2:30 PM');
    });

    test('preserves original format when stored as 12-hour', function () {
        $time = TimeValue::make('2:30 PM');

        expect($time->toString(false))->toBe('2:30 PM');
    });

    test('converts to string using __toString', function () {
        $time = TimeValue::make('14:30:45');

        expect((string) $time)->toBe('14:30:45');
    });
});

describe('TimeValue Format Checking', function () {
    test('checks if 24-hour format', function () {
        $time24 = TimeValue::make('14:30');
        $time12 = TimeValue::make('2:30 PM');

        expect($time24->is24Hour())->toBeTrue();
        expect($time12->is24Hour())->toBeFalse();
    });

    test('checks if 12-hour format', function () {
        $time24 = TimeValue::make('14:30');
        $time12 = TimeValue::make('2:30 PM');

        expect($time24->is12Hour())->toBeFalse();
        expect($time12->is12Hour())->toBeTrue();
    });
});

describe('TimeValue Seconds Conversion', function () {
    test('converts to total seconds', function () {
        $time = TimeValue::make('02:30:45');
        $expectedSeconds = (2 * 3600) + (30 * 60) + 45;

        expect($time->toSeconds())->toBe($expectedSeconds);
    });

    test('converts midnight to seconds', function () {
        $time = TimeValue::make('00:00:00');

        expect($time->toSeconds())->toBe(0);
    });

    test('converts 12-hour PM to seconds correctly', function () {
        $time = TimeValue::make('2:30 PM');
        $expectedSeconds = (14 * 3600) + (30 * 60);

        expect($time->toSeconds())->toBe($expectedSeconds);
    });
});

describe('TimeValue Comparison', function () {
    test('compares if before', function () {
        $time1 = TimeValue::make('10:00');
        $time2 = TimeValue::make('14:00');

        expect($time1->isBefore($time2))->toBeTrue();
        expect($time2->isBefore($time1))->toBeFalse();
    });

    test('compares if after', function () {
        $time1 = TimeValue::make('14:00');
        $time2 = TimeValue::make('10:00');

        expect($time1->isAfter($time2))->toBeTrue();
        expect($time2->isAfter($time1))->toBeFalse();
    });

    test('compares equality', function () {
        $time1 = TimeValue::make('14:30');
        $time2 = TimeValue::make('2:30 PM');
        $time3 = TimeValue::make('10:00');

        expect($time1->equals($time2))->toBeTrue();
        expect($time1->equals($time3))->toBeFalse();
    });
});

describe('TimeValue Carbon Integration', function () {
    test('converts to Carbon instance', function () {
        $time = TimeValue::make('14:30:45');
        $carbon = $time->toCarbon();

        expect($carbon)->toBeInstanceOf(Carbon::class);
        expect($carbon->hour)->toBe(14);
        expect($carbon->minute)->toBe(30);
        expect($carbon->second)->toBe(45);
    });

    test('converts to Carbon with specific date', function () {
        $time = TimeValue::make('14:30');
        $date = Carbon::parse('2024-11-04');
        $carbon = $time->toCarbon($date);

        expect($carbon->toDateTimeString())->toBe('2024-11-04 14:30:00');
    });

    test('formats using Carbon format', function () {
        $time = TimeValue::make('14:30:45');

        expect($time->format('H:i'))->toBe('14:30');
        expect($time->format('g:i A'))->toBe('2:30 PM');
        expect($time->format('H:i:s'))->toBe('14:30:45');
    });
});

describe('TimeValue Serialization', function () {
    test('converts to array', function () {
        $time = TimeValue::make('14:30:45');
        $array = $time->toArray();

        expect($array)->toHaveKey('hour');
        expect($array)->toHaveKey('minute');
        expect($array)->toHaveKey('second');
        expect($array)->toHaveKey('meridiem');
        expect($array)->toHaveKey('formatted');
        expect($array['hour'])->toBe(14);
        expect($array['minute'])->toBe(30);
        expect($array['second'])->toBe(45);
    });

    test('creates from array with components', function () {
        $array = [
            'hour' => 14,
            'minute' => 30,
            'second' => 45,
        ];
        $time = TimeValue::fromArray($array);

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
    });

    test('creates from array with formatted string', function () {
        $array = ['formatted' => '14:30:45'];
        $time = TimeValue::fromArray($array);

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
    });
});

describe('TimeValue Livewire Integration', function () {
    test('converts to Livewire format for 24-hour', function () {
        $time = TimeValue::make('14:30:45');

        expect($time->toLivewire())->toBe('14:30:45');
    });

    test('converts to Livewire format for 12-hour', function () {
        $time = TimeValue::make('2:30 PM');

        expect($time->toLivewire())->toBe('2:30 PM');
    });

    test('creates from Livewire value as string', function () {
        $time = TimeValue::fromLivewire('14:30:45');

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
    });

    test('creates from Livewire value as TimeValue instance', function () {
        $original = TimeValue::make('14:30');
        $time = TimeValue::fromLivewire($original);

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
    });

    test('creates from Livewire value as array', function () {
        $array = ['hour' => 14, 'minute' => 30, 'second' => 0];
        $time = TimeValue::fromLivewire($array);

        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
    });

    test('throws exception for invalid Livewire value', function () {
        expect(fn () => TimeValue::fromLivewire(123))
            ->toThrow(InvalidArgumentException::class);
    });
});
