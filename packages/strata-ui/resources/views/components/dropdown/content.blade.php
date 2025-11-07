@aware([
    'placement' => 'bottom-start',
    'offset' => 8,
])

@props([
    'size' => 'md',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Support\PositioningHelper;

$sizes = ComponentSizeConfig::dropdownSizes();
$sizeClasses = $sizes[$size] ?? $sizes['md'];

$baseClasses = 'bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm py-1 focus:outline-none';
$animationClasses = '[&[popover]]:[transition:opacity_150ms,transform_150ms,overlay_150ms_allow-discrete,display_150ms_allow-discrete] ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95';

$classes = trim("$baseClasses $sizeClasses $animationClasses");

$positioning = PositioningHelper::getAnchorPositioning($placement, $offset);
$positioningStyle = $positioning['style'];
@endphp

<div
    :id="$id('dropdown')"
    popover="auto"
    @toggle="open = $event.newState === 'open'"
    :style="`{{ $positioningStyle }} position-anchor: --dropdown-${$id('dropdown')};`"
    data-strata-dropdown-content
    data-placement="{{ $placement }}"
    role="menu"
    wire:ignore.self
    :aria-activedescendant="getActiveDescendant()"
    x-trap.nofocus="open"
    tabindex="-1"
    {{ $attributes->merge(['class' => $classes]) }}
>
    <div class="max-h-96 overflow-y-auto overflow-x-hidden p-1 space-y-1">
        {{ $slot }}
    </div>
</div>
