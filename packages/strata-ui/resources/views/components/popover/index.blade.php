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
                this.highlighted = -1;
                this.$refs.popover?.focus();
            },
            onClose: function() {
                this.highlighted = -1;
            }
        }),

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
            this.initPositionable();
            this.initKeyboardNavigation();
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
    @keydown="handleKeyboardNavigation"
    {{ $attributes->merge(['class' => 'relative inline-block']) }}
>
    {{ $slot }}
</div>
