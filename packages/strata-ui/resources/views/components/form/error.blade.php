@props([
    'error' => null,
])

@if($error || $slot->isNotEmpty())
    <div {{ $attributes->merge(['class' => 'flex items-center gap-1.5 mt-1.5 text-sm text-destructive']) }}>
        <x-strata::icon.alert-circle class="w-4 h-4 flex-shrink-0" />
        <span>{{ $error ?? $slot }}</span>
    </div>
@endif
