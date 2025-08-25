@props([
    'href' => null,
    'icon' => null,
    'active' => false
])

@php
    $tag = $href ? 'a' : 'button';
    $baseClasses = 'flex items-center w-full gap-x-3 px-3 py-2 text-left rounded-[var(--radius-component)] transition-colors text-secondary';
    $activeClasses = $active
        ? 'bg-primary/10 text-primary font-semibold'
        : 'hover:bg-default';
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => "$baseClasses $activeClasses", 'href' => $href]) }}>
    @if ($icon)
        <x-icon :name="$icon" class="w-5 h-5" />
    @endif

    <span class="flex-1">{{ $slot }}</span>

    @if (isset($badge))
        {{ $badge }}
    @endif
</{{ $tag }}>