/**
 * Keyboard Navigation Mixin
 *
 * Provides reusable keyboard navigation for list-based components.
 * Supports arrow keys, Home/End, typeahead search, and ARIA activedescendant.
 *
 * @param {Object} config Configuration options
 * @returns {Object} Alpine.js mixin object
 */
export function createKeyboardNavigationMixin(config = {}) {
    const {
        itemSelector = '[data-item]',
        itemsProperty = 'items',
        highlightedProperty = 'highlighted',
        collectItems = null,
        itemMapper = (el) => ({
            element: el,
            text: el.textContent.trim(),
            disabled: el.hasAttribute('data-disabled')
        }),
        filteredItemsGetter = null,
        onActivate = null,
        defaultActivation = 'click',
        openProperty = 'open',
        openKeys = ['Enter', ' ', 'ArrowDown'],
        enableTypeahead = false,
        typeaheadTimeout = 500,
        typeaheadMatcher = (item, buffer) => item.text.toLowerCase().startsWith(buffer),
        onOpen = null,
        onClose = null,
        generateItemId = (item, index) => item.element?.id || `item-${index}`,
    } = config;

    return {
        [highlightedProperty]: -1,
        [itemsProperty]: [],

        ...(enableTypeahead ? {
            typeaheadBuffer: '',
            typeaheadTimeout: null,
        } : {}),

        initKeyboardNavigation() {
            this.$nextTick(() => {
                this.collectKeyboardItems();
            });
        },

        collectKeyboardItems() {
            if (collectItems) {
                this[itemsProperty] = collectItems.call(this);
            } else {
                const elements = this.$el.querySelectorAll(itemSelector);
                this[itemsProperty] = Array.from(elements).map(itemMapper);
            }
        },

        getAvailableItems() {
            const items = filteredItemsGetter
                ? this[filteredItemsGetter]
                : this[itemsProperty];

            return items.filter(item => !item.disabled);
        },

        highlightNext() {
            const available = this.getAvailableItems();
            if (available.length === 0) return;

            const allItems = filteredItemsGetter ? this[filteredItemsGetter] : this[itemsProperty];

            if (this[highlightedProperty] === -1) {
                this[highlightedProperty] = filteredItemsGetter ? 0 : allItems.indexOf(available[0]);
            } else {
                if (filteredItemsGetter) {
                    this[highlightedProperty] = (this[highlightedProperty] + 1) % available.length;
                } else {
                    const currentInAvailable = available.findIndex(
                        item => allItems.indexOf(item) === this[highlightedProperty]
                    );
                    const nextItem = available[(currentInAvailable + 1) % available.length];
                    this[highlightedProperty] = allItems.indexOf(nextItem);
                }
            }

        },

        highlightPrevious() {
            const available = this.getAvailableItems();
            if (available.length === 0) return;

            const allItems = filteredItemsGetter ? this[filteredItemsGetter] : this[itemsProperty];

            if (this[highlightedProperty] === -1) {
                this[highlightedProperty] = filteredItemsGetter
                    ? available.length - 1
                    : allItems.indexOf(available[available.length - 1]);
            } else {
                if (filteredItemsGetter) {
                    this[highlightedProperty] = (this[highlightedProperty] - 1 + available.length) % available.length;
                } else {
                    const currentInAvailable = available.findIndex(
                        item => allItems.indexOf(item) === this[highlightedProperty]
                    );
                    const prevItem = available[(currentInAvailable - 1 + available.length) % available.length];
                    this[highlightedProperty] = allItems.indexOf(prevItem);
                }
            }

        },

        highlightFirst() {
            const available = this.getAvailableItems();
            if (available.length === 0) return;

            const allItems = filteredItemsGetter ? this[filteredItemsGetter] : this[itemsProperty];
            this[highlightedProperty] = filteredItemsGetter ? 0 : allItems.indexOf(available[0]);
        },

        highlightLast() {
            const available = this.getAvailableItems();
            if (available.length === 0) return;

            const allItems = filteredItemsGetter ? this[filteredItemsGetter] : this[itemsProperty];
            this[highlightedProperty] = filteredItemsGetter
                ? available.length - 1
                : allItems.indexOf(available[available.length - 1]);
        },

        activateHighlighted() {
            const items = filteredItemsGetter ? this[filteredItemsGetter] : this[itemsProperty];
            const item = items[this[highlightedProperty]];

            if (!item || item.disabled) return;

            if (onActivate) {
                onActivate.call(this, item);
            } else if (defaultActivation === 'click' && item.element) {
                item.element.click();
            }
        },

        getActiveDescendant() {
            const items = filteredItemsGetter ? this[filteredItemsGetter] : this[itemsProperty];
            const item = items[this[highlightedProperty]];

            if (!item) return '';
            return generateItemId(item, this[highlightedProperty]);
        },

        ...(enableTypeahead ? {
            handleTypeahead(key) {
                clearTimeout(this.typeaheadTimeout);

                this.typeaheadBuffer += key.toLowerCase();

                const available = this.getAvailableItems();
                const matchingItem = available.find(item =>
                    typeaheadMatcher(item, this.typeaheadBuffer)
                );

                if (matchingItem) {
                    const allItems = this[itemsProperty];
                    this[highlightedProperty] = allItems.indexOf(matchingItem);
                }

                this.typeaheadTimeout = setTimeout(() => {
                    this.typeaheadBuffer = '';
                }, typeaheadTimeout);
            }
        } : {}),

        handleKeyboardNavigation(e) {
            const isOpen = this[openProperty];

            if (!isOpen) {
                if (openKeys.includes(e.key)) {
                    e.preventDefault();
                    this[openProperty] = true;
                    if (onOpen) onOpen.call(this);
                }
                return;
            }

            switch(e.key) {
                case 'Escape':
                    e.preventDefault();
                    this[openProperty] = false;
                    if (onClose) onClose.call(this);
                    break;

                case 'ArrowDown':
                    e.preventDefault();
                    this.highlightNext();
                    break;

                case 'ArrowUp':
                    e.preventDefault();
                    this.highlightPrevious();
                    break;

                case 'Home':
                    e.preventDefault();
                    this.highlightFirst();
                    break;

                case 'End':
                    e.preventDefault();
                    this.highlightLast();
                    break;

                case 'Tab':
                    this[openProperty] = false;
                    if (onClose) onClose.call(this);
                    break;

                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.activateHighlighted();
                    break;

                default:
                    if (enableTypeahead && e.key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
                        e.preventDefault();
                        this.handleTypeahead(e.key);
                    }
                    break;
            }
        },
    };
}

if (typeof window !== 'undefined') {
    window.createKeyboardNavigationMixin = createKeyboardNavigationMixin;
}
