{{--
/**
 * Sidebar Navigation Component
 *
 * Wrapper for sidebar navigation items. Provides scrollable content area.
 *
 * @slots
 * @slot default - Navigation items, groups, and sections
 *
 * @example
 * <x-strata::sidebar.nav>
 *     <x-strata::sidebar.item href="/dashboard">Dashboard</x-strata::sidebar.item>
 *     <x-strata::sidebar.item href="/users">Users</x-strata::sidebar.item>
 * </x-strata::sidebar.nav>
 */
--}}

<nav
    {{ $attributes->merge([
        'class' => 'flex-1 overflow-y-auto overflow-x-hidden px-3 py-4 space-y-1'
    ]) }}
    data-strata-sidebar-nav
    aria-label="Sidebar navigation"
>
    {{ $slot }}
</nav>
