window.StrataLightbox = function () {
    return {
        dialog: null,
        open: false,
        currentIndex: 0,
        currentGallery: null,
        galleries: {},
        items: [],
        isLoading: false,
        isZoomed: false,
        initialized: false,

        init() {
            if (this.initialized) {
                return;
            }
            this.initialized = true;

            this.$nextTick(() => {
                this.dialog = this.$el;
                this.discoverItems();
                this.setupEventListeners();
            });
        },

        discoverItems() {
            const elements = document.querySelectorAll('[data-lightbox]');

            elements.forEach((element) => {
                const galleryName = element.getAttribute('data-lightbox') || 'default';

                if (!this.galleries[galleryName]) {
                    this.galleries[galleryName] = [];
                }

                const itemIndex = this.galleries[galleryName].length;
                const item = this.createItemFromElement(element, itemIndex, galleryName);

                this.galleries[galleryName].push(item);

                element.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.openGallery(galleryName, itemIndex);
                });
            });
        },

        createItemFromElement(element, index, galleryName) {
            const type = this.detectMediaType(element);
            const url = this.getMediaUrl(element, type);
            const caption = this.getCaption(element);

            return {
                id: `lightbox-item-${galleryName}-${index}-${Math.random().toString(36).substr(2, 9)}`,
                type,
                url,
                caption,
                element,
                thumbnailUrl: this.getThumbnailUrl(element, type),
            };
        },

        detectMediaType(element) {
            if (element.tagName === 'IMG') return 'image';
            if (element.tagName === 'VIDEO') return 'video';

            const url = element.href || element.src || '';
            const ext = url.split('.').pop().split('?')[0].toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'].includes(ext)) {
                return 'image';
            }
            if (['mp4', 'webm', 'ogg', 'mov'].includes(ext)) {
                return 'video';
            }
            if (['pdf'].includes(ext)) {
                return 'document';
            }

            return 'image';
        },

        getMediaUrl(element, type) {
            if (type === 'image' && element.tagName === 'IMG') {
                return element.src;
            }
            if (type === 'video' && element.tagName === 'VIDEO') {
                return element.src || element.querySelector('source')?.src || '';
            }
            return element.href || element.src || '';
        },

        getThumbnailUrl(element, type) {
            if (type === 'image' && element.tagName === 'IMG') {
                return element.src;
            }
            if (type === 'video') {
                return element.poster || '';
            }
            return '';
        },

        getCaption(element) {
            if (element.dataset.lightboxCaption) {
                return element.dataset.lightboxCaption;
            }

            const figure = element.closest('figure');
            if (figure) {
                const figcaption = figure.querySelector('figcaption');
                if (figcaption) {
                    return figcaption.textContent.trim();
                }
            }

            return element.title || element.alt || '';
        },

        setupEventListeners() {
            this.dialog.addEventListener('close', () => {
                this.handleClose();
            });

            this.dialog.addEventListener('click', (e) => {
                if (e.target === this.dialog) {
                    this.close();
                }
            });
        },

        openGallery(galleryName, index = 0) {
            this.currentGallery = galleryName;
            this.items = this.galleries[galleryName] || [];
            this.currentIndex = Math.max(0, Math.min(index, this.items.length - 1));
            this.isZoomed = false;
            this.open = true;

            if (this.dialog && !this.dialog.open) {
                this.dialog.showModal();
                this.preloadAdjacentImages();
            }
        },

        close() {
            this.cleanupMedia();
            this.open = false;
            this.isZoomed = false;
            if (this.dialog && this.dialog.open) {
                this.dialog.close();
            }
        },

        handleClose() {
            this.cleanupMedia();
            this.open = false;
            this.isZoomed = false;
            this.currentGallery = null;
        },

        cleanupMedia() {
            const video = this.$el.querySelector('[data-strata-lightbox-video]');
            if (video) {
                video.pause();
                video.currentTime = 0;
            }
        },

        next() {
            if (this.currentIndex < this.items.length - 1) {
                this.currentIndex++;
                this.isZoomed = false;
                this.preloadAdjacentImages();
            }
        },

        prev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
                this.isZoomed = false;
                this.preloadAdjacentImages();
            }
        },

        goTo(index) {
            if (index >= 0 && index < this.items.length) {
                this.currentIndex = index;
                this.isZoomed = false;
                this.preloadAdjacentImages();
            }
        },

        toggleZoom() {
            if (this.currentItem?.type === 'image') {
                this.isZoomed = !this.isZoomed;
            }
        },

        handleKeydown(e) {
            if (!this.open) return;

            switch (e.key) {
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
                    this.goTo(this.items.length - 1);
                    break;
                case ' ':
                case 'Enter':
                    if (e.target === this.$refs.mediaContainer || e.target.closest('[data-strata-lightbox-image]')) {
                        e.preventDefault();
                        this.toggleZoom();
                    }
                    break;
            }
        },

        preloadAdjacentImages() {
            const currentItem = this.currentItem;
            if (!currentItem || currentItem.type !== 'image') return;

            [this.currentIndex - 1, this.currentIndex + 1].forEach(index => {
                if (index >= 0 && index < this.items.length) {
                    const item = this.items[index];
                    if (item.type === 'image') {
                        const img = new Image();
                        img.src = item.url;
                    }
                }
            });
        },

        handleImageLoad() {
            this.isLoading = false;
        },

        handleImageError() {
            this.isLoading = false;
        },

        get currentItem() {
            return this.items[this.currentIndex] || null;
        },

        get hasMultipleItems() {
            return this.items.length > 1;
        },

        get hasPrev() {
            return this.currentIndex > 0;
        },

        get hasNext() {
            return this.currentIndex < this.items.length - 1;
        },

        get counter() {
            if (!this.hasMultipleItems) return '';
            return `${this.currentIndex + 1} / ${this.items.length}`;
        },
    };
};
