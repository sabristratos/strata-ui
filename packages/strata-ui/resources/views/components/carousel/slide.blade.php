<div
    {{ $attributes->merge(['class' => 'flex-shrink-0 w-full']) }}
    data-strata-carousel-slide
    role="group"
    aria-roledescription="slide"
>
    {{ $slot }}
</div>
