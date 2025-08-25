@php
    $selectId = $getId();
    $itemCount = count($items);
    $initialSelected = $multiple ? (is_array($selected) ? $selected : []) : $selected;
    $isSearchable = $searchable || count($items) >= $searchThreshold;
@endphp

<div>

    <div
        x-data="{
            open: false,
            highlighted: @js($multiple ? 0 : ($selected ?? 0)),
            count: {{ $itemCount }},
            multiple: {{ $multiple ? 'true' : 'false' }},
            maxSelections: {{ $maxSelections }},
            value: @if($attributes->wire('model')) @entangle($attributes->wire('model')) @else @js($initialSelected) @endif,
            items: @js($items),
            searchable: {{ $isSearchable ? 'true' : 'false' }},
            searchQuery: '',
            filteredItems: @js($items),
            filteredIndices: @js(array_keys($items)),

            next() {
                const maxIndex = this.searchable ? this.filteredItems.length - 1 : this.count - 1;
                this.highlighted = Math.min(this.highlighted + 1, maxIndex);
            },

            previous() {
                this.highlighted = Math.max(this.highlighted - 1, 0);
            },

            select() {
                if (this.multiple) {
                    const actualIndex = this.searchable ? this.filteredIndices[this.highlighted] : this.highlighted;
                    this.toggleSelection(actualIndex);
                } else {
                    const actualIndex = this.searchable ? this.filteredIndices[this.highlighted] : this.highlighted;
                    this.value = actualIndex;
                    this.open = false;
                    this.$refs.trigger.focus();
                }
            },

            toggleSelection(index) {
                if (!Array.isArray(this.value)) {
                    this.value = [];
                }
                
                const selectedIndex = this.value.indexOf(index);
                
                if (selectedIndex > -1) {
                    this.value.splice(selectedIndex, 1);
                } else if (this.maxSelections === 0 || this.value.length < this.maxSelections) {
                    this.value.push(index);
                }
            },

            isSelected(index) {
                if (this.multiple) {
                    return Array.isArray(this.value) && this.value.includes(index);
                }
                return this.value === index;
            },

            getDisplayText() {
                if (this.multiple) {
                    if (!Array.isArray(this.value) || this.value.length === 0) {
                        return '';
                    }
                    return this.value.length + ' selected';
                }
                return this.value !== null && this.value !== '' ? (this.items[this.value] || '') : '';
            },

            getVisibleTags() {
                if (!Array.isArray(this.value) || this.value.length === 0) {
                    return [];
                }
                // Show max 2 tags to prevent layout issues
                return this.value.slice(0, 2);
            },

            getRemainingCount() {
                if (!Array.isArray(this.value) || this.value.length <= 2) {
                    return 0;
                }
                return this.value.length - 2;
            },

            filterItems() {
                if (!this.searchQuery.trim()) {
                    this.filteredItems = this.items;
                    this.filteredIndices = Object.keys(this.items);
                } else {
                    const query = this.searchQuery.toLowerCase();
                    this.filteredItems = [];
                    this.filteredIndices = [];
                    
                    Object.keys(this.items).forEach((key) => {
                        if (this.items[key].toLowerCase().includes(query)) {
                            this.filteredItems.push(this.items[key]);
                            this.filteredIndices.push(key);
                        }
                    });
                }
                
                // Reset highlighted to first item
                this.highlighted = 0;
            },

            clearSearch() {
                this.searchQuery = '';
                this.filterItems();
                if (this.searchable && this.$refs.searchInput) {
                    this.$refs.searchInput.focus();
                }
            },

            handleSearchKeydown(event) {
                if (event.key === 'ArrowDown') {
                    event.preventDefault();
                    this.next();
                } else if (event.key === 'ArrowUp') {
                    event.preventDefault();
                    this.previous();
                } else if (event.key === 'Enter') {
                    event.preventDefault();
                    if (this.filteredItems.length > 0) {
                        this.select();
                    }
                } else if (event.key === 'Escape') {
                    if (this.searchQuery) {
                        this.clearSearch();
                    } else {
                        this.close();
                    }
                }
            },

            close() {
                this.open = false;
            },

            toggle() {
                this.open = !this.open;
                if (this.open && this.searchable) {
                    this.$nextTick(() => {
                        if (this.$refs.searchInput) {
                            this.$refs.searchInput.focus();
                        }
                    });
                }
            },

            clearSelection() {
                if (this.multiple) {
                    this.value = [];
                } else {
                    this.value = null;
                }
                this.$refs.trigger.focus();
            },

            hasSelection() {
                if (this.multiple) {
                    return Array.isArray(this.value) && this.value.length > 0;
                }
                return this.value !== null && this.value !== '';
            }
        }"
        @click.outside="close()"
        @keydown.escape.window="close()"
        class="relative"
    >
        <button
            x-ref="trigger"
            @click="toggle()"
            @keydown.arrow-down.prevent="open ? next() : (open = true)"
            @keydown.arrow-up.prevent="open ? previous() : (open = true)"
            @keydown.enter.prevent="open ? select() : toggle()"
            @keydown.space.prevent="toggle()"
            type="button"
            :disabled="@json($disabled)"
            {{ $attributes->except(['wire:model']) }}
            class="input-base h-9 flex items-center justify-between pl-3"
            :class="@json($clearable) && hasSelection() ? 'pr-16' : 'pr-10'"
        >
            <div class="flex items-center gap-1 flex-1 min-w-0">
                <template x-if="multiple && Array.isArray(value) && value.length > 0">
                    <div class="flex items-center gap-1 flex-nowrap min-w-0 overflow-hidden">
                        <template x-for="selectedIndex in getVisibleTags()" :key="selectedIndex">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-primary/20 text-primary text-xs flex-shrink-0">
                                <span x-text="items[selectedIndex]" class="truncate max-w-16"></span>
                                <button 
                                    type="button" 
                                    @click.stop="toggleSelection(selectedIndex)"
                                    class="hover:text-primary/70 flex-shrink-0"
                                >
                                    <x-icon name="heroicon-o-x-mark" class="h-3 w-3" />
                                </button>
                            </span>
                        </template>
                        <span x-show="getRemainingCount() > 0" class="text-muted-foreground text-xs flex-shrink-0 whitespace-nowrap"
                              x-text="'+' + getRemainingCount() + ' more'"></span>
                    </div>
                </template>
                
                <template x-if="!multiple">
                    <span x-show="getDisplayText()" x-text="getDisplayText()"></span>
                </template>
                
                <span x-show="getDisplayText() === ''" class="text-muted-foreground">{{ $placeholder }}</span>
            </div>
        </button>

        <!-- Clear and dropdown buttons -->
        <div class="absolute inset-y-0 right-0 flex items-center">
            @if($clearable)
                <button
                    x-show="hasSelection()"
                    x-on:click.stop="clearSelection()"
                    type="button"
                    class="pr-2 text-muted-foreground hover:text-primary focus:outline-hidden focus:text-primary transition-colors duration-200"
                >
                    <x-icon name="heroicon-o-x-mark" class="h-4 w-4" />
                </button>
            @endif
            
            <div class="pr-3 pointer-events-none">
                <x-icon
                    x-show="!open"
                    name="heroicon-o-chevron-down"
                    class="h-5 w-5 text-muted-foreground transition-transform duration-200"
                />
                <x-icon
                    x-show="open"
                    name="heroicon-o-chevron-up"
                    class="h-5 w-5 text-muted-foreground transition-transform duration-200"
                />
            </div>
        </div>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute z-50 w-full mt-1"
            style="display: none;"
        >
            <div class="bg-popover text-popover-foreground rounded-lg shadow-lg border border-border max-h-60 overflow-hidden flex flex-col">
                <!-- Search Input (when searchable) -->
                <template x-if="searchable">
                    <div class="p-2 border-b border-border">
                        <div class="relative">
                            <input
                                x-ref="searchInput"
                                x-model="searchQuery"
                                x-on:input="filterItems()"
                                x-on:keydown="handleSearchKeydown($event)"
                                type="text"
                                placeholder="{{ $searchPlaceholder }}"
                                class="input-base h-8 w-full text-sm pr-8"
                            />
                            <button
                                x-show="searchQuery"
                                x-on:click="clearSearch()"
                                type="button"
                                class="absolute inset-y-0 right-0 pr-2 flex items-center text-muted-foreground hover:text-primary transition-colors"
                            >
                                <x-icon name="heroicon-o-x-mark" class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Options List -->
                <div class="flex-1 overflow-auto p-1">
                    <!-- No Results Message -->
                    <template x-if="searchable && filteredItems.length === 0 && searchQuery">
                        <div class="px-3 py-2 text-sm text-muted-foreground text-center">
                            No results found
                        </div>
                    </template>

                    <!-- Filtered Items (when searchable) -->
                    <template x-if="searchable">
                        <template x-for="(item, index) in filteredItems" :key="filteredIndices[index]">
                            <button
                                type="button"
                                x-on:click="multiple ? toggleSelection(filteredIndices[index]) : (value = filteredIndices[index], open = false, $refs.trigger.focus())"
                                x-on:mouseover="highlighted = index"
                                :class="highlighted === index ? 'bg-accent text-accent-foreground' : 'text-popover-foreground'"
                                class="w-full text-left px-3 py-2 text-sm cursor-pointer rounded-md transition-colors duration-150 flex items-center justify-between hover:bg-accent hover:text-accent-foreground"
                                :disabled="multiple && maxSelections > 0 && !isSelected(filteredIndices[index]) && Array.isArray(value) && value.length >= maxSelections"
                            >
                                <span x-text="item"></span>
                                <x-icon
                                    x-show="isSelected(filteredIndices[index])"
                                    name="heroicon-o-check"
                                    :class="highlighted === index ? 'text-accent-foreground' : 'text-primary'"
                                    class="h-5 w-5"
                                />
                            </button>
                        </template>
                    </template>

                    <!-- Static Items (when not searchable) -->
                    <template x-if="!searchable">
                        <div>
                            <template x-for="(item, index) in Object.entries(items)" :key="index">
                                <button
                                    type="button"
                                    x-on:click="multiple ? toggleSelection(item[0]) : (value = item[0], open = false, $refs.trigger.focus())"
                                    x-on:mouseover="highlighted = index"
                                    :class="highlighted === index ? 'bg-accent text-accent-foreground' : 'text-popover-foreground'"
                                    class="w-full text-left px-3 py-2 text-sm cursor-pointer rounded-md transition-colors duration-150 flex items-center justify-between hover:bg-accent hover:text-accent-foreground"
                                    :disabled="multiple && maxSelections > 0 && !isSelected(item[0]) && Array.isArray(value) && value.length >= maxSelections"
                                >
                                    <span x-text="item[1]"></span>
                                    <x-icon
                                        x-show="isSelected(item[0])"
                                        name="heroicon-o-check"
                                        :class="highlighted === index ? 'text-accent-foreground' : 'text-primary'"
                                        class="h-5 w-5"
                                    />
                                </button>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        @if($name)
            <template x-if="multiple">
                <div>
                    <template x-for="(selectedValue, index) in Array.isArray(value) ? value : []" :key="index">
                        <input type="hidden" :name="'{{ $name }}[' + index + ']'" :value="selectedValue" />
                    </template>
                </div>
            </template>
            <template x-if="!multiple">
                <input type="hidden" name="{{ $name }}" :value="value" />
            </template>
        @endif
    </div>
</div>
