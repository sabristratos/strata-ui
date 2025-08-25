<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Avatar component for displaying user profile images and status.
 */
class Avatar extends Component
{
    public function __construct(
        public ?string $src = null,
        public ?string $alt = null,
        public ?string $initials = null,
        public string $size = 'md',
        public string $shape = 'circle',
        public string $status = 'none',
        public string $statusPosition = 'bottom-right',
        public bool $border = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.avatar');
    }

    /**
     * Get the CSS classes for the avatar size.
     */
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'xs' => 'w-6 h-6',
            'sm' => 'w-8 h-8',
            'lg' => 'w-12 h-12',
            'xl' => 'w-16 h-16',
            '2xl' => 'w-20 h-20',
            '3xl' => 'w-24 h-24',
            default => 'w-10 h-10',
        };
    }

    /**
     * Get the CSS classes for the avatar shape.
     */
    public function getShapeClasses(): string
    {
        return match ($this->shape) {
            'square' => 'rounded-[var(--radius-component)]',
            'rounded' => 'rounded-[var(--radius-component-lg)]',
            default => 'rounded-full',
        };
    }

    /**
     * Get the CSS classes for the avatar border.
     */
    public function getBorderClasses(): string
    {
        return $this->border ? 'ring-2 ring-white dark:ring-slate-800' : '';
    }

    /**
     * Get the CSS classes for the avatar status indicator.
     */
    public function getStatusClasses(): string
    {
        $baseClasses = 'absolute rounded-full ring-2 ring-white dark:ring-slate-800';

        $sizeClasses = match ($this->size) {
            'xs', 'sm' => 'w-2 h-2',
            'lg' => 'w-3 h-3',
            'xl' => 'w-3.5 h-3.5',
            '2xl' => 'w-4 h-4',
            '3xl' => 'w-5 h-5',
            default => 'w-2.5 h-2.5',
        };

        $positionClasses = match ($this->statusPosition) {
            'top-left' => 'top-0 left-0 transform -translate-x-1/4 -translate-y-1/4',
            'top-right' => 'top-0 right-0 transform translate-x-1/4 -translate-y-1/4',
            'bottom-left' => 'bottom-0 left-0 transform -translate-x-1/4 translate-y-1/4',
            default => 'bottom-0 right-0 transform translate-x-1/4 translate-y-1/4', // 'bottom-right'
        };

        $colorClasses = match ($this->status) {
            'online' => 'bg-[var(--color-status-online)]',
            'away' => 'bg-[var(--color-status-away)]',
            'busy' => 'bg-[var(--color-status-busy)]',
            'offline' => 'bg-[var(--color-status-offline)]',
            default => 'hidden',
        };

        return "{$baseClasses} {$sizeClasses} {$positionClasses} {$colorClasses}";
    }

    /**
     * Get the CSS classes for the avatar initials text.
     */
    public function getInitialsTextClasses(): string
    {
        return match ($this->size) {
            'xs' => 'text-[8px]',
            'sm' => 'text-xs',
            'lg' => 'text-lg',
            'xl' => 'text-2xl',
            '2xl' => 'text-3xl',
            '3xl' => 'text-4xl',
            default => 'text-sm',
        };
    }
}
