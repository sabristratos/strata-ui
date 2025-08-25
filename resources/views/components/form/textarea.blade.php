@php
    $baseClasses = 'input-base min-h-20';
    
    if ($autoResize) {
        $baseClasses .= ' resize-none overflow-hidden';
    } else {
        $baseClasses .= ' resize-y';
    }
@endphp

<textarea
    @if($autoResize)
        x-data="{
            value: @if($attributes->wire('model')) @entangle($attributes->wire('model')) @else '{{ $value }}' @endif,
            
            resize() {
                $el.style.height = 'auto';
                $el.style.height = $el.scrollHeight + 'px';
            },
            
            init() {
                this.$nextTick(() => this.resize());
            }
        }"
        x-model="value"
        x-on:input="resize"
        x-init="resize()"
    @else
        @if($attributes->wire('model'))
            x-data="{ value: @entangle($attributes->wire('model')) }"
            x-model="value"
        @else
            @if($value) value="{{ $value }}" @endif
        @endif
    @endif
    @if($name) name="{{ $name }}" @endif
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
    rows="{{ $rows }}"
    {{ $attributes->except(['wire:model']) }}
    class="{{ $baseClasses }}"
>@if(!$attributes->wire('model') && $value){{ $value }}@endif</textarea>