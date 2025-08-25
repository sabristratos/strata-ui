<div>
    <label for="{{ $for }}" class="block text-sm font-medium text-foreground mb-1">
        {{ $label }}
    </label>
    <div>
        {{ $slot }}
    </div>
    @if ($helpText && !$error)
        <p class="mt-2 text-sm text-muted-foreground">{{ $helpText }}</p>
    @endif
    @if ($error)
        <p class="mt-2 text-sm text-destructive">{{ $error }}</p>
    @endif
</div>