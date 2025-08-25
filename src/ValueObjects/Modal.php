<?php

declare(strict_types=1);

namespace Strata\UI\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class Modal implements Arrayable
{
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $content = null,
        public string $size = 'md',
        public string $variant = 'default',
        public bool $closable = true,
        public bool $backdrop = true,
        public ?array $actions = null,
    ) {
        $this->id = $this->id ?? uniqid('modal_');
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'size' => $this->size,
            'variant' => $this->variant,
            'closable' => $this->closable,
            'backdrop' => $this->backdrop,
            'actions' => $this->actions,
        ];
    }
}