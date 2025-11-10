<?php

namespace Stratos\StrataUI\View\Components;

use Illuminate\View\Component;
use InvalidArgumentException;

class Image extends Component
{
    protected array $allowedAspects = [
        'square' => '1/1',
        'video' => '16/9',
        'wide' => '21/9',
        'portrait' => '3/4',
        'photo' => '4/3',
    ];

    protected array $allowedObjectFits = ['contain', 'cover', 'fill', 'none', 'scale-down'];

    protected array $allowedObjectPositions = [
        'center', 'top', 'bottom', 'left', 'right',
        'top-left', 'top-right', 'bottom-left', 'bottom-right',
    ];

    protected array $allowedLoadingModes = ['lazy', 'eager'];

    protected array $allowedPlaceholderTypes = ['blur', 'skeleton', 'none'];

    protected array $allowedCaptionPositions = ['bottom', 'overlay'];

    public function __construct(
        public string $src = '',
        public string $alt = '',
        public ?int $width = null,
        public ?int $height = null,
        public string $loading = 'lazy',
        public ?string $srcset = null,
        public ?string $sizes = null,
        public ?array $sources = null,
        public ?array $formats = null,
        public ?string $placeholder = null,
        public ?string $blurHash = null,
        public string $placeholderType = 'skeleton',
        public ?string $fallback = null,
        public mixed $media = null,
        public ?string $lightbox = null,
        public ?string $lightboxCaption = null,
        public ?string $aspect = null,
        public string $objectFit = 'cover',
        public string $objectPosition = 'center',
        public string $rounded = 'md',
        public ?string $caption = null,
        public string $captionPosition = 'bottom',
        public bool $decorative = false,
        public ?string $fetchpriority = null,
        public bool $decodeAsync = true,
    ) {}

    /**
     * Mount the component and validate props.
     */
    public function mount(): void
    {
        // Validate alt text requirement
        if (! $this->decorative && empty($this->alt)) {
            throw new InvalidArgumentException(
                'The "alt" attribute is required for accessibility. Use decorative="true" if the image is purely decorative.'
            );
        }

        // If decorative, clear alt text
        if ($this->decorative) {
            $this->alt = '';
        }

        // Validate loading mode
        if (! in_array($this->loading, $this->allowedLoadingModes)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid loading value "%s". Allowed values: %s',
                    $this->loading,
                    implode(', ', $this->allowedLoadingModes)
                )
            );
        }

        // Validate object fit
        if (! in_array($this->objectFit, $this->allowedObjectFits)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid objectFit value "%s". Allowed values: %s',
                    $this->objectFit,
                    implode(', ', $this->allowedObjectFits)
                )
            );
        }

        // Validate object position
        if (! in_array($this->objectPosition, $this->allowedObjectPositions)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid objectPosition value "%s". Allowed values: %s',
                    $this->objectPosition,
                    implode(', ', $this->allowedObjectPositions)
                )
            );
        }

        // Validate placeholder type
        if (! in_array($this->placeholderType, $this->allowedPlaceholderTypes)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid placeholderType value "%s". Allowed values: %s',
                    $this->placeholderType,
                    implode(', ', $this->allowedPlaceholderTypes)
                )
            );
        }

        // Validate caption position
        if (! in_array($this->captionPosition, $this->allowedCaptionPositions)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid captionPosition value "%s". Allowed values: %s',
                    $this->captionPosition,
                    implode(', ', $this->allowedCaptionPositions)
                )
            );
        }

        // Process media library if provided
        if ($this->media !== null) {
            $this->processMediaLibrary();
        }

        // Process formats if provided
        if ($this->formats !== null) {
            $this->processFormats();
        }
    }

    /**
     * Process Spatie Media Library media object.
     */
    protected function processMediaLibrary(): void
    {
        // Check if it's a Spatie Media Library instance
        if (! is_object($this->media) || ! method_exists($this->media, 'getUrl')) {
            throw new InvalidArgumentException(
                'The media prop must be a valid Media Library instance with a getUrl() method.'
            );
        }

        // Set src from media
        if (empty($this->src)) {
            $this->src = $this->media->getUrl();
        }

        // Generate srcset from responsive images if available
        if (empty($this->srcset) && method_exists($this->media, 'getSrcset')) {
            $this->srcset = $this->media->getSrcset();
        }

        // Use media name as alt if not provided
        if (empty($this->alt) && ! $this->decorative) {
            $this->alt = $this->media->name ?? 'Image from media library';
        }

        // Get width/height if available
        if ($this->width === null && isset($this->media->width)) {
            $this->width = $this->media->width;
        }

        if ($this->height === null && isset($this->media->height)) {
            $this->height = $this->media->height;
        }
    }

    /**
     * Process formats array to generate sources.
     */
    protected function processFormats(): void
    {
        if (! is_array($this->formats)) {
            throw new InvalidArgumentException('The formats prop must be an array of format strings (e.g., ["avif", "webp"]).');
        }

        $sources = [];

        foreach ($this->formats as $format) {
            // Generate source URL by replacing extension
            $sourceSrc = preg_replace('/\.[^.]+$/', '.'.$format, $this->src);

            $sources[] = [
                'srcset' => $sourceSrc,
                'type' => 'image/'.$format,
            ];
        }

        // Merge with existing sources
        $this->sources = array_merge($sources, $this->sources ?? []);
    }

    /**
     * Get the aspect ratio value.
     */
    public function getAspectRatio(): ?string
    {
        if ($this->aspect === null) {
            return null;
        }

        // Return preset or custom value
        return $this->allowedAspects[$this->aspect] ?? $this->aspect;
    }

    /**
     * Get the object fit class.
     */
    public function getObjectFitClass(): string
    {
        return 'object-'.$this->objectFit;
    }

    /**
     * Get the object position class.
     */
    public function getObjectPositionClass(): string
    {
        $positionMap = [
            'center' => 'object-center',
            'top' => 'object-top',
            'bottom' => 'object-bottom',
            'left' => 'object-left',
            'right' => 'object-right',
            'top-left' => 'object-left-top',
            'top-right' => 'object-right-top',
            'bottom-left' => 'object-left-bottom',
            'bottom-right' => 'object-right-bottom',
        ];

        return $positionMap[$this->objectPosition] ?? 'object-center';
    }

    /**
     * Get the rounded class.
     */
    public function getRoundedClass(): string
    {
        $roundedMap = [
            'none' => 'rounded-none',
            'sm' => 'rounded-sm',
            'md' => 'rounded-md',
            'lg' => 'rounded-lg',
            'xl' => 'rounded-xl',
            '2xl' => 'rounded-2xl',
            'full' => 'rounded-full',
        ];

        return $roundedMap[$this->rounded] ?? 'rounded-md';
    }

    /**
     * Get lightbox data attributes.
     */
    public function getLightboxAttributes(): array
    {
        $attributes = [];

        if ($this->lightbox !== null) {
            // Convert boolean true to 'default', keep string as-is
            $galleryName = ($this->lightbox === true || $this->lightbox === '1')
                ? 'default'
                : $this->lightbox;

            $attributes['data-lightbox'] = $galleryName;
        }

        if ($this->lightboxCaption !== null) {
            $attributes['data-lightbox-caption'] = $this->lightboxCaption;
        } elseif ($this->caption !== null && $this->lightbox !== null) {
            $attributes['data-lightbox-caption'] = $this->caption;
        }

        return $attributes;
    }

    /**
     * Check if component should use <picture> element.
     */
    public function usesPictureElement(): bool
    {
        return ! empty($this->sources);
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('strata-ui::components.image.index');
    }
}
