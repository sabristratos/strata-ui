<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Table;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cell extends Component
{
    public function __construct(
        public bool $header = false,
        public bool $sortable = false,
        public string $sortDirection = 'none',
        public string $align = 'left'
    ) {
    }

    public function render(): View
    {
        return view('strata::components.table.cell');
    }
}