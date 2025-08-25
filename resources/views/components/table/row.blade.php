@php
    $baseClasses = '';
    
    if ($selected) {
        $baseClasses .= ' bg-primary-50 dark:bg-primary-900/20';
    }
    
    if ($clickable) {
        $baseClasses .= ' hover:bg-default cursor-pointer transition-colors duration-150';
    }
@endphp

<tr {{ $attributes->merge(['class' => trim($baseClasses)]) }}>
    {{ $slot }}
</tr>