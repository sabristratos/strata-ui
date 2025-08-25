<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Table;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Vertical extends Component
{
    public function __construct(
        public bool $striped = false,
        public string $size = 'md'
    ) {
    }

    public function render(): View
    {
        return view('strata::components.table.vertical');
    }
}