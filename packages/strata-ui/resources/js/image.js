/**
 * Image - Alpine.js data function for image component with loading/error states
 *
 * Provides loading states, error handling, and fallback chain for images.
 *
 * @param {string} src - Primary image source URL
 * @param {string|null} [fallbackSrc=null] - Fallback image URL if primary fails
 * @param {string} [fallbackIcon='image'] - Icon name to show if all images fail
 * @returns {Object} Alpine.js data object with image state management
 *
 * @example
 * // In Blade component
 * <div x-data="window.StrataImage('image.jpg', 'fallback.jpg', 'image')">
 *     <img x-show="shouldShowImage"
 *          :src="currentSrc"
 *          @load="handleLoad"
 *          @error="handleError" />
 *
 *     <div x-show="shouldShowSkeleton">Loading...</div>
 *     <div x-show="shouldShowFallback">
 *         <x-strata::icon :name="fallbackIcon" />
 *     </div>
 * </div>
 */
export default (src, fallbackSrc = null, fallbackIcon = 'image') => ({
    /** @type {boolean} Whether image is currently loading */
    isLoading: true,

    /** @type {boolean} Whether image failed to load */
    hasError: false,

    /** @type {string} Current image source (switches to fallback on error) */
    currentSrc: src,

    /** @type {string} Icon name for ultimate fallback */
    fallbackIcon: fallbackIcon,

    /** @type {boolean} Whether to show placeholder state */
    showPlaceholder: true,

    /**
     * Initialize image state
     * If no source provided, immediately show fallback
     */
    init() {
        if (!this.currentSrc) {
            this.handleError();
        }
    },

    /**
     * Handle successful image load
     * Hides loading and error states
     */
    handleLoad() {
        this.isLoading = false;
        this.hasError = false;
        this.showPlaceholder = false;
    },

    /**
     * Handle image load error
     * Attempts fallback source if available, otherwise shows icon
     */
    handleError() {
        this.isLoading = false;
        this.hasError = true;
        this.showPlaceholder = false;

        if (fallbackSrc && this.currentSrc !== fallbackSrc) {
            this.currentSrc = fallbackSrc;
            this.hasError = false;
            this.isLoading = true;
        }
    },

    /**
     * @returns {boolean} Whether to display the image element
     */
    get shouldShowImage() {
        return this.currentSrc && !this.hasError;
    },

    /**
     * @returns {boolean} Whether to display fallback icon
     */
    get shouldShowFallback() {
        return this.hasError || !this.currentSrc;
    },

    /**
     * @returns {boolean} Whether to display loading skeleton
     */
    get shouldShowSkeleton() {
        return this.isLoading && !this.hasError;
    }
});
