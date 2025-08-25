<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Popover extends Component
{
    public function __construct(
        public string $position = 'bottom-start',
        public int $offset = 8,
        public string $width = 'w-56'
    ) {
    }

    public function render(): View
    {
        return view('strata::components.popover');
    }
}