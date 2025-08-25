@php
    $hasLeadingSlot = isset($leading);
    $hasTrailingSlot = isset($trailing);
    $hasIcon = !empty($icon);
    $hasClearable = $clearable;
    $hasPasswordToggle = $showPasswordToggle && $type === 'password';

    $inputClasses = 'input-base h-9';

    if ($hasIcon || $hasLeadingSlot) {
        $inputClasses .= ' pl-10';
    } else {
        $inputClasses .= ' px-3';
    }

    if ($hasClearable || $hasPasswordToggle || $hasTrailingSlot) {
        $inputClasses .= ' pr-10';
    } else {
        $inputClasses .= ' px-3';
    }
@endphp

<div
    x-data="{
        /** @type {string} Current input value */
        value: @if($attributes->wire('model')) @entangle($attributes->wire('model')) @else '{{ $value }}' @endif,
        /** @type {string} Input type */
        type: '{{ $type }}',
        /** @type {boolean} Whether this is a password input */
        isPassword: '{{ $type === 'password' }}',
        /** @type {boolean} Whether password is currently visible */
        showPassword: false,

        /**
         * Get the current input type, handling password visibility
         * @returns {string} The input type to use
         */
        get inputType() {
            return this.isPassword && !this.showPassword ? 'password' : (this.isPassword ? 'text' : this.type);
        },

        /**
         * Check if input has a value
         * @returns {boolean} Whether input has content
         */
        get hasValue() {
            return this.value && this.value.toString().length > 0;
        },

        /**
         * Clear the input value and focus the field
         */
        clearInput() {
            this.value = '';
            this.$refs.input.focus();
        },

        /**
         * Toggle password visibility and focus the field
         */
        togglePassword() {
            this.showPassword = !this.showPassword;
            this.$refs.input.focus();
        }
    }"
    class="relative"
>
    @if($hasIcon || $hasLeadingSlot)
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            @isset($leading)
                {{ $leading }}
            @elseif($hasIcon)
                <x-dynamic-component :component="$icon" class="h-5 w-5 text-muted" />
            @endisset
        </div>
    @endif

    <input
        x-ref="input"
        :type="inputType"
        x-model="value"
        @if($name) name="{{ $name }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->except(['wire:model']) }}
        class="{{ $inputClasses }}"
    />

    @if($hasClearable || $hasPasswordToggle || $hasTrailingSlot)
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center space-x-1">
            @isset($trailing)
                {{ $trailing }}
            @endif

            @if($hasClearable)
                <button
                    type="button"
                    x-show="hasValue"
                    x-on:click="clearInput"
                    class="text-muted-foreground hover:text-primary focus:outline-hidden focus:text-primary transition-colors duration-200"
                >
                    <x-icon name="heroicon-o-x-mark" class="h-4 w-4" />
                </button>
            @endif

            @if($hasPasswordToggle)
                <button
                    type="button"
                    x-on:click="togglePassword"
                    class="text-muted-foreground hover:text-primary focus:outline-hidden focus:text-primary transition-colors duration-200"
                >
                    <x-icon x-show="!showPassword" name="heroicon-o-eye" class="h-4 w-4" />
                    <x-icon x-show="showPassword" name="heroicon-o-eye-slash" class="h-4 w-4" />
                </button>
            @endif
        </div>
    @endif
</div>
