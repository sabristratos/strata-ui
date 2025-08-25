# Changelog

All notable changes to `stratosdigital/strata-ui` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.1] - 2024-08-25

### Added
- Comprehensive components documentation (COMPONENTS.md)
- Complete API documentation for all 25+ components
- Detailed usage examples for every component
- Form integration patterns and Livewire usage guide
- Theming and customization documentation
- Accessibility considerations and best practices

### Fixed
- **BREAKING FIX**: Removed stray quotes from `@strataScripts` directive output
- Blade directive now properly outputs clean HTML script tags
- Fixed literal quote marks appearing in rendered HTML

### Changed
- Updated package name from `strata/ui` to `stratosdigital/strata-ui`
- Updated author information to Sabri Ben Chaabane
- Updated all repository URLs to point to correct GitHub location
- Improved README with Tailwind v4 specific installation instructions

## [1.0.0] - 2024-08-25

### Added
- Initial release of Strata UI component library
- Comprehensive Blade component system with 25+ components
- Full Tailwind CSS v4 integration with semantic color tokens
- Alpine.js powered interactivity with smart plugin loading
- Complete Livewire compatibility with `wire:model` support
- Dark mode support with automatic theme switching
- Rating component with star system and customizable icons
- Custom rating star color variable extending yellow palette
- File upload component with drag & drop and gallery modes
- Calendar component with date range selection and presets
- Modal system with named modals and event-driven API
- Toast notification system with action buttons
- Table components with sorting, pagination, and responsive design
- Form components with validation, accessibility, and consistent styling
- Avatar component with fallback handling and status indicators
- Badge, Button, Alert, Card, and Tooltip components
- Comprehensive test coverage with Pest
- TypeScript-style PHP documentation
- Development pattern documentation (DEVELOPMENT.md)
- Laravel package structure with auto-discovery
- Asset publishing system with proper tags
- MIT license and proper attribution