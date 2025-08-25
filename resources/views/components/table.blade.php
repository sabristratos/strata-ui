@php
    $baseClasses = 'relative overflow-x-auto';
    $sizeClasses = match($size) {
        'sm' => 'text-xs',
        'md' => 'text-sm',
        'lg' => 'text-base',
        'default' => 'text-sm'
    };
    
    $tableClasses = 'w-full text-left text-secondary';
    if ($striped) {
        $tableClasses .= ' [&>tbody>tr:nth-child(even)]:bg-default';
    }
    
    // Add sticky classes directly to table element for proper behavior
    if ($sticky) {
        $tableClasses .= ' [&_thead_th]:sticky [&_thead_th]:top-0 [&_thead_th]:z-10 [&_thead_th]:bg-default';
    }
    
    // CSS variables for dynamic cell padding based on size
    $paddingVariables = match($size) {
        'sm' => '--table-cell-px: 0.75rem; --table-cell-py: 0.5rem;', // px-3 py-2
        'md' => '--table-cell-px: 1rem; --table-cell-py: 0.75rem;',    // px-4 py-3
        'lg' => '--table-cell-px: 1.5rem; --table-cell-py: 1rem;',     // px-6 py-4
        'default' => '--table-cell-px: 1rem; --table-cell-py: 0.75rem;'
    };
@endphp

<div {{ $attributes->merge(['class' => $baseClasses . ' ' . $sizeClasses]) }} style="{{ $paddingVariables }}">
    <table class="{{ $tableClasses }}">
        {{ $slot }}
    </table>

    @if ($loading)
        <div class="absolute inset-0 bg-white/80 dark:bg-gray-900/80 flex items-center justify-center backdrop-blur-xs">
            <div class="flex items-center space-x-2 text-secondary">
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="text-sm font-medium">Loading...</span>
            </div>
        </div>
    @endif
</div>