# Strata UI Project Guidelines

## Stack
- PHP 8.3, Laravel 12, Livewire 3, Alpine.js, Tailwind v4, Pest 4
- No code comments - only PHPDoc/JSDoc blocks
- Always run `vendor/bin/pint --dirty` before finalizing changes

## Core Principles

### Technology Priority
1. Native HTML/PHP first
2. Tailwind CSS for styling (never hardcode values)
3. Alpine.js for interactivity (only when needed)
4. Livewire for server state

### Theme System
- Always use `packages/strata-ui/resources/css/theme.css` design system
- CSS custom properties: `--color-*`, `--spacing-*`, `--radius-*`, `--shadow-*`
- Supports light/dark modes via `light-dark()` function
- Never construct dynamic class names: use complete classes only

### Floating Elements
- **Popover API** for top-layer management (tooltips, dropdowns, modals)
- **CSS Anchor Positioning** for layout (no JavaScript positioning)
- **PositioningHelper** for consistent positioning logic
- Supported placements: `bottom-start`, `bottom-end`, `top-start`, `top-end`, `right-start`, `left-start`, etc.

### Component Architecture
- Sensible defaults, minimal configuration required
- Extensible via slots and sub-components
- Reuse existing buttons, icons, separators, cards
- Props for configuration, attributes for HTML forwarding
- Always validate props in `mount()` with clear error messages

### Element Targeting
- **Prefer** `x-ref` and `$refs` for local Alpine scoping
- **Use data attributes** for cross-component targeting (`data-strata-*`)
- **Never** rely on classes or IDs for selectors

### Accessibility
- Use semantic HTML elements
- Include proper ARIA attributes (roles, labels, descriptions)
- Support keyboard navigation (arrows, home/end, escape, tab)
- Use `x-trap` for focus management
- Ensure WCAG AA contrast compliance

## Laravel Best Practices
- Use `php artisan make:*` commands with `--no-interaction`
- Prefer Eloquent over raw queries, avoid `DB::`
- Use Form Request classes for validation
- Never use `env()` outside config files
- Models: use `casts()` method, proper relationship type hints
- Laravel 12 structure: no middleware files, use `bootstrap/app.php`

## Livewire
- Single root element required
- State lives on server
- Use `wire:key` in loops
- `wire:model` is deferred by default, use `wire:model.live` for real-time
- Alpine included automatically (plugins: persist, intersect, collapse, focus)
- Use entangleable system for Alpine ↔ Livewire sync

## Testing
- Write Pest tests for all changes
- Browser tests in `tests/Browser/`
- Run minimal tests: `php artisan test --filter=testName`
- Test all paths: happy, failure, edge cases
- No verification scripts if tests exist

## Tailwind v4
- Import: `@import "tailwindcss";` (not `@tailwind` directives)
- Use `gap` for spacing, not margins
- Theme variables auto-generate utilities
- Deprecated utilities replaced (see table in full docs)
- Support dark mode with `dark:` prefix

## Documentation
- Location: `packages/strata-ui/docs/`
- Style: simple, straightforward, scannable
- Update docs for every component change
- Only create docs if explicitly requested

## Performance
- Use `wire:init` for lazy loading
- Use `wire:ignore` to prevent morphing
- `@once` for scripts/styles
- `x-show` for frequent toggles, `x-if` for rare renders
- Use event modifiers: `.prevent`, `.stop`, `.debounce`

## Package Structure
```
packages/strata-ui/
├── config/strata-ui.php
├── resources/
│   ├── css/theme.css
│   ├── js/app.js
│   └── views/components/
├── src/Components/
└── tests/
```

## Quick Reference

### Service Provider
- Namespace autoloading: `Blade::componentNamespace('Strata\\UI\\Components', 'strata')`
- Usage: `<x-strata::button />`

### Variant System
- Standard: `primary`, `outline`, `ghost`, `destructive`, `success`, `warning`, `info`
- Sizes: `xs`, `sm`, `md`, `lg`, `xl`

### Slot Names
- Common: `header`, `footer`, `icon`, `prefix`, `suffix`, `content`

### Keyboard Nav
- Arrow keys: navigate lists/menus/tabs
- Home/End: first/last item
- Escape: close/cancel
- Enter/Space: activate/toggle
- Tab: focus navigation