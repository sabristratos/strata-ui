@props([
    'blurHash' => null,
    'placeholder' => null,
    'aspect' => null,
    'rounded' => 'rounded-md',
])

<div {{ $attributes->merge(['class' => "absolute inset-0 overflow-hidden {$rounded}"]) }}>
    @if ($blurHash)
        {{-- BlurHash Canvas --}}
        <canvas
            x-ref="blurHashCanvas"
            class="w-full h-full {{ $rounded }}"
            @if ($aspect)
                style="aspect-ratio: {{ $aspect }};"
            @endif
        ></canvas>
    @elseif ($placeholder)
        {{-- Blur Placeholder Image --}}
        <img
            src="{{ $placeholder }}"
            alt=""
            class="w-full h-full object-cover {{ $rounded }} blur-sm scale-110"
            @if ($aspect)
                style="aspect-ratio: {{ $aspect }};"
            @endif
        />
    @endif
</div>
