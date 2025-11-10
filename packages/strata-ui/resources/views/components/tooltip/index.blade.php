@props([
    'text' => null,
    'placement' => 'top',
    'offset' => 8,
])

@php
    use Stratos\StrataUI\Support\PositioningHelper;
    use Stratos\StrataUI\Support\ComponentHelpers;

    $hasNamedSlot = isset($content);
    $tooltipContent = $hasNamedSlot ? $content : $text;

    $positioning = PositioningHelper::getAnchorPositioning($placement, $offset);
    $positioningStyle = $positioning['style'];

    $tooltipId = ComponentHelpers::generateId('tooltip', null, null);
@endphp

<div
    x-data="{
        open: false,

        init() {
            console.log('Tooltip Alpine component initialized', this.$refs);
        },

        show() {
            console.log('Tooltip show() called', { open: this.open, refs: this.$refs });
            try {
                const popover = this.$refs.tooltip;
                console.log('Popover element:', popover);
                if (popover) {
                    console.log('Calling showPopover()');
                    popover.showPopover();
                    console.log('showPopover() completed');
                } else {
                    console.error('Popover ref not found');
                }
            } catch (e) {
                console.error('Tooltip show error:', e);
            }
        },

        hide() {
            console.log('Tooltip hide() called', { open: this.open });
            try {
                const popover = this.$refs.tooltip;
                if (popover) {
                    console.log('Calling hidePopover()');
                    popover.hidePopover();
                } else {
                    console.error('Popover ref not found');
                }
            } catch (e) {
                console.error('Tooltip hide error:', e);
            }
        },

        toggle() {
            console.log('Tooltip toggle() called');
            if (this.open) {
                this.hide();
            } else {
                this.show();
            }
        }
    }"
    @keydown.escape.window="hide()"
    data-strata-tooltip-wrapper
    class="inline-block"
>
    <div
        style="anchor-name: --tooltip-{{ $tooltipId }};"
        @mouseenter="show()"
        @mouseleave="hide()"
        @focus="show()"
        @blur="hide()"
        @click="toggle()"
        class="inline-block"
    >
        {{ $slot }}
    </div>

    <div
        x-ref="tooltip"
        popover="hint"
        @toggle="open = $event.newState === 'open'; console.log('Tooltip toggle event:', $event.newState, open)"
        id="tooltip-{{ $tooltipId }}"
        style="{{ $positioningStyle }} position-anchor: --tooltip-{{ $tooltipId }};"
        role="tooltip"
        data-strata-tooltip
        data-placement="{{ $placement }}"
        class="bg-popover text-popover-foreground
               border border-border rounded-md
               shadow-lg
               text-sm px-3 py-1.5
               max-w-xs
               animate-tooltip-bounce"
        {{ $attributes->except(['class', 'style']) }}
    >
        @if($hasNamedSlot)
            {{ $tooltipContent }}
        @else
            {{ $text }}
        @endif
    </div>
</div>
