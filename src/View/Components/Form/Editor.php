<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Rich text editor component with contenteditable
 * 
 * @property string $name The form field name
 * @property string $value The initial content value
 * @property ?string $placeholder Placeholder text
 * @property ?string $id The element ID
 * @property bool $required Whether the field is required
 * @property bool $disabled Whether the field is disabled
 * @property ?int $minHeight Minimum height in pixels
 * @property ?int $maxHeight Maximum height in pixels
 */
class Editor extends Component
{
    public function __construct(
        public string $name = '',
        public string $value = '',
        public ?string $placeholder = null,
        public ?string $id = null,
        public bool $required = false,
        public bool $disabled = false,
        public ?int $minHeight = 200,
        public ?int $maxHeight = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.form.editor');
    }
}