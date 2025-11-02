@props([
    'href' => null,
    'icon' => null,
    'active' => false,
])

@php
    $tag = $href && !$active ? 'a' : 'span';

    $iconSizes = [
        'sm' => 'w-3.5 h-3.5',
        'md' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
    ];

    $baseClasses = 'inline-flex items-center gap-1.5 transition-colors';

    $stateClasses = $active
        ? 'text-foreground'
        : 'text-muted-foreground hover:text-foreground';

    $classes = $baseClasses . ' ' . $stateClasses;

    $additionalAttributes = [];
    if ($href && !$active) {
        $additionalAttributes['href'] = $href;
    }
    if ($active) {
        $additionalAttributes['aria-current'] = 'page';
    }
@endphp

<{{ $tag }}
    data-strata-breadcrumbs-item
    x-data="{ size: $el.closest('[data-strata-breadcrumbs]').__x?.$data?.size || 'md' }"
    {{ $attributes->merge(['class' => $classes]) }}
    @foreach($additionalAttributes as $key => $value)
        {{ $key }}="{{ $value }}"
    @endforeach
>
    @if($icon)
        <x-dynamic-component
            :component="'strata::icon.' . $icon"
            x-bind:class="size === 'sm' ? 'w-3.5 h-3.5' : (size === 'lg' ? 'w-5 h-5' : 'w-4 h-4')"
        />
    @endif

    <span>{{ $slot }}</span>
</{{ $tag }}>
