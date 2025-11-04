<?php

use Carbon\Carbon;
use Stratos\StrataUI\Data\DateRange;
use Stratos\StrataUI\Enums\DateRangePreset;

beforeEach(function () {
    Carbon::setTestNow('2024-11-04 12:00:00');
});

afterEach(function () {
    Carbon::setTestNow();
});

describe('DateRange Factory Methods', function () {
    test('creates from strings', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');

        expect($range->getStartDate()->toDateString())->toBe('2024-11-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-10');
    });

    test('creates from Carbon instances', function () {
        $start = Carbon::parse('2024-11-01');
        $end = Carbon::parse('2024-11-10');
        $range = DateRange::between($start, $end);

        expect($range->getStartDate()->toDateString())->toBe('2024-11-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-10');
    });

    test('creates with preset', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10', DateRangePreset::Last7Days);

        expect($range->preset())->toBe(DateRangePreset::Last7Days);
    });
});

describe('DateRange Preset Methods', function () {
    test('creates today range', function () {
        $range = DateRange::today();

        expect($range->getStartDate()->toDateString())->toBe('2024-11-04');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-04');
        expect($range->preset())->toBe(DateRangePreset::Today);
    });

    test('creates yesterday range', function () {
        $range = DateRange::yesterday();

        expect($range->getStartDate()->toDateString())->toBe('2024-11-03');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-03');
        expect($range->preset())->toBe(DateRangePreset::Yesterday);
    });

    test('creates this week range', function () {
        $range = DateRange::thisWeek();

        expect($range->getStartDate()->dayOfWeek)->toBe(Carbon::SUNDAY);
        expect($range->getEndDate()->dayOfWeek)->toBe(Carbon::SATURDAY);
        expect($range->preset())->toBe(DateRangePreset::ThisWeek);
    });

    test('creates last week range', function () {
        $range = DateRange::lastWeek();

        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();

        expect($range->getStartDate()->toDateString())->toBe($lastWeekStart->toDateString());
        expect($range->getEndDate()->toDateString())->toBe($lastWeekEnd->toDateString());
        expect($range->preset())->toBe(DateRangePreset::LastWeek);
    });

    test('creates last 7 days range', function () {
        $range = DateRange::last7Days();

        expect($range->getStartDate()->toDateString())->toBe('2024-10-29');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-04');
        expect($range->count())->toBe(7);
        expect($range->preset())->toBe(DateRangePreset::Last7Days);
    });

    test('creates last 30 days range', function () {
        $range = DateRange::last30Days();

        expect($range->getStartDate()->toDateString())->toBe('2024-10-06');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-04');
        expect($range->count())->toBe(30);
        expect($range->preset())->toBe(DateRangePreset::Last30Days);
    });

    test('creates this month range', function () {
        $range = DateRange::thisMonth();

        expect($range->getStartDate()->toDateString())->toBe('2024-11-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-30');
        expect($range->preset())->toBe(DateRangePreset::ThisMonth);
    });

    test('creates last month range', function () {
        $range = DateRange::lastMonth();

        expect($range->getStartDate()->toDateString())->toBe('2024-10-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-10-31');
        expect($range->preset())->toBe(DateRangePreset::LastMonth);
    });

    test('creates this quarter range', function () {
        $range = DateRange::thisQuarter();

        expect($range->getStartDate()->toDateString())->toBe('2024-10-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-12-31');
        expect($range->preset())->toBe(DateRangePreset::ThisQuarter);
    });

    test('creates last quarter range', function () {
        $range = DateRange::lastQuarter();

        expect($range->getStartDate()->toDateString())->toBe('2024-07-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-09-30');
        expect($range->preset())->toBe(DateRangePreset::LastQuarter);
    });

    test('creates this year range', function () {
        $range = DateRange::thisYear();

        expect($range->getStartDate()->toDateString())->toBe('2024-01-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-12-31');
        expect($range->preset())->toBe(DateRangePreset::ThisYear);
    });

    test('creates last year range', function () {
        $range = DateRange::lastYear();

        expect($range->getStartDate()->toDateString())->toBe('2023-01-01');
        expect($range->getEndDate()->toDateString())->toBe('2023-12-31');
        expect($range->preset())->toBe(DateRangePreset::LastYear);
    });

    test('creates year to date range', function () {
        $range = DateRange::yearToDate();

        expect($range->getStartDate()->toDateString())->toBe('2024-01-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-04');
        expect($range->preset())->toBe(DateRangePreset::YearToDate);
    });

    test('creates all time range', function () {
        $range = DateRange::allTime();

        expect($range->getStartDate()->toDateString())->toBe('1970-01-01');
        expect($range->getEndDate()->toDateString())->toBe('2099-12-31');
        expect($range->preset())->toBe(DateRangePreset::AllTime);
    });

    test('creates from preset enum', function () {
        $range = DateRange::fromPreset(DateRangePreset::Last7Days);

        expect($range->preset())->toBe(DateRangePreset::Last7Days);
        expect($range->count())->toBe(7);
    });
});

describe('DateRange Methods', function () {
    test('gets start date', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');

        expect($range->getStartDate())->toBeInstanceOf(Carbon::class);
        expect($range->getStartDate()->toDateString())->toBe('2024-11-01');
    });

    test('gets end date', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');

        expect($range->getEndDate())->toBeInstanceOf(Carbon::class);
        expect($range->getEndDate()->toDateString())->toBe('2024-11-10');
    });

    test('calculates days in range', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');

        expect($range->count())->toBe(10);
    });

    test('checks if contains date as string', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');

        expect($range->contains('2024-11-05'))->toBeTrue();
        expect($range->contains('2024-10-31'))->toBeFalse();
        expect($range->contains('2024-11-11'))->toBeFalse();
    });

    test('checks if contains date as Carbon', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');

        expect($range->contains(Carbon::parse('2024-11-05')))->toBeTrue();
        expect($range->contains(Carbon::parse('2024-10-31')))->toBeFalse();
    });

    test('checks if has preset', function () {
        $rangeWithPreset = DateRange::last7Days();
        $rangeWithoutPreset = DateRange::between('2024-11-01', '2024-11-10');

        expect($rangeWithPreset->hasPreset())->toBeTrue();
        expect($rangeWithoutPreset->hasPreset())->toBeFalse();
    });
});

describe('DateRange Serialization', function () {
    test('converts to array without preset', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');
        $array = $range->toArray();

        expect($array)->toHaveKey('start');
        expect($array)->toHaveKey('end');
        expect($array)->toHaveKey('preset');
        expect($array['start'])->toBe('2024-11-01');
        expect($array['end'])->toBe('2024-11-10');
        expect($array['preset'])->toBeNull();
    });

    test('converts to array with preset', function () {
        $range = DateRange::last7Days();
        $array = $range->toArray();

        expect($array['preset'])->toBe('last-7-days');
    });

    test('creates from array without preset', function () {
        $array = [
            'start' => '2024-11-01',
            'end' => '2024-11-10',
        ];
        $range = DateRange::fromArray($array);

        expect($range->getStartDate()->toDateString())->toBe('2024-11-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-10');
        expect($range->preset())->toBeNull();
    });

    test('creates from array with preset', function () {
        $array = [
            'start' => '2024-11-01',
            'end' => '2024-11-10',
            'preset' => 'last-7-days',
        ];
        $range = DateRange::fromArray($array);

        expect($range->preset())->toBe(DateRangePreset::Last7Days);
    });
});

describe('DateRange Livewire Integration', function () {
    test('converts to Livewire format', function () {
        $range = DateRange::between('2024-11-01', '2024-11-10');
        $livewireValue = $range->toLivewire();

        expect($livewireValue)->toBeArray();
        expect($livewireValue['start'])->toBe('2024-11-01');
        expect($livewireValue['end'])->toBe('2024-11-10');
    });

    test('creates from Livewire value as array', function () {
        $livewireValue = [
            'start' => '2024-11-01',
            'end' => '2024-11-10',
        ];
        $range = DateRange::fromLivewire($livewireValue);

        expect($range->getStartDate()->toDateString())->toBe('2024-11-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-10');
    });

    test('creates from Livewire value as DateRange instance', function () {
        $original = DateRange::between('2024-11-01', '2024-11-10');
        $range = DateRange::fromLivewire($original);

        expect($range->getStartDate()->toDateString())->toBe('2024-11-01');
        expect($range->getEndDate()->toDateString())->toBe('2024-11-10');
    });

    test('creates default range from invalid Livewire value', function () {
        $range = DateRange::fromLivewire(null);

        expect($range->preset())->toBe(DateRangePreset::Last7Days);
    });
});

describe('DateRange CarbonPeriod Integration', function () {
    test('extends CarbonPeriod', function () {
        $range = DateRange::between('2024-11-01', '2024-11-05');

        expect($range)->toBeInstanceOf(\Carbon\CarbonPeriod::class);
    });

    test('can iterate over dates', function () {
        $range = DateRange::between('2024-11-01', '2024-11-05');
        $dates = [];

        foreach ($range as $date) {
            $dates[] = $date->toDateString();
        }

        expect($dates)->toBe([
            '2024-11-01',
            '2024-11-02',
            '2024-11-03',
            '2024-11-04',
            '2024-11-05',
        ]);
    });

    test('converts to array of Carbon instances', function () {
        $range = DateRange::between('2024-11-01', '2024-11-03');
        $array = iterator_to_array($range);

        expect($array)->toHaveCount(3);
        expect($array[0])->toBeInstanceOf(Carbon::class);
    });
});
