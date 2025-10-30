@props([
    'value' => null,
    'disabled' => false,
    'icon' => 'chevron-right',
])

@php
$value = $value ?? uniqid('accordion-item-');

$borderedClasses = 'border border-border bg-background rounded-lg overflow-hidden';
$dividedClasses = 'border-b border-border last:border-b-0';
$cardClasses = 'bg-card text-card-foreground border border-card-border rounded-lg shadow-sm overflow-hidden';
$minimalClasses = 'overflow-hidden';

$variants = [
    'bordered' => $borderedClasses,
    'divided' => $dividedClasses,
    'card' => $cardClasses,
    'minimal' => $minimalClasses,
];
@endphp

<details
    x-data="{
        value: @js($value),
        disabled: @js($disabled),
        isOpen: false,
        init() {
            const isDefault = this.defaultValue?.includes(this.value);
            if (isDefault) {
                this.$el.open = true;
                this.isOpen = true;
            }
        },
        handleToggle(event) {
            if (this.disabled) {
                event.preventDefault();
                return false;
            }
            this.isOpen = this.$el.open;
        },
        getVariantClasses() {
            const variantMap = @js($variants);
            return variantMap[this.variant || 'bordered'] || @js($borderedClasses);
        }
    }"
    x-bind:class="getVariantClasses()"
    x-bind:name="accordionName"
    x-on:toggle="handleToggle($event)"
    data-strata-accordion-item
    data-value="{{ $value }}"
    {{ $attributes }}
>
    <summary class="flex items-center justify-between w-full cursor-pointer select-none transition-colors duration-200 hover:bg-muted/50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 list-none"
        :class="{
            'p-4': true,
            'cursor-not-allowed opacity-50': disabled
        }"
        :aria-disabled="disabled"
    >
        <div class="flex-1">
            @isset($trigger)
                {{ $trigger }}
            @else
                {{ $slot }}
            @endisset
        </div>

        <div class="ml-4 flex-shrink-0">
            @isset($iconSlot)
                {{ $iconSlot }}
            @else
                <div class="transition-transform duration-200"
                    :class="{ 'rotate-90': isOpen }"
                >
                    <x-dynamic-component
                        :component="'strata::icon.' . $icon"
                        class="w-5 h-5 text-muted-foreground"
                    />
                </div>
            @endisset
        </div>
    </summary>

    @if(isset($content))
        <div class="px-4 pb-4 text-muted-foreground">
            {{ $content }}
        </div>
    @elseif(isset($trigger))
        <div class="px-4 pb-4 text-muted-foreground">
            {{ $slot }}
        </div>
    @endif
</details>
