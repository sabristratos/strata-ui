@props([
    'max' => 3,
    'size' => 'md',
    'shape' => 'circle',
    'ring' => 'accent',
    'variant' => 'secondary',
    'style' => 'filled',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$childSizes = [
    'xs' => '*:w-6 *:h-6 *:text-xs',
    'sm' => '*:w-8 *:h-8 *:text-sm',
    'md' => '*:w-10 *:h-10 *:text-base',
    'lg' => '*:w-12 *:h-12 *:text-lg',
    'xl' => '*:w-14 *:h-14 *:text-xl',
    '2xl' => '*:w-16 *:h-16 *:text-2xl',
];

$childShapes = [
    'circle' => '*:rounded-full',
    'square' => '*:rounded-none',
    'rounded' => '*:rounded-lg',
];

$sizes = ComponentSizeConfig::avatarSizes();

$shapes = [
    'circle' => 'rounded-full',
    'square' => 'rounded-none',
    'rounded' => 'rounded-lg',
];

// Counter badge color variants (design system)
$designSystemVariants = [
    'primary' => [
        'filled' => 'bg-primary text-white/90',
        'outlined' => 'bg-transparent text-primary border border-primary',
        'soft' => 'bg-primary/10 text-primary dark:text-primary',
    ],
    'secondary' => [
        'filled' => 'bg-secondary text-secondary-foreground',
        'outlined' => 'bg-transparent text-secondary-foreground border border-secondary-foreground',
        'soft' => 'bg-secondary/10 text-secondary-foreground',
    ],
    'success' => [
        'filled' => 'bg-success text-white/90',
        'outlined' => 'bg-transparent text-success border border-success',
        'soft' => 'bg-success/10 text-success dark:text-success',
    ],
    'warning' => [
        'filled' => 'bg-warning text-white/90',
        'outlined' => 'bg-transparent text-warning border border-warning',
        'soft' => 'bg-warning/10 text-warning dark:text-warning',
    ],
    'destructive' => [
        'filled' => 'bg-destructive text-white/90',
        'outlined' => 'bg-transparent text-destructive border border-destructive',
        'soft' => 'bg-destructive/10 text-destructive dark:text-destructive',
    ],
    'info' => [
        'filled' => 'bg-info text-white/90',
        'outlined' => 'bg-transparent text-info border border-info',
        'soft' => 'bg-info/10 text-info dark:text-info',
    ],
];

// Tailwind colors list
$tailwindColors = ['red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose', 'slate', 'gray', 'zinc', 'neutral', 'stone'];

// Design system ring colors
$childRingColors = [
    'primary' => '*:ring-primary',
    'secondary' => '*:ring-secondary',
    'accent' => '*:ring-accent',
    'success' => '*:ring-success',
    'warning' => '*:ring-warning',
    'destructive' => '*:ring-destructive',
    'info' => '*:ring-info',
];

$ringColors = [
    'primary' => 'ring-primary',
    'secondary' => 'ring-secondary',
    'accent' => 'ring-accent',
    'success' => 'ring-success',
    'warning' => 'ring-warning',
    'destructive' => 'ring-destructive',
    'info' => 'ring-info',
];

// Counter badge color logic
$counterClasses = '';
if (array_key_exists($variant, $designSystemVariants)) {
    $counterClasses = $designSystemVariants[$variant][$style];
} elseif (in_array($variant, $tailwindColors)) {
    if ($style === 'filled') {
        $counterClasses = "bg-{$variant}-500 text-white/90";
    } elseif ($style === 'outlined') {
        $counterClasses = "bg-transparent text-{$variant}-600 border border-{$variant}-600";
    } elseif ($style === 'soft') {
        $counterClasses = "bg-{$variant}-100 text-{$variant}-700 dark:bg-{$variant}-500/10 dark:!text-{$variant}-950";
    }
} else {
    $counterClasses = $designSystemVariants['secondary'][$style];
}

// Ring color logic
if (array_key_exists($ring, $childRingColors)) {
    $childRingClasses = $childRingColors[$ring];
    $ringClasses = $ringColors[$ring];
} elseif (in_array($ring, $tailwindColors)) {
    $childRingClasses = "*:ring-{$ring}-500";
    $ringClasses = "ring-{$ring}-500";
} else {
    $childRingClasses = $childRingColors['accent'];
    $ringClasses = $ringColors['accent'];
}

$childSizeClasses = $childSizes[$size] ?? $childSizes['md'];
$childShapeClasses = $childShapes[$shape] ?? $childShapes['circle'];
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
    {{ $attributes->merge(['class' => 'flex ' . $childSizeClasses . ' ' . $childShapeClasses . ' *:not-first:-ml-2 *:ring-2 ' . $childRingClasses]) }}
>
    {{ $slot }}

    <div
        x-show="remaining > 0"
        x-cloak
        class="inline-flex items-center justify-center font-medium ring-2 {{ $counterClasses }} {{ $ringClasses }} {{ $sizeClasses }} {{ $shapeClasses }}"
    >
        +<span x-text="remaining"></span>
    </div>
</div>
