@props([
    'format' => 'hex',
    'allowAlpha' => false,
])

<div class="space-y-2" data-strata-colorpicker-inputs>
    <div class="grid grid-cols-3 gap-2">
        <div class="col-span-3">
            <label class="block text-xs font-medium text-muted-foreground mb-1">
                {{ strtoupper($format) }}
            </label>
            <input
                type="text"
                x-model="display"
                @input.debounce.300ms="selectColor(display)"
                class="w-full h-9 px-3 text-sm bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                :disabled="disabled"
                placeholder="{{ $format === 'hex' ? '#000000' : 'hsl(0, 0%, 0%)' }}"
                data-strata-colorpicker-input-display
            />
        </div>
    </div>

    <div class="grid grid-cols-{{ $allowAlpha ? '4' : '3' }} gap-2">
        @if($format === 'hsl')
        <div>
            <label class="block text-xs font-medium text-muted-foreground mb-1">H</label>
            <input
                type="number"
                x-model.number="hue"
                @input.debounce.300ms="updateColor()"
                min="0"
                max="360"
                class="w-full h-9 px-2 text-sm bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                :disabled="disabled"
                data-strata-colorpicker-input-hue
            />
        </div>

        <div>
            <label class="block text-xs font-medium text-muted-foreground mb-1">S</label>
            <input
                type="number"
                x-model.number="saturation"
                @input.debounce.300ms="updateColor()"
                min="0"
                max="100"
                class="w-full h-9 px-2 text-sm bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                :disabled="disabled"
                data-strata-colorpicker-input-saturation
            />
        </div>

        <div>
            <label class="block text-xs font-medium text-muted-foreground mb-1">L</label>
            <input
                type="number"
                x-model.number="lightness"
                @input.debounce.300ms="updateColor()"
                min="0"
                max="100"
                class="w-full h-9 px-2 text-sm bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                :disabled="disabled"
                data-strata-colorpicker-input-lightness
            />
        </div>
        @endif

        @if($allowAlpha)
        <div>
            <label class="block text-xs font-medium text-muted-foreground mb-1">A</label>
            <input
                type="number"
                x-model.number="alpha"
                @input.debounce.300ms="updateColor()"
                min="0"
                max="100"
                class="w-full h-9 px-2 text-sm bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                :disabled="disabled"
                data-strata-colorpicker-input-alpha
            />
        </div>
        @endif
    </div>
</div>
