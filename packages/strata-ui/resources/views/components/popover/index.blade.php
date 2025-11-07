@props([
    'placement' => 'bottom-start',
    'size' => 'md',
    'offset' => 8,
])

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataPopover', (placement, offset) => ({
        ...window.createKeyboardNavigationMixin({
            itemSelector: '[data-strata-popover-item]:not([data-disabled])',
            itemMapper: (el) => ({
                element: el,
                text: el.textContent.trim(),
                disabled: el.hasAttribute('data-disabled')
            }),
            onActivate: function(item) {
                item.element.click();
                this.close();
            },
            enableTypeahead: false,
            onClose: function() {
                this.close();
            }
        }),

        open: false,

        init() {
            this.initKeyboardNavigation();
        },

        close() {
            this.open = false;
        }
    }));
});
</script>
@endonce

<div
    x-data="strataPopover('{{ $placement }}', {{ $offset }})"
    x-modelable="open"
    x-id="['popover']"
    x-provide="{ placement: '{{ $placement }}', offset: {{ $offset }} }"
    data-strata-popover
    @keydown="handleKeyboardNavigation"
    {{ $attributes->merge(['class' => 'relative inline-block overflow-visible']) }}
>
    {{ $slot }}
</div>
