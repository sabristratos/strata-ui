@props(['name', 'shortcut' => null])

<div 
    @click="$strata.modal('{{ $name }}').show()"
    @if($shortcut)
        @keydown.window="{{ $shortcut }}="$strata.modal('{{ $name }}').show()"
    @endif
    {{ $attributes->except(['name', 'shortcut']) }}
>
    {{ $slot }}
</div>