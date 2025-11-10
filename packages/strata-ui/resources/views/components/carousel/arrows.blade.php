@props([
    'carousel',
    'size' => 'md',
    'variant' => 'secondary',
    'appearance' => 'outlined',
])

<div
    x-data="{ store: $store['carousel-{{ $carousel }}'] || {} }"
    {{ $attributes->merge(['class' => 'flex flex-row gap-2']) }}
    data-strata-carousel-arrows
>
    <x-strata::button.icon
        icon="chevron-left"
        :size="$size"
        :variant="$variant"
        :appearance="$appearance"
        x-on:click="store.prev()"
        ::disabled="!store.canScrollPrev"
        aria-label="Previous slide"
        data-strata-carousel-prev
    />
    <x-strata::button.icon
        icon="chevron-right"
        :size="$size"
        :variant="$variant"
        :appearance="$appearance"
        x-on:click="store.next()"
        ::disabled="!store.canScrollNext"
        aria-label="Next slide"
        data-strata-carousel-next
    />
</div>
