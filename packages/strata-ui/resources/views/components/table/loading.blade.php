@props([
    'message' => 'Loading...',
])

<div
    data-strata-table-loading
    class="absolute inset-0 bg-card/80 backdrop-blur-sm flex flex-col items-center justify-center z-10 transition-all transition-discrete duration-200 opacity-100 starting:opacity-0"
    {{ $attributes }}
>
    <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
    @if($message)
        <p class="mt-3 text-sm text-muted-foreground">{{ $message }}</p>
    @endif
</div>
