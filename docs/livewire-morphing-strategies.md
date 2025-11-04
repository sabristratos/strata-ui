# Livewire Morphing Strategies

This document outlines proven strategies for building Alpine.js components that work reliably with Livewire's DOM morphing system, based on analysis of WireUI's DatetimePicker and our own testing.

## Table of Contents
- [Understanding the Problem](#understanding-the-problem)
- [Core Strategies](#core-strategies)
- [Implementation Patterns](#implementation-patterns)
- [Best Practices Checklist](#best-practices-checklist)
- [Common Pitfalls](#common-pitfalls)

---

## Understanding the Problem

Livewire uses DOM morphing (via morphdom) to efficiently update the page after server responses. When you have complex Alpine.js components with their own state management, morphing can cause issues:

1. **State Loss**: Alpine component state resets when elements are morphed
2. **Event Listener Loss**: Event listeners attached by Alpine may be removed
3. **Reference Breakage**: `x-ref` references can become stale after morphing
4. **Binding Conflicts**: Two-way binding between Alpine and Livewire can create update loops

### When Morphing Becomes Problematic

Morphing issues typically arise in components with:
- Complex state (arrays, objects, nested data)
- Positioned elements (dropdowns, popovers, tooltips)
- Multiple interactive parts (calendar grids, multi-select chips)
- External DOM references (Floating UI, third-party libraries)

---

## Core Strategies

### 1. Hidden Input Pattern

**The Problem**: Direct `wire:model` binding on Alpine properties causes conflicts when Livewire morphs the DOM.

**The Solution**: Use a hidden input as the source of truth for Livewire, and sync Alpine state to it.

```blade
<!-- Wrap in hidden div with hidden attribute -->
<div class="hidden" hidden>
    <input
        type="hidden"
        id="{{ $componentId }}"
        name="{{ $name }}"
        value="{{ $value }}"
        x-ref="input"
        x-bind:value="entangleable.value"
        data-strata-field-type="{{ $type }}"
    />
</div>
```

**Key attributes:**
- `class="hidden"` - CSS hiding (backup)
- `hidden` - HTML attribute prevents Livewire from considering it during morphing
- `x-ref="input"` - Alpine reference for synchronization
- `x-bind:value` - Keep input in sync with Alpine state
- `data-strata-field-type` - Reliable targeting after morphing

**Why this works:**
1. The hidden input is a simple, predictable HTML element
2. Livewire can track and update it reliably
3. Alpine manages complex state separately
4. The `hidden` attribute signals to Livewire's morphing algorithm to treat it as stable

---

### 2. Entangleable Mediator Pattern

**The Problem**: Direct two-way binding between Alpine and Livewire creates race conditions and update loops.

**The Solution**: Use an intermediary state container (Entangleable) that coordinates updates.

```javascript
// In Alpine component
init() {
    // Initialize Entangleable with initial value
    this.entangleable = new window.StrataEntangleable(initialValue);

    // Auto-detect wire:model from hidden input
    const input = this.$el.querySelector('[data-strata-datepicker-input]');
    if (input) {
        this.entangleable.setupLivewire(this, input);
    }

    // React to value changes
    this.entangleable.watch((newValue) => {
        // Update UI based on new value
        this.syncCalendar();
    });
}
```

**Benefits:**
- Decouples Alpine state from Livewire state
- Provides transformation layer (date objects ↔ strings)
- Prevents morphing from breaking synchronization
- Allows multiple watchers for different UI updates

**When to use Entangleable:**
- Multi-value components (multi-select, date ranges)
- Components needing data transformation (dates, formatted numbers)
- Components with complex internal state
- Components requiring multiple watchers

**When NOT to use Entangleable:**
- Simple single-value inputs (use direct `wire:model`)
- Checkbox/radio/toggle (use direct `wire:model`)
- Static components without state changes

---

### 3. x-show Over x-if

**The Problem**: `x-if` adds/removes elements from the DOM, creating an inconsistent structure that confuses morphing algorithms.

**The Solution**: Always use `x-show` for conditional visibility in Livewire-controlled components.

```blade
<!-- ✅ CORRECT: Use x-show (CSS display toggling) -->
<div x-show="open" class="...">
    Dropdown content
</div>

<!-- ✅ CORRECT: Multiple conditions with x-show -->
<div x-show="selectedDates.length > 0">
    <template x-for="date in selectedDates">
        <span>{{ date }}</span>
    </template>
</div>

<!-- ❌ WRONG: x-if changes DOM structure -->
<template x-if="open">
    <div>Dropdown content</div>
</template>
```

**Animation with x-show:**

Use CSS `@starting-style` instead of `x-transition`:

```blade
<div x-show="open"
     class="transition-all transition-discrete duration-150
            opacity-100 scale-100
            starting:opacity-0 starting:scale-95">
    Content appears with animation
</div>
```

**Exception**: Use `x-if` only when you genuinely need to prevent rendering (heavy content, security-sensitive data).

---

### 4. Strategic x-ref Usage

**The Problem**: DOM queries using selectors can break after morphing if element order changes.

**The Solution**: Use `x-ref` for critical elements and data attributes for queries.

```blade
<!-- Main component wrapper -->
<div x-data="datePicker" data-strata-datepicker>

    <!-- Hidden input reference -->
    <input
        x-ref="input"
        data-strata-datepicker-input
    />

    <!-- Dropdown reference -->
    <div
        x-ref="dropdown"
        data-strata-datepicker-dropdown
    >
        <!-- Options -->
        <div data-strata-datepicker-option>...</div>
    </div>
</div>
```

**In JavaScript:**
```javascript
// ✅ GOOD: Use x-ref for direct references
const input = this.$refs.input;

// ✅ GOOD: Use data attributes with querySelector
const options = this.$el.querySelectorAll('[data-strata-datepicker-option]');

// ✅ GOOD: Use closest to find parent
const component = this.$el.closest('[data-strata-datepicker]');

// ❌ BAD: Index-based traversal
const sibling = this.$el.nextElementSibling; // Breaks after morphing
```

---

### 5. x-cloak for Initialization

**The Problem**: During Alpine initialization, there can be a flash where Alpine directives are visible before processing, causing morphing conflicts.

**The Solution**: Use `x-cloak` on elements that should be hidden during initialization.

```blade
<!-- Hide until Alpine initializes -->
<button
    x-cloak
    x-show="entangleable.isNotEmpty()"
    @click="clear()"
>
    Clear
</button>
```

**Add to your CSS:**
```css
[x-cloak] {
    display: none !important;
}
```

---

### 6. Configuration via :x-props

**The Problem**: Hardcoding configuration in Alpine components makes them hard to test and customize.

**The Solution**: Pass all configuration from Blade via `:x-props`.

```blade
<div x-data="datePickerComponent"
     :x-props="{
         mode: '{{ $mode }}',
         format: '{{ $format }}',
         minDate: '{{ $minDate }}',
         maxDate: '{{ $maxDate }}',
         timezone: '{{ $timezone }}',
         weekStart: {{ $weekStart }},
         disabled: {{ $disabled ? 'true' : 'false' }}
     }">
```

**In Alpine component:**
```javascript
Alpine.data('datePickerComponent', (props = {}) => ({
    mode: props.mode || 'single',
    format: props.format || 'Y-m-d',
    minDate: props.minDate || null,
    // ... use props throughout

    init() {
        // Configuration already available
        this.setupCalendar();
    }
}));
```

**Benefits:**
- Server-side type safety
- No runtime configuration parsing
- Easier testing
- Consistent initialization

---

### 7. Wire Model Extraction (Advanced)

**The Pattern**: WireUI extracts `wire:model` configuration server-side and passes it to Alpine for setup.

```php
// In component class
public function getWireModelConfig(): array
{
    $wireModel = $this->attributes->whereStartsWith('wire:model')->first();

    if (!$wireModel) {
        return ['exists' => false];
    }

    // Extract modifiers: wire:model.live.debounce.500ms
    $name = str($wireModel)->after('wire:model.')->before('.')->value();
    $modifiers = str($wireModel)->after('wire:model.')->explode('.');

    return [
        'exists' => true,
        'name' => $name,
        'modifiers' => $modifiers->toArray(),
        'livewireId' => $this->id ?? null,
    ];
}
```

```blade
<!-- Pass to Alpine -->
<div x-data="component"
     :x-props="{
         wireModel: @js($this->getWireModelConfig())
     }">
```

**Benefits:**
- Explicit wire:model handling
- Support for modifiers (live, debounce, throttle)
- Testable configuration
- No runtime detection

---

## Implementation Patterns

### Pattern 1: Simple Form Component (Input, Textarea)

Use direct `wire:model` - no need for Entangleable:

```blade
<input
    type="text"
    wire:model="{{ $model }}"
    {{ $attributes->class(['border', 'rounded']) }}
/>
```

---

### Pattern 2: Complex State Component (Select, Date Picker)

Use Entangleable + Hidden Input:

```blade
<!-- Hidden input for wire:model -->
<div class="hidden" hidden>
    <input
        type="hidden"
        x-ref="input"
        x-bind:value="entangleable.value"
        data-strata-datepicker-input
    />
</div>

<!-- Visible UI -->
<div x-show="open" class="...">
    <!-- Complex interactions here -->
</div>
```

```javascript
Alpine.data('datePicker', (props = {}) => ({
    entangleable: null,
    open: false,

    init() {
        this.entangleable = new window.StrataEntangleable(props.initialValue);

        const input = this.$el.querySelector('[data-strata-datepicker-input]');
        if (input) {
            this.entangleable.setupLivewire(this, input);
        }

        this.entangleable.watch((value) => {
            this.updateUI();
        });
    }
}));
```

---

### Pattern 3: Positioned Component (Dropdown, Popover)

Use Positionable + Entangleable:

```blade
<div x-data="dropdown" data-strata-dropdown>
    <!-- Trigger -->
    <button x-ref="trigger" @click="toggle()">
        Toggle
    </button>

    <!-- Dropdown (positioned) -->
    <div x-show="open"
         x-ref="dropdown"
         :style="positionable.styles"
         class="...">
        <!-- Content -->
    </div>
</div>
```

```javascript
Alpine.data('dropdown', () => ({
    open: false,
    positionable: null,

    init() {
        this.positionable = new window.StrataPositionable({
            placement: 'bottom-start',
            offset: 8,
            strategy: 'absolute'
        });

        this.positionable.start(this, this.$refs.trigger, this.$refs.dropdown);

        this.$watch('open', (value) => {
            if (value) {
                this.positionable.open();
            } else {
                this.positionable.close();
            }
        });
    },

    toggle() {
        this.open = !this.open;
    }
}));
```

---

## Best Practices Checklist

Use this checklist when building or reviewing Livewire-compatible Alpine components:

### HTML/Blade
- [ ] Hidden input uses `class="hidden" hidden` attributes
- [ ] Hidden input has `x-ref="input"` for Alpine access
- [ ] Hidden input uses `x-bind:value` to sync with Alpine state
- [ ] All conditional visibility uses `x-show`, NOT `x-if`
- [ ] Critical elements have `x-ref` attributes
- [ ] All interactive elements have `data-strata-*` attributes
- [ ] Components use `data-strata-field-type` attribute
- [ ] Elements use `x-cloak` where appropriate
- [ ] Animations use CSS `@starting-style`, NOT `x-transition`

### JavaScript
- [ ] Complex components use Entangleable for state
- [ ] Entangleable initialized with proper default value
- [ ] `setupLivewire()` called when wire:model detected
- [ ] Positioned components use Positionable module
- [ ] Positionable uses `strategy: 'absolute'` (NOT 'fixed')
- [ ] Configuration passed via `:x-props`, not hardcoded
- [ ] DOM queries use data attributes, not traversal
- [ ] Watchers properly clean up on destroy
- [ ] NO direct `wire:model` on Alpine properties

### PHP/Component Class
- [ ] Initial value normalized in component class
- [ ] Size/state/variant maps defined in PHP
- [ ] Timezone/formatting handled server-side
- [ ] Wire model extraction if needed (advanced)
- [ ] Props validated and have sensible defaults

### Testing
- [ ] Test with Livewire morphing scenarios
- [ ] Test wire:model binding in both directions
- [ ] Test with multiple instances on same page
- [ ] Test with rapid state changes
- [ ] Test positioned elements after morphing

---

## Common Pitfalls

### Pitfall 1: Using x-if in Livewire Components
```blade
<!-- ❌ WRONG -->
<template x-if="open">
    <div>Content</div>
</template>

<!-- ✅ CORRECT -->
<div x-show="open">
    Content
</div>
```

### Pitfall 2: Direct wire:model on Alpine Properties
```javascript
// ❌ WRONG
Alpine.data('component', () => ({
    value: @entangle('value')  // Breaks during morphing
}));

// ✅ CORRECT
Alpine.data('component', () => ({
    entangleable: null,
    init() {
        this.entangleable = new window.StrataEntangleable(initialValue);
        this.entangleable.setupLivewire(this, this.$refs.input);
    }
}));
```

### Pitfall 3: Index-Based DOM Traversal
```javascript
// ❌ WRONG - Breaks after morphing
const next = this.$el.nextElementSibling;

// ✅ CORRECT - Use data attributes
const next = this.$el.parentElement.querySelector('[data-strata-next]');
```

### Pitfall 4: Missing hidden Attribute
```blade
<!-- ❌ WRONG - Still visible to morphing -->
<div class="hidden">
    <input x-bind:value="value" />
</div>

<!-- ✅ CORRECT - Protected from morphing -->
<div class="hidden" hidden>
    <input x-bind:value="value" />
</div>
```

### Pitfall 5: Forgetting x-cloak
```blade
<!-- ❌ WRONG - Flash of Alpine syntax -->
<button x-show="hasValue" @click="clear()">
    Clear
</button>

<!-- ✅ CORRECT - Hidden until Alpine loads -->
<button x-cloak x-show="hasValue" @click="clear()">
    Clear
</button>
```

### Pitfall 6: Using x-transition
```blade
<!-- ❌ WRONG - Conflicts with morphing -->
<div x-show="open" x-transition>
    Content
</div>

<!-- ✅ CORRECT - Use CSS -->
<div x-show="open"
     class="transition-all duration-150
            opacity-100 starting:opacity-0">
    Content
</div>
```

---

## Real-World Example: Date Picker

Complete implementation following all strategies:

```blade
<!-- packages/strata-ui/resources/views/components/date-picker/index.blade.php -->
<div x-data="datePickerComponent"
     :x-props="{
         mode: '{{ $mode }}',
         initialValue: '{{ $value }}',
         format: '{{ $format }}',
         minDate: '{{ $minDate }}',
         maxDate: '{{ $maxDate }}'
     }"
     data-strata-datepicker
     class="relative">

    <!-- Hidden input for wire:model -->
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name }}"
            x-ref="input"
            x-bind:value="entangleable.value"
            data-strata-datepicker-input
            data-strata-field-type="date"
        />
    </div>

    <!-- Visible input (trigger) -->
    <input
        type="text"
        x-ref="trigger"
        :value="displayValue"
        @click="open = true"
        @focus="open = true"
        readonly
        {{ $attributes->class(['border', 'rounded']) }}
    />

    <!-- Clear button (with x-cloak) -->
    <button
        x-cloak
        x-show="entangleable.value"
        @click="clear()"
        type="button"
    >
        Clear
    </button>

    <!-- Calendar dropdown (positioned) -->
    <div x-show="open"
         x-ref="dropdown"
         @click.outside="open = false"
         :style="positionable.styles"
         data-strata-datepicker-dropdown
         class="transition-all transition-discrete duration-150
                opacity-100 scale-100
                starting:opacity-0 starting:scale-95">

        <!-- Calendar grid -->
        <div class="grid grid-cols-7 gap-1">
            <template x-for="day in calendar.days" :key="day.date">
                <button
                    @click="selectDate(day)"
                    :class="{
                        'bg-primary text-primary-foreground': day.isSelected,
                        'opacity-50': day.isDisabled
                    }"
                    data-strata-datepicker-day
                >
                    <span x-text="day.label"></span>
                </button>
            </template>
        </div>
    </div>
</div>
```

```javascript
// packages/strata-ui/resources/js/date-picker.js
Alpine.data('datePickerComponent', (props = {}) => ({
    entangleable: null,
    positionable: null,
    open: false,
    calendar: {},

    init() {
        // Initialize Entangleable
        this.entangleable = new window.StrataEntangleable(props.initialValue || null);

        // Setup Livewire sync
        const input = this.$el.querySelector('[data-strata-datepicker-input]');
        if (input) {
            this.entangleable.setupLivewire(this, input);
        }

        // Watch for value changes
        this.entangleable.watch((value) => {
            this.updateCalendar();
        });

        // Initialize Positionable
        this.positionable = new window.StrataPositionable({
            placement: 'bottom-start',
            offset: 8,
            strategy: 'absolute'
        });

        this.positionable.start(this, this.$refs.trigger, this.$refs.dropdown);

        // Sync positioning with open state
        this.$watch('open', (value) => {
            if (value) {
                this.positionable.open();
            } else {
                this.positionable.close();
            }
        });

        // Initial calendar render
        this.updateCalendar();
    },

    get displayValue() {
        return this.entangleable.value
            ? this.formatDate(this.entangleable.value)
            : '';
    },

    selectDate(day) {
        if (day.isDisabled) return;

        this.entangleable.value = day.date;
        this.open = false;
    },

    clear() {
        this.entangleable.value = null;
        this.open = false;
    },

    updateCalendar() {
        // Update calendar UI based on current value
        this.calendar = this.generateCalendar();
    },

    generateCalendar() {
        // Calendar generation logic
        return {
            days: [/* ... */]
        };
    },

    formatDate(date) {
        // Format for display
        return date;
    }
}));
```

---

## Summary

Building Alpine.js components that work reliably with Livewire morphing requires:

1. **Separation of concerns**: Hidden input for Livewire, Alpine for UI
2. **Explicit state management**: Use Entangleable as a mediator
3. **Consistent DOM structure**: Use `x-show`, not `x-if`
4. **Reliable targeting**: Use data attributes and `x-ref`
5. **Configuration over convention**: Pass settings via `:x-props`

Following these patterns will result in components that are:
- Morphing-resistant
- Easy to test
- Maintainable
- Predictable
- Performant

---

**Last updated**: 2025-11-04
**References**: WireUI DatetimePicker analysis, Strata UI testing
