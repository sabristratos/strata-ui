@php
$triggerClasses = [
    'w-full inline-flex items-center gap-2 rounded-lg',
    'transition-all duration-150',
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2',
    $variantClasses,
    $sizeClasses,
    $stateClasses,
];

if ($disabled) {
    $triggerClasses[] = 'opacity-50 cursor-not-allowed';
} else {
    $triggerClasses[] = 'cursor-pointer hover:border-primary/50';
}
@endphp

<div
    {{ $attributes->merge(['class' => implode(' ', $triggerClasses)]) }}
    x-ref="trigger"
    :style="`anchor-name: --timepicker-${$id('timepicker-dropdown')};`"
    @click.prevent.stop="isDisabled() ? null : toggleDropdown()"
    @keydown.enter.prevent="isDisabled() ? null : toggleDropdown()"
    @keydown.space.prevent="isDisabled() ? null : toggleDropdown()"
    @keydown="!isDisabled() && handleKeyboardNavigation($event)"
    :tabindex="isDisabled() ? -1 : 0"
    role="combobox"
    aria-haspopup="listbox"
    :aria-expanded="open"
    :aria-disabled="isDisabled()"
    :aria-controls="$id('timepicker-dropdown')"
    :aria-activedescendant="open ? getActiveDescendant() : ''"
    :aria-readonly="readonly"
    :aria-required="required"
>
    <x-strata::icon.clock
        class="w-5 h-5 shrink-0 text-muted-foreground"
        aria-hidden="true"
    />

    <div class="flex-1 min-w-0 truncate">
        <span
            x-show="display"
            x-text="display"
            class="text-foreground"
        ></span>
        <span
            x-show="!display"
            x-text="placeholder"
            class="text-muted-foreground"
        ></span>
    </div>

    <x-strata::time-picker.clear size="sm" />

    <x-strata::icon.chevron-down
        class="w-5 h-5 shrink-0 text-muted-foreground transition-transform duration-150 ease-out"
        ::class="{ 'rotate-180': open }"
        aria-hidden="true"
    />
</div>
