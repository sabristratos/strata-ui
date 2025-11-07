@props([
    'positioningStyle' => '',
    'animationClasses' => '',
    'placement' => 'bottom-start',
])

@php
$dropdownClasses = [
    'bg-popover text-popover-foreground border border-border rounded-lg shadow-lg overflow-hidden p-0 m-0',
    $animationClasses,
];
@endphp

<div
    :id="$id('timepicker-dropdown')"
    popover="auto"
    @toggle="open = $event.newState === 'open'"
    :style="`{{ $positioningStyle }} position-anchor: --timepicker-${$id('timepicker-dropdown')};`"
    data-strata-timepicker-dropdown
    data-placement="{{ $placement }}"
    x-trap.nofocus="open"
    wire:ignore.self
    tabindex="-1"
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
