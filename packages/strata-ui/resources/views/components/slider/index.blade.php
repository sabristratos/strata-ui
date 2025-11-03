{{--
/**
 * Slider Component
 *
 * Hybrid carousel/slider component supporting both presentational (carousel) and form (value selection) modes.
 * Uses StrataSlider module for state management and Entangleable for Livewire sync in form mode.
 *
 * @props
 * @prop string $mode - Component mode: 'presentational'|'form' (default: 'presentational')
 * @prop string $size - Component size: 'sm'|'md'|'lg' (default: 'md')
 * @prop string $state - Validation state: 'default'|'success'|'error'|'warning' (default: 'default')
 * @prop string|null $id - Component ID (default: 'slider-' . uniqid())
 * @prop string|null $name - Form input name for form mode (default: null)
 * @prop int|null $value - Selected slide index for form mode (default: null)
 * @prop int $perView - Number of slides visible at once: 1-4 (default: 1)
 * @prop int $gap - Gap between slides in Tailwind spacing units (default: 4)
 * @prop bool $peek - Show partial next/previous slides (default: false)
 * @prop string $peekAmount - Amount of peek as CSS value (default: '10%')
 * @prop bool $loop - Enable infinite loop (default: false)
 * @prop bool $autoplay - Enable autoplay (default: false)
 * @prop int $autoplayDelay - Autoplay delay in milliseconds (default: 5000)
 * @prop bool $showNavigation - Show prev/next buttons (default: true)
 * @prop bool $showDots - Show dot indicators (default: true)
 * @prop string $snapAlign - Scroll snap alignment: 'start'|'center'|'end' (default: 'start')
 *
 * @slots
 * @slot default - Slider items using <x-strata::slider.item> components
 *
 * @example Presentational carousel
 * <x-strata::slider :autoplay="true" :loop="true">
 *     <x-strata::slider.item>Slide 1</x-strata::slider.item>
 *     <x-strata::slider.item>Slide 2</x-strata::slider.item>
 *     <x-strata::slider.item>Slide 3</x-strata::slider.item>
 * </x-strata::slider>
 *
 * @example Form mode with Livewire
 * <x-strata::slider
 *     mode="form"
 *     wire:model="selectedSlide"
 *     name="product_selection"
 *     :perView="3"
 *     :showNavigation="true">
 *     <x-strata::slider.item>Product A</x-strata::slider.item>
 *     <x-strata::slider.item>Product B</x-strata::slider.item>
 *     <x-strata::slider.item>Product C</x-strata::slider.item>
 * </x-strata::slider>
 */
--}}

@props([
    'mode' => 'presentational',
    'size' => 'md',
    'state' => 'default',
    'id' => null,
    'name' => null,
    'value' => null,
    'perView' => 1,
    'gap' => 4,
    'peek' => false,
    'peekAmount' => '10%',
    'loop' => false,
    'autoplay' => false,
    'autoplayDelay' => 5000,
    'showNavigation' => true,
    'showDots' => true,
    'snapAlign' => 'start',
])

@php
if (!in_array($mode, ['presentational', 'form'])) {
    throw new \InvalidArgumentException('The "mode" prop must be one of: presentational, form. Got: ' . $mode);
}

if (!in_array($size, ['sm', 'md', 'lg'])) {
    throw new \InvalidArgumentException('The "size" prop must be one of: sm, md, lg. Got: ' . $size);
}

if (!in_array($state, ['default', 'success', 'error', 'warning'])) {
    throw new \InvalidArgumentException('The "state" prop must be one of: default, success, error, warning. Got: ' . $state);
}

$componentId = $id ?? $attributes->get('id') ?? 'slider-' . uniqid();
$isFormMode = $mode === 'form';

$peekMode = filter_var($peek, FILTER_VALIDATE_BOOLEAN);
$loopMode = filter_var($loop, FILTER_VALIDATE_BOOLEAN);
$autoplayEnabled = filter_var($autoplay, FILTER_VALIDATE_BOOLEAN);
$showNav = filter_var($showNavigation, FILTER_VALIDATE_BOOLEAN);
$showDotsValue = filter_var($showDots, FILTER_VALIDATE_BOOLEAN);

$sizes = [
    'sm' => 'min-h-32',
    'md' => 'min-h-48',
    'lg' => 'min-h-64',
];

$states = [
    'default' => 'border-border',
    'success' => 'border-success',
    'error' => 'border-destructive',
    'warning' => 'border-warning',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$stateClasses = $isFormMode ? ($states[$state] ?? $states['default']) : '';
$borderClasses = $isFormMode ? 'border-2 rounded-lg ' . $stateClasses : '';

$gapClass = "gap-{$gap}";

$gapPx = match((int)$gap) {
    1 => '0.25rem',
    2 => '0.5rem',
    3 => '0.75rem',
    4 => '1rem',
    5 => '1.25rem',
    6 => '1.5rem',
    8 => '2rem',
    default => '1rem',
};

$itemWidthClass = match((int)$perView) {
    1 => $peekMode ? "w-[calc(100%-{$peekAmount}-{$peekAmount})]" : 'w-full',
    2 => $peekMode
        ? "w-[calc((100%-{$peekAmount}-{$peekAmount}-{$gapPx})/2)]"
        : "w-[calc((100%-{$gapPx})/2)]",
    3 => $peekMode
        ? "w-[calc((100%-{$peekAmount}-{$peekAmount}-{$gapPx}-{$gapPx})/3)]"
        : "w-[calc((100%-{$gapPx}-{$gapPx})/3)]",
    4 => $peekMode
        ? "w-[calc((100%-{$peekAmount}-{$peekAmount}-{$gapPx}-{$gapPx}-{$gapPx})/4)]"
        : "w-[calc((100%-{$gapPx}-{$gapPx}-{$gapPx})/4)]",
    default => 'w-full',
};

$wrapperPadding = $peekMode ? "pl-[{$peekAmount}] pr-[{$peekAmount}]" : '';
$snapAlignClass = "snap-{$snapAlign}";
$scrollPadding = $peekMode ? "scroll-pl-[{$peekAmount}] scroll-pr-[{$peekAmount}]" : 'scroll-pr-4';

$normalizedValue = $isFormMode ? ($value ?? 0) : 0;

$sliderConfig = json_encode([
    'mode' => $mode,
    'loop' => $loopMode,
    'autoplay' => $autoplayEnabled,
    'autoplayDelay' => (int)$autoplayDelay,
    'peek' => $peekMode,
], JSON_UNESCAPED_SLASHES);

$wrapperAttributes = $attributes->only(['class', 'style']);
$inputAttributes = $attributes->except(['class', 'style', 'id'])->merge(['name' => $name]);
@endphp

<div
    {{ $wrapperAttributes->merge([
        'id' => $componentId,
        'data-strata-slider' => true,
        'data-strata-field-type' => $isFormMode ? 'slider' : null,
        'role' => 'region',
        'aria-roledescription' => 'carousel',
        'aria-label' => 'Content slider',
        'class' => $sizeClasses . ' ' . $borderClasses,
    ]) }}
    x-data="{ currentSlide: {{ $normalizedValue }}, totalSlides: 0, slider: null, init() { this.slider = new window.StrataSlider({{ Js::from(json_decode($sliderConfig, true)) }}); this.slider.init(this); }, destroy() { if (this.slider) { this.slider.destroy(); } } }"
    x-init="init()"
    x-destroy="destroy()"
    tabindex="0"
>
    @if($isFormMode)
        <input
            type="hidden"
            data-strata-slider-input
            {{ $inputAttributes }}
            value="{{ $normalizedValue }}"
        />
    @endif

    <div
        data-strata-slider-live-region
        class="sr-only"
        aria-live="polite"
        aria-atomic="true"
    ></div>

    <div
        data-strata-slider-container
        class="w-full overflow-x-auto snap-x snap-proximity scroll-smooth {{ $scrollPadding }} [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden"
        x-ref="container"
        x-on:scroll.debounce.150ms="slider?.updateCurrentSlide()"
        x-on:mouseenter="slider?.pauseAutoplay()"
        x-on:mouseleave="slider?.resumeAutoplay()"
        role="list"
    >
        <div
            data-strata-slider-items-wrapper
            data-item-width-class="{{ $itemWidthClass }}"
            data-snap-align-class="{{ $snapAlignClass }}"
            class="flex {{ $gapClass }} {{ $wrapperPadding }}"
        >
            {{ $slot }}
        </div>
    </div>

    @if($showNav)
        <div @mouseenter="slider?.pauseAutoplay()" @mouseleave="slider?.resumeAutoplay()">
            <x-strata::slider.navigation :size="$size" />
        </div>
    @endif

    @if($showDotsValue)
        <div @mouseenter="slider?.pauseAutoplay()" @mouseleave="slider?.resumeAutoplay()">
            <x-strata::slider.dots :size="$size" />
        </div>
    @endif

    @if($autoplayEnabled)
        <x-strata::slider.controls :size="$size" />
    @endif
</div>
