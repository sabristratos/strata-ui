{{--
/**
 * Select Component
 *
 * Multi-select and single-select dropdown with search, chips, and keyboard navigation.
 * Uses Entangleable for Livewire sync and Positionable for dropdown positioning.
 *
 * @props
 * @prop bool $multiple - Enable multiple selection (default: false)
 * @prop string $size - Component size: 'sm'|'md'|'lg' (default: 'md')
 * @prop string $state - Validation state: 'default'|'success'|'error'|'warning' (default: 'default')
 * @prop string $placeholder - Placeholder text (default: 'Select an option')
 * @prop bool $disabled - Disable the select (default: false)
 * @prop string|null $name - Form input name (default: null)
 * @prop mixed $value - Selected value(s) - array for multiple, string/int for single (default: null)
 * @prop string $chips - Chip display mode: 'inline'|'below'|'summary' (default: 'inline')
 * @prop bool $searchable - Enable search functionality (default: false)
 * @prop int $minItemsForSearch - Minimum options before search shows (default: 0)
 * @prop string $searchPlaceholder - Search input placeholder (default: 'Search...')
 * @prop string $noResultsMessage - Message when search has no results (default: 'No results found')
 * @prop string $emptyMessage - Message when no options available (default: 'No options available')
 * @prop bool $clearable - Show clear button to reset selection (default: false)
 *
 * @slots
 * @slot default - Select options using <x-strata::select.option> components
 *
 * @example Basic usage
 * <x-strata::select wire:model="category" placeholder="Select category">
 *     <x-strata::select.option value="1" label="Category 1" />
 *     <x-strata::select.option value="2" label="Category 2" />
 * </x-strata::select>
 *
 * @example Multi-select with search
 * <x-strata::select
 *     wire:model="tags"
 *     :multiple="true"
 *     :searchable="true"
 *     chips="below"
 *     placeholder="Select tags">
 *     <x-strata::select.option value="laravel" label="Laravel" />
 *     <x-strata::select.option value="php" label="PHP" />
 * </x-strata::select>
 */
--}}

@props([
    'multiple' => false,
    'size' => 'md',
    'state' => 'default',
    'placeholder' => 'Select an option',
    'disabled' => false,
    'name' => null,
    'value' => null,
    'chips' => false,
    'searchable' => false,
    'minItemsForSearch' => 0,
    'searchPlaceholder' => 'Search...',
    'noResultsMessage' => 'No results found',
    'emptyMessage' => 'No options available',
    'clearable' => false,
])

@php
$chips = filter_var($chips, FILTER_VALIDATE_BOOLEAN);

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

$componentId = $attributes->get('id') ?? 'select-' . uniqid();
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
        display: '',

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
                strategy: 'absolute',
                enableSize: true,
                matchReferenceWidth: true,
                maxHeight: true
            });

            this.dropdown = this.$refs.dropdown;
            this.trigger = this.$refs.trigger;

            if (this.dropdown && this.trigger) {
                this.positionable.start(this, this.trigger, this.dropdown);
            }

            const input = this.$el.querySelector('[data-strata-select-input]');
            if (input) {
                this.entangleable.setupLivewire(this, input);
            }

            this.$nextTick(() => {
                this.collectOptions();
                this.display = this.computeDisplay(this.entangleable.value);

                this.entangleable.watch((newValue) => {
                    this.display = this.computeDisplay(newValue);
                });
            });

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
            if (this.entangleable) {
                this.entangleable.destroy();
            }
            if (this.positionable) {
                this.positionable.destroy();
            }
        },
    }));
});
</script>
@endonce

<div
    x-data="strataSelect(@js($normalizedValue), {{ $multiple ? 'true' : 'false' }}, {{ $disabled ? 'true' : 'false' }}, {{ $chips ? 'true' : 'false' }}, {{ $searchable ? 'true' : 'false' }}, {{ $minItemsForSearch }}, {{ $clearable ? 'true' : 'false' }})"
    data-strata-select
    data-strata-field-type="select"
    @keydown.escape="positionable.close()"
    tabindex="0"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="{{ $multiple ? 'JSON.stringify(entangleable.value)' : 'entangleable.value' }}"
            data-strata-select-input
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    <div class="relative">
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
                            <template x-if="chips">
                                <div class="flex flex-wrap gap-1 max-h-20 overflow-y-auto">
                                    <template x-for="value in selected" :key="value">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-primary/10 text-primary text-sm rounded">
                                            <span x-text="getLabelForValue(value)"></span>
                                        </span>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!chips">
                                <span x-text="`${selected.length} ${selected.length === 1 ? 'selection' : 'selections'}`"></span>
                            </template>
                        </div>
                    </template>

                    <template x-if="!multiple && selected">
                        <span x-text="display"></span>
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
            <x-strata::select.clear size="sm" />
        </div>
    </div>

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

                <div class="space-y-1">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
