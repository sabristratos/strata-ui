@aware([
    'separator' => 'chevron-right',
    'size' => 'md',
])

@php
    use Stratos\StrataUI\Config\ComponentSizeConfig;

    $iconSizeClasses = ComponentSizeConfig::breadcrumbsIconSizes();

    $textSizeClasses = [
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg',
    ];

    $iconSize = $iconSizeClasses[$size] ?? $iconSizeClasses['md'];
    $textSize = $textSizeClasses[$size] ?? $textSizeClasses['md'];
@endphp

<span
    data-strata-breadcrumbs-separator
    aria-hidden="true"
    {{ $attributes->merge(['class' => 'inline-flex items-center text-muted-foreground']) }}
>
    @if($separator === 'slash')
        <span class="mx-0.5 {{ $textSize }}">/</span>
    @elseif($separator === 'chevron-right')
        <x-strata::icon.chevron-right class="{{ $iconSize }}" />
    @else
        <span>{{ $separator }}</span>
    @endif
</span>
