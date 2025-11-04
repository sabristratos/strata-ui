<?php

namespace Stratos\StrataUI\Data;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Wireable;
use Stratos\StrataUI\Enums\DateRangePreset;

class DateRange extends CarbonPeriod implements Wireable
{
    protected ?DateRangePreset $rangePreset = null;

    public static function between(Carbon|string $start, Carbon|string $end, ?DateRangePreset $preset = null): self
    {
        $startDate = is_string($start) ? Carbon::parse($start) : $start;
        $endDate = is_string($end) ? Carbon::parse($end) : $end;

        $instance = new self($startDate, $endDate);
        $instance->rangePreset = $preset;

        return $instance;
    }

    public static function today(): self
    {
        $today = Carbon::today();

        return self::between($today, $today, DateRangePreset::Today);
    }

    public static function yesterday(): self
    {
        $yesterday = Carbon::yesterday();

        return self::between($yesterday, $yesterday, DateRangePreset::Yesterday);
    }

    public static function thisWeek(): self
    {
        return self::between(
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
            DateRangePreset::ThisWeek
        );
    }

    public static function lastWeek(): self
    {
        return self::between(
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek(),
            DateRangePreset::LastWeek
        );
    }

    public static function last7Days(): self
    {
        return self::between(
            Carbon::now()->subDays(6),
            Carbon::now(),
            DateRangePreset::Last7Days
        );
    }

    public static function last30Days(): self
    {
        return self::between(
            Carbon::now()->subDays(29),
            Carbon::now(),
            DateRangePreset::Last30Days
        );
    }

    public static function thisMonth(): self
    {
        return self::between(
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
            DateRangePreset::ThisMonth
        );
    }

    public static function lastMonth(): self
    {
        return self::between(
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth(),
            DateRangePreset::LastMonth
        );
    }

    public static function thisQuarter(): self
    {
        return self::between(
            Carbon::now()->startOfQuarter(),
            Carbon::now()->endOfQuarter(),
            DateRangePreset::ThisQuarter
        );
    }

    public static function lastQuarter(): self
    {
        return self::between(
            Carbon::now()->subQuarter()->startOfQuarter(),
            Carbon::now()->subQuarter()->endOfQuarter(),
            DateRangePreset::LastQuarter
        );
    }

    public static function thisYear(): self
    {
        return self::between(
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
            DateRangePreset::ThisYear
        );
    }

    public static function lastYear(): self
    {
        return self::between(
            Carbon::now()->subYear()->startOfYear(),
            Carbon::now()->subYear()->endOfYear(),
            DateRangePreset::LastYear
        );
    }

    public static function yearToDate(): self
    {
        return self::between(
            Carbon::now()->startOfYear(),
            Carbon::now(),
            DateRangePreset::YearToDate
        );
    }

    public static function allTime(): self
    {
        return self::between(
            Carbon::parse('1970-01-01'),
            Carbon::parse('2099-12-31'),
            DateRangePreset::AllTime
        );
    }

    public function preset(): ?DateRangePreset
    {
        return $this->rangePreset;
    }

    public function hasPreset(): bool
    {
        return $this->rangePreset !== null;
    }

    public function toArray(): array
    {
        return [
            'start' => $this->getStartDate()->toDateString(),
            'end' => $this->getEndDate()->toDateString(),
            'preset' => $this->rangePreset?->value,
        ];
    }

    public static function fromArray(array $data): self
    {
        $preset = isset($data['preset'])
            ? DateRangePreset::fromString($data['preset'])
            : null;

        return self::between(
            $data['start'] ?? now(),
            $data['end'] ?? now(),
            $preset
        );
    }

    public static function fromPreset(DateRangePreset $preset): self
    {
        return match ($preset) {
            DateRangePreset::Today => self::today(),
            DateRangePreset::Yesterday => self::yesterday(),
            DateRangePreset::ThisWeek => self::thisWeek(),
            DateRangePreset::LastWeek => self::lastWeek(),
            DateRangePreset::Last7Days => self::last7Days(),
            DateRangePreset::Last30Days => self::last30Days(),
            DateRangePreset::ThisMonth => self::thisMonth(),
            DateRangePreset::LastMonth => self::lastMonth(),
            DateRangePreset::ThisQuarter => self::thisQuarter(),
            DateRangePreset::LastQuarter => self::lastQuarter(),
            DateRangePreset::ThisYear => self::thisYear(),
            DateRangePreset::LastYear => self::lastYear(),
            DateRangePreset::YearToDate => self::yearToDate(),
            DateRangePreset::AllTime => self::allTime(),
        };
    }

    public function toLivewire(): array
    {
        return $this->toArray();
    }

    public static function fromLivewire($value): self
    {
        if ($value instanceof self) {
            return $value;
        }

        if (is_array($value)) {
            return self::fromArray($value);
        }

        return self::last7Days();
    }
}
