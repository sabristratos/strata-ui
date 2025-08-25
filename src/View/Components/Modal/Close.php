<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Modal;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Modal close component for closing modals.
 */
class Close extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.modal.close');
    }
}