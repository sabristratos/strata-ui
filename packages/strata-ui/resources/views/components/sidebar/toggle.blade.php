{{--
/**
 * Sidebar Toggle Component
 *
 * Button to toggle sidebar open/closed (mobile) or expanded/collapsed (desktop).
 *
 * @props
 * @prop string $target - Target sidebar ID to control (default: null, finds closest sidebar)
 * @prop string $variant - Toggle variant: 'hamburger' | 'collapse' | 'auto' (default: 'auto')
 * @prop string $position - Button position: 'inside' | 'outside' (default: 'outside')
 *
 * @slots
 * @slot default - Custom button content
 *
 * @example Basic toggle outside sidebar
 * <x-strata::sidebar.toggle />
 *
 * @example Hamburger menu
 * <x-strata::sidebar.toggle variant="hamburger" />
 *
 * @example Collapse toggle inside sidebar
 * <x-strata::sidebar.toggle variant="collapse" position="inside" />
 */
--}}

@props([
    'target' => null,
    'variant' => 'auto',
    'position' => 'outside',
])

@php
$toggleId = 'sidebar-toggle-' . uniqid();
@endphp

<button
    x-data="{
        sidebarElement: null,
        init() {
            this.$nextTick(() => {
                @if($target)
                    this.sidebarElement = document.querySelector('[data-sidebar-id=\'{{ $target }}\']');
                @else
                    this.sidebarElement = this.$el.closest('[data-strata-sidebar]');
                @endif
            });
        },
        get sidebar() {
            return this.sidebarElement?.__x?.$data || {};
        }
    }"
    @click="
        if (sidebar.isMobile) {
            sidebar.toggle?.();
        } else {
            sidebar.toggleCollapsed?.();
        }
    "
    type="button"
    {{ $attributes->merge([
        'class' => 'p-2 rounded-md hover:bg-sidebar-hover
                   transition-colors duration-150
                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring'
    ]) }}
    :aria-label="sidebar.isMobile ? 'Toggle sidebar' : (sidebar.collapsed ? 'Expand sidebar' : 'Collapse sidebar')"
    :aria-expanded="sidebar.isMobile ? sidebar.open?.toString() : (!sidebar.collapsed)?.toString()"
    data-strata-sidebar-toggle
    data-toggle-id="{{ $toggleId }}"
>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        <template x-if="@js($variant) === 'hamburger' || (@js($variant) === 'auto' && sidebar.isMobile)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </template>

        <template x-if="@js($variant) === 'collapse' || (@js($variant) === 'auto' && !sidebar.isMobile)">
            <svg
                class="w-5 h-5 transition-transform duration-150"
                :class="sidebar.collapsed ? 'rotate-180' : 'rotate-0'"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </template>
    @endif
</button>
