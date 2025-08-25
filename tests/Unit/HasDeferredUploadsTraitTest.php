<?php

declare(strict_types=1);

use Strata\UI\Traits\HasDeferredUploads;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

// Create a test model that uses the trait
class TestModelWithUploads extends Model
{
    use HasDeferredUploads;
    
    protected $table = 'test_models';
    protected $fillable = ['name'];
}

describe('HasDeferredUploads Trait', function () {
    beforeEach(function () {
        $this->model = new TestModelWithUploads();
    });

    describe('deferred uploads management', function () {
        it('adds deferred uploads correctly', function () {
            $files = [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf'),
            ];
            
            $this->model->addDeferredUploads($files, 'avatars');
            
            $deferredUploads = $this->model->getDeferredUploads('avatars');
            expect($deferredUploads)->toHaveCount(1);
            expect($deferredUploads[0]['files'])->toHaveCount(2);
        });

        it('supports multiple collections', function () {
            $avatarFiles = [UploadedFile::fake()->image('avatar.jpg')];
            $documentFiles = [UploadedFile::fake()->create('doc.pdf', 1000, 'application/pdf')];
            
            $this->model->addDeferredUploads($avatarFiles, 'avatars');
            $this->model->addDeferredUploads($documentFiles, 'documents');
            
            expect($this->model->getDeferredUploads('avatars'))->toHaveCount(1);
            expect($this->model->getDeferredUploads('documents'))->toHaveCount(1);
            expect($this->model->getDeferredUploads())->toHaveKeys(['avatars', 'documents']);
        });

        it('adds uploads with custom properties', function () {
            $files = [UploadedFile::fake()->image('image1.jpg')];
            $customProperties = ['alt' => 'Test image'];
            $manipulations = ['thumb' => ['width' => 150]];
            
            $this->model->addDeferredUploads(
                $files,
                'gallery',
                $customProperties,
                $manipulations,
                's3',
                true
            );
            
            $uploads = $this->model->getDeferredUploads('gallery');
            expect($uploads[0])->toMatchArray([
                'custom_properties' => $customProperties,
                'manipulations' => $manipulations,
                'conversions_disk' => 's3',
                'responsive_images' => true,
            ]);
        });

        it('clears deferred uploads', function () {
            $files = [UploadedFile::fake()->image('image1.jpg')];
            
            $this->model->addDeferredUploads($files, 'avatars');
            $this->model->addDeferredUploads($files, 'documents');
            
            expect($this->model->getDeferredUploads())->toHaveKeys(['avatars', 'documents']);
            
            // Clear specific collection
            $this->model->clearDeferredUploads('avatars');
            expect($this->model->getDeferredUploads())->toHaveKeys(['documents']);
            expect($this->model->getDeferredUploads('avatars'))->toBeEmpty();
            
            // Clear all
            $this->model->clearDeferredUploads();
            expect($this->model->getDeferredUploads())->toBeEmpty();
        });
    });

    describe('file upload handling', function () {
        it('handles single file upload', function () {
            $file = UploadedFile::fake()->image('avatar.jpg');
            
            $this->model->handleFileUploads('avatar', $file);
            
            $uploads = $this->model->getDeferredUploads('avatar');
            expect($uploads)->toHaveCount(1);
            expect($uploads[0]['files'])->toHaveCount(1);
            expect($uploads[0]['files'][0])->toBe($file);
        });

        it('handles multiple file uploads', function () {
            $files = [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->image('image2.jpg'),
            ];
            
            $this->model->handleFileUploads('gallery', $files);
            
            $uploads = $this->model->getDeferredUploads('gallery');
            expect($uploads)->toHaveCount(1);
            expect($uploads[0]['files'])->toHaveCount(2);
        });

        it('filters out non-file objects', function () {
            $mixed = [
                UploadedFile::fake()->image('image1.jpg'),
                'not-a-file',
                null,
                UploadedFile::fake()->image('image2.jpg'),
            ];
            
            $this->model->handleFileUploads('mixed', $mixed);
            
            $uploads = $this->model->getDeferredUploads('mixed');
            expect($uploads)->toHaveCount(1);
            expect($uploads[0]['files'])->toHaveCount(2);
        });

        it('ignores empty file inputs', function () {
            $this->model->handleFileUploads('empty', null);
            $this->model->handleFileUploads('empty-array', []);
            $this->model->handleFileUploads('empty-string', '');
            
            expect($this->model->getDeferredUploads())->toBeEmpty();
        });

        it('accepts upload options', function () {
            $file = UploadedFile::fake()->image('avatar.jpg');
            $options = [
                'custom_properties' => ['alt' => 'Avatar'],
                'manipulations' => ['thumb' => ['width' => 100]],
                'conversions_disk' => 's3',
                'responsive_images' => true,
            ];
            
            $this->model->handleFileUploads('avatar', $file, 'avatars', $options);
            
            $uploads = $this->model->getDeferredUploads('avatars');
            expect($uploads[0])->toMatchArray([
                'custom_properties' => $options['custom_properties'],
                'manipulations' => $options['manipulations'],
                'conversions_disk' => $options['conversions_disk'],
                'responsive_images' => $options['responsive_images'],
            ]);
        });
    });

    describe('default collection handling', function () {
        it('uses field name as collection when not specified', function () {
            $file = UploadedFile::fake()->image('image.jpg');
            
            $this->model->handleFileUploads('profile_picture', $file);
            
            expect($this->model->getDeferredUploads('profile_picture'))->toHaveCount(1);
        });

        it('uses default collection when not specified in addDeferredUploads', function () {
            $files = [UploadedFile::fake()->image('image.jpg')];
            
            $this->model->addDeferredUploads($files);
            
            expect($this->model->getDeferredUploads('default'))->toHaveCount(1);
        });
    });
});