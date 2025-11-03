class Slider {
    constructor(config = {}) {
        this.config = {
            mode: config.mode || 'presentational',
            loop: config.loop || false,
            autoplay: config.autoplay || false,
            autoplayDelay: config.autoplayDelay || 3000,
            peek: config.peek || false,
            ...config
        };

        this.currentSlide = 0;
        this.totalSlides = 0;
        this.autoplayInterval = null;
        this.entangleable = null;
        this.component = null;
        this.container = null;
        this.isFormMode = this.config.mode === 'form';
        this.navigating = false;
        this.isPlaying = false;
        this.touchStartX = 0;
        this.touchEndX = 0;
    }

    init(component) {
        this.component = component;
        component.isPlaying = false;

        component.$nextTick(() => {
            this.container = component.$refs.container;
            this.totalSlides = component.$el.querySelectorAll('[data-strata-slider-item]').length;
            component.totalSlides = this.totalSlides;

            if (this.isFormMode) {
                this.setupFormMode();
            }

            if (this.config.autoplay && !this.prefersReducedMotion()) {
                this.startAutoplay();
            }

            this.updateCurrentSlide();

            this.setupScrollListener();
            this.setupKeyboardNavigation();
            this.setupTouchHandlers();
        });
    }

    setupFormMode() {
        const input = this.component.$el.querySelector('[data-strata-slider-input]');
        if (!input) return;

        this.entangleable = new window.StrataEntangleable(this.component.currentSlide);

        this.entangleable.setupLivewire(this.component, input);

        this.entangleable.watch((newValue) => {
            if (typeof newValue === 'number' && newValue !== this.component.currentSlide) {
                this.goTo(newValue);
            }
        });

        this.component.$watch('currentSlide', (value) => {
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
                this.updateCurrentSlide();
            }, 150);
        });
    }

    setupKeyboardNavigation() {
        this.component.$el.addEventListener('keydown', (e) => {
            if (!this.component.$el.contains(document.activeElement)) return;

            switch(e.key) {
                case 'ArrowRight':
                    e.preventDefault();
                    this.next();
                    break;
                case 'ArrowLeft':
                    e.preventDefault();
                    this.prev();
                    break;
                case 'Home':
                    e.preventDefault();
                    this.goTo(0);
                    break;
                case 'End':
                    e.preventDefault();
                    this.goTo(this.totalSlides - 1);
                    break;
            }
        });
    }

    goTo(index, { smooth = true, scrollToSlide = true } = {}) {
        if (this.navigating || index < 0 || index >= this.totalSlides) return;

        this.navigating = true;

        const items = this.component.$el.querySelectorAll('[data-strata-slider-item]');
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

            this.component.currentSlide = index;
            this.announceSlideChange(index);
        }

        setTimeout(() => {
            this.navigating = false;
        }, 150);
    }

    next() {
        const nextIndex = this.config.loop
            ? (this.component.currentSlide + 1) % this.totalSlides
            : Math.min(this.component.currentSlide + 1, this.totalSlides - 1);
        this.goTo(nextIndex);
    }

    prev() {
        const prevIndex = this.config.loop
            ? (this.component.currentSlide - 1 + this.totalSlides) % this.totalSlides
            : Math.max(this.component.currentSlide - 1, 0);
        this.goTo(prevIndex);
    }

    updateCurrentSlide() {
        if (!this.container) return;

        const items = this.component.$el.querySelectorAll('[data-strata-slider-item]');
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

        this.component.currentSlide = closestIndex;
    }

    announceSlideChange(index) {
        const liveRegion = this.component.$el.querySelector('[data-strata-slider-live-region]');
        if (liveRegion) {
            liveRegion.textContent = `Slide ${index + 1} of ${this.totalSlides}`;
        }
    }

    startAutoplay() {
        if (this.autoplayInterval) return;
        this.isPlaying = true;
        if (this.component) this.component.isPlaying = true;
        this.autoplayInterval = setInterval(() => {
            const nextIndex = this.config.loop
                ? (this.component.currentSlide + 1) % this.totalSlides
                : Math.min(this.component.currentSlide + 1, this.totalSlides - 1);
            this.goTo(nextIndex, { scrollToSlide: false });
        }, this.config.autoplayDelay);
    }

    stopAutoplay() {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
    }

    pauseAutoplay() {
        this.stopAutoplay();
        this.isPlaying = false;
        if (this.component) this.component.isPlaying = false;
    }

    resumeAutoplay() {
        if (this.config.autoplay && !this.prefersReducedMotion()) {
            this.startAutoplay();
        }
    }

    togglePlayPause() {
        if (this.isPlaying) {
            this.pauseAutoplay();
        } else {
            this.resumeAutoplay();
        }
    }

    prefersReducedMotion() {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    setupTouchHandlers() {
        if (!this.container) return;

        this.container.addEventListener('touchstart', (e) => {
            this.touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        this.container.addEventListener('touchend', (e) => {
            this.touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
        }, { passive: true });
    }

    handleSwipe() {
        const swipeThreshold = this.container.clientWidth * 0.3;
        const swipeDistance = this.touchStartX - this.touchEndX;

        if (Math.abs(swipeDistance) < swipeThreshold) return;

        if (swipeDistance > 0) {
            this.pauseAutoplay();
            this.next();
        } else {
            this.pauseAutoplay();
            this.prev();
        }
    }

    destroy() {
        this.stopAutoplay();
        if (this.entangleable) {
            this.entangleable.destroy();
        }
        this.component = null;
        this.container = null;
    }
}

export default Slider;
