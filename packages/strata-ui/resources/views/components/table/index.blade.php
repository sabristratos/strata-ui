@props([
    'variant' => 'bordered',
    'size' => 'md',
    'hoverable' => true,
    'striped' => null,
    'responsive' => true,
    'sticky' => false,
])

@php
$striped = $striped ?? ($variant === 'striped');

$variants = [
    'bordered' => 'border border-table-border',
    'striped' => 'border-y border-table-border',
    'minimal' => '',
];

$sizes = [
    'sm' => 'text-sm',
    'md' => 'text-base',
    'lg' => 'text-lg',
];

$variantClasses = $variants[$variant] ?? $variants['bordered'];
$sizeClasses = $sizes[$size] ?? $sizes['md'];

$wrapperClasses = trim(implode(' ', array_filter([
    $responsive ? 'overflow-x-auto' : '',
    $responsive ? 'w-full' : '',
])));

$tableClasses = trim(implode(' ', array_filter([
    'w-full',
    'border-collapse',
    $variantClasses,
    $sizeClasses,
])));
@endphp

<div
    x-data="{
        variant: @js($variant),
        size: @js($size),
        hoverable: @js($hoverable),
        striped: @js($striped),
        sticky: @js($sticky),
    }"
    data-strata-table-wrapper
    {{ $attributes->only(['class', 'style'])->merge(['class' => $wrapperClasses]) }}
>
    <table
        data-strata-table
        class="{{ $tableClasses }}"
    >
        {{ $slot }}
    </table>
</div>
