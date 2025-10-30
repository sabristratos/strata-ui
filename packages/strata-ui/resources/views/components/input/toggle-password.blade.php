@props([
    'size' => 'sm',
])

<div
    x-data="{
        show: false,
        input: null,
        init() {
            this.input = this.$el.closest('[data-strata-input-wrapper]').querySelector('[data-strata-input]');
        },
        toggle() {
            if (this.input) {
                this.show = !this.show;
                this.input.type = this.show ? 'text' : 'password';
            }
        }
    }"
>
    <x-strata::button.icon
        x-bind:icon="show ? 'eye-off' : 'eye'"
        :size="$size"
        variant="secondary"
        style="ghost"
        x-bind:aria-label="show ? 'Hide password' : 'Show password'"
        @click="toggle()"
        type="button"
        {{ $attributes }}
    />
</div>
