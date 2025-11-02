# Tooltip

Interactive tooltips that appear on hover or focus. Support both simple text and rich HTML content, making them perfect for providing contextual information, keyboard shortcuts, or interactive help.

## Basic Usage

### Simple Text Tooltip

Use the `text` prop for simple string tooltips:

```blade
<x-strata::tooltip text="This is a helpful tooltip">
    <x-strata::button>Hover me</x-strata::button>
</x-strata::tooltip>
```

### Rich Content Tooltip

Use the named `content` slot for HTML content:

```blade
<x-strata::tooltip>
    <x-slot:content>
        <div class="space-y-1">
            <div class="font-semibold">Keyboard Shortcut</div>
            <div class="flex gap-1">
                <x-strata::kbd>Ctrl</x-strata::kbd>
                <span>+</span>
                <x-strata::kbd>S</x-strata::kbd>
            </div>
        </div>
    </x-slot:content>

    <x-strata::button>Save</x-strata::button>
</x-strata::tooltip>
```

## Placement

Control tooltip position with the `placement` prop. Supports all Floating UI placements:

```blade
<x-strata::tooltip text="Top placement" placement="top">
    <x-strata::button>Top</x-strata::button>
</x-strata::tooltip>

<x-strata::tooltip text="Right placement" placement="right">
    <x-strata::button>Right</x-strata::button>
</x-strata::tooltip>

<x-strata::tooltip text="Bottom placement" placement="bottom">
    <x-strata::button>Bottom</x-strata::button>
</x-strata::tooltip>

<x-strata::tooltip text="Left placement" placement="left">
    <x-strata::button>Left</x-strata::button>
</x-strata::tooltip>
```

Available placements: `top`, `top-start`, `top-end`, `right`, `right-start`, `right-end`, `bottom`, `bottom-start`, `bottom-end`, `left`, `left-start`, `left-end`.

## Delays

Customize show and hide delays for better UX:

```blade
{{-- No delay (instant) --}}
<x-strata::tooltip text="Instant tooltip" :delay="0">
    <x-strata::button>Instant</x-strata::button>
</x-strata::tooltip>

{{-- Fast delay --}}
<x-strata::tooltip text="Fast tooltip" :delay="100">
    <x-strata::button>Fast</x-strata::button>
</x-strata::tooltip>

{{-- Custom hide delay --}}
<x-strata::tooltip text="Custom delays" :delay="300" :hideDelay="500">
    <x-strata::button>Slow hide</x-strata::button>
</x-strata::tooltip>
```

## Interactive Content

Tooltips support interactive content like links and buttons. When you hover over the tooltip content itself, it stays open:

```blade
<x-strata::tooltip>
    <x-slot:content>
        <div class="space-y-1">
            <div class="font-semibold">Learn More</div>
            <div class="text-xs">
                <a href="https://example.com" target="_blank" class="underline hover:text-primary">
                    View documentation
                </a>
            </div>
        </div>
    </x-slot:content>

    <x-strata::button.icon icon="circle-help" />
</x-strata::tooltip>
```

## On Various Elements

Tooltips work on any element:

```blade
{{-- Icon buttons --}}
<x-strata::tooltip text="Help information">
    <x-strata::button.icon icon="circle-help" />
</x-strata::tooltip>

{{-- Avatars --}}
<x-strata::tooltip text="John Doe">
    <x-strata::avatar src="/avatar.jpg" />
</x-strata::tooltip>

{{-- Badges --}}
<x-strata::tooltip text="Active status">
    <x-strata::badge variant="success">Active</x-strata::badge>
</x-strata::tooltip>

{{-- Keyboard shortcuts --}}
<x-strata::tooltip text="Escape key">
    <x-strata::kbd>Esc</x-strata::kbd>
</x-strata::tooltip>
```

## Accessibility

Tooltips are fully keyboard accessible:

- **Tab navigation**: Focus on an element to show its tooltip
- **Blur**: Tooltip automatically hides when focus leaves
- **Hover**: Shows on mouse enter, hides on mouse leave
- **Interactive content**: Tooltip stays open when hovering over its content

The tooltip wrapper maintains inline-block display to preserve the original element's layout behavior.

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `text` | `string` | `null` | Simple text content for the tooltip (shorthand) |
| `placement` | `string` | `'top'` | Floating UI placement position |
| `offset` | `int` | `8` | Distance from trigger element in pixels |
| `delay` | `int` | `200` | Show delay in milliseconds |
| `hideDelay` | `int` | `100` | Hide delay in milliseconds |

## Slots

| Slot | Description |
|------|-------------|
| Default | The trigger element that shows the tooltip on hover/focus |
| `content` | Named slot for rich HTML content (alternative to `text` prop) |

## Styling

The tooltip component uses semantic Tailwind classes that adapt to your theme:

- Background: `bg-popover`
- Text: `text-popover-foreground`
- Border: `border-border`
- Shadow: `shadow-lg`
- Dark mode compatible with automatic theme switching

You can customize the appearance by extending the component or using Tailwind's configuration.

## Best Practices

1. **Keep it concise**: Tooltips should provide brief, helpful information
2. **Use appropriate delays**: Default delays work well for most cases
3. **Consider placement**: Use placements that don't obscure important UI
4. **Interactive content**: Use for links and actions users might need
5. **Keyboard shortcuts**: Great for displaying keyboard shortcuts with `<x-strata::kbd>`
6. **Icon buttons**: Always add tooltips to icon-only buttons for clarity

## Examples

### Delete Confirmation

```blade
<x-strata::tooltip text="This action cannot be undone" placement="top">
    <x-strata::button variant="destructive">Delete Account</x-strata::button>
</x-strata::tooltip>
```

### Keyboard Shortcut Display

```blade
<x-strata::tooltip placement="right">
    <x-slot:content>
        <div class="space-y-1">
            <div class="font-semibold">Quick Save</div>
            <div class="flex gap-1 text-xs">
                <x-strata::kbd>Ctrl</x-strata::kbd>
                <span>+</span>
                <x-strata::kbd>S</x-strata::kbd>
            </div>
        </div>
    </x-slot:content>

    <x-strata::button>Save Changes</x-strata::button>
</x-strata::tooltip>
```

### Help Icon

```blade
<div class="flex items-center gap-2">
    <label>Complex Setting</label>
    <x-strata::tooltip text="This setting controls the behavior of...">
        <x-strata::button.icon icon="circle-help" variant="ghost" size="sm" />
    </x-strata::tooltip>
</div>
```

### Status Badge with Info

```blade
<x-strata::tooltip>
    <x-slot:content>
        <div class="space-y-1">
            <div class="font-semibold">Active Status</div>
            <div class="text-xs">User is currently online</div>
        </div>
    </x-slot:content>

    <x-strata::badge variant="success">
        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
        Online
    </x-strata::badge>
</x-strata::tooltip>
```
