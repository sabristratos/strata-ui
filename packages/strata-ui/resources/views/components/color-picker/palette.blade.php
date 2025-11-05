@props([
    'presets' => [],
])

@if(!empty($presets))
<div class="space-y-2" data-strata-colorpicker-palette>
    <div class="text-xs font-medium text-muted-foreground">Presets</div>

    <div class="grid grid-cols-8 gap-2">
        @foreach($presets as $color => $label)
        <button
            type="button"
            @click="selectColor('{{ $color }}')"
            class="w-8 h-8 rounded-md border-2 transition-all hover:scale-110 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 relative overflow-hidden"
            :class="{
                'border-primary ring-2 ring-primary ring-offset-2': entangleable && entangleable.value === '{{ $color }}',
                'border-border': !entangleable || entangleable.value !== '{{ $color }}'
            }"
            aria-label="{{ $label }}"
            title="{{ $label }}"
            data-strata-colorpicker-swatch
        >
            <div
                class="absolute inset-0"
                style="background-image: linear-gradient(45deg, #e5e7eb 25%, transparent 25%), linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #e5e7eb 75%), linear-gradient(-45deg, transparent 75%, #e5e7eb 75%); background-size: 4px 4px; background-position: 0 0, 0 2px, 2px -2px, -2px 0px;"
            ></div>

            <div
                class="absolute inset-0"
                style="background-color: {{ $color }}"
            ></div>
        </button>
        @endforeach
    </div>
</div>
@endif
