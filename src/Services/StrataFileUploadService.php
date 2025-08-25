<?php

declare(strict_types=1);

namespace Strata\UI\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Service class for handling file uploads with optional Spatie Media Library integration.
 */
class StrataFileUploadService
{
    /**
     * Check if Spatie Media Library is available.
     */
    public function isMediaLibraryAvailable(): bool
    {
        return interface_exists(HasMedia::class) && 
               class_exists(Media::class);
    }

    /**
     * Check if a model implements HasMedia interface.
     */
    public function modelSupportsMedia(Model $model): bool
    {
        return $this->isMediaLibraryAvailable() && $model instanceof HasMedia;
    }

    /**
     * Store files using Spatie Media Library.
     */
    public function storeWithMediaLibrary(
        Model $model,
        array $files,
        ?string $collection = null,
        ?array $customProperties = null,
        ?array $manipulations = null,
        ?string $conversionsDisk = null,
        bool $responsiveImages = false
    ): array {
        if (!$this->modelSupportsMedia($model)) {
            throw new \InvalidArgumentException('Model must implement HasMedia interface');
        }

        $mediaItems = [];
        $collection = $collection ?? 'default';

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $mediaItem = $model
                ->addMediaFromRequest($file->getClientOriginalName())
                ->toMediaCollection($collection);

            // Add custom properties if specified
            if ($customProperties) {
                foreach ($customProperties as $key => $value) {
                    $mediaItem->setCustomProperty($key, $value);
                }
                $mediaItem->save();
            }

            // Set conversions disk if specified
            if ($conversionsDisk) {
                $mediaItem->setCustomProperty('conversions_disk', $conversionsDisk);
                $mediaItem->save();
            }

            // Enable responsive images if requested
            if ($responsiveImages) {
                $mediaItem->setCustomProperty('responsive_images', true);
                $mediaItem->save();
            }

            // Apply manipulations if specified
            if ($manipulations) {
                foreach ($manipulations as $conversionName => $manipulation) {
                    $mediaItem->setCustomProperty("manipulation_{$conversionName}", $manipulation);
                }
                $mediaItem->save();
            }

            $mediaItems[] = $mediaItem;
        }

        return $mediaItems;
    }

    /**
     * Get media items from a model for a specific collection.
     */
    public function getMediaFromModel(
        Model $model,
        ?string $collection = null,
        ?string $conversion = null
    ): array {
        if (!$this->modelSupportsMedia($model)) {
            return [];
        }

        $collection = $collection ?? 'default';
        $mediaItems = $model->getMedia($collection);

        return $mediaItems->map(function (Media $media) use ($conversion) {
            $data = [
                'id' => $media->id,
                'name' => $media->name,
                'file_name' => $media->file_name,
                'mime_type' => $media->mime_type,
                'size' => $media->size,
                'collection_name' => $media->collection_name,
                'url' => $conversion ? $media->getUrl($conversion) : $media->getUrl(),
                'custom_properties' => $media->custom_properties,
                'uploaded' => true,
            ];

            // Add conversion URLs if they exist
            if ($media->hasGeneratedConversion($conversion ?? 'thumb')) {
                $data['thumb_url'] = $media->getUrl($conversion ?? 'thumb');
            }

            return $data;
        })->toArray();
    }

    /**
     * Reorder media items in a collection.
     */
    public function reorderMedia(Model $model, array $mediaIds, ?string $collection = null): bool
    {
        if (!$this->modelSupportsMedia($model)) {
            return false;
        }

        $collection = $collection ?? 'default';

        foreach ($mediaIds as $order => $mediaId) {
            $media = $model->getMedia($collection)->find($mediaId);
            if ($media) {
                $media->order_column = $order + 1;
                $media->save();
            }
        }

        return true;
    }

    /**
     * Delete media from a model.
     */
    public function deleteMedia(Model $model, int $mediaId): bool
    {
        if (!$this->modelSupportsMedia($model)) {
            return false;
        }

        $media = $model->getMedia()->find($mediaId);
        
        if ($media) {
            $media->delete();
            return true;
        }

        return false;
    }

    /**
     * Store files using standard Laravel file storage.
     */
    public function storeFiles(
        array $files,
        string $path = 'uploads',
        ?string $disk = null
    ): array {
        $storedFiles = [];
        $disk = $disk ?? config('filesystems.default');

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $filePath = $file->store($path, $disk);
            
            $storedFiles[] = [
                'id' => uniqid(),
                'name' => $file->getClientOriginalName(),
                'file_name' => basename($filePath),
                'path' => $filePath,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'disk' => $disk,
                'url' => \Storage::disk($disk)->url($filePath),
                'uploaded' => true,
            ];
        }

        return $storedFiles;
    }

    /**
     * Validate file types against accepted mime types or extensions.
     */
    public function validateFileType(UploadedFile $file, string $accept): bool
    {
        if ($accept === '*/*') {
            return true;
        }

        $acceptedTypes = array_map('trim', explode(',', $accept));
        
        foreach ($acceptedTypes as $type) {
            // Extension-based check
            if (str_starts_with($type, '.')) {
                if (str_ends_with(strtolower($file->getClientOriginalName()), strtolower($type))) {
                    return true;
                }
            }
            // Wildcard mime type check (e.g., image/*)
            elseif (str_ends_with($type, '/*')) {
                $category = str_replace('/*', '', $type);
                if (str_starts_with($file->getMimeType(), $category)) {
                    return true;
                }
            }
            // Exact mime type check
            elseif ($file->getMimeType() === $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * Format file size in human-readable format.
     */
    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = floor(log($bytes, 1024));
        
        return round($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }

    /**
     * Get file type icon based on mime type.
     */
    public function getFileTypeIcon(string $mimeType): string
    {
        return match (true) {
            str_starts_with($mimeType, 'image/') => 'heroicon-o-photo',
            $mimeType === 'application/pdf' => 'heroicon-o-document-text',
            str_contains($mimeType, 'word') => 'heroicon-o-document-text',
            str_contains($mimeType, 'spreadsheet') => 'heroicon-o-table-cells',
            str_starts_with($mimeType, 'video/') => 'heroicon-o-video-camera',
            str_starts_with($mimeType, 'audio/') => 'heroicon-o-musical-note',
            default => 'heroicon-o-document',
        };
    }
}