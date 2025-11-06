@props([
    'value' => null,
    'icon' => null,
    'disabled' => false,
])

@php
if (!$value) {
    throw new InvalidArgumentException('Tabs trigger requires a "value" prop.');
}
@endphp

<button
    type="button"
    role="tab"
    :id="`${tabsId}-tab-${@js($value)}`"
    :aria-selected="isSelected(@js($value)) ? 'true' : 'false'"
    :aria-controls="`${tabsId}-panel-${@js($value)}`"
    data-tab-value="{{ $value }}"
    data-strata-tabs-trigger
    @click="select($el)"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => '
        relative z-20 inline-flex items-center justify-center font-medium whitespace-nowrap
        group-aria-[orientation=vertical]:justify-start group-aria-[orientation=vertical]:w-full
        transition-colors duration-150 border-0 bg-transparent cursor-pointer
        focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
        disabled:pointer-events-none disabled:opacity-50 disabled:cursor-not-allowed
        group-data-[size=sm]:h-8 group-data-[size=sm]:px-3 group-data-[size=sm]:text-sm group-data-[size=sm]:gap-1.5
        group-data-[size=md]:h-10 group-data-[size=md]:px-4 group-data-[size=md]:text-base group-data-[size=md]:gap-2
        group-data-[size=lg]:h-12 group-data-[size=lg]:px-6 group-data-[size=lg]:text-lg group-data-[size=lg]:gap-2.5
        group-data-[variant=pills]:rounded-md
        group-data-[variant=pills]:aria-selected:text-foreground
        group-data-[variant=pills]:aria-[selected=false]:text-muted-foreground group-data-[variant=pills]:aria-[selected=false]:hover:text-foreground
        group-data-[variant=underline]:-mb-px
        group-data-[variant=underline]:aria-selected:text-primary
        group-data-[variant=underline]:aria-[selected=false]:text-muted-foreground group-data-[variant=underline]:aria-[selected=false]:hover:text-foreground
        group-data-[variant=default]:rounded-md
        group-data-[variant=default]:aria-selected:bg-muted group-data-[variant=default]:aria-selected:text-foreground
        group-data-[variant=default]:aria-[selected=false]:text-muted-foreground group-data-[variant=default]:aria-[selected=false]:hover:bg-muted/50 group-data-[variant=default]:aria-[selected=false]:hover:text-foreground
    ']) }}
>
    @if($icon)
        <x-dynamic-component
            :component="'strata::icon.' . $icon"
            class="group-data-[size=sm]:w-4 group-data-[size=sm]:h-4 group-data-[size=md]:w-5 group-data-[size=md]:h-5 group-data-[size=lg]:w-6 group-data-[size=lg]:h-6"
        />
    @endif

    {{ $slot }}
</button>
