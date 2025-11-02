@props([
    'state' => 'default',
    'size' => 'md',
    'resize' => 'vertical',
    'rows' => 4,
    'disabled' => false,
])

@php
$baseClasses = 'w-full bg-input border rounded-lg transition-all duration-150';

$sizeClasses = [
    'sm' => 'px-3 py-2 text-sm',
    'md' => 'px-3 py-2.5 text-base',
    'lg' => 'px-4 py-3 text-lg',
];

$stateClasses = [
    'default' => 'border-border focus:ring-2 focus:ring-ring focus:ring-offset-2',
    'success' => 'border-success focus:ring-2 focus:ring-success/20 focus:ring-offset-2',
    'error' => 'border-destructive focus:ring-2 focus:ring-destructive/20 focus:ring-offset-2',
    'warning' => 'border-warning focus:ring-2 focus:ring-warning/20 focus:ring-offset-2',
];

$resizeClasses = [
    'none' => 'resize-none',
    'vertical' => 'resize-y',
    'horizontal' => 'resize-x',
    'both' => 'resize',
];

$stateIcons = [
    'success' => 'check-circle',
    'error' => 'alert-circle',
    'warning' => 'alert-triangle',
];

$disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';

$wrapperClasses = $baseClasses . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']) . ' ' . ($stateClasses[$state] ?? $stateClasses['default']) . ' ' . $disabledClasses;

$textareaClasses = 'w-full bg-transparent border-0 outline-none text-foreground placeholder:text-muted-foreground disabled:cursor-not-allowed min-h-20 ' . ($resizeClasses[$resize] ?? $resizeClasses['vertical']);

$wrapperAttributes = $attributes->only(['class', 'style']);
$textareaAttributes = $attributes->except(['class', 'style']);
@endphp

<div>
    <div data-strata-textarea-wrapper {{ $wrapperAttributes->merge(['class' => $wrapperClasses . ' relative']) }}>
        <textarea
            data-strata-textarea
            data-strata-field-type="textarea"
            rows="{{ $rows }}"
            {{ $textareaAttributes->merge(['class' => $textareaClasses]) }}
            @disabled($disabled)
        ></textarea>

        @if($state !== 'default' && isset($stateIcons[$state]))
            <x-dynamic-component :component="'strata::icon.' . $stateIcons[$state]" class="w-5 h-5 absolute top-2 right-2 pointer-events-none {{ $state === 'success' ? 'text-success' : ($state === 'error' ? 'text-destructive' : 'text-warning') }}" />
        @endif
    </div>

    @if($slot->isNotEmpty())
        <div class="flex items-center justify-end gap-2 mt-1.5">
            {{ $slot }}
        </div>
    @endif
</div>
