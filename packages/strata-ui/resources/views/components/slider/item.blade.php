<div
    {{ $attributes->merge([
        'data-strata-slider-item' => true,
        'class' => 'flex-shrink-0',
        'role' => 'listitem',
    ]) }}
    x-init="
        $nextTick(() => {
            const wrapper = $el.closest('[data-strata-slider-items-wrapper]');
            const widthClass = wrapper?.getAttribute('data-item-width-class');
            const snapClass = wrapper?.getAttribute('data-snap-align-class');

            if (widthClass) $el.classList.add(widthClass);
            if (snapClass) $el.classList.add(snapClass);

            const items = wrapper?.querySelectorAll('[data-strata-slider-item]') || [];
            const itemIndex = Array.from(items).indexOf($el);
            $el.dataset.currentIndex = itemIndex;
        });
    "
    x-bind:aria-current="currentSlide === parseInt($el.dataset.currentIndex || '0') ? 'true' : 'false'"
    x-bind:aria-label="`Slide ${(parseInt($el.dataset.currentIndex || '0') + 1)} of ${totalSlides}`"
    x-on:click="if (currentSlide !== parseInt($el.dataset.currentIndex || '0')) { slider?.pauseAutoplay(); slider?.goTo(parseInt($el.dataset.currentIndex || '0')) }"
    tabindex="0"
>
    {{ $slot }}
</div>
