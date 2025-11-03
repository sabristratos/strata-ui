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

## Best Practice Patterns

These patterns have been proven in the codebase and should be replicated in new components:

### 1. Entangleable Setup Pattern

For components needing bidirectional Alpine ↔ Livewire sync (Select, Calendar, Date Picker, Rating):

```javascript
init() {
    // Initialize Entangleable with default value
    this.entangleable = new window.StrataEntangleable(initialValue);

    // Auto-detect wire:model from hidden input
    const input = this.$el.querySelector('[data-strata-select-input]');
    if (input) {
        this.entangleable.setupLivewire(this, input);
    }

    // Watch for changes and react
    this.entangleable.watch((newValue) => {
        // Update UI based on new value
        this.updateChips();
    });
}
```

### 2. Positionable Setup Pattern

For positioned components (Dropdown, Popover, Tooltip, Date Picker):

```javascript
init() {
    // Initialize Positionable with config
    this.positionable = new window.StrataPositionable({
        placement: 'bottom-start',
        offset: 8,
        strategy: 'absolute'  // ALWAYS absolute, never 'fixed'
    });

    // Connect trigger and floating elements
    const content = this.$refs.content;
    const trigger = document.querySelector('[data-dropdown-trigger="id"]');

    if (content && trigger) {
        this.positionable.start(this, trigger, content);
    }

    // Sync positioning with open state
    this.$watch('open', (value) => {
        if (value) {
            this.positionable.open();
        } else {
            this.positionable.close();
        }
    });

    // Handle external closes
    this.positionable.watch((state) => {
        if (!state) {
            this.open = false;
        }
    });
}
```

### 3. Nested Alpine Scope Pattern

Child components can access parent Alpine scope directly - no need for events or stores:

```blade
<!-- Parent: calendar/header.blade.php -->
<div x-data="{
    showMonthPicker: false,
    currentMonth: new Date(),
    goToMonth(month) { ... }
}">
    <!-- Child can access ALL parent scope properties -->
    <x-strata::calendar.month-picker />
</div>

<!-- Child: calendar/month-picker.blade.php -->
<div x-show="showMonthPicker"
     @click.outside="showMonthPicker = false">

    <button @click="goToMonth(month)">
        <!-- Direct access to parent methods! -->
    </button>
</div>
```

**When to use:**
- Parent-child communication (Month Picker → Header → Calendar)
- Dropdown submenus accessing parent state
- Modal/dialog content accessing trigger state

**Alternatives:**
- `Alpine.store()` for true global state
- `$dispatch()` for event-based communication across tree

### 4. CSS Animation Pattern

Always use CSS with `@starting-style`, never Alpine `x-transition`:

```blade
<div x-show="open"
     class="transition-all transition-discrete duration-150 ease-out
            will-change-[transform,opacity]
            opacity-100 scale-100
            starting:opacity-0 starting:scale-95">
```

**Key classes:**
- `transition-discrete` - Required for discrete properties
- `will-change-[transform,opacity]` - Performance optimization
- `starting:*` - Entry state (replaces x-transition-enter-from)
- `opacity-100 scale-100` - Default state

### 5. Component Size/State Maps

Consistent pattern across all components:

```php
$sizes = [
    'sm' => 'h-9 px-3 text-sm',
    'md' => 'h-10 px-3 text-base',
    'lg' => 'h-11 px-4 text-lg',
];

$states = [
    'default' => 'border-border focus:ring-ring',
    'success' => 'border-success focus:ring-success/20',
    'error' => 'border-destructive focus:ring-destructive/20',
    'warning' => 'border-warning focus:ring-warning/20',
];

$sizeClasses = $sizes[$size] ?? $sizes['md'];
$stateClasses = $states[$state] ?? $states['default'];
```

### 6. Data Attribute Pattern

Consistent naming for reliable DOM queries:

```blade
<div data-strata-{component}>
    <input
        data-strata-{component}-input
        data-strata-field-type="{type}"
    />
    <div data-strata-{component}-dropdown>
        <div data-strata-{component}-option>
            ...
        </div>
    </div>
</div>
```

**JavaScript usage:**
```javascript
// Find parent component
this.$el.closest('[data-strata-select]')

// Find child elements
this.$el.querySelector('[data-strata-select-input]')
this.$el.querySelectorAll('[data-strata-select-option]')

// Filter by field type (CSS or JS)
document.querySelectorAll('[data-strata-field-type="select"]')
```

### 7. ID Generation Pattern

Standardized across all components:

```php
$componentId = $id ?? $attributes->get('id') ?? '{component}-' . uniqid();
```

**Examples:**
- `'dropdown-' . uniqid()`
- `'tooltip-' . uniqid()`
- `'checkbox-' . uniqid()`

**DO NOT use:**
- `Str::random()` - inconsistent
- Custom prefixes without `uniqid()` - collision risk

## Testing Strategy

### Test Structure

**Package Tests:** `packages/strata-ui/tests/`
- Unit tests for PHP components
- Feature tests for Blade rendering
- JavaScript tests for Alpine modules

**Test Infrastructure:**
- Orchestra Testbench for isolated package testing
- Pest 4 for PHP tests
- Vitest for JavaScript tests

### Running Tests

```bash
# PHP Tests (from package directory)
cd packages/strata-ui
composer test

# JavaScript Tests
npm test              # Run once
npm run test:watch    # Watch mode
npm run test:ui       # UI mode
npm run test:coverage # With coverage

# From root directory
vendor/bin/pest packages/strata-ui/tests
```

### Writing Component Tests

**Use `expectComponent()` helper for Blade components:**

```php
test('renders with default props', function () {
    expectComponent('button', slot: 'Click Me')
        ->toHaveTag('button')
        ->toHaveAttribute('type', 'button')
        ->toHaveClasses('bg-primary', 'text-primary-foreground')
        ->toRenderSlot('Click Me');
});

test('renders all sizes', function () {
    expectComponent('input', ['size' => 'sm'])
        ->toHaveClasses('h-9', 'px-3', 'text-sm');

    expectComponent('input', ['size' => 'lg'])
        ->toHaveClasses('h-11', 'px-4', 'text-lg');
});
```

**Custom Pest Expectations:**
- `expectComponent(component, attributes, slot)` - Render and test component
- `toHaveClasses(...classes)` - Assert CSS classes
- `toHaveDataAttribute(attr, value)` - Assert data attributes
- `toRenderSlot(content)` - Assert slot content
- `toHaveAttribute(attr, value)` - Assert HTML attributes
- `toHaveTag(tag)` - Assert HTML tag

**JavaScript Testing Pattern:**

```javascript
import { describe, it, expect, beforeEach, vi } from 'vitest';
import Entangleable from '../../resources/js/entangleable.js';

describe('Module Name', () => {
    let instance;

    beforeEach(() => {
        instance = new Entangleable();
    });

    test('functionality', () => {
        expect(instance.value).toBeNull();
    });
});
```

### Test Coverage Goals

**Phase 1 (Completed):**
- ✅ Test infrastructure setup
- ✅ Core form components (Button, Input, Textarea, Checkbox, Radio, Toggle, Group)
- ✅ JavaScript module (Entangleable)
- **Result:** 148 test cases (112 PHP + 36 JS)

**Phase 2 (Next):**
- Complex components (Select, Calendar, Date Picker, Rating)
- Positionable JavaScript module tests

**Phase 3 (Future):**
- Positioned components (Dropdown, Popover, Tooltip, Modal)
- Advanced components (Table, Accordion, Tabs, Toast, File Input)
- Presentational components (Badge, Avatar, Card, Alert, etc.)

### Test-Driven Development

When creating new components:
1. Write tests for expected behavior first
2. Implement component to pass tests
3. Verify all variants and edge cases
4. Check accessibility attributes

**Required test coverage for each component:**
- Default rendering
- All size variants
- All state/variant types
- Slot content rendering
- Custom class merging
- Accessibility attributes (sr-only, aria-*, role)
- Data attributes for JS targeting

## Code Quality Rules (Non-Negotiable)

1. **Absolutely no comments in code** (PHPDoc blocks allowed)
2. Use path of least resistance
3. No thin wrappers or unnecessary abstractions
4. No hacky solutions
5. Use modern, simple approaches
6. Check for existing components before creating new ones
7. Reuse existing components when building new ones
8. **If it's not tested, it's not production-ready**

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
