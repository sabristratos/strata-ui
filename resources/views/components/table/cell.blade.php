@php
    $alignClasses = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left'
    };

    $cellTag = $header ? 'th' : 'td';
    $baseClasses = 'px-[var(--table-cell-px)] py-[var(--table-cell-py)]';

    if ($header) {
        $baseClasses .= ' font-semibold text-primary bg-default first:rounded-tl-[var(--radius-component-lg)] last:rounded-tr-[var(--radius-component-lg)]';
    } else {
        $baseClasses .= ' text-secondary';
    }

    $baseClasses .= ' ' . $alignClasses;
@endphp

<{{ $cellTag }} {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if ($header && $sortable)
        <button
            type="button"
            class="group inline-flex items-center gap-2 font-semibold text-primary hover:text-primary-600 transition-colors duration-150"
            {{ $attributes->only(['wire:click', 'onclick', '@click']) }}
        >
            <span>{{ $slot }}</span>
            <span class="shrink-0">
                @if ($sortDirection === 'asc')
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                @elseif ($sortDirection === 'desc')
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                @else
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                @endif
            </span>
        </button>
    @else
        {{ $slot }}
    @endif
</{{ $cellTag }}>
