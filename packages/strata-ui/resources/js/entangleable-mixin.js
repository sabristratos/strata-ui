/**
 * Create an Entangleable mixin for Alpine components
 *
 * Provides standardized setup for bidirectional Alpine ↔ Livewire state synchronization.
 *
 * @param {Object} config - Mixin configuration
 * @param {*} config.initialValue - Initial value for entangleable (default: null)
 * @param {string} config.inputSelector - Selector for hidden input element (default: 'input[type="hidden"]')
 * @param {Function} config.beforeWatch - Callback before watch handler (receives component context)
 * @param {Function} config.afterWatch - Callback in watch handler (receives newValue, component context)
 * @returns {Object} Alpine data object with entangleable setup
 */
export function createEntangleableMixin(config = {}) {
    const {
        initialValue = null,
        inputSelector = 'input[type="hidden"]',
        beforeWatch = null,
        afterWatch = null
    } = config;

    return {
        entangleable: null,

        initEntangleable() {
            this.entangleable = new window.StrataEntangleable(initialValue);

            const input = this.$el.querySelector(inputSelector);
            if (input) {
                this.entangleable.setupLivewire(this, input);
            }

            if (beforeWatch) {
                beforeWatch.call(this);
            }

            this.entangleable.watch((newValue) => {
                if (afterWatch) {
                    afterWatch.call(this, newValue);
                }
            });
        }
    };
}
