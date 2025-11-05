@props([
    'type' => 'multiple',
    'variant' => 'bordered',
    'defaultValue' => [],
    'name' => null,
])

@php
use Stratos\StrataUI\Support\ComponentHelpers;

$variants = [
    'bordered' => 'space-y-2',
    'divided' => 'divide-y divide-border',
    'card' => 'space-y-3',
    'minimal' => 'space-y-1',
];

$variantClasses = $variants[$variant] ?? $variants['bordered'];
$classes = trim($variantClasses);

$accordionName = $name ?? ($type === 'single' ? ComponentHelpers::generateId('accordion', null, null) : null);
@endphp

<div
    x-data="{
        variant: @js($variant),
        defaultValue: @js($defaultValue),
        accordionName: @js($accordionName)
    }"
    data-strata-accordion
    data-type="{{ $type }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</div>
