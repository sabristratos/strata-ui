<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * File upload component with drag-drop support and optional Spatie Media Library integration.
 */
class FileUpload extends Component
{
    public function __construct(
        public ?string $name = null,
        public bool $multiple = false,
        public ?string $accept = null,
        public ?int $maxSize = null,
        public ?string $collection = null,
        public bool $mediaLibrary = false,
        public bool $enableReordering = false,
        public bool $showPreview = true,
        public bool $showProgress = true,
        public ?string $placeholder = null,
        public ?string $helpText = null,
        public ?array $customProperties = null,
        public ?array $manipulations = null,
        public ?string $conversion = null,
        public bool $responsiveImages = false,
        public ?string $conversionsDisk = null,
        public string $variant = 'default',
        public mixed $value = null
    ) {
        // Set default accept types if not specified
        if ($this->accept === null) {
            $this->accept = 'image/*,application/pdf,.doc,.docx,.txt';
        }

        // Set default max size (12MB) if not specified
        if ($this->maxSize === null) {
            $this->maxSize = 12288; // 12MB in KB
        }

        // Set default placeholder if not specified
        if ($this->placeholder === null) {
            $this->placeholder = $this->multiple 
                ? 'Drop files here or click to browse'
                : 'Drop file here or click to browse';
        }
    }

    /**
     * Get the maximum file size in a human-readable format.
     */
    public function getMaxSizeFormatted(): string
    {
        $bytes = $this->maxSize * 1024;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }

    /**
     * Check if the model uses Spatie Media Library.
     */
    public function isMediaLibraryAvailable(): bool
    {
        return $this->mediaLibrary && 
               interface_exists('\Spatie\MediaLibrary\HasMedia') &&
               class_exists('\Spatie\MediaLibrary\MediaCollections\Models\Media');
    }

    /**
     * Get the variant-specific CSS classes.
     */
    public function getVariantClasses(): string
    {
        return match ($this->variant) {
            'compact' => 'border border-dashed border-border rounded-md p-4',
            'gallery' => 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4',
            default => 'border-2 border-dashed border-border rounded-lg p-8'
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('strata::components.form.file-upload');
    }
}