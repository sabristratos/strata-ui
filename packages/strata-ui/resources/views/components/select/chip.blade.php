@props([
    'label' => '',
    'size' => 'md',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$sizes = ComponentSizeConfig::badgeSizes();
$iconSizes = ComponentSizeConfig::badgeIconSizes();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];

$baseClasses = 'inline-flex items-center bg-primary/10 text-primary rounded-md font-medium transition-colors duration-150';

$classes = trim("$baseClasses $sizeClasses");
@endphp

<span data-strata-select-chip {{ $attributes->merge(['class' => $classes]) }}>
    <span x-text="label"></span>
    <x-strata::button.icon
        icon="x"
        size="sm"
        variant="primary"
        appearance="ghost"
        @click.stop="$dispatch('remove')"
        aria-label="Remove"
        class="hover:bg-primary/20 !p-0.5 -mr-1"
    />
</span>
