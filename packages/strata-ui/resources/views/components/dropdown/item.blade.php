@props([
    'disabled' => false,
    'href' => null,
    'icon' => null,
    'iconTrailing' => null,
    'destructive' => false,
])

@php
$itemId = $attributes->get('id') ?? 'dropdown-item-' . uniqid();

$baseClasses = 'w-full flex items-center gap-3 px-4 py-2 text-left text-sm transition-colors duration-150 rounded-md';

$stateClasses = $disabled
    ? 'opacity-50 cursor-not-allowed'
    : ($destructive
        ? 'text-destructive hover:bg-destructive/10 focus:bg-destructive/10 cursor-pointer'
        : 'text-foreground hover:bg-muted focus:bg-muted cursor-pointer');

$highlightedClasses = $disabled ? '' : 'aria-[current=true]:bg-accent';

$classes = trim("$baseClasses $stateClasses $highlightedClasses");

$tag = $href && !$disabled ? 'a' : 'button';
$tagAttributes = $href && !$disabled ? ['href' => $href] : ['type' => 'button'];
@endphp

<{{ $tag }}
    id="{{ $itemId }}"
    data-strata-dropdown-item
    @if($disabled) data-disabled @endif
    role="menuitem"
    tabindex="-1"
    :aria-current="highlighted === {{ json_encode(array_search($itemId, array_column($items ?? [], 'element.id'))) }} ? 'true' : 'false'"
    @click="if (!{{ $disabled ? 'true' : 'false' }}) { close(); }"
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
