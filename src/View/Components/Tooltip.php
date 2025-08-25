<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tooltip extends Component
{
    public function __construct(
        public string $text,
        public string $position = 'top',
        public int $offset = 8
    ) {
    }

    public function render(): View
    {
        return view('strata::components.tooltip');
    }
}