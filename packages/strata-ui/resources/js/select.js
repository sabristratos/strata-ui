export default function (props = {}) {
    return {
        ...window.createEntangleableMixin({
            initialValue: props.initialValue || (props.multiple ? [] : null),
            inputSelector: '[data-strata-select-input]',
            afterWatch: function(newValue) {
                this.display = this.computeDisplay(newValue);
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
        disabled: false,
        _optionsObserver: null,
        _disabledObserver: null,

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

        isDisabled() {
            return this.disabled === true;
        },

        init() {
            this.initEntangleable();
            this.initKeyboardNavigation();

            // Initialize disabled state from DOM
            this.disabled = this.$el?.dataset?.disabled === 'true';

            // Watch for disabled attribute changes (Livewire morphing)
            this._disabledObserver = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-disabled') {
                        this.disabled = this.$el?.dataset?.disabled === 'true';
                    }
                }
            });

            this._disabledObserver.observe(this.$el, {
                attributes: true,
                attributeFilter: ['data-disabled']
            });

            this.$nextTick(() => {
                this.collectOptions();
                this.collectKeyboardItems();
                this.display = this.computeDisplay(this.entangleable.value);

                const dropdown = document.getElementById(this.$id('select-dropdown'));
                if (dropdown) {
                    this._optionsObserver = new MutationObserver(() => {
                        this.collectOptions();
                        this.collectKeyboardItems();
                        this.display = this.computeDisplay(this.entangleable.value);
                    });

                    this._optionsObserver.observe(dropdown, {
                        childList: true,
                        subtree: true
                    });
                }
            });

            this.$watch('search', () => {
                this.highlighted = -1;
            });

            this.$watch('open', (newValue) => {
                if (newValue) {
                    this.$nextTick(() => {
                        if (this.shouldShowSearch()) {
                            const dropdown = document.getElementById(this.$id('select-dropdown'));
                            const searchInput = dropdown?.querySelector('[data-strata-select-search]');
                            if (searchInput) {
                                searchInput.focus({ preventScroll: true });
                            }
                        } else {
                            const dropdown = document.getElementById(this.$id('select-dropdown'));
                            if (dropdown) {
                                dropdown.focus({ preventScroll: true });
                            }
                        }
                    });
                } else {
                    this.clearSearch();
                    this.$el.focus();
                }
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

        toggleDropdown() {
            if (!this.isDisabled()) {
                if (!this.open) {
                    this.collectOptions();
                    this.display = this.computeDisplay(this.entangleable.value);
                }
                const dropdown = document.getElementById(this.$id('select-dropdown'));
                if (dropdown) {
                    dropdown.togglePopover();
                }
            }
        },

        openIfClosed() {
            if (!this.isDisabled() && !this.open) {
                this.collectOptions();
                this.display = this.computeDisplay(this.entangleable.value);
                const dropdown = document.getElementById(this.$id('select-dropdown'));
                if (dropdown) {
                    dropdown.showPopover();
                }
            }
        },

        close() {
            const dropdown = document.getElementById(this.$id('select-dropdown'));
            if (dropdown) {
                dropdown.hidePopover();
            }
        },

        select(value) {
            if (this.isDisabled()) return;

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
            if (!this.isDisabled() && this.multiple) {
                this.selected = this.selected.filter(v => v !== value);
            }
        },

        clear() {
            if (!this.isDisabled()) {
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
            if (this._disabledObserver) {
                this._disabledObserver.disconnect();
                this._disabledObserver = null;
            }
            if (this.entangleable) {
                this.entangleable.destroy();
            }
        },
    };
}
