@props([
    'variant' => 'secondary',
    'size' => 'md',
])

@php
use Stratos\StrataUI\Config\ComponentSizeConfig;

$designSystemDotColors = [
    'primary' => 'bg-primary',
    'secondary' => 'bg-secondary',
    'success' => 'bg-success',
    'warning' => 'bg-warning',
    'destructive' => 'bg-destructive',
    'info' => 'bg-info',
];

$tailwindColors = ['red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose', 'slate', 'gray', 'zinc', 'neutral', 'stone'];

$dotColor = '';

if (array_key_exists($variant, $designSystemDotColors)) {
    $dotColor = $designSystemDotColors[$variant];
} elseif (in_array($variant, $tailwindColors)) {
    $dotColor = "bg-{$variant}-500";
} else {
    $dotColor = $designSystemDotColors['secondary'];
}

$sizes = ComponentSizeConfig::badgeDotTextSizes();
$dotSizes = ComponentSizeConfig::badgeDotSizes();

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$dotSize = $dotSizes[$size] ?? $dotSizes['md'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center font-medium text-foreground ' . $sizeClasses]) }}>
    <span class="{{ $dotColor }} {{ $dotSize }} rounded-full"></span>
    {{ $slot }}
</span>
