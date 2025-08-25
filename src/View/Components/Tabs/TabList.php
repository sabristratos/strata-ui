<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Tabs;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Tabs list component that contains tab triggers.
 */
class TabList extends Component
{
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.tabs.list');
    }
}