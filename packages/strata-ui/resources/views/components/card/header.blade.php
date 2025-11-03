@props([
    'title' => null,
    'subtitle' => null,
])

@php
$classes = 'flex items-start justify-between gap-4 p-6 pb-4';
@endphp

<div data-strata-card-header {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex-1 min-w-0">
        @if($title)
            <x-strata::heading level="3" size="text-lg font-semibold" class="text-card-foreground">{{ $title }}</x-strata::heading>
        @endif

        @if($slot->isNotEmpty() && !$title)
            <div class="text-lg font-semibold text-card-foreground">
                {{ $slot }}
            </div>
        @endif

        @if($subtitle)
            <x-strata::text variant="small" class="mt-1">{{ $subtitle }}</x-strata::text>
        @endif
    </div>

    @if(isset($actions) && $actions->isNotEmpty())
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
