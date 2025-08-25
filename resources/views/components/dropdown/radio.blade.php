@php
    $radioId = $name . '_' . $value . '_' . uniqid();
@endphp

<label 
    for="{{ $radioId }}" 
    class="flex items-start gap-3 px-3 py-2 text-sm cursor-pointer rounded-[var(--radius-component-sm)] hover:bg-default transition-colors group"
    {{ $attributes }}
>
    <div class="flex items-center h-5">
        <input
            id="{{ $radioId }}"
            name="{{ $name }}"
            type="radio"
            value="{{ $value }}"
            @if($checked) checked @endif
            class="h-4 w-4 text-primary border-default focus:outline-hidden focus:ring-2 focus:ring-primary focus:ring-offset-2"
        >
    </div>
    
    <div class="flex-1 min-w-0">
        <div class="text-primary font-medium group-hover:text-primary">
            {{ $label ?? $slot }}
        </div>
        @if($description)
            <div class="text-xs text-muted mt-0.5">{{ $description }}</div>
        @endif
    </div>
</label>