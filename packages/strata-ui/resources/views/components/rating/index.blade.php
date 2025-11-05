@props([
    'variant' => 'default',
    'value' => 0,
    'max' => 5,
    'precision' => 0.5,
    'size' => 'md',
    'state' => 'default',
    'disabled' => false,
    'readonly' => false,
    'showRating' => false,
    'showCount' => false,
    'count' => null,
    'label' => null,
    'id' => null,
    'icon' => 'star',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;
use Stratos\StrataUI\Config\ComponentStateConfig;
use Stratos\StrataUI\Support\ComponentHelpers;

$sizes = ComponentSizeConfig::checkboxSizes();
$textSizes = ComponentSizeConfig::labelSizes();

$states = ComponentStateConfig::ratingStates();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$textSizeClasses = $textSizes[$size] ?? $textSizes['md'];
$stateClass = $states[$state] ?? $states['default'];

$componentId = ComponentHelpers::generateId('rating', $id, $attributes);

$isReadonly = $readonly || $variant === 'default';
$isInteractive = !$isReadonly && !$disabled && in_array($variant, ['input', 'clearable']);

$wrapperAttributes = $attributes->only(['class', 'style']);
$inputAttributes = $attributes->except(['class', 'style']);

$fullStars = floor($value);
$remainder = $value - $fullStars;
$hasHalfStar = $remainder >= 0.5 && $precision == 0.5;
$emptyStars = $max - $fullStars - ($hasHalfStar ? 1 : 0);

$alpineConfig = [
    'value' => (float) $value,
    'max' => (int) $max,
    'readonly' => $isReadonly,
    'disabled' => $disabled,
    'icon' => $icon,
    'sizeClasses' => $sizeClasses,
    'stateClass' => $stateClass,
];

$alpineData = $isInteractive ? "rating(" . json_encode($alpineConfig) . ")" : '{}';
@endphp

<div
    x-data="{{ $alpineData }}"
    @if($isInteractive)
        x-init="setupLivewire($el)"
    @endif
    data-strata-rating-wrapper
    {{ $wrapperAttributes->merge(['class' => 'inline-flex items-center gap-2 flex-wrap']) }}
>
    @if($label)
        <span class="{{ $textSizeClasses }} text-foreground font-medium">{{ $label }}</span>
    @endif

    <div
        data-strata-rating
        role="{{ $isInteractive ? 'radiogroup' : 'img' }}"
        @if(!$isInteractive)
            aria-label="Rating: {{ $value }} out of {{ $max }} stars"
        @else
            aria-label="{{ $label ?? 'Star rating' }}"
        @endif
        class="inline-flex items-center gap-0.5 {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        @if($isInteractive)
            @keydown.right.prevent="selectNext()"
            @keydown.left.prevent="selectPrevious()"
            @keydown.escape="reset()"
            tabindex="0"
        @endif
    >
        @if($isInteractive)
            @for($i = 1; $i <= $max; $i++)
                <button
                    type="button"
                    data-strata-star
                    x-data="{starIndex: {{ $i }}}"
                    role="radio"
                    :aria-checked="starIndex <= value"
                    :aria-label="`${starIndex} star${starIndex !== 1 ? 's' : ''}`"
                    @click="selectRating($event, starIndex)"
                    @mouseenter="hoverRating(starIndex)"
                    @mouseleave="hoveredValue = null"
                    class="transition-all duration-150 hover:scale-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-1 rounded"
                    :disabled="disabled"
                >
                    <span class="relative inline-block">
                        <x-dynamic-component
                            :component="'strata::icon.' . $icon"
                            class="{{ $sizeClasses }} text-gray-300"
                            fill="none"
                        />
                        <span
                            class="absolute inset-0 transition-opacity duration-150"
                            x-show="starIndex <= (hoveredValue ?? value)"
                        >
                            <x-dynamic-component
                                :component="'strata::icon.' . $icon"
                                class="{{ $sizeClasses }} {{ $stateClass }}"
                                fill="currentColor"
                            />
                        </span>
                    </span>
                </button>
            @endfor

            <input
                type="hidden"
                id="{{ $componentId }}"
                data-strata-rating-input
                data-strata-field-type="rating"
                x-model="value"
                {{ $inputAttributes }}
            />
        @else
            @for($i = 1; $i <= $fullStars; $i++)
                <span
                    data-strata-star
                    data-star-index="{{ $i }}"
                    class="{{ $sizeClasses }} {{ $stateClass }}"
                >
                    <x-dynamic-component :component="'strata::icon.' . $icon" class="{{ $sizeClasses }}" fill="currentColor" />
                </span>
            @endfor

            @if($hasHalfStar)
                <span
                    data-strata-star
                    data-star-index="{{ $fullStars + 1 }}"
                    class="{{ $sizeClasses }} {{ $stateClass }} relative inline-block"
                >
                    <x-dynamic-component :component="'strata::icon.' . $icon" class="{{ $sizeClasses }}" fill="none" />
                    <span class="absolute inset-0 overflow-hidden" style="width: 50%;">
                        <x-dynamic-component :component="'strata::icon.' . $icon" class="{{ $sizeClasses }}" fill="currentColor" />
                    </span>
                </span>
            @endif

            @for($i = 1; $i <= $emptyStars; $i++)
                <span
                    data-strata-star
                    data-star-index="{{ $fullStars + ($hasHalfStar ? 1 : 0) + $i }}"
                    class="{{ $sizeClasses }} text-gray-300"
                >
                    <x-dynamic-component :component="'strata::icon.' . $icon" class="{{ $sizeClasses }}" fill="none" />
                </span>
            @endfor
        @endif
    </div>

    @if($showRating || $showCount)
        <div class="inline-flex items-baseline gap-1 {{ $textSizeClasses }} text-muted-foreground">
            @if($showRating)
                @if($isInteractive)
                    <span class="font-semibold text-foreground" x-text="(value || 0).toFixed(0)"></span>
                @else
                    <span class="font-semibold text-foreground">{{ number_format($value, $precision == 0.5 ? 1 : 0) }}</span>
                @endif
            @endif
            @if($showCount && $count !== null)
                <span class="text-xs">
                    ({{ number_format($count) }} {{ str($count == 1 ? 'review' : 'reviews')->value }})
                </span>
            @endif
        </div>
    @endif

    @if($variant === 'clearable' && $isInteractive)
        <x-strata::button.icon
            icon="x"
            size="sm"
            variant="secondary"
            appearance="ghost"
            @click="clearRating()"
            :disabled="disabled || value === 0"
            aria-label="Clear rating"
            class="!p-0.5"
        />
    @endif
</div>

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('rating', (config) => ({
        ...window.createEntangleableMixin({
            initialValue: parseFloat(config.value || 0),
            inputSelector: '[data-strata-rating-input]',
            afterWatch: function(newValue) {
                const input = this.$el.querySelector('[data-strata-rating-input]');
                if (input) {
                    input.value = newValue;
                }
            }
        }),

        hoveredValue: null,
        max: config.max,
        readonly: config.readonly,
        disabled: config.disabled,
        icon: config.icon,
        sizeClasses: config.sizeClasses,
        stateClass: config.stateClass,

        get value() {
            return this.entangleable?.get() ?? 0;
        },

        set value(newValue) {
            this.entangleable?.set(parseFloat(newValue || 0));
        },

        setupLivewire(el) {
            this.initEntangleable();
        },

        selectRating(event, starIndex) {
            if (this.disabled || this.readonly) return;
            this.value = starIndex;
        },

        hoverRating(starIndex) {
            if (this.disabled || this.readonly) return;
            this.hoveredValue = starIndex;
        },

        selectNext() {
            if (this.disabled || this.readonly) return;
            this.value = Math.min(this.value + 1, this.max);
        },

        selectPrevious() {
            if (this.disabled || this.readonly) return;
            this.value = Math.max(this.value - 1, 0);
        },

        clearRating() {
            if (this.disabled || this.readonly) return;
            this.value = 0;
            this.hoveredValue = null;
        },

        reset() {
            this.hoveredValue = null;
        }
    }));
});
</script>
@endonce
