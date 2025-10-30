<?php

namespace Stratos\StrataUI\View\Components;

use Illuminate\View\Component;
use Stratos\StrataUI\Services\FileService;

class FileInputItem extends Component
{
    public string $extension = '';

    public string $badgeColor = '';

    public string $icon = 'file';

    public function __construct(
        public string $fileName = '',
        public string $fileSize = '',
        public ?string $fileType = null,
        public ?string $preview = null,
        public ?string $onRemove = null,
        public bool $showBadge = true,
    ) {}

    public function mount(): void
    {
        $fileService = app(FileService::class);

        $this->extension = $fileService->getExtensionFromFilename($this->fileName);

        if ($this->fileType) {
            $this->badgeColor = $fileService->getExtensionBadgeColor($this->extension);
            $this->icon = $fileService->getIconForMimeType($this->fileType);
        } else {
            $this->badgeColor = $fileService->getExtensionBadgeColor($this->extension);
            $this->icon = 'file';
        }
    }

    public function render()
    {
        return view('strata-ui::components.file-input.item');
    }
}
