@props([
    'checked' => false,
])

<x-strata::table.cell align="center" class="w-12">
    <x-strata::checkbox
        :checked="$checked"
        {{ $attributes }}
    />
</x-strata::table.cell>
