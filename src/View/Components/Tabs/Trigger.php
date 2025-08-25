<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Tabs;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Tabs trigger component for individual tab buttons.
 */
class Trigger extends Component
{
    public function __construct(
        public string $value,
        public bool $disabled = false
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.tabs.trigger');
    }
}