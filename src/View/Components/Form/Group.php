<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Form group component for wrapping form fields with labels and help text.
 */
class Group extends Component
{
    public function __construct(
        public string $label,
        public string $for,
        public ?string $helpText = null,
        public ?string $error = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.form.group');
    }
}