@props([
    'id' => null,
    'type' => 'auto',
    'placement' => 'bottom',
    'size' => 'md',
    'offset' => '8',
])

@php
if (!$id) {
    throw new \InvalidArgumentException('Popover component requires an "id" prop');
}

$sizes = [
    'sm' => 'min-w-48 max-w-64',
    'md' => 'min-w-64 max-w-96',
    'lg' => 'min-w-80 max-w-lg',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];

$baseClasses = 'bg-popover text-popover-foreground !border !border-popover-border rounded-lg shadow-xl backdrop-blur-sm ring-1 ring-black/5 dark:ring-white/10 p-0 m-0';
$placementClasses = 'popover-placement-' . $placement;

$classes = trim("$baseClasses $sizeClasses $placementClasses");

$popoverType = $type === 'manual' ? 'manual' : 'auto';

$anchorName = '--anchor-' . $id;
$offsetValue = is_numeric($offset) ? $offset . 'px' : $offset;
$styleValue = 'position-anchor: ' . $anchorName . '; --popover-offset: ' . $offsetValue . ';';
@endphp

<div
    id="{{ $id }}"
    popover="{{ $popoverType }}"
    data-strata-popover
    data-placement="{{ $placement }}"
    wire:ignore.self
    {{ $attributes->merge(['class' => $classes, 'style' => $styleValue]) }}
>
    {{ $slot }}
</div>
