<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Badge component for displaying labels and status indicators.
 */
class Badge extends Component
{
    public function __construct(
        public string $variant = 'solid',
        public string $color = 'primary',
        public string $size = 'md',
        public string $shape = 'pill',
        public ?string $icon = null,
        public bool $dismissible = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.badge');
    }

    /**
     * Get the CSS classes for the badge variant and color combination.
     */
    public function getVariantClasses(): string
    {
        return match ($this->variant) {
            'outline' => match ($this->color) {
                'accent' => 'bg-transparent text-accent border border-accent',
                'destructive' => 'bg-transparent text-destructive border border-destructive',
                'success' => 'bg-transparent text-teal-500 border border-teal-500',
                'warning' => 'bg-transparent text-yellow-500 border border-yellow-500',
                'info' => 'bg-transparent text-indigo-500 border border-indigo-500',
                default => 'bg-transparent text-primary border border-primary',
            },
            'soft' => match ($this->color) {
                'accent' => 'bg-accent/20 text-accent border-0',
                'destructive' => 'bg-destructive/20 text-destructive border-0',
                'success' => 'bg-teal-500/20 text-teal-500 border-0',
                'warning' => 'bg-yellow-500/20 text-yellow-500 border-0',
                'info' => 'bg-indigo-500/20 text-indigo-500 border-0',
                default => 'bg-primary/20 text-primary border-0',
            },
            default => match ($this->color) {
                'accent' => 'bg-accent text-accent-foreground border-0',
                'destructive' => 'bg-destructive text-destructive-foreground border-0',
                'success' => 'bg-teal-500 text-foreground border-0',
                'warning' => 'bg-yellow-500 text-foreground border-0',
                'info' => 'bg-indigo-500 text-foreground border-0',
                default => 'bg-primary text-primary-foreground border-0',
            },
        };
    }
}
