@props([
    'badge' => null,
    'dot' => false,
    'variant' => 'destructive',
    'position' => 'top-right',
    'size' => 'sm',
])

@php
$positions = [
    'top-right' => 'top-1 right-1 translate-x-1/2 -translate-y-1/2',
    'top-left' => 'top-1 left-1 -translate-x-1/2 -translate-y-1/2',
    'bottom-right' => 'bottom-1 right-1 translate-x-1/2 translate-y-1/2',
    'bottom-left' => 'bottom-1 left-1 -translate-x-1/2 translate-y-1/2',
];

$dotColors = [
    'primary' => 'bg-primary',
    'secondary' => 'bg-secondary',
    'success' => 'bg-success',
    'warning' => 'bg-warning',
    'destructive' => 'bg-destructive',
    'info' => 'bg-info',
];

$dotSizes = [
    'sm' => 'w-3 h-3',
    'md' => 'w-4 h-4',
    'lg' => 'w-5 h-5',
];

$positionClasses = $positions[$position] ?? $positions['top-right'];
$dotColor = $dotColors[$variant] ?? $dotColors['destructive'];
$dotSize = $dotSizes[$size] ?? $dotSizes['sm'];
$showBadge = $badge !== null || $dot;
@endphp

<div {{ $attributes->merge(['class' => 'relative inline-flex']) }}>
    {{ $slot }}

    @if($showBadge)
        <span class="absolute z-10 {{ $positionClasses }}">
            @if($dot)
                <span class="inline-block {{ $dotColor }} {{ $dotSize }} rounded-full border-2 border-body" aria-label="{{ $badge ?? 'Indicator' }}"></span>
            @else
                <x-strata::badge :variant="$variant" :size="$size" style="filled">
                    {{ $badge }}
                </x-strata::badge>
            @endif
        </span>
    @endif
</div>
