@props([
    'fallback' => null,
    'aspect' => null,
    'rounded' => 'rounded-md',
])

<div
    {{ $attributes->merge(['class' => "flex items-center justify-center bg-[color:var(--color-muted)] {$rounded}"]) }}
    @if ($aspect)
        style="aspect-ratio: {{ $aspect }};"
    @else
        style="min-height: 200px;"
    @endif
>
    @if ($fallback)
        {{-- Fallback Image --}}
        <img
            src="{{ $fallback }}"
            alt="Fallback image"
            class="w-full h-full object-cover {{ $rounded }}"
        />
    @elseif ($slot->isNotEmpty())
        {{-- Custom Fallback Slot --}}
        {{ $slot }}
    @else
        {{-- Default Icon Fallback --}}
        <x-strata::icon.image class="w-12 h-12 text-[color:var(--color-muted-foreground)]" />
    @endif
</div>
