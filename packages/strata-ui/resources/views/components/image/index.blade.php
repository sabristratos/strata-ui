<div
    data-strata-image
    data-strata-field-type="image"
    x-data="window.StrataImage('{{ $src }}', '{{ $fallbackSrc }}', '{{ $fallbackIcon }}')"
    {{ $attributes->merge(['class' => 'relative ' . $displayClass . ' overflow-hidden ' . $sizeClass . ' ' . $aspectClass . ' ' . $roundedClass . ' ' . $variantClass . ($zoom ? ' group cursor-pointer' : '')]) }}
>
    @if($placeholder || $blurHash)
        <x-strata::image.placeholder
            :src="$placeholder"
            :blurHash="$blurHash"
            :rounded="$rounded"
            x-show="showPlaceholder"
        />
    @endif

    <div
        x-show="shouldShowSkeleton && !showPlaceholder"
        x-cloak
        class="absolute inset-0"
    >
        <x-strata::image.skeleton
            :variant="$skeletonVariant"
            :rounded="$rounded"
        />
    </div>

    <img
        x-show="shouldShowImage"
        :src="currentSrc"
        alt="{{ $alt }}"
        loading="{{ $loading }}"
        x-on:load="handleLoad()"
        x-on:error="handleError()"
        data-strata-image-element
        class="{{ $size || $aspect ? 'w-full h-full' : '' }} {{ $fitClass }} {{ $positionClass }} {{ $imageRoundedClass }}{{ $zoom ? ' transition-transform duration-300 ease-in-out group-hover:scale-110' : '' }} transition-opacity duration-200 starting:opacity-0 {{ $imgClass }}"
        :class="{ 'opacity-100': !isLoading, 'opacity-0': isLoading }"
        @if($processedSrcset || $srcset) srcset="{{ $processedSrcset ?? $srcset }}" @endif
        @if($sizes) sizes="{{ $sizes }}" @endif
    />

    <div
        x-show="shouldShowFallback"
        x-cloak
        class="absolute inset-0 flex items-center justify-center"
    >
        <x-strata::image.fallback
            :icon="$fallbackIcon"
            :showIcon="$showFallbackIcon"
        >
            {{ $slot }}
        </x-strata::image.fallback>
    </div>

    @if($caption)
        <x-strata::image.caption :position="$captionPosition">
            {{ $caption }}
        </x-strata::image.caption>
    @endif
</div>
