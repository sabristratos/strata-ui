@props([
    'size' => 'sm',
])

<div
    x-data="{
        textarea: null,
        hasValue: false,
        init() {
            this.textarea = this.$el.closest('[data-strata-textarea-wrapper]').querySelector('[data-strata-textarea]');
            if (this.textarea) {
                this.hasValue = this.textarea.value.length > 0;
                this.textarea.addEventListener('input', () => {
                    this.hasValue = this.textarea.value.length > 0;
                });
            }
        },
        clear() {
            if (this.textarea) {
                this.textarea.value = '';
                this.textarea.dispatchEvent(new Event('input', { bubbles: true }));
                this.textarea.focus();
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
        style="ghost"
        aria-label="Clear textarea"
        @click="clear()"
        type="button"
        {{ $attributes }}
    />
</div>
