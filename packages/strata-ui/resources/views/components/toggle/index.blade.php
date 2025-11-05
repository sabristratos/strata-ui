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
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$toggleSizes = ComponentSizeConfig::toggleSizes();
$trackSizes = $toggleSizes['track'];
$thumbSizes = $toggleSizes['handle'];

$thumbTranslations = [
    'sm' => 'translate-x-1 group-has-[:checked]:translate-x-5',
    'md' => 'translate-x-1 group-has-[:checked]:translate-x-7',
    'lg' => 'translate-x-1 group-has-[:checked]:translate-x-[2.5rem]',
];

$labelSizes = ComponentSizeConfig::labelSizes();
$descriptionSizes = ComponentSizeConfig::descriptionSizes();

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

$states = ComponentStateConfig::toggleStates();

$trackSizeClasses = $trackSizes[$size] ?? $trackSizes['md'];
$thumbSizeClasses = $thumbSizes[$size] ?? $thumbSizes['md'];
$thumbTranslateClasses = $thumbTranslations[$size] ?? $thumbTranslations['md'];
$labelSizeClasses = $labelSizes[$size] ?? $labelSizes['md'];
$descriptionSizeClasses = $descriptionSizes[$size] ?? $descriptionSizes['md'];
$roundedClass = $roundedClasses[$rounded] ?? $roundedClasses['full'];
$stateClasses = $states[$state] ?? $states['default'];

$componentId = ComponentHelpers::generateId('toggle', $id, $attributes);

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
                for="{{ $componentId }}"
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
            id="{{ $componentId }}"
            data-strata-toggle
            data-strata-field-type="toggle"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $toggleAttributes->merge(['class' => 'sr-only peer']) }}
        />

        <label
            for="{{ $componentId }}"
            role="switch"
            class="relative flex items-center cursor-pointer {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }} outline-offset-2 transition ease-in-out duration-150 focus:ring-2 focus:ring-offset-2 {{ $trackSizeClasses }} {{ $roundedClass }} {{ $stateClasses['track'] }}"
        >
            <span class="transition ease-in-out duration-200 {{ $thumbSizeClasses }} {{ $roundedClass }} {{ $stateClasses['thumb'] }} {{ $thumbTranslateClasses }}"></span>
        </label>
    </div>
</div>
