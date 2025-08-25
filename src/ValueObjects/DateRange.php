<?php

declare(strict_types=1);

namespace Strata\UI\ValueObjects;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class DateRange implements Arrayable
{
    public function __construct(
        public Carbon $start,
        public Carbon $end
    ) {}

    public static function fromArray(array $data): self
    {
        if (!isset($data['start']) || !isset($data['end'])) {
            throw new \InvalidArgumentException('DateRange array must contain both "start" and "end" keys');
        }
        
        return new self(
            Carbon::parse($data['start']),
            Carbon::parse($data['end'])
        );
    }

    public function toArray(): array
    {
        return [
            'start' => $this->start->toDateString(),
            'end' => $this->end->toDateString(),
        ];
    }
}