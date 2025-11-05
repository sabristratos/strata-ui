@props([
    'id' => null,
    'placement' => 'bottom-start',
    'size' => 'md',
    'offset' => 8,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

if (!$id) {
    throw new \InvalidArgumentException('Popover component requires an "id" prop');
}

$sizes = ComponentSizeConfig::dropdownSizes();

$sizeClasses = $sizes[$size] ?? $sizes['md'];

$baseClasses = 'overflow-hidden bg-popover text-popover-foreground border border-border rounded-lg shadow-xl backdrop-blur-sm ring-1 ring-black/5 dark:ring-white/10 p-4';

$classes = trim("$baseClasses $sizeClasses");
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataPopover', (placement, offset, popoverId) => ({
        ...window.createPositionableMixin({
            placement: placement,
            offset: offset,
            floatingRef: 'popover',
            triggerSelector: '[data-popover-trigger="' + popoverId + '"]',
            onOpen: function() {
                this.$refs.popover?.focus();
            }
        }),

        init() {
            this.initPositionable();
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
