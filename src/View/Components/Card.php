<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Card component for content containers.
 */
class Card extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $size The card size (sm, md, lg)
     * @param string $border The border style (none, default, primary, accent)
     */
    public function __construct(
        public string $size = 'md',
        public string $border = 'default',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.card');
    }

    /**
     * Get the CSS classes for the card size.
     */
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'p-2',
            'lg' => 'p-6',
            default => 'p-4',
        };
    }

    /**
     * Get the CSS classes for the card border.
     */
    public function getBorderClasses(): string
    {
        return match ($this->border) {
            'none' => 'border-0',
            'primary' => 'border border-primary',
            'accent' => 'border border-accent',
            default => 'border border-border',
        };
    }
}
