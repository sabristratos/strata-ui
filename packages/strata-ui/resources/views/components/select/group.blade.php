@props([
    'label' => null,
])

@php
if (!$label) {
    throw new \InvalidArgumentException('Select group requires a "label" prop');
}

$labelClasses = 'px-3 py-1.5 text-xs font-medium text-muted-foreground/70 uppercase tracking-wide select-none';
@endphp

<div {{ $attributes->merge(['class' => 'first:mt-0 mt-3 first:pt-0 pt-3 first:border-0 border-t border-border']) }}>
    <div class="{{ $labelClasses }}" role="group" aria-label="{{ $label }}">
        {{ $label }}
    </div>
    <div class="space-y-1 mt-1">
        {{ $slot }}
    </div>
</div>
