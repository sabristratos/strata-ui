<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Button component for Strata UI.
 */
class Button extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $variant The button variant (primary, accent, destructive, outline, secondary, ghost)
     * @param string $size The button size (sm, md, lg)
     * @param string $type The button type attribute
     * @param bool $disabled Whether the button is disabled
     * @param bool $loading Whether the button is in loading state
     * @param string|null $icon The icon name to display
     * @param string $iconPosition The position of the icon (left, right)
     */
    public function __construct(
        public string $variant = 'primary',
        public string $size = 'md',
        public string $type = 'button',
        public bool $disabled = false,
        public bool $loading = false,
        public ?string $icon = null,
        public string $iconPosition = 'left',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.button');
    }

    /**
     * Get the CSS classes for the button variant.
     */
    public function getVariantClasses(): string
    {
        return match ($this->variant) {
            'accent' => 'bg-accent text-accent-foreground hover:bg-accent/90 shadow',
            'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/90 shadow',
            'outline' => 'border border-border bg-background text-foreground hover:bg-accent hover:text-accent-foreground shadow',
            'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/90 shadow',
            'ghost' => 'hover:bg-accent hover:text-accent-foreground',
            default => 'bg-primary text-primary-foreground hover:bg-primary/90 shadow',
        };
    }
}
