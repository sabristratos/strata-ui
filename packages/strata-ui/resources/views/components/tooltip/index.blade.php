@props([
    'text' => null,
    'placement' => 'top',
    'offset' => 8,
    'delay' => 200,
    'hideDelay' => 100,
])

@php
    $tooltipId = 'tooltip-' . uniqid();

    $hasNamedSlot = isset($content);
    $tooltipContent = $hasNamedSlot ? $content : $text;
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataTooltip', (placement, offset, delay, hideDelay) => ({
        positionable: null,
        open: false,
        showTimeout: null,
        hideTimeout: null,

        init() {
            this.positionable = new window.StrataPositionable({
                placement: placement,
                offset: offset,
                strategy: 'absolute',
                enableHide: true,
                hideStrategy: 'referenceHidden'
            });

            const trigger = this.$refs.trigger;
            const tooltip = this.$refs.tooltip;

            if (trigger && tooltip) {
                this.positionable.start(this, trigger, tooltip);
            }

            this.$watch('open', (value) => {
                if (value) {
                    this.positionable.open();
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

        show() {
            clearTimeout(this.hideTimeout);
            this.showTimeout = setTimeout(() => {
                this.open = true;
            }, delay);
        },

        hide() {
            clearTimeout(this.showTimeout);
            this.hideTimeout = setTimeout(() => {
                this.open = false;
            }, hideDelay);
        },

        destroy() {
            clearTimeout(this.showTimeout);
            clearTimeout(this.hideTimeout);
            if (this.positionable) {
                this.positionable.cleanup();
            }
        }
    }));
});
</script>
@endonce

<div
    x-data="strataTooltip('{{ $placement }}', {{ $offset }}, {{ $delay }}, {{ $hideDelay }})"
    data-strata-tooltip-wrapper
    class="inline-block"
>
    <div
        x-ref="trigger"
        @mouseenter="show()"
        @mouseleave="hide()"
        @focus="show()"
        @blur="hide()"
        class="inline-block"
    >
        {{ $slot }}
    </div>

    <div
        x-ref="tooltip"
        x-cloak
        x-show="open"
        :style="positionable?.styles"
        @mouseenter="show()"
        @mouseleave="hide()"
        class="absolute top-0 left-0 z-50"
    >
        <div
            data-strata-tooltip
            class="bg-popover text-popover-foreground
                   border border-border rounded-md
                   shadow-lg ring-1 ring-black/5 dark:ring-white/10
                   text-sm px-3 py-1.5
                   max-w-xs
                   transition-all transition-discrete duration-150 ease-out
                   will-change-[transform,opacity]
                   opacity-100 scale-100
                   starting:opacity-0 starting:scale-95"
        >
            @if($hasNamedSlot)
                {{ $tooltipContent }}
            @else
                {{ $text }}
            @endif
        </div>
    </div>
</div>
