@props([
    'orientation' => 'vertical',
    'label' => null,
    'error' => null,
])

@php
$orientations = [
    'vertical' => 'flex-col',
    'horizontal' => 'flex-row flex-wrap',
];

$orientationClasses = $orientations[$orientation] ?? $orientations['vertical'];
$gapClasses = $orientation === 'vertical' ? 'gap-3' : 'gap-4';
@endphp

<div data-strata-checkbox-group {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label class="block text-sm font-medium text-foreground mb-2">
            {{ $label }}
        </label>
    @endif

    <div class="flex {{ $orientationClasses }} {{ $gapClasses }}">
        {{ $slot }}
    </div>

    @if($error)
        <p class="mt-2 text-sm text-destructive">{{ $error }}</p>
    @endif
</div>
