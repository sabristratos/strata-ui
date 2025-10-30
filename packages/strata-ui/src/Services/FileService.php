<?php

namespace Stratos\StrataUI\Services;

use Stratos\StrataUI\Enums\FileCategory;

class FileService
{
    public function detectFileCategory(string $mimeType): FileCategory
    {
        return FileCategory::fromMimeType($mimeType);
    }

    public function isImage(string $mimeType): bool
    {
        return str_starts_with($mimeType, 'image/');
    }

    public function recommendLayout(array $files): string
    {
        if (empty($files)) {
            return 'list';
        }

        $imageCount = 0;
        $totalCount = count($files);

        foreach ($files as $file) {
            $mimeType = $file['type'] ?? $file['mimeType'] ?? '';
            if ($this->isImage($mimeType)) {
                $imageCount++;
            }
        }

        return ($imageCount / $totalCount) >= 0.7 ? 'grid' : 'list';
    }

    public function formatFileSize(int $bytes): string
    {
        if ($bytes === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = floor(log($bytes, 1024));
        $size = $bytes / pow(1024, $power);

        return round($size, 2).' '.$units[$power];
    }

    public function getIconForMimeType(string $mimeType): string
    {
        $category = $this->detectFileCategory($mimeType);

        return match ($category) {
            FileCategory::Image => 'image',
            FileCategory::Video => 'video',
            FileCategory::Audio => 'music',
            FileCategory::Archive => 'archive',
            FileCategory::Document => $this->getDocumentIcon($mimeType),
            default => 'file',
        };
    }

    protected function getDocumentIcon(string $mimeType): string
    {
        return match ($mimeType) {
            'application/pdf' => 'file-text',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'file-text',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'file-spreadsheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'presentation',
            default => 'file-text',
        };
    }

    public function getExtensionBadgeColor(string $extension): string
    {
        $extension = strtolower(ltrim($extension, '.'));

        return match ($extension) {
            'pdf' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
            'doc', 'docx' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            'xls', 'xlsx' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
            'ppt', 'pptx' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg' => 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400',
            'mp4', 'mov', 'avi', 'webm' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
            'mp3', 'wav', 'ogg' => 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400',
            'zip', 'rar', '7z', 'tar', 'gz' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
            default => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
        };
    }

    public function getExtensionFromFilename(string $filename): string
    {
        $parts = explode('.', $filename);

        return count($parts) > 1 ? strtoupper(end($parts)) : '';
    }
}
