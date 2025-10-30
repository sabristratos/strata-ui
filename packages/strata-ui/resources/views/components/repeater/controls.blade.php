@props([
    'label' => 'Add Item',
    'size' => 'md',
    'disabled' => false,
])

<x-strata::button
    type="button"
    variant="secondary"
    :size="$size"
    :disabled="$disabled"
    {{ $attributes }}
>
    <x-strata::icon.plus class="w-4 h-4" />
    {{ $label }}
</x-strata::button>
