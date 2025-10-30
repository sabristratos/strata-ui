@props([
    'label' => '',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'text-xs px-2 py-0.5 gap-1',
    'md' => 'text-sm px-2 py-1 gap-1.5',
    'lg' => 'text-base px-3 py-1.5 gap-2',
];

$iconSizes = [
    'sm' => 'w-3 h-3',
    'md' => 'w-4 h-4',
    'lg' => 'w-5 h-5',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];

$baseClasses = 'inline-flex items-center bg-primary/10 text-primary rounded-md font-medium transition-colors duration-150';

$classes = trim("$baseClasses $sizeClasses");
@endphp

<span data-strata-select-chip {{ $attributes->merge(['class' => $classes]) }}>
    <span x-text="label"></span>
    <button
        type="button"
        @click.stop="$dispatch('remove')"
        class="hover:bg-primary/20 rounded-sm transition-colors duration-150 p-0.5 -mr-1"
        aria-label="Remove"
    >
        <x-strata::icon.x class="{{ $iconSize }}" />
    </button>
</span>
