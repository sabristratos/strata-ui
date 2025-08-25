@php
    $tag = $attributes->has('href') ? 'a' : 'button';

    $isIconOnly = $icon && empty(trim(strip_tags($slot)));

    $baseClasses = 'inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0';

    $sizeClasses = match ($size) {
        'sm' => 'h-8 rounded-md px-3 text-xs',
        'lg' => 'h-10 rounded-md px-8',
        default => 'h-9 px-4 py-2 rounded-md',
    };

    $iconSizeClasses = match ($size) {
        'sm' => 'w-4 h-4',
        'lg' => 'w-6 h-6',
        default => 'w-5 h-5',
    };

    if ($isIconOnly) {
        $layoutClasses = match ($size) {
            'sm' => 'h-8 w-8 rounded-md',
            'lg' => 'h-10 w-10 rounded-md',
            default => 'h-9 w-9 rounded-md',
        };
    } else {
        $layoutClasses = $sizeClasses;
    }
@endphp

@isset($badge)
<div class="relative inline-block">
@endisset

<{{ $tag }} {{ $attributes->merge([
    'type' => $tag === 'button' ? $type : null,
    'disabled' => $tag === 'button' ? ($disabled || $loading) : null,
    'class' => implode(' ', [$baseClasses, $layoutClasses, $getVariantClasses()])
]) }}>
@if ($loading)
    <svg @class(["animate-spin", $iconSizeClasses]) xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
@else
    @if ($icon && $iconPosition === 'left')
        <x-icon :name="$icon" :class="$iconSizeClasses" />
    @endif

    @if ($slot->isNotEmpty())
        <span>{!! $slot !!}</span>
    @endif

    @if ($icon && $iconPosition === 'right')
        <x-icon :name="$icon" :class="$iconSizeClasses" />
    @endif
@endif
</{{ $tag }}>

@isset($badge)
    <div class="absolute -top-1 -right-1 z-10 transform">
        {!! $badge !!}
    </div>
</div>
@endisset
