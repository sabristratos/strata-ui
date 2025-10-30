# Badges

Flexible badge components for labels, status indicators, and tags.

## Basic Usage

```blade
<x-strata::badge>Default</x-strata::badge>
<x-strata::badge variant="success">Active</x-strata::badge>
<x-strata::badge variant="warning">Pending</x-strata::badge>
```

## Variants

Available variants: `primary`, `secondary`, `success`, `warning`, `destructive`, `info` (default: `secondary`)

```blade
<x-strata::badge variant="primary">Primary</x-strata::badge>
<x-strata::badge variant="secondary">Secondary</x-strata::badge>
<x-strata::badge variant="success">Success</x-strata::badge>
<x-strata::badge variant="warning">Warning</x-strata::badge>
<x-strata::badge variant="destructive">Destructive</x-strata::badge>
<x-strata::badge variant="info">Info</x-strata::badge>
```

## Sizes

Available sizes: `sm`, `md` (default), `lg`

```blade
<x-strata::badge size="sm">Small</x-strata::badge>
<x-strata::badge size="md">Medium</x-strata::badge>
<x-strata::badge size="lg">Large</x-strata::badge>
```

## Styles

Available styles: `filled` (default), `outlined`, `soft`

```blade
<x-strata::badge style="filled" variant="success">Filled</x-strata::badge>
<x-strata::badge style="outlined" variant="success">Outlined</x-strata::badge>
<x-strata::badge style="soft" variant="success">Soft</x-strata::badge>
```

## With Icons

Add icons before or after the text:

```blade
{{-- Leading icon --}}
<x-strata::badge icon="check" variant="success">Verified</x-strata::badge>
<x-strata::badge icon="star" variant="warning">Premium</x-strata::badge>

{{-- Trailing icon --}}
<x-strata::badge icon-trailing="arrow-right" variant="primary">Next</x-strata::badge>

{{-- Both icons --}}
<x-strata::badge icon="shield" icon-trailing="chevron-down" variant="info">
    Protected
</x-strata::badge>
```

## Dot Badges

Status indicators with colored dots. The badge itself has no background - only the dot is colored:

```blade
<x-strata::badge.dot variant="success">Online</x-strata::badge.dot>
<x-strata::badge.dot variant="warning">Away</x-strata::badge.dot>
<x-strata::badge.dot variant="danger">Offline</x-strata::badge.dot>
<x-strata::badge.dot variant="info">Processing</x-strata::badge.dot>
```

Perfect for user status, connection states, or live indicators.

## Removable Badges

Tags with remove buttons, ideal for filters or tag management:

```blade
<x-strata::badge.removable variant="primary">Tag 1</x-strata::badge.removable>
<x-strata::badge.removable variant="success" icon="tag">Category</x-strata::badge.removable>
```

### With Livewire

Removable badges work seamlessly with Livewire for interactive tag removal:

```blade
@foreach($tags as $tag)
    <x-strata::badge.removable wire:click="removeTag({{ $tag->id }})">
        {{ $tag->name }}
    </x-strata::badge.removable>
@endforeach
```

## Container Badges

Floating badges that wrap other components, perfect for notification indicators and status dots:

```blade
{{-- Notification count --}}
<x-strata::badge.container badge="5" variant="destructive">
    <x-strata::icon.bell class="w-6 h-6" />
</x-strata::badge.container>

{{-- Online status dot --}}
<x-strata::badge.container dot variant="success" position="bottom-right">
    <img src="avatar.jpg" class="w-10 h-10 rounded-full" />
</x-strata::badge.container>

{{-- New feature indicator --}}
<x-strata::badge.container badge="New" variant="info">
    <x-strata::button>Settings</x-strata::button>
</x-strata::badge.container>
```

### Positions

Container badges support four corner positions:

```blade
<x-strata::badge.container badge="3" position="top-right">...</x-strata::badge.container>
<x-strata::badge.container badge="3" position="top-left">...</x-strata::badge.container>
<x-strata::badge.container badge="3" position="bottom-right">...</x-strata::badge.container>
<x-strata::badge.container badge="3" position="bottom-left">...</x-strata::badge.container>
```

### Dot Mode

Use the `dot` prop to show only a status indicator without text:

```blade
{{-- User online status --}}
<x-strata::badge.container dot variant="success" position="bottom-right">
    <img src="avatar.jpg" class="w-12 h-12 rounded-full" />
</x-strata::badge.container>

{{-- Unread indicator on icon button --}}
<x-strata::badge.container dot variant="warning">
    <x-strata::button.icon icon="mail" variant="secondary" aria-label="Messages" />
</x-strata::badge.container>
```

## Props Reference

### Base Badge

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `secondary` | Color variant |
| `size` | string | `md` | Badge size |
| `style` | string | `filled` | Badge style |
| `icon` | string | `null` | Leading icon name |
| `icon-trailing` | string | `null` | Trailing icon name |

### Dot Badge

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `secondary` | Dot color variant |
| `size` | string | `md` | Badge size |

### Removable Badge

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `secondary` | Color variant |
| `size` | string | `md` | Badge size |
| `style` | string | `filled` | Badge style |
| `icon` | string | `null` | Leading icon name |

### Container Badge

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `badge` | string\|number | `null` | Badge text or number |
| `dot` | boolean | `false` | Show as dot only (no text) |
| `variant` | string | `destructive` | Color variant |
| `position` | string | `top-right` | Position (`top-right`, `top-left`, `bottom-right`, `bottom-left`) |
| `size` | string | `sm` | Badge/dot size |

## Examples

### Status Labels

```blade
<x-strata::badge variant="success">Published</x-strata::badge>
<x-strata::badge variant="warning">Draft</x-strata::badge>
<x-strata::badge variant="destructive">Archived</x-strata::badge>
```

### User Roles

```blade
<x-strata::badge icon="shield" variant="primary">Admin</x-strata::badge>
<x-strata::badge icon="user" variant="secondary">Member</x-strata::badge>
```

### Notifications

```blade
<button class="relative">
    <x-strata::icon.bell class="w-5 h-5" />
    <x-strata::badge size="sm" variant="destructive" class="absolute -top-1 -right-1">
        3
    </x-strata::badge>
</button>
```

### Online Status

```blade
<div class="flex items-center gap-3">
    <img src="avatar.jpg" class="w-10 h-10 rounded-full" />
    <div>
        <div class="font-medium">John Doe</div>
        <x-strata::badge.dot variant="success" size="sm">Online</x-strata::badge.dot>
    </div>
</div>
```
