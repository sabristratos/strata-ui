@props([
    'chips' => false,
    'disabled' => false,
    'sizeClasses' => '',
    'stateClasses' => '',
    'variantClasses' => '',
])

@php
$itemsAlignment = $chips ? 'items-start' : 'items-center';

$triggerClasses = [
    'w-full inline-flex justify-between gap-2 rounded-lg',
    'transition-all duration-150',
    'focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2',
    $variantClasses,
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
    :style="`anchor-name: --datepicker-${$id('datepicker-dropdown')};`"
    @click.prevent.stop="isDisabled() ? null : toggleDropdown()"
    x-ref="trigger"
    :tabindex="isDisabled() ? -1 : 0"
    @keydown.enter.prevent="isDisabled() ? null : toggleDropdown()"
    @keydown.space.prevent="isDisabled() ? null : toggleDropdown()"
    role="combobox"
    aria-haspopup="dialog"
    :aria-expanded="open"
    :aria-disabled="isDisabled()"
    :aria-controls="$id('datepicker-dropdown')"
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
                    x-text="getPlaceholder()"
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
