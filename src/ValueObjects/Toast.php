<?php

declare(strict_types=1);

namespace Strata\UI\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class Toast implements Arrayable
{
    public function __construct(
        public ?string $message = null,
        public ?string $title = null,
        public string $variant = 'info',
        public int $duration = 5000,
        public ?string $icon = null,
        public ?array $actions = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'title' => $this->title,
            'variant' => $this->variant,
            'duration' => $this->duration,
            'icon' => $this->icon,
            'actions' => $this->actions,
        ];
    }
}