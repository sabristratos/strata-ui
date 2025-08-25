@props([
    'position' => 'bottom-start',
    'offset' => 8,
    'width' => 'w-56'
])

<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    @click.outside="open = false"
    class="relative"
    {{ $attributes->except(['position', 'offset', 'width']) }}
>
    <div @click="open = !open" x-ref="trigger" class="inline-block">
        {{ $trigger }}
    </div>
    <template x-teleport="body">
        <div
            x-show="open"
            x-anchor.{{ $position }}.offset.{{ $offset }}="$refs.trigger"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute z-50 {{ $width }}"
            style="display: none;"
        >
            <div class="bg-popover text-popover-foreground rounded-lg shadow-lg border border-border">
                {{ $slot }}
            </div>
        </div>
    </template>
</div>