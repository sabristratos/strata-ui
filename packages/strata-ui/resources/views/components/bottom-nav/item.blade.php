{{--
/**
 * Bottom Navigation Item Component
 *
 * Individual navigation item for bottom navigation bar.
 *
 * @props
 * @prop string|null $icon - Icon name (default: null)
 * @prop bool $active - Active state (default: false)
 * @prop string|null $href - Link URL (default: null)
 * @prop string $size - Size variant: 'sm'|'md'|'lg' (default: 'md')
 * @prop bool $showLabel - Show label text (default: true)
 * @prop string|null $badge - Badge text/number (default: null)
 * @prop string $badgeVariant - Badge variant: 'default'|'destructive'|'success'|'warning' (default: 'default')
 * @prop bool $badgeDot - Show dot indicator instead of badge (default: false)
 * @prop bool $disabled - Disable interaction (default: false)
 * @prop bool $loading - Show loading spinner (default: false)
 * @prop string|null $target - Link target attribute: '_blank'|'_self' (default: null)
 *
 * @slots
 * @slot default - Navigation item label
 *
 * @example Active item with icon
 * <x-strata::bottom-nav.item icon="home" active>
 *     Home
 * </x-strata::bottom-nav.item>
 *
 * @example With badge
 * <x-strata::bottom-nav.item icon="bell" badge="3" badge-variant="destructive">
 *     Notifications
 * </x-strata::bottom-nav.item>
 *
 * @example With dot indicator
 * <x-strata::bottom-nav.item icon="inbox" :badge-dot="true">
 *     Messages
 * </x-strata::bottom-nav.item>
 *
 * @example Disabled state
 * <x-strata::bottom-nav.item icon="settings" disabled>
 *     Settings
 * </x-strata::bottom-nav.item>
 *
 * @example Loading state
 * <x-strata::bottom-nav.item icon="user" :loading="$isLoading">
 *     Profile
 * </x-strata::bottom-nav.item>
 */
--}}

@props([
    'icon' => null,
    'active' => false,
    'href' => null,
    'size' => 'md',
    'showLabel' => true,
    'badge' => null,
    'badgeVariant' => 'default',
    'badgeDot' => false,
    'disabled' => false,
    'loading' => false,
    'target' => null,
])

@php
$sizes = [
    'sm' => [
        'container' => 'min-h-11 px-3 py-2 gap-1.5 text-xs',
        'icon' => 'w-4 h-4',
    ],
    'md' => [
        'container' => 'min-h-11 px-4 py-2.5 gap-2 text-sm',
        'icon' => 'w-5 h-5',
    ],
    'lg' => [
        'container' => 'min-h-12 px-5 py-3 gap-2.5 text-base',
        'icon' => 'w-6 h-6',
    ],
];

$sizeConfig = $sizes[$size] ?? $sizes['md'];
$containerClasses = $sizeConfig['container'];
$iconSize = $sizeConfig['icon'];

$activeClasses = $active
    ? 'bg-primary text-primary-foreground'
    : 'bg-transparent text-muted-foreground hover:text-foreground';

$disabledClasses = 'disabled:opacity-60 disabled:cursor-not-allowed disabled:pointer-events-none';

$baseClasses = 'relative inline-flex items-center justify-center font-medium rounded-full transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2';

$tag = $href ? 'a' : 'button';
$isDisabled = $disabled || $loading;
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if($href && $target) target="{{ $target }}" @endif
    @if(!$href) type="button" @endif
    @if($isDisabled) disabled @endif
    @if($loading) aria-busy="true" @endif
    data-strata-bottom-nav-item
    @if($active) aria-current="page" @endif
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $containerClasses . ' ' . $activeClasses . ' ' . $disabledClasses]) }}
>
    @if($loading)
        <x-strata::icon.loader-2 :class="'animate-spin ' . $iconSize" aria-hidden="true" />
    @elseif($icon)
        <div class="relative">
            <x-dynamic-component :component="'strata::icon.' . $icon" :class="$iconSize" aria-hidden="true" />
            @if($badge || $badgeDot)
                <span class="absolute -top-1 -right-1">
                    @if($badgeDot)
                        <span class="block w-2 h-2 bg-destructive rounded-full border border-background"></span>
                    @else
                        <x-strata::badge :variant="$badgeVariant" size="sm" class="min-w-4 h-4 px-1 text-[10px]">
                            {{ $badge }}
                        </x-strata::badge>
                    @endif
                </span>
            @endif
        </div>
    @endif

    @if($showLabel)
        <span class="font-medium">{{ $slot }}</span>
    @else
        <span class="sr-only">{{ $slot }}</span>
    @endif
</{{ $tag }}>