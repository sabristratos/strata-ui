# Popover

Flexible popover component with automatic positioning, multiple placements, and seamless Livewire integration. Perfect for contextual menus, user profiles, and interactive panels.

## Props

### Popover

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `id` | string | **required** | Any string | Unique identifier (must match trigger's `target`) |
| `placement` | string | `bottom-start` | `top`, `top-start`, `top-end`, `bottom`, `bottom-start`, `bottom-end`, `left`, `left-start`, `left-end`, `right`, `right-start`, `right-end` | Position relative to trigger |
| `size` | string | `md` | `sm`, `md`, `lg` | Popover width |
| `offset` | number | `8` | Any number | Distance from trigger in pixels |

### Popover Trigger

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `target` | string | **required** | ID of the popover to control |

**Note:** The trigger accepts any element as a child (buttons, avatars, badges, icons, or custom elements).

### Popover Content

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `padding` | string | `normal` | `none`, `sm`, `normal`, `lg` | Content padding size |

## Example

```blade
{{-- Basic popover --}}
<x-strata::popover id="basic-menu" placement="bottom-start">
    <x-strata::popover.trigger target="basic-menu">
        <x-strata::button>Open Menu</x-strata::button>
    </x-strata::popover.trigger>
    <x-strata::popover.content>
        <p>Popover content goes here</p>
    </x-strata::popover.content>
</x-strata::popover>

{{-- User profile popover --}}
<x-strata::popover id="user-profile" placement="bottom-end" size="md">
    <x-strata::popover.trigger target="user-profile">
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
<x-strata::popover id="context-menu" placement="bottom-start" size="sm">
    <x-strata::popover.trigger target="context-menu">
        <x-strata::button.icon icon="more-vertical" variant="secondary" aria-label="Options" />
    </x-strata::popover.trigger>
    <x-strata::popover.content padding="none">
        <div class="py-1">
            <button class="w-full text-left px-4 py-2 hover:bg-accent">Edit</button>
            <button class="w-full text-left px-4 py-2 hover:bg-accent">Duplicate</button>
            <button class="w-full text-left px-4 py-2 hover:bg-accent text-destructive">Delete</button>
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
<x-strata::popover id="notifications" placement="bottom-end" size="lg">
    <x-strata::popover.trigger target="notifications">
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

All 12 placement options with automatic viewport-aware positioning:

```blade
{{-- Edge placements --}}
<x-strata::popover id="top" placement="top">...</x-strata::popover>
<x-strata::popover id="bottom" placement="bottom">...</x-strata::popover>
<x-strata::popover id="left" placement="left">...</x-strata::popover>
<x-strata::popover id="right" placement="right">...</x-strata::popover>

{{-- Corner placements (aligned) --}}
<x-strata::popover id="top-start" placement="top-start">...</x-strata::popover>
<x-strata::popover id="top-end" placement="top-end">...</x-strata::popover>
<x-strata::popover id="bottom-start" placement="bottom-start">...</x-strata::popover>
<x-strata::popover id="bottom-end" placement="bottom-end">...</x-strata::popover>
<x-strata::popover id="left-start" placement="left-start">...</x-strata::popover>
<x-strata::popover id="left-end" placement="left-end">...</x-strata::popover>
<x-strata::popover id="right-start" placement="right-start">...</x-strata::popover>
<x-strata::popover id="right-end" placement="right-end">...</x-strata::popover>
```

## Flexible Triggers

The trigger accepts any element as a child:

```blade
{{-- Button trigger --}}
<x-strata::popover.trigger target="menu">
    <x-strata::button variant="primary">Open</x-strata::button>
</x-strata::popover.trigger>

{{-- Icon button trigger --}}
<x-strata::popover.trigger target="help">
    <x-strata::button.icon icon="help-circle" aria-label="Help" />
</x-strata::popover.trigger>

{{-- Avatar trigger --}}
<x-strata::popover.trigger target="profile">
    <x-strata::avatar name="Jane Smith" />
</x-strata::popover.trigger>

{{-- Badge trigger --}}
<x-strata::popover.trigger target="notifications">
    <x-strata::badge variant="destructive">3 New</x-strata::badge>
</x-strata::popover.trigger>

{{-- Custom element trigger --}}
<x-strata::popover.trigger target="custom">
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
<x-strata::popover id="actions-menu" placement="bottom-start">
    <x-strata::popover.trigger target="actions-menu">
        <x-strata::button>Actions</x-strata::button>
    </x-strata::popover.trigger>
    <x-strata::popover.content padding="sm">
        <x-strata::popover.item icon="edit">Edit</x-strata::popover.item>
        <x-strata::popover.item icon="copy">Duplicate</x-strata::popover.item>
        <x-strata::popover.item icon="archive">Archive</x-strata::popover.item>
        <x-strata::popover.item icon="trash" destructive>Delete</x-strata::popover.item>
    </x-strata::popover.content>
</x-strata::popover>
```

**Item Props:**
- `icon` - Leading icon name
- `iconTrailing` - Trailing icon name
- `disabled` - Disable item (boolean)
- `destructive` - Apply destructive styling (boolean)
- `href` - Link URL (converts to anchor tag)

## Notes

- **Required ID:** Popover `id` must match trigger's `target` prop
- **Light dismiss:** Clicking outside or pressing Escape automatically closes the popover
- **Automatic positioning:** Popover repositions if it would overflow the viewport
- **Focus trap:** Focus remains within popover when open (x-trap.nofocus)
- **Smooth animations:** Uses CSS `@starting-style` for fade/scale transitions
- **Livewire compatible:** Use `wire:ignore.self` on content for proper DOM morphing
- **Keyboard navigation:** Arrow keys navigate items, Enter/Space activates, Home/End jump to first/last
- **Free-form content:** Popovers without items still work normally (no keyboard navigation)
- **Size variants:** Content width controlled by `size` prop (sm: min-w-48, md: min-w-64, lg: min-w-80)
