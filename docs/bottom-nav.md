# Bottom Navigation

A mobile-first bottom navigation component with a pill-style container and individual navigation items.

## Installation

The Bottom Navigation component is included with Strata UI. Make sure you have the package installed and configured.

## Basic Usage

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item icon="home" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="user">
        Profile
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="newspaper">
        News
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

## Navigation Container Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `position` | `string` | `'fixed'` | Position style: `'fixed'`, `'sticky'`, or `'static'` |
| `size` | `string` | `'md'` | Size variant: `'sm'`, `'md'`, or `'lg'` |
| `respectSafeArea` | `bool` | `true` | Add padding for device safe areas (iPhone notch, etc.) |

## Navigation Item Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `icon` | `string\|null` | `null` | Icon name from the icon set |
| `active` | `bool` | `false` | Whether the item is currently active |
| `href` | `string\|null` | `null` | URL for link navigation (renders as `<a>` instead of `<button>`) |
| `size` | `string` | `'md'` | Size variant: `'sm'`, `'md'`, or `'lg'` |
| `showLabel` | `bool` | `true` | Whether to show the label text (false for icon-only) |
| `badge` | `string\|null` | `null` | Badge text/number to display on the icon |
| `badgeVariant` | `string` | `'default'` | Badge variant: `'default'`, `'destructive'`, `'success'`, `'warning'` |
| `badgeDot` | `bool` | `false` | Show dot indicator instead of badge |
| `disabled` | `bool` | `false` | Disable interaction |
| `loading` | `bool` | `false` | Show loading spinner |
| `target` | `string\|null` | `null` | Link target attribute: `'_blank'`, `'_self'`, etc. |

## Examples

### Icon Only Navigation

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item icon="home" :show-label="false" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="user" :show-label="false">
        Profile
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="newspaper" :show-label="false">
        News
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### With Links

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item icon="home" href="/" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="user" href="/profile">
        Profile
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="newspaper" href="/news">
        News
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### Different Sizes

```blade
{{-- Small --}}
<x-strata::bottom-nav size="sm">
    <x-strata::bottom-nav.item icon="home" size="sm" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="user" size="sm">
        Profile
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>

{{-- Large --}}
<x-strata::bottom-nav size="lg">
    <x-strata::bottom-nav.item icon="home" size="lg" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="user" size="lg">
        Profile
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### Sticky Position

```blade
<x-strata::bottom-nav position="sticky">
    <x-strata::bottom-nav.item icon="home" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="user">
        Profile
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="newspaper">
        News
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### Static Position (Inline)

```blade
<x-strata::bottom-nav position="static">
    <x-strata::bottom-nav.item icon="home" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="user">
        Profile
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### With Badges

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item icon="home" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="bell" badge="5" badge-variant="destructive">
        Notifications
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="inbox" :badge-dot="true">
        Messages
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### Badge Variants

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item icon="home" badge="3">
        Default Badge
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="bell" badge="12" badge-variant="destructive">
        Destructive Badge
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="check" badge="5" badge-variant="success">
        Success Badge
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### Disabled and Loading States

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item icon="home" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="settings" disabled>
        Settings
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="user" :loading="$isLoadingProfile">
        Profile
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### External Links

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item icon="home" href="/" active>
        Home
    </x-strata::bottom-nav.item>
    <x-strata::bottom-nav.item icon="external-link" href="https://example.com" target="_blank">
        External
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

### Safe Area Support

```blade
{{-- Default: safe area enabled for modern devices --}}
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item icon="home" active>
        Home
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>

{{-- Disable safe area if you handle it elsewhere --}}
<x-strata::bottom-nav :respect-safe-area="false">
    <x-strata::bottom-nav.item icon="home" active>
        Home
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

## Accessibility

The Bottom Navigation component follows accessibility best practices:

- Uses semantic `<nav>` element with `role="navigation"`
- Includes `aria-label` for screen readers
- Active items have `aria-current="page"`
- Icon-only items include `sr-only` labels for screen readers
- Proper keyboard navigation support
- Focus visible states for keyboard users
- Touch target minimum height of 44px (iOS) / 48px (Android) for all sizes
- Loading state includes `aria-busy="true"`
- Disabled state prevents interaction with proper cursor and opacity

## Mobile Optimization

The component includes modern mobile optimizations:

- **Safe Area Support**: Automatically respects device safe areas (iPhone notch, home indicator) with `env(safe-area-inset-bottom)`
- **Touch Targets**: Minimum 44px height for all interactive elements
- **Glass Morphism**: Translucent background with backdrop blur for modern aesthetics
- **Smooth Transitions**: Hardware-accelerated animations for 60fps performance

## Styling

The component uses:
- Glass morphism effect with `backdrop-blur-lg` and semi-transparent background
- Pill-shaped container with `rounded-full`
- Active state with primary brand colors (`bg-primary`, `text-primary-foreground`)
- Smooth transitions for hover and active states
- Shadow for depth and visual separation
- Badge positioning with absolute placement on icons

## Best Practices

1. **Limit Items**: Keep navigation items between 3-5 for optimal mobile UX
2. **Always Active**: One item should always be marked as active
3. **Consistent Icons**: Use icons consistently across all items
4. **Label Text**: Provide label text even for icon-only navigation (for accessibility)
5. **Mobile First**: This component is designed for mobile viewports
6. **Fixed Position**: Use fixed position for persistent bottom navigation
7. **Safe Areas**: Keep default safe area support enabled unless you have a specific reason to disable it
8. **Badge Usage**: Use badges sparingly to indicate important notifications or counts
9. **Loading State**: Show loading state during async operations to provide user feedback

## Integration with Livewire

You can dynamically set the active state based on the current route:

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item
        icon="home"
        href="/"
        :active="request()->routeIs('home')"
    >
        Home
    </x-strata::bottom-nav.item>

    <x-strata::bottom-nav.item
        icon="user"
        href="/profile"
        :active="request()->routeIs('profile')"
    >
        Profile
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```

Or with Livewire wire:navigate for SPA-like navigation:

```blade
<x-strata::bottom-nav>
    <x-strata::bottom-nav.item
        icon="home"
        href="/"
        wire:navigate
        :active="request()->routeIs('home')"
    >
        Home
    </x-strata::bottom-nav.item>
</x-strata::bottom-nav>
```
