<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Table component for displaying structured data.
 */
class Table extends Component
{
    public function __construct(
        public bool $striped = false,
        public bool $loading = false,
        public string $size = 'md',
        public bool $sticky = false
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.table');
    }
}