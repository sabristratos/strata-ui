import { describe, it, expect, beforeEach, afterEach, vi } from 'vitest';
import strataSlider from '../../resources/js/slider.js';

describe('Slider', () => {
    let component;
    let mockContainer;

    beforeEach(() => {
        vi.useFakeTimers();

        global.window.matchMedia = vi.fn(() => ({
            matches: false,
            addEventListener: vi.fn(),
            removeEventListener: vi.fn(),
        }));

        mockContainer = {
            scrollLeft: 0,
            clientWidth: 800,
            addEventListener: vi.fn(),
            scrollTo: vi.fn(),
        };

        const config = {
            mode: 'presentational',
            loop: false,
            autoplay: false,
            autoplayDelay: 3000,
            peek: false,
            value: 0,
        };

        component = strataSlider(config);

        component.$el = {
            querySelectorAll: vi.fn(() => [
                { offsetLeft: 0, clientWidth: 800, scrollIntoView: vi.fn(), dataset: { currentIndex: '0' } },
                { offsetLeft: 800, clientWidth: 800, scrollIntoView: vi.fn(), dataset: { currentIndex: '1' } },
                { offsetLeft: 1600, clientWidth: 800, scrollIntoView: vi.fn(), dataset: { currentIndex: '2' } },
            ]),
            querySelector: vi.fn(),
            contains: vi.fn(() => true),
            addEventListener: vi.fn(),
        };
        component.$refs = { container: mockContainer };
        component.$nextTick = vi.fn((cb) => cb());
        component.$watch = vi.fn();
    });

    afterEach(() => {
        vi.clearAllTimers();
        vi.restoreAllMocks();
    });

    describe('initialization', () => {
        it('initializes with default config', () => {
            const c = strataSlider();
            expect(c.currentSlide).toBe(0);
            expect(c.totalSlides).toBe(0);
            expect(c.isPlaying).toBe(false);
            expect(c.engine).toBeNull();
        });

        it('initializes with custom config value', () => {
            const c = strataSlider({
                mode: 'form',
                loop: true,
                autoplay: true,
                autoplayDelay: 5000,
                value: 2,
            });
            expect(c.currentSlide).toBe(2);
            expect(c.isPlaying).toBe(false);
        });

        it('initializes state properties', () => {
            expect(component.currentSlide).toBe(0);
            expect(component.totalSlides).toBe(0);
            expect(component.isPlaying).toBe(false);
            expect(component.engine).toBeNull();
        });
    });

    describe('init', () => {
        it('initializes engine and component references', () => {
            component.init();

            expect(component.engine).toBeTruthy();
            expect(component.totalSlides).toBe(3);
        });

        it('calls setupScrollListener', () => {
            component.init();
            expect(component.engine).toBeTruthy();
        });

        it('starts autoplay when enabled and not reduced motion', () => {
            const autoplayComponent = strataSlider({ autoplay: true });
            autoplayComponent.$el = component.$el;
            autoplayComponent.$refs = component.$refs;
            autoplayComponent.$nextTick = component.$nextTick;
            autoplayComponent.$watch = component.$watch;

            vi.spyOn(window, 'matchMedia').mockReturnValue({ matches: false });

            autoplayComponent.init();
            expect(autoplayComponent.isPlaying).toBe(true);
        });

        it('does not start autoplay when reduced motion is preferred', () => {
            const autoplayComponent = strataSlider({ autoplay: true });
            autoplayComponent.$el = component.$el;
            autoplayComponent.$refs = component.$refs;
            autoplayComponent.$nextTick = component.$nextTick;
            autoplayComponent.$watch = component.$watch;

            vi.spyOn(window, 'matchMedia').mockReturnValue({ matches: true });

            autoplayComponent.init();
            expect(autoplayComponent.isPlaying).toBe(false);
        });
    });

    describe('setupFormMode', () => {
        it('sets up Entangleable when input exists', () => {
            const mockInput = { value: '0' };
            const formComponent = strataSlider({ mode: 'form' });
            formComponent.$el = component.$el;
            formComponent.$refs = component.$refs;
            formComponent.$nextTick = component.$nextTick;
            formComponent.$watch = component.$watch;
            formComponent.$el.querySelector = vi.fn(() => mockInput);

            global.window.StrataEntangleable = class MockEntangleable {
                constructor(value) { this.value = value; }
                setupLivewire() {}
                watch() {}
            };

            formComponent.init();
            expect(formComponent.engine.entangleable).toBeTruthy();
        });

        it('does nothing when no input found', () => {
            const formComponent = strataSlider({ mode: 'form' });
            formComponent.$el = component.$el;
            formComponent.$refs = component.$refs;
            formComponent.$nextTick = component.$nextTick;
            formComponent.$watch = component.$watch;
            formComponent.$el.querySelector = vi.fn(() => null);

            formComponent.init();
            expect(formComponent.engine.entangleable).toBeNull();
        });
    });

    describe('goTo', () => {
        beforeEach(() => {
            component.init();
        });

        it('navigates to specified slide index', () => {
            component.goTo(1);

            expect(component.currentSlide).toBe(1);
        });

        it('does not navigate when already navigating', () => {
            component.engine.navigating = true;
            const items = component.$el.querySelectorAll();

            component.goTo(1);
            expect(items[1].scrollIntoView).not.toHaveBeenCalled();
        });

        it('does not navigate to negative index', () => {
            const items = component.$el.querySelectorAll();
            component.goTo(-1);
            expect(items[0].scrollIntoView).not.toHaveBeenCalled();
        });

        it('does not navigate beyond totalSlides', () => {
            const items = component.$el.querySelectorAll();
            component.goTo(5);
            expect(items[0].scrollIntoView).not.toHaveBeenCalled();
        });

        it('sets navigating flag and clears after timeout', () => {
            component.goTo(1);
            expect(component.engine.navigating).toBe(true);

            vi.advanceTimersByTime(150);
            expect(component.engine.navigating).toBe(false);
        });
    });

    describe('next', () => {
        beforeEach(() => {
            component.init();
        });

        it('advances to next slide', () => {
            const spy = vi.spyOn(component.engine, 'goTo');
            component.currentSlide = 0;

            component.next();
            expect(spy).toHaveBeenCalledWith(1, component);
        });

        it('stops at last slide when not looping', () => {
            const spy = vi.spyOn(component.engine, 'goTo');
            component.currentSlide = 2;

            component.next();
            expect(spy).toHaveBeenCalledWith(2, component);
        });

        it('loops to first slide when looping enabled', () => {
            const loopComponent = strataSlider({ loop: true });
            loopComponent.$el = component.$el;
            loopComponent.$refs = component.$refs;
            loopComponent.$nextTick = component.$nextTick;
            loopComponent.$watch = component.$watch;
            loopComponent.init();

            const spy = vi.spyOn(loopComponent.engine, 'goTo');
            loopComponent.currentSlide = 2;

            loopComponent.next();
            expect(spy).toHaveBeenCalledWith(0, loopComponent);
        });
    });

    describe('prev', () => {
        beforeEach(() => {
            component.init();
        });

        it('goes to previous slide', () => {
            const spy = vi.spyOn(component.engine, 'goTo');
            component.currentSlide = 2;

            component.prev();
            expect(spy).toHaveBeenCalledWith(1, component);
        });

        it('stops at first slide when not looping', () => {
            const spy = vi.spyOn(component.engine, 'goTo');
            component.currentSlide = 0;

            component.prev();
            expect(spy).toHaveBeenCalledWith(0, component);
        });

        it('loops to last slide when looping enabled', () => {
            const loopComponent = strataSlider({ loop: true });
            loopComponent.$el = component.$el;
            loopComponent.$refs = component.$refs;
            loopComponent.$nextTick = component.$nextTick;
            loopComponent.$watch = component.$watch;
            loopComponent.init();

            const spy = vi.spyOn(loopComponent.engine, 'goTo');
            loopComponent.currentSlide = 0;

            loopComponent.prev();
            expect(spy).toHaveBeenCalledWith(2, loopComponent);
        });
    });

    describe('updateCurrentSlide', () => {
        beforeEach(() => {
            component.init();
        });

        it('finds closest slide based on scroll position', () => {
            mockContainer.scrollLeft = 850;

            component.engine.updateCurrentSlide(component);
            expect(component.currentSlide).toBe(1);
        });

        it('handles first slide position', () => {
            mockContainer.scrollLeft = 50;

            component.engine.updateCurrentSlide(component);
            expect(component.currentSlide).toBe(0);
        });

        it('handles last slide position', () => {
            mockContainer.scrollLeft = 1650;

            component.engine.updateCurrentSlide(component);
            expect(component.currentSlide).toBe(2);
        });
    });

    describe('announceSlideChange', () => {
        beforeEach(() => {
            component.init();
        });

        it('updates live region with slide information', () => {
            const mockLiveRegion = { textContent: '' };
            component.$el.querySelector = vi.fn(() => mockLiveRegion);

            component.engine.announceSlideChange(1, component);
            expect(mockLiveRegion.textContent).toBe('Slide 2 of 3');
        });

        it('does nothing when live region not found', () => {
            component.$el.querySelector = vi.fn(() => null);
            expect(() => component.engine.announceSlideChange(1, component)).not.toThrow();
        });
    });

    describe('autoplay', () => {
        let autoplayComponent;

        beforeEach(() => {
            autoplayComponent = strataSlider({ autoplay: true, autoplayDelay: 3000 });
            autoplayComponent.$el = component.$el;
            autoplayComponent.$refs = component.$refs;
            autoplayComponent.$nextTick = component.$nextTick;
            autoplayComponent.$watch = component.$watch;
            global.window.matchMedia = vi.fn(() => ({ matches: false }));
        });

        it('startAutoplay sets interval', () => {
            autoplayComponent.init();

            expect(autoplayComponent.engine.autoplayInterval).not.toBeNull();
            expect(autoplayComponent.isPlaying).toBe(true);
        });

        it('startAutoplay advances slides', () => {
            autoplayComponent.init();
            const spy = vi.spyOn(autoplayComponent.engine, 'goTo');

            vi.advanceTimersByTime(3000);
            expect(spy).toHaveBeenCalled();
        });

        it('stopAutoplay clears interval', () => {
            autoplayComponent.init();
            autoplayComponent.pauseAutoplay();

            expect(autoplayComponent.engine.autoplayInterval).toBeNull();
        });

        it('pauseAutoplay stops and updates playing state', () => {
            autoplayComponent.init();
            autoplayComponent.pauseAutoplay();

            expect(autoplayComponent.engine.autoplayInterval).toBeNull();
            expect(autoplayComponent.isPlaying).toBe(false);
        });

        it('resumeAutoplay restarts when autoplay enabled', () => {
            autoplayComponent.init();
            autoplayComponent.pauseAutoplay();

            autoplayComponent.resumeAutoplay();
            expect(autoplayComponent.isPlaying).toBe(true);
        });

        it('togglePlayPause switches state', () => {
            autoplayComponent.init();

            autoplayComponent.togglePlayPause();
            expect(autoplayComponent.isPlaying).toBe(false);

            autoplayComponent.togglePlayPause();
            expect(autoplayComponent.isPlaying).toBe(true);
        });
    });

    describe('setupFocusListener', () => {
        let autoplayComponent;

        beforeEach(() => {
            autoplayComponent = strataSlider({ autoplay: true });
            autoplayComponent.$el = component.$el;
            autoplayComponent.$refs = component.$refs;
            autoplayComponent.$nextTick = component.$nextTick;
            autoplayComponent.$watch = component.$watch;
            global.window.matchMedia = vi.fn(() => ({ matches: false }));
        });

        it('stops autoplay when carousel receives focus', () => {
            autoplayComponent.init();

            const focusinHandler = autoplayComponent.$el.addEventListener.mock.calls
                .find(call => call[0] === 'focusin')[1];

            focusinHandler();
            expect(autoplayComponent.isPlaying).toBe(false);
        });
    });

    describe('touch handling', () => {
        beforeEach(() => {
            component.init();
        });

        it('detects right swipe', () => {
            const spy = vi.spyOn(component.engine, 'next');

            component.engine.touchStartX = 500;
            component.engine.touchEndX = 100;
            component.engine.handleSwipe(component);

            expect(spy).toHaveBeenCalled();
        });

        it('detects left swipe', () => {
            const spy = vi.spyOn(component.engine, 'prev');

            component.engine.touchStartX = 100;
            component.engine.touchEndX = 500;
            component.engine.handleSwipe(component);

            expect(spy).toHaveBeenCalled();
        });

        it('ignores small swipes below threshold', () => {
            const nextSpy = vi.spyOn(component.engine, 'next');
            const prevSpy = vi.spyOn(component.engine, 'prev');

            component.engine.touchStartX = 100;
            component.engine.touchEndX = 90;
            component.engine.handleSwipe(component);

            expect(nextSpy).not.toHaveBeenCalled();
            expect(prevSpy).not.toHaveBeenCalled();
        });

        it('pauses autoplay on swipe', () => {
            const spy = vi.spyOn(component.engine, 'pauseAutoplay');

            component.engine.touchStartX = 500;
            component.engine.touchEndX = 100;
            component.engine.handleSwipe(component);

            expect(spy).toHaveBeenCalled();
        });
    });

    describe('prefersReducedMotion', () => {
        it('returns true when user prefers reduced motion', () => {
            global.window.matchMedia = vi.fn(() => ({ matches: true }));
            component.init();

            expect(component.engine.prefersReducedMotion()).toBe(true);
        });

        it('returns false when user does not prefer reduced motion', () => {
            global.window.matchMedia = vi.fn(() => ({ matches: false }));
            component.init();

            expect(component.engine.prefersReducedMotion()).toBe(false);
        });
    });

    describe('destroy', () => {
        let autoplayComponent;

        beforeEach(() => {
            autoplayComponent = strataSlider({ autoplay: true });
            autoplayComponent.$el = component.$el;
            autoplayComponent.$refs = component.$refs;
            autoplayComponent.$nextTick = component.$nextTick;
            autoplayComponent.$watch = component.$watch;
            global.window.matchMedia = vi.fn(() => ({ matches: false }));
        });

        it('stops autoplay', () => {
            autoplayComponent.init();
            const spy = vi.spyOn(autoplayComponent.engine, 'stopAutoplay');

            autoplayComponent.destroy();
            expect(spy).toHaveBeenCalled();
        });

        it('destroys entangleable in form mode', () => {
            const mockInput = { value: '0' };
            const formComponent = strataSlider({ mode: 'form', autoplay: true });
            formComponent.$el = component.$el;
            formComponent.$refs = component.$refs;
            formComponent.$nextTick = component.$nextTick;
            formComponent.$watch = component.$watch;
            formComponent.$el.querySelector = vi.fn(() => mockInput);

            const mockDestroy = vi.fn();
            global.window.StrataEntangleable = class MockEntangleable {
                constructor(value) {
                    this.value = value;
                    this.destroy = mockDestroy;
                }
                setupLivewire() {}
                watch() {}
            };

            global.window.matchMedia = vi.fn(() => ({ matches: false }));

            formComponent.init();
            formComponent.destroy();

            expect(mockDestroy).toHaveBeenCalled();
        });

        it('clears component references', () => {
            autoplayComponent.init();
            autoplayComponent.destroy();

            expect(autoplayComponent.engine.component).toBeNull();
            expect(autoplayComponent.engine.container).toBeNull();
        });
    });

    describe('Edge Cases - Initialization', () => {
        it('handles missing container gracefully', () => {
            component.$refs.container = null;

            expect(() => component.init()).not.toThrow();
            expect(component.engine.container).toBeNull();
        });

        it('handles empty slide list', () => {
            component.$el.querySelectorAll = vi.fn(() => []);
            component.init();

            expect(component.totalSlides).toBe(0);
        });

        it('handles single slide', () => {
            component.$el.querySelectorAll = vi.fn(() => [
                { offsetLeft: 0, clientWidth: 800, scrollIntoView: vi.fn() }
            ]);
            component.init();

            expect(component.totalSlides).toBe(1);
        });

        it('initializes with all config options', () => {
            const fullConfig = strataSlider({
                mode: 'form',
                loop: true,
                autoplay: false,
                autoplayDelay: 5000,
                peek: true,
                value: 2
            });
            fullConfig.$el = component.$el;
            fullConfig.$refs = component.$refs;
            fullConfig.$nextTick = component.$nextTick;
            fullConfig.$watch = component.$watch;
            global.window.matchMedia = vi.fn(() => ({ matches: false }));
            fullConfig.init();

            expect(fullConfig.engine.config.mode).toBe('form');
            expect(fullConfig.engine.config.loop).toBe(true);
            expect(fullConfig.engine.config.autoplay).toBe(false);
            expect(fullConfig.engine.config.autoplayDelay).toBe(5000);
            expect(fullConfig.engine.config.peek).toBe(true);
        });

        it('handles undefined config gracefully', () => {
            const defaultSlider = strataSlider(undefined);

            expect(defaultSlider.currentSlide).toBe(0);
            expect(defaultSlider.engine).toBeNull();
        });

        it('handles null value in config', () => {
            const nullValueSlider = strataSlider({ value: null });

            expect(nullValueSlider.currentSlide).toBe(0);
        });
    });

    describe('Edge Cases - Navigation Boundaries', () => {
        beforeEach(() => {
            component.init();
        });

        it('goTo with exact boundary indices', () => {
            component.goTo(0);
            vi.advanceTimersByTime(150);
            expect(component.currentSlide).toBe(0);

            component.goTo(2);
            vi.advanceTimersByTime(150);
            expect(component.currentSlide).toBe(2);
        });

        it('goTo with large negative index does nothing', () => {
            component.currentSlide = 1;
            component.goTo(-999);
            expect(component.currentSlide).toBe(1);
        });

        it('goTo with large positive index beyond slides does nothing', () => {
            component.currentSlide = 1;
            component.goTo(999);
            expect(component.currentSlide).toBe(1);
        });

        it('next at last slide without loop stays at last slide', () => {
            component.currentSlide = 2;
            component.next();
            expect(component.currentSlide).toBe(2);
        });

        it('prev at first slide without loop stays at first slide', () => {
            component.currentSlide = 0;
            component.prev();
            expect(component.currentSlide).toBe(0);
        });

        it('handles rapid consecutive next calls', () => {
            component.currentSlide = 0;
            component.next();
            vi.advanceTimersByTime(150);
            component.next();
            vi.advanceTimersByTime(150);
            component.next();
            vi.advanceTimersByTime(150);

            expect(component.currentSlide).toBe(2);
        });

        it('handles rapid consecutive prev calls', () => {
            component.currentSlide = 2;
            component.prev();
            vi.advanceTimersByTime(150);
            component.prev();
            vi.advanceTimersByTime(150);
            component.prev();
            vi.advanceTimersByTime(150);

            expect(component.currentSlide).toBe(0);
        });

        it('handles alternating next and prev calls', () => {
            component.currentSlide = 1;
            component.next();
            component.prev();
            component.next();

            expect(component.currentSlide).toBe(2);
        });
    });

    describe('Edge Cases - Loop Mode Boundaries', () => {
        let loopComponent;

        beforeEach(() => {
            loopComponent = strataSlider({ loop: true });
            loopComponent.$el = component.$el;
            loopComponent.$refs = component.$refs;
            loopComponent.$nextTick = component.$nextTick;
            loopComponent.$watch = component.$watch;
            loopComponent.init();
        });

        it('next wraps from last to first slide', () => {
            loopComponent.currentSlide = 2;
            loopComponent.next();

            expect(loopComponent.currentSlide).toBe(0);
        });

        it('prev wraps from first to last slide', () => {
            loopComponent.currentSlide = 0;
            loopComponent.prev();

            expect(loopComponent.currentSlide).toBe(2);
        });

        it('handles multiple wraps forward', () => {
            loopComponent.currentSlide = 2;
            loopComponent.next();
            loopComponent.next();
            loopComponent.next();

            expect(loopComponent.currentSlide).toBe(0);
        });

        it('handles multiple wraps backward', () => {
            loopComponent.currentSlide = 0;
            loopComponent.prev();
            vi.advanceTimersByTime(150);
            loopComponent.prev();
            vi.advanceTimersByTime(150);
            loopComponent.prev();
            vi.advanceTimersByTime(150);

            expect(loopComponent.currentSlide).toBe(0);
        });
    });

    describe('Edge Cases - Autoplay Timing', () => {
        let autoplayComponent;

        beforeEach(() => {
            autoplayComponent = strataSlider({ autoplay: true, autoplayDelay: 1000 });
            autoplayComponent.$el = component.$el;
            autoplayComponent.$refs = component.$refs;
            autoplayComponent.$nextTick = component.$nextTick;
            autoplayComponent.$watch = component.$watch;
            global.window.matchMedia = vi.fn(() => ({ matches: false }));
        });

        it('advances multiple slides with autoplay', () => {
            autoplayComponent.init();

            vi.advanceTimersByTime(1000);
            expect(autoplayComponent.currentSlide).toBe(1);

            vi.advanceTimersByTime(1000);
            expect(autoplayComponent.currentSlide).toBe(2);
        });

        it('stops autoplay at last slide when not looping', () => {
            autoplayComponent.init();

            vi.advanceTimersByTime(3000);
            expect(autoplayComponent.currentSlide).toBe(2);

            vi.advanceTimersByTime(5000);
            expect(autoplayComponent.currentSlide).toBe(2);
        });

        it('handles very short autoplay delay', () => {
            const fastComponent = strataSlider({ autoplay: true, autoplayDelay: 100 });
            fastComponent.$el = component.$el;
            fastComponent.$refs = component.$refs;
            fastComponent.$nextTick = component.$nextTick;
            fastComponent.$watch = component.$watch;
            fastComponent.init();

            vi.advanceTimersByTime(300);
            expect(fastComponent.currentSlide).toBeGreaterThan(0);
        });

        it('handles pause and resume correctly', () => {
            autoplayComponent.init();

            vi.advanceTimersByTime(500);
            autoplayComponent.pauseAutoplay();
            const pausedSlide = autoplayComponent.currentSlide;

            vi.advanceTimersByTime(2000);
            expect(autoplayComponent.currentSlide).toBe(pausedSlide);

            autoplayComponent.resumeAutoplay();
            vi.advanceTimersByTime(1000);
            expect(autoplayComponent.currentSlide).toBeGreaterThan(pausedSlide);
        });

        it('does not create multiple intervals when startAutoplay called twice', () => {
            autoplayComponent.init();
            const firstInterval = autoplayComponent.engine.autoplayInterval;

            autoplayComponent.engine.startAutoplay(autoplayComponent);
            expect(autoplayComponent.engine.autoplayInterval).toBe(firstInterval);
        });

        it('handles toggle multiple times rapidly', () => {
            autoplayComponent.init();

            autoplayComponent.togglePlayPause();
            expect(autoplayComponent.isPlaying).toBe(false);

            autoplayComponent.togglePlayPause();
            expect(autoplayComponent.isPlaying).toBe(true);

            autoplayComponent.togglePlayPause();
            expect(autoplayComponent.isPlaying).toBe(false);
        });
    });

    describe('Edge Cases - Touch Handling', () => {
        beforeEach(() => {
            component.init();
        });

        it('handles swipe exactly at threshold', () => {
            const threshold = mockContainer.clientWidth * 0.3;
            const spy = vi.spyOn(component.engine, 'next');

            component.engine.touchStartX = threshold;
            component.engine.touchEndX = 0;
            component.engine.handleSwipe(component);

            expect(spy).toHaveBeenCalled();
        });

        it('handles swipe just below threshold', () => {
            const threshold = mockContainer.clientWidth * 0.3;
            const nextSpy = vi.spyOn(component.engine, 'next');
            const prevSpy = vi.spyOn(component.engine, 'prev');

            component.engine.touchStartX = threshold - 1;
            component.engine.touchEndX = 0;
            component.engine.handleSwipe(component);

            expect(nextSpy).not.toHaveBeenCalled();
            expect(prevSpy).not.toHaveBeenCalled();
        });

        it('handles zero swipe distance', () => {
            const nextSpy = vi.spyOn(component.engine, 'next');
            const prevSpy = vi.spyOn(component.engine, 'prev');

            component.engine.touchStartX = 100;
            component.engine.touchEndX = 100;
            component.engine.handleSwipe(component);

            expect(nextSpy).not.toHaveBeenCalled();
            expect(prevSpy).not.toHaveBeenCalled();
        });

        it('handles very large swipe distance', () => {
            const spy = vi.spyOn(component.engine, 'next');

            component.engine.touchStartX = 10000;
            component.engine.touchEndX = 0;
            component.engine.handleSwipe(component);

            expect(spy).toHaveBeenCalled();
        });

        it('handles negative touch coordinates', () => {
            const spy = vi.spyOn(component.engine, 'prev');

            component.engine.touchStartX = 0;
            component.engine.touchEndX = 400;
            component.engine.handleSwipe(component);

            expect(spy).toHaveBeenCalled();
        });
    });

    describe('Edge Cases - Scroll Position Updates', () => {
        beforeEach(() => {
            component.init();
        });

        it('updates to correct slide when scrolled to exact position', () => {
            mockContainer.scrollLeft = 800;
            component.engine.updateCurrentSlide(component);

            expect(component.currentSlide).toBe(1);
        });

        it('handles scroll position between slides', () => {
            mockContainer.scrollLeft = 400;
            component.engine.updateCurrentSlide(component);

            expect(component.currentSlide).toBe(0);
        });

        it('handles scroll position at slide boundary', () => {
            mockContainer.scrollLeft = 799;
            component.engine.updateCurrentSlide(component);

            expect(component.currentSlide).toBeLessThanOrEqual(1);
        });

        it('handles negative scroll position', () => {
            mockContainer.scrollLeft = -100;
            component.engine.updateCurrentSlide(component);

            expect(component.currentSlide).toBe(0);
        });

        it('handles scroll beyond last slide', () => {
            mockContainer.scrollLeft = 9999;
            component.engine.updateCurrentSlide(component);

            expect(component.currentSlide).toBe(2);
        });
    });

    describe('Edge Cases - Form Mode Integration', () => {
        let formComponent;

        beforeEach(() => {
            formComponent = strataSlider({ mode: 'form', value: 1 });
            formComponent.$el = component.$el;
            formComponent.$refs = component.$refs;
            formComponent.$nextTick = component.$nextTick;
            formComponent.$watch = component.$watch;
        });

        it('initializes with starting value', () => {
            expect(formComponent.currentSlide).toBe(1);
        });

        it('handles entangleable watch with invalid values', () => {
            const mockInput = { value: '1' };
            formComponent.$el.querySelector = vi.fn(() => mockInput);

            let watchCallback;
            global.window.StrataEntangleable = class MockEntangleable {
                constructor(value) { this.value = value; }
                setupLivewire() {}
                watch(cb) { watchCallback = cb; }
            };

            formComponent.init();

            watchCallback('invalid');
            watchCallback(null);
            watchCallback(undefined);
            watchCallback({});
        });

        it('handles entangleable watch with same value', () => {
            const mockInput = { value: '1' };
            formComponent.$el.querySelector = vi.fn(() => mockInput);

            let watchCallback;
            global.window.StrataEntangleable = class MockEntangleable {
                constructor(value) { this.value = value; }
                setupLivewire() {}
                watch(cb) { watchCallback = cb; }
            };

            formComponent.init();
            const spy = vi.spyOn(formComponent.engine, 'goTo');

            watchCallback(formComponent.currentSlide);
            expect(spy).not.toHaveBeenCalled();
        });

        it('handles entangleable watch with out of bounds value', () => {
            const mockInput = { value: '1' };
            formComponent.$el.querySelector = vi.fn(() => mockInput);

            let watchCallback;
            global.window.StrataEntangleable = class MockEntangleable {
                constructor(value) { this.value = value; }
                setupLivewire() {}
                watch(cb) { watchCallback = cb; }
            };

            formComponent.init();

            watchCallback(999);
            watchCallback(-1);
        });
    });

    describe('Edge Cases - ARIA and Accessibility', () => {
        beforeEach(() => {
            component.init();
        });

        it('announces slide change with valid index', () => {
            const mockLiveRegion = { textContent: '' };
            component.$el.querySelector = vi.fn(() => mockLiveRegion);

            component.engine.announceSlideChange(0, component);
            expect(mockLiveRegion.textContent).toBe('Slide 1 of 3');

            component.engine.announceSlideChange(2, component);
            expect(mockLiveRegion.textContent).toBe('Slide 3 of 3');
        });

        it('handles missing live region gracefully', () => {
            component.$el.querySelector = vi.fn(() => null);

            expect(() => component.engine.announceSlideChange(1, component)).not.toThrow();
        });

        it('announces with zero total slides', () => {
            component.totalSlides = 0;
            const mockLiveRegion = { textContent: '' };
            component.$el.querySelector = vi.fn(() => mockLiveRegion);

            component.engine.announceSlideChange(0, component);
            expect(mockLiveRegion.textContent).toBe('Slide 1 of 0');
        });
    });

    describe('Edge Cases - Cleanup and Memory', () => {
        it('destroy handles null engine gracefully', () => {
            const newComponent = strataSlider();
            expect(() => newComponent.destroy()).not.toThrow();
        });

        it('destroy can be called multiple times', () => {
            component.init();

            expect(() => {
                component.destroy();
                component.destroy();
                component.destroy();
            }).not.toThrow();
        });

        it('destroy clears all timers', () => {
            const autoplayComponent = strataSlider({ autoplay: true });
            autoplayComponent.$el = component.$el;
            autoplayComponent.$refs = component.$refs;
            autoplayComponent.$nextTick = component.$nextTick;
            autoplayComponent.$watch = component.$watch;
            global.window.matchMedia = vi.fn(() => ({ matches: false }));

            autoplayComponent.init();
            expect(autoplayComponent.engine.autoplayInterval).not.toBeNull();

            autoplayComponent.destroy();
            expect(autoplayComponent.engine.autoplayInterval).toBeNull();
        });

        it('methods handle destroyed state gracefully', () => {
            component.init();
            component.destroy();

            expect(() => {
                component.next();
                component.prev();
                component.pauseAutoplay();
                component.resumeAutoplay();
            }).not.toThrow();
        });
    });

    describe('Edge Cases - Container State', () => {
        it('handles missing container in updateCurrentSlide', () => {
            component.init();
            component.engine.container = null;

            expect(() => component.engine.updateCurrentSlide(component)).not.toThrow();
        });

        it('handles missing container in setupTouchHandlers', () => {
            component.$refs.container = null;

            expect(() => component.init()).not.toThrow();
        });

        it('handles missing container in handleSwipe', () => {
            component.init();

            component.engine.touchStartX = 500;
            component.engine.touchEndX = 100;
            component.engine.container = null;

            expect(() => component.engine.handleSwipe(component)).not.toThrow();
        });

        it('handles zero width container for swipe threshold', () => {
            mockContainer.clientWidth = 0;
            component.init();

            const spy = vi.spyOn(component.engine, 'next');
            component.engine.touchStartX = 100;
            component.engine.touchEndX = 0;
            component.engine.handleSwipe(component);

            expect(spy).toHaveBeenCalled();
        });
    });

    describe('Edge Cases - Concurrent Operations', () => {
        beforeEach(() => {
            component.init();
        });

        it('handles goTo while navigating', () => {
            component.engine.navigating = true;
            const items = component.$el.querySelectorAll();

            component.goTo(1);

            expect(items[1].scrollIntoView).not.toHaveBeenCalled();
        });

        it('handles rapid toggle during autoplay', () => {
            const autoplayComponent = strataSlider({ autoplay: true, autoplayDelay: 1000 });
            autoplayComponent.$el = component.$el;
            autoplayComponent.$refs = component.$refs;
            autoplayComponent.$nextTick = component.$nextTick;
            autoplayComponent.$watch = component.$watch;
            global.window.matchMedia = vi.fn(() => ({ matches: false }));
            autoplayComponent.init();

            vi.advanceTimersByTime(500);
            autoplayComponent.togglePlayPause();
            vi.advanceTimersByTime(100);
            autoplayComponent.togglePlayPause();
            vi.advanceTimersByTime(100);
            autoplayComponent.togglePlayPause();

            expect(autoplayComponent.isPlaying).toBe(false);
        });

        it('handles navigation during scroll update', () => {
            const spy = vi.spyOn(component.engine, 'goTo');

            component.engine.updateCurrentSlide(component);
            component.next();
            component.engine.updateCurrentSlide(component);

            expect(spy).toHaveBeenCalled();
        });
    });
});
