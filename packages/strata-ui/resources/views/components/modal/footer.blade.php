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

$alignClasses = $alignments[$align] ?? $alignments['end'];
$classes = "flex items-center gap-3 px-6 py-4 bg-muted/30 border-t border-border $alignClasses";
@endphp

<div data-strata-modal-footer {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
