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

**Livewire Morphing Compatibility:**

For detailed strategies on building Alpine components that work seamlessly with Livewire's DOM morphing, see [Livewire Morphing Strategies](docs/livewire-morphing-strategies.md).

**Key patterns for morphing-resistant components:**
- Hidden input with `class="hidden" hidden` for Entangleable components
- `x-show` over `x-if` for predictable DOM structure
- Strategic `x-ref` and data attributes for reliable DOM queries
- Attribute filtering with `whereDoesntStartWith('wire:model')` and `whereStartsWith('wire:model')`

**About wire:ignore:**

You may notice some components use `wire:ignore`. This directive is ONLY needed for:
- ✅ Components with complex external libraries (Editor.js, Chart.js)
- ✅ Components where Livewire must NEVER morph the content
- ✅ Calendar component (complex date grid manipulation)

For most Entangleable components, `wire:ignore` is **NOT needed** because:
- ❌ Hidden input + Entangleable pattern handles Livewire sync
- ❌ Alpine manages UI independently
- ❌ Morphing doesn't break the pattern

**Examples:**
- ✅ Uses `wire:ignore`: Calendar, Editor (complex DOM, external libs)
- ❌ No `wire:ignore`: Date Picker, Time Picker, Select (hidden input pattern)

### Positioning Strategy

**Use Floating UI for ALL positioned elements** (dropdowns, popovers, tooltips, menus).

Pattern:
- `x-show` for visibility
- `:style="positionable.styles"` for positioning
- `strategy: 'absolute'` (NOT 'fixed')
- NO `animationFrame: true` in autoUpdate (causes issues with 4+ components)
- Disable on mobile (`< 640px`)

### Alpine vs Blade Separation of Concerns

**CRITICAL:** Blade handles static rendering and PHP logic, Alpine handles runtime interactivity ONLY.

**Blade Responsibilities:**
- Static HTML structure and markup
- PHP-based prop processing (sizes, variants, states)
- CSS class assignment from PHP variables/maps
- Slot rendering and content projection
- Initial value normalization and defaults
- `wire:ignore` placement for Alpine-managed DOM areas
- **ALL Tailwind class definitions** (never in Alpine)

**Alpine Responsibilities:**
- Runtime interactivity (clicks, hovers, keyboard events)
- Dynamic state management (open/closed, selected values, search)
- DOM updates (show/hide, filter, highlight, scroll)
- Livewire synchronization via Entangleable
- Dropdown positioning via Positionable
- Computed properties and reactive watchers
- Event listeners and dispatchers

**Styling Rules (NON-NEGOTIABLE):**
- ✅ **Tailwind classes ALWAYS written in Blade templates**
- ✅ **Alpine ONLY toggles predefined classes using `:class`**
- ❌ **NEVER generate class strings in Alpine** (no `'h-' + size` or ternary class selection)
- ❌ **NEVER use x-transition** (use CSS `@starting-style` instead)

**Critical Pattern Examples:**

```blade
<!-- ✅ CORRECT: Blade assigns all classes, Alpine toggles them conditionally -->
<div class="transition-all duration-200 rotate-0"
     :class="{ 'rotate-180': open }">

<!-- ✅ CORRECT: Multiple conditional classes -->
<div class="px-4 py-2 rounded-md"
     :class="{
         'bg-primary text-primary-foreground': isSelected,
         'hover:bg-accent': !isSelected,
         'opacity-40': isDisabled
     }">

<!-- ✅ CORRECT: Blade handles size variants -->
@php
$sizes = [
    'sm' => 'h-9 px-3 text-sm',
    'md' => 'h-10 px-3 text-base',
    'lg' => 'h-11 px-4 text-lg',
];
@endphp
<button class="{{ $sizes[$size] }}">

<!-- ❌ WRONG: Generating classes in Alpine -->
<div :class="open ? 'block' : 'hidden'">  <!-- Use x-show instead! -->

<!-- ❌ WRONG: Building class strings -->
<div :class="'h-' + size + ' px-' + padding">  <!-- Do this in Blade! -->

<!-- ❌ WRONG: Using x-transition -->
<div x-show="open" x-transition>  <!-- Use CSS @starting-style instead! -->
```

**Livewire Integration Pattern:**

In Livewire components, **NEVER call methods directly in Blade attributes**:

```php
// ❌ WRONG: Method call in Blade
<x-component :prop="$this->getComputedValue()" />

// ✅ CORRECT: Use property updated via hook
class MyComponent extends Component {
    public array $computedValue = [];

    public function updatedSomeProperty(): void {
        $this->computedValue = $this->getComputedValue();
    }
}
```

```blade
<!-- Then in Blade -->
<x-component :prop="$computedValue" />
```

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

### Component Props Pattern

All Strata UI components use `@props([...])` directive to extract and declare component props:

**Implementation:**
```blade
@props([
    'id' => null,
    'name' => null,
    'size' => 'md',
    'state' => 'default',
    'disabled' => false,
    'clearable' => true,
    // ... all props with defaults
])

@php
// Process props in PHP
$componentId = $id ?? $attributes->get('id') ?? 'component-' . uniqid();
$sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'relative']) }}>
    <!-- Component markup -->
</div>
```

**Benefits:**
- Explicit prop declaration with defaults
- Removes props from `$attributes` bag (prevents HTML attribute pollution)
- Type-safe in IDE with Laravel Blade Plugin
- Clear API surface for component users
- Self-documenting component interface

**Why NOT `$attributes->get('prop', 'default')`:**
- `@props` is Laravel's official pattern for components
- Auto-completes in IDEs with proper plugins
- Props are extracted before rendering, preventing attribute leakage
- More maintainable and consistent across codebase

**Required for all components:** Every Strata UI component must declare its props using `@props([...])`.

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

## Best Practice Patterns

These patterns have been proven in the codebase and should be replicated in new components:

### 1. Entangleable Setup Pattern

For components needing bidirectional Alpine ↔ Livewire sync (Select, Calendar, Date Picker, Rating):

**JavaScript:**
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

**Blade: Attribute Filtering Pattern**

For components using Entangleable with hidden inputs, filter `wire:model` attributes correctly:

```blade
@props([
    'id' => null,
    'name' => null,
    // ... other props
])

<div
    x-data="window.strataDatePicker({ ... })"
    data-strata-datepicker
    data-strata-field-type="date"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative']) }}
>
    <!-- Hidden input for Livewire binding -->
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="input"
            x-bind:value="JSON.stringify(entangleable.value)"
            data-strata-datepicker-input
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    <!-- Trigger and dropdown markup -->
</div>
```

**Why Filter Attributes:**
- `whereDoesntStartWith('wire:model')` - Apply all attributes EXCEPT wire:model to wrapper
- `whereStartsWith('wire:model')` - Apply ONLY wire:model to hidden input
- Prevents duplicate wire:model on both wrapper and input
- Keeps Livewire binding on the correct element (hidden input)
- Wrapper gets other attributes like `class`, `id`, custom data attributes

**When to Use:**
- ✅ Required for Entangleable components with hidden inputs (Date Picker, Time Picker, Select with form mode)
- ❌ Not needed for simple components with direct wire:model (Input, Textarea, Checkbox)

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

### 8. Reactive Display Property Pattern

For components that need to format/display Entangleable values (Date Picker, Time Picker):

**❌ WRONG: Computed Getter (Breaks Alpine Reactivity)**
```javascript
return {
    entangleable: null,

    get display() {
        // Alpine doesn't track changes to entangleable.value
        return this.computeDisplay(this.entangleable.value);
    }
}
```

**Problem:** Alpine's reactivity doesn't track external object properties like `entangleable.value`. The getter won't re-evaluate when the value changes.

**✅ CORRECT: Reactive Property + Watcher**
```javascript
return {
    entangleable: null,
    display: '',  // Reactive Alpine property

    init() {
        this.entangleable = new window.StrataEntangleable(initialValue);

        // Update display when entangleable value changes
        this.entangleable.watch((newValue) => {
            this.display = this.computeDisplay(newValue);
        });

        // Set initial display
        this.display = this.computeDisplay(this.entangleable.value);
    },

    // Helper method (not getter)
    computeDisplay(value) {
        if (!value) return '';
        return this.formatDate(value);  // or formatTime, formatNumber, etc.
    }
}
```

**Why This Works:**
- Alpine tracks `display` as a reactive property
- Watcher updates `display` when entangleable changes
- Template reactively updates when `display` changes
- Computed helper avoids duplicate logic
- Display value is cached for performance

**When to Use:**
- ✅ Components displaying formatted Entangleable values (dates, times, numbers)
- ✅ Components needing reactive computed displays
- ✅ Anywhere Alpine reactivity on computed values is needed
- ❌ Simple getters that don't depend on external objects

**Used In:**
- Date Picker (formats dates as "Jan 15, 2025" or "Jan 15 - Jan 20, 2025")
- Time Picker (formats times as "2:30 PM" or "14:30")

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

### Testing Approaches

Strata UI uses three complementary testing approaches:

**1. Feature Tests (Primary Approach)**
- **Purpose:** Test component rendering, props, classes, attributes
- **Tool:** Pest with `expectComponent()` helper
- **Location:** `packages/strata-ui/tests/Feature/Components/`
- **When to use:** All components, all variants, all states
- **Example:** `DatePickerRenderingTest.php`, `ButtonRenderingTest.php`

**2. Livewire Integration Tests**
- **Purpose:** Test `wire:model` binding, state synchronization, Livewire morphing compatibility
- **Tool:** Pest with real Livewire components
- **Location:** `packages/strata-ui/tests/Feature/`
- **When to use:** Components using Entangleable, value objects, custom Livewire synthesizers
- **Example:** `ValueObjectsLivewireTest.php`

**3. Demo Components (Manual Testing)**
- **Purpose:** Manual browser testing during development
- **Tool:** Real Livewire components in development app
- **Location:** `app/Livewire/` (development app, not package)
- **When to use:** Interactive testing, visual QA, user experience validation
- **Example:** `AppointmentBookingDemo.php`

**Priority Order:**
1. Write Feature tests for all components (required)
2. Add Livewire Integration tests for Entangleable components (recommended)
3. Create Demo components for complex interactions (optional)

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
