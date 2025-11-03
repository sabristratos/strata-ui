# Strata UI Documentation

Welcome to Strata UI, a Blade and Livewire component library for Laravel applications. This library provides clean, flexible, and powerful UI components built with modern web standards.

## Component Library

### Typography

- [Heading](heading.md) - Semantic heading component with responsive scale, gradient variant, and flexible rendering
- [Text](text.md) - Versatile text component with presets for body, lead, muted, overline, quote, code, and more
- [Prose](prose.md) - Rich content wrapper for markdown with beautiful typography styling

### Data Display

- [Table](table.md) - Full-featured table with sorting, selection, loading states, responsive mobile layouts, and accessibility

### Forms

- [Calendar](calendar.md) - Date picker with multiple selection modes, keyboard navigation, and range selection
- [File Input](file-input.md) - File upload component with drag-and-drop, previews, and Livewire integration
- [Repeater](repeater.md) - Dynamic repeater with add/remove/reorder, deferred sync, and auto-extraction for all field types
- [Select](select.md) - Flexible select component with single/multiselect, keyboard navigation, and customizable options
- [Toggle](toggle.md) - Switch-style toggle component with size variants, rounded options, and Livewire integration

### Navigation

- [Bottom Navigation](bottom-nav.md) - Mobile-first bottom navigation bar with pill-style container, icon support, and multiple position variants
- [Dropdown](dropdown.md) - Comprehensive dropdown menu with actions, checkboxes, radios, nested submenus, and full ARIA keyboard navigation
- [Sidebar](sidebar.md) - Flexible navigation sidebar with persistent/mini variants, nested navigation, search, and responsive behavior

### Overlays

- [Modal](modal.md) - Dialog and flyout component using native `<dialog>` with Alpine.js, Livewire integration, and multiple size variants

### Notifications

- [Toast](toast.md) - Toast notifications with auto-dismiss, progress bar, multiple variants, positioning options, and both Livewire and JavaScript APIs

### Getting Started

Components are available via Laravel's auto-discovery. Simply use the `x-strata::` prefix to access any component:

```blade
<x-strata::file-input wire:model="files" multiple />
```

### Features

- **Blade Components** - Clean, reusable Blade components
- **Livewire Integration** - Seamless wire:model support
- **Alpine.js** - Interactive UI without complex JavaScript
- **Tailwind CSS v4** - Modern styling with theming support
- **Dark Mode** - Built-in light/dark mode support
- **Accessible** - ARIA labels and keyboard navigation

### Installation

Include Strata UI assets in your layout:

```blade
<!DOCTYPE html>
<html>
<head>
    @strataStyles
</head>
<body>
    {{ $slot }}

    @strataScripts
</body>
</html>
```

### Customization

Override component styles in your `app.css`:

```css
@import "tailwindcss";

@theme {
  --color-primary: oklch(0.5 0.2 250);
  --color-primary-foreground: white;
}
```

### Development

To build Strata UI assets during development:

```bash
php artisan strata:build
php artisan strata:build --watch
```
