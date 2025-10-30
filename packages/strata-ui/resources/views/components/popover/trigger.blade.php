@props([
    'target' => null,
    'action' => 'toggle',
])

@php
if (!$target) {
    throw new \InvalidArgumentException('Popover trigger requires a "target" prop');
}

$anchorName = '--anchor-' . $target;
$anchorStyle = 'anchor-name: ' . $anchorName . ';';
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataPopoverTrigger', (target, action) => ({
        init() {
            const popover = document.getElementById(target);
            const trigger = this.$el.firstElementChild;

            if (popover && trigger) {
                if (trigger.tagName === 'BUTTON') {
                    trigger.popoverTargetElement = popover;
                    trigger.popoverTargetAction = action;
                } else {
                    trigger.setAttribute('role', 'button');
                    trigger.setAttribute('tabindex', '0');
                    trigger.setAttribute('aria-haspopup', 'true');

                    const handleTrigger = (e) => {
                        if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') {
                            return;
                        }
                        if (e.type === 'keydown') {
                            e.preventDefault();
                        }

                        if (action === 'show') {
                            popover.showPopover();
                        } else if (action === 'hide') {
                            popover.hidePopover();
                        } else {
                            popover.togglePopover();
                        }
                    };

                    trigger.addEventListener('click', handleTrigger);
                    trigger.addEventListener('keydown', handleTrigger);
                }

                if (!trigger.style.cursor) {
                    trigger.style.cursor = 'pointer';
                }
            }
        }
    }));
});
</script>
@endonce

<div
    x-data="strataPopoverTrigger('{{ $target }}', '{{ $action }}')"
    data-strata-popover-trigger
    {{ $attributes->merge(['style' => $anchorStyle]) }}
>
    {{ $slot }}
</div>
