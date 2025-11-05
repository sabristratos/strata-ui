@props([
    'variant' => 'default',
    'size' => 'md',
    'separator' => 'chevron-right',
    'maxItems' => null,
])

@php
    use Stratos\StrataUI\Config\ComponentSizeConfig;

    $variants = [
        'default' => '',
        'bold' => 'font-semibold',
    ];

    $sizes = ComponentSizeConfig::breadcrumbsSizes();

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
        init() {
            if (this.maxItems) {
                this.$nextTick(() => {
                    const items = this.$el.querySelectorAll('[data-strata-breadcrumbs-item]');
                    if (items.length > this.maxItems) {
                        const itemsToShow = Math.floor((this.maxItems - 1) / 2);

                        items.forEach((item, index) => {
                            const shouldHide = index > itemsToShow && index < items.length - 1;
                            if (shouldHide) {
                                item.style.display = 'none';
                                const separator = item.nextElementSibling;
                                if (separator && separator.hasAttribute('data-strata-breadcrumbs-separator')) {
                                    separator.style.display = 'none';
                                }
                            }
                        });

                        const ellipsis = this.$refs.ellipsis;
                        if (ellipsis) {
                            const lastVisibleItem = items[itemsToShow];
                            const separator = lastVisibleItem.nextElementSibling;
                            if (separator && separator.hasAttribute('data-strata-breadcrumbs-separator')) {
                                separator.insertAdjacentElement('afterend', ellipsis);
                            } else {
                                lastVisibleItem.insertAdjacentElement('afterend', ellipsis);
                            }
                            ellipsis.style.display = 'inline-flex';
                        }
                    }
                });
            }
        }
    }"
    {{ $attributes->merge(['class' => $baseClasses]) }}
>
    @if($maxItems)
        <span
            x-ref="ellipsis"
            aria-hidden="true"
            data-strata-breadcrumbs-ellipsis
            class="hidden items-center justify-center text-muted-foreground px-1"
        >
            <x-strata::icon.more-horizontal class="w-5 h-5" />
        </span>
    @endif

    {{ $slot }}
</nav>
