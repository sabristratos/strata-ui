<?php

namespace Stratos\StrataUI\View\Components;

use Illuminate\View\Component;
use InvalidArgumentException;

class Select extends Component
{
    protected array $allowedSizes = ['xs', 'sm', 'md', 'lg', 'xl'];

    protected array $allowedStates = ['default', 'success', 'error', 'warning'];

    protected array $allowedVariants = ['faded', 'flat', 'bordered', 'underlined'];

    protected array $allowedPlacements = [
        'bottom-start', 'bottom-end', 'bottom',
        'top-start', 'top-end', 'top',
        'right-start', 'right-end', 'right',
        'left-start', 'left-end', 'left',
    ];

    public function __construct(
        public string $size = 'md',
        public string $state = 'default',
        public string $variant = 'faded',
        public string $placement = 'bottom-start',
        public bool $multiple = false,
        public bool $searchable = false,
        public bool $clearable = false,
        public bool $chips = false,
        public bool $disabled = false,
        public bool $readonly = false,
        public bool $required = false,
        public bool $loading = false,
        public ?int $maxSelected = null,
        public string $placeholder = 'Select an option',
        public string $searchPlaceholder = 'Search...',
        public string $loadingMessage = 'Loading options...',
        public string $noResultsMessage = 'No results found.',
        public string $emptyMessage = 'No options available.',
        public int $offset = 8,
        public ?array $value = null,
        public ?string $wireModel = null,
    ) {}

    public function mount(): void
    {
        if (! in_array($this->size, $this->allowedSizes)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid size "%s" for Select component. Allowed values: %s',
                    $this->size,
                    implode(', ', $this->allowedSizes)
                )
            );
        }

        if (! in_array($this->state, $this->allowedStates)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid state "%s" for Select component. Allowed values: %s',
                    $this->state,
                    implode(', ', $this->allowedStates)
                )
            );
        }

        if (! in_array($this->variant, $this->allowedVariants)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid variant "%s" for Select component. Allowed values: %s',
                    $this->variant,
                    implode(', ', $this->allowedVariants)
                )
            );
        }

        if (! in_array($this->placement, $this->allowedPlacements)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid placement "%s" for Select component. Allowed values: %s',
                    $this->placement,
                    implode(', ', $this->allowedPlacements)
                )
            );
        }

        if ($this->maxSelected !== null && $this->maxSelected < 1) {
            throw new InvalidArgumentException(
                'The maxSelected value must be at least 1'
            );
        }

        if ($this->maxSelected !== null && ! $this->multiple) {
            throw new InvalidArgumentException(
                'The maxSelected prop can only be used with multiple="true"'
            );
        }
    }

    public function render()
    {
        return view('strata-ui::components.select.index');
    }
}
