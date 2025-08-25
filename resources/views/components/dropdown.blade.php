@props([
    'position' => 'bottom-end',
    'width' => 'w-56'
])

<x-strata::popover :position="$position" :width="$width">
    {{-- Pass the trigger slot through to the underlying popover --}}
    <x-slot:trigger>
        {{ $trigger }}
    </x-slot:trigger>

    {{-- The dropdown content area with padding --}}
    <div class="p-1">
        {{ $slot }}
    </div>
</x-strata::popover>