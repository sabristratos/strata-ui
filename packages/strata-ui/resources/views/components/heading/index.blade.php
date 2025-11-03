@props([
    'level' => 2,
    'as' => null,
    'variant' => 'default',
    'size' => null,
])

@php
    $level = max(1, min(6, (int) $level));
    $tag = $as ?? "h{$level}";

    $levelSizes = [
        1 => 'text-4xl md:text-5xl font-bold tracking-tight',
        2 => 'text-3xl md:text-4xl font-bold tracking-tight',
        3 => 'text-2xl md:text-3xl font-semibold',
        4 => 'text-xl md:text-2xl font-semibold',
        5 => 'text-lg md:text-xl font-semibold',
        6 => 'text-base md:text-lg font-semibold',
    ];

    $variantClasses = [
        'default' => 'text-foreground',
        'gradient' => 'w-fit bg-gradient-to-r from-primary to-info bg-clip-text text-transparent pb-1 -mb-1',
        'muted' => 'text-muted-foreground',
    ];

    $sizeClass = $size ?? $levelSizes[$level];
    $variantClass = $variantClasses[$variant] ?? $variantClasses['default'];
@endphp

@if($slot->isNotEmpty())
    <{{ $tag }} {{ $attributes->merge(['class' => $sizeClass . ' ' . $variantClass]) }} data-strata-heading data-strata-heading-level="{{ $level }}" data-strata-heading-variant="{{ $variant }}">
        {{ $slot }}
    </{{ $tag }}>
@endif
