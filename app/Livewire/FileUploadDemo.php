<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUploadDemo extends Component
{
    use WithFileUploads;

    public $avatar;

    public $documents = [];

    public $images = [];

    public $singleFile;

    public $multipleFiles = [];

    public $limitedFiles = [];

    public $validatedFiles = [];

    public $progressFiles = [];

    public string $message = '';

    public string $validationError = '';

    public array $existingImages = [];

    public array $existingDocuments = [];

    public function mount(): void
    {
        $this->message = '';
        $this->validationError = '';

        $this->existingImages = [
            [
                'id' => 1,
                'name' => 'photo-1761405378543.avif',
                'size' => 176829,
                'url' => '/photo-1761405378543-e74453424152.avif',
                'type' => 'image/avif',
            ],
            [
                'id' => 2,
                'name' => 'photo-1761578571404.avif',
                'size' => 81758,
                'url' => '/photo-1761578571404-f7e0fa2ff634.avif',
                'type' => 'image/avif',
            ],
            [
                'id' => 3,
                'name' => 'photo-1761582286153.avif',
                'size' => 92645,
                'url' => '/photo-1761582286153-03b935a8a41e.avif',
                'type' => 'image/avif',
            ],
        ];

        $this->existingDocuments = [
            [
                'id' => 4,
                'name' => 'report.pdf',
                'size' => 5120000,
                'url' => '/storage/documents/report.pdf',
                'type' => 'application/pdf',
            ],
            [
                'id' => 5,
                'name' => 'presentation.pptx',
                'size' => 3072000,
                'url' => '/storage/documents/presentation.pptx',
                'type' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            ],
        ];
    }

    public function updatedAvatar(): void
    {
        $this->validate([
            'avatar' => 'image|max:2048',
        ]);
    }

    public function updatedImages(): void
    {
        $this->validate([
            'images.*' => 'image|max:2048',
        ]);
    }

    public function updatedDocuments(): void
    {
        $this->validate([
            'documents.*' => 'mimes:pdf,doc,docx|max:5120',
        ]);
    }

    public function updatedValidatedFiles(): void
    {
        $this->validationError = '';

        try {
            $this->validate([
                'validatedFiles.*' => 'required|mimes:pdf|max:1024',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->validationError = $e->validator->errors()->first();
        }
    }

    public function removeDocument(int $index): void
    {
        array_splice($this->documents, $index, 1);
    }

    public function removeImage(int $index): void
    {
        array_splice($this->images, $index, 1);
    }

    public function removeMultipleFile(int $index): void
    {
        array_splice($this->multipleFiles, $index, 1);
    }

    public function removeLimitedFile(int $index): void
    {
        array_splice($this->limitedFiles, $index, 1);
    }

    public function removeValidatedFile(int $index): void
    {
        array_splice($this->validatedFiles, $index, 1);
    }

    public function removeProgressFile(int $index): void
    {
        array_splice($this->progressFiles, $index, 1);
    }

    public function clearAvatar(): void
    {
        $this->avatar = null;
    }

    public function clearAllDocuments(): void
    {
        $this->documents = [];
    }

    public function clearAllImages(): void
    {
        $this->images = [];
    }

    public function clearAllMultipleFiles(): void
    {
        $this->multipleFiles = [];
    }

    public function clearAllLimitedFiles(): void
    {
        $this->limitedFiles = [];
    }

    public function clearAllValidatedFiles(): void
    {
        $this->validatedFiles = [];
        $this->validationError = '';
    }

    public function clearAllProgressFiles(): void
    {
        $this->progressFiles = [];
    }

    public function removeExistingImage(int $id): void
    {
        $this->existingImages = array_filter(
            $this->existingImages,
            fn ($file) => $file['id'] !== $id
        );
    }

    public function removeExistingDocument(int $id): void
    {
        $this->existingDocuments = array_filter(
            $this->existingDocuments,
            fn ($file) => $file['id'] !== $id
        );
    }

    public function submit(): void
    {
        $this->validate([
            'documents.*' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $documentCount = is_countable($this->documents) ? count($this->documents) : 0;
        $imageCount = is_countable($this->images) ? count($this->images) : 0;

        $this->message = "Form submitted! Documents: {$documentCount}, Images: {$imageCount}";
    }

    public function render()
    {
        return view('livewire.file-upload-demo');
    }
}
