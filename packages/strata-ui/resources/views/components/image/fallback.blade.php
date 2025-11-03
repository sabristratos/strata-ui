@props([
    'icon' => 'image',
    'showIcon' => true,
])

<div
    data-strata-image-fallback
    {{ $attributes->merge(['class' => 'w-full h-full flex flex-col items-center justify-center bg-muted text-muted-foreground']) }}
>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @elseif($showIcon)
        <x-dynamic-component
            :component="'strata::icon.' . $icon"
            class="w-1/3 h-1/3 opacity-50"
        />
    @endif
</div>
