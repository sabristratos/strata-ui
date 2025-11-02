@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
$dropdownId = $attributes->get('data-dropdown-trigger');

if (!$dropdownId) {
    throw new \InvalidArgumentException('Dropdown trigger requires a data-dropdown-trigger attribute with matching dropdown id');
}

$variants = [
    'default' => 'inline-flex items-center justify-center gap-2 px-4 py-2 bg-secondary border border-border rounded-lg hover:bg-accent hover:border-primary/50 transition-all duration-200',
    'primary' => 'inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-all duration-200',
    'ghost' => 'inline-flex items-center justify-center gap-2 px-4 py-2 bg-transparent hover:bg-accent rounded-lg transition-all duration-200',
    'text' => 'inline-flex items-center justify-center gap-1 text-foreground hover:text-primary transition-colors duration-200',
];

$sizes = [
    'sm' => 'text-sm px-3 py-1.5',
    'md' => 'text-base px-4 py-2',
    'lg' => 'text-lg px-5 py-2.5',
];

$baseClasses = $variants[$variant] ?? $variants['default'];

$sizeClasses = '';
if ($variant !== 'text') {
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
}

$classes = trim("$baseClasses $sizeClasses");
@endphp

<button
    type="button"
    @click="toggle()"
    data-dropdown-trigger="{{ $dropdownId }}"
    aria-haspopup="true"
    :aria-expanded="open"
    :aria-controls="'{{ $dropdownId }}'"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>
