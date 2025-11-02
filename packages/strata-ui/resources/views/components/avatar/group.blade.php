@props([
    'max' => 3,
    'size' => 'md',
    'shape' => 'circle',
])

@php
$sizes = [
    'xs' => 'w-6 h-6 text-xs',
    'sm' => 'w-8 h-8 text-sm',
    'md' => 'w-10 h-10 text-base',
    'lg' => 'w-12 h-12 text-lg',
    'xl' => 'w-14 h-14 text-xl',
    '2xl' => 'w-16 h-16 text-2xl',
];

$shapes = [
    'circle' => 'rounded-full',
    'square' => 'rounded-none',
    'rounded' => 'rounded-lg',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$shapeClasses = $shapes[$shape] ?? $shapes['circle'];
@endphp

<div
    x-data="{
        max: {{ $max }},
        total: 0,
        remaining: 0,
        init() {
            this.total = this.$el.querySelectorAll('[data-strata-avatar]').length;
            this.remaining = Math.max(0, this.total - this.max);

            const avatars = this.$el.querySelectorAll('[data-strata-avatar]');
            avatars.forEach((avatar, index) => {
                if (index >= this.max) {
                    avatar.style.display = 'none';
                }
            });
        }
    }"
    {{ $attributes->merge(['class' => 'flex [&>[data-strata-avatar]:not(:first-child)]:-ml-2 [&>[data-strata-avatar]]:ring-2 [&>[data-strata-avatar]]:ring-body']) }}
>
    {{ $slot }}

    <div
        x-show="remaining > 0"
        x-cloak
        class="inline-flex items-center justify-center bg-muted text-muted-foreground font-medium ring-2 ring-body {{ $sizeClasses }} {{ $shapeClasses }}"
    >
        +<span x-text="remaining"></span>
    </div>
</div>
