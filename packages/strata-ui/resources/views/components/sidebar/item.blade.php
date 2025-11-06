{{--
/**
 * Sidebar Item Component
 *
 * Individual navigation link or button for sidebar.
 *
 * @props
 * @prop string $href - Link URL (default: null for button behavior)
 * @prop bool $active - Whether item is currently active (default: false)
 * @prop string $icon - Icon name from icon library (default: null)
 * @prop string $badge - Badge content for notifications (default: null)
 * @prop string $badgeVariant - Badge variant (default: 'default')
 * @prop string $target - Link target attribute (default: null)
 *
 * @slots
 * @slot default - Item label text
 * @slot icon - Custom icon content
 * @slot badge - Custom badge content
 *
 * @example
 * <x-strata::sidebar.item href="/dashboard" icon="home" active>
 *     Dashboard
 * </x-strata::sidebar.item>
 *
 * <x-strata::sidebar.item href="/users" icon="users" badge="5">
 *     Users
 * </x-strata::sidebar.item>
 */
--}}

@props([
    'href' => null,
    'active' => false,
    'icon' => null,
    'badge' => null,
    'badgeVariant' => 'default',
    'target' => null,
])

@php
$tag = $href ? 'a' : 'button';

$baseClasses = 'flex items-center gap-3 w-full px-3 py-2 text-sm font-medium rounded-md
                transition-all duration-150 ease-out
                focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2';

$stateClasses = $active
    ? 'bg-sidebar-active text-sidebar-active-foreground'
    : 'text-sidebar-foreground hover:bg-sidebar-hover';

$finalClasses = $baseClasses . ' ' . $stateClasses;
@endphp

<{{ $tag }}
    @if($href)
        href="{{ $href }}"
    @endif
    @if($target)
        target="{{ $target }}"
    @endif
    @if($active)
        aria-current="page"
    @endif
    x-show="filterItems('{{ addslashes($slot->toHtml()) }}')"
    {{ $attributes->merge(['class' => $finalClasses]) }}
    data-strata-sidebar-item
>
    @if($icon)
        <span
            class="flex-shrink-0 transition-all"
            data-strata-sidebar-item-icon
        >
            <x-dynamic-component :component="'strata::icon.' . $icon" class="w-5 h-5" />
        </span>
    @endif

    <span
        :class="{
            'opacity-0 w-0 overflow-hidden': collapsed && !isMobile,
            'opacity-100 flex-1': !collapsed || isMobile
        }"
        class="text-left truncate transition-all duration-150"
        data-strata-sidebar-item-label
    >
        {{ $slot }}
    </span>

    @if($badge)
        <span
            :class="{
                'opacity-0 w-0 overflow-hidden': collapsed && !isMobile,
                'opacity-100': !collapsed || isMobile
            }"
            class="flex-shrink-0 transition-all duration-150"
            data-strata-sidebar-item-badge
        >
            <x-strata::badge :variant="$badgeVariant" size="sm">
                {{ $badge }}
            </x-strata::badge>
        </span>
    @endif
</{{ $tag }}>
