{{--
/**
 * Bottom Navigation Component
 *
 * A mobile-first bottom navigation bar with pill-style container, safe area support,
 * and modern mobile optimizations.
 *
 * @props
 * @prop string $position - Position style: 'fixed'|'sticky'|'static' (default: 'fixed')
 * @prop string $size - Size variant: 'sm'|'md'|'lg' (default: 'md')
 * @prop bool $respectSafeArea - Add padding for device safe areas (iPhone notch, etc.) (default: true)
 *
 * @slots
 * @slot default - Bottom navigation items
 *
 * @example Basic bottom navigation
 * <x-strata::bottom-nav>
 *     <x-strata::bottom-nav.item icon="home" active>Home</x-strata::bottom-nav.item>
 *     <x-strata::bottom-nav.item icon="user">Profile</x-strata::bottom-nav.item>
 *     <x-strata::bottom-nav.item icon="newspaper">News</x-strata::bottom-nav.item>
 * </x-strata::bottom-nav>
 *
 * @example With badges
 * <x-strata::bottom-nav>
 *     <x-strata::bottom-nav.item icon="home" active>Home</x-strata::bottom-nav.item>
 *     <x-strata::bottom-nav.item icon="bell" badge="5" badge-variant="destructive">Notifications</x-strata::bottom-nav.item>
 *     <x-strata::bottom-nav.item icon="inbox" :badge-dot="true">Messages</x-strata::bottom-nav.item>
 * </x-strata::bottom-nav>
 */
--}}

@props([
    'position' => 'fixed',
    'size' => 'md',
    'respectSafeArea' => true,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$componentId = ComponentHelpers::generateId('bottom-nav', $id, $attributes);

$positions = [
    'fixed' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'sticky' => 'sticky bottom-4 left-1/2 -translate-x-1/2',
    'static' => 'relative',
];

$sizes = ComponentSizeConfig::bottomNavSizes();

$positionClasses = $positions[$position] ?? $positions['fixed'];
$sizeClasses = $sizes[$size] ?? $sizes['md'];

$safeAreaClasses = $respectSafeArea && in_array($position, ['fixed', 'sticky'])
    ? 'pb-[calc(1rem+env(safe-area-inset-bottom))]'
    : '';

$baseClasses = 'flex items-center justify-center bg-background/80 backdrop-blur-lg border border-border rounded-full shadow-lg z-50';
@endphp

<nav
    id="{{ $componentId }}"
    data-strata-bottom-nav
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $positionClasses . ' ' . $sizeClasses . ' ' . $safeAreaClasses]) }}
    role="navigation"
    aria-label="Bottom navigation"
>
    {{ $slot }}
</nav>