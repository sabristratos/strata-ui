@props([
    'handleType' => 'min',
    'componentId' => '',
    'sizeConfig' => [],
    'stateConfig' => [],
    'disabled' => false,
    'showTooltip' => true,
])

@php
$isSingle = $handleType === 'single';
$isMin = $handleType === 'min';
$isMax = $handleType === 'max';

if ($isSingle) {
    $xRef = 'singleHandle';
    $mouseDownHandler = 'handleSingleMouseDown($event)';
    $touchStartHandler = 'handleSingleTouchStart($event)';
    $keydownHandler = 'handleSingleKeydown($event)';
    $ariaLabel = 'Value';
    $ariaValueKey = 'value';
    $percentVar = 'singlePercent';
    $fallbackVar = 'min';
    $hoveringVar = 'isHoveringSingle';
    $draggingVar = 'isDraggingSingle';
    $tooltipFlippedVar = 'tooltipFlippedSingle';
} elseif ($isMin) {
    $xRef = 'minHandle';
    $mouseDownHandler = 'handleMinMouseDown($event)';
    $touchStartHandler = 'handleMinTouchStart($event)';
    $keydownHandler = 'handleMinKeydown($event)';
    $ariaLabel = 'Minimum value';
    $ariaValueKey = 'min';
    $percentVar = 'minPercent';
    $fallbackVar = 'min';
    $hoveringVar = 'isHoveringMin';
    $draggingVar = 'isDraggingMin';
    $tooltipFlippedVar = 'tooltipFlippedMin';
} else {
    $xRef = 'maxHandle';
    $mouseDownHandler = 'handleMaxMouseDown($event)';
    $touchStartHandler = 'handleMaxTouchStart($event)';
    $keydownHandler = 'handleMaxKeydown($event)';
    $ariaLabel = 'Maximum value';
    $ariaValueKey = 'max';
    $percentVar = 'maxPercent';
    $fallbackVar = 'max';
    $hoveringVar = 'isHoveringMax';
    $draggingVar = 'isDraggingMax';
    $tooltipFlippedVar = 'tooltipFlippedMax';
}

$handleClasses = [
    'absolute top-1/2 -translate-y-1/2 -translate-x-1/2 z-10',
    'rounded-full shadow-sm',
    'cursor-grab active:cursor-grabbing',
    'transition-all duration-150',
    'hover:scale-110',
    $sizeConfig['handle'],
    $stateConfig['handle'],
];

if ($disabled) {
    $handleClasses[] = 'opacity-50 cursor-not-allowed';
}
@endphp

<button
    type="button"
    x-ref="{{ $xRef }}"
    @mousedown="{{ $mouseDownHandler }}"
    @touchstart="{{ $touchStartHandler }}"
    @mouseenter="{{ $hoveringVar }} = true"
    @mouseleave="{{ $hoveringVar }} = false"
    @keydown="{{ $keydownHandler }}"
    :style="'left: ' + {{ $percentVar }} + '%'"
    :disabled="disabled"
    :aria-label="'{{ $ariaLabel }}'"
    :class="{ 'scale-125': {{ $draggingVar }} }"
    role="slider"
    aria-orientation="horizontal"
    :aria-valuemin="min"
    :aria-valuemax="max"
    :aria-valuenow="{{ $isSingle ? 'localValue' : "localValue?.{$ariaValueKey}" }} ?? {{ $fallbackVar }}"
    :aria-disabled="disabled"
    tabindex="{{ $disabled ? '-1' : '0' }}"
    class="{{ implode(' ', $handleClasses) }}"
    data-strata-slider-handle
    data-strata-slider-handle-type="{{ $handleType }}"
>
    @if($showTooltip)
    <div
        :class="{{ $tooltipFlippedVar }} ? 'top-full mt-2' : 'bottom-full mb-2'"
        class="absolute left-1/2 -translate-x-1/2 pointer-events-none z-20"
        data-tooltip
    >
        <div class="bg-popover text-popover-foreground
                    border border-border rounded-md shadow-lg
                    px-2 py-1 text-xs font-medium whitespace-nowrap">
            <span x-text="formatValue({{ $isSingle ? 'localValue' : "localValue?.{$ariaValueKey}" }} ?? {{ $fallbackVar }})"></span>

            <div
                :class="{{ $tooltipFlippedVar }} ? 'bottom-full -mb-px' : 'top-full -mt-px'"
                class="absolute left-1/2 -translate-x-1/2"
            >
                <div :class="{{ $tooltipFlippedVar }} ? 'border-b-border' : 'border-t-border'" class="border-4 border-transparent"></div>
                <div
                    :class="{{ $tooltipFlippedVar }} ? 'border-b-popover -mb-[3px]' : 'border-t-popover -mt-[3px]'"
                    class="absolute top-0 left-1/2 -translate-x-1/2 border-4 border-transparent"
                ></div>
            </div>
        </div>
    </div>
    @endif
</button>
