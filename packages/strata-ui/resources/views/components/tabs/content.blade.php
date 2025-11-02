@props([
    'value' => null,
])

@php
if (!$value) {
    throw new InvalidArgumentException('Tabs content requires a "value" prop.');
}
@endphp

<div
    x-show="isSelected(@js($value))"
    x-cloak
    role="tabpanel"
    :id="`${tabsId}-panel-${@js($value)}`"
    :aria-labelledby="`${tabsId}-tab-${@js($value)}`"
    :aria-hidden="!isSelected(@js($value))"
    data-strata-tabs-content
    data-tab-value="{{ $value }}"
    {{ $attributes->merge(['class' => 'transition-opacity duration-150 ease-out opacity-100 aria-hidden:opacity-0 starting:opacity-0']) }}
>
    {{ $slot }}
</div>
