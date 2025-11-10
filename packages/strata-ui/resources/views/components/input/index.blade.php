{{--
/**
 * Input Component
 *
 * Text input with support for icons, prefixes, suffixes, and validation states.
 * Works with wire:model for Livewire integration.
 *
 * @props
 * @prop string $type - HTML input type: 'text'|'email'|'password'|'number'|etc. (default: 'text')
 * @prop string $state - Validation state: 'default'|'success'|'error'|'warning' (default: 'default')
 * @prop string $size - Input size: 'sm'|'md'|'lg' (default: 'md')
 * @prop string $variant - Visual variant: 'faded'|'flat'|'bordered'|'underlined' (default: 'faded')
 * @prop string|null $iconLeft - Left icon name (default: null)
 * @prop string|null $iconRight - Right icon name (default: null)
 * @prop string|null $prefix - Text prefix (e.g., "$", "http://") (default: null)
 * @prop string|null $suffix - Text suffix (e.g., ".com", "kg") (default: null)
 * @prop bool $disabled - Disable input (default: false)
 * @prop string|null $label - Field label text (shorthand) (default: null)
 * @prop string|null $hint - Help text above input (shorthand) (default: null)
 * @prop string|null $hintTrailing - Help text below input (shorthand) (default: null)
 * @prop string|null $error - Manual error message (shorthand, auto-detected if not provided) (default: null)
 * @prop bool $required - Show required indicator on label (shorthand) (default: false)
 * @prop string $spacing - Field spacing when using shorthand: 'tight'|'default'|'loose' (default: 'default')
 *
 * @example Basic input
 * <x-strata::input wire:model="name" placeholder="Enter your name" />
 *
 * @example Input with icon
 * <x-strata::input
 *     wire:model="email"
 *     type="email"
 *     iconLeft="mail"
 *     placeholder="email@example.com" />
 *
 * @example Shorthand with label and validation
 * <x-strata::input
 *     label="Email Address"
 *     hint="We'll never share your email"
 *     wire:model="email"
 *     type="email"
 *     required />
 */
--}}

@props([
    'type' => 'text',
    'state' => 'default',
    'size' => 'md',
    'variant' => 'faded',
    'iconLeft' => null,
    'iconRight' => null,
    'prefix' => null,
    'suffix' => null,
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

$baseClasses = 'flex items-center gap-2 rounded-lg transition-all duration-150';

$sizes = ComponentSizeConfig::inputSizes();

$stateClasses = ComponentStateConfig::inputStates();

$variants = ComponentVariantConfig::inputVariants();

$stateIcons = [
    'success' => 'check-circle',
    'error' => 'alert-circle',
    'warning' => 'alert-triangle',
];

$disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';

$wrapperClasses = $baseClasses . ' ' . ($variants[$variant] ?? $variants['faded']) . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($stateClasses[$finalState] ?? $stateClasses['default']) . ' ' . $disabledClasses;

$inputClasses = 'flex-1 bg-transparent border-0 outline-none text-foreground placeholder:text-muted-foreground disabled:cursor-not-allowed';

$wrapperAttributes = $attributes->only(['class', 'style']);
$inputAttributes = $attributes->except(['class', 'style', 'label', 'hint', 'hintTrailing', 'error', 'required', 'spacing']);
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

        <div data-strata-input-wrapper {{ $wrapperAttributes->merge(['class' => $wrapperClasses]) }}>
            @if($iconLeft)
                <x-dynamic-component :component="'strata::icon.' . $iconLeft" class="w-5 h-5 text-muted-foreground flex-shrink-0" />
            @endif

            @if(isset($prefixSlot))
                <div class="flex items-center flex-shrink-0">
                    {{ $prefixSlot }}
                </div>
            @endif

            @if($prefix)
                <span class="text-muted-foreground flex-shrink-0">{{ $prefix }}</span>
            @endif

            <input
                id="{{ $componentId }}"
                data-strata-input
                data-strata-field-type="input"
                type="{{ $type }}"
                {{ $inputAttributes->merge(['class' => $inputClasses]) }}
                @disabled($disabled)
            />

            @if($finalState !== 'default' && isset($stateIcons[$finalState]))
                <x-dynamic-component :component="'strata::icon.' . $stateIcons[$finalState]" class="w-5 h-5 flex-shrink-0 {{ $finalState === 'success' ? 'text-success' : ($finalState === 'error' ? 'text-destructive' : 'text-warning') }}" />
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

        @if($hintTrailing)
            <x-strata::field.hint>{{ $hintTrailing }}</x-strata::field.hint>
        @endif

        @if($displayError)
            <x-strata::field.error>{{ $displayError }}</x-strata::field.error>
        @endif
    </x-strata::field>
@else
    <div data-strata-input-wrapper {{ $wrapperAttributes->merge(['class' => $wrapperClasses]) }}>
        @if($iconLeft)
            <x-dynamic-component :component="'strata::icon.' . $iconLeft" class="w-5 h-5 text-muted-foreground flex-shrink-0" />
        @endif

        @if(isset($prefixSlot))
            <div class="flex items-center flex-shrink-0">
                {{ $prefixSlot }}
            </div>
        @endif

        @if($prefix)
            <span class="text-muted-foreground flex-shrink-0">{{ $prefix }}</span>
        @endif

        <input
            @if($componentId) id="{{ $componentId }}" @endif
            data-strata-input
            data-strata-field-type="input"
            type="{{ $type }}"
            {{ $inputAttributes->merge(['class' => $inputClasses]) }}
            @disabled($disabled)
        />

        @if($finalState !== 'default' && isset($stateIcons[$finalState]))
            <x-dynamic-component :component="'strata::icon.' . $stateIcons[$finalState]" class="w-5 h-5 flex-shrink-0 {{ $finalState === 'success' ? 'text-success' : ($finalState === 'error' ? 'text-destructive' : 'text-warning') }}" />
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
@endif
