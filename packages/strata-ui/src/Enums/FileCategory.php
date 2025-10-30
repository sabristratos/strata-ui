<?php

namespace Stratos\StrataUI\Enums;

enum FileCategory: string
{
    case Image = 'image';
    case Document = 'document';
    case Video = 'video';
    case Audio = 'audio';
    case Archive = 'archive';
    case Other = 'other';

    public static function fromMimeType(string $mimeType): self
    {
        return match (true) {
            str_starts_with($mimeType, 'image/') => self::Image,
            str_starts_with($mimeType, 'video/') => self::Video,
            str_starts_with($mimeType, 'audio/') => self::Audio,
            in_array($mimeType, [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'text/plain',
                'application/rtf',
            ]) => self::Document,
            in_array($mimeType, [
                'application/zip',
                'application/x-rar-compressed',
                'application/x-7z-compressed',
                'application/x-tar',
                'application/gzip',
            ]) => self::Archive,
            default => self::Other,
        };
    }

    public function getDefaultIcon(): string
    {
        return match ($this) {
            self::Image => 'image',
            self::Document => 'file-text',
            self::Video => 'video',
            self::Audio => 'music',
            self::Archive => 'archive',
            self::Other => 'file',
        };
    }

    public function getRecommendedLayout(): string
    {
        return match ($this) {
            self::Image => 'grid',
            default => 'list',
        };
    }
}
