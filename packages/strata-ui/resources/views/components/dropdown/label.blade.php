@props([])

<div
    role="presentation"
    {{ $attributes->merge(['class' => 'px-4 py-2 text-xs font-semibold text-muted-foreground uppercase tracking-wider']) }}
>
    {{ $slot }}
</div>
