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
    'name' => null,
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$sizes = ComponentSizeConfig::checkboxSizes();
$iconSizes = ComponentSizeConfig::checkboxIconSizes();
$labelSizes = ComponentSizeConfig::labelSizes();
$descriptionSizes = ComponentSizeConfig::descriptionSizes();

$states = ComponentStateConfig::checkableStates();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$iconSizeClasses = $iconSizes[$size] ?? $iconSizes['md'];
$labelSizeClasses = $labelSizes[$size] ?? $labelSizes['md'];
$descriptionSizeClasses = $descriptionSizes[$size] ?? $descriptionSizes['md'];
$stateClasses = $states[$state] ?? $states['default'];

$componentId = ComponentHelpers::generateId('checkbox', $id, $attributes);

$wrapperAttributes = $attributes->only(['class', 'style']);
$checkboxAttributes = $attributes->except(['class', 'style']);

$alpineData = $indeterminate ? "{ indeterminate: true, init() { this.\$el.querySelector('input').indeterminate = true; } }" : '{ indeterminate: false }';
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
                id="{{ $componentId }}"
                @if($name) name="{{ $name }}" @endif
                data-strata-checkbox
                data-strata-field-type="checkbox"
                @if($checked) checked @endif
                @if($disabled) disabled @endif
                {{ $checkboxAttributes->merge([
                    'class' => "sr-only peer"
                ]) }}
            />
            <label for="{{ $componentId }}" class="cursor-pointer">
                <div class="{{ $sizeClasses }} {{ $stateClasses }} rounded-md bg-secondary border-2 flex items-center justify-center transition-all duration-200 group-has-[:checked]:bg-primary group-has-[:checked]:border-primary">
                    <template x-if="!indeterminate">
                        <x-strata::icon.check
                            class="{{ $iconSizeClasses }} text-primary-foreground transition-opacity opacity-0 group-has-[:checked]:opacity-100"
                        />
                    </template>
                    <template x-if="indeterminate">
                        <x-strata::icon.minus
                            class="{{ $iconSizeClasses }} text-primary-foreground"
                        />
                    </template>
                </div>
            </label>
        </div>

        @if($label || $description || $slot->isNotEmpty())
            <div class="flex flex-col gap-0.5">
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
    </div>

@elseif($variant === 'bordered')
    <label
        for="{{ $componentId }}"
        x-data="{{ $alpineData }}"
        data-strata-checkbox-wrapper
        {{ $wrapperAttributes->merge([
            'class' => "group flex items-start gap-3 p-4 border border-border rounded-lg transition-all duration-200 cursor-pointer " .
                ($disabled ? 'opacity-50 cursor-not-allowed bg-muted' : 'hover:border-primary/50 hover:bg-accent/5 has-[:checked]:border-primary has-[:checked]:bg-primary/5')
        ]) }}
    >
        <input
            type="checkbox"
            id="{{ $componentId }}"
            @if($name) name="{{ $name }}" @endif
            data-strata-checkbox
            data-strata-field-type="checkbox"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $checkboxAttributes->merge([
                'class' => "sr-only peer"
            ]) }}
        />
        <div class="{{ $sizeClasses }} {{ $stateClasses }} rounded-md bg-secondary border-2 flex items-center justify-center transition-all duration-200 group-has-[:checked]:bg-primary group-has-[:checked]:border-primary mt-0.5">
            <template x-if="!indeterminate">
                <x-strata::icon.check
                    class="{{ $iconSizeClasses }} text-primary-foreground transition-opacity opacity-0 group-has-[:checked]:opacity-100"
                />
            </template>
            <template x-if="indeterminate">
                <x-strata::icon.minus
                    class="{{ $iconSizeClasses }} text-primary-foreground"
                />
            </template>
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
        for="{{ $componentId }}"
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
            id="{{ $componentId }}"
            @if($name) name="{{ $name }}" @endif
            data-strata-checkbox
            data-strata-field-type="checkbox"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $checkboxAttributes->merge([
                'class' => "sr-only peer"
            ]) }}
        />

        <div class="absolute top-4 right-4" data-strata-checkbox-indicator>
            <div class="{{ $stateClasses }} w-6 h-6 rounded-md border bg-secondary flex items-center justify-center transition-all duration-200 group-has-[:checked]:bg-primary group-has-[:checked]:border-primary">
                <template x-if="!indeterminate">
                    <x-strata::icon.check
                        class="w-4 h-4 text-primary-foreground transition-opacity opacity-0 group-has-[:checked]:opacity-100"
                        data-strata-checkbox-icon
                    />
                </template>
                <template x-if="indeterminate">
                    <x-strata::icon.minus
                        class="w-4 h-4 text-primary-foreground"
                        data-strata-checkbox-icon
                    />
                </template>
            </div>
        </div>

        <div class="pr-10">
            @if($label || $slot->isNotEmpty())
                <div class="flex flex-col gap-2">
                    <div class="{{ $labelSizeClasses }} font-semibold text-foreground">
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
        </div>
    </label>

@elseif($variant === 'pill')
    <label
        for="{{ $componentId }}"
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
            id="{{ $componentId }}"
            @if($name) name="{{ $name }}" @endif
            data-strata-checkbox
            data-strata-field-type="checkbox"
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
