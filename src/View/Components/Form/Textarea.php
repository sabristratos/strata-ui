<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Textarea component for multi-line text input.
 */
class Textarea extends Component
{
    public function __construct(
        public ?string $name = null,
        public int $rows = 3,
        public bool $autoResize = false,
        public ?string $placeholder = null,
        public mixed $value = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.form.textarea');
    }
}