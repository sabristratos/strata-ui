<?php

declare(strict_types=1);

use Strata\UI\Services\StrataFileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

describe('StrataFileUploadService', function () {
    beforeEach(function () {
        $this->service = new StrataFileUploadService();
    });

    describe('file validation', function () {
        it('validates file types correctly', function () {
            $jpegFile = UploadedFile::fake()->image('test.jpg');
            $pdfFile = UploadedFile::fake()->create('test.pdf', 1000, 'application/pdf');
            $txtFile = UploadedFile::fake()->create('test.txt', 100, 'text/plain');
            
            // Test wildcard image acceptance
            expect($this->service->validateFileType($jpegFile, 'image/*'))->toBeTrue();
            
            // Test specific mime type
            expect($this->service->validateFileType($pdfFile, 'application/pdf'))->toBeTrue();
            
            // Test extension-based validation
            expect($this->service->validateFileType($txtFile, '.txt'))->toBeTrue();
            
            // Test rejection
            expect($this->service->validateFileType($txtFile, 'image/*'))->toBeFalse();
            expect($this->service->validateFileType($jpegFile, 'application/pdf'))->toBeFalse();
        });

        it('accepts all files with wildcard', function () {
            $file = UploadedFile::fake()->image('test.jpg');
            expect($this->service->validateFileType($file, '*/*'))->toBeTrue();
        });

        it('validates multiple accept types', function () {
            $jpegFile = UploadedFile::fake()->image('test.jpg');
            $pdfFile = UploadedFile::fake()->create('test.pdf', 1000, 'application/pdf');
            
            $accept = 'image/*,application/pdf,.txt';
            
            expect($this->service->validateFileType($jpegFile, $accept))->toBeTrue();
            expect($this->service->validateFileType($pdfFile, $accept))->toBeTrue();
        });
    });

    describe('file size formatting', function () {
        it('formats bytes correctly', function () {
            expect($this->service->formatFileSize(0))->toBe('0 B');
            expect($this->service->formatFileSize(1024))->toBe('1 KB');
            expect($this->service->formatFileSize(1048576))->toBe('1 MB');
            expect($this->service->formatFileSize(1073741824))->toBe('1 GB');
            expect($this->service->formatFileSize(1536))->toBe('1.5 KB');
            expect($this->service->formatFileSize(2621440))->toBe('2.5 MB');
        });
    });

    describe('file type icons', function () {
        it('returns correct icons for different file types', function () {
            expect($this->service->getFileTypeIcon('image/jpeg'))
                ->toBe('heroicon-o-photo');
                
            expect($this->service->getFileTypeIcon('application/pdf'))
                ->toBe('heroicon-o-document-text');
                
            expect($this->service->getFileTypeIcon('video/mp4'))
                ->toBe('heroicon-o-video-camera');
                
            expect($this->service->getFileTypeIcon('audio/mp3'))
                ->toBe('heroicon-o-musical-note');
                
            expect($this->service->getFileTypeIcon('application/vnd.ms-word'))
                ->toBe('heroicon-o-document-text');
                
            expect($this->service->getFileTypeIcon('application/vnd.ms-excel'))
                ->toBe('heroicon-o-table-cells');
                
            expect($this->service->getFileTypeIcon('application/unknown'))
                ->toBe('heroicon-o-document');
        });
    });

    describe('standard file storage', function () {
        beforeEach(function () {
            Storage::fake('local');
        });

        it('stores files using Laravel storage', function () {
            $files = [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf'),
            ];
            
            $storedFiles = $this->service->storeFiles($files, 'test-uploads');
            
            expect($storedFiles)->toHaveCount(2);
            
            foreach ($storedFiles as $storedFile) {
                expect($storedFile)->toHaveKeys([
                    'id', 'name', 'file_name', 'path', 
                    'mime_type', 'size', 'disk', 'url', 'uploaded'
                ]);
                expect($storedFile['uploaded'])->toBeTrue();
                expect($storedFile['disk'])->toBe('local');
            }
        });

        it('filters out non-file objects', function () {
            $files = [
                UploadedFile::fake()->image('image1.jpg'),
                'not-a-file',
                null,
                UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf'),
            ];
            
            $storedFiles = $this->service->storeFiles($files, 'test-uploads');
            
            expect($storedFiles)->toHaveCount(2);
        });
    });

    describe('media library availability', function () {
        it('checks for media library classes and interfaces', function () {
            $available = $this->service->isMediaLibraryAvailable();
            expect($available)->toBeBool();
        });
    });
});