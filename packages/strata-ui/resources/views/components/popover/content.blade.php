@props([
    'padding' => 'normal',
    'size' => 'md',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$sizes = ComponentSizeConfig::dropdownSizes();

$sizeClasses = $sizes[$size] ?? $sizes['md'];

$paddings = [
    'none' => '',
    'sm' => 'p-3',
    'normal' => 'p-4',
    'lg' => 'p-6',
];

$paddingClasses = $paddings[$padding] ?? $paddings['normal'];

$baseClasses = 'overflow-hidden bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm ring-1 ring-black/5 dark:ring-white/10';
$animationClasses = 'transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95';

$classes = trim("$baseClasses $sizeClasses $paddingClasses $animationClasses");
@endphp

<div
    x-ref="popover"
    x-cloak
    x-show="open"
    :style="positionable.styles"
    class="absolute z-50"
>
    <div
        x-trap.nofocus="open"
        @click.outside="close()"
        @keydown.escape="close()"
        data-strata-popover-content
        wire:ignore.self
        tabindex="-1"
        role="menu"
        :aria-activedescendant="getActiveDescendant()"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </div>
</div>
