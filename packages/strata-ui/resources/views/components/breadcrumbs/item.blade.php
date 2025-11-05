@props([
    'href' => null,
    'icon' => null,
    'active' => false,
])

@php
    use Stratos\StrataUI\Config\ComponentSizeConfig;

    $tag = $href && !$active ? 'a' : 'span';

    $iconSizes = ComponentSizeConfig::breadcrumbsIconSizes();

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
    x-data="{
        size: $el.closest('[data-strata-breadcrumbs]').__x?.$data?.size || 'md',
        iconSizes: @js($iconSizes)
    }"
    {{ $attributes->merge(['class' => $classes]) }}
    @foreach($additionalAttributes as $key => $value)
        {{ $key }}="{{ $value }}"
    @endforeach
>
    @if($icon)
        <x-dynamic-component
            :component="'strata::icon.' . $icon"
            x-bind:class="iconSizes[size] || iconSizes['md']"
        />
    @endif

    <span>{{ $slot }}</span>
</{{ $tag }}>
