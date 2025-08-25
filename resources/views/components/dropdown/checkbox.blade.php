@php
    $checkboxId = $name . '_' . $value . '_' . uniqid();
    // Remove [] from name for the ID if present (common in multi-value form fields)
    $cleanName = str_replace(['[', ']'], '', $name);
@endphp

<label 
    for="{{ $checkboxId }}" 
    class="flex items-start gap-3 px-3 py-2 text-sm cursor-pointer rounded-[var(--radius-component-sm)] hover:bg-default transition-colors group"
    {{ $attributes }}
>
    <div class="flex items-center h-5">
        <input
            id="{{ $checkboxId }}"
            name="{{ $name }}"
            type="checkbox"
            value="{{ $value }}"
            @if($checked) checked @endif
            class="h-4 w-4 text-primary border-default rounded-[var(--radius-component-sm)] focus:outline-hidden focus:ring-2 focus:ring-primary focus:ring-offset-2"
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