<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Input component for form fields.
 */
class Input extends Component
{
    public function __construct(
        public string $type = 'text',
        public ?string $name = null,
        public ?string $icon = null,
        public bool $clearable = false,
        public bool $showPasswordToggle = false,
        public ?string $placeholder = null,
        public mixed $value = null
    ) {
        if ($this->type === 'password' && !$this->showPasswordToggle) {
            $this->showPasswordToggle = true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.form.input');
    }
}