<?php

namespace Strata\UI\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class Toggle extends Component
{
    public function __construct(
        public ?string $name = null,
        public ?string $label = null,
        public ?string $description = null,
        public mixed $value = null,
        public bool $checked = false,
        public ?string $id = null
    ) {
        $this->id = $id ?: 'toggle-' . uniqid();
    }

    public function render()
    {
        return view('strata::components.form.toggle');
    }
}