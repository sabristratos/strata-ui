@props([
    'chips' => false,
    'disabled' => false,
    'sizeClasses' => '',
    'stateClasses' => '',
])

@php
$itemsAlignment = $chips ? 'items-start' : 'items-center';

$triggerClasses = [
    'w-full inline-flex justify-between gap-2 bg-input border rounded-lg inset-shadow-sm',
    'transition-all duration-150',
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2',
    $itemsAlignment,
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
    <x-strata::icon.calendar
        class="w-5 h-5 shrink-0 text-muted-foreground"
        aria-hidden="true"
    />

    <div class="flex-1">
        <template x-if="mode === 'multiple' && chips && entangleable.value && entangleable.value.length > 0">
            <div>
                <div class="flex flex-wrap gap-1 max-h-20 overflow-y-auto">
                    <template x-for="date in entangleable.value" :key="date">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-primary/10 text-primary text-sm rounded">
                            <span x-text="formatDateShort(date)"></span>
                        </span>
                    </template>
                </div>
            </div>
        </template>

        <template x-if="!(mode === 'multiple' && chips && entangleable.value && entangleable.value.length > 0)">
            <div class="truncate">
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
        </template>
    </div>

    <x-strata::icon.chevron-down
        class="w-5 h-5 shrink-0 text-muted-foreground transition-transform duration-150 ease-out"
        ::class="{ 'rotate-180': open }"
        aria-hidden="true"
    />
</div>
