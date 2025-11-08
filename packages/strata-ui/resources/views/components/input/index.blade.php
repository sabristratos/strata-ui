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
 * @prop string|null $iconLeft - Left icon name (default: null)
 * @prop string|null $iconRight - Right icon name (default: null)
 * @prop string|null $prefix - Text prefix (e.g., "$", "http://") (default: null)
 * @prop string|null $suffix - Text suffix (e.g., ".com", "kg") (default: null)
 * @prop bool $disabled - Disable input (default: false)
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
 * @example Input with prefix/suffix
 * <x-strata::input
 *     wire:model="price"
 *     type="number"
 *     prefix="$"
 *     suffix="USD" />
 *
 * @example Validation states
 * <x-strata::input
 *     wire:model="username"
 *     state="error"
 *     placeholder="Username" />
 */
--}}

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
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;

$baseClasses = 'flex items-center gap-2 bg-input border rounded-lg transition-all duration-150 inset-shadow-sm';

$sizes = ComponentSizeConfig::inputSizes();

$stateClasses = ComponentStateConfig::inputStates();

$stateIcons = [
    'success' => 'check-circle',
    'error' => 'alert-circle',
    'warning' => 'alert-triangle',
];

$disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';

$wrapperClasses = $baseClasses . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($stateClasses[$state] ?? $stateClasses['default']) . ' ' . $disabledClasses;

$inputClasses = 'flex-1 bg-transparent border-0 outline-none text-foreground placeholder:text-muted-foreground disabled:cursor-not-allowed';

$wrapperAttributes = $attributes->only(['class', 'style']);
$inputAttributes = $attributes->except(['class', 'style']);
@endphp

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
        data-strata-input
        data-strata-field-type="input"
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
