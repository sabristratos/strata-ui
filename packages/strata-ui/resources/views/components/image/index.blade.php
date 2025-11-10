@props([
    'id' => 'image-' . uniqid(),
])

@php
    $roundedClass = $getRoundedClass();
    $objectFitClass = $getObjectFitClass();
    $objectPositionClass = $getObjectPositionClass();
    $aspectRatio = $getAspectRatio();
    $lightboxAttrs = $getLightboxAttributes();
    $usesPicture = $usesPictureElement();

    $imageClasses = "{$objectFitClass} {$objectPositionClass} {$roundedClass} w-full h-full transition-opacity duration-300" . ($lightbox ? ' cursor-pointer' : '');

    $aspectStyle = $aspectRatio ? "aspect-ratio: {$aspectRatio};" : '';

    $skeletonStyle = $aspectStyle;
    if (!$aspectStyle && $width && $height) {
        $skeletonStyle = "width: {$width}px; height: {$height}px;";
    } elseif (!$aspectStyle) {
        $skeletonStyle = 'min-height: 200px;';
    }

    $errorStyle = $aspectStyle ?: 'min-height: 200px;';

    if ($caption) {
        $captionPositionClass = $captionPosition === 'overlay'
            ? 'absolute bottom-0 left-0 right-0 bg-black/60 text-white p-2'
            : 'mt-2';
        $captionClasses = "text-sm text-muted-foreground {$captionPositionClass}";
    }
@endphp

<div
    {{ $attributes->merge(['class' => 'relative inline-block']) }}
    x-data="imageComponent({
        src: {{ json_encode($src) }},
        fallback: {{ json_encode($fallback) }},
        blurHash: {{ json_encode($blurHash) }},
        placeholder: {{ json_encode($placeholder) }},
        placeholderType: {{ json_encode($placeholderType) }}
    })"
    x-init="init()"
>
    @if ($placeholder || $blurHash)
        @if ($blurHash)
            <div class="absolute inset-0 overflow-hidden {{ $roundedClass }}" x-show="state === 'loading'" x-cloak>
                <canvas x-ref="blurHashCanvas" class="w-full h-full {{ $roundedClass }}" {!! $aspectStyle ? 'style="' . $aspectStyle . '"' : '' !!}></canvas>
            </div>
        @elseif ($placeholder)
            <div class="absolute inset-0 overflow-hidden {{ $roundedClass }}" x-show="state === 'loading'" x-cloak>
                <img src="{{ $placeholder }}" alt="" class="w-full h-full object-cover {{ $roundedClass }} blur-sm scale-110" {!! $aspectStyle ? 'style="' . $aspectStyle . '"' : '' !!} />
            </div>
        @endif
    @endif

    @if ($placeholderType === 'skeleton')
        <div
            class="bg-[color:var(--color-muted)] animate-pulse {{ $roundedClass }}"
            x-show="state === 'loading' && !blurHash && !placeholder"
            x-cloak
            style="{{ $skeletonStyle }}"
        ></div>
    @endif

    @if ($usesPicture)
        <picture>
            @foreach ($sources as $source)
                <source
                    {!! isset($source['srcset']) ? 'srcset="' . $source['srcset'] . '"' : '' !!}
                    {!! isset($source['type']) ? 'type="' . $source['type'] . '"' : '' !!}
                    {!! isset($source['media']) ? 'media="' . $source['media'] . '"' : '' !!}
                    {!! isset($source['sizes']) ? 'sizes="' . $source['sizes'] . '"' : '' !!}
                />
            @endforeach

            <img
                id="{{ $id }}"
                src="{{ $src }}"
                alt="{{ $alt }}"
                {!! $srcset ? 'srcset="' . $srcset . '"' : '' !!}
                {!! $sizes ? 'sizes="' . $sizes . '"' : '' !!}
                {!! $width ? 'width="' . $width . '"' : '' !!}
                {!! $height ? 'height="' . $height . '"' : '' !!}
                loading="{{ $loading }}"
                {!! $fetchpriority ? 'fetchpriority="' . $fetchpriority . '"' : '' !!}
                {!! $decodeAsync ? 'decoding="async"' : '' !!}
                @foreach ($lightboxAttrs as $attr => $value)
                    {{ $attr }}="{{ $value }}"
                @endforeach
                class="{{ $imageClasses }}"
                :class="{ 'opacity-0': state === 'loading', 'opacity-100': state === 'loaded' }"
                {!! $aspectStyle ? 'style="' . $aspectStyle . '"' : '' !!}
                x-ref="image"
                x-on:load="handleLoad"
                x-on:error="handleError"
            />
        </picture>
    @else
        <img
            id="{{ $id }}"
            src="{{ $src }}"
            alt="{{ $alt }}"
            {!! $srcset ? 'srcset="' . $srcset . '"' : '' !!}
            {!! $sizes ? 'sizes="' . $sizes . '"' : '' !!}
            {!! $width ? 'width="' . $width . '"' : '' !!}
            {!! $height ? 'height="' . $height . '"' : '' !!}
            loading="{{ $loading }}"
            {!! $fetchpriority ? 'fetchpriority="' . $fetchpriority . '"' : '' !!}
            {!! $decodeAsync ? 'decoding="async"' : '' !!}
            @foreach ($lightboxAttrs as $attr => $value)
                {{ $attr }}="{{ $value }}"
            @endforeach
            class="{{ $imageClasses }}"
            :class="{ 'opacity-0': state === 'loading', 'opacity-100': state === 'loaded' }"
            {!! $aspectStyle ? 'style="' . $aspectStyle . '"' : '' !!}
            x-ref="image"
            x-on:load="handleLoad"
            x-on:error="handleError"
        />
    @endif

    <div
        class="flex items-center justify-center bg-[color:var(--color-muted)] {{ $roundedClass }}"
        x-show="state === 'error'"
        x-cloak
        style="{{ $errorStyle }}"
    >
        @if ($fallback)
            <img src="{{ $fallback }}" alt="Fallback image" class="w-full h-full object-cover {{ $roundedClass }}" />
        @else
            <x-strata::icon.image class="w-12 h-12 text-[color:var(--color-muted-foreground)]" />
        @endif
    </div>

    @if ($caption)
        <figcaption class="{{ $captionClasses }}">
            {{ $caption }}
        </figcaption>
    @endif
</div>
