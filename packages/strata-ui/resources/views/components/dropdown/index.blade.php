@props([
    'id' => null,
    'size' => 'md',
    'placement' => 'bottom-start',
    'offset' => 8,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$sizes = ComponentSizeConfig::dropdownSizes();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataDropdown', (placement, offsetValue) => ({
        ...window.createKeyboardNavigationMixin({
            itemSelector: '[data-strata-dropdown-item]:not([data-disabled])',
            itemMapper: (el) => ({
                element: el,
                text: el.textContent.trim(),
                disabled: el.hasAttribute('data-disabled'),
                role: el.getAttribute('role')
            }),
            onActivate: function(item) {
                item.element.click();
                this.close();
            },
            enableTypeahead: true,
            onClose: function() {
                this.close();
            }
        }),

        open: false,

        init() {
            this.initKeyboardNavigation();

            this.$watch('open', (value) => {
                if (value) {
                    this.highlighted = -1;
                } else {
                    this.highlighted = -1;
                    this.typeaheadBuffer = '';
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
    x-data="strataDropdown('{{ $placement }}', {{ $offset }})"
    x-modelable="open"
    x-id="['dropdown']"
    x-provide="{ placement: '{{ $placement }}', offset: {{ $offset }} }"
    data-strata-dropdown
    @keydown="handleKeyboardNavigation"
    {{ $attributes->merge(['class' => 'relative inline-block overflow-visible']) }}
>
    {{ $slot }}
</div>
