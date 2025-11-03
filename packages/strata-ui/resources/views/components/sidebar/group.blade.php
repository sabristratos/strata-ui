{{--
/**
 * Sidebar Group Component
 *
 * Collapsible group of sidebar items using native <details> and <summary> elements.
 *
 * @props
 * @prop string $id - Unique identifier (default: 'sidebar-group-{uniqid}')
 * @prop string $title - Group title/label (default: null)
 * @prop string $icon - Icon for group title (default: null)
 * @prop bool $defaultExpanded - Initial expanded state (default: false)
 * @prop string $badge - Badge content for group (default: null)
 * @prop string $badgeVariant - Badge variant (default: 'default')
 *
 * @slots
 * @slot default - Child navigation items
 * @slot title - Custom title content
 *
 * @example
 * <x-strata::sidebar.group title="Settings" icon="settings" defaultExpanded>
 *     <x-strata::sidebar.item href="/settings/profile">Profile</x-strata::sidebar.item>
 *     <x-strata::sidebar.item href="/settings/security">Security</x-strata::sidebar.item>
 * </x-strata::sidebar.group>
 */
--}}

@props([
    'id' => null,
    'title' => null,
    'icon' => null,
    'defaultExpanded' => false,
    'badge' => null,
    'badgeVariant' => 'default',
])

@php
$groupId = $id ?? $attributes->get('id') ?? 'sidebar-group-' . uniqid();
@endphp

<details
    x-data="{
        groupId: @js($groupId),
        isOpen: false,
        init() {
            const savedState = localStorage.getItem('sidebar-group-' + this.groupId);
            if (savedState === 'true' || @js($defaultExpanded)) {
                this.$el.open = true;
                this.isOpen = true;
            }
        },
        handleToggle(event) {
            this.isOpen = this.$el.open;
            localStorage.setItem('sidebar-group-' + this.groupId, this.$el.open.toString());
        }
    }"
    x-on:toggle="handleToggle($event)"
    {{ $attributes->merge(['class' => 'space-y-1']) }}
    data-strata-sidebar-group
    data-group-id="{{ $groupId }}"
>
    @if($title)
    <summary
        class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium rounded-md
               text-sidebar-foreground hover:bg-sidebar-hover
               transition-all duration-150 ease-out
               focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
               list-none cursor-pointer"
        aria-controls="{{ $groupId }}-content"
        data-strata-sidebar-group-trigger
    >
        @if($icon)
        <span class="flex-shrink-0 w-5 h-5" data-strata-sidebar-group-icon>
            <x-dynamic-component :component="'strata::icon.' . $icon" class="w-5 h-5" />
        </span>
        @endif

        <span
            x-show="!collapsed || isMobile"
            x-transition.opacity.duration.150ms
            class="flex-1 text-left truncate"
        >
            {{ $title }}
        </span>

        @if($badge)
        <span
            x-show="!collapsed || isMobile"
            x-transition.opacity.duration.150ms
            class="flex-shrink-0"
        >
            <x-strata::badge :variant="$badgeVariant" size="sm">
                {{ $badge }}
            </x-strata::badge>
        </span>
        @endif

        <span
            x-show="!collapsed || isMobile"
            x-transition.opacity.duration.150ms
            :class="isOpen ? 'rotate-90' : 'rotate-0'"
            class="flex items-center justify-center flex-shrink-0 w-4 h-4 transition-all duration-150 origin-center"
            data-strata-sidebar-group-chevron
        >
            <x-strata::icon.chevron-right class="w-4 h-4" />
        </span>
    </summary>
    @endif

    <div
        id="{{ $groupId }}-content"
        class="space-y-1"
        :class="collapsed ? '' : 'pl-6'"
        data-strata-sidebar-group-content
    >
        {{ $slot }}
    </div>
</details>
