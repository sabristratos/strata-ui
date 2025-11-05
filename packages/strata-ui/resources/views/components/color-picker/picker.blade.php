@props([
    'allowAlpha' => false,
])

<div class="space-y-3" data-strata-colorpicker-picker>
    <div
        class="relative w-full h-40 rounded-lg cursor-crosshair overflow-hidden"
        x-ref="slArea"
        @mousedown="handleSLMouseDown($event)"
        :style="{ backgroundColor: `hsl(${hue}, 100%, 50%)` }"
        data-strata-colorpicker-sl-area
    >
        <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent"></div>

        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>

        <div
            class="absolute w-4 h-4 rounded-full border-2 border-white shadow-lg pointer-events-none transform -translate-x-1/2 -translate-y-1/2"
            :style="{
                left: `${saturation}%`,
                top: `${100 - lightness}%`
            }"
        ></div>
    </div>

    <div class="space-y-2">
        <div
            class="relative w-full h-4 rounded-full cursor-pointer overflow-hidden"
            x-ref="hueSlider"
            @mousedown="handleHueMouseDown($event)"
            style="background: linear-gradient(to right,
                hsl(0, 100%, 50%),
                hsl(60, 100%, 50%),
                hsl(120, 100%, 50%),
                hsl(180, 100%, 50%),
                hsl(240, 100%, 50%),
                hsl(300, 100%, 50%),
                hsl(360, 100%, 50%)
            )"
            data-strata-colorpicker-hue-slider
        >
            <div
                class="absolute top-1/2 w-2 h-6 bg-white rounded-sm border border-border shadow-md pointer-events-none transform -translate-x-1/2 -translate-y-1/2"
                :style="{ left: `${(hue / 360) * 100}%` }"
            ></div>
        </div>

        @if($allowAlpha)
        <div class="relative w-full h-4 rounded-full cursor-pointer overflow-hidden" data-strata-colorpicker-alpha-slider-wrapper>
            <div
                class="absolute inset-0 rounded-full"
                style="background-image: linear-gradient(45deg, #e5e7eb 25%, transparent 25%), linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #e5e7eb 75%), linear-gradient(-45deg, transparent 75%, #e5e7eb 75%); background-size: 8px 8px; background-position: 0 0, 0 4px, 4px -4px, -4px 0px;"
            ></div>

            <div
                class="absolute inset-0 rounded-full"
                x-ref="alphaSlider"
                @mousedown="handleAlphaMouseDown($event)"
                :style="{
                    background: `linear-gradient(to right,
                        hsla(${hue}, ${saturation}%, ${lightness}%, 0),
                        hsl(${hue}, ${saturation}%, ${lightness}%)
                    )`
                }"
            ></div>

            <div
                class="absolute top-1/2 w-2 h-6 bg-white rounded-sm border border-border shadow-md pointer-events-none transform -translate-x-1/2 -translate-y-1/2"
                :style="{ left: `${alpha}%` }"
            ></div>
        </div>
        @endif
    </div>

    <div
        class="w-full h-12 rounded-lg border border-border relative overflow-hidden"
        data-strata-colorpicker-preview-large
    >
        <div
            class="absolute inset-0"
            style="background-image: linear-gradient(45deg, #e5e7eb 25%, transparent 25%), linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #e5e7eb 75%), linear-gradient(-45deg, transparent 75%, #e5e7eb 75%); background-size: 8px 8px; background-position: 0 0, 0 4px, 4px -4px, -4px 0px;"
        ></div>

        <div
            class="absolute inset-0"
            :style="{ backgroundColor: getCurrentColorWithAlpha() }"
        ></div>
    </div>
</div>
