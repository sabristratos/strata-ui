@props([])

<div
    x-show="clearable && hasSelection() && !isDisabled()"
    x-cloak
    @click.stop="clear()"
    class="flex items-center justify-center cursor-pointer text-muted-foreground hover:text-foreground transition-colors p-1"
    role="button"
    aria-label="Clear selection"
    tabindex="-1"
    {{ $attributes }}
>
    <x-strata::icon.x class="w-4 h-4" />
</div>
