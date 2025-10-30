@props([
    'sortable' => false,
    'sortColumn' => null,
    'sortDirection' => null,
    'align' => 'left',
])

@php
$alignments = [
    'left' => 'text-left',
    'center' => 'text-center',
    'right' => 'text-right',
];

$alignClass = $alignments[$align] ?? $alignments['left'];

$paddingSizes = [
    'sm' => 'px-3 py-2',
    'md' => 'px-4 py-3',
    'lg' => 'px-6 py-4',
];
@endphp

<th
    data-strata-table-head-cell
    :class="{
        'font-semibold': true,
        '{{ $alignClass }}': true,
        '{{ $paddingSizes['sm'] }}': size === 'sm',
        '{{ $paddingSizes['md'] }}': size === 'md',
        '{{ $paddingSizes['lg'] }}': size === 'lg',
        'cursor-pointer select-none hover:bg-table-row-hover/30 transition-colors': @js($sortable)
    }"
    {{ $attributes }}
>
    @if($sortable)
        <div class="flex items-center gap-2"
            :class="{
                'justify-start': '{{ $align }}' === 'left',
                'justify-center': '{{ $align }}' === 'center',
                'justify-end': '{{ $align }}' === 'right'
            }"
        >
            <span>{{ $slot }}</span>
            <span class="flex-shrink-0">
                @if($sortColumn && $sortDirection)
                    @if($sortDirection === 'asc')
                        <x-strata::icon.chevron-up class="w-4 h-4" />
                    @else
                        <x-strata::icon.chevron-down class="w-4 h-4" />
                    @endif
                @else
                    <x-strata::icon.chevrons-up-down class="w-4 h-4 text-muted-foreground/50" />
                @endif
            </span>
        </div>
    @else
        {{ $slot }}
    @endif
</th>
