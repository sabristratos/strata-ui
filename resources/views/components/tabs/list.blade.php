@php
    $listClasses = [
        'flex',
        'gap-1',
        'border-b border-border',
        'mb-4'
    ];
@endphp

<div 
    role="tablist"
    {{ $attributes->merge([
        'class' => implode(' ', array_filter($listClasses))
    ]) }}
>
    {{ $slot }}
</div>