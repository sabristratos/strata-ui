class SliderEngine {
    constructor(config = {}) {
        this.config = {
            mode: config.mode || 'presentational',
            loop: config.loop || false,
            autoplay: config.autoplay || false,
            autoplayDelay: config.autoplayDelay || 3000,
            peek: config.peek || false,
            ...config
        };

        this.component = null;
        this.container = null;
        this.entangleable = null;
        this.autoplayInterval = null;
        this.isFormMode = this.config.mode === 'form';
        this.navigating = false;
        this.touchStartX = 0;
        this.touchEndX = 0;
    }

    init(component) {
        this.component = component;

        this.container = component.$refs.container;
        component.totalSlides = component.$el.querySelectorAll('[data-strata-slider-item]').length;

        if (this.isFormMode) {
            this.setupFormMode(component);
        }

        if (this.config.autoplay && !this.prefersReducedMotion()) {
            this.startAutoplay(component);
        }

        this.updateCurrentSlide(component);
        this.setupScrollListener();
        this.setupFocusListener(component);
        this.setupTouchHandlers(component);
    }

    setupFormMode(component) {
        const entangleableMixin = window.createEntangleableMixin({
            initialValue: component.currentSlide,
            inputSelector: '[data-strata-slider-input]',
            afterWatch: (newValue) => {
                if (typeof newValue === 'number' && newValue !== component.currentSlide) {
                    this.goTo(newValue, component);
                }
            }
        });

        Object.assign(component, entangleableMixin);
        component.initEntangleable();

        this.entangleable = component.entangleable;

        component.$watch('currentSlide', (value) => {
            if (this.entangleable) {
                this.entangleable.set(value);
            }
        });
    }

    setupScrollListener() {
        if (!this.container) return;

        let scrollTimeout;
        this.container.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                this.updateCurrentSlide(this.component);
            }, 150);
        });
    }

    setupFocusListener(component) {
        if (!component.$el) return;

        component.$el.addEventListener('focusin', () => {
            if (component.isPlaying) {
                this.stopAutoplay(component);
            }
        });
    }

    goTo(index, component, { smooth = true, scrollToSlide = true } = {}) {
        if (this.navigating || index < 0 || index >= component.totalSlides) return;

        this.navigating = true;

        const items = component.$el.querySelectorAll('[data-strata-slider-item]');
        const item = items[index];

        if (item) {
            if (scrollToSlide) {
                item.scrollIntoView({
                    behavior: smooth ? 'smooth' : 'auto',
                    block: 'nearest',
                    inline: this.config.peek ? 'start' : 'center'
                });
            } else {
                const container = this.container;
                if (container) {
                    const scrollPosition = this.config.peek
                        ? item.offsetLeft
                        : item.offsetLeft - (container.clientWidth / 2) + (item.clientWidth / 2);

                    container.scrollTo({
                        left: scrollPosition,
                        behavior: smooth ? 'smooth' : 'auto'
                    });
                }
            }

            component.currentSlide = index;
            this.announceSlideChange(index, component);
        }

        setTimeout(() => {
            this.navigating = false;
        }, 150);
    }

    next(component) {
        const nextIndex = this.config.loop
            ? (component.currentSlide + 1) % component.totalSlides
            : Math.min(component.currentSlide + 1, component.totalSlides - 1);
        this.goTo(nextIndex, component);
    }

    prev(component) {
        const prevIndex = this.config.loop
            ? (component.currentSlide - 1 + component.totalSlides) % component.totalSlides
            : Math.max(component.currentSlide - 1, 0);
        this.goTo(prevIndex, component);
    }

    updateCurrentSlide(component) {
        if (!this.container) return;

        const items = component.$el.querySelectorAll('[data-strata-slider-item]');
        const scrollLeft = this.container.scrollLeft;

        let closestIndex = 0;
        let closestDistance = Infinity;

        items.forEach((item, index) => {
            const distance = Math.abs(item.offsetLeft - scrollLeft);
            if (distance < closestDistance) {
                closestDistance = distance;
                closestIndex = index;
            }
        });

        component.currentSlide = closestIndex;
    }

    announceSlideChange(index, component) {
        const liveRegion = component.$el.querySelector('[data-strata-slider-live-region]');
        if (liveRegion) {
            liveRegion.textContent = `Slide ${index + 1} of ${component.totalSlides}`;
        }
    }

    startAutoplay(component) {
        if (this.autoplayInterval) return;
        component.isPlaying = true;
        this.autoplayInterval = setInterval(() => {
            const nextIndex = this.config.loop
                ? (component.currentSlide + 1) % component.totalSlides
                : Math.min(component.currentSlide + 1, component.totalSlides - 1);
            this.goTo(nextIndex, component, { scrollToSlide: false });
        }, this.config.autoplayDelay);
    }

    stopAutoplay(component) {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
            component.isPlaying = false;
        }
    }

    pauseAutoplay(component) {
        this.stopAutoplay(component);
    }

    resumeAutoplay(component) {
        const canResume = this.config.autoplay && !this.prefersReducedMotion() && !this.autoplayInterval;
        if (canResume) {
            this.startAutoplay(component);
        }
    }

    togglePlayPause(component) {
        if (component.isPlaying) {
            this.pauseAutoplay(component);
        } else {
            this.resumeAutoplay(component);
        }
    }

    prefersReducedMotion() {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    setupTouchHandlers(component) {
        if (!this.container) return;

        this.container.addEventListener('touchstart', (e) => {
            this.touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        this.container.addEventListener('touchend', (e) => {
            this.touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe(component);
        }, { passive: true });
    }

    handleSwipe(component) {
        if (!this.container) return;

        const swipeThreshold = this.container.clientWidth * 0.3;
        const swipeDistance = this.touchStartX - this.touchEndX;

        if (Math.abs(swipeDistance) < swipeThreshold) return;

        if (swipeDistance > 0) {
            this.pauseAutoplay(component);
            this.next(component);
        } else {
            this.pauseAutoplay(component);
            this.prev(component);
        }
    }

    destroy(component) {
        this.stopAutoplay(component);
        if (this.entangleable) {
            this.entangleable.destroy();
        }
        this.component = null;
        this.container = null;
    }
}

export default (config = {}) => ({
    currentSlide: config.value ?? 0,
    totalSlides: 0,
    isPlaying: false,
    engine: null,

    init() {
        this.engine = new SliderEngine(config);
        this.$nextTick(() => {
            this.engine.init(this);
        });
    },

    goTo(index) {
        this.engine.goTo(index, this);
    },

    next() {
        this.engine.next(this);
    },

    prev() {
        this.engine.prev(this);
    },

    pauseAutoplay() {
        this.engine.pauseAutoplay(this);
    },

    resumeAutoplay() {
        this.engine.resumeAutoplay(this);
    },

    togglePlayPause() {
        this.engine.togglePlayPause(this);
    },

    destroy() {
        if (this.engine) {
            this.engine.destroy(this);
        }
    }
});
