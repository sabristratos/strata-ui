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
                focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2';

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
    {{ $attributes->merge(['class' => $finalClasses]) }}
    data-strata-sidebar-item
>
    @if($icon || $attributes->has('icon'))
        <span
            class="flex-shrink-0 transition-all"
            data-strata-sidebar-item-icon
        >
            @if(isset($icon) && $icon)
                <x-dynamic-component :component="'strata::icon.' . $icon" class="w-5 h-5" />
            @else
                {{ $icon ?? '' }}
            @endif
        </span>
    @endif

    <span
        x-show="!collapsed || isMobile"
        x-transition.opacity.duration.150ms
        class="flex-1 text-left truncate"
        data-strata-sidebar-item-label
    >
        {{ $slot }}
    </span>

    @if($badge || $attributes->has('badge'))
        <span
            x-show="!collapsed || isMobile"
            x-transition.opacity.duration.150ms
            class="flex-shrink-0"
            data-strata-sidebar-item-badge
        >
            @if(isset($badge) && $badge)
                <x-strata::badge :variant="$badgeVariant" size="sm">
                    {{ $badge }}
                </x-strata::badge>
            @else
                {{ $badge ?? '' }}
            @endif
        </span>
    @endif
</{{ $tag }}>
