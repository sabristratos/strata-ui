@props([
    'variant' => 'info',
    'style' => 'subtle',
    'title' => null,
    'icon' => null,
    'dismissible' => false,
])

@php
$icons = [
    'neutral' => 'circle-help',
    'info' => 'info',
    'success' => 'check-circle',
    'warning' => 'alert-triangle',
    'error' => 'x-circle',
];

$iconName = $icon ?? $icons[$variant] ?? $icons['info'];

$variantClasses = [
    'neutral' => [
        'subtle' => 'bg-muted border-border text-muted-foreground',
        'bordered' => 'bg-transparent border-border text-muted-foreground',
        'filled' => 'bg-muted text-muted-foreground',
        'iconColor' => [
            'subtle' => 'text-muted-foreground',
            'bordered' => 'text-muted-foreground',
            'filled' => 'text-muted-foreground',
        ],
    ],
    'info' => [
        'subtle' => 'bg-info/10 border-info/20 text-info',
        'bordered' => 'bg-transparent border-info text-info',
        'filled' => 'bg-info text-info-foreground',
        'iconColor' => [
            'subtle' => 'text-info',
            'bordered' => 'text-info',
            'filled' => 'text-info-foreground',
        ],
    ],
    'success' => [
        'subtle' => 'bg-success/10 border-success/20 text-success',
        'bordered' => 'bg-transparent border-success text-success',
        'filled' => 'bg-success text-success-foreground',
        'iconColor' => [
            'subtle' => 'text-success',
            'bordered' => 'text-success',
            'filled' => 'text-success-foreground',
        ],
    ],
    'warning' => [
        'subtle' => 'bg-warning/10 border-warning/20 text-warning',
        'bordered' => 'bg-transparent border-warning text-warning',
        'filled' => 'bg-warning text-warning-foreground',
        'iconColor' => [
            'subtle' => 'text-warning',
            'bordered' => 'text-warning',
            'filled' => 'text-warning-foreground',
        ],
    ],
    'error' => [
        'subtle' => 'bg-destructive/10 border-destructive/20 text-destructive',
        'bordered' => 'bg-transparent border-destructive text-destructive',
        'filled' => 'bg-destructive text-destructive-foreground',
        'iconColor' => [
            'subtle' => 'text-destructive',
            'bordered' => 'text-destructive',
            'filled' => 'text-destructive-foreground',
        ],
    ],
];

$classes = $variantClasses[$variant] ?? $variantClasses['info'];
$alertClasses = $classes[$style] ?? $classes['subtle'];
$iconColor = $classes['iconColor'][$style] ?? $classes['iconColor']['subtle'];

$borderWidth = $style === 'bordered' ? 'border-2' : 'border';
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    role="alert"
    data-strata-alert
    {{ $attributes->merge([
        'class' => "relative flex gap-4 p-4 rounded-lg $borderWidth $alertClasses"
    ]) }}
>
    {{-- Icon --}}
    <div class="flex-shrink-0">
        <div class="flex items-center justify-center size-6">
            <x-dynamic-component :component="'strata::icon.'.$iconName" class="size-4 {{ $iconColor }}" />
        </div>
    </div>

    {{-- Content --}}
    <div class="flex-1 pt-0.5">
        @if($title)
            <h5 class="font-semibold text-base mb-1">{{ $title }}</h5>
        @endif

        <div class="text-sm {{ $title ? 'opacity-90' : '' }}">
            {{ $slot }}
        </div>
    </div>

    {{-- Dismiss button --}}
    @if($dismissible)
        <x-strata::button.icon
            icon="x"
            size="sm"
            variant="secondary"
            appearance="ghost"
            @click="show = false"
            aria-label="Dismiss"
            class="flex-shrink-0"
        />
    @endif
</div>
