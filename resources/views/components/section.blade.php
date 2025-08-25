<section {{ $attributes->merge(['class' => $getPaddingClasses()]) }}>
    <div class="{{ $getContainerClasses() }} mx-auto">
        {{ $slot }}
    </div>
</section>