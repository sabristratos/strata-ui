@props([
    'size' => 'md',
    'rounded' => 'full',
    'state' => 'default',
    'disabled' => false,
    'checked' => false,
    'label' => null,
    'description' => null,
    'id' => null,
])

@php
$trackSizes = [
    'sm' => 'h-5 w-9',
    'md' => 'h-7 w-12',
    'lg' => 'h-9 w-16',
];

$thumbSizes = [
    'sm' => 'w-3 h-3',
    'md' => 'w-4 h-4',
    'lg' => 'w-5 h-5',
];

$thumbTranslations = [
    'sm' => 'translate-x-1 group-has-[:checked]:translate-x-5',
    'md' => 'translate-x-1 group-has-[:checked]:translate-x-7',
    'lg' => 'translate-x-1 group-has-[:checked]:translate-x-[2.5rem]',
];

$labelSizes = [
    'sm' => 'text-sm',
    'md' => 'text-base',
    'lg' => 'text-lg',
];

$descriptionSizes = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];

$roundedClasses = [
    'none' => 'rounded-none',
    'sm' => 'rounded-sm',
    'base' => 'rounded',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl',
    '3xl' => 'rounded-3xl',
    'full' => 'rounded-full',
];

$states = [
    'default' => [
        'track' => 'bg-muted group-has-[:checked]:bg-primary focus:ring-primary',
        'thumb' => 'bg-body',
    ],
    'success' => [
        'track' => 'bg-muted group-has-[:checked]:bg-success focus:ring-success',
        'thumb' => 'bg-body',
    ],
    'error' => [
        'track' => 'bg-muted group-has-[:checked]:bg-destructive focus:ring-destructive',
        'thumb' => 'bg-body',
    ],
    'warning' => [
        'track' => 'bg-muted group-has-[:checked]:bg-warning focus:ring-warning',
        'thumb' => 'bg-body',
    ],
];

$trackSizeClasses = $trackSizes[$size] ?? $trackSizes['md'];
$thumbSizeClasses = $thumbSizes[$size] ?? $thumbSizes['md'];
$thumbTranslateClasses = $thumbTranslations[$size] ?? $thumbTranslations['md'];
$labelSizeClasses = $labelSizes[$size] ?? $labelSizes['md'];
$descriptionSizeClasses = $descriptionSizes[$size] ?? $descriptionSizes['md'];
$roundedClass = $roundedClasses[$rounded] ?? $roundedClasses['full'];
$stateClasses = $states[$state] ?? $states['default'];

$toggleId = $id ?? $attributes->get('id') ?? 'toggle-' . uniqid();

$wrapperAttributes = $attributes->only(['class', 'style']);
$toggleAttributes = $attributes->except(['class', 'style']);
@endphp

<div
    data-strata-toggle-wrapper
    {{ $wrapperAttributes->merge(['class' => 'group flex items-center justify-between gap-3 w-full']) }}
>
    @if($label || $description || $slot->isNotEmpty())
        <div class="flex flex-col gap-0.5 flex-1">
            <label
                for="{{ $toggleId }}"
                class="{{ $labelSizeClasses }} text-foreground cursor-pointer select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'hover:text-foreground/90' }}"
            >
                @if($label)
                    {{ $label }}
                @else
                    {{ $slot }}
                @endif
            </label>

            @if($description)
                <span class="{{ $descriptionSizeClasses }} text-muted-foreground {{ $disabled ? 'opacity-50' : '' }}">
                    {{ $description }}
                </span>
            @endif
        </div>
    @endif

    <div class="relative inline-flex items-center select-none shrink-0">
        <input
            type="checkbox"
            id="{{ $toggleId }}"
            data-strata-toggle
            data-strata-field-type="toggle"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $toggleAttributes->merge(['class' => 'sr-only peer']) }}
        />

        <label
            for="{{ $toggleId }}"
            role="switch"
            class="relative flex items-center cursor-pointer {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }} outline-offset-2 transition ease-in-out duration-150 focus:ring-2 focus:ring-offset-2 {{ $trackSizeClasses }} {{ $roundedClass }} {{ $stateClasses['track'] }}"
        >
            <span class="transition ease-in-out duration-200 {{ $thumbSizeClasses }} {{ $roundedClass }} {{ $stateClasses['thumb'] }} {{ $thumbTranslateClasses }}"></span>
        </label>
    </div>
</div>
