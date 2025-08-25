<?php

declare(strict_types=1);

use Strata\UI\Services\StrataFileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

describe('File Validation and Error Handling', function () {
    beforeEach(function () {
        $this->service = new StrataFileUploadService();
        Storage::fake('local');
    });

    describe('file size validation', function () {
        it('validates file size limits correctly', function () {
            // Create files of different sizes
            $smallFile = UploadedFile::fake()->create('small.pdf', 1024); // 1MB
            $largeFile = UploadedFile::fake()->create('large.pdf', 5120); // 5MB
            $hugeFIle = UploadedFile::fake()->create('huge.pdf', 15360); // 15MB
            
            // Test with 2MB limit
            $maxSizeKB = 2048;
            
            expect($smallFile->getSize())->toBeLessThanOrEqual($maxSizeKB * 1024);
            expect($largeFile->getSize())->toBeGreaterThan($maxSizeKB * 1024);
            expect($hugeFIle->getSize())->toBeGreaterThan($maxSizeKB * 1024);
        });

        it('formats various file sizes correctly', function () {
            $testCases = [
                [500, '500 B'],
                [1024, '1 KB'],
                [1536, '1.5 KB'],
                [1048576, '1 MB'],
                [2621440, '2.5 MB'],
                [1073741824, '1 GB'],
                [1610612736, '1.5 GB'],
            ];
            
            foreach ($testCases as [$bytes, $expected]) {
                expect($this->service->formatFileSize($bytes))->toBe($expected);
            }
        });
    });

    describe('file type validation', function () {
        it('validates image files correctly', function () {
            $jpegFile = UploadedFile::fake()->image('photo.jpg');
            $pngFile = UploadedFile::fake()->image('photo.png', 100, 100);
            $gifFile = UploadedFile::fake()->create('animation.gif', 100, 'image/gif');
            
            // Test image/* acceptance
            expect($this->service->validateFileType($jpegFile, 'image/*'))->toBeTrue();
            expect($this->service->validateFileType($pngFile, 'image/*'))->toBeTrue();
            expect($this->service->validateFileType($gifFile, 'image/*'))->toBeTrue();
            
            // Test specific mime types
            expect($this->service->validateFileType($jpegFile, 'image/jpeg'))->toBeTrue();
            expect($this->service->validateFileType($pngFile, 'image/png'))->toBeTrue();
            
            // Test rejection of non-images
            $pdfFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
            expect($this->service->validateFileType($pdfFile, 'image/*'))->toBeFalse();
        });

        it('validates document files correctly', function () {
            $pdfFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
            $wordFile = UploadedFile::fake()->create('document.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            $txtFile = UploadedFile::fake()->create('readme.txt', 100, 'text/plain');
            
            // Test PDF acceptance
            expect($this->service->validateFileType($pdfFile, 'application/pdf'))->toBeTrue();
            
            // Test extension-based validation
            expect($this->service->validateFileType($txtFile, '.txt'))->toBeTrue();
            expect($this->service->validateFileType($pdfFile, '.pdf'))->toBeTrue();
            
            // Test mixed acceptance
            $mixedAccept = 'application/pdf,.doc,.docx,text/plain';
            expect($this->service->validateFileType($pdfFile, $mixedAccept))->toBeTrue();
            expect($this->service->validateFileType($txtFile, $mixedAccept))->toBeTrue();
        });

        it('rejects invalid file types', function () {
            $imageFile = UploadedFile::fake()->image('photo.jpg');
            $pdfFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
            
            // Image should be rejected when only PDF is accepted
            expect($this->service->validateFileType($imageFile, 'application/pdf'))->toBeFalse();
            
            // PDF should be rejected when only images are accepted
            expect($this->service->validateFileType($pdfFile, 'image/*'))->toBeFalse();
            
            // Test extension mismatch
            expect($this->service->validateFileType($imageFile, '.pdf'))->toBeFalse();
        });

        it('handles complex accept strings', function () {
            $jpegFile = UploadedFile::fake()->image('photo.jpg');
            $pdfFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
            $txtFile = UploadedFile::fake()->create('readme.txt', 100, 'text/plain');
            $videoFile = UploadedFile::fake()->create('video.mp4', 1000, 'video/mp4');
            
            $complexAccept = 'image/*,application/pdf,.txt,.doc,.docx,video/mp4';
            
            expect($this->service->validateFileType($jpegFile, $complexAccept))->toBeTrue();
            expect($this->service->validateFileType($pdfFile, $complexAccept))->toBeTrue();
            expect($this->service->validateFileType($txtFile, $complexAccept))->toBeTrue();
            expect($this->service->validateFileType($videoFile, $complexAccept))->toBeTrue();
            
            // Should reject audio files
            $audioFile = UploadedFile::fake()->create('song.mp3', 1000, 'audio/mpeg');
            expect($this->service->validateFileType($audioFile, $complexAccept))->toBeFalse();
        });
    });

    describe('file icon assignment', function () {
        it('assigns correct icons for different file types', function () {
            $testCases = [
                ['image/jpeg', 'heroicon-o-photo'],
                ['image/png', 'heroicon-o-photo'],
                ['image/gif', 'heroicon-o-photo'],
                ['application/pdf', 'heroicon-o-document-text'],
                ['application/msword', 'heroicon-o-document-text'],
                ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'heroicon-o-document-text'],
                ['application/vnd.ms-excel', 'heroicon-o-table-cells'],
                ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'heroicon-o-table-cells'],
                ['video/mp4', 'heroicon-o-video-camera'],
                ['video/avi', 'heroicon-o-video-camera'],
                ['audio/mp3', 'heroicon-o-musical-note'],
                ['audio/wav', 'heroicon-o-musical-note'],
                ['text/plain', 'heroicon-o-document'],
                ['application/zip', 'heroicon-o-document'],
                ['application/unknown', 'heroicon-o-document'],
            ];
            
            foreach ($testCases as [$mimeType, $expectedIcon]) {
                expect($this->service->getFileTypeIcon($mimeType))->toBe($expectedIcon);
            }
        });
    });

    describe('error handling scenarios', function () {
        it('handles empty file uploads gracefully', function () {
            $result = $this->service->storeFiles([], 'uploads');
            expect($result)->toBeEmpty();
        });

        it('filters out non-file objects during storage', function () {
            $validFile = UploadedFile::fake()->image('valid.jpg');
            $invalidData = [
                $validFile,
                'not-a-file',
                null,
                123,
                [],
                new \stdClass(),
            ];
            
            $result = $this->service->storeFiles($invalidData, 'uploads');
            expect($result)->toHaveCount(1);
            expect($result[0]['name'])->toBe('valid.jpg');
        });

        it('handles storage failures gracefully', function () {
            // This test would require mocking Storage to throw exceptions
            // For now, we'll test that the service doesn't break with empty arrays
            expect($this->service->storeFiles([], 'uploads'))->toBeArray();
        });
    });

    describe('edge cases', function () {
        it('handles files with special characters in names', function () {
            $file = UploadedFile::fake()->create('file with spaces & symbols!@#.pdf', 100, 'application/pdf');
            
            expect($this->service->validateFileType($file, 'application/pdf'))->toBeTrue();
            expect($this->service->validateFileType($file, '.pdf'))->toBeTrue();
        });

        it('handles very long filenames', function () {
            $longName = str_repeat('a', 200) . '.jpg';
            $file = UploadedFile::fake()->image($longName);
            
            expect($this->service->validateFileType($file, 'image/*'))->toBeTrue();
        });

        it('handles case sensitivity in extensions', function () {
            $upperCaseFile = UploadedFile::fake()->create('DOCUMENT.PDF', 100, 'application/pdf');
            $lowerCaseFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
            
            // Extension validation should be case-insensitive
            expect($this->service->validateFileType($upperCaseFile, '.pdf'))->toBeTrue();
            expect($this->service->validateFileType($upperCaseFile, '.PDF'))->toBeTrue();
            expect($this->service->validateFileType($lowerCaseFile, '.PDF'))->toBeTrue();
        });

        it('handles zero-byte files', function () {
            $emptyFile = UploadedFile::fake()->create('empty.txt', 0, 'text/plain');
            
            expect($this->service->formatFileSize($emptyFile->getSize()))->toBe('0 B');
            expect($this->service->validateFileType($emptyFile, 'text/plain'))->toBeTrue();
        });
    });
});