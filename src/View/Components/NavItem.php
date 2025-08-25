<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavItem extends Component
{
    public function __construct(
        public ?string $href = null,
        public ?string $icon = null,
        public bool $active = false
    ) {
    }

    public function render(): View
    {
        return view('strata::components.nav-item');
    }
}