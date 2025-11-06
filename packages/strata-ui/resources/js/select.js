export default function (props = {}) {
    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue || (props.multiple ? [] : null),
            inputSelector: '[data-strata-select-input]',
            afterWatch: function(newValue) {
                this.display = this.computeDisplay(newValue);
            }
        }),

        ...window.createPositionableMixin({
            placement: 'bottom-start',
            offset: 8,
            floatingRef: 'dropdown',
            enableSize: true,
            matchReferenceWidth: true,
            maxHeight: true,
            onOpen: function() {
                if (this.shouldShowSearch()) {
                    const searchInput = this.$refs.dropdown.querySelector('[data-strata-select-search]');
                    if (searchInput) {
                        searchInput.focus({ preventScroll: true });
                    }
                } else {
                    this.$refs.dropdown.focus({ preventScroll: true });
                }
            },
            onClose: function() {
                this.clearSearch();
                this.$el.focus();
            }
        }),

        ...window.createKeyboardNavigationMixin({
            itemSelector: '[data-strata-select-option]:not([data-disabled])',
            itemsProperty: 'items',
            highlightedProperty: 'highlighted',
            filteredItemsGetter: 'filteredOptions',
            openProperty: 'open',
            enableTypeahead: true,
            typeaheadMatcher: (item, buffer) => {
                return item.label.toLowerCase().startsWith(buffer);
            },
            onActivate: function(item) {
                this.select(item.value);
            },
            onClose: function() {
                this.close();
            },
            generateItemId: (item) => `option-${item.value}`
        }),

        open: false,
        options: [],
        multiple: props.multiple || false,
        chips: props.chips || false,
        dropdown: null,
        searchable: props.searchable || false,
        minItemsForSearch: props.minItemsForSearch || 0,
        clearable: props.clearable || false,
        search: '',
        display: '',
        _optionsObserver: null,

        get selected() {
            return this.entangleable?.get() ?? (this.multiple ? [] : null);
        },

        set selected(value) {
            this.entangleable?.set(value);
        },

        get filteredOptions() {
            if (!this.search.trim()) {
                return this.options;
            }

            const searchLower = this.search.toLowerCase();
            return this.options.filter(opt => {
                const labelMatch = opt.label.toLowerCase().includes(searchLower);
                const valueMatch = String(opt.value).toLowerCase().includes(searchLower);
                return labelMatch || valueMatch;
            });
        },

        get selectedLabels() {
            if (this.multiple) {
                return this.options
                    .filter(opt => this.selected.includes(opt.value))
                    .map(opt => opt.label);
            }
            const selected = this.options.find(opt => opt.value === this.selected);
            return selected ? [selected.label] : [];
        },

        get disabled() {
            return this.$el?.dataset?.disabled === 'true';
        },

        init() {
            this.initEntangleable();
            this.initPositionable();
            this.initKeyboardNavigation();

            this.$nextTick(() => {
                this.collectOptions();
                this.collectKeyboardItems();
                this.display = this.computeDisplay(this.entangleable.value);

                this._optionsObserver = new MutationObserver(() => {
                    this.collectOptions();
                    this.collectKeyboardItems();
                    this.display = this.computeDisplay(this.entangleable.value);
                });

                const dropdown = this.$refs.dropdown;
                if (dropdown) {
                    this._optionsObserver.observe(dropdown, {
                        childList: true,
                        subtree: true
                    });
                }
            });

            this.$watch('search', () => {
                this.highlighted = -1;
            });
        },

        collectOptions() {
            const optionElements = this.$el.querySelectorAll('[data-strata-select-option]');
            this.options = Array.from(optionElements).map(el => ({
                value: el.dataset.value,
                label: el.textContent.trim(),
                disabled: el.hasAttribute('data-disabled'),
                element: el
            }));

            this.items = this.options.map(opt => ({
                ...opt,
                text: opt.label
            }));
        },

        toggle() {
            if (!this.disabled) {
                if (!this.open) {
                    this.collectOptions();
                    this.display = this.computeDisplay(this.entangleable.value);
                }
                this.open = !this.open;
            }
        },

        openIfClosed() {
            if (!this.disabled && !this.open) {
                this.collectOptions();
                this.display = this.computeDisplay(this.entangleable.value);
                this.open = true;
            }
        },

        close() {
            this.open = false;
        },

        select(value) {
            if (this.disabled) return;

            if (this.multiple) {
                const index = this.selected.indexOf(value);
                if (index > -1) {
                    this.selected = this.selected.filter(v => v !== value);
                } else {
                    this.selected = [...this.selected, value];
                }
            } else {
                this.selected = value;
                this.close();
            }
        },

        remove(value) {
            if (!this.disabled && this.multiple) {
                this.selected = this.selected.filter(v => v !== value);
            }
        },

        clear() {
            if (!this.disabled) {
                this.selected = this.multiple ? [] : null;
            }
        },

        isSelected(value) {
            if (this.multiple) {
                return this.selected.includes(value);
            }
            return this.selected === value;
        },

        shouldShowSearch() {
            return this.searchable && this.options.length >= this.minItemsForSearch;
        },

        clearSearch() {
            this.search = '';
            this.highlighted = -1;
        },

        hasSelection() {
            if (this.multiple) {
                return this.selected.length > 0;
            }
            return this.selected !== null && this.selected !== '';
        },

        computeDisplay(value) {
            if (this.multiple) {
                if (!value || value.length === 0) return '';
                const labels = this.options
                    .filter(opt => value.includes(opt.value))
                    .map(opt => opt.label);

                if (this.chips) {
                    return labels.join(', ');
                }

                return `${value.length} ${value.length === 1 ? 'selection' : 'selections'}`;
            }

            const option = this.options.find(opt => opt.value === value);
            return option ? option.label : '';
        },

        getLabelForValue(value) {
            const option = this.options.find(opt => opt.value === value);
            return option ? option.label : value;
        },

        destroy() {
            if (this._optionsObserver) {
                this._optionsObserver.disconnect();
                this._optionsObserver = null;
            }
            if (this.entangleable) {
                this.entangleable.destroy();
            }
            this.destroyPositionable();
        },
    };
}
