<?php

namespace Strata\UI\View\Components\Dropdown;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public function __construct(
        public string $name,
        public string $value,
        public ?string $label = null,
        public bool $checked = false,
        public ?string $description = null,
    ) {}

    public function render()
    {
        return view('strata::components.dropdown.checkbox');
    }
}