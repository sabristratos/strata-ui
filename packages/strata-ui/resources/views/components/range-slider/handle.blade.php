@props([
    'handleType' => 'min',
    'componentId' => '',
    'sizeConfig' => [],
    'stateConfig' => [],
    'disabled' => false,
    'showTooltip' => true,
])

@php
$isMin = $handleType === 'min';
$xRef = $isMin ? 'minHandle' : 'maxHandle';
$mouseDownHandler = $isMin ? 'handleMinMouseDown($event)' : 'handleMaxMouseDown($event)';
$touchStartHandler = $isMin ? 'handleMinTouchStart($event)' : 'handleMaxTouchStart($event)';
$keydownHandler = $isMin ? 'handleMinKeydown($event)' : 'handleMaxKeydown($event)';
$ariaLabel = $isMin ? 'Minimum value' : 'Maximum value';
$ariaValueKey = $isMin ? 'min' : 'max';
$percentVar = $isMin ? 'minPercent' : 'maxPercent';
$fallbackVar = $isMin ? 'min' : 'max';
$hoveringVar = $isMin ? 'isHoveringMin' : 'isHoveringMax';
$draggingVar = $isMin ? 'isDraggingMin' : 'isDraggingMax';

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
    x-bind:style="'left: ' + {{ $percentVar }} + '%'"
    :disabled="disabled"
    :aria-label="'{{ $ariaLabel }}'"
    :class="{
        'scale-125': {{ $draggingVar }},
        'ring-2 ring-ring ring-offset-2': {{ $hoveringVar }} || {{ $draggingVar }}
    }"
    role="slider"
    :aria-valuemin="min"
    :aria-valuemax="max"
    :aria-valuenow="entangleable.value?.{{ $ariaValueKey }} ?? {{ $fallbackVar }}"
    :aria-disabled="disabled"
    tabindex="{{ $disabled ? '-1' : '0' }}"
    class="{{ implode(' ', $handleClasses) }}"
    data-strata-range-slider-handle
    data-strata-range-slider-handle-type="{{ $handleType }}"
>
    @if($showTooltip)
    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 pointer-events-none z-20">
        <div class="bg-popover text-popover-foreground
                    border border-border rounded-md shadow-lg
                    px-2 py-1 text-xs font-medium whitespace-nowrap">
            <span x-text="formatValue(entangleable.value?.{{ $ariaValueKey }} ?? {{ $fallbackVar }})"></span>

            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-px">
                <div class="border-4 border-transparent border-t-border"></div>
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-[3px] border-4 border-transparent border-t-popover"></div>
            </div>
        </div>
    </div>
    @endif
</button>
