/**
 * Carousel component using transform-based positioning
 *
 * @param {Object} props - Component properties
 * @param {boolean} props.loop - Enable infinite scrolling
 * @param {boolean} props.autoplay - Enable automatic slide progression
 * @param {number} props.autoplayDelay - Delay between slides in ms
 * @param {number} props.startIndex - Initial slide index
 * @param {boolean} props.playOnInit - Start autoplay immediately
 * @param {boolean} props.stopOnInteraction - Stop autoplay permanently after user interaction
 * @param {boolean} props.stopOnLastSnap - Stop autoplay at last slide instead of looping
 * @param {boolean} props.jump - Use instant transitions instead of animated
 */
export default function (props = {}) {
    return {
        loop: props.loop ?? false,
        autoplay: props.autoplay ?? false,
        autoplayDelay: props.autoplayDelay ?? 3000,
        startIndex: props.startIndex ?? 0,
        playOnInit: props.playOnInit ?? true,
        stopOnInteraction: props.stopOnInteraction ?? true,
        stopOnLastSnap: props.stopOnLastSnap ?? false,
        jump: props.jump ?? false,
        carouselId: props.id ?? null,

        currentIndex: 0,
        totalSlides: 0,
        slides: [],
        isDragging: false,
        dragStartX: 0,
        dragStartPosition: 0,
        isPlaying: false,
        autoplayInterval: null,
        touchIdentifier: null,
        dragDistance: 0,
        dragThreshold: 5,
        thresholdMet: false,
        preventClick: false,
        currentPosition: 0,
        targetPosition: 0,
        velocity: 0,
        lastMoveX: 0,
        lastMoveTime: 0,
        animationFrame: null,
        hasInteracted: false,

        init() {
            this.collectSlides();
            this.setupScrollObserver();
            this.registerStore();

            if (this.startIndex > 0 && this.startIndex < this.totalSlides) {
                this.scrollToSlide(this.startIndex, true);
            }

            if (this.autoplay && this.playOnInit) {
                this.startAutoplay();
            }

            this.dispatchEvent('carousel-init');
        },

        registerStore() {
            if (!this.carouselId) return;

            Alpine.store(`carousel-${this.carouselId}`, {
                currentIndex: this.currentIndex,
                totalSlides: this.totalSlides,
                scrollProgress: this.scrollProgress,
                canScrollNext: this.canScrollNext,
                canScrollPrev: this.canScrollPrev,
                isPlaying: this.isPlaying,
                next: () => this.next(),
                prev: () => this.prev(),
                scrollToSlide: (index) => this.scrollToSlide(index),
            });
        },

        updateStore() {
            if (!this.carouselId) return;

            const store = Alpine.store(`carousel-${this.carouselId}`);
            if (store) {
                store.currentIndex = this.currentIndex;
                store.totalSlides = this.totalSlides;
                store.scrollProgress = this.scrollProgress;
                store.canScrollNext = this.canScrollNext;
                store.canScrollPrev = this.canScrollPrev;
                store.isPlaying = this.isPlaying;
            }
        },

        destroy() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
            }
            if (this.carouselId) {
                delete Alpine.store(`carousel-${this.carouselId}`);
            }
        },

        collectSlides() {
            if (!this.$refs.container) return;

            this.slides = Array.from(this.$refs.container.querySelectorAll('[data-strata-carousel-slide]'));
            this.totalSlides = this.slides.length;

            this.slides.forEach((slide, index) => {
                slide.setAttribute('aria-label', `Slide ${index + 1} of ${this.totalSlides}`);
            });

            this.updateStore();
        },

        setupScrollObserver() {
            if (!this.$refs.viewport) return;

            this.$watch('totalSlides', () => {
                this.collectSlides();
            });

            const observer = new MutationObserver(() => {
                const newCount = this.$refs.container.querySelectorAll('[data-strata-carousel-slide]').length;
                if (newCount !== this.totalSlides) {
                    this.collectSlides();
                }
            });

            observer.observe(this.$refs.container, {
                childList: true,
                subtree: false
            });
        },

        scrollToSlide(index, immediate = false) {
            if (index < 0 || index >= this.totalSlides) return;

            const slide = this.slides[index];
            if (!slide) return;

            this.targetPosition = slide.offsetLeft;
            this.currentIndex = index;

            const shouldJump = immediate || this.jump;

            if (shouldJump) {
                this.currentPosition = this.targetPosition;
            } else {
                this.animateToTarget();
            }

            this.updateStore();
            this.dispatchEvent('carousel-settle', { index: this.currentIndex });
        },

        animateToTarget() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }

            const animate = () => {
                const diff = this.targetPosition - this.currentPosition;

                if (Math.abs(diff) < 0.5) {
                    this.currentPosition = this.targetPosition;
                    this.animationFrame = null;
                    return;
                }

                this.currentPosition += diff * 0.15;
                this.animationFrame = requestAnimationFrame(animate);
            };

            animate();
        },

        next() {
            this.hasInteracted = true;

            if (this.currentIndex < this.totalSlides - 1) {
                this.scrollToSlide(this.currentIndex + 1);
            } else if (this.loop) {
                this.scrollToSlide(0);
            } else if (this.stopOnLastSnap && this.isPlaying) {
                this.stopAutoplay();
            }
        },

        prev() {
            this.hasInteracted = true;

            if (this.currentIndex > 0) {
                this.scrollToSlide(this.currentIndex - 1);
            } else if (this.loop) {
                this.scrollToSlide(this.totalSlides - 1);
            }
        },

        get canScrollNext() {
            return this.loop || this.currentIndex < this.totalSlides - 1;
        },

        get canScrollPrev() {
            return this.loop || this.currentIndex > 0;
        },

        get scrollProgress() {
            if (this.totalSlides === 0) return 0;
            if (this.totalSlides === 1) return 1;

            return this.currentIndex / (this.totalSlides - 1);
        },

        handleDragStart(e) {
            if (!this.$refs.viewport || !this.$refs.container) return;

            const target = e.target;
            if (target.matches('input, select, textarea, button, a')) {
                return;
            }

            if (!e.type.includes('touch') && e.button !== 0) {
                return;
            }

            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
                this.animationFrame = null;
            }

            this.hasInteracted = true;
            this.isDragging = true;
            this.dragStartX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
            this.dragStartPosition = this.currentPosition;
            this.dragDistance = 0;
            this.thresholdMet = false;
            this.velocity = 0;
            this.lastMoveX = this.dragStartX;
            this.lastMoveTime = Date.now();

            if (e.type.includes('touch')) {
                this.touchIdentifier = e.touches[0].identifier;
            }

            this.pauseAutoplay();
        },

        handleDragMove(e) {
            if (!this.isDragging || !this.$refs.container) return;

            let clientX;

            if (e.type.includes('touch')) {
                const touches = Array.from(e.touches);
                const touch = touches.find(t => t.identifier === this.touchIdentifier);
                if (!touch) return;
                clientX = touch.clientX;
            } else {
                e.preventDefault();
                clientX = e.clientX;
            }

            const deltaX = this.dragStartX - clientX;
            this.dragDistance = Math.abs(deltaX);

            const now = Date.now();
            const timeDelta = now - this.lastMoveTime;

            if (timeDelta > 0) {
                this.velocity = (clientX - this.lastMoveX) / timeDelta;
            }

            this.lastMoveX = clientX;
            this.lastMoveTime = now;

            if (!this.thresholdMet && this.dragDistance > this.dragThreshold) {
                this.thresholdMet = true;
            }

            if (this.thresholdMet) {
                const newPosition = this.dragStartPosition + deltaX;
                const maxScroll = this.$refs.container.scrollWidth - this.$refs.viewport.offsetWidth;
                this.currentPosition = Math.max(0, Math.min(newPosition, maxScroll));
            }
        },

        handleDragEnd(e) {
            if (!this.isDragging) return;

            this.isDragging = false;
            this.touchIdentifier = null;

            if (this.dragDistance > 5) {
                this.preventClick = true;
                setTimeout(() => {
                    this.preventClick = false;
                }, 10);
            }

            const velocityThreshold = 0.5;
            if (Math.abs(this.velocity) > velocityThreshold) {
                this.applyMomentum();
            } else {
                this.snapToNearest();
            }

            this.resumeAutoplay();
        },

        applyMomentum() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }

            const deceleration = 0.95;

            const animate = () => {
                if (Math.abs(this.velocity) < 0.1) {
                    this.snapToNearest();
                    return;
                }

                this.velocity *= deceleration;
                this.currentPosition -= this.velocity * 16;

                const maxScroll = this.$refs.container.scrollWidth - this.$refs.viewport.offsetWidth;
                this.currentPosition = Math.max(0, Math.min(this.currentPosition, maxScroll));

                this.animationFrame = requestAnimationFrame(animate);
            };

            animate();
        },

        snapToNearest() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
                this.animationFrame = null;
            }

            const slideWidth = this.slides[0]?.offsetWidth || 0;
            if (slideWidth === 0) return;

            const nearestIndex = Math.round(this.currentPosition / slideWidth);
            const clampedIndex = Math.max(0, Math.min(nearestIndex, this.totalSlides - 1));

            this.scrollToSlide(clampedIndex);
        },

        startAutoplay() {
            if (this.isPlaying) return;

            this.isPlaying = true;
            this.autoplayInterval = setInterval(() => {
                this.next();
            }, this.autoplayDelay);
            this.updateStore();
        },

        stopAutoplay() {
            if (!this.isPlaying) return;

            this.isPlaying = false;
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
            this.updateStore();
        },

        pauseAutoplay() {
            if (!this.autoplay || !this.isPlaying) return;
            this.stopAutoplay();
        },

        resumeAutoplay() {
            if (!this.autoplay) return;
            if (this.stopOnInteraction && this.hasInteracted) return;
            this.startAutoplay();
        },

        dispatchEvent(eventName, detail = {}) {
            this.$el.dispatchEvent(new CustomEvent(eventName, {
                detail: {
                    ...detail,
                    currentIndex: this.currentIndex,
                    totalSlides: this.totalSlides,
                    scrollProgress: this.scrollProgress
                },
                bubbles: true
            }));
        }
    };
}
