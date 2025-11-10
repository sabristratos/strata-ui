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
    <button
        type="button"
        @click="toggle()"
        :aria-label="show ? $__('Hide password') : $__('Show password')"
        class="inline-flex items-center justify-center rounded-md transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground {{ $size === 'sm' ? 'h-8 w-8' : ($size === 'md' ? 'h-10 w-10' : 'h-12 w-12') }}"
        {{ $attributes }}
    >
        <x-strata::icon.eye x-show="!show" class="w-4 h-4" />
        <x-strata::icon.eye-off x-show="show" x-cloak class="w-4 h-4" />
    </button>
</div>
