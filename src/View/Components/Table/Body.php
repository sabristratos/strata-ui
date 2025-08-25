<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Table;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Body extends Component
{
    public function render(): View
    {
        return view('strata::components.table.body');
    }
}