# Strata UI Documentation

A modern Blade and Livewire component library for Laravel.

## Overview

Strata UI provides clean, flexible, and powerful UI components built with:

- **Tailwind CSS v4** - Modern utility-first styling
- **Livewire v3** - Seamless reactive components
- **Alpine.js** - Minimal JavaScript interactions
- **Semantic Theming** - Consistent color tokens
- **1,648+ Icons** - Complete Lucide icon set

## Getting Started

### Installation

```bash
composer require stratos/strata-ui
```

### Include Assets

Add the Strata UI directives to your layout file:

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>App</title>

    @strataStyles
</head>
<body>
    {{ $slot }}

    @strataScripts
</body>
</html>
```

That's it! You're ready to use Strata UI components.

## Design System

- **[Design System](design-system.md)** - Comprehensive token system for theming and customization

## Architecture

- **[Component Structure](component-structure.md)** - How components are organized and the folder structure pattern

## Available Components

- **[Accordion](accordion.md)** - Modern collapsible panels with smooth CSS animations
- **[Alerts](alert.md)** - Clean alerts with semantic colors and dismissible functionality
- **[Avatars](avatars.md)** - User profile images with automatic fallback handling
- **[Badges](badges.md)** - Flexible labels, status indicators, and tags
- **[Buttons](buttons.md)** - Realistic 3D buttons with loading states and variants
- **[Cards](card.md)** - Flexible containers for displaying content in a structured format
- **[Checkboxes](checkbox.md)** - Checkboxes with Livewire integration and multiple variants
- **[Icons](icons.md)** - 1,648 Lucide icons with simple syntax
- **[Inputs](inputs.md)** - Form inputs with validation states and composable field components
- **[Kbd](kbd.md)** - Keyboard keys and shortcuts with realistic button-style appearance
- **[Popovers](popover.md)** - Native popover API with CSS anchor positioning for tooltips and menus
- **[Radio Buttons](radio.md)** - Radio buttons with Livewire integration and multiple variants
- **[Tables](table.md)** - Fully composable tables with sorting, selection, and multiple variants
- **[Textareas](textareas.md)** - Multi-line text inputs with resize control and action components

## Customization

All Strata UI components support full Tailwind customization through attribute merging:

```blade
<x-strata::badge class="uppercase tracking-wide">Custom</x-strata::badge>
```

You can also override any component by publishing the views:

```bash
php artisan vendor:publish --tag=strata-ui-views
```

Then edit files in `resources/views/vendor/strata-ui/components/`.

## Theming

Strata UI uses a comprehensive design token system with 75 semantic color tokens:

- **Semantic colors**: `primary`, `secondary`, `success`, `warning`, `destructive`, `info`
- **Foundation tokens**: `background`, `foreground`, `muted`, `border`, etc.
- **Component tokens**: Specialized tokens for cards, inputs, dialogs, tables, and more

Each semantic color includes variants for foreground text, hover states, active states, subtle backgrounds, and borders.

Learn more in the **[Design System](design-system.md)** documentation.
