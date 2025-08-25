<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Modal;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Modal trigger component for opening named modals.
 */
class Trigger extends Component
{
    public function __construct(
        public string $name,
        public ?string $shortcut = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.modal.trigger');
    }
}