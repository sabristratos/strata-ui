@props([
    'sortable' => false,
    'sortColumn' => null,
    'sortDirection' => null,
    'align' => 'left',
    'column' => null,
])

@php
$alignments = [
    'left' => 'text-left',
    'center' => 'text-center',
    'right' => 'text-right',
];

$alignClass = $alignments[$align] ?? $alignments['left'];

$paddingSizes = [
    'sm' => 'px-3 py-2 @max-sm:py-3',
    'md' => 'px-4 py-3 @max-sm:py-4',
    'lg' => 'px-6 py-4 @max-sm:py-5',
];

$ariaSort = 'none';
if ($sortColumn === $column && $sortDirection) {
    $ariaSort = $sortDirection === 'asc' ? 'ascending' : 'descending';
}
@endphp

<th
    data-strata-table-head-cell
    scope="col"
    aria-sort="{{ $ariaSort }}"
    :class="{
        'font-semibold': true,
        '{{ $alignClass }}': true,
        '{{ $paddingSizes['sm'] }}': size === 'sm',
        '{{ $paddingSizes['md'] }}': size === 'md',
        '{{ $paddingSizes['lg'] }}': size === 'lg',
        'cursor-pointer select-none hover:bg-table-row-hover/30 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-1': @js($sortable)
    }"
    @if($sortable)
        tabindex="0"
        role="button"
        wire:click="sortBy('{{ $column }}')"
        @keydown.enter="$wire.sortBy('{{ $column }}')"
        @keydown.space.prevent="$wire.sortBy('{{ $column }}')"
    @endif
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
