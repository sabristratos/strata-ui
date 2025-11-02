# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Strata UI is a modern Blade and Livewire component library for Laravel. This repository is structured as a monorepo:
- Root: Laravel app for testing/development
- `packages/strata-ui/`: The actual package being developed

**Tech Stack:**
- Laravel 12 + Livewire 3 + Tailwind CSS v4
- Alpine.js (included with Livewire)
- Floating UI for positioned elements
- Pest 4 for testing

## Development Commands

```bash
# Development
composer run dev              # Run server, queue, and Vite concurrently
npm run dev                   # Just Vite (in root)

# Testing
composer run test             # Run all tests
php artisan test --filter=name  # Run specific test

# Strata UI Package
php artisan strata:build      # Build package assets
php artisan strata:build --watch  # Watch package assets

# Code Quality
vendor/bin/pint              # Format code (run before committing)
```

## Strata UI Architecture

### Core Philosophy
- Sensible defaults with clean, beautiful UI
- Extensive customization without complexity
- Path of least resistance
- Modern web standards (HTML, Tailwind v4, PHP 8.3+)

### State Management

**Alpine for transient UI state, Livewire for persistence.**

Use `wire:model` for simple single-value interactions (checkbox, radio, toggle, basic inputs). Use Alpine for complex interactions (multi-select, file batch uploads, drag-and-drop, filtering) with deferred Livewire sync.

**Alpine State Scoping:**
- Alpine supports **nested data** - child components can access parent scope variables
- Child `x-data` can read and modify parent `x-data` properties
- Example: `<div x-data="{ open: false }"><div x-data="{}">` - inner div can access `open`
- Use this for parent-child component communication (dropdowns, modals, popovers)
- Alternative: Use `Alpine.store()` for global state or `$dispatch` for events

**Key Modules:**
- **Entangleable** (`resources/js/entangleable.js`) - Bidirectional Alpine ↔ Livewire state sync with watchers. Use for complex components needing state synchronization.
- **Positionable** (`resources/js/positionable.js`) - Floating UI integration for dropdowns, popovers, tooltips. Always use `strategy: 'absolute'`.

**Decision Matrix: Entangleable vs Direct wire:model**

Use **direct wire:model** for:
- Single value form inputs (text, email, number, etc.)
- Simple checkboxes and radios
- Toggles/switches
- Textareas
- Components without complex state transformations

Use **Entangleable** for:
- Multi-select components (value is array, needs watchers)
- Components with internal state that must sync to Livewire (calendar, date-picker)
- Components requiring state watchers for UI updates
- Components needing bidirectional sync with transformations (rating with precision)
- Components where state changes trigger complex Alpine logic

**Examples:**
- ✅ Direct wire:model: `<x-strata::input wire:model="email" />`
- ✅ Direct wire:model: `<x-strata::checkbox wire:model="agreed" />`
- ✅ Entangleable: Select component (multi-select with chips, search, clear)
- ✅ Entangleable: Calendar component (complex date selection modes)
- ✅ Entangleable: Rating component (half-star precision, hover states)
- ✅ Nested Alpine data: Month picker accessing parent header's `showMonthPicker` state

### Positioning Strategy

**Use Floating UI for ALL positioned elements** (dropdowns, popovers, tooltips, menus).

Pattern:
- `x-show` for visibility
- `:style="positionable.styles"` for positioning
- `strategy: 'absolute'` (NOT 'fixed')
- NO `animationFrame: true` in autoUpdate (causes issues with 4+ components)
- Disable on mobile (`< 640px`)

### Animations

**Use pure CSS animations with @starting-style**, not Alpine x-transition directives.

```blade
<div x-show="open"
     class="transition-all transition-discrete duration-100
            opacity-100 scale-100
            starting:opacity-0 starting:scale-95">
```

### Component Structure

**All components live in folders with `index.blade.php`:**
```
components/
  button/
    index.blade.php       → <x-strata::button />
    icon.blade.php        → <x-strata::button.icon />
  input/
    index.blade.php       → <x-strata::input />
    clear.blade.php       → <x-strata::input.clear />
```

Laravel auto-resolves `folder/index.blade.php` when you use `<x-strata::folder />`.

### Data Attributes

Use `data-strata-*` prefixed attributes for reliable element targeting:

**Naming Convention:**
- `data-strata-{component}` - Main component element (e.g., `data-strata-select`, `data-strata-dropdown`)
- `data-strata-{component}-wrapper` - Wrapper/container element
- `data-strata-{component}-input` - Hidden input for form submission
- `data-strata-{component}-{part}` - Sub-elements (e.g., `data-strata-select-dropdown`, `data-strata-select-option`)
- `data-strata-field-type="{type}"` - Field type identifier for all form components (e.g., `data-strata-field-type="select"`)

**Usage:**
- Use `closest('[data-strata-*]')` for finding parents
- Use `querySelector('[data-strata-*]')` for finding children
- Always add `data-strata-field-type` to form components for consistency

### Asset Management

Blade directives for including assets:
- `@strataStyles` - In `<head>`
- `@strataScripts` - Before `</body>`

Build process:
- Package has own `vite.config.js` in `packages/strata-ui/`
- Builds to `packages/strata-ui/public/build/`
- Published to host apps via `vendor:publish --tag=strata-ui-assets`

### Theming

Use CSS variables with `light-dark()` function:
```css
@theme {
  --color-primary: light-dark(blue, lightblue);
}
```

Tailwind auto-generates utilities: `bg-primary`, `text-primary`, etc.

### Documentation

- `docs/index.md` - Main hub
- `docs/{component}.md` - Component docs
- Write for package users, not developers
- Show variants, props tables, real examples
- Keep README.md minimal

### Testing Strategy

Test Livewire integration by creating demo components in `app/Livewire/` and including them on the welcome page. Test `wire:model`, state changes, validation, and interactions there.

## Code Quality Rules (Non-Negotiable)

1. **Absolutely no comments in code** (PHPDoc blocks allowed)
2. Use path of least resistance
3. No thin wrappers or unnecessary abstractions
4. No hacky solutions
5. Use modern, simple approaches
6. Check for existing components before creating new ones
7. Reuse existing components when building new ones

## Laravel Conventions

- Use `php artisan make:*` commands for creating files
- Form Request classes for validation (not inline)
- Eloquent over raw queries
- Named routes with `route()` function
- Environment variables only in config files (use `config()`, not `env()`)
- Explicit return types and type hints on all methods
- PHP 8 constructor property promotion
- Laravel 12 structure (no Kernel files, bootstrap/app.php for middleware)

## Livewire 3

- Use `wire:model.live` for real-time updates
- `wire:model` is deferred by default
- Components in `App\Livewire` namespace
- `$this->dispatch()` for events
- Add `wire:key` in loops
- Single root element per component

## Tailwind CSS v4

Import with `@import "tailwindcss";` (not `@tailwind` directives).

Use modern features:
- Container queries with `@container` and `@sm`/`@md` variants
- `starting:*` variant for entry animations
- `transition-discrete` for animating discrete properties
- `light-dark()` in `@theme` blocks

## Pest 4

- All tests use Pest (not PHPUnit)
- Use `php artisan make:test --pest <name>`
- Browser tests in `tests/Browser/`
- Run filtered: `php artisan test --filter=name`
- Use specific assertions: `assertSuccessful()` not `assertStatus(200)`

## Laravel Pint

Run `vendor/bin/pint` before committing changes to ensure code style compliance.
