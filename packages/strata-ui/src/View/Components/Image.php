<?php

namespace Stratos\StrataUI\View\Components;

use Illuminate\View\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Image extends Component
{
    public string $sizeClass = '';

    public string $aspectClass = '';

    public string $roundedClass = '';

    public string $imageRoundedClass = '';

    public string $displayClass = '';

    public string $variantClass = '';

    public string $fitClass = '';

    public string $positionClass = '';

    public ?string $processedSrcset = null;

    public ?string $blurDataUrl = null;

    public function __construct(
        public ?string $src = null,
        public ?string $alt = null,
        public ?string $aspect = null,
        public string $fit = 'cover',
        public string $position = 'center',
        public string $loading = 'lazy',
        public ?string $size = null,
        public ?string $rounded = null,
        public string $variant = 'default',
        public ?string $fallbackSrc = null,
        public ?string $fallbackIcon = 'image',
        public bool $showFallbackIcon = true,
        public bool $skeleton = true,
        public string $skeletonVariant = 'pulse',
        public ?string $blurHash = null,
        public ?string $placeholder = null,
        public ?string $srcset = null,
        public ?string $sizes = null,
        public bool $decorative = false,
        public ?string $caption = null,
        public string $captionPosition = 'bottom',
        public bool $zoom = false,
        public ?string $imgClass = null,
        public ?Media $media = null,
    ) {
        if ($this->media) {
            $this->loadFromMedia();
        }

        if (! $this->decorative && ! $this->alt && ! $this->media) {
            throw new \InvalidArgumentException('The "alt" attribute is required for non-decorative images. Use decorative="true" for decorative images.');
        }

        if ($this->decorative) {
            $this->alt = '';
        }

        $this->sizeClass = $this->getSizeClass();
        $this->aspectClass = $this->getAspectClass();
        $this->roundedClass = $this->getRoundedClass();
        $this->displayClass = $this->getDisplayClass();
        $this->variantClass = $this->getVariantClass();
        $this->fitClass = $this->getFitClass();
        $this->positionClass = $this->getPositionClass();
        $this->imageRoundedClass = $this->getImageRoundedClass();

        if ($this->blurHash) {
            $this->blurDataUrl = $this->generateBlurDataUrl();
        }
    }

    public function mount(): void {}

    protected function loadFromMedia(): void
    {
        if (! $this->media) {
            return;
        }

        $this->src = $this->media->getUrl();
        $this->alt = $this->alt ?? $this->media->name;

        if (method_exists($this->media, 'getSrcset')) {
            $this->processedSrcset = $this->media->getSrcset();
        }

        $customProperties = $this->media->custom_properties ?? [];
        if (isset($customProperties['blur_hash'])) {
            $this->blurHash = $customProperties['blur_hash'];
        }
    }

    protected function getSizeClass(): string
    {
        if (! $this->size) {
            return '';
        }

        if ($this->aspect) {
            return match ($this->size) {
                'xs' => 'w-16',
                'sm' => 'w-24',
                'md' => 'w-32',
                'lg' => 'w-48',
                'xl' => 'w-64',
                '2xl' => 'w-96',
                'full' => 'w-full',
                default => $this->size,
            };
        }

        return match ($this->size) {
            'xs' => 'w-16 h-16',
            'sm' => 'w-24 h-24',
            'md' => 'w-32 h-32',
            'lg' => 'w-48 h-48',
            'xl' => 'w-64 h-64',
            '2xl' => 'w-96 h-96',
            'full' => 'w-full',
            default => $this->size,
        };
    }

    protected function getAspectClass(): string
    {
        if (! $this->aspect) {
            return '';
        }

        return match ($this->aspect) {
            'square' => 'aspect-square',
            'video' => 'aspect-video',
            'wide' => 'aspect-[21/9]',
            'portrait' => 'aspect-[3/4]',
            'photo' => 'aspect-[4/3]',
            default => "aspect-[{$this->aspect}]",
        };
    }

    protected function getRoundedClass(): string
    {
        if (! $this->rounded) {
            return '';
        }

        return match ($this->rounded) {
            'none' => 'rounded-none',
            'sm' => 'rounded-sm',
            'md' => 'rounded-md',
            'lg' => 'rounded-lg',
            'xl' => 'rounded-xl',
            'full' => 'rounded-full',
            default => $this->rounded,
        };
    }

    protected function getVariantClass(): string
    {
        return match ($this->variant) {
            'bordered' => 'border-4 border-border',
            'elevated' => 'shadow-xl',
            'outlined' => 'border-2 border-border p-3 bg-card',
            default => '',
        };
    }

    protected function getFitClass(): string
    {
        return match ($this->fit) {
            'contain' => 'object-contain',
            'cover' => 'object-cover',
            'fill' => 'object-fill',
            'none' => 'object-none',
            'scale-down' => 'object-scale-down',
            default => 'object-cover',
        };
    }

    protected function getPositionClass(): string
    {
        return match ($this->position) {
            'center' => 'object-center',
            'top' => 'object-top',
            'bottom' => 'object-bottom',
            'left' => 'object-left',
            'right' => 'object-right',
            'top-left' => 'object-left-top',
            'top-right' => 'object-right-top',
            'bottom-left' => 'object-left-bottom',
            'bottom-right' => 'object-right-bottom',
            default => 'object-center',
        };
    }

    protected function getDisplayClass(): string
    {
        if ($this->size || $this->aspect) {
            return 'block';
        }

        return 'inline-block';
    }

    protected function getImageRoundedClass(): string
    {
        if (! $this->rounded) {
            return '';
        }

        if ($this->variant === 'bordered') {
            return match ($this->rounded) {
                'sm' => '',
                'md' => 'rounded-sm',
                'lg' => 'rounded-md',
                'xl' => 'rounded-lg',
                'full' => 'rounded-full',
                default => '',
            };
        }

        return $this->roundedClass;
    }

    protected function generateBlurDataUrl(): ?string
    {
        return null;
    }

    public function render()
    {
        return view('strata-ui::components.image.index');
    }
}
