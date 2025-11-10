import { describe, it, expect, beforeEach, vi } from 'vitest';
import imageComponent from '../../resources/js/image.js';

describe('Image Component', () => {
    let component;
    let mockRefs;

    beforeEach(() => {
        mockRefs = {
            image: document.createElement('img'),
            blurHashCanvas: document.createElement('canvas'),
        };

        component = imageComponent({
            src: 'test.jpg',
            fallback: 'fallback.jpg',
            blurHash: 'LGF5]+Yk^6#M@-5c,1J5@[or[Q6.',
            placeholderType: 'skeleton',
        });

        component.$refs = mockRefs;
        component.$dispatch = vi.fn();
    });

    describe('Initialization', () => {
        it('initializes with loading state', () => {
            expect(component.state).toBe('loading');
        });

        it('stores configuration', () => {
            expect(component.src).toBe('test.jpg');
            expect(component.fallback).toBe('fallback.jpg');
            expect(component.blurHash).toBe('LGF5]+Yk^6#M@-5c,1J5@[or[Q6.');
            expect(component.placeholderType).toBe('skeleton');
        });
    });

    describe('Loading States', () => {
        it('transitions to loaded state on successful load', () => {
            component.handleLoad();

            expect(component.state).toBe('loaded');
        });

        it('dispatches loaded event on successful load', () => {
            component.handleLoad();

            expect(component.$dispatch).toHaveBeenCalledWith('image-loaded', {
                src: 'test.jpg',
                fallback: 'fallback.jpg',
            });
        });

        it('transitions to error state when fallback exists', () => {
            component.handleError();

            expect(component.state).toBe('error');
        });

        it('stays in loading state when no fallback exists', () => {
            component.fallback = null;
            component.handleError();

            expect(component.state).toBe('loading');
        });

        it('dispatches error event on load failure', () => {
            component.handleError();

            expect(component.$dispatch).toHaveBeenCalledWith('image-error', {
                src: 'test.jpg',
                fallback: 'fallback.jpg',
            });
        });
    });

    describe('BlurHash Rendering', () => {
        it('renders blurhash on canvas', () => {
            const canvas = mockRefs.blurHashCanvas;
            const ctx = canvas.getContext('2d');
            const putImageDataSpy = vi.spyOn(ctx, 'putImageData');

            component.init();

            expect(canvas.width).toBe(32);
            expect(canvas.height).toBe(32);
            expect(putImageDataSpy).toHaveBeenCalled();
        });

        it('handles missing canvas reference gracefully', () => {
            component.$refs.blurHashCanvas = null;

            expect(() => component.renderBlurHash('LGF5]+Yk^6#M@-5c,1J5@[or[Q6.')).not.toThrow();
        });

        it('handles invalid blurhash gracefully', () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {});

            component.renderBlurHash('invalid-hash');

            expect(consoleSpy).toHaveBeenCalledWith(
                'Failed to render BlurHash:',
                expect.any(Error)
            );

            consoleSpy.mockRestore();
        });

        it('skips rendering when hash is null', () => {
            const canvas = mockRefs.blurHashCanvas;
            const ctx = canvas.getContext('2d');
            const putImageDataSpy = vi.spyOn(ctx, 'putImageData');

            component.renderBlurHash(null);

            expect(putImageDataSpy).not.toHaveBeenCalled();
        });
    });

    describe('Event Dispatching', () => {
        it('dispatches custom events with correct payload', () => {
            component.dispatchEvent('loaded');

            expect(component.$dispatch).toHaveBeenCalledWith('image-loaded', {
                src: 'test.jpg',
                fallback: 'fallback.jpg',
            });
        });
    });

    describe('Edge Cases', () => {
        it('handles missing src gracefully', () => {
            const noSrcComponent = imageComponent({
                src: '',
                fallback: null,
                blurHash: null,
                placeholderType: 'skeleton',
            });

            expect(noSrcComponent.src).toBe('');
            expect(noSrcComponent.state).toBe('loading');
        });

        it('handles all placeholder types', () => {
            const types = ['blur', 'skeleton', 'none'];

            types.forEach(type => {
                const comp = imageComponent({
                    src: 'test.jpg',
                    fallback: null,
                    blurHash: null,
                    placeholderType: type,
                });

                expect(comp.placeholderType).toBe(type);
            });
        });
    });
});
