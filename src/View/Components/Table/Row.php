<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Table;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Row extends Component
{
    public function __construct(
        public bool $selected = false,
        public bool $clickable = false
    ) {
    }

    public function render(): View
    {
        return view('strata::components.table.row');
    }
}