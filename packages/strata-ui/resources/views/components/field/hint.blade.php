@props([
    'hint' => null,
])

@if($hint || $slot->isNotEmpty())
    <div {{ $attributes->merge(['class' => 'mt-1.5 text-sm text-muted-foreground']) }}>
        {{ $hint ?? $slot }}
    </div>
@endif
