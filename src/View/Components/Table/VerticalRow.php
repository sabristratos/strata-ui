<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Table;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VerticalRow extends Component
{
    public function __construct(
        public string $label = '',
        public bool $labelBold = true
    ) {
    }

    public function render(): View
    {
        return view('strata::components.table.vertical-row');
    }
}