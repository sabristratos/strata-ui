<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public function __construct(
        public string $name,
        public string $id,
        public mixed $value,
        public string $label,
        public ?string $description = null,
        public bool $checked = false
    ) {
    }

    public function render(): View
    {
        return view('strata::components.form.radio');
    }
}