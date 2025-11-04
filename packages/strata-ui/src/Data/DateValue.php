<?php

namespace Stratos\StrataUI\Data;

use Carbon\Carbon;
use Livewire\Wireable;

class DateValue implements Wireable
{
    public function __construct(
        public readonly Carbon $date
    ) {}

    public static function make(Carbon|string $date): self
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return new self($date);
    }

    public static function today(): self
    {
        return new self(Carbon::today());
    }

    public static function tomorrow(): self
    {
        return new self(Carbon::tomorrow());
    }

    public static function yesterday(): self
    {
        return new self(Carbon::yesterday());
    }

    public function toCarbon(): Carbon
    {
        return $this->date;
    }

    public function format(string $format = 'Y-m-d'): string
    {
        return $this->date->format($format);
    }

    public function toDateString(): string
    {
        return $this->date->toDateString();
    }

    public function isToday(): bool
    {
        return $this->date->isToday();
    }

    public function isFuture(): bool
    {
        return $this->date->isFuture();
    }

    public function isPast(): bool
    {
        return $this->date->isPast();
    }

    public function isWeekend(): bool
    {
        return $this->date->isWeekend();
    }

    public function isWeekday(): bool
    {
        return $this->date->isWeekday();
    }

    public function diffInDays(DateValue|Carbon|string $date = null): int
    {
        $date = match (true) {
            $date instanceof DateValue => $date->date,
            $date instanceof Carbon => $date,
            is_string($date) => Carbon::parse($date),
            default => Carbon::now(),
        };

        return $this->date->diffInDays($date);
    }

    public function addDays(int $days): self
    {
        return new self($this->date->copy()->addDays($days));
    }

    public function subDays(int $days): self
    {
        return new self($this->date->copy()->subDays($days));
    }

    public function toArray(): array
    {
        return [
            'date' => $this->toDateString(),
            'formatted' => $this->format(),
            'timestamp' => $this->date->timestamp,
        ];
    }

    public static function fromArray(array $data): self
    {
        return self::make($data['date'] ?? $data['formatted'] ?? now());
    }

    public function toLivewire(): string
    {
        return $this->toDateString();
    }

    public static function fromLivewire($value): self
    {
        if ($value instanceof self) {
            return $value;
        }

        return self::make($value);
    }

    public function __toString(): string
    {
        return $this->toDateString();
    }
}
