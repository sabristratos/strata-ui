# Sidebar

A flexible navigation sidebar component with persistent and mini variants, responsive behavior, nested navigation support, search functionality, and user profile integration.

## Features

- **Multiple variants**: Persistent (always visible) and Mini (collapsible icon mode)
- **Responsive behavior**: Automatic mobile overlay, desktop fixed sidebar
- **Nested navigation**: 2-level collapsible groups with localStorage persistence
- **Search functionality**: Real-time filtering of navigation items
- **User profile section**: Avatar, name, role with dropdown menu
- **Icon and badge support**: Visual enhancements for menu items
- **Accessibility-first**: Full keyboard navigation, ARIA attributes, screen reader support
- **Dark mode**: Built-in support with light-dark() theme colors
- **State persistence**: Remembers collapsed state and expanded groups

## Basic Usage

```blade
<x-strata::sidebar>
    <x-strata::sidebar.header search>
        <div class="flex items-center gap-2">
            <x-strata::icon.layers class="w-8 h-8" />
            <span class="font-semibold text-lg">My App</span>
        </div>
    </x-strata::sidebar.header>

    <x-strata::sidebar.nav>
        <x-strata::sidebar.item href="/dashboard" icon="home" active>
            Dashboard
        </x-strata::sidebar.item>
        <x-strata::sidebar.item href="/users" icon="users" badge="5">
            Users
        </x-strata::sidebar.item>
        <x-strata::sidebar.item href="/settings" icon="settings">
            Settings
        </x-strata::sidebar.item>
    </x-strata::sidebar.nav>

    <x-strata::sidebar.footer>
        <div class="flex items-center gap-3 px-3 py-2">
            <x-strata::avatar fallback="JD" size="sm" />
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium truncate">John Doe</p>
                <p class="text-xs text-muted-foreground truncate">john@example.com</p>
            </div>
        </div>
    </x-strata::sidebar.footer>
</x-strata::sidebar>
```

## Variants

### Persistent Sidebar (Default)

Always visible on desktop, pushes main content to the side. On mobile, becomes an overlay.

```blade
<x-strata::sidebar variant="persistent">
    <!-- Content -->
</x-strata::sidebar>
```

### Mini/Collapsible Sidebar

Shows icons only when collapsed, expands to show full labels. Perfect for maximizing screen real estate.

```blade
<x-strata::sidebar variant="mini" defaultCollapsed>
    <x-strata::sidebar.nav>
        <x-strata::sidebar.item href="/dashboard" icon="home">
            Dashboard
        </x-strata::sidebar.item>
        <!-- When collapsed, only icons are visible -->
    </x-strata::sidebar.nav>
</x-strata::sidebar>
```

## Props

### Sidebar (Main Component)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | string | `'sidebar-{uniqid}'` | Unique identifier |
| `variant` | string | `'persistent'` | Sidebar variant: `'persistent'` or `'mini'` |
| `position` | string | `'left'` | Position: `'left'` or `'right'` |
| `width` | string | `'md'` | Width: `'sm'` (240px), `'md'` (280px), `'lg'` (320px) |
| `collapsedWidth` | string | `'md'` | Collapsed width: `'sm'` (48px), `'md'` (64px) |
| `defaultOpen` | boolean | `true` | Initial open state (mobile) |
| `defaultCollapsed` | boolean | `false` | Initial collapsed state (desktop) |
| `overlay` | boolean | `true` | Show backdrop overlay on mobile |

### Sidebar.Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `href` | string | `null` | Link URL (renders as `<a>` if provided, `<button>` otherwise) |
| `active` | boolean | `false` | Whether item is currently active |
| `icon` | string | `null` | Icon name from icon library |
| `badge` | string | `null` | Badge content for notifications |
| `badgeVariant` | string | `'default'` | Badge variant |
| `target` | string | `null` | Link target attribute |

### Sidebar.Group

Collapsible navigation group using native HTML `<details>` and `<summary>` elements for optimal performance and accessibility.

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | string | `'sidebar-group-{uniqid}'` | Unique identifier (used for localStorage) |
| `title` | string | `null` | Group title/label |
| `icon` | string | `null` | Icon for group title |
| `defaultExpanded` | boolean | `false` | Initial expanded state |
| `badge` | string | `null` | Badge content |
| `badgeVariant` | string | `'default'` | Badge variant |

**Implementation Note:** Groups use native `<details>`/`<summary>` elements for browser-native collapsible behavior. Each group independently manages its own localStorage state without parent coordination.

### Sidebar.Section

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | `null` | Section title |
| `divider` | boolean | `false` | Show divider before section |

### Sidebar.Header

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `search` | boolean | `false` | Show search input |
| `searchPlaceholder` | string | `'Search...'` | Search input placeholder |
| `close` | boolean | `true` | Show close button (mobile) |

### Sidebar.Toggle

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `target` | string | `null` | Target sidebar ID to control |
| `variant` | string | `'auto'` | Toggle variant: `'hamburger'`, `'collapse'`, `'auto'` |
| `position` | string | `'outside'` | Button position: `'inside'`, `'outside'` |

## Examples

### With Nested Navigation

```blade
<x-strata::sidebar>
    <x-strata::sidebar.nav>
        <x-strata::sidebar.item href="/dashboard" icon="home">
            Dashboard
        </x-strata::sidebar.item>

        <x-strata::sidebar.group title="Settings" icon="settings" defaultExpanded>
            <x-strata::sidebar.item href="/settings/profile" icon="user">
                Profile
            </x-strata::sidebar.item>
            <x-strata::sidebar.item href="/settings/security" icon="shield">
                Security
            </x-strata::sidebar.item>
            <x-strata::sidebar.item href="/settings/billing" icon="credit-card">
                Billing
            </x-strata::sidebar.item>
        </x-strata::sidebar.group>

        <x-strata::sidebar.group title="Administration" icon="users-cog" badge="3">
            <x-strata::sidebar.item href="/admin/users" icon="users">
                Users
            </x-strata::sidebar.item>
            <x-strata::sidebar.item href="/admin/roles" icon="key">
                Roles
            </x-strata::sidebar.item>
        </x-strata::sidebar.group>
    </x-strata::sidebar.nav>
</x-strata::sidebar>
```

### With Sections

```blade
<x-strata::sidebar>
    <x-strata::sidebar.nav>
        <x-strata::sidebar.section title="Main">
            <x-strata::sidebar.item href="/dashboard" icon="home">
                Dashboard
            </x-strata::sidebar.item>
            <x-strata::sidebar.item href="/analytics" icon="chart-bar">
                Analytics
            </x-strata::sidebar.item>
        </x-strata::sidebar.section>

        <x-strata::sidebar.section title="Management" divider>
            <x-strata::sidebar.item href="/users" icon="users">
                Users
            </x-strata::sidebar.item>
            <x-strata::sidebar.item href="/projects" icon="folder">
                Projects
            </x-strata::sidebar.item>
        </x-strata::sidebar.section>

        <x-strata::sidebar.section title="Settings" divider>
            <x-strata::sidebar.item href="/settings" icon="settings">
                Settings
            </x-strata::sidebar.item>
        </x-strata::sidebar.section>
    </x-strata::sidebar.nav>
</x-strata::sidebar>
```

### With Search and User Profile

```blade
<x-strata::sidebar>
    <x-strata::sidebar.header search searchPlaceholder="Search menu...">
        <div class="flex items-center gap-2">
            <img src="/logo.png" class="w-8 h-8 rounded" alt="Logo" />
            <span class="font-semibold text-lg">My Application</span>
        </div>
    </x-strata::sidebar.header>

    <x-strata::sidebar.nav>
        <x-strata::sidebar.item href="/dashboard" icon="home">
            Dashboard
        </x-strata::sidebar.item>
        <x-strata::sidebar.item href="/inbox" icon="inbox" badge="12" badgeVariant="destructive">
            Inbox
        </x-strata::sidebar.item>
        <x-strata::sidebar.item href="/tasks" icon="check-square" badge="5" badgeVariant="warning">
            Tasks
        </x-strata::sidebar.item>
    </x-strata::sidebar.nav>

    <x-strata::sidebar.footer>
        <x-strata::dropdown>
            <x-strata::dropdown.trigger asChild>
                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-md hover:bg-sidebar-hover transition-colors">
                    <x-strata::avatar src="/avatar.jpg" alt="John Doe" size="sm" />
                    <div class="flex-1 min-w-0 text-left">
                        <p class="text-sm font-medium truncate">John Doe</p>
                        <p class="text-xs text-muted-foreground truncate">john@example.com</p>
                    </div>
                    <x-strata::icon name="chevron-up" class="w-4 h-4" />
                </button>
            </x-strata::dropdown.trigger>

            <x-strata::dropdown.content align="end">
                <x-strata::dropdown.label>My Account</x-strata::dropdown.label>
                <x-strata::dropdown.item href="/profile">Profile</x-strata::dropdown.item>
                <x-strata::dropdown.item href="/settings">Settings</x-strata::dropdown.item>
                <x-strata::dropdown.divider />
                <x-strata::dropdown.item href="/logout">Logout</x-strata::dropdown.item>
            </x-strata::dropdown.content>
        </x-strata::dropdown>
    </x-strata::sidebar.footer>
</x-strata::sidebar>
```

### Right-Positioned Sidebar

```blade
<x-strata::sidebar position="right" width="sm">
    <x-strata::sidebar.header>
        <h2 class="font-semibold text-lg">Filters</h2>
    </x-strata::sidebar.header>

    <x-strata::sidebar.nav>
        <!-- Filter options -->
    </x-strata::sidebar.nav>
</x-strata::sidebar>
```

### With Toggle Button

```blade
<!-- Outside sidebar -->
<div class="flex">
    <!-- Hamburger menu for mobile -->
    <x-strata::sidebar.toggle target="main-sidebar" variant="hamburger" class="md:hidden" />

    <x-strata::sidebar id="main-sidebar">
        <!-- Collapse toggle inside sidebar -->
        <x-strata::sidebar.header>
            <div class="flex items-center justify-between">
                <span class="font-semibold">Menu</span>
                <x-strata::sidebar.toggle variant="collapse" />
            </div>
        </x-strata::sidebar.header>

        <x-strata::sidebar.nav>
            <!-- Navigation items -->
        </x-strata::sidebar.nav>
    </x-strata::sidebar>

    <main class="flex-1 p-6">
        <!-- Main content -->
    </main>
</div>
```

## Responsive Behavior

The sidebar automatically adapts to different screen sizes:

### Desktop (≥ 768px)
- Fixed position sidebar
- Persistent or mini variant as specified
- Can be collapsed to icon-only mode
- Pushes or overlays main content

### Mobile (< 768px)
- Overlay with backdrop
- Slides in from left or right
- Full-height drawer
- Closes on backdrop click or item selection
- Hamburger menu trigger recommended

## State Management

### localStorage Persistence

The sidebar automatically saves and restores:
- **Collapsed state** (expanded/icon-only mode) - Saved globally as `strata-sidebar-collapsed`
- **Expanded groups** - Each group saves its state individually as `sidebar-group-{id}`

This provides a seamless experience across page reloads. Groups use native HTML `<details>` elements with independent state management for better performance and reliability.

### Alpine.js State

Access sidebar state in your templates:

```blade
<div x-data>
    <button @click="$root.closest('[data-strata-sidebar]').__x.$data.toggle()">
        Toggle Sidebar
    </button>

    <button @click="$root.closest('[data-strata-sidebar]').__x.$data.toggleCollapsed()">
        Toggle Collapsed
    </button>
</div>
```

**Note:** Groups manage their own state using native `<details>` elements and don't require parent state access.

## Accessibility

### Keyboard Navigation

- **Tab / Shift+Tab**: Navigate through interactive elements
- **Enter / Space**: Activate links and buttons
- **Escape**: Close sidebar on mobile
- **Arrow Keys**: Navigate menu items (browser default)

### ARIA Attributes

The sidebar includes proper ARIA attributes:
- `role="navigation"` on main sidebar
- `aria-label="Main navigation"`
- `aria-expanded` for collapsible groups
- `aria-current="page"` for active items
- `aria-controls` for toggle buttons

### Screen Readers

All interactive elements have proper labels:
- Icons have accompanying text
- Toggle buttons have `aria-label`
- Navigation structure is semantic

## Theming

The sidebar uses CSS variables for easy theming:

```css
@theme {
    --color-sidebar: light-dark(var(--color-neutral-50), var(--color-neutral-950));
    --color-sidebar-foreground: var(--color-foreground);
    --color-sidebar-hover: light-dark(var(--color-neutral-100), var(--color-neutral-900));
    --color-sidebar-active: light-dark(var(--color-primary-100), oklch(from var(--color-primary-900) l c h / 0.3));
    --color-sidebar-active-foreground: light-dark(var(--color-primary-700), var(--color-primary-300));
    --color-sidebar-border: var(--color-border);
}
```

Override these variables to customize the appearance:

```css
:root {
    --color-sidebar: #f8f9fa;
    --color-sidebar-active: #e3f2fd;
}
```

## Integration with Livewire

While the sidebar doesn't directly integrate with Livewire state, you can control it via Alpine events:

```blade
<!-- Livewire Component -->
<div>
    <button wire:click="$dispatch('open-sidebar')">
        Open Sidebar
    </button>
</div>

<!-- Sidebar -->
<x-strata::sidebar
    x-on:open-sidebar.window="open = true"
    x-on:close-sidebar.window="open = false"
>
    <!-- Content -->
</x-strata::sidebar>
```

## Layout Integration

### Full Page Layout

```blade
<!DOCTYPE html>
<html>
<head>
    @strataStyles
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <x-strata::sidebar>
            <!-- Sidebar content -->
        </x-strata::sidebar>

        <main class="flex-1 overflow-y-auto">
            <!-- Main content -->
        </main>
    </div>

    @strataScripts
</body>
</html>
```

### With Top Navigation

```blade
<div class="flex flex-col h-screen">
    <!-- Top navbar -->
    <header class="h-16 bg-white border-b">
        <x-strata::sidebar.toggle target="main-sidebar" variant="hamburger" />
        <!-- Other navbar content -->
    </header>

    <div class="flex flex-1 overflow-hidden">
        <x-strata::sidebar id="main-sidebar">
            <!-- Sidebar content -->
        </x-strata::sidebar>

        <main class="flex-1 overflow-y-auto p-6">
            <!-- Main content -->
        </main>
    </div>
</div>
```

## Best Practices

1. **Use semantic icons**: Choose icons that clearly represent the function
2. **Limit nesting**: Stick to 2 levels maximum for better UX
3. **Group logically**: Organize related items into sections or groups
4. **Badge sparingly**: Only use badges for important notifications
5. **Keep labels short**: Ensure text fits when sidebar is expanded
6. **Test mobile**: Always test the mobile overlay experience
7. **Active states**: Always indicate the current page with `active` prop
8. **Keyboard access**: Ensure all functionality works with keyboard only

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Requires CSS `light-dark()` function support
- Alpine.js 3.x required
- Tailwind CSS v4 required

## Related Components

- **Dropdown**: Use in footer for user profile menus
- **Badge**: For notification counts on items
- **Avatar**: For user profile display
- **Input**: For search functionality
- **Separator**: For visual dividers between sections
- **Icon**: For menu item icons
