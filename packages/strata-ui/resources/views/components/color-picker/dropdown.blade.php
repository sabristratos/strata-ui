@props([
    'format' => 'hex',
    'showPresets' => true,
    'presets' => [],
    'allowAlpha' => false,
])

@php
$dropdownClasses = [
    'bg-popover text-popover-foreground border border-border rounded-lg shadow-lg',
    'transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity]',
    'opacity-100 scale-100',
    'starting:opacity-0 starting:scale-95',
];
@endphp

<div
    x-ref="dropdown"
    x-cloak
    x-show="open"
    :style="positionable.styles"
    class="absolute z-50"
    data-strata-colorpicker-dropdown
>
    <div
        @click.outside="open = false"
        @keydown.escape.window="open = false"
        class="{{ implode(' ', $dropdownClasses) }}"
        role="dialog"
        aria-modal="true"
    >
        <div class="p-4 space-y-4 w-72">
            <x-strata::color-picker.picker :allow-alpha="$allowAlpha" />

            @if($showPresets && !empty($presets))
            <x-strata::color-picker.palette :presets="$presets" />
            @endif

            <x-strata::color-picker.inputs :format="$format" :allow-alpha="$allowAlpha" />
        </div>
    </div>
</div>
