<div 
    x-data="{
        value: @if($attributes->wire('model')) @entangle($attributes->wire('model')) @else {{ $checked ? 'true' : 'false' }} @endif,
        
        get isOn() {
            return this.value === true || this.value === '1' || this.value === 1;
        },
        
        toggle() {
            this.value = !this.isOn;
            this.$refs.hiddenInput.checked = this.isOn;
        }
    }" 
    class="flex items-center space-x-3"
>
    @if($name && !$attributes->wire('model'))
        <input type="hidden" name="{{ $name }}" value="0">
    @endif
    
    <input 
        x-ref="hiddenInput"
        type="checkbox" 
        @if($name) name="{{ $name }}" @endif
        @if($value) value="{{ $value }}" @else value="1" @endif
        :checked="isOn"
        class="sr-only"
        {{ $attributes->except(['wire:model']) }}
    >

    <button 
        x-ref="switchButton"
        type="button" 
        @click="toggle()"
        :class="isOn ? 'bg-primary' : 'bg-input'" 
        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
        :aria-pressed="isOn.toString()"
        role="switch"
        @if($label) aria-labelledby="{{ $id }}-label" @endif
        @if($description) aria-describedby="{{ $id }}-description" @endif
    >
        <span 
            :class="isOn ? 'translate-x-5' : 'translate-x-0'" 
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-background shadow-sm ring-0 transition duration-200 ease-in-out"
        ></span>
    </button>

    @if($label || $description)
        <div class="flex flex-col">
            @if($label)
                <label 
                    id="{{ $id }}-label"
                    @click="$refs.switchButton.click(); $refs.switchButton.focus()" 
                    class="text-sm font-medium cursor-pointer select-none text-foreground"
                >
                    {{ $label }}
                </label>
            @endif
            @if($description)
                <p 
                    id="{{ $id }}-description"
                    class="text-xs text-muted-foreground mt-0.5"
                >
                    {{ $description }}
                </p>
            @endif
        </div>
    @endif
</div>