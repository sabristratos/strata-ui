<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChoiceGroup extends Component
{
    public function __construct(
        public string $label,
        public bool $inline = false
    ) {
    }

    public function render(): View
    {
        return view('strata::components.form.choice-group');
    }
}