@props([
    'index' => 0,
    'removable' => true,
    'state' => 'default',
    'size' => 'md',
])

@php
    $stateClasses = [
        'default' => 'border-input-border bg-card',
        'success' => 'border-success bg-card',
        'error' => 'border-destructive bg-card',
        'warning' => 'border-warning bg-card',
    ];

    $sizeClasses = [
        'sm' => 'p-3',
        'md' => 'p-4',
        'lg' => 'p-5',
    ];

    $classes = trim($stateClasses[$state] . ' ' . $sizeClasses[$size]);
@endphp

<div
    data-strata-repeater-item
    :data-index="index"
    {{ $attributes->merge(['class' => $classes . ' border-2 rounded-lg transition-colors']) }}
>
    <div class="flex items-start gap-3">
        <div class="flex-1 min-w-0">
            {{ $slot }}
        </div>

        @if($removable)
            <button
                type="button"
                @click="$dispatch('remove')"
                class="shrink-0 p-1.5 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-md transition-colors"
                aria-label="Remove item"
            >
                <x-strata::icon.x class="w-4 h-4" />
            </button>
        @endif
    </div>
</div>
