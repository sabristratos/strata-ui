<?php

namespace Stratos\StrataUI\View\Components;

use Illuminate\View\Component;
use Stratos\StrataUI\Data\FileData;
use Stratos\StrataUI\Services\FileService;

class FileInput extends Component
{
    public array $processedExistingFiles = [];

    public string $recommendedLayout = 'list';

    public bool $hasExistingFiles = false;

    public function __construct(
        public bool $multiple = false,
        public ?string $accept = null,
        public ?int $maxSize = null,
        public ?int $maxFiles = null,
        public string $size = 'md',
        public string $state = 'default',
        public bool $disabled = false,
        public ?string $label = null,
        public ?string $hint = null,
        public ?string $error = null,
        public string $icon = 'upload-cloud',
        public ?array $existingFiles = null,
        public ?string $onRemoveExisting = null,
        public bool $showNewUploadsSection = true,
    ) {}

    public function mount(): void
    {
        if ($this->existingFiles && is_array($this->existingFiles) && count($this->existingFiles) > 0) {
            $fileService = app(FileService::class);

            $this->processedExistingFiles = array_map(
                fn ($file) => FileData::fromArray($file),
                $this->existingFiles
            );

            $this->recommendedLayout = $fileService->recommendLayout($this->existingFiles);
            $this->hasExistingFiles = true;
        }
    }

    public function render()
    {
        return view('strata-ui::components.file-input.index');
    }
}
