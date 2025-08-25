<?php

declare(strict_types=1);

namespace Strata\UI\Traits;

use Illuminate\Http\UploadedFile;
use Strata\UI\Services\StrataFileUploadService;

/**
 * Trait for handling deferred file uploads.
 * 
 * This trait allows models to handle file uploads that are attached
 * before the model is saved, which is useful for forms that validate
 * and store files in a single operation.
 */
trait HasDeferredUploads
{
    /**
     * Deferred uploads storage.
     */
    protected array $deferredUploads = [];

    /**
     * Add files to be uploaded when the model is saved.
     */
    public function addDeferredUploads(
        array $files,
        ?string $collection = null,
        ?array $customProperties = null,
        ?array $manipulations = null,
        ?string $conversionsDisk = null,
        bool $responsiveImages = false
    ): self {
        $collection = $collection ?? 'default';
        
        if (!isset($this->deferredUploads[$collection])) {
            $this->deferredUploads[$collection] = [];
        }

        $this->deferredUploads[$collection][] = [
            'files' => $files,
            'custom_properties' => $customProperties,
            'manipulations' => $manipulations,
            'conversions_disk' => $conversionsDisk,
            'responsive_images' => $responsiveImages,
        ];

        return $this;
    }

    /**
     * Process deferred uploads after model is saved.
     */
    public function processDeferredUploads(): array
    {
        if (empty($this->deferredUploads)) {
            return [];
        }

        $service = app(StrataFileUploadService::class);
        $processedUploads = [];

        foreach ($this->deferredUploads as $collection => $uploadGroups) {
            foreach ($uploadGroups as $uploadGroup) {
                if ($service->modelSupportsMedia($this)) {
                    $mediaItems = $service->storeWithMediaLibrary(
                        $this,
                        $uploadGroup['files'],
                        $collection,
                        $uploadGroup['custom_properties'],
                        $uploadGroup['manipulations'],
                        $uploadGroup['conversions_disk'],
                        $uploadGroup['responsive_images']
                    );
                    
                    $processedUploads[$collection] = array_merge(
                        $processedUploads[$collection] ?? [],
                        $mediaItems
                    );
                } else {
                    // Fallback to regular file storage
                    $storedFiles = $service->storeFiles(
                        $uploadGroup['files'],
                        "uploads/{$this->getTable()}"
                    );
                    
                    $processedUploads[$collection] = array_merge(
                        $processedUploads[$collection] ?? [],
                        $storedFiles
                    );
                }
            }
        }

        // Clear deferred uploads after processing
        $this->deferredUploads = [];

        return $processedUploads;
    }

    /**
     * Get deferred uploads for a specific collection.
     */
    public function getDeferredUploads(?string $collection = null): array
    {
        if ($collection) {
            return $this->deferredUploads[$collection] ?? [];
        }

        return $this->deferredUploads;
    }

    /**
     * Clear deferred uploads for a specific collection or all collections.
     */
    public function clearDeferredUploads(?string $collection = null): self
    {
        if ($collection) {
            unset($this->deferredUploads[$collection]);
        } else {
            $this->deferredUploads = [];
        }

        return $this;
    }

    /**
     * Handle file uploads from a form field.
     */
    public function handleFileUploads(
        string $field,
        mixed $files,
        ?string $collection = null,
        ?array $options = []
    ): self {
        if (empty($files)) {
            return $this;
        }

        // Normalize files to array
        if ($files instanceof UploadedFile) {
            $files = [$files];
        }

        if (!is_array($files)) {
            return $this;
        }

        // Filter out non-file objects
        $validFiles = array_filter($files, fn($file) => $file instanceof UploadedFile);

        if (empty($validFiles)) {
            return $this;
        }

        $collection = $collection ?? $field;

        $this->addDeferredUploads(
            $validFiles,
            $collection,
            $options['custom_properties'] ?? null,
            $options['manipulations'] ?? null,
            $options['conversions_disk'] ?? null,
            $options['responsive_images'] ?? false
        );

        return $this;
    }

    /**
     * Boot the trait.
     */
    protected static function bootHasDeferredUploads(): void
    {
        // Process deferred uploads after model is saved
        static::saved(function ($model) {
            if (method_exists($model, 'processDeferredUploads')) {
                $model->processDeferredUploads();
            }
        });
    }
}