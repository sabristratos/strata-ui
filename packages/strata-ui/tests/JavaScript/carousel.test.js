import { describe, it, expect, beforeEach, vi } from 'vitest';
import carouselComponent from '../../resources/js/carousel.js';

describe('Carousel Component', () => {
    let component;
    let mockRefs;
    let mockSlideElements;

    beforeEach(() => {
        mockSlideElements = [
            createMockSlide(0, 300),
            createMockSlide(1, 300),
            createMockSlide(2, 300),
            createMockSlide(3, 300),
        ];

        mockRefs = {
            viewport: createMockViewport(),
            container: createMockContainer(mockSlideElements),
        };

        component = carouselComponent({
            align: 'start',
            loop: false,
            dragFree: false,
            slidesToScroll: 1,
            autoplay: false,
            autoplayDelay: 3000,
            speed: 300,
            draggable: true,
        });

        component.$refs = mockRefs;
        component.$dispatch = vi.fn();
        component.$nextTick = (fn) => fn();

        vi.useFakeTimers();
    });

    function createMockSlide(index, width) {
        const slide = document.createElement('div');
        slide.setAttribute('data-carousel-slide', '');
        slide.setAttribute('data-slide-index', index.toString());
        Object.defineProperty(slide, 'offsetLeft', { value: index * width, writable: true });
        Object.defineProperty(slide, 'offsetWidth', { value: width, writable: true });
        slide.style.scrollSnapAlign = 'start';
        slide.style.scrollSnapStop = 'always';
        return slide;
    }

    function createMockViewport() {
        const viewport = document.createElement('div');
        Object.defineProperty(viewport, 'clientWidth', { value: 900, writable: true });
        return viewport;
    }

    function createMockContainer(slides) {
        const container = document.createElement('div');
        container.style.scrollBehavior = 'smooth';
        slides.forEach(slide => container.appendChild(slide));

        container.querySelectorAll = vi.fn(() => slides);

        Object.defineProperty(container, 'scrollLeft', { value: 0, writable: true });
        Object.defineProperty(container, 'scrollWidth', { value: 1200, writable: true });
        Object.defineProperty(container, 'clientWidth', { value: 900, writable: true });

        container.scrollTo = vi.fn(({ left, behavior }) => {
            container.scrollLeft = left;
        });

        container.addEventListener = vi.fn();

        return container;
    }

    describe('Initialization', () => {
        it('initializes with default values', () => {
            expect(component.currentIndex).toBe(0);
            expect(component.isDragging).toBe(false);
            expect(component.autoplayPaused).toBe(false);
        });

        it('collects slides on init', () => {
            component.init();

            expect(component.totalSlides).toBe(4);
            expect(component.slides.length).toBe(4);
        });

        it('dispatches init event', () => {
            component.init();

            expect(component.$dispatch).toHaveBeenCalledWith('carousel-init', {
                totalSlides: 4,
                currentIndex: 0,
            });
        });

        it('sets up scroll snap styles', () => {
            component.init();

            expect(mockRefs.container.style.scrollSnapType).toBe('x mandatory');
            mockSlideElements.forEach(slide => {
                expect(slide.style.scrollSnapAlign).toBe('start');
                expect(slide.style.scrollSnapStop).toBe('always');
            });
        });
    });

    describe('Navigation', () => {
        beforeEach(() => {
            component.init();
        });

        it('scrolls to next slide', () => {
            component.scrollNext();

            expect(component.currentIndex).toBe(1);
            expect(mockRefs.container.scrollTo).toHaveBeenCalled();
        });

        it('scrolls to previous slide', () => {
            component.currentIndex = 2;
            component.scrollPrev();

            expect(component.currentIndex).toBe(1);
        });

        it('scrolls to specific slide index', () => {
            component.scrollTo(2);

            expect(component.currentIndex).toBe(2);
            expect(mockRefs.container.scrollTo).toHaveBeenCalled();
        });

        it('respects slidesToScroll value', () => {
            component.slidesToScroll = 2;
            component.scrollNext();

            expect(component.currentIndex).toBe(2);
        });

        it('uses instant scroll when specified', () => {
            component.scrollTo(2, true);

            expect(mockRefs.container.scrollLeft).toBeGreaterThan(0);
        });

        it('dispatches select event on navigation', () => {
            component.scrollTo(1);

            expect(component.$dispatch).toHaveBeenCalledWith('carousel-select', expect.objectContaining({
                index: 1,
            }));
        });
    });

    describe('Loop Mode', () => {
        beforeEach(() => {
            component.loop = true;
            component.init();
        });

        it('normalizes index when looping forward', () => {
            const normalized = component.normalizeIndex(5);
            expect(normalized).toBe(1);
        });

        it('normalizes index when looping backward', () => {
            const normalized = component.normalizeIndex(-1);
            expect(normalized).toBe(3);
        });

        it('allows scrolling past last slide', () => {
            component.currentIndex = 3;
            expect(component.canScrollNext()).toBe(true);
        });

        it('allows scrolling before first slide', () => {
            component.currentIndex = 0;
            expect(component.canScrollPrev()).toBe(true);
        });
    });

    describe('Non-Loop Mode', () => {
        beforeEach(() => {
            component.loop = false;
            component.init();
        });

        it('prevents scrolling past last slide', () => {
            component.currentIndex = 3;
            expect(component.canScrollNext()).toBe(false);
        });

        it('prevents scrolling before first slide', () => {
            component.currentIndex = 0;
            expect(component.canScrollPrev()).toBe(false);
        });

        it('clamps index to valid range', () => {
            const normalized = component.normalizeIndex(10);
            expect(normalized).toBe(3);

            const normalizedNegative = component.normalizeIndex(-1);
            expect(normalizedNegative).toBe(0);
        });
    });

    describe('Drag Interactions', () => {
        beforeEach(() => {
            component.draggable = true;
            component.init();
        });

        it('starts dragging on mouse down', () => {
            const event = new MouseEvent('mousedown', { clientX: 100 });
            component.handleDragStart(event);

            expect(component.isDragging).toBe(true);
            expect(component.dragStartX).toBe(100);
        });

        it('starts dragging on touch start', () => {
            const event = new TouchEvent('touchstart', {
                touches: [{ clientX: 100, identifier: 0 }],
            });
            component.handleDragStart(event);

            expect(component.isDragging).toBe(true);
            expect(component.dragStartX).toBe(100);
        });

        it('updates scroll position during drag', () => {
            component.handleDragStart(new MouseEvent('mousedown', { clientX: 100 }));
            component.handleDragMove(new MouseEvent('mousemove', { clientX: 50 }));

            expect(mockRefs.container.scrollLeft).toBe(50);
        });

        it('ends dragging on mouse up', () => {
            component.handleDragStart(new MouseEvent('mousedown', { clientX: 100 }));
            component.dragCurrentX = 50;
            component.handleDragEnd();

            expect(component.isDragging).toBe(false);
        });

        it('pauses autoplay during drag', () => {
            component.autoplay = true;
            component.startAutoplay();

            component.handleDragStart(new MouseEvent('mousedown', { clientX: 100 }));

            expect(component.autoplayInterval).toBeNull();
        });

        it('does not drag when draggable is false', () => {
            component.draggable = false;
            component.handleDragStart(new MouseEvent('mousedown', { clientX: 100 }));

            expect(component.isDragging).toBe(false);
        });
    });

    describe('Autoplay', () => {
        beforeEach(() => {
            component.autoplay = true;
            component.autoplayDelay = 1000;
            component.init();
        });

        it('starts autoplay on init', () => {
            expect(component.autoplayInterval).not.toBeNull();
        });

        it('advances to next slide after delay', () => {
            component.startAutoplay();

            vi.advanceTimersByTime(1000);

            expect(component.currentIndex).toBe(1);
        });

        it('pauses on mouse enter', () => {
            component.handleMouseEnter();

            expect(component.autoplayPaused).toBe(true);
            expect(component.autoplayInterval).toBeNull();
        });

        it('resumes on mouse leave', () => {
            component.handleMouseEnter();
            component.handleMouseLeave();

            expect(component.autoplayPaused).toBe(false);
            expect(component.autoplayInterval).not.toBeNull();
        });

        it('does not autoplay when reduced motion is preferred', () => {
            component.prefersReducedMotion = true;
            component.init();

            expect(component.autoplayInterval).toBeNull();
        });
    });

    describe('Keyboard Navigation', () => {
        beforeEach(() => {
            component.init();
        });

        it('navigates to next slide on ArrowRight', () => {
            const event = new KeyboardEvent('keydown', { key: 'ArrowRight' });
            event.preventDefault = vi.fn();

            component.handleKeydown(event);

            expect(event.preventDefault).toHaveBeenCalled();
            expect(component.currentIndex).toBe(1);
        });

        it('navigates to previous slide on ArrowLeft', () => {
            component.currentIndex = 2;
            const event = new KeyboardEvent('keydown', { key: 'ArrowLeft' });
            event.preventDefault = vi.fn();

            component.handleKeydown(event);

            expect(event.preventDefault).toHaveBeenCalled();
            expect(component.currentIndex).toBe(1);
        });

        it('navigates to first slide on Home', () => {
            component.currentIndex = 2;
            const event = new KeyboardEvent('keydown', { key: 'Home' });
            event.preventDefault = vi.fn();

            component.handleKeydown(event);

            expect(event.preventDefault).toHaveBeenCalled();
            expect(component.currentIndex).toBe(0);
        });

        it('navigates to last slide on End', () => {
            const event = new KeyboardEvent('keydown', { key: 'End' });
            event.preventDefault = vi.fn();

            component.handleKeydown(event);

            expect(event.preventDefault).toHaveBeenCalled();
            expect(component.currentIndex).toBe(3);
        });
    });

    describe('Alignment', () => {
        it('calculates start alignment correctly', () => {
            component.align = 'start';
            component.init();

            component.scrollTo(1);

            const call = mockRefs.container.scrollTo.mock.calls[0][0];
            expect(call.left).toBe(300);
        });

        it('sets center snap alignment', () => {
            component.align = 'center';
            component.init();

            mockSlideElements.forEach(slide => {
                expect(slide.style.scrollSnapAlign).toBe('center');
            });
        });

        it('sets end snap alignment', () => {
            component.align = 'end';
            component.init();

            mockSlideElements.forEach(slide => {
                expect(slide.style.scrollSnapAlign).toBe('end');
            });
        });
    });

    describe('Event Dispatching', () => {
        beforeEach(() => {
            component.init();
        });

        it('dispatches scroll event during scrolling', () => {
            component.handleScroll();

            expect(component.$dispatch).toHaveBeenCalledWith('carousel-scroll', expect.objectContaining({
                currentIndex: expect.any(Number),
                progress: expect.any(Number),
            }));
        });

        it('dispatches settle event after scrolling stops', () => {
            component.handleScroll();

            vi.advanceTimersByTime(150);

            expect(component.$dispatch).toHaveBeenCalledWith('carousel-settle', expect.objectContaining({
                currentIndex: expect.any(Number),
            }));
        });
    });

    describe('Scroll Progress', () => {
        beforeEach(() => {
            component.init();
        });

        it('calculates scroll progress', () => {
            mockRefs.container.scrollLeft = 150;

            const progress = component.scrollProgress;

            expect(progress).toBeGreaterThanOrEqual(0);
            expect(progress).toBeLessThanOrEqual(1);
        });

        it('returns 0 when scroll width equals client width', () => {
            mockRefs.container.scrollWidth = 900;

            const progress = component.scrollProgress;

            expect(progress).toBe(0);
        });
    });

    describe('Cleanup', () => {
        beforeEach(() => {
            component.autoplay = true;
            component.init();
        });

        it('clears autoplay interval on destroy', () => {
            component.destroy();

            expect(component.autoplayInterval).toBeNull();
        });

        it('disconnects resize observer on destroy', () => {
            const mockObserver = {
                disconnect: vi.fn(),
            };
            component.resizeObserver = mockObserver;

            component.destroy();

            expect(mockObserver.disconnect).toHaveBeenCalled();
            expect(component.resizeObserver).toBeNull();
        });
    });
});
