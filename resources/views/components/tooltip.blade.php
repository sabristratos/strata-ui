@props([
    'text',
    'position' => 'top',
    'offset' => 8
])

<div
    x-data="{ open: false }"
    @mouseenter="open = true"
    @mouseleave="open = false"
    class="relative inline-block max-w-max"
    x-ref="trigger"
>
    {{-- This is the element that triggers the tooltip --}}
    {{ $slot }}

    {{-- The tooltip content itself --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-75"
        x-anchor.{{ $position }}.offset.{{ $offset }}="$refs.trigger"
        role="tooltip"
        class="absolute z-50 px-2.5 py-1.5 text-sm font-medium text-primary-foreground bg-primary/90 rounded-md shadow-sm backdrop-blur-sm pointer-events-none whitespace-nowrap max-w-max"
        style="display: none;"
    >
        {{ $text }}
    </div>
</div>