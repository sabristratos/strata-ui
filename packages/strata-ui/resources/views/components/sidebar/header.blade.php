{{--
/**
 * Sidebar Header Component
 *
 * Sticky header section for sidebar with support for logo, title, search, and close button.
 *
 * @props
 * @prop bool $search - Show search input (default: false)
 * @prop string $searchPlaceholder - Search input placeholder (default: 'Search...')
 * @prop bool $close - Show close button for mobile (default: true)
 *
 * @slots
 * @slot default - Header content (logo, title, custom elements)
 *
 * @example
 * <x-strata::sidebar.header search>
 *     <div class="flex items-center gap-2">
 *         <img src="/logo.png" class="w-8 h-8" alt="Logo" />
 *         <span class="font-semibold text-lg">My App</span>
 *     </div>
 * </x-strata::sidebar.header>
 */
--}}

@props([
    'search' => false,
    'searchPlaceholder' => 'Search...',
    'close' => true,
])

<div
    {{ $attributes->merge([
        'class' => 'flex-shrink-0 border-b border-sidebar-border px-3 py-4 space-y-3'
    ]) }}
    data-strata-sidebar-header
>
    <div class="flex items-center justify-between gap-3">
        <div
            :class="{
                'opacity-0 w-0 overflow-hidden pointer-events-none': collapsed && !isMobile,
                'opacity-100 flex-1': !collapsed || isMobile
            }"
            class="min-w-0 transition-all duration-150"
        >
            {{ $slot }}
        </div>

        @if($close)
        <button
            @click="close()"
            type="button"
            class="md:hidden flex-shrink-0 p-2 rounded-md hover:bg-sidebar-hover
                   transition-colors duration-150
                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
            aria-label="Close sidebar"
            data-strata-sidebar-close
        >
            <x-strata::icon.x class="w-5 h-5" />
        </button>
        @endif
    </div>

    @if($search)
    <div
        :class="{
            'opacity-0 h-0 overflow-hidden pointer-events-none': collapsed && !isMobile,
            'opacity-100 h-auto': !collapsed || isMobile
        }"
        role="search"
        class="transition-all duration-150"
        data-strata-sidebar-search
    >
        <x-strata::input
            type="search"
            x-model="searchQuery"
            placeholder="{{ $searchPlaceholder }}"
            size="sm"
            class="w-full"
        >
            <x-slot:prefix>
                <x-strata::icon.search class="w-4 h-4 text-muted-foreground" />
            </x-slot:prefix>
        </x-strata::input>
    </div>
    @endif
</div>
