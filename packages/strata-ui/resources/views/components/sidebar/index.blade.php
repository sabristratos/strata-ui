{{--
/**
 * Sidebar Component
 *
 * A flexible navigation sidebar with persistent and mini variants, responsive behavior,
 * and support for nested navigation, search, and user profiles.
 *
 * @props
 * @prop string $id - Unique identifier (default: 'sidebar-{uniqid}')
 * @prop string $variant - Sidebar variant: 'persistent' | 'mini' (default: 'persistent')
 * @prop string $position - Sidebar position: 'left' | 'right' (default: 'left')
 * @prop string $width - Sidebar width: 'sm' (240px) | 'md' (280px) | 'lg' (320px) (default: 'md')
 * @prop string $collapsedWidth - Collapsed width: 'sm' (48px) | 'md' (64px) (default: 'md')
 * @prop bool $defaultOpen - Initial open state for mobile (default: true)
 * @prop bool $defaultCollapsed - Initial collapsed state for desktop (default: false)
 * @prop bool $overlay - Show overlay on mobile (default: true)
 *
 * @slots
 * @slot default - Sidebar content (header, nav, footer)
 *
 * @example Basic usage
 * <x-strata::sidebar>
 *     <x-strata::sidebar.nav>
 *         <x-strata::sidebar.item href="/dashboard">Dashboard</x-strata::sidebar.item>
 *     </x-strata::sidebar.nav>
 * </x-strata::sidebar>
 */
--}}

@props([
    'id' => null,
    'variant' => 'persistent',
    'position' => 'left',
    'width' => 'md',
    'collapsedWidth' => 'md',
    'defaultOpen' => true,
    'defaultCollapsed' => false,
    'overlay' => true,
])

@php
use Stratos\StrataUI\Support\ComponentHelpers;

$componentId = ComponentHelpers::generateId('sidebar', $id, $attributes);

$widths = [
    'sm' => 'w-60',
    'md' => 'w-70',
    'lg' => 'w-80',
];

$collapsedWidths = [
    'sm' => 'w-12',
    'md' => 'w-16',
];

$positions = [
    'left' => 'left-0 border-e',
    'right' => 'right-0 border-s',
];

$widthClass = $widths[$width] ?? $widths['md'];
$collapsedWidthClass = $collapsedWidths[$collapsedWidth] ?? $collapsedWidths['md'];
$positionClass = $positions[$position] ?? $positions['left'];
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataSidebar', (config) => ({
        open: config.defaultOpen,
        collapsed: config.defaultCollapsed,
        variant: config.variant,
        position: config.position,
        searchQuery: '',
        isMobile: false,

        init() {
            this.checkMobile();

            const storedCollapsed = localStorage.getItem('strata-sidebar-collapsed');
            if (storedCollapsed !== null && !this.isMobile) {
                this.collapsed = JSON.parse(storedCollapsed);
            }

            this.$watch('collapsed', (value) => {
                if (!this.isMobile) {
                    localStorage.setItem('strata-sidebar-collapsed', JSON.stringify(value));
                }
            });

            window.addEventListener('resize', () => {
                this.checkMobile();
            });

            if (this.isMobile) {
                this.$watch('open', (value) => {
                    document.body.style.overflow = value ? 'hidden' : '';
                });
            }
        },

        checkMobile() {
            this.isMobile = window.innerWidth < 768;
            if (this.isMobile && !this.open) {
                this.open = false;
            }
        },

        toggle() {
            this.open = !this.open;
        },

        close() {
            this.open = false;
        },

        toggleCollapsed() {
            this.collapsed = !this.collapsed;
        },

        filterItems(text) {
            if (!this.searchQuery) return true;
            return text.toLowerCase().includes(this.searchQuery.toLowerCase());
        }
    }));
});
</script>
@endonce

<div
    x-data="strataSidebar({
        defaultOpen: @js($defaultOpen),
        defaultCollapsed: @js($defaultCollapsed),
        variant: @js($variant),
        position: @js($position)
    })"
    x-init="$nextTick(() => {
        if (isMobile) {
            collapsed = false;
            if (!@js($defaultOpen)) {
                open = false;
            }
        }
    })"
    class="contents"
    data-strata-sidebar
    data-sidebar-id="{{ $componentId }}"
>
    @if($overlay)
    <div
        x-show="open && isMobile"
        @click="close()"
        class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm md:hidden transition-all transition-discrete duration-150
               opacity-100
               starting:opacity-0"
        style="display: none;"
    ></div>
    @endif

    <aside
        id="{{ $componentId }}"
        role="navigation"
        aria-label="Main navigation"
        :aria-expanded="open.toString()"
        :aria-hidden="(!open && isMobile).toString()"
        :inert="!open && isMobile"
        x-cloak
        :class="{
            '{{ $widthClass }}': !collapsed && !isMobile,
            '{{ $collapsedWidthClass }}': collapsed && !isMobile,
            'w-64': isMobile && open,
            'translate-x-0': open || !isMobile,
            '-translate-x-full': !open && isMobile && position === 'left',
            'translate-x-full': !open && isMobile && position === 'right',
            'fixed inset-y-0 z-40': isMobile,
            'static': !isMobile,
        }"
        {{ $attributes->merge([
            'class' => "flex bg-sidebar text-sidebar-foreground border-sidebar-border
                       transition-all duration-300 ease-out will-change-transform
                       flex-col {$positionClass}"
        ]) }}
        data-strata-sidebar-container
    >
        {{ $slot }}
    </aside>
</div>
