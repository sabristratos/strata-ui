@props([
    'disabled' => false,
    'href' => null,
    'icon' => null,
    'iconTrailing' => null,
    'destructive' => false,
])

@php
use Stratos\StrataUI\Support\ComponentHelpers;

$itemId = ComponentHelpers::generateId('popover-item', null, $attributes);

$baseClasses = 'w-full flex items-center gap-3 px-4 py-2 text-left text-sm transition-colors duration-150 rounded-md focus:outline-none';

$stateClasses = $disabled
    ? 'opacity-50 cursor-not-allowed'
    : ($destructive
        ? 'text-destructive hover:bg-destructive/10 focus:bg-destructive/10 cursor-pointer'
        : 'text-foreground hover:bg-muted focus:bg-muted cursor-pointer');

$classes = trim("$baseClasses $stateClasses");

$tag = $href && !$disabled ? 'a' : 'button';
$tagAttributes = $href && !$disabled ? ['href' => $href] : ['type' => 'button'];
@endphp

<{{ $tag }}
    id="{{ $itemId }}"
    data-strata-popover-item
    @if($disabled) data-disabled @endif
    role="menuitem"
    tabindex="-1"
    :class="{
        'bg-accent': highlighted === items.findIndex(item => item.element.id === '{{ $itemId }}')
    }"
    @click.stop="if (!{{ $disabled ? 'true' : 'false' }}) { close(); }"
    {{ $attributes->merge(['class' => $classes])->merge($tagAttributes) }}
>
    @if($icon)
        <span class="flex-shrink-0">
            <x-dynamic-component :component="'strata::icon.' . $icon" class="w-4 h-4" />
        </span>
    @endif

    <span class="flex-1">
        {{ $slot }}
    </span>

    @if($iconTrailing)
        <span class="flex-shrink-0">
            <x-dynamic-component :component="'strata::icon.' . $iconTrailing" class="w-4 h-4" />
        </span>
    @endif
</{{ $tag }}>
