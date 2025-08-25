<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NotificationContent extends Component
{
    public function __construct(
        public ?string $image = null,
        public ?string $title = null,
        public ?string $description = null,
    ) {}

    public function render(): View
    {
        return view('strata::components.notification-content');
    }
}