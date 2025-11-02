@props([
    'title' => null,
])

@php
$classes = 'flex items-center justify-between gap-4 px-6 py-4 border-b border-border';
@endphp

<div data-strata-modal-header {{ $attributes->merge(['class' => $classes]) }}>
    @if($title)
        <h2 class="text-lg font-semibold text-dialog-foreground">{{ $title }}</h2>
    @elseif($slot->isNotEmpty())
        <div class="flex-1 text-lg font-semibold text-dialog-foreground">
            {{ $slot }}
        </div>
    @endif

    @if(isset($actions) && $actions->isNotEmpty())
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
