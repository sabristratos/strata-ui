@props([
    'position' => 'bottom',
])

@php
$positionClasses = match($position) {
    'top' => 'mb-2',
    'bottom' => 'mt-2',
    'overlay' => 'absolute bottom-0 left-0 right-0 bg-black/60 text-white p-2',
    default => 'mt-2',
};
@endphp

<div
    data-strata-image-caption
    {{ $attributes->merge(['class' => "text-sm text-muted-foreground {$positionClasses}"]) }}
>
    {{ $slot }}
</div>
