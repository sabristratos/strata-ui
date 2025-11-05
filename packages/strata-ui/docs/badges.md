# Badges

Flexible badge components for labels, status indicators, and tags with support for design system variants and all Tailwind color palettes.

## Props Reference

### Base Badge

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `secondary` | Color variant (design system or Tailwind color) |
| `size` | string | `md` | Badge size (`sm`, `md`, `lg`) |
| `style` | string | `filled` | Visual style (`filled`, `outlined`, `soft`) |
| `icon` | string | `null` | Leading icon name |
| `icon-trailing` | string | `null` | Trailing icon name |

### Dot Badge

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `secondary` | Dot color variant |
| `size` | string | `md` | Badge size (`sm`, `md`, `lg`) |

### Removable Badge

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `secondary` | Color variant |
| `size` | string | `md` | Badge size (`sm`, `md`, `lg`) |
| `style` | string | `filled` | Visual style (`filled`, `outlined`, `soft`) |
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

### Design System Variants

```blade
{{-- All 6 design system color variants --}}
<x-strata::badge variant="primary">Primary</x-strata::badge>
<x-strata::badge variant="secondary">Secondary</x-strata::badge>
<x-strata::badge variant="success">Success</x-strata::badge>
<x-strata::badge variant="warning">Warning</x-strata::badge>
<x-strata::badge variant="destructive">Destructive</x-strata::badge>
<x-strata::badge variant="info">Info</x-strata::badge>
```

### Tailwind Color Variants

Beyond the 6 design system variants, badges support all 22 Tailwind color palettes:

```blade
{{-- Tailwind colors --}}
<x-strata::badge variant="red">Red</x-strata::badge>
<x-strata::badge variant="orange">Orange</x-strata::badge>
<x-strata::badge variant="blue">Blue</x-strata::badge>
<x-strata::badge variant="purple">Purple</x-strata::badge>
<x-strata::badge variant="pink">Pink</x-strata::badge>
{{-- Also: amber, yellow, lime, green, emerald, teal, cyan, sky, indigo, violet, fuchsia, rose, slate, gray, zinc, neutral, stone --}}
```

### Styles and Sizes

```blade
{{-- Three visual styles --}}
<x-strata::badge style="filled" variant="success">Filled</x-strata::badge>
<x-strata::badge style="outlined" variant="success">Outlined</x-strata::badge>
<x-strata::badge style="soft" variant="success">Soft</x-strata::badge>

{{-- Three sizes --}}
<x-strata::badge size="sm">Small</x-strata::badge>
<x-strata::badge size="md">Medium</x-strata::badge>
<x-strata::badge size="lg">Large</x-strata::badge>
```

### With Icons

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
<x-strata::badge icon="star" variant="warning">VIP</x-strata::badge>
```

## Dot Badges

Status indicators with colored dots - perfect for user status, connection states, or live indicators:

```blade
<x-strata::badge.dot variant="success">Online</x-strata::badge.dot>
<x-strata::badge.dot variant="warning">Away</x-strata::badge.dot>
<x-strata::badge.dot variant="destructive">Offline</x-strata::badge.dot>
<x-strata::badge.dot variant="info">Processing</x-strata::badge.dot>
```

The dot badge has no background - only the dot itself is colored, making it ideal for subtle status indicators:

```blade
<div class="flex items-center gap-3">
    <img src="avatar.jpg" class="w-10 h-10 rounded-full" />
    <div>
        <div class="font-medium">John Doe</div>
        <x-strata::badge.dot variant="success" size="sm">Online</x-strata::badge.dot>
    </div>
</div>
```

## Removable Badges

Tags with remove buttons, ideal for filters or tag management:

```blade
<x-strata::badge.removable variant="primary">Tag 1</x-strata::badge.removable>
<x-strata::badge.removable variant="success" icon="tag">Category</x-strata::badge.removable>
```

### Livewire Integration

Removable badges work seamlessly with Livewire for interactive tag removal:

```blade
@foreach($tags as $tag)
    <x-strata::badge.removable
        wire:click="removeTag({{ $tag->id }})"
        variant="primary"
    >
        {{ $tag->name }}
    </x-strata::badge.removable>
@endforeach
```

```php
class TagManager extends Component
{
    public Collection $tags;

    public function removeTag($tagId): void
    {
        $this->tags = $this->tags->reject(fn($tag) => $tag->id === $tagId);
    }
}
```

## Container Badges

Floating badges that wrap other components - perfect for notification indicators and status dots:

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

Use the `dot` prop for subtle status indicators without text:

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

## Notes

- **Color Support:** Badges support 6 design system variants (`primary`, `secondary`, `success`, `warning`, `destructive`, `info`) plus all 22 Tailwind color palettes (`red`, `orange`, `amber`, `yellow`, `lime`, `green`, `emerald`, `teal`, `cyan`, `sky`, `blue`, `indigo`, `violet`, `purple`, `fuchsia`, `pink`, `rose`, `slate`, `gray`, `zinc`, `neutral`, `stone`)
- **Styles:** Three visual styles available - `filled` (default, solid background), `outlined` (transparent with border), and `soft` (light background with darker text)
- **Removable Badges:** Use `wire:click` for Livewire integration - the X button automatically receives the click handler
- **Container Badges:** Automatically positioned using absolute positioning with proper z-index stacking
- **Accessibility:** All badges include proper semantic markup and color contrast ratios
