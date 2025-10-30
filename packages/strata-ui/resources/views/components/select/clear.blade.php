@props([
    'size' => 'sm',
])

<div
    x-show="clearable && hasSelection() && !disabled"
    x-cloak
>
    <x-strata::button.icon
        icon="x"
        :size="$size"
        variant="secondary"
        style="ghost"
        aria-label="Clear selection"
        @click.stop="clear()"
        type="button"
        {{ $attributes }}
    />
</div>
