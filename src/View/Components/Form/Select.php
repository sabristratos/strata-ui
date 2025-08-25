<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Select component for form fields with dropdown functionality.
 */
class Select extends Component
{
    public function __construct(
        public ?string $label = null,
        public array $items = [],
        public mixed $selected = null,
        public ?string $placeholder = 'Choose...',
        public ?string $name = null,
        public ?string $error = null,
        public ?string $helpText = null,
        public bool $disabled = false,
        public bool $clearable = false,
        public bool $multiple = false,
        public int $maxSelections = 0,
        public bool $searchable = false,
        public int $searchThreshold = 10,
        public string $searchPlaceholder = 'Search...',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.form.select');
    }

    /**
     * Get the unique ID for this select component.
     */
    public function getId(): string
    {
        return 'select_' . uniqid();
    }
}