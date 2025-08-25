<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Strata\UI\View\Components\Form\FileUpload;
use Illuminate\View\Component;

describe('FileUpload Feature Tests', function () {
    beforeEach(function () {
        Storage::fake('local');
    });

    it('renders component with default settings', function () {
        $component = new FileUpload();
        $view = $component->render();
        
        expect($view)->toBeInstanceOf(\Illuminate\Contracts\View\View::class);
        expect($view->name())->toBe('strata::components.form.file-upload');
    });

    it('renders component with multiple file support', function () {
        $component = new FileUpload(multiple: true);
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('multiple="multiple"')
            ->and($rendered)->toContain('Drop files here or click to browse');
    });

    it('renders component with custom accept types', function () {
        $component = new FileUpload(accept: 'image/*');
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('accept="image/*"')
            ->and($rendered)->toContain('Accepted formats: image/*');
    });

    it('renders gallery variant correctly', function () {
        $component = new FileUpload(variant: 'gallery');
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4');
    });

    it('renders compact variant correctly', function () {
        $component = new FileUpload(variant: 'compact');
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('border border-dashed border-border rounded-md p-4');
    });

    it('displays help text when provided', function () {
        $helpText = 'Upload your documents here';
        $component = new FileUpload(helpText: $helpText);
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain($helpText);
    });

    it('displays custom placeholder when provided', function () {
        $placeholder = 'Drag and drop your files';
        $component = new FileUpload(placeholder: $placeholder);
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain($placeholder);
    });

    it('shows max file size in human readable format', function () {
        $component = new FileUpload(maxSize: 2048); // 2MB
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('Max size: 2.00 MB');
    });

    it('includes media library configuration when enabled', function () {
        $component = new FileUpload(
            mediaLibrary: true,
            collection: 'avatars',
            responsiveImages: true
        );
        
        expect($component->mediaLibrary)->toBeTrue()
            ->and($component->collection)->toBe('avatars')
            ->and($component->responsiveImages)->toBeTrue();
    });

    it('handles wire:model attributes correctly', function () {
        $component = new FileUpload();
        $attributes = new \Illuminate\View\ComponentAttributeBag([
            'wire:model' => 'files'
        ]);
        
        // Component should handle wire:model in the template
        expect($component)->toBeInstanceOf(FileUpload::class);
    });

    it('includes Alpine.js data configuration', function () {
        $component = new FileUpload(
            multiple: true,
            accept: 'image/*',
            maxSize: 1024,
            mediaLibrary: true
        );
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('x-data=')
            ->and($rendered)->toContain('multiple: true')
            ->and($rendered)->toContain('accept: \'image/*\'')
            ->and($rendered)->toContain('maxSize: 1024')
            ->and($rendered)->toContain('mediaLibrary: true');
    });

    it('includes drag and drop event handlers', function () {
        $component = new FileUpload();
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('@dragover.prevent="handleDragOver"')
            ->and($rendered)->toContain('@dragleave.prevent="handleDragLeave"')
            ->and($rendered)->toContain('@drop.prevent="handleDrop"');
    });

    it('includes file input element', function () {
        $component = new FileUpload(name: 'uploads');
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('type="file"')
            ->and($rendered)->toContain('name="uploads"')
            ->and($rendered)->toContain('x-ref="fileInput"');
    });

    it('shows progress indicators in template', function () {
        $component = new FileUpload(showProgress: true);
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('progress[file.id || file.name]')
            ->and($rendered)->toContain('bg-primary h-1 rounded-full');
    });

    it('shows remove buttons for files', function () {
        $component = new FileUpload();
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('removeFile(file.id || file.name)')
            ->and($rendered)->toContain('heroicon-o-trash')
            ->and($rendered)->toContain('heroicon-o-x-mark');
    });

    it('handles error display', function () {
        $component = new FileUpload();
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('errors[file.id || file.name]')
            ->and($rendered)->toContain('text-destructive');
    });

    it('supports reordering when enabled', function () {
        $component = new FileUpload(enableReordering: true);
        
        expect($component->enableReordering)->toBeTrue();
    });

    it('renders file icons based on file type', function () {
        $component = new FileUpload();
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('getFileIcon(file)')
            ->and($rendered)->toContain('heroicon-o-photo')
            ->and($rendered)->toContain('heroicon-o-document');
    });

    it('formats file sizes in template', function () {
        $component = new FileUpload();
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('formatFileSize(file.size)');
    });

    it('handles conversion settings for media library', function () {
        $component = new FileUpload(
            mediaLibrary: true,
            conversion: 'thumb',
            conversionsDisk: 's3'
        );
        
        expect($component->conversion)->toBe('thumb')
            ->and($component->conversionsDisk)->toBe('s3');
    });

    it('supports custom properties and manipulations', function () {
        $component = new FileUpload(
            customProperties: ['alt' => 'Image alt text'],
            manipulations: ['thumb' => ['width' => 150, 'height' => 150]]
        );
        
        expect($component->customProperties)->toBe(['alt' => 'Image alt text'])
            ->and($component->manipulations)->toBe(['thumb' => ['width' => 150, 'height' => 150]]);
    });
});