@props([
    'variant' => 'default',
    'size' => 'md',
    'state' => 'default',
    'disabled' => false,
    'checked' => false,
    'indeterminate' => false,
    'label' => null,
    'description' => null,
    'id' => null,
])

@php
$sizes = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
];

$iconSizes = [
    'sm' => 'w-3 h-3',
    'md' => 'w-3.5 h-3.5',
    'lg' => 'w-4 h-4',
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

$states = [
    'default' => 'border-input-border hover:border-input-hover focus:ring-ring accent-primary',
    'success' => 'border-success hover:border-success/80 focus:ring-success accent-success',
    'error' => 'border-destructive hover:border-destructive/80 focus:ring-destructive accent-destructive',
    'warning' => 'border-warning hover:border-warning/80 focus:ring-warning accent-warning',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSizeClasses = $iconSizes[$size] ?? $iconSizes['md'];
$labelSizeClasses = $labelSizes[$size] ?? $labelSizes['md'];
$descriptionSizeClasses = $descriptionSizes[$size] ?? $descriptionSizes['md'];
$stateClasses = $states[$state] ?? $states['default'];

$checkboxId = $id ?? $attributes->get('id') ?? 'checkbox-' . uniqid();

$wrapperAttributes = $attributes->only(['class', 'style']);
$checkboxAttributes = $attributes->except(['class', 'style']);

$alpineData = $indeterminate ? "{ indeterminate: true, init() { this.\$el.querySelector('input').indeterminate = this.indeterminate; } }" : '{}';
@endphp

@if($variant === 'default')
    <div
        x-data="{{ $alpineData }}"
        data-strata-checkbox-wrapper
        {{ $wrapperAttributes->merge(['class' => 'group inline-flex items-center gap-3']) }}
    >
        <div class="relative flex items-center">
            <input
                type="checkbox"
                id="{{ $checkboxId }}"
                data-strata-checkbox
                @if($checked) checked @endif
                @if($disabled) disabled @endif
                {{ $checkboxAttributes->merge([
                    'class' => "sr-only peer"
                ]) }}
            />
            <label for="{{ $checkboxId }}" class="cursor-pointer">
                <div class="{{ $sizeClasses }} rounded-md bg-background border-2 border-input-border flex items-center justify-center transition-all duration-200 group-has-[:checked]:bg-primary group-has-[:checked]:border-primary">
                    <x-strata::icon.check
                        class="{{ $iconSizeClasses }} text-primary-foreground transition-opacity opacity-0 group-has-[:checked]:opacity-100"
                    />
                </div>
            </label>
        </div>

        @if($label || $description || $slot->isNotEmpty())
            <div class="flex flex-col gap-0.5">
                <label
                    for="{{ $checkboxId }}"
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
    </div>

@elseif($variant === 'bordered')
    <label
        for="{{ $checkboxId }}"
        x-data="{{ $alpineData }}"
        data-strata-checkbox-wrapper
        {{ $wrapperAttributes->merge([
            'class' => "group flex items-start gap-3 p-4 border border-border rounded-lg transition-all duration-200 cursor-pointer " .
                ($disabled ? 'opacity-50 cursor-not-allowed bg-muted' : 'hover:border-primary/50 hover:bg-accent/5 has-[:checked]:border-primary has-[:checked]:bg-primary/5')
        ]) }}
    >
        <input
            type="checkbox"
            id="{{ $checkboxId }}"
            data-strata-checkbox
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $checkboxAttributes->merge([
                'class' => "sr-only peer"
            ]) }}
        />
        <div class="{{ $sizeClasses }} rounded-md bg-background border-2 border-input-border flex items-center justify-center transition-all duration-200 group-has-[:checked]:bg-primary group-has-[:checked]:border-primary mt-0.5">
            <x-strata::icon.check
                class="{{ $iconSizeClasses }} text-primary-foreground transition-opacity opacity-0 group-has-[:checked]:opacity-100"
            />
        </div>

        @if($label || $description || $slot->isNotEmpty())
            <div class="flex-1 flex flex-col gap-1">
                <div class="{{ $labelSizeClasses }} font-medium text-foreground">
                    @if($label)
                        {{ $label }}
                    @else
                        {{ $slot }}
                    @endif
                </div>

                @if($description)
                    <div class="{{ $descriptionSizeClasses }} text-muted-foreground">
                        {{ $description }}
                    </div>
                @endif
            </div>
        @endif
    </label>

@elseif($variant === 'card')
    <label
        for="{{ $checkboxId }}"
        x-data="{{ $alpineData }}"
        data-strata-checkbox-wrapper
        data-strata-checkbox-card
        {{ $wrapperAttributes->merge([
            'class' => "group relative flex flex-col p-6 border border-border rounded-lg transition-all duration-200 cursor-pointer " .
                ($disabled ? 'opacity-50 cursor-not-allowed bg-muted' : 'hover:border-primary/50 hover:shadow-md has-[:checked]:border-primary has-[:checked]:bg-primary/5 has-[:checked]:shadow-lg')
        ]) }}
    >
        <input
            type="checkbox"
            id="{{ $checkboxId }}"
            data-strata-checkbox
            data-strata-checkbox-input
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $checkboxAttributes->merge([
                'class' => "sr-only peer"
            ]) }}
        />

        <div class="absolute top-4 right-4" data-strata-checkbox-indicator>
            <div class="w-6 h-6 rounded-md border bg-background border-input-border flex items-center justify-center transition-all duration-200 group-has-[:checked]:bg-primary group-has-[:checked]:border-primary">
                <x-strata::icon.check
                    class="w-4 h-4 text-primary-foreground transition-opacity opacity-0 group-has-[:checked]:opacity-100"
                    data-strata-checkbox-icon
                />
            </div>
        </div>

        <div class="pr-10">
            @if($label || $description || $slot->isNotEmpty())
                <div class="flex flex-col gap-2">
                    @if($label)
                        <div class="{{ $labelSizeClasses }} font-semibold text-foreground">
                            {{ $label }}
                        </div>
                    @endif

                    @if($description)
                        <div class="{{ $descriptionSizeClasses }} text-muted-foreground">
                            {{ $description }}
                        </div>
                    @endif

                    @if($slot->isNotEmpty() && !$label)
                        {{ $slot }}
                    @endif
                </div>
            @endif
        </div>
    </label>

@elseif($variant === 'pill')
    <label
        for="{{ $checkboxId }}"
        x-data="{{ $alpineData }}"
        data-strata-checkbox-wrapper
        {{ $wrapperAttributes->merge([
            'class' => "inline-flex items-center justify-center rounded-full border border-border transition-all duration-200 cursor-pointer select-none " .
                ($size === 'sm' ? 'px-3 py-1 text-xs' : ($size === 'lg' ? 'px-6 py-2 text-base' : 'px-4 py-1.5 text-sm')) . ' ' .
                ($disabled ? 'opacity-50 cursor-not-allowed bg-muted' : 'hover:border-primary/50 hover:shadow-sm has-[:checked]:bg-primary has-[:checked]:border-primary has-[:checked]:text-primary-foreground has-[:checked]:shadow-md active:scale-95')
        ]) }}
    >
        <input
            type="checkbox"
            id="{{ $checkboxId }}"
            data-strata-checkbox
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $checkboxAttributes->merge([
                'class' => "sr-only peer"
            ]) }}
        />

        <span class="font-medium">
            @if($label)
                {{ $label }}
            @else
                {{ $slot }}
            @endif
        </span>
    </label>
@endif
