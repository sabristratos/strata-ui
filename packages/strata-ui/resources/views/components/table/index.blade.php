@props([
    'variant' => 'bordered',
    'size' => 'md',
    'hoverable' => true,
    'striped' => null,
    'responsive' => 'stacked',
    'sticky' => false,
    'loading' => false,
])

@php
$striped = $striped ?? ($variant === 'striped');

$variants = [
    'bordered' => '',
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
    'relative',
    $variant === 'bordered' ? 'border border-table-border rounded-lg overflow-hidden' : '',
    $responsive === 'scroll' || $responsive === true ? 'overflow-x-auto' : '',
    $responsive ? 'w-full' : '',
])));

$tableClasses = trim(implode(' ', array_filter([
    'w-full',
    'border-collapse',
    $variantClasses,
    $sizeClasses,
    $responsive === 'stacked' ? 'table-responsive-stacked' : '',
])));
@endphp

<div
    x-data="{
        variant: @js($variant),
        size: @js($size),
        hoverable: @js($hoverable),
        striped: @js($striped),
        sticky: @js($sticky),
        loading: @js($loading),
    }"
    data-strata-table-wrapper
    @if($variant === 'striped') data-striped @endif
    {{ $attributes->only(['class', 'style'])->merge(['class' => $wrapperClasses]) }}
>
    @if($loading)
        <x-strata::table.loading />
    @endif

    <table
        data-strata-table
        class="{{ $tableClasses }}"
    >
        {{ $slot }}
    </table>
</div>
