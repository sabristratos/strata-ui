@props([
    'format' => 'hex',
    'showPresets' => true,
    'presets' => [],
    'allowAlpha' => false,
    'placement' => 'bottom-start',
    'positioningStyle' => '',
])

<div
    :id="$id('colorpicker-dropdown')"
    popover="auto"
    @toggle="open = $event.newState === 'open'"
    :style="`{{ $positioningStyle }} position-anchor: --colorpicker-${$id('colorpicker-dropdown')};`"
    data-strata-colorpicker-dropdown
    data-placement="{{ $placement }}"
    x-trap.nofocus="open"
    wire:ignore.self
    tabindex="-1"
    class="animate-dropdown-bounce bg-popover text-popover-foreground border border-border rounded-lg shadow-lg p-4 space-y-4 w-72"
    role="dialog"
    aria-modal="true"
>
    <x-strata::color-picker.picker :allow-alpha="$allowAlpha" />

    @if($showPresets && !empty($presets))
    <x-strata::color-picker.palette :presets="$presets" />
    @endif

    <x-strata::color-picker.inputs :format="$format" :allow-alpha="$allowAlpha" />
</div>
