<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Alert component for displaying notifications and status messages.
 */
class Alert extends Component
{
    public function __construct(
        public string $variant = 'solid',
        public string $color = 'info',
        public string $size = 'md',
        public ?string $icon = null,
        public bool $dismissible = false,
        public ?string $title = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.alert');
    }

    /**
     * Get the CSS classes for the alert variant and color combination.
     */
    public function getVariantClasses(): string
    {
        return match ($this->variant) {
            'outline' => match ($this->color) {
                'accent' => 'bg-transparent text-accent border border-accent',
                'destructive' => 'bg-transparent text-destructive border border-destructive',
                'success' => 'bg-transparent text-teal-500 border border-teal-500',
                'warning' => 'bg-transparent text-yellow-500 border border-yellow-500',
                'primary' => 'bg-transparent text-primary border border-primary',
                default => 'bg-transparent text-indigo-500 border border-indigo-500',
            },
            'soft' => match ($this->color) {
                'accent' => 'bg-accent/20 text-accent border border-transparent',
                'destructive' => 'bg-destructive/20 text-destructive border border-transparent',
                'success' => 'bg-teal-500/20 text-teal-500 border border-transparent',
                'warning' => 'bg-yellow-500/20 text-yellow-500 border border-transparent',
                'primary' => 'bg-primary/20 text-primary border border-transparent',
                default => 'bg-indigo-500/20 text-indigo-500 border border-transparent',
            },
            default => match ($this->color) {
                'accent' => 'bg-accent text-accent-foreground border border-transparent',
                'destructive' => 'bg-destructive text-destructive-foreground border border-transparent',
                'success' => 'bg-teal-500 text-foreground border border-transparent',
                'warning' => 'bg-yellow-500 text-foreground border border-transparent',
                'primary' => 'bg-primary text-primary-foreground border border-transparent',
                default => 'bg-indigo-500 text-foreground border border-transparent',
            },
        };
    }

    /**
     * Get the CSS classes for the alert size.
     */
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'p-3 text-sm',
            'lg' => 'p-6 text-base',
            default => 'p-4',
        };
    }

    /**
     * Get the CSS classes for the alert icon size.
     */
    public function getIconSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'w-4 h-4',
            'lg' => 'w-6 h-6',
            default => 'w-5 h-5',
        };
    }

    /**
     * Get the contextual icon based on the alert color.
     */
    public function getContextualIcon(): string
    {
        if ($this->icon) {
            return $this->icon;
        }

        return match ($this->color) {
            'destructive' => 'heroicon-o-x-circle',
            'success' => 'heroicon-o-check-circle',
            'warning' => 'heroicon-o-exclamation-triangle',
            'primary' => 'heroicon-o-star',
            'accent' => 'heroicon-o-information-circle',
            default => 'heroicon-o-information-circle',
        };
    }

    /**
     * Get the CSS classes for the alert title.
     */
    public function getTitleClasses(): string
    {
        return match ($this->size) {
            'sm' => 'text-sm font-medium',
            'lg' => 'text-lg font-semibold',
            default => 'text-base font-medium',
        };
    }
}