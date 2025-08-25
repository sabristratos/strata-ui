@php
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
    
    // CSS variables for dynamic cell padding based on size
    $paddingVariables = match($size) {
        'sm' => '--table-cell-px: 0.75rem; --table-cell-py: 0.5rem;',
        'md' => '--table-cell-px: 1rem; --table-cell-py: 0.75rem;',
        'lg' => '--table-cell-px: 1.5rem; --table-cell-py: 1rem;',
        'default' => '--table-cell-px: 1rem; --table-cell-py: 0.75rem;'
    };
@endphp

<div {{ $attributes->merge(['class' => 'relative overflow-x-auto ' . $sizeClasses]) }} style="{{ $paddingVariables }}">
    <table class="{{ $tableClasses }}">
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>