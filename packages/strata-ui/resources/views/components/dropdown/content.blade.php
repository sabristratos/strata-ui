@props([
    'size' => 'md',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$sizes = ComponentSizeConfig::dropdownSizes();

$sizeClasses = $sizes[$size] ?? $sizes['md'];

$baseClasses = 'bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm ring-1 ring-black/5 dark:ring-white/10 py-1';
$animationClasses = 'transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95';

$classes = trim("$baseClasses $sizeClasses $animationClasses");
@endphp

<div
    x-ref="content"
    x-cloak
    x-show="open"
    :style="positionable.styles"
    class="absolute top-0 left-0 z-50"
>
    <div
        x-trap.nofocus="open"
        @click.outside="close()"
        tabindex="-1"
        data-strata-dropdown-content
        role="menu"
        wire:ignore.self
        :aria-activedescendant="getActiveDescendant()"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        <div class="max-h-96 overflow-y-auto overflow-x-hidden p-1 space-y-1">
            {{ $slot }}
        </div>
    </div>
</div>
