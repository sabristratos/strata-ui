@props([
    'id' => null,
    'size' => 'md',
    'placement' => 'bottom-start',
    'offset' => 8,
])

@php
$dropdownId = $id ?? 'dropdown-' . uniqid();

$sizes = [
    'sm' => 'min-w-48 max-w-64',
    'md' => 'min-w-64 max-w-96',
    'lg' => 'min-w-80 max-w-lg',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('strataDropdown', (dropdownId, placement, offset) => ({
        positionable: null,
        open: false,
        highlighted: -1,
        items: [],
        typeaheadBuffer: '',
        typeaheadTimeout: null,

        init() {
            this.positionable = new window.StrataPositionable({
                placement: placement,
                offset: offset,
                strategy: 'absolute'
            });

            const content = this.$refs.content;
            const trigger = document.querySelector(`[data-dropdown-trigger="${dropdownId}"]`);

            if (content && trigger) {
                this.positionable.start(this, trigger, content);
            }

            this.$nextTick(() => {
                this.collectItems();
            });

            this.$watch('open', (value) => {
                if (value) {
                    this.positionable.open();
                    this.$nextTick(() => {
                        this.$refs.content?.focus();
                        this.highlighted = -1;
                    });
                } else {
                    this.positionable.close();
                    this.highlighted = -1;
                    this.typeaheadBuffer = '';
                }
            });

            this.positionable.watch((state) => {
                if (!state) {
                    this.open = false;
                }
            });
        },

        collectItems() {
            const itemElements = this.$el.querySelectorAll('[data-strata-dropdown-item]:not([data-disabled])');
            this.items = Array.from(itemElements).map(el => ({
                element: el,
                text: el.textContent.trim(),
                disabled: el.hasAttribute('data-disabled'),
                role: el.getAttribute('role')
            }));
        },

        toggle() {
            this.open = !this.open;
        },

        close() {
            this.open = false;
        },

        getActiveDescendant() {
            if (this.highlighted === -1 || !this.items[this.highlighted]) return '';
            return this.items[this.highlighted].element.id || '';
        },

        highlightNext() {
            const availableItems = this.items.filter(item => !item.disabled);
            if (availableItems.length === 0) return;

            if (this.highlighted === -1) {
                this.highlighted = this.items.indexOf(availableItems[0]);
            } else {
                const currentIndex = availableItems.findIndex(item => this.items.indexOf(item) === this.highlighted);
                const nextItem = availableItems[(currentIndex + 1) % availableItems.length];
                this.highlighted = this.items.indexOf(nextItem);
            }
            this.scrollToHighlighted();
        },

        highlightPrevious() {
            const availableItems = this.items.filter(item => !item.disabled);
            if (availableItems.length === 0) return;

            if (this.highlighted === -1) {
                this.highlighted = this.items.indexOf(availableItems[availableItems.length - 1]);
            } else {
                const currentIndex = availableItems.findIndex(item => this.items.indexOf(item) === this.highlighted);
                const prevItem = availableItems[(currentIndex - 1 + availableItems.length) % availableItems.length];
                this.highlighted = this.items.indexOf(prevItem);
            }
            this.scrollToHighlighted();
        },

        highlightFirst() {
            const availableItems = this.items.filter(item => !item.disabled);
            if (availableItems.length > 0) {
                this.highlighted = this.items.indexOf(availableItems[0]);
                this.scrollToHighlighted();
            }
        },

        highlightLast() {
            const availableItems = this.items.filter(item => !item.disabled);
            if (availableItems.length > 0) {
                this.highlighted = this.items.indexOf(availableItems[availableItems.length - 1]);
                this.scrollToHighlighted();
            }
        },

        activateHighlighted() {
            if (this.highlighted !== -1 && this.items[this.highlighted]) {
                const item = this.items[this.highlighted].element;
                if (item && !item.hasAttribute('data-disabled')) {
                    item.click();
                }
            }
        },

        scrollToHighlighted() {
            if (this.highlighted !== -1 && this.items[this.highlighted]) {
                this.items[this.highlighted].element.scrollIntoView({
                    block: 'nearest',
                    behavior: 'auto'
                });
            }
        },

        handleTypeahead(key) {
            clearTimeout(this.typeaheadTimeout);

            this.typeaheadBuffer += key.toLowerCase();

            const matchingItem = this.items.find(item =>
                !item.disabled && item.text.toLowerCase().startsWith(this.typeaheadBuffer)
            );

            if (matchingItem) {
                this.highlighted = this.items.indexOf(matchingItem);
                this.scrollToHighlighted();
            }

            this.typeaheadTimeout = setTimeout(() => {
                this.typeaheadBuffer = '';
            }, 500);
        },

        handleKeydown(e) {
            if (!this.open) {
                if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    this.open = true;
                }
                return;
            }

            switch(e.key) {
                case 'Escape':
                    e.preventDefault();
                    this.close();
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    this.highlightNext();
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    this.highlightPrevious();
                    break;
                case 'Home':
                    e.preventDefault();
                    this.highlightFirst();
                    break;
                case 'End':
                    e.preventDefault();
                    this.highlightLast();
                    break;
                case 'Tab':
                    this.close();
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.activateHighlighted();
                    break;
                default:
                    if (e.key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
                        e.preventDefault();
                        this.handleTypeahead(e.key);
                    }
                    break;
            }
        },
    }));
});
</script>
@endonce

<div
    x-data="strataDropdown('{{ $dropdownId }}', '{{ $placement }}', {{ $offset }})"
    data-strata-dropdown
    @keydown="handleKeydown"
    {{ $attributes->merge(['class' => 'relative inline-block']) }}
>
    {{ $slot }}
</div>
