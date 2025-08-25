@php
    $hasWireModel = $attributes->wire('model');
@endphp

<div 
    x-data="strataRating({
        hasWireModel: @js($hasWireModel),
        value: @js($value),
        readonly: @js($readonly),
        max: @js($max),
        name: @js($name)
    })"
    x-modelable="value"
    @if($hasWireModel) {{ $attributes->wire('model') }} @endif
    class="flex flex-col space-y-2"
>
    @if($name && !$hasWireModel)
        <input 
            x-ref="hiddenInput"
            type="hidden" 
            name="{{ $name }}" 
            value="{{ $value ?? '' }}"
        >
    @endif

    @if($label || $description)
        <div class="space-y-1">
            @if($label)
                <label 
                    id="{{ $id }}-label"
                    class="text-sm font-medium text-foreground"
                >
                    {{ $label }}
                </label>
            @endif
            @if($description)
                <p 
                    id="{{ $id }}-description"
                    class="text-xs text-muted-foreground"
                >
                    {{ $description }}
                </p>
            @endif
        </div>
    @endif

    <div class="flex items-center {{ $getGapClasses() }}">
        @for($i = 1; $i <= $max; $i++)
            <button
                type="button"
                @if(!$readonly)
                    @click="setRating({{ $i }})"
                    @mouseenter="onMouseEnter({{ $i }})"
                    @mouseleave="onMouseLeave()"
                @endif
                :class="{
                    'text-rating-star': isActive({{ $i }}),
                    'text-muted-foreground': !isActive({{ $i }}),
                    'hover:text-rating-star': !readonly && !isActive({{ $i }}),
                    'cursor-pointer': !readonly,
                    'cursor-default': readonly
                }"
                class="transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 rounded-sm"
                {{ $attributes->except(['wire:model']) }}
                @if($label) aria-labelledby="{{ $id }}-label" @endif
                @if($description) aria-describedby="{{ $id }}-description" @endif
                aria-label="Rate {{ $i }} out of {{ $max }}"
            >
                <x-icon 
                    :name="str_replace('-o-', '-s-', $icon)" 
                    :class="$getSizeClasses()" 
                    x-show="isActive({{ $i }})"
                />
                <x-icon 
                    :name="$icon" 
                    :class="$getSizeClasses() . ' opacity-40'" 
                    x-show="!isActive({{ $i }})"
                />
            </button>
        @endfor

        @if($clearable && !$readonly)
            <button
                type="button"
                @click="clearRating()"
                x-show="value !== null"
                class="ml-2 text-muted-foreground hover:text-foreground transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 rounded-sm"
                aria-label="Clear rating"
                title="Clear rating"
            >
                <x-icon 
                    name="heroicon-o-x-mark" 
                    :class="$getClearButtonSizeClasses()" 
                />
            </button>
        @endif
    </div>

    @if($value !== null)
        <div class="text-xs text-muted-foreground">
            <span x-text="value"></span> out of {{ $max }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('strataRating', (config) => ({
            value: config.hasWireModel ? null : config.value,
            hoverValue: null,
            readonly: config.readonly,
            max: config.max,
            name: config.name,
            
            init() {
                // Handle Livewire entanglement
                if (config.hasWireModel) {
                    this.value = config.value;
                }
                
                // Initialize hidden input value
                if (this.$refs.hiddenInput) {
                    this.$refs.hiddenInput.value = this.value || '';
                }
            },
            
            get displayValue() {
                return this.hoverValue !== null ? this.hoverValue : this.value;
            },
            
            setRating(rating) {
                if (this.readonly) return;
                
                this.value = rating;
                
                // Update hidden input
                if (this.$refs.hiddenInput) {
                    this.$refs.hiddenInput.value = rating;
                }
                
                // Dispatch change event
                this.$dispatch('change', { value: rating });
            },
            
            clearRating() {
                if (this.readonly) return;
                
                this.value = null;
                
                // Update hidden input
                if (this.$refs.hiddenInput) {
                    this.$refs.hiddenInput.value = '';
                }
                
                // Dispatch change event
                this.$dispatch('change', { value: null });
            },
            
            onMouseEnter(rating) {
                if (this.readonly) return;
                this.hoverValue = rating;
            },
            
            onMouseLeave() {
                if (this.readonly) return;
                this.hoverValue = null;
            },
            
            isActive(index) {
                const current = this.displayValue;
                return current !== null && index <= current;
            },
            
            isHalfActive(index) {
                const current = this.displayValue;
                return current !== null && index - 0.5 <= current && current < index;
            }
        }));
    });
</script>