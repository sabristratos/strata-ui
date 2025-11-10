<?php

namespace Stratos\StrataUI\View\Components;

use Illuminate\View\Component;
use InvalidArgumentException;

class Carousel extends Component
{
    protected array $allowedSizes = ['xs', 'sm', 'md', 'lg', 'xl'];

    public function __construct(
        public string $id,
        public string $size = 'md',
        public bool $loop = false,
        public bool $autoplay = false,
        public int $autoplayDelay = 3000,
        public bool $controls = true,
        public int $startIndex = 0,
        public bool $playOnInit = true,
        public bool $stopOnInteraction = true,
        public bool $stopOnLastSnap = false,
        public bool $jump = false,
    ) {}

    public function mount(): void
    {
        if (empty($this->id)) {
            throw new InvalidArgumentException(
                'The id property is required for Carousel component'
            );
        }

        if (! in_array($this->size, $this->allowedSizes)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid size "%s" for Carousel component. Allowed values: %s',
                    $this->size,
                    implode(', ', $this->allowedSizes)
                )
            );
        }

        if ($this->autoplayDelay < 1) {
            throw new InvalidArgumentException(
                'The autoplayDelay value must be at least 1 millisecond'
            );
        }

        if ($this->startIndex < 0) {
            throw new InvalidArgumentException(
                'The startIndex value must be greater than or equal to 0'
            );
        }
    }

    public function render()
    {
        return view('strata-ui::components.carousel.index', [
            'id' => $this->id,
            'size' => $this->size,
            'loop' => $this->loop,
            'autoplay' => $this->autoplay,
            'autoplayDelay' => $this->autoplayDelay,
            'controls' => $this->controls,
            'startIndex' => $this->startIndex,
            'playOnInit' => $this->playOnInit,
            'stopOnInteraction' => $this->stopOnInteraction,
            'stopOnLastSnap' => $this->stopOnLastSnap,
            'jump' => $this->jump,
        ]);
    }
}
