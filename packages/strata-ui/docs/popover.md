# Popover

Flexible popover components using the native Popover API with CSS anchor positioning. Perfect for tooltips, dropdown menus, context menus, and floating action panels.

## Technical Implementation

The popover component uses the native [Popover API](https://developer.mozilla.org/en-US/docs/Web/API/Popover_API) combined with [CSS anchor positioning](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_anchor_positioning) for automatic positioning and fallback behavior.

**Key Features:**
- Native browser API with polyfill support for older browsers
- Automatic viewport-aware positioning with fallback
- Smooth animations using `@starting-style` and CSS transitions
- Light dismiss behavior (auto) or explicit control (manual)
- Full keyboard navigation support (Escape to close)

**Browser Support:**
- Modern browsers (Chrome 125+) with native support
- Older browsers supported via `@oddbird/css-anchor-positioning` polyfill
- Polyfill automatically loaded and initialized

**For developers**: See [CSS Anchor Positioning Guide](./css-anchor-positioning.md) for technical implementation details, troubleshooting, and best practices.

## Basic Usage

```blade
<x-strata::popover.trigger target="basic-popover">
    <x-strata::button>Open Popover</x-strata::button>
</x-strata::popover.trigger>

<x-strata::popover id="basic-popover">
    <x-strata::popover.content>
        <p>This is a basic popover with some content.</p>
    </x-strata::popover.content>
</x-strata::popover>
```

**Note**: The trigger component accepts any element as a child. You can use buttons, avatars, badges, icons, or any custom element as the trigger.

## Placement Options

The popover automatically positions itself relative to the trigger using CSS anchor positioning. Available placements: `top`, `top-start`, `top-end`, `bottom` (default), `bottom-start`, `bottom-end`, `left`, `left-start`, `left-end`, `right`, `right-start`, `right-end`

```blade
{{-- Bottom (default) --}}
<x-strata::popover.trigger target="bottom-popover">
    <x-strata::button>Bottom</x-strata::button>
</x-strata::popover.trigger>
<x-strata::popover id="bottom-popover" placement="bottom">
    <x-strata::popover.content>Positioned below the trigger</x-strata::popover.content>
</x-strata::popover>

{{-- Top --}}
<x-strata::popover.trigger target="top-popover">
    <x-strata::button>Top</x-strata::button>
</x-strata::popover.trigger>
<x-strata::popover id="top-popover" placement="top">
    <x-strata::popover.content>Positioned above the trigger</x-strata::popover.content>
</x-strata::popover>

{{-- Left --}}
<x-strata::popover.trigger target="left-popover">
    <x-strata::button>Left</x-strata::button>
</x-strata::popover.trigger>
<x-strata::popover id="left-popover" placement="left">
    <x-strata::popover.content>Positioned to the left</x-strata::popover.content>
</x-strata::popover>

{{-- Right --}}
<x-strata::popover.trigger target="right-popover">
    <x-strata::button>Right</x-strata::button>
</x-strata::popover.trigger>
<x-strata::popover id="right-popover" placement="right">
    <x-strata::popover.content>Positioned to the right</x-strata::popover.content>
</x-strata::popover>
```

### Aligned Placements

Use `-start` and `-end` suffixes for aligned positioning:

```blade
{{-- Top Start (left-aligned to trigger) --}}
<x-strata::popover id="top-start-popover" placement="top-start">
    <x-strata::popover.content>Aligned to the left edge</x-strata::popover.content>
</x-strata::popover>

{{-- Bottom End (right-aligned to trigger) --}}
<x-strata::popover id="bottom-end-popover" placement="bottom-end">
    <x-strata::popover.content>Aligned to the right edge</x-strata::popover.content>
</x-strata::popover>
```

## Popover Types

### Auto Popover (Default)

Auto popovers close when clicking outside, pressing Escape, or when another popover opens:

```blade
<x-strata::popover.trigger target="auto-popover">
    Auto Popover
</x-strata::popover.trigger>

<x-strata::popover id="auto-popover" type="auto">
    <x-strata::popover.content>
        <p>Click outside or press Escape to close.</p>
    </x-strata::popover.content>
</x-strata::popover>
```

### Manual Popover

Manual popovers must be explicitly closed. Multiple manual popovers can be open simultaneously:

```blade
<x-strata::popover.trigger target="manual-popover">
    Manual Popover
</x-strata::popover.trigger>

<x-strata::popover id="manual-popover" type="manual">
    <x-strata::popover.content>
        <p>This won't close automatically.</p>
        <x-strata::popover.trigger target="manual-popover" action="hide" variant="secondary" size="sm">
            Close
        </x-strata::popover.trigger>
    </x-strata::popover.content>
</x-strata::popover>
```

## Size Options

Available sizes: `sm`, `md` (default), `lg`

```blade
{{-- Small --}}
<x-strata::popover id="small-popover" size="sm">
    <x-strata::popover.content>
        <p>Small popover content</p>
    </x-strata::popover.content>
</x-strata::popover>

{{-- Medium (default) --}}
<x-strata::popover id="medium-popover" size="md">
    <x-strata::popover.content>
        <p>Medium popover content</p>
    </x-strata::popover.content>
</x-strata::popover>

{{-- Large --}}
<x-strata::popover id="large-popover" size="lg">
    <x-strata::popover.content>
        <p>Large popover with more content space</p>
    </x-strata::popover.content>
</x-strata::popover>
```

## Popover Trigger

The trigger component is a flexible slot-based wrapper that accepts **any element** as a trigger. It uses the JavaScript Popover API to wire up trigger functionality automatically.

### Trigger Actions

Control how the trigger interacts with the popover:

```blade
{{-- Toggle (default) - Opens and closes --}}
<x-strata::popover.trigger target="my-popover" action="toggle">
    <x-strata::button>Toggle</x-strata::button>
</x-strata::popover.trigger>

{{-- Show only - Opens the popover --}}
<x-strata::popover.trigger target="my-popover" action="show">
    <x-strata::button>Open</x-strata::button>
</x-strata::popover.trigger>

{{-- Hide only - Closes the popover --}}
<x-strata::popover.trigger target="my-popover" action="hide">
    <x-strata::button>Close</x-strata::button>
</x-strata::popover.trigger>
```

### Button Triggers

Use any button variant as a trigger:

```blade
<x-strata::popover.trigger target="styled-popover">
    <x-strata::button
        variant="success"
        appearance="outlined"
        size="lg"
        icon="plus"
    >
        Create New
    </x-strata::button>
</x-strata::popover.trigger>
```

### Flexible Trigger Elements

The trigger accepts **any element**, not just buttons:

```blade
{{-- Avatar trigger --}}
<x-strata::popover.trigger target="user-menu">
    <x-strata::avatar name="John Doe" />
</x-strata::popover.trigger>

{{-- Badge trigger --}}
<x-strata::popover.trigger target="notifications">
    <x-strata::badge variant="destructive">3</x-strata::badge>
</x-strata::popover.trigger>

{{-- Icon trigger --}}
<x-strata::popover.trigger target="help">
    <x-strata::icon.help-circle class="w-6 h-6" />
</x-strata::popover.trigger>

{{-- Custom element --}}
<x-strata::popover.trigger target="custom">
    <div class="p-2 rounded hover:bg-muted cursor-pointer">
        Custom Trigger
    </div>
</x-strata::popover.trigger>
```

**How it works**: The trigger component uses Alpine.js to automatically configure the child element using the JavaScript Popover API's `popoverTargetElement` and `popoverTargetAction` properties.

## Popover Content

The content component provides consistent padding for popover contents.

### Padding Options

Available padding options: `none`, `sm`, `normal` (default), `lg`

```blade
<x-strata::popover id="content-popover">
    {{-- No padding for custom layouts --}}
    <x-strata::popover.content padding="none">
        <img src="/image.jpg" alt="Full width image" class="w-full">
        <div class="p-4">
            <p>Image with custom padding</p>
        </div>
    </x-strata::popover.content>
</x-strata::popover>

<x-strata::popover id="large-padding-popover">
    {{-- Large padding --}}
    <x-strata::popover.content padding="lg">
        <p>Spacious content area</p>
    </x-strata::popover.content>
</x-strata::popover>
```

### Custom Content

You can skip the content wrapper for complete control:

```blade
<x-strata::popover id="custom-content-popover">
    <div class="divide-y">
        <div class="p-4">
            <h3 class="font-semibold mb-2">Menu</h3>
        </div>
        <div class="p-2">
            <button class="w-full text-left px-3 py-2 hover:bg-muted rounded">Item 1</button>
            <button class="w-full text-left px-3 py-2 hover:bg-muted rounded">Item 2</button>
        </div>
    </div>
</x-strata::popover>
```

## Nested Popovers

Popovers can be nested within each other:

```blade
<x-strata::popover.trigger target="parent-popover">
    Open Parent
</x-strata::popover.trigger>

<x-strata::popover id="parent-popover">
    <x-strata::popover.content>
        <p class="mb-3">Parent popover content</p>

        <x-strata::popover.trigger target="child-popover" variant="secondary" size="sm">
            Open Child
        </x-strata::popover.trigger>

        <x-strata::popover id="child-popover" placement="right">
            <x-strata::popover.content>
                <p>Nested popover content</p>
            </x-strata::popover.content>
        </x-strata::popover>
    </x-strata::popover.content>
</x-strata::popover>
```

## Automatic Fallback Positioning

The popover intelligently adjusts its position if it would overflow the viewport, using CSS `position-try-fallbacks`. This ensures the popover remains visible and accessible regardless of the trigger's position on screen.

**How it works:**
- Each placement has predefined fallback positions
- The browser (or polyfill) automatically selects the first fallback that fits
- Transitions are smooth thanks to CSS animations
- No JavaScript required for repositioning logic

**Example fallback chain:**
- `bottom` → tries `top`, then `left`, then `right`
- `top-start` → tries `bottom-start`, then `top-end`, then `bottom-end`
- `right` → tries `left`, then `top`, then `bottom`

**Testing fallback behavior:**
- Scroll the trigger near viewport edges
- Resize the browser window to constrain space
- The popover will automatically reposition to stay visible

**Technical details**: The implementation uses CSS `anchor()` functions and `@position-try` rules. See [CSS Anchor Positioning Guide](./css-anchor-positioning.md) for complete technical documentation.

## Offset Control

Control the spacing between the popover and its trigger using the `offset` prop.

**Default offset (8px)**:
```blade
<x-strata::popover id="default" placement="bottom">
    <x-strata::popover.content>
        8px spacing from trigger
    </x-strata::popover.content>
</x-strata::popover>
```

**No offset (flush with trigger)**:
```blade
<x-strata::popover id="flush" placement="bottom" offset="0">
    <x-strata::popover.content>
        No spacing - flush with trigger
    </x-strata::popover.content>
</x-strata::popover>
```

**Custom offset (pixels)**:
```blade
<x-strata::popover id="large-gap" placement="bottom" offset="20">
    <x-strata::popover.content>
        20px spacing from trigger
    </x-strata::popover.content>
</x-strata::popover>
```

**Custom offset (rem units)**:
```blade
<x-strata::popover id="rem-gap" placement="bottom" offset="1rem">
    <x-strata::popover.content>
        1rem spacing from trigger
    </x-strata::popover.content>
</x-strata::popover>
```

**Note**: The offset applies to all placements and fallback positions automatically. When overflow occurs and the popover repositions, it maintains the specified offset in the new position.

## Props Reference

### Popover

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | string | **required** | Unique identifier for the popover (must match trigger's `target`) |
| `type` | string | `auto` | Popover type: `auto` (light dismiss) or `manual` (explicit close) |
| `placement` | string | `bottom` | Position relative to trigger: `top`, `top-start`, `top-end`, `bottom`, `bottom-start`, `bottom-end`, `left`, `left-start`, `left-end`, `right`, `right-start`, `right-end` |
| `size` | string | `md` | Popover size: `sm`, `md`, `lg` |
| `offset` | string\|number | `8` | Distance between popover and trigger. Accepts numeric values (converted to px) or string values with units (e.g., `1rem`) |

### Popover Trigger

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `target` | string | **required** | ID of the popover to control |
| `action` | string | `toggle` | Action to perform: `toggle`, `show`, `hide` |

**Note**: The trigger component is a slot-based wrapper. It accepts any element as a child and automatically configures it to trigger the popover. Style and configure the child element directly (e.g., button variants, avatar sizes, badge colors, etc.).

### Popover Content

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `padding` | string | `normal` | Padding size: `none`, `sm`, `normal`, `lg` |

## Real-World Examples

### Dropdown Menu

```blade
<x-strata::popover.trigger target="menu-popover" icon="menu">
    Menu
</x-strata::popover.trigger>

<x-strata::popover id="menu-popover" placement="bottom-start" size="sm">
    <div class="py-1">
        <button class="w-full text-left px-4 py-2 hover:bg-muted transition-colors flex items-center gap-2">
            <x-strata::icon.user class="w-4 h-4" />
            Profile
        </button>
        <button class="w-full text-left px-4 py-2 hover:bg-muted transition-colors flex items-center gap-2">
            <x-strata::icon.settings class="w-4 h-4" />
            Settings
        </button>
        <div class="border-t my-1"></div>
        <button class="w-full text-left px-4 py-2 hover:bg-muted transition-colors flex items-center gap-2 text-destructive">
            <x-strata::icon.log-out class="w-4 h-4" />
            Logout
        </button>
    </div>
</x-strata::popover>
```

### User Info Card

```blade
<x-strata::popover.trigger target="user-info" appearance="ghost" size="sm">
    <x-strata::avatar name="John Doe" size="sm" />
</x-strata::popover.trigger>

<x-strata::popover id="user-info" placement="bottom-end">
    <x-strata::popover.content>
        <div class="flex items-center gap-3 mb-3">
            <x-strata::avatar name="John Doe" size="lg" />
            <div>
                <p class="font-semibold">John Doe</p>
                <p class="text-sm text-muted-foreground">john@example.com</p>
            </div>
        </div>
        <div class="space-y-2">
            <x-strata::button variant="secondary" appearance="outlined" size="sm" class="w-full">
                View Profile
            </x-strata::button>
            <x-strata::button variant="destructive" appearance="ghost" size="sm" class="w-full">
                Sign Out
            </x-strata::button>
        </div>
    </x-strata::popover.content>
</x-strata::popover>
```

### Confirmation Dialog

```blade
<x-strata::popover.trigger target="delete-confirm" variant="destructive" icon="trash-2">
    Delete
</x-strata::popover.trigger>

<x-strata::popover id="delete-confirm" type="manual">
    <x-strata::popover.content>
        <div class="space-y-3">
            <div>
                <h3 class="font-semibold mb-1">Delete Item?</h3>
                <p class="text-sm text-muted-foreground">
                    This action cannot be undone.
                </p>
            </div>
            <div class="flex gap-2">
                <x-strata::popover.trigger
                    target="delete-confirm"
                    action="hide"
                    variant="secondary"
                    appearance="outlined"
                    size="sm"
                    class="flex-1"
                >
                    Cancel
                </x-strata::popover.trigger>
                <x-strata::button variant="destructive" size="sm" class="flex-1">
                    Delete
                </x-strata::button>
            </div>
        </div>
    </x-strata::popover.content>
</x-strata::popover>
```

### Color Picker

```blade
<x-strata::popover.trigger target="color-picker" icon="palette">
    Choose Color
</x-strata::popover.trigger>

<x-strata::popover id="color-picker" size="sm">
    <x-strata::popover.content padding="sm">
        <div class="grid grid-cols-5 gap-2">
            @foreach(['red', 'orange', 'yellow', 'green', 'blue', 'purple', 'pink', 'gray', 'black', 'white'] as $color)
                <button
                    class="w-8 h-8 rounded border-2 border-border hover:scale-110 transition-transform"
                    style="background-color: {{ $color }}"
                    aria-label="{{ $color }}"
                ></button>
            @endforeach
        </div>
    </x-strata::popover.content>
</x-strata::popover>
```

### Notification Panel

```blade
<x-strata::popover.trigger target="notifications" icon="bell" appearance="ghost">
    Notifications
    <x-strata::badge variant="destructive" size="sm" class="absolute -top-1 -right-1">3</x-strata::badge>
</x-strata::popover.trigger>

<x-strata::popover id="notifications" placement="bottom-end" size="lg">
    <div class="py-2">
        <div class="px-4 py-2 border-b">
            <h3 class="font-semibold">Notifications</h3>
        </div>
        <div class="divide-y max-h-80 overflow-y-auto">
            <div class="px-4 py-3 hover:bg-muted transition-colors cursor-pointer">
                <p class="font-medium text-sm">New message from Sarah</p>
                <p class="text-xs text-muted-foreground mt-1">2 minutes ago</p>
            </div>
            <div class="px-4 py-3 hover:bg-muted transition-colors cursor-pointer">
                <p class="font-medium text-sm">Your report is ready</p>
                <p class="text-xs text-muted-foreground mt-1">1 hour ago</p>
            </div>
            <div class="px-4 py-3 hover:bg-muted transition-colors cursor-pointer">
                <p class="font-medium text-sm">System update completed</p>
                <p class="text-xs text-muted-foreground mt-1">3 hours ago</p>
            </div>
        </div>
        <div class="px-4 py-2 border-t">
            <x-strata::button variant="secondary" appearance="ghost" size="sm" class="w-full">
                View All
            </x-strata::button>
        </div>
    </div>
</x-strata::popover>
```

### Context Menu

```blade
<div class="relative">
    <img src="/image.jpg" alt="Right-click me" class="rounded-lg">

    <x-strata::button
        popovertarget="context-menu"
        class="absolute top-2 right-2"
        icon="more-vertical"
        variant="secondary"
        size="sm"
    />
</div>

<x-strata::popover id="context-menu" placement="bottom-end" size="sm">
    <div class="py-1">
        <button class="w-full text-left px-4 py-2 hover:bg-muted transition-colors flex items-center gap-2">
            <x-strata::icon.download class="w-4 h-4" />
            Download
        </button>
        <button class="w-full text-left px-4 py-2 hover:bg-muted transition-colors flex items-center gap-2">
            <x-strata::icon.share-2 class="w-4 h-4" />
            Share
        </button>
        <button class="w-full text-left px-4 py-2 hover:bg-muted transition-colors flex items-center gap-2">
            <x-strata::icon.copy class="w-4 h-4" />
            Copy Link
        </button>
        <div class="border-t my-1"></div>
        <button class="w-full text-left px-4 py-2 hover:bg-muted transition-colors flex items-center gap-2 text-destructive">
            <x-strata::icon.trash-2 class="w-4 h-4" />
            Delete
        </button>
    </div>
</x-strata::popover>
```

## Browser Compatibility

### Native Support
- **Chrome/Edge 125+**: Basic anchor positioning
- **Chrome/Edge 128+**: Added `position-try-fallbacks` for automatic repositioning
- **Chrome/Edge 129+**: Added `position-area` property
- **Safari/Firefox**: Limited support (polyfill required)

### Polyfill Support
The `@oddbird/css-anchor-positioning` polyfill provides full functionality in older browsers:
- Automatically loaded and initialized by Strata UI
- No additional configuration required
- Works in all modern browsers (Chrome 90+, Safari 14+, Firefox 88+)

**Performance note**: The polyfill adds ~116KB to the JavaScript bundle. Once browser support reaches ~95% (estimated 2026-2027), the polyfill can be conditionally loaded or removed entirely.

## Implementation Notes

### For Component Users
- Popovers work out of the box with automatic positioning
- No JavaScript or Alpine.js knowledge required
- Focus on content and styling, positioning is handled automatically

### For Developers

**Architecture:**
- Uses native Popover API for dismiss behavior and accessibility
- CSS anchor positioning for automatic layout calculation
- `@starting-style` for smooth entry/exit animations
- Explicit inset properties required for polyfill compatibility

**Key Technical Decisions:**
1. **anchor() functions over position-area**: More reliable with polyfill
2. **Explicit inset properties**: Required for fallback positioning to work
3. **Named @position-try rules**: Fallbacks need complete positioning specifications
4. **Polyfill invocation**: Must explicitly call `polyfill()` after import

**Common Issues:**
- Popover not anchoring → Check `anchor-name` and `position-anchor` match
- Fallback breaks positioning → Ensure all four inset properties are explicit
- Style attribute not rendering → Check for component prop name conflicts

**Full technical documentation**: See [CSS Anchor Positioning Guide](./css-anchor-positioning.md) for:
- Complete implementation details
- Troubleshooting guide
- Polyfill limitations and workarounds
- Best practices for floating UI components

## Related Components

- [Button](./buttons.md) - Popover triggers extend button component
- [Card](./card.md) - Use cards inside popovers for structured content
- [Badge](./badge.md) - Notification indicators on triggers
- [Avatar](./avatar.md) - User avatars in profile popovers

## Future Enhancements

Planned improvements as browser support evolves:
- Conditional polyfill loading for smaller bundle size
- Native `position-area` syntax when widely supported
- Additional animation options
- Touch gesture support for mobile
- Tooltip-specific variant with hover triggers
