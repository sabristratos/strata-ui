@props([
    'variant' => 'default',
    'size' => 'md',
    'separator' => 'chevron-right',
    'maxItems' => null,
])

@php
    $variants = [
        'default' => '',
        'bold' => 'font-semibold',
    ];

    $sizes = [
        'sm' => 'text-sm gap-1.5',
        'md' => 'text-base gap-2',
        'lg' => 'text-lg gap-2.5',
    ];

    $variantClasses = $variants[$variant] ?? $variants['default'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];

    $baseClasses = 'flex flex-wrap items-center ' . $variantClasses . ' ' . $sizeClasses;
@endphp

<nav
    aria-label="Breadcrumbs"
    data-strata-breadcrumbs
    x-data="{
        maxItems: @js($maxItems),
        separator: @js($separator),
        size: @js($size),
        variant: @js($variant),
        showAll: false,
        init() {
            if (this.maxItems) {
                this.$nextTick(() => {
                    const items = this.$el.querySelectorAll('[data-strata-breadcrumbs-item]');
                    if (items.length > this.maxItems) {
                        items.forEach((item, index) => {
                            if (index !== 0 && index !== items.length - 1 && index >= Math.floor(this.maxItems / 2)) {
                                item.style.display = this.showAll ? 'flex' : 'none';
                                const separator = item.nextElementSibling;
                                if (separator && separator.hasAttribute('data-strata-breadcrumbs-separator')) {
                                    separator.style.display = this.showAll ? 'flex' : 'none';
                                }
                            }
                        });
                    }
                });
            }
        },
        toggleShowAll() {
            this.showAll = !this.showAll;
            this.init();
        },
        shouldShowEllipsis() {
            if (!this.maxItems) return false;
            const items = this.$el.querySelectorAll('[data-strata-breadcrumbs-item]');
            return items.length > this.maxItems;
        }
    }"
    {{ $attributes->merge(['class' => $baseClasses]) }}
>
    {{ $slot }}

    <template x-if="shouldShowEllipsis() && !showAll">
        <x-strata::button.icon
            icon="more-horizontal"
            variant="secondary"
            appearance="ghost"
            @click="toggleShowAll"
            aria-label="Show all breadcrumbs"
            x-bind:size="size === 'sm' ? 'sm' : (size === 'lg' ? 'lg' : 'md')"
            class="!p-0"
        />
    </template>
</nav>
