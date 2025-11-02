@props([
    'multiple' => false,
    'size' => 'md',
    'state' => 'default',
    'placeholder' => 'Select an option',
    'disabled' => false,
    'name' => null,
    'value' => null,
    'chips' => 'inline',
    'searchable' => false,
    'minItemsForSearch' => 0,
    'searchPlaceholder' => 'Search...',
    'noResultsMessage' => 'No results found',
    'emptyMessage' => 'No options available',
    'clearable' => false,
])

@php
if (!in_array($chips, ['inline', 'below', 'summary'])) {
    throw new \InvalidArgumentException('The "chips" prop must be one of: inline, below, summary. Got: ' . $chips);
}

$baseClasses = 'w-full inline-flex items-center justify-between gap-2 bg-input border rounded-lg transition-all duration-150';

$sizes = [
    'sm' => ['trigger' => 'h-9 px-3 text-sm', 'icon' => 'w-4 h-4', 'dropdown' => 'min-w-48 max-w-64'],
    'md' => ['trigger' => 'h-10 px-3 text-base', 'icon' => 'w-5 h-5', 'dropdown' => 'min-w-64 max-w-96'],
    'lg' => ['trigger' => 'h-11 px-4 text-lg', 'icon' => 'w-6 h-6', 'dropdown' => 'min-w-80 max-w-lg'],
];

$dropdownSizeClasses = $sizes[$size]['dropdown'] ?? $sizes['md']['dropdown'];

$stateClasses = [
    'default' => 'border-border focus:ring-2 focus:ring-ring focus:ring-offset-2',
    'success' => 'border-success focus:ring-2 focus:ring-success/20 focus:ring-offset-2',
    'error' => 'border-destructive focus:ring-2 focus:ring-destructive/20 focus:ring-offset-2',
    'warning' => 'border-warning focus:ring-2 focus:ring-warning/20 focus:ring-offset-2',
];

$disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer hover:border-primary/50';

$triggerClasses = $baseClasses . ' ' . ($sizes[$size]['trigger'] ?? $sizes['md']['trigger']) . ' ' . ($stateClasses[$state] ?? $stateClasses['default']) . ' ' . $disabledClasses;

$iconSize = $sizes[$size]['icon'] ?? $sizes['md']['icon'];

$normalizedValue = $multiple
    ? (is_array($value) ? $value : ($value ? [$value] : []))
    : $value;

$wrapperAttributes = $attributes->only(['class', 'style', 'id']);
$selectAttributes = $attributes->except(['class', 'style', 'id'])->merge(['name' => $name]);
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataSelect', (initialValue, multiple, disabled, chips, searchable, minItemsForSearch, clearable) => ({
        entangleable: null,
        positionable: null,
        highlighted: -1,
        options: [],
        disabled: disabled,
        multiple: multiple,
        chips: chips,
        dropdown: null,
        searchable: searchable,
        minItemsForSearch: minItemsForSearch,
        clearable: clearable,
        search: '',

        get selected() {
            return this.entangleable?.get() ?? (multiple ? [] : null);
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

        init() {
            this.entangleable = new window.StrataEntangleable(initialValue);
            this.positionable = new window.StrataPositionable({
                placement: 'bottom-start',
                offset: 8,
                strategy: 'absolute'
            });

            this.dropdown = this.$refs.dropdown;
            this.trigger = this.$refs.trigger;

            if (this.dropdown && this.trigger) {
                this.positionable.start(this, this.trigger, this.dropdown);
            }

            this.$nextTick(() => {
                this.collectOptions();
            });

            const input = this.$el.querySelector('[data-strata-select-input]');
            if (input) {
                this.entangleable.setupLivewire(this, input);
            }

            this.$watch('search', () => {
                this.highlighted = -1;
            });

            this.positionable.watch((state) => {
                if (state) {
                    this.$nextTick(() => {
                        if (this.shouldShowSearch()) {
                            const searchInput = this.dropdown.querySelector('[data-strata-select-search]');
                            if (searchInput) {
                                searchInput.focus();
                            }
                        } else {
                            this.dropdown.focus();
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
        },

        toggle() {
            if (!this.disabled) {
                this.positionable.toggle();
            }
        },

        openIfClosed() {
            if (!this.disabled) {
                this.positionable.openIfClosed();
            }
        },

        close() {
            this.positionable.close();
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

        getActiveDescendant() {
            if (this.highlighted === -1) return '';
            const availableOptions = this.filteredOptions.filter(opt => !opt.disabled);
            return availableOptions[this.highlighted]?.value ? `option-${availableOptions[this.highlighted].value}` : '';
        },

        highlightNext() {
            const availableOptions = this.filteredOptions.filter(opt => !opt.disabled);
            if (availableOptions.length === 0) return;

            if (this.highlighted === -1) {
                this.highlighted = 0;
            } else {
                this.highlighted = (this.highlighted + 1) % availableOptions.length;
            }
            this.scrollToHighlighted();
        },

        highlightPrevious() {
            const availableOptions = this.filteredOptions.filter(opt => !opt.disabled);
            if (availableOptions.length === 0) return;

            if (this.highlighted === -1) {
                this.highlighted = availableOptions.length - 1;
            } else {
                this.highlighted = (this.highlighted - 1 + availableOptions.length) % availableOptions.length;
            }
            this.scrollToHighlighted();
        },

        selectHighlighted() {
            const availableOptions = this.filteredOptions.filter(opt => !opt.disabled);
            if (availableOptions[this.highlighted]) {
                this.select(availableOptions[this.highlighted].value);
            }
        },

        scrollToHighlighted() {
            const availableOptions = this.filteredOptions.filter(opt => !opt.disabled);
            if (availableOptions[this.highlighted]?.element) {
                availableOptions[this.highlighted].element.scrollIntoView({
                    block: 'nearest',
                    behavior: 'auto'
                });
            }
        },

        handleKeydown(e) {
            if (this.disabled) return;

            switch(e.key) {
                case 'Escape':
                    if (this.positionable.state) {
                        e.preventDefault();
                        this.close();
                    }
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    if (!this.positionable.state) {
                        this.positionable.open();
                    } else {
                        this.highlightNext();
                    }
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    if (!this.positionable.state) {
                        this.positionable.open();
                    } else {
                        this.highlightPrevious();
                    }
                    break;
                case 'Home':
                    if (this.positionable.state) {
                        e.preventDefault();
                        const availableOptions = this.filteredOptions.filter(opt => !opt.disabled);
                        if (availableOptions.length > 0) {
                            this.highlighted = 0;
                            this.scrollToHighlighted();
                        }
                    }
                    break;
                case 'End':
                    if (this.positionable.state) {
                        e.preventDefault();
                        const availableOptions = this.filteredOptions.filter(opt => !opt.disabled);
                        if (availableOptions.length > 0) {
                            this.highlighted = availableOptions.length - 1;
                            this.scrollToHighlighted();
                        }
                    }
                    break;
                case 'Tab':
                    if (this.positionable.state) {
                        this.close();
                    }
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    if (this.positionable.state) {
                        this.selectHighlighted();
                    } else {
                        this.positionable.open();
                    }
                    break;
            }
        },
    }));
});
</script>
@endonce

<div
    x-data="strataSelect(@js($normalizedValue), {{ $multiple ? 'true' : 'false' }}, {{ $disabled ? 'true' : 'false' }}, '{{ $chips }}', {{ $searchable ? 'true' : 'false' }}, {{ $minItemsForSearch }}, {{ $clearable ? 'true' : 'false' }})"
    data-strata-select
    data-strata-field-type="select"
    @keydown.escape="positionable.close()"
    tabindex="0"
    {{ $wrapperAttributes->merge(['class' => 'relative']) }}
>
    <input
        type="hidden"
        data-strata-select-input
        {{ $selectAttributes }}
    />

    <button
        type="button"
        x-ref="trigger"
        data-strata-select-trigger
        {{ $attributes->only(['aria-label', 'aria-describedby']) }}
        :disabled="disabled"
        @click.prevent.stop="toggle()"
        @keydown="handleKeydown"
        class="{{ $triggerClasses }}"
        aria-haspopup="listbox"
        :aria-expanded="positionable.state"
        :aria-activedescendant="positionable.state ? getActiveDescendant() : ''"
        :aria-multiselectable="multiple"
    >
            <div class="flex-1 text-left truncate">
                <template x-if="multiple && selected.length > 0">
                    <div>
                        <template x-if="chips === 'inline'">
                            <div class="flex flex-wrap gap-1 max-h-20 overflow-y-auto" wire:ignore>
                                <template x-for="label in selectedLabels" :key="label">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-primary/10 text-primary text-sm rounded">
                                        <span x-text="label"></span>
                                    </span>
                                </template>
                            </div>
                        </template>
                        <template x-if="chips === 'summary' || chips === 'below'">
                            <span x-text="`${selected.length} ${selected.length === 1 ? 'selection' : 'selections'}`"></span>
                        </template>
                    </div>
                </template>

                <template x-if="!multiple && selected">
                    <span x-text="selectedLabels[0]"></span>
                </template>

                <template x-if="(!multiple && !selected) || (multiple && selected.length === 0)">
                    <span class="text-muted-foreground">{{ $placeholder }}</span>
                </template>
            </div>

            <x-strata::icon.chevron-down
                class="{{ $iconSize }} text-muted-foreground transition-transform duration-150 ease-out"
                ::class="{ 'rotate-180': positionable.state }"
            />
    </button>

    <div class="absolute right-10 top-1/2 -translate-y-1/2 pointer-events-auto">
        <x-strata::select.clear :size="$size" />
    </div>

    <template x-if="multiple && chips === 'below' && selected.length > 0">
        <div class="flex flex-wrap gap-2 mt-2">
            <div wire:ignore class="flex flex-wrap gap-2">
                <template x-for="(label, index) in selectedLabels" :key="label">
                    <x-strata::select.chip
                        :size="$size"
                        x-bind:label="label"
                        @remove="remove(selected[index])"
                    />
                </template>
            </div>
        </div>
    </template>

    <div
        x-ref="dropdown"
        x-cloak
        x-show="positionable.state"
        :style="positionable.styles"
        class="absolute top-0 left-0 z-50"
    >
        <div
            x-trap.nofocus="positionable.state"
            @click.outside="positionable.close()"
            tabindex="-1"
            data-strata-select-dropdown
            class="overflow-hidden bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm ring-1 ring-black/5 dark:ring-white/10 p-0 m-0 transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95 {{ $dropdownSizeClasses }}"
            wire:ignore.self
            role="listbox"
            :aria-multiselectable="multiple"
        >
            <template x-if="shouldShowSearch()">
                <div class="sticky top-0 z-10 bg-popover border-b border-border p-2">
                    <div class="relative">
                        <input
                            type="text"
                            data-strata-select-search
                            x-model="search"
                            @keydown.down.prevent="highlightNext()"
                            @keydown.up.prevent="highlightPrevious()"
                            @keydown.enter.prevent="selectHighlighted()"
                            @keydown.escape="clearSearch()"
                            placeholder="{{ $searchPlaceholder }}"
                            class="w-full px-3 py-2 pr-8 text-sm bg-input border border-border rounded-md focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:border-border transition-all duration-150"
                        />
                        <template x-if="search.length > 0">
                            <x-strata::button.icon
                                icon="x"
                                size="sm"
                                variant="secondary"
                                appearance="ghost"
                                @click="clearSearch()"
                                aria-label="Clear search"
                                class="absolute right-2 top-1/2 -translate-y-1/2 !p-1"
                            />
                        </template>
                    </div>
                </div>
            </template>

            <div
                data-strata-select-options
                class="max-h-64 overflow-y-auto p-1 space-y-1"
            >
                <template x-if="options.length === 0">
                    <div class="px-3 py-8 text-center text-sm text-muted-foreground">
                        {{ $emptyMessage }}
                    </div>
                </template>

                <template x-if="options.length > 0 && filteredOptions.length === 0">
                    <div class="px-3 py-8 text-center text-sm text-muted-foreground">
                        {{ $noResultsMessage }}
                    </div>
                </template>

                <div wire:ignore class="space-y-1">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
