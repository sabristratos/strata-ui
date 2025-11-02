# Breadcrumbs

A navigation component that helps users understand their location within the application hierarchy and navigate back to parent pages.

## Basic Usage

```blade
<x-strata::breadcrumbs>
    <x-strata::breadcrumbs.item href="/" icon="home">
        Home
    </x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/products">
        Products
    </x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item active>
        Category
    </x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>
```

## Variants

The breadcrumbs component supports two visual variants:

```blade
<!-- Default variant (subtle styling) -->
<x-strata::breadcrumbs variant="default">
    <!-- items here -->
</x-strata::breadcrumbs>

<!-- Bold variant (stronger emphasis) -->
<x-strata::breadcrumbs variant="bold">
    <!-- items here -->
</x-strata::breadcrumbs>
```

## Sizes

Control the overall size of the breadcrumbs:

```blade
<!-- Small -->
<x-strata::breadcrumbs size="sm">
    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>

<!-- Medium (default) -->
<x-strata::breadcrumbs size="md">
    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>

<!-- Large -->
<x-strata::breadcrumbs size="lg">
    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>
```

## Separators

Choose from different separator styles:

```blade
<!-- Chevron (default) -->
<x-strata::breadcrumbs separator="chevron-right">
    <!-- items here -->
</x-strata::breadcrumbs>

<!-- Slash -->
<x-strata::breadcrumbs separator="slash">
    <!-- items here -->
</x-strata::breadcrumbs>

<!-- Custom separator -->
<x-strata::breadcrumbs separator="→">
    <!-- items here -->
</x-strata::breadcrumbs>
```

## Icons

Add optional icons to breadcrumb items:

```blade
<x-strata::breadcrumbs>
    <x-strata::breadcrumbs.item href="/" icon="home">
        Home
    </x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/settings" icon="settings">
        Settings
    </x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item icon="user" active>
        Profile
    </x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>
```

## Collapsed View

For long breadcrumb trails, automatically collapse middle items:

```blade
<x-strata::breadcrumbs :max-items="3">
    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/level1">Level 1</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/level2">Level 2</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/level3">Level 3</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>
```

When the number of items exceeds `maxItems`, middle items are hidden and an ellipsis button appears. Clicking it reveals all items.

## Component API

### Breadcrumbs (Main Container)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `default` | Visual style: `default`, `bold` |
| `size` | string | `md` | Size of breadcrumbs: `sm`, `md`, `lg` |
| `separator` | string | `chevron-right` | Separator type: `chevron-right`, `slash`, or custom text |
| `maxItems` | int\|null | `null` | Maximum items before collapsing middle items |

### Breadcrumbs Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `href` | string\|null | `null` | Link destination (renders as `<a>` when provided) |
| `icon` | string\|null | `null` | Optional leading icon name |
| `active` | boolean | `false` | Marks the current page (adds `aria-current="page"`) |

### Breadcrumbs Separator

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | string\|null | `null` | Override parent separator type |

## Accessibility

The breadcrumbs component includes proper accessibility features:

- Semantic `<nav>` element with `aria-label="Breadcrumbs"`
- Active items have `aria-current="page"`
- Separators have `aria-hidden="true"`
- Links are keyboard accessible
- Proper focus states

## Examples

### E-commerce Product Path

```blade
<x-strata::breadcrumbs>
    <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/shop">Shop</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/shop/electronics">Electronics</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/shop/electronics/laptops">Laptops</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item active>MacBook Pro</x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>
```

### Admin Dashboard Path

```blade
<x-strata::breadcrumbs variant="bold" separator="slash">
    <x-strata::breadcrumbs.item href="/admin" icon="layout-dashboard">Dashboard</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/admin/users" icon="users">Users</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item active>Edit User</x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>
```

### Deep Hierarchy with Collapse

```blade
<x-strata::breadcrumbs size="sm" :max-items="4">
    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/docs">Documentation</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/docs/components">Components</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/docs/components/navigation">Navigation</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/docs/components/navigation/breadcrumbs">Breadcrumbs</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item active>Examples</x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>
```

## Responsive Behavior

The breadcrumbs component automatically wraps on smaller screens. Consider using the `maxItems` prop for very deep hierarchies on mobile devices:

```blade
<x-strata::breadcrumbs :max-items="3" size="sm">
    <!-- Many items will collapse with ellipsis on mobile -->
</x-strata::breadcrumbs>
```
