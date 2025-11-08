<?php

namespace Stratos\StrataUI\View\Components;

use Illuminate\View\Component;
use InvalidArgumentException;

class PhoneInput extends Component
{
    protected array $allowedSizes = ['xs', 'sm', 'md', 'lg', 'xl'];

    protected array $allowedStates = ['default', 'success', 'error', 'warning'];

    public function __construct(
        public array $countries = [],
        public ?string $value = null,
        public ?string $defaultCountry = null,
        public string $size = 'md',
        public string $state = 'default',
        public bool $disabled = false,
        public bool $required = false,
        public bool $readonly = false,
        public string $placeholder = 'Enter phone number',
        public ?string $wireModel = null,
        public int $offset = 8,
    ) {}

    public function mount(): void
    {
        if (empty($this->countries)) {
            throw new InvalidArgumentException(
                'The countries prop is required and cannot be empty. Please provide an array of country data.'
            );
        }

        foreach ($this->countries as $index => $country) {
            if (! isset($country['code'], $country['name'], $country['dialCode'])) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Country at index %d is missing required fields. Each country must have: code, name, dialCode',
                        $index
                    )
                );
            }
        }

        if (! in_array($this->size, $this->allowedSizes)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid size "%s" for PhoneInput component. Allowed values: %s',
                    $this->size,
                    implode(', ', $this->allowedSizes)
                )
            );
        }

        if (! in_array($this->state, $this->allowedStates)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid state "%s" for PhoneInput component. Allowed values: %s',
                    $this->state,
                    implode(', ', $this->allowedStates)
                )
            );
        }

        if ($this->defaultCountry !== null) {
            $countryCodes = array_column($this->countries, 'code');
            if (! in_array($this->defaultCountry, $countryCodes)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Invalid defaultCountry "%s". Must match one of the country codes provided in countries array.',
                        $this->defaultCountry
                    )
                );
            }
        }
    }

    public function render()
    {
        return view('strata-ui::components.phone-input.index');
    }
}
