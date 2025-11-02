@props([
    'value' => null,
    'checked' => false,
    'disabled' => false,
    'name' => null,
])

@php
$wrapperClasses = 'px-2 py-1 transition-colors duration-150 hover:bg-accent';
$disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';
$classes = trim("$wrapperClasses $disabledClasses");

$checkboxAttributes = $attributes->only(['wire:model', 'wire:model.live', 'x-model']);
$wrapperAttributes = $attributes->except(['wire:model', 'wire:model.live', 'x-model']);
@endphp

<div
    data-strata-dropdown-item
    @if($disabled) data-disabled @endif
    role="menuitemcheckbox"
    tabindex="-1"
    {{ $wrapperAttributes->merge(['class' => $classes]) }}
>
    <x-strata::checkbox
        :value="$value"
        :checked="$checked"
        :disabled="$disabled"
        :name="$name"
        size="sm"
        :attributes="$checkboxAttributes"
    >
        {{ $slot }}
    </x-strata::checkbox>
</div>
