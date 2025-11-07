# Popover

Flexible popover component built with the native Popover API and CSS Anchor Positioning. Features automatic positioning with intelligent fallbacks, full keyboard navigation, and seamless Livewire integration. Perfect for contextual menus, user profiles, and interactive panels.

## Props

### Popover

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `placement` | string | `bottom-start` | `top`, `top-start`, `top-end`, `bottom`, `bottom-start`, `bottom-end`, `left`, `left-start`, `left-end`, `right`, `right-start`, `right-end` | Position relative to trigger |
| `size` | string | `md` | `sm`, `md`, `lg` | Popover width |
| `offset` | number | `8` | Any number | Distance from trigger in pixels |

### Popover Trigger

No props required. The trigger uses Alpine's `x-id()` to automatically generate unique IDs.

**Note:** The trigger accepts any element as a child (buttons, avatars, badges, icons, or custom elements).

### Popover Content

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `padding` | string | `normal` | `none`, `sm`, `normal`, `lg` | Content padding size |

## Example

```blade
{{-- Basic popover --}}
<x-strata::popover placement="bottom-start">
    <x-strata::popover.trigger>
        <x-strata::button>Open Menu</x-strata::button>
    </x-strata::popover.trigger>
    <x-strata::popover.content>
        <p>Popover content goes here</p>
    </x-strata::popover.content>
</x-strata::popover>

{{-- User profile popover --}}
<x-strata::popover placement="bottom-end" size="md">
    <x-strata::popover.trigger>
        <x-strata::avatar name="John Doe" />
    </x-strata::popover.trigger>
    <x-strata::popover.content padding="sm">
        <div class="space-y-2">
            <p class="font-semibold">John Doe</p>
            <p class="text-sm text-muted-foreground">john@example.com</p>
            <x-strata::button size="sm" class="w-full">View Profile</x-strata::button>
        </div>
    </x-strata::popover.content>
</x-strata::popover>

{{-- Context menu with custom trigger --}}
<x-strata::popover placement="bottom-start" size="sm">
    <x-strata::popover.trigger>
        <x-strata::button.icon icon="more-vertical" variant="secondary" aria-label="Options" />
    </x-strata::popover.trigger>
    <x-strata::popover.content padding="none">
        <div class="py-1">
            <button @click="$closePopover()" class="w-full text-left px-4 py-2 hover:bg-accent">Edit</button>
            <button @click="$closePopover()" class="w-full text-left px-4 py-2 hover:bg-accent">Duplicate</button>
            <button @click="$closePopover()" class="w-full text-left px-4 py-2 hover:bg-accent text-destructive">Delete</button>
        </div>
    </x-strata::popover.content>
</x-strata::popover>
```

## Livewire Integration

Popovers work seamlessly with Livewire for dynamic content and form submissions:

```blade
{{-- Component: app/Livewire/NotificationPanel.php --}}
public $notifications = [];
public $unreadCount = 0;

public function markAsRead($notificationId)
{
    // Handle notification read...
    $this->unreadCount--;
}
```

```blade
{{-- View: resources/views/livewire/notification-panel.blade.php --}}
<x-strata::popover placement="bottom-end" size="lg">
    <x-strata::popover.trigger>
        <x-strata::button variant="secondary" appearance="ghost" icon="bell">
            @if($unreadCount > 0)
                <x-strata::badge variant="destructive" size="sm">{{ $unreadCount }}</x-strata::badge>
            @endif
        </x-strata::button>
    </x-strata::popover.trigger>
    <x-strata::popover.content padding="none">
        <div class="py-2">
            <div class="px-4 py-2 border-b">
                <h3 class="font-semibold">Notifications</h3>
            </div>
            <div class="divide-y max-h-80 overflow-y-auto">
                @forelse($notifications as $notification)
                    <button
                        wire:click="markAsRead({{ $notification['id'] }})"
                        @click="$closePopover()"
                        class="w-full px-4 py-3 text-left hover:bg-accent transition-colors"
                    >
                        <p class="font-medium text-sm">{{ $notification['text'] }}</p>
                        <p class="text-xs text-muted-foreground mt-1">{{ $notification['time'] }}</p>
                    </button>
                @empty
                    <div class="px-4 py-8 text-center text-muted-foreground">
                        No notifications
                    </div>
                @endforelse
            </div>
        </div>
    </x-strata::popover.content>
</x-strata::popover>
```

## Placement Options

All 12 placement options with automatic viewport-aware positioning using CSS Anchor Positioning with intelligent fallbacks:

```blade
{{-- Edge placements --}}
<x-strata::popover placement="top">...</x-strata::popover>
<x-strata::popover placement="bottom">...</x-strata::popover>
<x-strata::popover placement="left">...</x-strata::popover>
<x-strata::popover placement="right">...</x-strata::popover>

{{-- Corner placements (aligned) --}}
<x-strata::popover placement="top-start">...</x-strata::popover>
<x-strata::popover placement="top-end">...</x-strata::popover>
<x-strata::popover placement="bottom-start">...</x-strata::popover>
<x-strata::popover placement="bottom-end">...</x-strata::popover>
<x-strata::popover placement="left-start">...</x-strata::popover>
<x-strata::popover placement="left-end">...</x-strata::popover>
<x-strata::popover placement="right-start">...</x-strata::popover>
<x-strata::popover placement="right-end">...</x-strata::popover>
```

## Flexible Triggers

The trigger accepts any element as a child:

```blade
{{-- Button trigger --}}
<x-strata::popover.trigger>
    <x-strata::button variant="primary">Open</x-strata::button>
</x-strata::popover.trigger>

{{-- Icon button trigger --}}
<x-strata::popover.trigger>
    <x-strata::button.icon icon="help-circle" aria-label="Help" />
</x-strata::popover.trigger>

{{-- Avatar trigger --}}
<x-strata::popover.trigger>
    <x-strata::avatar name="Jane Smith" />
</x-strata::popover.trigger>

{{-- Badge trigger --}}
<x-strata::popover.trigger>
    <x-strata::badge variant="destructive">3 New</x-strata::badge>
</x-strata::popover.trigger>

{{-- Custom element trigger --}}
<x-strata::popover.trigger>
    <div class="px-3 py-2 rounded hover:bg-accent cursor-pointer">
        Custom Trigger
    </div>
</x-strata::popover.trigger>
```

## Keyboard Navigation

Full keyboard support for accessibility and navigation:

| Key | Action |
|-----|--------|
| `↑` `↓` | Navigate through items |
| `Home` / `End` | Jump to first/last item |
| `Enter` / `Space` | Activate highlighted item |
| `Escape` / `Tab` | Close popover |

### Navigable Items

Use `<x-strata::popover.item>` for menu-style popovers with keyboard navigation:

```blade
<x-strata::popover placement="bottom-start">
    <x-strata::popover.trigger>
        <x-strata::button>Actions</x-strata::button>
    </x-strata::popover.trigger>
    <x-strata::popover.content padding="sm">
        <x-strata::popover.item icon="edit" @click="$closePopover()">Edit</x-strata::popover.item>
        <x-strata::popover.item icon="copy" @click="$closePopover()">Duplicate</x-strata::popover.item>
        <x-strata::popover.item icon="archive" @click="$closePopover()">Archive</x-strata::popover.item>
        <x-strata::popover.item icon="trash" destructive @click="$closePopover()">Delete</x-strata::popover.item>
    </x-strata::popover.content>
</x-strata::popover>
```

**Item Props:**
- `icon` - Leading icon name
- `iconTrailing` - Trailing icon name
- `disabled` - Disable item (boolean)
- `destructive` - Apply destructive styling (boolean)
- `href` - Link URL (converts to anchor tag)

## Technical Implementation

The popover component leverages modern web standards for optimal performance and accessibility:

- **Native Popover API:** Uses the browser's native popover functionality
  - Auto-dismiss on outside click
  - Escape key closes automatically
  - Top layer rendering (no z-index conflicts)
  - Proper focus management
  - Light dismiss behavior

- **CSS Anchor Positioning:** Positioning handled by CSS Anchor Positioning specification
  - Automatic fallback positioning with `@position-try` rules
  - Intelligent repositioning when viewport space is limited
  - Configurable placement (12 placement options)
  - Configurable offset distance
  - No JavaScript positioning calculations
  - Dynamic anchor-name generation using Alpine's `x-id()` for unique instances
  - Global fallback positioning via `data-placement` attribute

- **Keyboard Navigation:** Full keyboard support for navigable items
  - Arrow keys for navigation
  - Home/End for first/last item
  - Enter/Space to activate items
  - Escape/Tab to close
  - ARIA activedescendant pattern for screen readers

- **Livewire Integration:** Proper state management and morph handling
  - `x-modelable="open"` for two-way binding
  - wire:ignore.self prevents morph issues
  - Full wire:click and wire:model support

- **Alpine.js Magic Helpers:** Global helpers for common operations
  - `$closePopover()` - Close nearest popover from any element inside
  - `$closeDropdown()` - Close nearest dropdown
  - `$closeModal()` - Close nearest modal/dialog

## Notes

- **No ID required:** Popover automatically generates unique IDs using Alpine's `x-id()`
- **Light dismiss:** Clicking outside or pressing Escape automatically closes the popover
- **Automatic positioning:** Popover repositions intelligently using CSS fallbacks if it would overflow the viewport
- **Focus trap:** Focus remains within popover when open (x-trap.nofocus)
- **Smooth animations:** Uses CSS `@starting-style` for fade/scale transitions
- **Livewire compatible:** Use `wire:ignore.self` on content for proper DOM morphing
- **Keyboard navigation:** Arrow keys navigate items, Enter/Space activates, Home/End jump to first/last
- **Free-form content:** Popovers without items still work normally (no keyboard navigation)
- **Size variants:** Content width controlled by `size` prop (sm: min-w-48, md: min-w-64, lg: min-w-80)
- **Alpine magic helpers:** Use `$closePopover()` inside popover content to close from any button/link
