@props([
    'variant' => 'pills',
    'size' => 'md',
])

<div
    role="tablist"
    :aria-orientation="orientation"
    data-strata-tabs-list
    data-variant="{{ $variant }}"
    data-size="{{ $size }}"
    {{ $attributes->merge(['class' => '
        group relative inline-flex
        aria-[orientation=horizontal]:flex-row aria-[orientation=vertical]:flex-col aria-[orientation=vertical]:items-start
        data-[variant=pills]:gap-1 data-[variant=pills]:bg-muted data-[variant=pills]:rounded-lg data-[variant=pills]:p-1
        data-[variant=pills][data-size=lg]:p-1.5
        data-[variant=underline]:gap-4 data-[variant=underline]:border-b data-[variant=underline]:border-border
        data-[variant=default]:gap-2
    ']) }}
>
    <div
        x-ref="marker"
        class="absolute left-0 z-10 transition-all duration-150 ease-out
               data-[variant=pills]:bg-card data-[variant=pills]:rounded-md data-[variant=pills]:shadow-sm
               data-[variant=underline]:h-0.5 data-[variant=underline]:bg-primary data-[variant=underline]:bottom-0"
        data-variant="{{ $variant }}"
    ></div>

    {{ $slot }}
</div>
