# Strata UI

A comprehensive Laravel Blade component library built with Tailwind CSS v4, Alpine.js, and full Livewire integration. Strata UI provides modern, accessible, and customizable UI components for Laravel applications with zero configuration required.

## Features

- 🎨 **Modern Design System** - Built with Tailwind CSS v4 and semantic color tokens
- 🌙 **Dark Mode Support** - Automatic dark mode with comprehensive theme coverage
- ⚡ **Alpine.js Integration** - Interactive components with smart plugin loading
- 🔄 **Livewire Compatible** - Full `wire:model` support and event integration
- ♿ **Accessibility First** - ARIA labels, keyboard navigation, and screen reader support
- 📱 **Responsive Design** - Mobile-first approach with consistent breakpoints
- 🎯 **Type Safe** - PHP 8+ with proper type declarations and return types
- 🧪 **Fully Tested** - Comprehensive test coverage with Pest

## Requirements

- PHP 8.2+
- Laravel 11+ (or Laravel 12)
- **Tailwind CSS v4** (required - v3 not supported)
- Node.js 18+ (for asset compilation)

## Installation

### 1. Install the Package

```bash
composer require stratosdigital/strata-ui
```

### 2. Publish Assets (Optional)

If you want to customize the theme or extend the package:

```bash
php artisan vendor:publish --tag=strata-ui-assets
php artisan vendor:publish --tag=strata-ui-views
```

### 3. Add Strata Scripts

Add the Strata scripts directive to your main layout file:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Your head content -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Your body content -->
    
    <!-- Add this before closing body tag -->
    @strataScripts
</body>
</html>
```

### 4. Configure Tailwind CSS v4

Add Strata UI paths to your CSS file using Tailwind v4's `@source` directive:

```css
/* resources/css/app.css */
@import "tailwindcss";

/* Add Strata UI template paths */
@source "../../vendor/stratosdigital/strata-ui/resources/views/**/*.blade.php";
```

### 5. Import Strata Theme (Optional)

If you want to use Strata's design system, import the theme in your main CSS file:

```css
/* resources/css/app.css */
@import "tailwindcss";

/* Add Strata UI template paths */
@source "../../vendor/stratosdigital/strata-ui/resources/views/**/*.blade.php";

/* Import Strata UI theme (optional) */
@import "../../vendor/stratosdigital/strata-ui/resources/css/strata-theme.css";
```

## Basic Usage

Once installed, you can use Strata UI components with the `x-strata::` prefix:

```blade
<!-- Button -->
<x-strata::button>Click Me</x-strata::button>

<!-- Form Input -->
<x-strata::form.input 
    name="email" 
    label="Email Address"
    placeholder="Enter your email"
/>

<!-- Rating Component -->
<x-strata::form.rating
    name="rating"
    label="Rate this product"
    value="4"
    clearable
/>

<!-- Modal -->
<x-strata::modal name="example">
    <h2>Modal Title</h2>
    <p>Modal content goes here...</p>
</x-strata::modal>
```

## Livewire Integration

All form components support Livewire out of the box:

```blade
<!-- In your Livewire component view -->
<x-strata::form.input 
    wire:model="email" 
    label="Email"
    placeholder="Enter email"
/>

<x-strata::form.rating 
    wire:model="rating"
    label="Product Rating"
    :max="5"
/>

<x-strata::form.select
    wire:model="category"
    :items="$categories"
    label="Category"
    searchable
/>
```

## Component Categories

### Core UI Components
- `button` - Buttons with multiple variants and sizes
- `badge` - Status indicators and labels
- `alert` - Contextual messaging
- `card` - Container component
- `avatar` - User profile pictures and initials

### Form Components (`form.*`)
- `input` - Text inputs with icons and validation
- `textarea` - Multi-line text input
- `select` - Dropdown selection with search
- `checkbox` - Checkbox inputs
- `radio` - Radio button inputs  
- `toggle` - Switch/toggle inputs
- `rating` - Star rating component
- `file-upload` - File upload with drag & drop
- `group` - Form field wrapper with labels and errors

### Advanced Components
- `modal` - Modal dialogs with Alpine.js
- `table` - Data tables with sorting and pagination
- `calendar` - Date picker and range selection
- `toast` - Notification system
- `tooltip` - Hover-triggered tooltips
- `tabs` - Tabbed content areas

## Configuration

### Environment Variables

The package respects standard Laravel configurations:

```env
APP_TIMEZONE=UTC
APP_LOCALE=en
```

### Customizing the Theme

If you published the assets, you can customize the theme by editing:

```
resources/css/strata-theme.css
```

The theme uses CSS custom properties for easy customization:

```css
:root {
    --primary: oklch(0.6104 0.0767 299.7335);
    --accent: oklch(0.7889 0.0802 359.9375);
    --rating-star: oklch(0.7540 0.0982 76.8292);
    --background: oklch(0.9777 0.0041 301.4256);
    /* ... other variables */
}
```

## Asset Compilation

If you need to customize JavaScript functionality:

```bash
# Install dependencies
npm install

# Build for development
npm run dev

# Build for production
npm run build
```

## Testing

Run the component tests:

```bash
# Run all tests
php artisan test

# Run only Strata UI tests
php artisan test --filter=Strata

# Run specific component tests
php artisan test tests/Feature/RatingComponentTest.php
```

## Development

For package development and contributing, see [DEVELOPMENT.md](DEVELOPMENT.md) for detailed patterns and conventions.

## Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions) 
- Safari (latest 2 versions)
- Edge (latest 2 versions)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Follow the patterns in [DEVELOPMENT.md](DEVELOPMENT.md)
4. Add tests for new components
5. Submit a pull request

## License

Strata UI is open-sourced software licensed under the [MIT license](LICENSE).

## Credits

- Built with [Alpine.js](https://alpinejs.dev/)
- Styled with [Tailwind CSS](https://tailwindcss.com/)
- Icons by [Heroicons](https://heroicons.com/)
- Inspired by modern design systems and Laravel ecosystem best practices
