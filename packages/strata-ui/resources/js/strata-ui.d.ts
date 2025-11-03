/**
 * Strata UI TypeScript Definitions
 *
 * Type definitions for Strata UI JavaScript modules.
 * Provides IntelliSense and type checking for TypeScript/JavaScript projects.
 */

/**
 * Callback function for Entangleable watchers
 */
export type WatcherCallback = (newValue: any, oldValue: any) => void;

/**
 * Bidirectional state synchronization between Alpine.js and Livewire
 */
export class Entangleable {
    /**
     * Current value of the entangled state
     */
    value: any;

    /**
     * Registered watcher callbacks
     */
    watchers: WatcherCallback[];

    /**
     * Alpine component instance
     */
    component: any | null;

    /**
     * Livewire model property name
     */
    wireModelProperty: string | null;

    /**
     * Alpine model property name
     */
    alpineModelProperty: string | null;

    /**
     * Create a new Entangleable instance
     * @param initialValue - Initial value for the entangled state
     */
    constructor(initialValue?: any);

    /**
     * Register a watcher callback to be notified of value changes
     * @param callback - Function called when value changes (newValue, oldValue)
     * @returns Returns this for method chaining
     */
    watch(callback: WatcherCallback): this;

    /**
     * Set a new value and notify watchers if changed
     * @param value - New value to set
     */
    set(value: any): void;

    /**
     * Get the current value
     * @returns Current entangled value
     */
    get(): any;

    /**
     * Setup bidirectional sync with Livewire via wire:model attribute
     * @param component - Alpine component instance
     * @param inputElement - Input element with wire:model attribute
     */
    setupLivewire(component: any, inputElement: HTMLElement): void;

    /**
     * Setup sync with Alpine component property
     * @param component - Alpine component instance
     * @param modelProperty - Property name on component to sync with
     */
    setupAlpine(component: any, modelProperty: string): void;

    /**
     * Clean up watchers and references
     */
    destroy(): void;
}

/**
 * Configuration for Positionable
 */
export interface PositionableConfig {
    /**
     * Floating UI placement
     * @default 'bottom-start'
     */
    placement?: string;

    /**
     * Distance in pixels between reference and floating element
     * @default 8
     */
    offset?: number;

    /**
     * Positioning strategy ('absolute' or 'fixed'). Always use 'absolute'
     * @default 'absolute'
     */
    strategy?: 'absolute' | 'fixed';
}

/**
 * Computed position styles
 */
export interface PositionStyles {
    /**
     * CSS position value
     */
    position: string;

    /**
     * Left position in pixels
     */
    left: string;

    /**
     * Top position in pixels
     */
    top: string;
}

/**
 * Floating UI integration for positioned elements
 */
export class Positionable {
    /**
     * All active Positionable instances
     */
    static instances: Set<Positionable>;

    /**
     * Merged configuration
     */
    config: PositionableConfig;

    /**
     * Floating UI cleanup function
     */
    cleanup: (() => void) | null;

    /**
     * Reference element (trigger)
     */
    reference: HTMLElement | null;

    /**
     * Floating element (dropdown/popover content)
     */
    floating: HTMLElement | null;

    /**
     * Alpine component instance
     */
    component: any | null;

    /**
     * Current open/closed state
     */
    state: boolean;

    /**
     * Computed position styles
     */
    styles: PositionStyles;

    /**
     * Component wrapper element for hierarchy detection
     */
    wrapperElement: HTMLElement | null;

    /**
     * Create a new Positionable instance
     * @param config - Configuration options
     */
    constructor(config?: PositionableConfig);

    /**
     * Initialize positioning and register instance
     * @param component - Alpine component instance
     * @param reference - Trigger element
     * @param floating - Floating content element
     * @returns Returns this for method chaining
     */
    start(component: any, reference: HTMLElement, floating: HTMLElement): this;

    /**
     * Watch state changes
     * @param callback - Function called with new state value
     * @returns Returns this for method chaining
     */
    watch(callback: (state: boolean) => void): this;

    /**
     * Open the floating element
     */
    open(): void;

    /**
     * Open only if currently closed
     */
    openIfClosed(): void;

    /**
     * Close the floating element
     */
    close(): void;

    /**
     * Toggle between open and closed states
     */
    toggle(): void;

    /**
     * Clean up resources and remove from instance tracking
     */
    destroy(): void;
}

/**
 * Alpine.js data object for image component
 */
export interface ImageData {
    /**
     * Whether image is currently loading
     */
    isLoading: boolean;

    /**
     * Whether image failed to load
     */
    hasError: boolean;

    /**
     * Current image source (switches to fallback on error)
     */
    currentSrc: string;

    /**
     * Icon name for ultimate fallback
     */
    fallbackIcon: string;

    /**
     * Whether to show placeholder state
     */
    showPlaceholder: boolean;

    /**
     * Initialize image state
     */
    init(): void;

    /**
     * Handle successful image load
     */
    handleLoad(): void;

    /**
     * Handle image load error
     */
    handleError(): void;

    /**
     * Whether to display the image element
     */
    readonly shouldShowImage: boolean;

    /**
     * Whether to display fallback icon
     */
    readonly shouldShowFallback: boolean;

    /**
     * Whether to display loading skeleton
     */
    readonly shouldShowSkeleton: boolean;
}

/**
 * Create Alpine.js data for image component
 * @param src - Primary image source URL
 * @param fallbackSrc - Fallback image URL if primary fails
 * @param fallbackIcon - Icon name to show if all images fail
 * @returns Alpine.js data object with image state management
 */
export type ImageFactory = (
    src: string,
    fallbackSrc?: string | null,
    fallbackIcon?: string
) => ImageData;

/**
 * Toast notification options
 */
export interface ToastOptions {
    /**
     * Toast variant
     * @default 'default'
     */
    variant?: 'default' | 'success' | 'error' | 'warning' | 'info';

    /**
     * Toast title
     */
    title?: string;

    /**
     * Toast description/message
     */
    description?: string;

    /**
     * Auto-dismiss duration in milliseconds
     */
    duration?: number;

    /**
     * Whether toast can be dismissed
     * @default true
     */
    dismissible?: boolean;
}

/**
 * Toast API
 */
export interface Toast {
    /**
     * Display a toast notification
     * @param options - Toast configuration or message string
     */
    (options: ToastOptions | string): void;

    /**
     * Display a success toast
     * @param title - Toast title
     * @param description - Optional description
     */
    success(title: string, description?: string | null): void;

    /**
     * Display an error toast
     * @param title - Toast title
     * @param description - Optional description
     */
    error(title: string, description?: string | null): void;

    /**
     * Display a warning toast
     * @param title - Toast title
     * @param description - Optional description
     */
    warning(title: string, description?: string | null): void;

    /**
     * Display an info toast
     * @param title - Toast title
     * @param description - Optional description
     */
    info(title: string, description?: string | null): void;
}

/**
 * Global window extensions
 */
declare global {
    interface Window {
        /**
         * Bidirectional Alpine ↔ Livewire state synchronization
         */
        StrataEntangleable: typeof Entangleable;

        /**
         * Floating UI positioning for dropdowns/popovers/tooltips
         */
        StrataPositionable: typeof Positionable;

        /**
         * Image component with loading/error states
         */
        StrataImage: ImageFactory;

        /**
         * Toast notification API
         */
        toast: Toast;
    }
}

export {};
