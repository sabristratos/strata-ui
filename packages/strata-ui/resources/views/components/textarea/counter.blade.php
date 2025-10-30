@props([
    'max' => 100,
])

<div
    x-data="{
        count: 0,
        max: {{ $max }},
        textarea: null,
        init() {
            this.textarea = this.$el.closest('[data-strata-textarea-wrapper]').querySelector('[data-strata-textarea]');
            if (this.textarea) {
                this.count = this.textarea.value.length;
                this.textarea.addEventListener('input', () => {
                    this.count = this.textarea.value.length;
                });
            }
        },
        getColor() {
            const percentage = (this.count / this.max) * 100;
            if (percentage >= 100) return 'text-destructive';
            if (percentage >= 80) return 'text-warning';
            return 'text-muted-foreground';
        }
    }"
    {{ $attributes->merge(['class' => 'text-sm font-medium flex-shrink-0']) }}
    x-bind:class="getColor()"
>
    <span x-text="count"></span>/<span x-text="max"></span>
</div>
