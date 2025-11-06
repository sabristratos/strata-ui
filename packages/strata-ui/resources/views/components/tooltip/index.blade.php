@props([
    'text' => null,
    'placement' => 'top',
    'offset' => 8,
    'delay' => 200,
    'hideDelay' => 100,
])

@php
    use Stratos\StrataUI\Support\ComponentHelpers;

    $tooltipId = ComponentHelpers::generateId('tooltip', null, null);

    $hasNamedSlot = isset($content);
    $tooltipContent = $hasNamedSlot ? $content : $text;
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataTooltip', (placement, offset, delay, hideDelay) => ({
        ...window.createPositionableMixin({
            placement: placement,
            offset: offset,
            enableHide: true,
            hideStrategy: 'referenceHidden',
            floatingRef: 'tooltip'
        }),

        open: false,
        showTimeout: null,
        hideTimeout: null,

        init() {
            this.initPositionable();
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
            this.destroyPositionable();
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
        class="absolute z-50"
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
