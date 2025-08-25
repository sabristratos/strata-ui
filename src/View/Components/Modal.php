<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Modal component for displaying content in overlay dialogs.
 */
class Modal extends Component
{
    public function __construct(
        public ?string $name = null,
        public string $variant = 'default',
        public string $size = 'md',
        public string $position = 'center',
        public bool $dismissible = true,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.modal');
    }

    /**
     * Get the CSS classes for the modal size.
     */
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'max-w-sm',
            'lg' => 'max-w-2xl',
            'xl' => 'max-w-4xl',
            '2xl' => 'max-w-6xl',
            'full' => 'max-w-[95vw]',
            default => 'max-w-lg',
        };
    }

    /**
     * Get the CSS classes for the modal variant.
     */
    public function getVariantClasses(): string
    {
        return match ($this->variant) {
            'flyout' => $this->getFlyoutVariantClasses(),
            'bare' => 'bg-transparent shadow-none border-0',
            default => 'bg-card text-card-foreground rounded-lg shadow-xl border border-border',
        };
    }
    
    /**
     * Get the CSS classes for flyout variant with position-specific borders.
     */
    private function getFlyoutVariantClasses(): string
    {
        $baseClasses = 'h-full max-h-none rounded-none bg-card text-card-foreground shadow-2xl border-border';
        
        return match ($this->position) {
            'left' => $baseClasses . ' border-r',
            'bottom' => $baseClasses . ' border-t',
            default => $baseClasses . ' border-l', // 'right'
        };
    }

    /**
     * Get the CSS classes for flyout positioning.
     */
    public function getFlyoutPositionClasses(): string
    {
        if ($this->variant !== 'flyout') {
            return '';
        }

        return match ($this->position) {
            'left' => 'left-0 top-0',
            'bottom' => 'bottom-0 left-0 w-full max-w-none rounded-t-lg rounded-b-none',
            default => 'right-0 top-0', // 'right'
        };
    }
}