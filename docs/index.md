# Strata UI Documentation

Welcome to Strata UI, a Blade and Livewire component library for Laravel applications. This library provides clean, flexible, and powerful UI components built with modern web standards.

## Component Library

### Forms

- [Calendar](calendar.md) - Date picker with multiple selection modes, keyboard navigation, and range selection
- [File Input](file-input.md) - File upload component with drag-and-drop, previews, and Livewire integration
- [Select](select.md) - Flexible select component with single/multiselect, keyboard navigation, and customizable options
- [Toggle](toggle.md) - Switch-style toggle component with size variants, rounded options, and Livewire integration

### Overlays

- [Modal](modal.md) - Dialog and flyout component using native `<dialog>` with Alpine.js, Livewire integration, and multiple size variants

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
