<?php

namespace Stratos\StrataUI\Data;

use Carbon\Carbon;
use InvalidArgumentException;
use Livewire\Wireable;

class TimeValue implements Wireable
{
    public function __construct(
        public readonly int $hour,
        public readonly int $minute,
        public readonly int $second = 0,
        public readonly ?string $meridiem = null,
    ) {
        $this->validate();
    }

    protected function validate(): void
    {
        if ($this->meridiem !== null) {
            if ($this->hour < 1 || $this->hour > 12) {
                throw new InvalidArgumentException('Hour must be between 1 and 12 for 12-hour format.');
            }
            if (! in_array(strtoupper($this->meridiem), ['AM', 'PM'])) {
                throw new InvalidArgumentException('Meridiem must be AM or PM.');
            }
        } else {
            if ($this->hour < 0 || $this->hour > 23) {
                throw new InvalidArgumentException('Hour must be between 0 and 23 for 24-hour format.');
            }
        }

        if ($this->minute < 0 || $this->minute > 59) {
            throw new InvalidArgumentException('Minute must be between 0 and 59.');
        }

        if ($this->second < 0 || $this->second > 59) {
            throw new InvalidArgumentException('Second must be between 0 and 59.');
        }
    }

    public static function make(string $time): self
    {
        $time = trim($time);

        if (preg_match('/^(\d{1,2}):(\d{2})(?::(\d{2}))?\s*(AM|PM)$/i', $time, $matches)) {
            return new self(
                hour: (int) $matches[1],
                minute: (int) $matches[2],
                second: isset($matches[3]) ? (int) $matches[3] : 0,
                meridiem: strtoupper($matches[4])
            );
        }

        if (preg_match('/^(\d{1,2}):(\d{2})(?::(\d{2}))?$/', $time, $matches)) {
            return new self(
                hour: (int) $matches[1],
                minute: (int) $matches[2],
                second: isset($matches[3]) ? (int) $matches[3] : 0,
            );
        }

        throw new InvalidArgumentException("Invalid time format: {$time}");
    }

    public static function now(): self
    {
        $now = Carbon::now();

        return new self(
            hour: $now->hour,
            minute: $now->minute,
            second: $now->second,
        );
    }

    public static function from24Hour(int $hour, int $minute, int $second = 0): self
    {
        return new self($hour, $minute, $second);
    }

    public static function from12Hour(int $hour, int $minute, string $meridiem, int $second = 0): self
    {
        return new self($hour, $minute, $second, $meridiem);
    }

    public function toCarbon(?Carbon $date = null): Carbon
    {
        $date = $date ?? Carbon::today();
        $hour = $this->to24HourFormat();

        return $date->copy()->setTime($hour, $this->minute, $this->second);
    }

    public function format(string $format = 'H:i'): string
    {
        return $this->toCarbon()->format($format);
    }

    public function to12HourFormat(): string
    {
        if ($this->meridiem !== null) {
            $formatted = sprintf('%d:%02d', $this->hour, $this->minute);
            if ($this->second > 0) {
                $formatted .= sprintf(':%02d', $this->second);
            }

            return $formatted.' '.$this->meridiem;
        }

        $hour = $this->hour === 0 ? 12 : ($this->hour > 12 ? $this->hour - 12 : $this->hour);
        $meridiem = $this->hour < 12 ? 'AM' : 'PM';

        $formatted = sprintf('%d:%02d', $hour, $this->minute);
        if ($this->second > 0) {
            $formatted .= sprintf(':%02d', $this->second);
        }

        return $formatted.' '.$meridiem;
    }

    public function to24HourFormat(): string|int
    {
        if ($this->meridiem !== null) {
            $hour = $this->hour;
            if (strtoupper($this->meridiem) === 'PM' && $hour !== 12) {
                $hour += 12;
            } elseif (strtoupper($this->meridiem) === 'AM' && $hour === 12) {
                $hour = 0;
            }

            return $hour;
        }

        return $this->hour;
    }

    public function toString(bool $use24Hour = true, bool $includeSeconds = false): string
    {
        if ($use24Hour) {
            $hour = is_int($this->to24HourFormat()) ? $this->to24HourFormat() : (int) $this->to24HourFormat();
            $formatted = sprintf('%02d:%02d', $hour, $this->minute);
            if ($includeSeconds) {
                $formatted .= sprintf(':%02d', $this->second);
            }

            return $formatted;
        }

        return $this->to12HourFormat();
    }

    public function is24Hour(): bool
    {
        return $this->meridiem === null;
    }

    public function is12Hour(): bool
    {
        return $this->meridiem !== null;
    }

    public function toSeconds(): int
    {
        $hour = is_int($this->to24HourFormat()) ? $this->to24HourFormat() : (int) $this->to24HourFormat();

        return ($hour * 3600) + ($this->minute * 60) + $this->second;
    }

    public function isBefore(TimeValue $other): bool
    {
        return $this->toSeconds() < $other->toSeconds();
    }

    public function isAfter(TimeValue $other): bool
    {
        return $this->toSeconds() > $other->toSeconds();
    }

    public function equals(TimeValue $other): bool
    {
        return $this->toSeconds() === $other->toSeconds();
    }

    public function toArray(): array
    {
        return [
            'hour' => $this->hour,
            'minute' => $this->minute,
            'second' => $this->second,
            'meridiem' => $this->meridiem,
            'formatted' => $this->toString(),
        ];
    }

    public static function fromArray(array $data): self
    {
        if (isset($data['formatted'])) {
            return self::make($data['formatted']);
        }

        return new self(
            hour: $data['hour'],
            minute: $data['minute'],
            second: $data['second'] ?? 0,
            meridiem: $data['meridiem'] ?? null,
        );
    }

    public function toLivewire(): string
    {
        return $this->toString(true, $this->second > 0);
    }

    public static function fromLivewire($value): self
    {
        if ($value instanceof self) {
            return $value;
        }

        if (is_string($value)) {
            return self::make($value);
        }

        if (is_array($value)) {
            return self::fromArray($value);
        }

        throw new InvalidArgumentException('Invalid value for TimeValue');
    }

    public function __toString(): string
    {
        return $this->toString($this->is24Hour(), $this->second > 0);
    }
}
