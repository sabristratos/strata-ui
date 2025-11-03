@props([
    'orientation' => 'horizontal',
    'decorative' => true,
])

@php
$isHorizontal = $orientation === 'horizontal';
$isVertical = $orientation === 'vertical';
$hasContent = !empty(trim($slot ?? ''));

if ($isHorizontal && !$hasContent) {
    $classes = 'border-t border-border w-full';
    $element = 'hr';
} elseif ($isVertical) {
    $classes = 'border-l border-border h-6 inline-block';
    $element = 'div';
} else {
    $element = 'div';
}

$ariaAttributes = [
    'role' => 'separator',
    'aria-orientation' => $orientation,
];

if ($decorative && !$hasContent) {
    $ariaAttributes['aria-hidden'] = 'true';
}
@endphp

@if($hasContent && $isHorizontal)
    <div
        data-strata-separator
        {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}
        role="separator"
        aria-orientation="horizontal"
    >
        <div class="flex-1 border-t border-border"></div>
        <span class="text-sm text-muted-foreground" data-strata-separator-label>
            {{ $slot }}
        </span>
        <div class="flex-1 border-t border-border"></div>
    </div>
@elseif($element === 'hr')
    <hr
        data-strata-separator
        {{ $attributes->merge(['class' => $classes]) }}
        @foreach($ariaAttributes as $key => $value)
            {{ $key }}="{{ $value }}"
        @endforeach
    />
@else
    <div
        data-strata-separator
        {{ $attributes->merge(['class' => $classes]) }}
        @foreach($ariaAttributes as $key => $value)
            {{ $key }}="{{ $value }}"
        @endforeach
    ></div>
@endif
