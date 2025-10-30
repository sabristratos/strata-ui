@props([
    'name' => null,
])

@php
if (!$name) {
    throw new \InvalidArgumentException('Modal trigger requires a "name" prop to identify which modal to open');
}
@endphp

<div
    x-data="{
        open() {
            window.dispatchEvent(new CustomEvent('modal-open-{{ $name }}'));
        }
    }"
    @click="open()"
    data-strata-modal-trigger
    data-modal-name="{{ $name }}"
    {{ $attributes }}
>
    {{ $slot }}
</div>
