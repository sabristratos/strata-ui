<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public string $position = 'bottom-end',
        public string $width = 'w-56'
    ) {
    }

    public function render(): View
    {
        return view('strata::components.dropdown');
    }
}