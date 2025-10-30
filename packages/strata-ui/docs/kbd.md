# Kbd (Keyboard Key)

Display keyboard keys and shortcuts with realistic button-style appearance.

## Basic Usage

```blade
<x-strata::kbd>Ctrl</x-strata::kbd>
<x-strata::kbd>Enter</x-strata::kbd>
<x-strata::kbd>⌘</x-strata::kbd>
```

## Sizes

Available sizes: `sm`, `md` (default), `lg`

```blade
<x-strata::kbd size="sm">Esc</x-strata::kbd>
<x-strata::kbd size="md">Tab</x-strata::kbd>
<x-strata::kbd size="lg">Space</x-strata::kbd>
```

## Variants

Available variants: `primary`, `secondary` (default), `success`, `warning`, `destructive`, `info`

```blade
<x-strata::kbd variant="primary">⌘</x-strata::kbd>
<x-strata::kbd variant="secondary">Alt</x-strata::kbd>
<x-strata::kbd variant="success">Enter</x-strata::kbd>
<x-strata::kbd variant="warning">Delete</x-strata::kbd>
<x-strata::kbd variant="destructive">Esc</x-strata::kbd>
<x-strata::kbd variant="info">Tab</x-strata::kbd>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `md` | Key size (`sm`, `md`, `lg`) |
| `variant` | string | `secondary` | Color variant |

## Examples

### Single Keys

```blade
<x-strata::kbd>A</x-strata::kbd>
<x-strata::kbd>Esc</x-strata::kbd>
<x-strata::kbd>↵</x-strata::kbd>
<x-strata::kbd>⌘</x-strata::kbd>
```

### Keyboard Shortcuts

Use inline markup to display keyboard combinations:

```blade
{{-- Copy shortcut --}}
<div class="flex items-center gap-2">
    <x-strata::kbd>Ctrl</x-strata::kbd>
    <span>+</span>
    <x-strata::kbd>C</x-strata::kbd>
</div>

{{-- Command palette --}}
<div class="flex items-center gap-2">
    <x-strata::kbd>⌘</x-strata::kbd>
    <span>+</span>
    <x-strata::kbd>K</x-strata::kbd>
</div>

{{-- Complex shortcut --}}
<div class="flex items-center gap-2">
    <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
    <span class="text-sm">+</span>
    <x-strata::kbd size="sm">Shift</x-strata::kbd>
    <span class="text-sm">+</span>
    <x-strata::kbd size="sm">P</x-strata::kbd>
</div>
```

### Documentation

Perfect for displaying keyboard shortcuts in documentation:

```blade
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <span>Open command palette</span>
        <div class="flex items-center gap-1">
            <x-strata::kbd size="sm">⌘</x-strata::kbd>
            <span class="text-sm text-muted-foreground">+</span>
            <x-strata::kbd size="sm">K</x-strata::kbd>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <span>Search files</span>
        <div class="flex items-center gap-1">
            <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
            <span class="text-sm text-muted-foreground">+</span>
            <x-strata::kbd size="sm">P</x-strata::kbd>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <span>Save document</span>
        <div class="flex items-center gap-1">
            <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
            <span class="text-sm text-muted-foreground">+</span>
            <x-strata::kbd size="sm">S</x-strata::kbd>
        </div>
    </div>
</div>
```

### Help Modal

Display available shortcuts in a help modal:

```blade
<x-strata::card>
    <x-strata::card.header>
        <h3 class="text-lg font-semibold">Keyboard Shortcuts</h3>
    </x-strata::card.header>

    <x-strata::card.body>
        <div class="space-y-4">
            <div class="grid grid-cols-[1fr,auto] gap-4 items-center">
                <span class="text-muted-foreground">Copy</span>
                <div class="flex items-center gap-1">
                    <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
                    <span class="text-sm">+</span>
                    <x-strata::kbd size="sm">C</x-strata::kbd>
                </div>
            </div>

            <div class="grid grid-cols-[1fr,auto] gap-4 items-center">
                <span class="text-muted-foreground">Paste</span>
                <div class="flex items-center gap-1">
                    <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
                    <span class="text-sm">+</span>
                    <x-strata::kbd size="sm">V</x-strata::kbd>
                </div>
            </div>

            <div class="grid grid-cols-[1fr,auto] gap-4 items-center">
                <span class="text-muted-foreground">Undo</span>
                <div class="flex items-center gap-1">
                    <x-strata::kbd size="sm">Ctrl</x-strata::kbd>
                    <span class="text-sm">+</span>
                    <x-strata::kbd size="sm">Z</x-strata::kbd>
                </div>
            </div>
        </div>
    </x-strata::card.body>
</x-strata::card>
```

### With Variants

Use variants to emphasize specific keys:

```blade
<div class="flex items-center gap-2">
    <span>Press</span>
    <x-strata::kbd variant="success">Enter</x-strata::kbd>
    <span>to submit or</span>
    <x-strata::kbd variant="destructive">Esc</x-strata::kbd>
    <span>to cancel</span>
</div>
```

## Best Practices

- Use consistent sizing within the same context
- For key combinations, use `+` or similar separators between keys
- Consider using `size="sm"` for inline documentation
- Use semantic variants to highlight important keys (e.g., `variant="success"` for Enter, `variant="destructive"` for Esc/Cancel)
- Prefer standard key names (Ctrl, Shift, Alt, Enter) over symbols when clarity is important
- Use Unicode symbols for common keys: ⌘ (Command), ⌥ (Option), ⇧ (Shift), ⌃ (Control), ↵ (Return)
