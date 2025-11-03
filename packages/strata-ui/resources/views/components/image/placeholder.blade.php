@props([
    'src' => null,
    'blurHash' => null,
    'rounded' => null,
])

@php
$roundedClass = match($rounded) {
    'none' => 'rounded-none',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    'full' => 'rounded-full',
    default => '',
};
@endphp

<div
    data-strata-image-placeholder
    {{ $attributes->merge(['class' => "absolute inset-0 overflow-hidden {$roundedClass}"]) }}
>
    @if($src)
        <img
            src="{{ $src }}"
            alt=""
            class="w-full h-full object-cover blur-md scale-110"
        />
    @elseif($blurHash)
        <div
            class="w-full h-full bg-muted"
            style="background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);"
        ></div>
    @endif
</div>
