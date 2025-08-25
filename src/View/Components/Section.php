<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Section extends Component
{
    public function __construct(
        public string $width = 'standard',
        public string $padding = 'md',
    ) {}

    public function render(): View
    {
        return view('strata::components.section');
    }

    public function getContainerClasses(): string
    {
        return match ($this->width) {
            'full' => 'w-full',
            'wide' => 'max-w-[var(--container-width-wide)]',
            'narrow' => 'max-w-[var(--container-width-narrow)]',
            'compact' => 'max-w-[var(--container-width-compact)]',
            default => 'max-w-[var(--container-width-standard)]',
        };
    }

    public function getPaddingClasses(): string
    {
        return match ($this->padding) {
            'none' => '',
            'sm' => 'py-4 px-6',
            'lg' => 'py-12 px-6',
            'xl' => 'py-16 px-6',
            default => 'py-8 px-6',
        };
    }
}