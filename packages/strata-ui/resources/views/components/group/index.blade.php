@props([
    'orientation' => 'horizontal',
])

@php
$orientationClasses = [
    'horizontal' => 'flex flex-row',
    'vertical' => 'flex flex-col',
];

$childClasses = $orientation === 'horizontal'
    ? '[&>*]:border-r-0 [&>*:last-child]:border-r [&>*:not(:first-child)]:rounded-l-none [&>*:not(:last-child)]:rounded-r-none'
    : '[&>*]:border-b-0 [&>*:last-child]:border-b [&>*:not(:first-child)]:rounded-t-none [&>*:not(:last-child)]:rounded-b-none';

$baseClasses = ($orientationClasses[$orientation] ?? $orientationClasses['horizontal']) . ' ' . $childClasses;
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</div>
