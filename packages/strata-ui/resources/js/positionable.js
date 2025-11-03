import { computePosition, autoUpdate, flip, shift, offset, size, arrow, hide, autoPlacement, inline, limitShift } from '@floating-ui/dom';

/**
 * @typedef {Object} PositionableConfig
 * @property {string} [placement='bottom-start'] - Floating UI placement (e.g., 'top', 'bottom-start', 'right-end')
 * @property {number} [offset=8] - Distance in pixels between reference and floating element
 * @property {string} [strategy='absolute'] - Positioning strategy ('absolute' or 'fixed'). Always use 'absolute'
 * @property {number} [padding=5] - Padding for flip/shift middleware
 * @property {Element|undefined} [boundary] - Custom boundary element for overflow detection
 * @property {boolean} [enableSize=false] - Enable size middleware for responsive sizing
 * @property {boolean} [matchReferenceWidth=false] - Match floating element width to reference width (requires enableSize)
 * @property {boolean} [maxHeight=false] - Apply max-height constraint to prevent viewport overflow (requires enableSize)
 * @property {Function|null} [sizeApply=null] - Custom size apply function (overrides matchReferenceWidth/maxHeight)
 * @property {HTMLElement|null} [arrowElement=null] - Arrow element for visual pointer (enables arrow middleware)
 * @property {number} [arrowPadding=5] - Padding around arrow element
 * @property {boolean} [enableHide=false] - Enable hide middleware for visibility detection
 * @property {string} [hideStrategy='referenceHidden'] - Hide strategy ('referenceHidden' or 'escaped')
 * @property {boolean} [useAutoPlacement=false] - Use autoPlacement instead of flip (mutually exclusive)
 * @property {boolean} [enableInline=false] - Enable inline middleware for multi-line elements
 * @property {number|undefined} [inlineX] - X coordinate for inline positioning
 * @property {number|undefined} [inlineY] - Y coordinate for inline positioning
 * @property {boolean} [limitShiftEnabled=false] - Enable limitShift to prevent detachment
 * @property {Array} [customMiddleware=[]] - Array of custom middleware to append
 * @property {Object} [autoUpdateOptions] - Options for autoUpdate (ancestorScroll, ancestorResize, etc.)
 */

/**
 * @typedef {Object} PositionStyles
 * @property {string} position - CSS position value ('absolute' or 'fixed')
 * @property {string} left - Left position in pixels
 * @property {string} top - Top position in pixels
 */

/**
 * Positionable - Floating UI integration for positioned elements
 *
 * Manages positioning for dropdowns, popovers, tooltips, and other floating elements.
 * Uses Floating UI for smart positioning with comprehensive middleware support.
 *
 * Features:
 * - Conflict resolution (closes siblings, keeps ancestors/descendants)
 * - Mobile handling (disabled < 640px)
 * - Automatic position updates with configurable options
 * - Instance tracking
 * - Size constraints (max-height, width matching)
 * - Arrow/pointer positioning
 * - Auto-hide when reference scrolls out of view
 * - Custom boundaries and middleware injection
 *
 * @example Basic Dropdown
 * init() {
 *     this.positionable = new window.StrataPositionable({
 *         placement: 'bottom-start',
 *         offset: 8,
 *         strategy: 'absolute'
 *     });
 *
 *     const trigger = this.$refs.trigger;
 *     const content = this.$refs.content;
 *
 *     if (trigger && content) {
 *         this.positionable.start(this, trigger, content);
 *     }
 *
 *     this.$watch('open', (value) => {
 *         value ? this.positionable.open() : this.positionable.close();
 *     });
 *
 *     this.positionable.watch((state) => {
 *         if (!state) this.open = false;
 *     });
 * }
 *
 * @example Select with Size Constraints
 * init() {
 *     this.positionable = new window.StrataPositionable({
 *         placement: 'bottom-start',
 *         offset: 4,
 *         enableSize: true,
 *         matchReferenceWidth: true,
 *         maxHeight: true
 *     });
 *     // ... start and watch setup
 * }
 *
 * @example Tooltip with Arrow
 * init() {
 *     this.positionable = new window.StrataPositionable({
 *         placement: 'top',
 *         offset: 8,
 *         arrowElement: this.$refs.arrow,
 *         enableHide: true
 *     });
 *     // ... start and watch setup
 * }
 *
 * @example Advanced with Custom Boundary
 * init() {
 *     this.positionable = new window.StrataPositionable({
 *         placement: 'bottom-start',
 *         boundary: document.querySelector('#scroll-container'),
 *         padding: 10,
 *         useAutoPlacement: true
 *     });
 *     // ... start and watch setup
 * }
 */
export default class Positionable {
    /** @type {Set<Positionable>} All active Positionable instances */
    static instances = new Set();

    /**
     * @param {PositionableConfig} config - Configuration options
     */
    constructor(config = {}) {
        /** @type {PositionableConfig} Merged configuration */
        this.config = {
            placement: config.placement || 'bottom-start',
            offset: config.offset ?? 8,
            strategy: config.strategy || 'absolute',
            padding: config.padding ?? 5,
            boundary: config.boundary,
            enableSize: config.enableSize || false,
            matchReferenceWidth: config.matchReferenceWidth || false,
            maxHeight: config.maxHeight || false,
            sizeApply: config.sizeApply || null,
            arrowElement: config.arrowElement || null,
            arrowPadding: config.arrowPadding ?? 5,
            enableHide: config.enableHide || false,
            hideStrategy: config.hideStrategy || 'referenceHidden',
            useAutoPlacement: config.useAutoPlacement || false,
            enableInline: config.enableInline || false,
            inlineX: config.inlineX,
            inlineY: config.inlineY,
            limitShiftEnabled: config.limitShiftEnabled || false,
            customMiddleware: config.customMiddleware || [],
            autoUpdateOptions: config.autoUpdateOptions || {
                ancestorScroll: true,
                ancestorResize: true,
                elementResize: true,
                layoutShift: true,
                animationFrame: false
            }
        };

        /** @type {Function|null} Floating UI cleanup function */
        this.cleanup = null;

        /** @type {HTMLElement|null} Reference element (trigger) */
        this.reference = null;

        /** @type {HTMLElement|null} Floating element (dropdown/popover content) */
        this.floating = null;

        /** @type {Object|null} Alpine component instance */
        this.component = null;

        /** @type {boolean} Current open/closed state */
        this.state = false;

        /** @type {PositionStyles} Computed position styles */
        this.styles = {};

        /** @type {HTMLElement|null} Component wrapper element for hierarchy detection */
        this.wrapperElement = null;

        /** @type {Object} Middleware data from last compute */
        this.middlewareData = {};
    }

    /**
     * Initialize positioning and register instance
     *
     * Connects the Positionable to Alpine component, trigger, and floating elements.
     * Adds instance to global tracking and sets up auto-update on state changes.
     *
     * @param {Object} component - Alpine component instance (this)
     * @param {HTMLElement} reference - Trigger element
     * @param {HTMLElement} floating - Floating content element
     * @returns {Positionable} Returns this for method chaining
     *
     * @example
     * const trigger = this.$refs.trigger;
     * const content = this.$refs.content;
     * this.positionable.start(this, trigger, content);
     */
    start(component, reference, floating) {
        this.component = component;
        this.reference = reference;
        this.floating = floating;
        this.wrapperElement = component.$el;

        Positionable.instances.add(this);

        this.compute();

        this.watch(state => {
            if (state && window.innerWidth >= 640 && !this.cleanup) {
                this.component.$nextTick(() => this.syncPosition());
            }

            if (!state && this.cleanup) {
                this.cleanup();
                this.cleanup = null;
            }
        });

        return this;
    }

    /**
     * Watch state changes
     *
     * Registers a callback to be called when state (open/closed) changes.
     *
     * @param {function(boolean): void} callback - Function called with new state value
     * @returns {Positionable} Returns this for method chaining
     *
     * @example
     * this.positionable.watch((state) => {
     *     if (!state) {
     *         this.open = false;
     *     }
     * });
     */
    watch(callback) {
        queueMicrotask(() => {
            this.component.$watch(() => this.state, (value) => callback(value));
        });
        return this;
    }

    /**
     * Sync position with autoUpdate
     *
     * Sets up Floating UI's autoUpdate to continuously track position changes.
     * Disabled on mobile (< 640px width).
     *
     * @private
     */
    syncPosition() {
        if (window.innerWidth < 640) {
            return;
        }

        this.cleanup = autoUpdate(
            this.reference,
            this.floating,
            () => this.compute(),
            this.config.autoUpdateOptions
        );
    }

    /**
     * Compute position using Floating UI
     *
     * Calculates optimal position for floating element relative to reference element.
     * Updates styles property with computed position.
     *
     * Middleware (applied conditionally based on config):
     * - offset: Adds spacing between reference and floating
     * - inline: Positions relative to inline elements (multi-line)
     * - flip OR autoPlacement: Flips placement if doesn't fit OR chooses best placement
     * - shift: Shifts floating element to keep in view
     * - size: Applies sizing constraints (max-height, width matching)
     * - arrow: Positions arrow element
     * - hide: Detects when element should be hidden
     * - custom: Any custom middleware from config
     *
     * @private
     */
    compute() {
        if (!this.reference || !this.floating) {
            return;
        }

        const middleware = [];

        middleware.push(offset(this.config.offset));

        if (this.config.enableInline) {
            middleware.push(inline({
                x: this.config.inlineX,
                y: this.config.inlineY,
                padding: 2
            }));
        }

        if (this.config.useAutoPlacement) {
            middleware.push(autoPlacement({
                padding: this.config.padding
            }));
        } else {
            middleware.push(flip({
                padding: this.config.padding,
                boundary: this.config.boundary
            }));
        }

        const shiftOptions = {
            padding: this.config.padding,
            boundary: this.config.boundary
        };

        if (this.config.limitShiftEnabled) {
            shiftOptions.limiter = limitShift();
        }

        middleware.push(shift(shiftOptions));

        if (this.config.enableSize) {
            if (this.config.sizeApply) {
                middleware.push(size({
                    apply: this.config.sizeApply,
                    padding: this.config.padding
                }));
            } else {
                middleware.push(size({
                    apply: ({ availableWidth, availableHeight, rects, elements }) => {
                        const styles = {};

                        if (this.config.maxHeight) {
                            styles.maxHeight = `${Math.max(0, availableHeight - 10)}px`;
                            styles.overflowY = 'auto';
                        }

                        if (this.config.matchReferenceWidth) {
                            styles.minWidth = `${rects.reference.width}px`;
                        }

                        Object.assign(elements.floating.style, styles);
                    },
                    padding: this.config.padding
                }));
            }
        }

        if (this.config.arrowElement) {
            middleware.push(arrow({
                element: this.config.arrowElement,
                padding: this.config.arrowPadding
            }));
        }

        if (this.config.enableHide) {
            middleware.push(hide({
                strategy: this.config.hideStrategy
            }));
        }

        middleware.push(...this.config.customMiddleware);

        computePosition(this.reference, this.floating, {
            placement: this.config.placement,
            strategy: this.config.strategy,
            middleware
        }).then(({ x, y, placement, middlewareData }) => {
            this.styles = {
                position: this.config.strategy,
                left: `${x}px`,
                top: `${y}px`
            };

            this.middlewareData = middlewareData;

            if (middlewareData.arrow && this.config.arrowElement) {
                this.applyArrowPosition(placement, middlewareData.arrow);
            }

            if (middlewareData.hide) {
                this.applyHideVisibility(middlewareData.hide);
            }
        });
    }

    /**
     * Open the floating element
     *
     * Closes conflicting instances (siblings), computes position, and sets state to true.
     *
     * @example
     * this.positionable.open();
     */
    open() {
        this.closeConflictingInstances();
        this.compute();
        this.component.$nextTick(() => {
            this.state = true;
        });
    }

    /**
     * Open only if currently closed
     *
     * @example
     * this.positionable.openIfClosed();
     */
    openIfClosed() {
        if (!this.state) {
            this.open();
        }
    }

    /**
     * Close the floating element
     *
     * Sets state to false, triggering watcher callbacks.
     *
     * @example
     * this.positionable.close();
     */
    close() {
        this.state = false;
    }

    /**
     * Toggle between open and closed states
     *
     * @example
     * this.positionable.toggle();
     */
    toggle() {
        if (this.state) {
            this.close();
        } else {
            this.open();
        }
    }

    /**
     * Close conflicting instances (siblings only)
     *
     * Closes other open Positionable instances that are not ancestors or descendants.
     * This allows nested dropdowns to remain open while closing siblings.
     *
     * Hierarchy logic:
     * - Ancestor: Instance wrapper contains this wrapper (keep open)
     * - Descendant: This wrapper contains instance wrapper (keep open)
     * - Sibling: No containment relationship (close)
     *
     * @private
     */
    closeConflictingInstances() {
        Positionable.instances.forEach(instance => {
            if (instance === this || !instance.state) {
                return;
            }

            const isAncestor = instance.wrapperElement?.contains(this.wrapperElement);
            const isDescendant = this.wrapperElement?.contains(instance.wrapperElement);

            if (!isAncestor && !isDescendant) {
                instance.close();
            }
        });
    }

    /**
     * Apply arrow position from middleware data
     *
     * Positions the arrow element based on Floating UI calculations.
     * Uses loose equality check for null/undefined as per Floating UI docs.
     *
     * @param {string} placement - Final placement (e.g., 'top', 'bottom-start')
     * @param {Object} arrowData - Arrow middleware data with x, y, centerOffset
     * @private
     */
    applyArrowPosition(placement, arrowData) {
        const { x, y, centerOffset } = arrowData;
        const arrowElement = this.config.arrowElement;

        if (!arrowElement) {
            return;
        }

        const staticSide = {
            top: 'bottom',
            right: 'left',
            bottom: 'top',
            left: 'right',
        }[placement.split('-')[0]];

        Object.assign(arrowElement.style, {
            left: x != null ? `${x}px` : '',
            top: y != null ? `${y}px` : '',
            right: '',
            bottom: '',
            [staticSide]: '-4px'
        });
    }

    /**
     * Apply visibility based on hide middleware data
     *
     * Hides floating element when reference is hidden or content has escaped.
     *
     * @param {Object} hideData - Hide middleware data
     * @private
     */
    applyHideVisibility(hideData) {
        if (!this.floating) {
            return;
        }

        const isHidden = hideData.referenceHidden || hideData.escaped;
        this.floating.style.visibility = isHidden ? 'hidden' : 'visible';
    }

    /**
     * Clean up resources and remove from instance tracking
     *
     * Call in Alpine component destroy() method to prevent memory leaks.
     *
     * @example
     * destroy() {
     *     this.positionable?.destroy();
     * }
     */
    destroy() {
        if (this.cleanup) {
            this.cleanup();
            this.cleanup = null;
        }
        Positionable.instances.delete(this);
    }
}
