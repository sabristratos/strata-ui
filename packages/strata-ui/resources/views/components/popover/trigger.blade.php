@props([
    'target' => null,
])

@php
if (!$target) {
    throw new \InvalidArgumentException('Popover trigger requires a "target" prop');
}
@endphp

<div
    x-data="{
        init() {
            const popoverEl = document.getElementById('{{ $target }}');
            if (popoverEl && popoverEl.__x) {
                this.$el.firstElementChild?.addEventListener('click', (e) => {
                    e.preventDefault();
                    popoverEl.__x.$data.toggle();
                });
            }
        }
    }"
    data-popover-trigger="{{ $target }}"
    {{ $attributes->merge(['class' => '']) }}
>
    {{ $slot }}
</div>
