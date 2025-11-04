<?php

namespace Stratos\StrataUI\Enums;

enum DateRangePreset: string
{
    case Today = 'today';
    case Yesterday = 'yesterday';
    case ThisWeek = 'this-week';
    case LastWeek = 'last-week';
    case Last7Days = 'last-7-days';
    case Last30Days = 'last-30-days';
    case ThisMonth = 'this-month';
    case LastMonth = 'last-month';
    case ThisQuarter = 'this-quarter';
    case LastQuarter = 'last-quarter';
    case ThisYear = 'this-year';
    case LastYear = 'last-year';
    case YearToDate = 'year-to-date';
    case AllTime = 'all-time';

    public function label(): string
    {
        return match ($this) {
            self::Today => 'Today',
            self::Yesterday => 'Yesterday',
            self::ThisWeek => 'This Week',
            self::LastWeek => 'Last Week',
            self::Last7Days => 'Last 7 Days',
            self::Last30Days => 'Last 30 Days',
            self::ThisMonth => 'This Month',
            self::LastMonth => 'Last Month',
            self::ThisQuarter => 'This Quarter',
            self::LastQuarter => 'Last Quarter',
            self::ThisYear => 'This Year',
            self::LastYear => 'Last Year',
            self::YearToDate => 'Year to Date',
            self::AllTime => 'All Time',
        };
    }

    public static function fromString(string $preset): ?self
    {
        return self::tryFrom($preset);
    }

    public static function default(): self
    {
        return self::Last7Days;
    }
}
