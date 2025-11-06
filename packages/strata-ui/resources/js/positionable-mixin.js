/**
 * Create a Positionable mixin for Alpine components
 *
 * Provides standardized setup for Floating UI positioning with Positionable.
 *
 * @param {Object} config - Mixin configuration
 * @param {string} config.placement - Placement option for Floating UI (default: 'bottom-start')
 * @param {number} config.offset - Offset from reference element (default: 8)
 * @param {string} config.strategy - Positioning strategy: 'absolute'|'fixed' (default: 'absolute')
 * @param {boolean} config.enableSize - Enable size middleware (default: false)
 * @param {boolean} config.matchReferenceWidth - Match reference element width (default: false)
 * @param {boolean} config.maxHeight - Enable maxHeight constraint (default: false)
 * @param {boolean} config.enableHide - Enable hide middleware (default: false)
 * @param {string} config.hideStrategy - Hide strategy: 'referenceHidden'|'escaped' (default: 'referenceHidden')
 * @param {string} config.triggerRef - Name of $ref for trigger element (default: 'trigger')
 * @param {string} config.floatingRef - Name of $ref for floating element (default: 'dropdown')
 * @param {string|null} config.triggerSelector - Query selector for trigger (overrides triggerRef)
 * @param {string} config.stateProperty - Property name for open/close state (default: 'open')
 * @param {Function} config.onOpen - Callback when opening (receives component context)
 * @param {Function} config.onClose - Callback when closing (receives component context)
 * @param {Function} config.beforeInit - Callback before Positionable init (receives component context)
 * @param {Function} config.afterInit - Callback after Positionable init (receives component context)
 * @returns {Object} Alpine data object with positionable setup
 */
export function createPositionableMixin(config = {}) {
    const {
        placement = 'bottom-start',
        offset = 8,
        strategy = 'absolute',
        enableSize = false,
        matchReferenceWidth = false,
        maxHeight = false,
        enableHide = false,
        hideStrategy = 'referenceHidden',
        triggerRef = 'trigger',
        floatingRef = 'dropdown',
        triggerSelector = null,
        stateProperty = 'open',
        onOpen = null,
        onClose = null,
        beforeInit = null,
        afterInit = null
    } = config;

    return {
        positionable: null,

        initPositionable() {
            if (beforeInit) {
                beforeInit.call(this);
            }

            const positionableConfig = {
                placement,
                offset,
                strategy
            };

            if (enableSize) positionableConfig.enableSize = true;
            if (matchReferenceWidth) positionableConfig.matchReferenceWidth = true;
            if (maxHeight) positionableConfig.maxHeight = true;
            if (enableHide) {
                positionableConfig.enableHide = true;
                positionableConfig.hideStrategy = hideStrategy;
            }

            this.positionable = new window.StrataPositionable(positionableConfig);

            const trigger = triggerSelector
                ? document.querySelector(triggerSelector)
                : this.$refs[triggerRef];
            const floating = this.$refs[floatingRef];

            if (trigger && floating) {
                this.positionable.start(this, trigger, floating);
            }

            this.$watch(stateProperty, (value) => {
                if (value) {
                    this.positionable.open();
                    if (onOpen) {
                        this.$nextTick(() => {
                            onOpen.call(this);
                        });
                    }
                } else {
                    this.positionable.close();
                    if (onClose) {
                        onClose.call(this);
                    }
                }
            });

            if (this.positionable.component) {
                this.positionable.watch((state) => {
                    if (!state) {
                        this[stateProperty] = false;
                    }
                });
            }

            if (afterInit) {
                afterInit.call(this);
            }
        },

        destroyPositionable() {
            if (this.positionable) {
                this.positionable.destroy();
            }
        }
    };
}
