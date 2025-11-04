@props([
    'size' => 'sm',
])

<div
    x-data="{
        input: null,
        hasValue: false,
        init() {
            this.input = this.$el.closest('[data-strata-input-wrapper]').querySelector('[data-strata-input]');
            if (this.input) {
                this.hasValue = this.input.value.length > 0;
                this.input.addEventListener('input', () => {
                    this.hasValue = this.input.value.length > 0;
                });
            }
        },
        clear() {
            if (this.input) {
                this.input.value = '';
                this.input.dispatchEvent(new Event('input', { bubbles: true }));
                this.input.focus();
                this.hasValue = false;
            }
        }
    }"
    x-show="hasValue"
    x-cloak
>
    <x-strata::button.icon
        icon="x"
        :size="$size"
        variant="secondary"
        appearance="ghost"
        aria-label="Clear input"
        @click.stop="clear()"
        type="button"
        {{ $attributes }}
    />
</div>
