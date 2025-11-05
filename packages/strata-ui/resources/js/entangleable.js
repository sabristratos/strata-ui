/**
 * @typedef {function(*, *): void} WatcherCallback
 */

/**
 * Entangleable - Bidirectional state synchronization between Alpine.js and Livewire
 *
 * Manages state that needs to be synchronized between Alpine (client-side UI state)
 * and Livewire (server-side persistence). Supports watchers for reactive updates.
 *
 * @example
 * // In Alpine component
 * init() {
 *     this.entangleable = new window.StrataEntangleable(['option1', 'option2']);
 *
 *     const input = this.$el.querySelector('[wire\\:model]');
 *     if (input) {
 *         this.entangleable.setupLivewire(this, input);
 *     }
 *
 *     this.entangleable.watch((newValue, oldValue) => {
 *         console.log('Value changed:', oldValue, '->', newValue);
 *     });
 * }
 */
export default class Entangleable {
    /**
     * @param {*} initialValue - Initial value for the entangled state
     */
    constructor(initialValue = null) {
        /** @type {*} Current value of the entangled state */
        this.value = initialValue;

        /** @type {WatcherCallback[]} Registered watcher callbacks */
        this.watchers = [];

        /** @type {Object|null} Alpine component instance */
        this.component = null;

        /** @type {string|null} Livewire model property name */
        this.wireModelProperty = null;

        /** @type {string|null} Alpine model property name */
        this.alpineModelProperty = null;
    }

    /**
     * Register a watcher callback to be notified of value changes
     *
     * @param {WatcherCallback} callback - Function called when value changes (newValue, oldValue)
     * @returns {Entangleable} Returns this for method chaining
     *
     * @example
     * entangleable.watch((newValue, oldValue) => {
     *     console.log('Changed from', oldValue, 'to', newValue);
     * });
     */
    watch(callback) {
        this.watchers.push(callback);
        return this;
    }

    /**
     * Set a new value and notify watchers if changed
     *
     * Uses JSON.stringify for deep equality comparison. If value differs,
     * notifies all watchers and syncs to Livewire if configured.
     *
     * @param {*} value - New value to set
     *
     * @example
     * entangleable.set(['new', 'values']);
     */
    set(value) {
        const oldValue = this.value;
        this.value = value;

        if (JSON.stringify(oldValue) !== JSON.stringify(value)) {
            this.notifyWatchers(value, oldValue);
            this.syncToLivewire();
        }
    }

    /**
     * Get the current value
     *
     * @returns {*} Current entangled value
     *
     * @example
     * const currentValue = entangleable.get();
     */
    get() {
        return this.value;
    }

    /**
     * Notify all registered watchers of a value change
     *
     * @private
     * @param {*} newValue - New value
     * @param {*} oldValue - Previous value
     */
    notifyWatchers(newValue, oldValue) {
        this.watchers.forEach(callback => callback(newValue, oldValue));
    }

    /**
     * Sync current value to Livewire component
     *
     * Re-detects wire:model property on each sync to handle morphing scenarios
     * where the wire:model attribute may have changed (e.g., switching between
     * wire:model="appointmentDate" and wire:model="recurringDateRange").
     *
     * @private
     */
    syncToLivewire() {
        if (!this.component?.$wire) return;

        const inputElement = this.component.$refs?.input ||
                            this.component.$el?.querySelector('[data-strata-date-picker-input]') ||
                            this.component.$el?.querySelector('[data-strata-datepicker-input]') ||
                            this.component.$el?.querySelector('[data-strata-select-input]') ||
                            this.component.$el?.querySelector('[data-strata-calendar-input]') ||
                            this.component.$el?.querySelector('[data-strata-range-slider-input]') ||
                            this.component.$el?.querySelector('[wire\\:model]');

        if (inputElement) {
            const wireModelAttribute = Array.from(inputElement.getAttributeNames())
                .find(attr => attr.startsWith('wire:model'));

            if (wireModelAttribute) {
                const currentProperty = inputElement.getAttribute(wireModelAttribute);
                if (currentProperty !== this.wireModelProperty) {
                    this.wireModelProperty = currentProperty;
                }
            }
        }

        if (this.wireModelProperty) {
            this.component.$wire.set(this.wireModelProperty, this.value);
        }
    }

    /**
     * Sync value from Livewire component to local state
     *
     * @private
     */
    syncFromLivewire() {
        if (this.component?.$wire && this.wireModelProperty) {
            const serverValue = this.component.$wire.get(this.wireModelProperty);
            if (serverValue !== undefined) {
                this.value = serverValue;
                this.notifyWatchers(this.value, null);
            }
        }
    }

    /**
     * Setup bidirectional sync with Livewire via wire:model attribute
     *
     * Auto-detects wire:model* attribute on input element and establishes
     * two-way binding with Livewire component property.
     *
     * @param {Object} component - Alpine component instance (this)
     * @param {HTMLElement} inputElement - Input element with wire:model attribute
     *
     * @example
     * const input = this.$el.querySelector('[data-strata-select-input]');
     * if (input) {
     *     this.entangleable.setupLivewire(this, input);
     * }
     */
    setupLivewire(component, inputElement) {
        if (!inputElement) return;

        const wireModelAttribute = Array.from(inputElement.getAttributeNames())
            .find(attr => attr.startsWith('wire:model'));

        if (!wireModelAttribute) return;

        this.component = component;

        if (!component.$wire) return;

        this.wireModelProperty = inputElement.getAttribute(wireModelAttribute);

        this.syncFromLivewire();

        component.$wire.$watch(this.wireModelProperty, (value) => {
            if (JSON.stringify(this.value) !== JSON.stringify(value)) {
                const oldValue = this.value;
                this.value = value;
                this.notifyWatchers(value, oldValue);
            }
        });
    }

    /**
     * Setup sync with Alpine component property
     *
     * Syncs Entangleable value with a property on the Alpine component.
     * Useful when not using Livewire or for additional local state sync.
     *
     * @param {Object} component - Alpine component instance (this)
     * @param {string} modelProperty - Property name on component to sync with
     *
     * @example
     * this.entangleable.setupAlpine(this, 'selectedItems');
     */
    setupAlpine(component, modelProperty) {
        this.component = component;
        this.alpineModelProperty = modelProperty;

        if (modelProperty && component[modelProperty] !== undefined) {
            this.value = component[modelProperty];
        }

        this.watch((newValue) => {
            if (modelProperty && component[modelProperty] !== newValue) {
                component[modelProperty] = newValue;
            }
        });
    }

    /**
     * Clean up watchers and references
     *
     * Call in Alpine component destroy() method to prevent memory leaks.
     *
     * @example
     * destroy() {
     *     this.entangleable?.destroy();
     * }
     */
    destroy() {
        this.watchers = [];
        this.component = null;
        this.wireModelProperty = null;
        this.alpineModelProperty = null;
        this.value = null;
    }
}
