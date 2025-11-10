@props([
    'state' => 'default',
    'size' => 'md',
    'variant' => 'faded',
    'resize' => 'vertical',
    'rows' => 4,
    'disabled' => false,
    'label' => null,
    'hint' => null,
    'hintTrailing' => null,
    'error' => null,
    'required' => false,
    'spacing' => 'default',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Config\ComponentVariantConfig;

$fieldName = null;
$wireModel = $attributes->whereStartsWith('wire:model')->first();
if ($wireModel) {
    $fieldName = is_string($wireModel) ? $wireModel : $attributes->get('wire:model');
}
if (!$fieldName) {
    $fieldName = $attributes->get('name');
}

$hasError = $fieldName && $errors->has($fieldName);
$displayError = $error ?? ($hasError ? $errors->first($fieldName) : null);
$componentId = $attributes->get('id') ?? ($fieldName ? 'field-' . str_replace(['.', '[', ']'], ['-', '-', ''], $fieldName) : 'field-' . uniqid());
$finalState = $hasError ? 'error' : $state;

$baseClasses = 'w-full rounded-lg transition-all duration-150';

$sizeClasses = ComponentSizeConfig::textareaSizes();

$stateClasses = ComponentStateConfig::focusableStates();

$variants = ComponentVariantConfig::inputVariants();

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

$wrapperClasses = $baseClasses . ' ' . ($variants[$variant] ?? $variants['faded']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']) . ' ' . ($stateClasses[$finalState] ?? $stateClasses['default']) . ' ' . $disabledClasses;

$textareaClasses = 'w-full bg-transparent border-0 outline-none text-foreground placeholder:text-muted-foreground disabled:cursor-not-allowed min-h-20 ' . ($resizeClasses[$resize] ?? $resizeClasses['vertical']);

$wrapperAttributes = $attributes->only(['class', 'style']);
$textareaAttributes = $attributes->except(['class', 'style', 'label', 'hint', 'hintTrailing', 'error', 'required', 'spacing']);
@endphp

@if($label || $hint || $hintTrailing || $displayError)
    <x-strata::field :spacing="$spacing">
        @if($label)
            <x-strata::field.label for="{{ $componentId }}" :required="$required">
                {{ $label }}
            </x-strata::field.label>
        @endif

        @if($hint)
            <x-strata::field.hint>{{ $hint }}</x-strata::field.hint>
        @endif

        <div data-strata-textarea-wrapper {{ $wrapperAttributes->merge(['class' => $wrapperClasses . ' relative']) }}>
            <textarea
                id="{{ $componentId }}"
                data-strata-textarea
                data-strata-field-type="textarea"
                rows="{{ $rows }}"
                {{ $textareaAttributes->merge(['class' => $textareaClasses]) }}
                @disabled($disabled)
            ></textarea>

            @if($finalState !== 'default' && isset($stateIcons[$finalState]))
                <x-dynamic-component :component="'strata::icon.' . $stateIcons[$finalState]" class="w-5 h-5 absolute top-2 right-2 pointer-events-none {{ $finalState === 'success' ? 'text-success' : ($finalState === 'error' ? 'text-destructive' : 'text-warning') }}" />
            @endif

            @if($slot->isNotEmpty())
                <div class="flex items-center justify-end gap-2 mt-1.5">
                    {{ $slot }}
                </div>
            @endif
        </div>

        @if($hintTrailing)
            <x-strata::field.hint>{{ $hintTrailing }}</x-strata::field.hint>
        @endif

        @if($displayError)
            <x-strata::field.error>{{ $displayError }}</x-strata::field.error>
        @endif
    </x-strata::field>
@else
    <div data-strata-textarea-wrapper {{ $wrapperAttributes->merge(['class' => $wrapperClasses . ' relative']) }}>
        <textarea
            @if($componentId) id="{{ $componentId }}" @endif
            data-strata-textarea
            data-strata-field-type="textarea"
            rows="{{ $rows }}"
            {{ $textareaAttributes->merge(['class' => $textareaClasses]) }}
            @disabled($disabled)
        ></textarea>

        @if($finalState !== 'default' && isset($stateIcons[$finalState]))
            <x-dynamic-component :component="'strata::icon.' . $stateIcons[$finalState]" class="w-5 h-5 absolute top-2 right-2 pointer-events-none {{ $finalState === 'success' ? 'text-success' : ($finalState === 'error' ? 'text-destructive' : 'text-warning') }}" />
        @endif

        @if($slot->isNotEmpty())
            <div class="flex items-center justify-end gap-2 mt-1.5">
                {{ $slot }}
            </div>
        @endif
    </div>
@endif
