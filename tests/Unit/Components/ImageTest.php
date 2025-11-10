<?php

use Stratos\StrataUI\View\Components\Image;

describe('Image Component', function () {
    it('requires alt text when not decorative', function () {
        expect(function () {
            $component = new Image(src: 'test.jpg');
            $component->mount();
        })->toThrow(InvalidArgumentException::class, 'The "alt" attribute is required');
    });

    it('allows decorative images without alt text', function () {
        $component = new Image(
            src: 'test.jpg',
            decorative: true
        );
        $component->mount();

        expect($component->alt)->toBe('');
    });

    it('clears alt text when decorative is true', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Some alt text',
            decorative: true
        );
        $component->mount();

        expect($component->alt)->toBe('');
    });

    it('validates loading mode', function () {
        expect(function () {
            $component = new Image(
                src: 'test.jpg',
                alt: 'Test',
                loading: 'invalid'
            );
            $component->mount();
        })->toThrow(InvalidArgumentException::class, 'Invalid loading value');
    });

    it('validates object fit', function () {
        expect(function () {
            $component = new Image(
                src: 'test.jpg',
                alt: 'Test',
                objectFit: 'invalid'
            );
            $component->mount();
        })->toThrow(InvalidArgumentException::class, 'Invalid objectFit value');
    });

    it('validates object position', function () {
        expect(function () {
            $component = new Image(
                src: 'test.jpg',
                alt: 'Test',
                objectPosition: 'invalid'
            );
            $component->mount();
        })->toThrow(InvalidArgumentException::class, 'Invalid objectPosition value');
    });

    it('validates placeholder type', function () {
        expect(function () {
            $component = new Image(
                src: 'test.jpg',
                alt: 'Test',
                placeholderType: 'invalid'
            );
            $component->mount();
        })->toThrow(InvalidArgumentException::class, 'Invalid placeholderType value');
    });

    it('validates caption position', function () {
        expect(function () {
            $component = new Image(
                src: 'test.jpg',
                alt: 'Test',
                captionPosition: 'invalid'
            );
            $component->mount();
        })->toThrow(InvalidArgumentException::class, 'Invalid captionPosition value');
    });

    it('returns correct aspect ratio for presets', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            aspect: 'square'
        );

        expect($component->getAspectRatio())->toBe('1/1');
    });

    it('returns custom aspect ratio', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            aspect: '4/3'
        );

        expect($component->getAspectRatio())->toBe('4/3');
    });

    it('returns null aspect ratio when not set', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test'
        );

        expect($component->getAspectRatio())->toBeNull();
    });

    it('generates correct object fit class', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            objectFit: 'contain'
        );

        expect($component->getObjectFitClass())->toBe('object-contain');
    });

    it('generates correct object position class', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            objectPosition: 'top-left'
        );

        expect($component->getObjectPositionClass())->toBe('object-left-top');
    });

    it('generates correct rounded class', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            rounded: 'full'
        );

        expect($component->getRoundedClass())->toBe('rounded-full');
    });

    it('generates lightbox attributes when lightbox is set', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            lightbox: 'gallery-1'
        );

        $attributes = $component->getLightboxAttributes();

        expect($attributes)->toHaveKey('data-lightbox', 'gallery-1');
    });

    it('uses default gallery name when lightbox is true', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            lightbox: true
        );

        $attributes = $component->getLightboxAttributes();

        expect($attributes)->toHaveKey('data-lightbox', 'default');
    });

    it('includes lightbox caption attribute', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            lightbox: 'gallery-1',
            lightboxCaption: 'Custom caption'
        );

        $attributes = $component->getLightboxAttributes();

        expect($attributes)
            ->toHaveKey('data-lightbox', 'gallery-1')
            ->toHaveKey('data-lightbox-caption', 'Custom caption');
    });

    it('uses caption as lightbox caption if not explicitly set', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            lightbox: 'gallery-1',
            caption: 'Image caption'
        );

        $attributes = $component->getLightboxAttributes();

        expect($attributes)->toHaveKey('data-lightbox-caption', 'Image caption');
    });

    it('processes formats array into sources', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            formats: ['avif', 'webp']
        );
        $component->mount();

        expect($component->sources)
            ->toHaveCount(2)
            ->and($component->sources[0])->toMatchArray([
                'srcset' => 'test.avif',
                'type' => 'image/avif',
            ])
            ->and($component->sources[1])->toMatchArray([
                'srcset' => 'test.webp',
                'type' => 'image/webp',
            ]);
    });

    it('indicates picture element usage when sources exist', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test',
            sources: [
                ['srcset' => 'test.webp', 'type' => 'image/webp'],
            ]
        );

        expect($component->usesPictureElement())->toBeTrue();
    });

    it('indicates no picture element usage when sources are empty', function () {
        $component = new Image(
            src: 'test.jpg',
            alt: 'Test'
        );

        expect($component->usesPictureElement())->toBeFalse();
    });

    it('validates formats as array', function () {
        expect(function () {
            $component = new Image(
                src: 'test.jpg',
                alt: 'Test',
                formats: 'invalid'
            );
            $component->mount();
        })->toThrow(TypeError::class);
    });
});
