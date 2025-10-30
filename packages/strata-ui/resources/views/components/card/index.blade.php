@props([
    'style' => 'elevated',
    'hoverable' => false,
    'clickable' => false,
    'loading' => false,
    'href' => null,
])

@php
$styles = [
    'elevated' => 'bg-card text-card-foreground border border-card-border shadow-sm',
    'outlined' => 'bg-card text-card-foreground border border-card-border',
    'filled' => 'bg-card text-card-foreground',
    'flat' => 'bg-transparent text-card-foreground',
];

$baseClasses = 'relative rounded-lg overflow-hidden';
$styleClasses = $styles[$style] ?? $styles['elevated'];

$interactiveClasses = '';
if ($hoverable || $clickable || $href) {
    $interactiveClasses = 'transition-all duration-200';

    if ($style === 'elevated') {
        $interactiveClasses .= ' hover:shadow-md';
    } elseif ($style === 'outlined') {
        $interactiveClasses .= ' hover:border-primary';
    } else {
        $interactiveClasses .= ' hover:bg-card-hover';
    }
}

if ($clickable || $href) {
    $interactiveClasses .= ' cursor-pointer';
}

$classes = trim("$baseClasses $styleClasses $interactiveClasses");

$tag = ($clickable || $href) ? 'a' : 'div';
$additionalAttributes = [];

if ($href) {
    $additionalAttributes['href'] = $href;
}
@endphp

<{{ $tag }}
    data-strata-card
    {{ $attributes->merge(['class' => $classes]) }}
    @foreach($additionalAttributes as $key => $value)
        {{ $key }}="{{ $value }}"
    @endforeach
>
    @if($loading)
        <div class="absolute inset-0 bg-card/80 backdrop-blur-sm flex items-center justify-center z-10">
            <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
        </div>
    @endif

    {{ $slot }}
</{{ $tag }}>
