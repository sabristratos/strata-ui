@props([
    'empty' => 'No files selected',
    'clearable' => false,
    'onClear' => null,
    'title' => null,
])

@php
$baseClasses = 'space-y-2';
@endphp

<div
    data-strata-file-input-list
    {{ $attributes->merge(['class' => $baseClasses]) }}
>
    @if($slot->isEmpty())
        <div class="text-center py-8">
            <x-strata::icon.inbox class="w-12 h-12 mx-auto text-muted-foreground/50 mb-3" />
            <p class="text-sm text-muted-foreground">{{ $empty }}</p>
        </div>
    @else
        @if($clearable || $title)
            <div class="flex items-center justify-between mb-3 pb-2 border-b border-border">
                @if($title)
                    <h4 class="text-sm font-medium text-foreground">{{ $title }}</h4>
                @else
                    <div></div>
                @endif

                @if($clearable && $onClear)
                    <x-strata::button
                        icon="x"
                        size="sm"
                        variant="destructive"
                        appearance="ghost"
                        wire:click="{{ $onClear }}"
                        type="button"
                    >
                        Clear All
                    </x-strata::button>
                @endif
            </div>
        @endif

        {{ $slot }}
    @endif
</div>
