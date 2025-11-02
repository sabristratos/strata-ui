@props([
    'type' => null,
])

@php
    $iconSizes = [
        'sm' => 'w-3.5 h-3.5',
        'md' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
    ];
@endphp

<span
    data-strata-breadcrumbs-separator
    aria-hidden="true"
    x-data="{
        separator: @js($type) || $el.closest('[data-strata-breadcrumbs]').__x?.$data?.separator || 'chevron-right',
        size: $el.closest('[data-strata-breadcrumbs]').__x?.$data?.size || 'md'
    }"
    {{ $attributes->merge(['class' => 'inline-flex items-center text-muted-foreground']) }}
>
    <template x-if="separator === 'slash'">
        <span
            class="mx-0.5"
            x-bind:class="size === 'sm' ? 'text-sm' : (size === 'lg' ? 'text-lg' : 'text-base')"
        >/</span>
    </template>

    <template x-if="separator === 'chevron-right'">
        <x-strata::icon.chevron-right
            x-bind:class="size === 'sm' ? 'w-3.5 h-3.5' : (size === 'lg' ? 'w-5 h-5' : 'w-4 h-4')"
        />
    </template>

    <template x-if="separator !== 'slash' && separator !== 'chevron-right'">
        <span x-text="separator"></span>
    </template>
</span>
