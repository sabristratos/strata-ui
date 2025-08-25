@props([
    'value',
    'disabled' => false
])

@php
    $baseClasses = [
        'inline-flex items-center justify-center',
        'px-4 py-2',
        'text-sm font-medium',
        'transition-all duration-200',
        'border-b-2 border-transparent',
        'hover:text-foreground hover:bg-muted/50',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
        'disabled:opacity-50 disabled:pointer-events-none',
        'whitespace-nowrap',
        'text-muted-foreground cursor-pointer'
    ];
    
    if ($disabled) {
        $baseClasses[] = 'cursor-not-allowed';
    }
@endphp

<button
    type="button"
    role="tab"
    data-tab-trigger="{{ $value }}"
    :aria-selected="isActive('{{ $value }}') ? 'true' : 'false'"
    :tabindex="isActive('{{ $value }}') ? '0' : '-1'"
    :data-state="isActive('{{ $value }}') ? 'active' : 'inactive'"
    @click="activateTab('{{ $value }}')"
    @if($disabled)
        disabled
        aria-disabled="true"
    @endif
    {{ $attributes->except(['value', 'disabled'])->merge([
        'class' => implode(' ', array_filter($baseClasses))
    ]) }}
>
    {{ $slot }}
</button>