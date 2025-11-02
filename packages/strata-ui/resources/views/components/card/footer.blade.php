@props([
    'align' => 'end',
])

@php
$alignments = [
    'start' => 'justify-start',
    'center' => 'justify-center',
    'end' => 'justify-end',
    'between' => 'justify-between',
];

$classes = 'flex items-center gap-3 p-6 pt-4 bg-muted border-t border-border ' . ($alignments[$align] ?? $alignments['end']);
@endphp

<div data-strata-card-footer {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
