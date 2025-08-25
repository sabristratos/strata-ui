<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Tabs component for organizing content into switchable panels.
 */
class Tabs extends Component
{
    public function __construct(
        public ?string $defaultValue = null,
        public string $orientation = 'horizontal',
        public string $activationMode = 'automatic',
        public string $variant = 'default'
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.tabs');
    }

    /**
     * Get the CSS classes for the tabs orientation.
     */
    public function getOrientationClasses(): string
    {
        return match ($this->orientation) {
            'vertical' => 'flex-col',
            default => 'flex-col',
        };
    }

    /**
     * Get the CSS classes for the tabs variant.
     */
    public function getVariantClasses(): string
    {
        return match ($this->variant) {
            'pills' => 'tabs-pills',
            'underline' => 'tabs-underline',
            default => 'tabs-default',
        };
    }
}