@props([
    'positioningStyle' => '',
    'animationClasses' => '',
    'placement' => 'bottom-start',
    'format' => '12',
    'showPresets' => false,
    'displayMode' => 'clock',
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
    @if ($displayMode === 'clock')
        <div class="flex min-w-[300px] max-w-[420px]">
            @if ($showPresets)
                <x-strata::time-picker.presets />
            @endif

            <div class="flex-1">
                <x-strata::time-picker.clock :format="$format" />
            </div>
        </div>
    @elseif ($displayMode === 'list')
        <div class="flex min-w-[300px] max-w-[420px]">
            @if ($showPresets)
                <x-strata::time-picker.presets />
            @endif

            <div class="flex-1 p-2">
                <x-strata::time-picker.time-list />
            </div>
        </div>
    @else
        <div class="flex flex-col min-w-[300px] max-w-[420px]">
            <div class="flex justify-center gap-2 p-2 border-b border-border">
                <button
                    type="button"
                    @click="displayMode = 'clock'"
                    :class="{
                        'bg-primary text-primary-foreground': displayMode === 'clock',
                        'bg-muted text-foreground hover:bg-muted/80': displayMode !== 'clock'
                    }"
                    class="px-3 py-1.5 rounded-md text-sm font-medium transition-colors"
                >
                    Clock
                </button>
                <button
                    type="button"
                    @click="displayMode = 'list'"
                    :class="{
                        'bg-primary text-primary-foreground': displayMode === 'list',
                        'bg-muted text-foreground hover:bg-muted/80': displayMode !== 'list'
                    }"
                    class="px-3 py-1.5 rounded-md text-sm font-medium transition-colors"
                >
                    List
                </button>
            </div>

            <div x-show="displayMode === 'clock'">
                <x-strata::time-picker.clock :format="$format" />
            </div>

            <div x-show="displayMode === 'list'" class="flex">
                @if ($showPresets)
                    <x-strata::time-picker.presets />
                @endif

                <div class="flex-1 p-2">
                    <x-strata::time-picker.time-list />
                </div>
            </div>
        </div>
    @endif
</div>
