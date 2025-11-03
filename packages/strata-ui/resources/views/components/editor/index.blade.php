@props([
    'size' => 'md',
    'state' => 'default',
    'id' => null,
])

@php
    $sizes = [
        'sm' => 'min-h-32 text-sm',
        'md' => 'min-h-60 text-base',
        'lg' => 'min-h-96 text-lg',
    ];

    $states = [
        'default' => 'border-border focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2',
        'success' => 'border-success focus-within:ring-2 focus-within:ring-success/20 focus-within:ring-offset-2',
        'error' => 'border-destructive focus-within:ring-2 focus-within:ring-destructive/20 focus-within:ring-offset-2',
        'warning' => 'border-warning focus-within:ring-2 focus-within:ring-warning/20 focus-within:ring-offset-2',
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $stateClasses = $states[$state] ?? $states['default'];

    $componentId = $id ?? $attributes->get('id') ?? 'editor-' . uniqid();

    $initialValue = $attributes->wire('model')->value()
        ? $this->{$attributes->wire('model')->value()}
        : null;
@endphp

<div
    wire:ignore
    x-data="strataEditor(@js($initialValue))"
    data-strata-editor
    data-strata-field-type="editor"
    {{ $attributes->merge(['class' => 'rounded-lg border bg-background transition-colors ' . $stateClasses]) }}
>
    <input
        type="hidden"
        data-strata-editor-input
        id="{{ $componentId }}"
        {{ $attributes->only(['wire:model', 'wire:model.live', 'name']) }}
    />

    <x-strata::editor.toolbar />

    <div
        x-ref="editor"
        data-strata-editor-content
        class="{{ $sizeClasses }}"
    ></div>
</div>
