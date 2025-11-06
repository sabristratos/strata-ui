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
>
    <div
        @click.outside="open = false"
        @keydown.escape.window="open = false"
        {{ $attributes->merge(['class' => implode(' ', $dropdownClasses)]) }}
        role="dialog"
        aria-modal="true"
    >
        <div class="flex w-[360px]">
            @if ($showPresets)
                <x-strata::time-picker.presets />
            @endif

            <div class="flex-1 p-2">
                <x-strata::time-picker.time-list />
            </div>
        </div>
    </div>
</div>
