{{--
/**
 * Sidebar Section Component
 *
 * Visual grouping of related navigation items with optional section header.
 *
 * @props
 * @prop string $title - Section title (default: null)
 * @prop bool $divider - Show divider before section (default: false)
 *
 * @slots
 * @slot default - Section content (items, groups)
 *
 * @example
 * <x-strata::sidebar.section title="Administration" divider>
 *     <x-strata::sidebar.item href="/users">Users</x-strata::sidebar.item>
 *     <x-strata::sidebar.item href="/roles">Roles</x-strata::sidebar.item>
 * </x-strata::sidebar.section>
 */
--}}

@props([
    'title' => null,
    'divider' => false,
])

<div
    {{ $attributes->merge(['class' => 'space-y-1']) }}
    data-strata-sidebar-section
>
    @if($divider)
        <div class="my-3">
            <x-strata::separator />
        </div>
    @endif

    @if($title)
    <div
        x-show="!collapsed || isMobile"
        x-transition.opacity.duration.150ms
        class="px-3 py-2"
        data-strata-sidebar-section-header
    >
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">
            {{ $title }}
        </h3>
    </div>
    @endif

    <div class="space-y-1" data-strata-sidebar-section-content>
        {{ $slot }}
    </div>
</div>
