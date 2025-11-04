<button
    type="button"
    data-strata-editor-button
    {{ $attributes->class([
        'inline-flex items-center justify-center h-8 min-w-8 px-2 rounded text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-muted hover:text-foreground',
    ]) }}
>
    {{ $slot }}
</button>
