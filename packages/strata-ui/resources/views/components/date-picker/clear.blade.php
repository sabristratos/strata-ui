@props([
    'size' => 'sm',
])

<div
    x-show="clearable && hasValue() && !disabled"
    x-cloak
>
    <x-strata::button.icon
        icon="x"
        :size="$size"
        variant="secondary"
        appearance="ghost"
        aria-label="Clear selection"
        @click.stop="clear()"
        type="button"
        {{ $attributes }}
    />
</div>
