<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Rating component for Strata UI.
 */
class Rating extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string|null $name The input name attribute
     * @param string|null $label The label text
     * @param string|null $description The description text
     * @param int|float|null $value The current rating value
     * @param int $max The maximum rating value (number of stars)
     * @param bool $readonly Whether the rating is readonly
     * @param bool $clearable Whether to show a clear button
     * @param string $size The size of the rating (sm, md, lg)
     * @param string $icon The icon to use for rating items
     * @param string|null $id The input ID attribute
     */
    public function __construct(
        public ?string $name = null,
        public ?string $label = null,
        public ?string $description = null,
        public int|float|null $value = null,
        public int $max = 5,
        public bool $readonly = false,
        public bool $clearable = true,
        public string $size = 'md',
        public string $icon = 'heroicon-o-star',
        public ?string $id = null,
    ) {
        $this->id = $id ?: 'rating-' . uniqid();
        
        // Ensure max is at least 1
        $this->max = max(1, $this->max);
        
        // Ensure value is within bounds if provided
        if ($this->value !== null) {
            $this->value = max(0, min($this->max, $this->value));
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.form.rating');
    }

    /**
     * Get the CSS classes for the rating size.
     */
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'w-4 h-4',
            'lg' => 'w-6 h-6',
            default => 'w-5 h-5',
        };
    }

    /**
     * Get the gap classes for the rating size.
     */
    public function getGapClasses(): string
    {
        return match ($this->size) {
            'sm' => 'gap-1',
            'lg' => 'gap-2',
            default => 'gap-1.5',
        };
    }

    /**
     * Get the clear button size classes.
     */
    public function getClearButtonSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'w-4 h-4',
            'lg' => 'w-5 h-5',
            default => 'w-4 h-4',
        };
    }

    /**
     * Get the ID for the component.
     */
    public function getId(): string
    {
        return $this->id;
    }
}