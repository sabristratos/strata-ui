@props([
    'for' => null,
    'required' => false,
])

<label
    {{ $attributes->merge(['class' => 'block text-sm font-medium text-foreground mb-1.5']) }}
    @if($for) for="{{ $for }}" @endif
>
    {{ $slot }}
    @if($required)
        <span class="text-destructive ml-0.5">*</span>
    @endif
</label>
