@props([
    'type' => 'text',
    'state' => 'default',
    'size' => 'md',
    'iconLeft' => null,
    'iconRight' => null,
    'prefix' => null,
    'suffix' => null,
    'disabled' => false,
])

@php
$baseClasses = 'flex items-center gap-2 bg-input border-2 border-input-border rounded-lg transition-all duration-150';

$sizes = [
    'sm' => ['wrapper' => 'px-3 text-sm', 'input' => 'py-1.5'],
    'md' => ['wrapper' => 'px-4 text-base', 'input' => 'py-2'],
    'lg' => ['wrapper' => 'px-5 text-lg', 'input' => 'py-2.5'],
];

$stateClasses = [
    'default' => 'focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2 focus-within:border-input-border',
    'success' => 'border-success focus-within:ring-2 focus-within:ring-success/20 focus-within:ring-offset-2',
    'error' => 'border-destructive focus-within:ring-2 focus-within:ring-destructive/20 focus-within:ring-offset-2',
    'warning' => 'border-warning focus-within:ring-2 focus-within:ring-warning/20 focus-within:ring-offset-2',
];

$stateIcons = [
    'success' => 'check-circle',
    'error' => 'alert-circle',
    'warning' => 'alert-triangle',
];

$disabledClasses = $disabled ? 'opacity-60 cursor-not-allowed' : '';

$wrapperClasses = $baseClasses . ' ' . ($sizes[$size]['wrapper'] ?? $sizes['md']['wrapper']) . ' ' . ($stateClasses[$state] ?? $stateClasses['default']) . ' ' . $disabledClasses;

$inputClasses = 'flex-1 bg-transparent border-0 outline-none text-foreground placeholder:text-muted-foreground disabled:cursor-not-allowed ' . ($sizes[$size]['input'] ?? $sizes['md']['input']);

$wrapperAttributes = $attributes->only(['class', 'style']);
$inputAttributes = $attributes->except(['class', 'style']);
@endphp

<div data-strata-input-wrapper {{ $wrapperAttributes->merge(['class' => $wrapperClasses]) }}>
    @if($iconLeft)
        <x-dynamic-component :component="'strata::icon.' . $iconLeft" class="w-5 h-5 text-muted-foreground flex-shrink-0" />
    @endif

    @if($prefix)
        <span class="text-muted-foreground flex-shrink-0">{{ $prefix }}</span>
    @endif

    <input
        data-strata-input
        type="{{ $type }}"
        {{ $inputAttributes->merge(['class' => $inputClasses]) }}
        @disabled($disabled)
    />

    @if($state !== 'default' && isset($stateIcons[$state]))
        <x-dynamic-component :component="'strata::icon.' . $stateIcons[$state]" class="w-5 h-5 flex-shrink-0 {{ $state === 'success' ? 'text-success' : ($state === 'error' ? 'text-destructive' : 'text-warning') }}" />
    @endif

    @if($suffix)
        <span class="text-muted-foreground flex-shrink-0">{{ $suffix }}</span>
    @endif

    @if($iconRight)
        <x-dynamic-component :component="'strata::icon.' . $iconRight" class="w-5 h-5 text-muted-foreground flex-shrink-0" />
    @endif

    @if($slot->isNotEmpty())
        <div class="flex items-center gap-1 flex-shrink-0">
            {{ $slot }}
        </div>
    @endif
</div>
