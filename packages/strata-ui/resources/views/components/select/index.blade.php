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
 * @prop bool $chips - Show selected items as removable chip badges (default: false)
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
 * @example Multi-select with search and chips
 * <x-strata::select
 *     wire:model="tags"
 *     :multiple="true"
 *     :searchable="true"
 *     :chips="true"
 *     placeholder="Select tags">
 *     <x-strata::select.option value="laravel" label="Laravel" />
 *     <x-strata::select.option value="php" label="PHP" />
 * </x-strata::select>
 */
--}}

@props([
    'id' => null,
    'name' => null,
    'minItemsForSearch' => 0,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;
use Stratos\StrataUI\Support\PositioningHelper;

$itemsAlignment = $chips ? 'items-start' : 'items-center';
$baseClasses = 'w-full inline-flex justify-between gap-2 bg-input border rounded-lg transition-all duration-150 inset-shadow-sm';

$sizes = $chips ? ComponentSizeConfig::selectSizesWithChips() : ComponentSizeConfig::selectSizes();

$dropdownSizeClasses = $sizes[$size]['dropdown'] ?? $sizes['md']['dropdown'];

$stateClasses = ComponentStateConfig::focusableStates();

$disabledClasses = ($disabled || $readonly) ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer hover:border-primary/50';

$triggerClasses = implode(' ', [
    $baseClasses,
    $itemsAlignment,
    $sizes[$size]['trigger'] ?? $sizes['md']['trigger'],
    $stateClasses[$state] ?? $stateClasses['default'],
    $disabledClasses,
]);

$iconSize = $sizes[$size]['icon'] ?? $sizes['md']['icon'];

$normalizedValue = $multiple
    ? (is_array($value) ? $value : ($value ? [$value] : []))
    : $value;

$componentId = ComponentHelpers::generateId('select', $id, $attributes);

$positioning = PositioningHelper::getAnchorPositioning($placement, $offset);
$positioningStyle = $positioning['style'];

$animationClasses = '[&[popover]]:[transition:opacity_150ms,transform_150ms,overlay_150ms_allow-discrete,display_150ms_allow-discrete] ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95';
@endphp

<div
    x-data="window.strataSelect({
        initialValue: @js($normalizedValue),
        multiple: {{ $multiple ? 'true' : 'false' }},
        chips: {{ $chips ? 'true' : 'false' }},
        searchable: {{ $searchable ? 'true' : 'false' }},
        minItemsForSearch: {{ $minItemsForSearch }},
        clearable: {{ $clearable ? 'true' : 'false' }},
        disabled: {{ $disabled ? 'true' : 'false' }},
        readonly: {{ $readonly ? 'true' : 'false' }},
        loading: {{ $loading ? 'true' : 'false' }},
        maxSelected: {{ $maxSelected ?? 'null' }}
    })"
    x-id="['select-dropdown']"
    data-disabled="{{ ($disabled || $readonly) ? 'true' : 'false' }}"
    data-size="{{ $size }}"
    data-strata-select
    data-strata-field-type="select"
    @keydown="!isDisabled() && handleKeyboardNavigation($event)"
    :tabindex="isDisabled() ? -1 : 0"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative overflow-visible']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="{{ $multiple ? 'JSON.stringify(entangleable.value)' : 'entangleable.value' }}"
            data-strata-select-input
            @if($required) required @endif
            @if($readonly) readonly @endif
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    <div class="relative">
        <div
            x-ref="trigger"
            :style="`anchor-name: --select-${$id('select-dropdown')};`"
            x-effect="isDisabled() ? $refs.trigger.setAttribute('inert', '') : $refs.trigger.removeAttribute('inert')"
            data-strata-select-trigger
            {{ $attributes->only(['aria-describedby', 'aria-errormessage']) }}
            :aria-label="$el.getAttribute('aria-label') || (hasSelection() ? display : '{{ $placeholder }}')"
            @click.prevent.stop="toggleDropdown()"
            @keydown.enter.prevent="toggleDropdown()"
            @keydown.space.prevent="toggleDropdown()"
            role="button"
            :tabindex="isDisabled() ? -1 : 0"
            :aria-disabled="isDisabled()"
            class="{{ $triggerClasses }}"
            aria-haspopup="listbox"
            :aria-expanded="open"
            :aria-activedescendant="open && highlighted >= 0 ? `option-${filteredOptions[highlighted]?.value}` : ''"
            :aria-multiselectable="multiple"
        >
                <div class="flex-1 text-left truncate">
                    <template x-if="multiple && selected.length > 0">
                        <div>
                            <template x-if="chips">
                                <div class="flex flex-wrap gap-1 max-h-20 overflow-y-auto">
                                    <template x-for="value in selected" :key="value">
                                        <span
                                            data-strata-select-chip
                                            class="inline-flex items-center bg-primary/10 text-primary rounded-md font-medium px-2 py-0.5 gap-1 text-sm transition-colors duration-150"
                                            :class="{ 'opacity-50 cursor-not-allowed': isDisabled() }"
                                        >
                                            <span x-text="getLabelForValue(value)"></span>
                                            <x-strata::button.icon
                                                icon="x"
                                                size="sm"
                                                variant="primary"
                                                appearance="ghost"
                                                ::disabled="isDisabled()"
                                                @click.stop="!isDisabled() && remove(value)"
                                                ::aria-label="`Remove ${getLabelForValue(value)}`"
                                                class="hover:bg-primary/20 !p-0.5 -mr-1"
                                            />
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
                    ::class="{ 'rotate-180': open }"
                />

                <x-strata::select.clear size="sm" />
        </div>
    </div>

    <div
        :id="$id('select-dropdown')"
        popover="auto"
        @toggle="open = $event.newState === 'open'"
        :style="`{{ $positioningStyle }} position-anchor: --select-${$id('select-dropdown')};`"
        data-strata-select-content
        data-placement="{{ $placement }}"
        x-trap="open && shouldShowSearch()"
        x-trap.nofocus="open && !shouldShowSearch()"
        tabindex="-1"
        data-strata-select-dropdown
        wire:ignore.self
        class="overflow-hidden bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm p-0 m-0 {{ $animationClasses }} {{ $dropdownSizeClasses }}"
        role="listbox"
        :aria-label="'{{ $placeholder }}'"
        :aria-multiselectable="multiple"
    >
            <template x-if="shouldShowSearch()">
                <div class="sticky top-0 z-10 bg-popover border-b border-border p-2">
                    <div
                        role="status"
                        aria-live="polite"
                        :id="$id('search-status')"
                        class="sr-only"
                        x-text="`${filteredOptions.length} ${filteredOptions.length === 1 ? 'option' : 'options'} available`"
                    ></div>
                    <x-strata::input
                        type="text"
                        size="sm"
                        data-strata-select-search
                        x-model="search"
                        @keydown.stop
                        @keydown.escape="close()"
                        @keydown.enter.prevent
                        placeholder="{{ $searchPlaceholder }}"
                        ::aria-describedby="$id('search-status')"
                    >
                        <x-strata::input.clear @click="clearSearch()" />
                    </x-strata::input>
                </div>
            </template>

            <div
                data-strata-select-options
                class="max-h-64 overflow-y-auto p-1 space-y-1"
            >
                <template x-if="loading">
                    <div class="px-3 py-8 flex flex-col items-center justify-center gap-2">
                        <x-strata::icon name="loader-circle" class="w-6 h-6 animate-spin text-muted-foreground" />
                        <p class="text-sm text-muted-foreground">{{ $loadingMessage }}</p>
                    </div>
                </template>

                <template x-if="!loading && options.length === 0">
                    <div class="px-3 py-8 text-center text-sm text-muted-foreground">
                        {{ $emptyMessage }}
                    </div>
                </template>

                <template x-if="!loading && options.length > 0 && filteredOptions.length === 0">
                    <div class="px-3 py-8 text-center text-sm text-muted-foreground">
                        {{ $noResultsMessage }}
                    </div>
                </template>

                <template x-if="!loading && filteredOptions.length > 0">
                    <div class="space-y-1">
                        {{ $slot }}
                    </div>
                </template>
            </div>
    </div>
</div>
