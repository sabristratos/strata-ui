@php
$triggerClasses = [
    'w-full inline-flex items-center gap-2 bg-input border rounded-lg inset-shadow-sm',
    'transition-all duration-150',
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2',
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
    @click="disabled ? null : (open = true)"
    x-ref="trigger"
    tabindex="{{ $disabled ? '-1' : '0' }}"
    @keydown.enter.prevent="disabled ? null : (open = true)"
    @keydown.space.prevent="disabled ? null : (open = true)"
    role="button"
    aria-haspopup="true"
    :aria-expanded="open"
    :aria-disabled="disabled"
>
    <x-strata::icon.clock
        class="w-5 h-5 shrink-0 text-muted-foreground"
        aria-hidden="true"
    />

    <div class="flex-1 truncate">
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

    <x-strata::icon.chevron-down
        class="w-5 h-5 shrink-0 text-muted-foreground transition-transform duration-150 ease-out"
        ::class="{ 'rotate-180': open }"
        aria-hidden="true"
    />
</div>
