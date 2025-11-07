@props([
    'value' => null,
    'label' => null,
    'description' => null,
    'disabled' => false,
])

@php
if ($value === null) {
    throw new \InvalidArgumentException('Select option requires a "value" prop');
}

$baseClasses = 'relative flex items-center gap-3 px-4 py-2.5 cursor-pointer transition-colors duration-150 select-none rounded-md';
$hoverClasses = 'hover:bg-muted';
$selectedClasses = 'bg-primary/10 text-primary font-medium';
$disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : '';

$classes = trim("$baseClasses $hoverClasses $disabledClasses");

$optionAttributes = $attributes->except(['class']);
@endphp

<div
    id="option-{{ $value }}"
    data-strata-select-option
    data-value="{{ $value }}"
    @if($disabled) data-disabled @endif
    @click.stop.prevent="!isDisabled() && select('{{ $value }}')"
    {{ $optionAttributes->merge(['class' => $classes]) }}
    :class="{
        '{{ $selectedClasses }}': isSelected('{{ $value }}'),
        'ring-2 ring-inset ring-primary/50': filteredOptions[highlighted]?.value === '{{ $value }}'
    }"
    x-show="filteredOptions.some(opt => opt.value === '{{ $value }}')"
    role="option"
    :aria-selected="isSelected('{{ $value }}')"
>
    <template x-if="multiple">
        <div class="flex items-center justify-center w-4 h-4 border-2 rounded transition-colors duration-150"
             :class="{
                 'border-primary bg-primary': isSelected('{{ $value }}'),
                 'border-border': !isSelected('{{ $value }}')
             }">
            <x-strata::icon.check
                class="w-3 h-3 text-white"
                x-show="isSelected('{{ $value }}')"
            />
        </div>
    </template>

    @isset($icon)
        <div class="flex-shrink-0">
            {{ $icon }}
        </div>
    @endisset

    <div class="flex-1 min-w-0">
        @isset($label)
            <div class="font-medium">
                {{ $label }}
            </div>
        @endisset

        @isset($description)
            <div class="text-sm text-muted-foreground mt-0.5">
                {{ $description }}
            </div>
        @endisset

        @if(!isset($label) && !isset($description))
            {{ $slot }}
        @endif
    </div>

    <template x-if="!multiple && isSelected('{{ $value }}')">
        <x-strata::icon.check class="w-5 h-5 text-primary flex-shrink-0" />
    </template>
</div>
