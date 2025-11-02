@props([
    'id' => null,
    'placement' => 'bottom-start',
    'size' => 'md',
    'offset' => 8,
])

@php
if (!$id) {
    throw new \InvalidArgumentException('Popover component requires an "id" prop');
}

$sizes = [
    'sm' => 'min-w-48 max-w-64',
    'md' => 'min-w-64 max-w-96',
    'lg' => 'min-w-80 max-w-lg',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];

$baseClasses = 'overflow-hidden bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm ring-1 ring-black/5 dark:ring-white/10 p-4';

$classes = trim("$baseClasses $sizeClasses");
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataPopover', (placement, offset, popoverId) => ({
        positionable: null,
        open: false,

        init() {
            this.positionable = new window.StrataPositionable({
                placement: placement,
                offset: offset,
                strategy: 'absolute'
            });

            const popover = this.$refs.popover;
            const triggerSelector = '[data-popover-trigger="' + popoverId + '"]';
            const trigger = document.querySelector(triggerSelector);

            if (popover && trigger) {
                this.positionable.start(this, trigger, popover);
            }

            this.$watch('open', (value) => {
                if (value) {
                    this.positionable.open();
                    this.$nextTick(() => {
                        popover?.focus();
                    });
                } else {
                    this.positionable.close();
                }
            });

            this.positionable.watch((state) => {
                if (!state) {
                    this.open = false;
                }
            });
        },

        toggle() {
            this.open = !this.open;
        },

        close() {
            this.open = false;
        }
    }));
});
</script>
@endonce

<div
    x-data="strataPopover('{{ $placement }}', {{ $offset }}, '{{ $id }}')"
    id="{{ $id }}"
    data-strata-popover-wrapper
>
    <div
        x-ref="popover"
        x-cloak
        x-show="open"
        :style="positionable.styles"
        class="absolute top-0 left-0 z-50"
    >
        <div
            x-trap.nofocus="open"
            @click.outside="close()"
            @keydown.escape="close()"
            data-strata-popover
            wire:ignore.self
            tabindex="-1"
            {{ $attributes->merge(['class' => $classes . ' transition-all transition-discrete duration-150 ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95']) }}
        >
            {{ $slot }}
        </div>
    </div>
</div>
