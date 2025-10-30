# Strata UI

A modern Blade and Livewire component library for Laravel.

## Features

- Clean, flexible, and powerful UI components
- Built with Tailwind CSS v4
- Seamless Livewire integration
- Alpine.js for interactions
- Semantic color tokens and theming
- 1,648+ Lucide icons included

## Installation

```bash
composer require stratos/strata-ui
```

## Quick Start

Add the Strata UI directives to your layout:

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

Start using components:

```blade
<x-strata::badge variant="success" icon="check">Verified</x-strata::badge>
<x-strata::icon.heart class="w-5 h-5 text-red-500" />
```

## Documentation

**[View Full Documentation →](docs/index.md)**

- [Icons](docs/icons.md) - 1,648 Lucide icons
- [Badges](docs/badges.md) - Labels, status indicators, and tags

## Development

Build package assets:

```bash
php artisan strata:build
```

Watch for changes during development:

```bash
php artisan strata:build --watch
```

## License

MIT
