<?php

declare(strict_types=1);

use Strata\UI\View\Components\Form\FileUpload;
use Illuminate\View\ComponentAttributeBag;

describe('FileUpload Component', function () {
    it('creates component with default values', function () {
        $component = new FileUpload();
        
        expect($component->multiple)->toBeFalse()
            ->and($component->accept)->toBe('image/*,application/pdf,.doc,.docx,.txt')
            ->and($component->maxSize)->toBe(12288)
            ->and($component->mediaLibrary)->toBeFalse()
            ->and($component->showPreview)->toBeTrue()
            ->and($component->variant)->toBe('default');
    });

    it('creates component with custom values', function () {
        $component = new FileUpload(
            name: 'attachments',
            multiple: true,
            accept: 'image/*',
            maxSize: 5120,
            mediaLibrary: true,
            variant: 'gallery'
        );
        
        expect($component->name)->toBe('attachments')
            ->and($component->multiple)->toBeTrue()
            ->and($component->accept)->toBe('image/*')
            ->and($component->maxSize)->toBe(5120)
            ->and($component->mediaLibrary)->toBeTrue()
            ->and($component->variant)->toBe('gallery');
    });

    it('formats max size correctly', function () {
        $component = new FileUpload(maxSize: 1024);
        expect($component->getMaxSizeFormatted())->toBe('1.00 MB');
        
        $component = new FileUpload(maxSize: 1536);
        expect($component->getMaxSizeFormatted())->toBe('1.50 MB');
        
        $component = new FileUpload(maxSize: 1048576);
        expect($component->getMaxSizeFormatted())->toBe('1.00 GB');
        
        $component = new FileUpload(maxSize: 512);
        expect($component->getMaxSizeFormatted())->toBe('512.00 KB');
    });

    it('sets default placeholder based on multiple setting', function () {
        $singleComponent = new FileUpload(multiple: false);
        expect($singleComponent->placeholder)->toBe('Drop file here or click to browse');
        
        $multipleComponent = new FileUpload(multiple: true);
        expect($multipleComponent->placeholder)->toBe('Drop files here or click to browse');
    });

    it('uses custom placeholder when provided', function () {
        $component = new FileUpload(
            multiple: true,
            placeholder: 'Custom upload message'
        );
        
        expect($component->placeholder)->toBe('Custom upload message');
    });

    it('checks media library availability', function () {
        $component = new FileUpload(mediaLibrary: true);
        
        // This will depend on whether Spatie Media Library is installed
        // In a real environment, this would check for the interface and class existence
        expect($component->isMediaLibraryAvailable())->toBeBool();
    });

    it('returns correct variant classes', function () {
        $defaultComponent = new FileUpload(variant: 'default');
        expect($defaultComponent->getVariantClasses())
            ->toBe('border-2 border-dashed border-border rounded-lg p-8');
        
        $compactComponent = new FileUpload(variant: 'compact');
        expect($compactComponent->getVariantClasses())
            ->toBe('border border-dashed border-border rounded-md p-4');
        
        $galleryComponent = new FileUpload(variant: 'gallery');
        expect($galleryComponent->getVariantClasses())
            ->toBe('grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4');
    });

    it('renders correct view', function () {
        $component = new FileUpload();
        $view = $component->render();
        
        expect($view->name())->toBe('strata::components.form.file-upload');
    });

    it('handles optional properties correctly', function () {
        $component = new FileUpload(
            collection: 'avatars',
            customProperties: ['alt' => 'User avatar'],
            manipulations: ['thumb' => ['width' => 150]],
            conversion: 'thumb',
            responsiveImages: true,
            conversionsDisk: 's3'
        );
        
        expect($component->collection)->toBe('avatars')
            ->and($component->customProperties)->toBe(['alt' => 'User avatar'])
            ->and($component->manipulations)->toBe(['thumb' => ['width' => 150]])
            ->and($component->conversion)->toBe('thumb')
            ->and($component->responsiveImages)->toBeTrue()
            ->and($component->conversionsDisk)->toBe('s3');
    });
});