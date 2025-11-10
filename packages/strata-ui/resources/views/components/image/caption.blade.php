@props([
    'position' => 'bottom',
])

@php
    $positionClasses = [
        'bottom' => 'mt-2',
        'overlay' => 'absolute bottom-0 left-0 right-0 bg-black/60 text-white p-2',
    ];

    $classes = $positionClasses[$position] ?? $positionClasses['bottom'];
@endphp

<figcaption {{ $attributes->merge(['class' => "text-sm text-[color:var(--color-muted-foreground)] {$classes}"]) }}>
    {{ $slot }}
</figcaption>
