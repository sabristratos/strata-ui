<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Toast container component for displaying toast notifications.
 */
class ToastContainer extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $position The position of the toast container
     * @param bool $expanded Whether the container should be expanded by default
     */
    public function __construct(
        public string $position = 'bottom-end',
        public bool $expanded = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.toast-container');
    }
}