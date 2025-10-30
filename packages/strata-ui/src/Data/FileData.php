<?php

namespace Stratos\StrataUI\Data;

use Illuminate\Http\UploadedFile;
use Stratos\StrataUI\Enums\FileCategory;
use Stratos\StrataUI\Services\FileService;

class FileData
{
    protected FileService $fileService;

    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly int $size,
        public readonly string $url,
        public readonly string $mimeType,
        public readonly string $extension,
    ) {
        $this->fileService = app(FileService::class);
    }

    public function isImage(): bool
    {
        return $this->fileService->isImage($this->mimeType);
    }

    public function sizeFormatted(): string
    {
        return $this->fileService->formatFileSize($this->size);
    }

    public function getCategory(): FileCategory
    {
        return $this->fileService->detectFileCategory($this->mimeType);
    }

    public function getIconName(): string
    {
        return $this->fileService->getIconForMimeType($this->mimeType);
    }

    public function getBadgeColor(): string
    {
        return $this->fileService->getExtensionBadgeColor($this->extension);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'size' => $this->size,
            'sizeFormatted' => $this->sizeFormatted(),
            'url' => $this->url,
            'mimeType' => $this->mimeType,
            'extension' => $this->extension,
            'isImage' => $this->isImage(),
            'category' => $this->getCategory()->value,
            'iconName' => $this->getIconName(),
            'badgeColor' => $this->getBadgeColor(),
        ];
    }

    public static function fromArray(array $data): self
    {
        $fileService = app(FileService::class);

        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? 'Unknown',
            size: $data['size'] ?? 0,
            url: $data['url'] ?? '',
            mimeType: $data['type'] ?? $data['mimeType'] ?? 'application/octet-stream',
            extension: $data['extension'] ?? $fileService->getExtensionFromFilename($data['name'] ?? ''),
        );
    }

    public static function fromUploadedFile(UploadedFile $file, ?int $id = null): self
    {
        $fileService = app(FileService::class);

        return new self(
            id: $id,
            name: $file->getClientOriginalName(),
            size: $file->getSize(),
            url: $file->temporaryUrl() ?? '',
            mimeType: $file->getMimeType() ?? 'application/octet-stream',
            extension: $fileService->getExtensionFromFilename($file->getClientOriginalName()),
        );
    }
}
