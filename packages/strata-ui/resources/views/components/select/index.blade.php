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

$id = 'select-' . uniqid();
$popoverId = $id . '-popover';

$baseClasses = 'w-full inline-flex items-center justify-between gap-2 bg-input border-2 border-input-border rounded-lg transition-all duration-150';

$sizes = [
    'sm' => ['trigger' => 'px-3 py-1.5 text-sm', 'icon' => 'w-4 h-4'],
    'md' => ['trigger' => 'px-4 py-2 text-base', 'icon' => 'w-5 h-5'],
    'lg' => ['trigger' => 'px-5 py-2.5 text-lg', 'icon' => 'w-6 h-6'],
];

$stateClasses = [
    'default' => 'focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:border-input-border',
    'success' => 'border-success focus:ring-2 focus:ring-success/20 focus:ring-offset-2',
    'error' => 'border-destructive focus:ring-2 focus:ring-destructive/20 focus:ring-offset-2',
    'warning' => 'border-warning focus:ring-2 focus:ring-warning/20 focus:ring-offset-2',
];

$disabledClasses = $disabled ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer hover:border-primary/50';

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
        open: false,
        selected: initialValue,
        highlighted: -1,
        options: [],
        disabled: disabled,
        multiple: multiple,
        chips: chips,
        popover: null,
        searchable: searchable,
        minItemsForSearch: minItemsForSearch,
        clearable: clearable,
        search: '',
        outsideClickHandler: null,

        init() {
            this.$nextTick(() => {
                this.collectOptions();
                setTimeout(() => this.collectOptions(), 50);
            });

            this.popover = document.getElementById('{{ $popoverId }}');

            this.$watch('selected', (value) => {
                const input = this.$el.querySelector('[data-strata-select-input]');
                if (input && this.$wire) {
                    const wireModelAttribute = Array.from(input.getAttributeNames())
                        .find(attr => attr.startsWith('wire:model'));

                    if (wireModelAttribute) {
                        const propertyName = input.getAttribute(wireModelAttribute);
                        this.$wire.set(propertyName, value);
                    }
                }
            });

            if (this.popover) {
                this.popover.addEventListener('toggle', (e) => {
                    this.open = e.newState === 'open';
                    if (this.open) {
                        this.highlighted = -1;
                        this.$nextTick(() => {
                            if (this.shouldShowSearch()) {
                                const searchInput = this.$el.querySelector('[data-strata-select-search]');
                                if (searchInput) {
                                    searchInput.focus();
                                }
                            }
                        });
                    } else {
                        this.clearSearch();
                    }
                });
            }

            this.outsideClickHandler = (e) => {
                if (!this.open) return;

                const clickedInside = this.$el.contains(e.target);
                const clickedInPopover = this.popover && this.popover.contains(e.target);

                if (!clickedInside && !clickedInPopover) {
                    this.popover.hidePopover();
                }
            };

            this.$nextTick(() => {
                document.addEventListener('click', this.outsideClickHandler);
            });

            this.setupServerSync();

            this.$watch('search', () => {
                this.highlighted = -1;
            });
        },

        destroy() {
            if (this.outsideClickHandler) {
                document.removeEventListener('click', this.outsideClickHandler);
            }
        },

        setupServerSync() {
            if (!this.$wire) return;

            const input = this.$el.querySelector('[data-strata-select-input]');
            if (!input) return;

            const wireModelAttribute = Array.from(input.getAttributeNames())
                .find(attr => attr.startsWith('wire:model'));

            if (!wireModelAttribute) return;

            const propertyName = input.getAttribute(wireModelAttribute);

            const serverValue = this.$wire.get(propertyName);
            if (serverValue !== undefined && serverValue !== null) {
                this.selected = serverValue;
            }

            this.$wire.on('select:reset', (event) => {
                if (!event.property || event.property === propertyName) {
                    this.selected = this.multiple ? [] : null;
                }
            });

            this.$wire.on('select:update', (event) => {
                if (event.property === propertyName) {
                    this.selected = event.value;
                }
            });

            this.$wire.on('select:sync', (event) => {
                if (!event.property || event.property === propertyName) {
                    const serverValue = this.$wire.get(propertyName);
                    this.selected = serverValue;
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
            if (!this.disabled && this.popover) {
                this.popover.togglePopover();
            }
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
                this.$nextTick(() => {
                    if (this.popover) {
                        this.popover.hidePopover();
                    }
                });
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

        getSelectedLabels() {
            if (this.multiple) {
                return this.options
                    .filter(opt => this.selected.includes(opt.value))
                    .map(opt => opt.label);
            }
            const selected = this.options.find(opt => opt.value === this.selected);
            return selected ? [selected.label] : [];
        },

        shouldShowSearch() {
            return this.searchable && this.options.length >= this.minItemsForSearch;
        },

        getFilteredOptions() {
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

        highlightNext() {
            const availableOptions = this.getFilteredOptions().filter(opt => !opt.disabled);
            if (availableOptions.length === 0) return;

            if (this.highlighted === -1) {
                this.highlighted = 0;
            } else {
                this.highlighted = (this.highlighted + 1) % availableOptions.length;
            }
            this.scrollToHighlighted();
        },

        highlightPrevious() {
            const availableOptions = this.getFilteredOptions().filter(opt => !opt.disabled);
            if (availableOptions.length === 0) return;

            if (this.highlighted === -1) {
                this.highlighted = availableOptions.length - 1;
            } else {
                this.highlighted = (this.highlighted - 1 + availableOptions.length) % availableOptions.length;
            }
            this.scrollToHighlighted();
        },

        selectHighlighted() {
            const availableOptions = this.getFilteredOptions().filter(opt => !opt.disabled);
            if (availableOptions[this.highlighted]) {
                this.select(availableOptions[this.highlighted].value);
            }
        },

        scrollToHighlighted() {
            const availableOptions = this.getFilteredOptions().filter(opt => !opt.disabled);
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
                case 'ArrowDown':
                    e.preventDefault();
                    if (!this.open && this.popover) {
                        this.popover.showPopover();
                    } else {
                        this.highlightNext();
                    }
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    if (!this.open && this.popover) {
                        this.popover.showPopover();
                    } else {
                        this.highlightPrevious();
                    }
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    if (this.open) {
                        this.selectHighlighted();
                    } else if (this.popover) {
                        this.popover.showPopover();
                    }
                    break;
                case 'Escape':
                    if (this.open && this.popover) {
                        e.preventDefault();
                        this.popover.hidePopover();
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
    wire:ignore
    {{ $wrapperAttributes }}
>
    <input
        type="hidden"
        data-strata-select-input
        {{ $selectAttributes }}
    />

    <x-strata::popover.trigger target="{{ $popoverId }}" action="toggle">
        <button
            type="button"
            data-strata-select-trigger
            {{ $attributes->only(['aria-label', 'aria-describedby']) }}
            :disabled="disabled"
            @keydown="handleKeydown"
            class="{{ $triggerClasses }}"
            aria-haspopup="listbox"
            :aria-expanded="open"
            :aria-multiselectable="multiple"
        >
            <div class="flex-1 text-left truncate" wire:ignore>
                <template x-if="multiple && selected.length > 0">
                    <div>
                        <template x-if="chips === 'inline'">
                            <div class="flex flex-wrap gap-1 max-h-20 overflow-y-auto">
                                <template x-for="label in getSelectedLabels()" :key="label">
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
                    <span x-text="getSelectedLabels()[0]"></span>
                </template>

                <template x-if="(!multiple && !selected) || (multiple && selected.length === 0)">
                    <span class="text-muted-foreground">{{ $placeholder }}</span>
                </template>
            </div>

            <x-strata::icon.chevron-down
                class="{{ $iconSize }} text-muted-foreground transition-transform duration-200"
                ::class="{ 'rotate-180': open }"
            />
        </button>
    </x-strata::popover.trigger>

    <div class="absolute right-10 top-1/2 -translate-y-1/2 pointer-events-auto">
        <x-strata::select.clear :size="$size" />
    </div>

    <template x-if="multiple && chips === 'below' && selected.length > 0">
        <div class="flex flex-wrap gap-2 mt-2" wire:ignore>
            <template x-for="(label, index) in getSelectedLabels()" :key="label">
                <x-strata::select.chip
                    :size="$size"
                    x-bind:label="label"
                    @remove="remove(selected[index])"
                />
            </template>
        </div>
    </template>

    <x-strata::popover
        :id="$popoverId"
        type="auto"
        :size="$size"
        placement="bottom"
        class="p-0"
    >
        <template x-if="shouldShowSearch()">
            <div class="sticky top-0 z-10 bg-popover border-b border-popover-border p-2">
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
                        class="w-full px-3 py-2 pr-8 text-sm bg-input border border-input-border rounded-md focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:border-input-border transition-all duration-150"
                    />
                    <template x-if="search.length > 0">
                        <button
                            type="button"
                            @click="clearSearch()"
                            class="absolute right-2 top-1/2 -translate-y-1/2 p-1 hover:bg-muted rounded"
                        >
                            <x-strata::icon.x class="w-4 h-4 text-muted-foreground" />
                        </button>
                    </template>
                </div>
            </div>
        </template>

        <div
            data-strata-select-dropdown
            class="max-h-64 overflow-y-auto p-1 space-y-1"
            role="listbox"
            :aria-multiselectable="multiple"
        >
            <template x-if="options.length === 0">
                <div class="px-3 py-8 text-center text-sm text-muted-foreground">
                    {{ $emptyMessage }}
                </div>
            </template>

            <template x-if="options.length > 0 && getFilteredOptions().length === 0">
                <div class="px-3 py-8 text-center text-sm text-muted-foreground">
                    {{ $noResultsMessage }}
                </div>
            </template>

            <div wire:ignore>
                {{ $slot }}
            </div>
        </div>
    </x-strata::popover>
</div>
