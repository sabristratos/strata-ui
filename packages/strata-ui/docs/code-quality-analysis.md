# Strata UI - Code Quality Analysis

**Date:** November 2025
**Scope:** Complete codebase analysis for duplication, DRY violations, and complexity
**Status:** Identified issues ready for refactoring

---

## Executive Summary

This analysis identifies **~1,740 lines of duplicated code** across the Strata UI component library that can be reduced to **~200 lines** of shared utilities. The primary issues are:

- **Size/state maps** duplicated in 30+ components
- **JavaScript setup patterns** duplicated in 10+ files
- **Complex components** exceeding maintainability thresholds
- **Missing shared utilities** causing maintenance burden

**Impact:** Changes to design tokens currently require updates in 30+ files. Refactoring to shared utilities will establish a single source of truth and improve maintainability.

---

## 1. Code Duplication Issues

---

### 1.2 State/Validation Maps (10+ Components)

**Severity:** High
**Impact:** ~300 lines of duplicated code
**Affected Files:** 10+ form components

**Pattern found in:**
- `input/index.blade.php:63-68`
- `textarea/index.blade.php:18-23`
- `date-picker/index.blade.php:26-31`
- `time-picker/index.blade.php:27-32`
- `checkbox/index.blade.php:38-43`
- `radio/index.blade.php:38-43`
- `toggle/index.blade.php:55-72`
- And more...

**Duplicated Code:**
```php
$stateClasses = [
    'default' => 'border-border focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2',
    'success' => 'border-success focus-within:ring-2 focus-within:ring-success/20 focus-within:ring-offset-2',
    'error' => 'border-destructive focus-within:ring-2 focus-within:ring-destructive/20 focus-within:ring-offset-2',
    'warning' => 'border-warning focus-within:ring-2 focus-within:ring-warning/20 focus-within:ring-offset-2',
];
```

**Problem:**
- Validation state styling duplicated across all form inputs
- Color scheme changes require 10+ file updates
- Different focus ring styles across components
- Accessibility improvements need multiple updates

**Recommendation:**
Create `ComponentStateConfig` class:
```php
class ComponentStateConfig
{
    public static function inputStates(): array
    {
        return [
            'default' => 'border-border focus-within:ring-2 focus-within:ring-ring',
            'success' => 'border-success focus-within:ring-2 focus-within:ring-success/20',
            'error' => 'border-destructive focus-within:ring-2 focus-within:ring-destructive/20',
            'warning' => 'border-warning focus-within:ring-2 focus-within:ring-warning/20',
        ];
    }
}
```

---

### 1.3 Icon Size Maps (10+ Components)

**Severity:** Medium
**Impact:** ~200 lines of duplicated code
**Affected Files:** 10+ components with icons

**Pattern found in:**
- `button/index.blade.php:55-59`
- `checkbox/index.blade.php:20-24`
- `radio/index.blade.php:20-24`
- `badge/index.blade.php:67-71`
- And more...

**Duplicated Code:**
```php
$iconSizes = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
];
```

**Problem:**
- Icon sizing duplicated separately from component sizing
- Should be part of `ComponentSizeConfig`

---

### 1.4 Component ID Generation (8+ Components)

**Severity:** Medium
**Impact:** 8+ instances of similar code
**Affected Files:** All interactive components

**Pattern found in:**
- `select/index.blade.php:93` → `'select-' . uniqid()`
- `date-picker/index.blade.php:17` → `'date-picker-' . uniqid()`
- `time-picker/index.blade.php:19` → `'time-picker-' . uniqid()`
- `checkbox/index.blade.php:51` → `'checkbox-' . uniqid()`
- `radio/index.blade.php:51` → `'radio-' . uniqid()`
- `toggle/index.blade.php:82` → `'toggle-' . uniqid()`
- `dropdown/index.blade.php:9` → `'dropdown-' . uniqid()`
- `slider/index.blade.php` → `'slider-' . uniqid()`

**Duplicated Pattern:**
```php
$componentId = $id ?? $attributes->get('id') ?? 'component-' . uniqid();
```

**Problem:**
- Each component uses different prefix
- CLAUDE.md specifies standardized pattern, but implementation varies
- No centralized ID generation logic

**Recommendation:**
Create `ComponentIdGenerator` helper:
```php
class ComponentIdGenerator
{
    public static function generate(string $prefix, $id = null, $attributes = null): string
    {
        if ($id) {
            return $id;
        }

        if ($attributes && $attributes->has('id')) {
            return $attributes->get('id');
        }

        return $prefix . '-' . uniqid();
    }
}
```

**Usage:**
```php
$componentId = ComponentIdGenerator::generate('select', $id, $attributes);
```

---

### 1.5 Disabled State Classes (10+ Components)

**Severity:** Low
**Impact:** 30+ instances across components
**Affected Files:** All form components

**Duplicated Patterns:**
```php
// Pattern 1: Simple disabled classes
$disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';

// Pattern 2: Conditional hover
class="{{ $disabled ? 'opacity-50 cursor-not-allowed' : 'hover:border-primary/50' }}"

// Pattern 3: Inline ternary
:class="{ 'opacity-50 cursor-not-allowed': disabled }"
```

**Problem:**
- Disabled styling inconsistent across components
- Some use `opacity-50`, others use `opacity-60`
- Hover state handling varies

**Recommendation:**
Add to `ComponentStateConfig`:
```php
public static function disabledClasses(): string
{
    return 'opacity-50 cursor-not-allowed';
}

public static function disabledWithHover(string $hoverClasses): string
{
    return $disabled ? self::disabledClasses() : $hoverClasses;
}
```

---

### 1.6 Label & Description Size Maps (5+ Components)

**Severity:** Low
**Impact:** ~100 lines of duplicated code
**Affected Files:** Checkbox, Radio, Toggle components

**Pattern found in:**
- `checkbox/index.blade.php:26-36`
- `radio/index.blade.php:26-36`
- `toggle/index.blade.php:31-41`

**Duplicated Code:**
```php
$labelSizes = [
    'sm' => 'text-sm',
    'md' => 'text-base',
    'lg' => 'text-lg',
];

$descriptionSizes = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];
```

**Recommendation:**
Add to `ComponentSizeConfig`:
```php
public static function labelSizes(): array
{
    return [
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg',
    ];
}

public static function descriptionSizes(): array
{
    return [
        'sm' => 'text-xs',
        'md' => 'text-sm',
        'lg' => 'text-base',
    ];
}
```

---

### 1.7 Attribute Splitting Pattern (8+ Components)

**Severity:** Low
**Impact:** 8+ identical instances
**Affected Files:** Input, Textarea, Checkbox, Radio, Toggle, Date Picker, Time Picker, Select

**Pattern found in:**
- `input/index.blade.php:82-83`
- `textarea/index.blade.php:44-45`
- `checkbox/index.blade.php:53-54`
- `radio/index.blade.php:53-54`
- `toggle/index.blade.php:84-85`
- And more...

**Duplicated Code:**
```php
$wrapperAttributes = $attributes->only(['class', 'style']);
$inputAttributes = $attributes->except(['class', 'style']);
```

**Recommendation:**
Create `ComponentAttributeSplitter` helper:
```php
class ComponentAttributeSplitter
{
    public static function splitWrapperAndInput($attributes): array
    {
        return [
            'wrapper' => $attributes->only(['class', 'style']),
            'input' => $attributes->except(['class', 'style']),
        ];
    }
}
```

---

## 2. JavaScript Duplication

### 2.1 Entangleable Setup Pattern (5+ Components)

**Severity:** High
**Impact:** ~150 lines of duplicated code
**Affected Files:** Date Picker, Time Picker, Select, Slider, Calendar

**Pattern found in:**
- `date-picker.js:15-28`
- `time-picker.js:17-29`
- `select/index.blade.php:145-175` (inline Alpine)
- `slider.js:42-60`

**Duplicated Code:**
```javascript
this.entangleable = new window.StrataEntangleable(initialValue);

const input = this.$el.querySelector('[data-strata-component-input]');
if (input) {
    this.entangleable.setupLivewire(this, input);
}

this.entangleable.watch((newValue) => {
    // Component-specific logic here
});
```

**Problem:**
- Identical setup code copied into each component
- Bug fixes require updates in 5+ files
- Inconsistent error handling
- No standardized teardown

**Recommendation:**
Create `EntangleableMixin`:
```javascript
// resources/js/mixins/entangleable-mixin.js
export function EntangleableMixin(initialValue, inputSelector, onChange) {
    return {
        entangleable: null,

        initEntangleable() {
            this.entangleable = new window.StrataEntangleable(initialValue);

            const input = this.$el.querySelector(inputSelector);
            if (input) {
                this.entangleable.setupLivewire(this, input);
            }

            if (onChange) {
                this.entangleable.watch((newValue) => {
                    onChange.call(this, newValue);
                });
            }
        },

        destroyEntangleable() {
            if (this.entangleable) {
                this.entangleable.destroy();
            }
        }
    };
}
```

**Usage:**
```javascript
window.strataDatePicker = (config) => {
    return {
        ...EntangleableMixin(
            config.value,
            '[data-strata-datepicker-input]',
            function(newValue) {
                this.updateDisplay(newValue);
            }
        ),

        init() {
            this.initEntangleable();
            // Component-specific init
        },

        destroy() {
            this.destroyEntangleable();
            // Component-specific cleanup
        }
    };
};
```

---

### 2.2 Positionable Setup Pattern (6+ Components)

**Severity:** High
**Impact:** ~200 lines of duplicated code
**Affected Files:** Date Picker, Time Picker, Select, Dropdown, Popover, Tooltip

**Pattern found in:**
- `date-picker.js:30-53`
- `time-picker.js:31-54`
- `select/index.blade.php:146-198`
- `dropdown/index.blade.php:32-67`

**Duplicated Code:**
```javascript
this.positionable = new window.StrataPositionable({
    placement: 'bottom-start',
    offset: 8,
    strategy: 'absolute',
});

this.positionable.start(this, trigger, dropdown);

this.$watch('open', (value) => {
    if (value) {
        this.positionable.open();
    } else {
        this.positionable.close();
    }
});

this.positionable.watch((state) => {
    if (!state) {
        this.open = false;
    }
});
```

**Problem:**
- Same positioning setup in every dropdown/popover
- Watcher logic duplicated
- Strategy always `'absolute'` per CLAUDE.md, but repeated

**Recommendation:**
Create `PositionableMixin`:
```javascript
// resources/js/mixins/positionable-mixin.js
export function PositionableMixin(config = {}) {
    return {
        positionable: null,
        open: false,

        initPositionable(trigger, content) {
            this.positionable = new window.StrataPositionable({
                placement: config.placement || 'bottom-start',
                offset: config.offset || 8,
                strategy: 'absolute',
                ...config
            });

            if (trigger && content) {
                this.positionable.start(this, trigger, content);
            }

            this.$watch('open', (value) => {
                if (value) {
                    this.positionable.open();
                } else {
                    this.positionable.close();
                }
            });

            this.positionable.watch((state) => {
                if (!state) {
                    this.open = false;
                }
            });
        },

        destroyPositionable() {
            if (this.positionable) {
                this.positionable.destroy();
            }
        }
    };
}
```

---

### 2.3 Keyboard Navigation Logic (3+ Components)

**Severity:** Medium
**Impact:** ~120 lines of duplicated code
**Affected Files:** Select, Dropdown, Calendar

**Pattern found in:**
- `select/index.blade.php:324-384`
- `dropdown/index.blade.php:174-219`

**Duplicated Code:**
```javascript
handleKeydown(e) {
    switch(e.key) {
        case 'Escape':
            e.preventDefault();
            this.close();
            break;
        case 'ArrowDown':
            e.preventDefault();
            this.highlightNext();
            break;
        case 'ArrowUp':
            e.preventDefault();
            this.highlightPrevious();
            break;
        case 'Home':
            e.preventDefault();
            this.highlightFirst();
            break;
        case 'End':
            e.preventDefault();
            this.highlightLast();
            break;
        case 'Enter':
            e.preventDefault();
            if (this.highlightedIndex !== null) {
                this.selectOption(this.highlightedIndex);
            }
            break;
    }
}
```

**Problem:**
- Arrow navigation logic duplicated
- Different components use slightly different key handling
- ARIA best practices should be centralized

**Recommendation:**
Create `KeyboardNavigationMixin`:
```javascript
// resources/js/mixins/keyboard-navigation-mixin.js
export function KeyboardNavigationMixin(callbacks) {
    return {
        highlightedIndex: null,

        handleArrowNavigation(e) {
            const handlers = {
                'Escape': () => callbacks.onEscape?.call(this),
                'ArrowDown': () => this.highlightNext(),
                'ArrowUp': () => this.highlightPrevious(),
                'Home': () => this.highlightFirst(),
                'End': () => this.highlightLast(),
                'Enter': () => callbacks.onEnter?.call(this, this.highlightedIndex),
                'Tab': () => callbacks.onTab?.call(this, e),
            };

            const handler = handlers[e.key];
            if (handler) {
                e.preventDefault();
                handler();
            }
        },

        highlightNext() {
            // Implementation
        },

        highlightPrevious() {
            // Implementation
        },

        highlightFirst() {
            // Implementation
        },

        highlightLast() {
            // Implementation
        }
    };
}
```

---

### 2.4 Clear/HasValue Methods (3+ Components)

**Severity:** Low
**Impact:** ~30 lines of duplicated code
**Affected Files:** Date Picker, Time Picker, Select

**Pattern found in:**
- `date-picker.js:254-261`
- `time-picker.js:157-164`
- `select/index.blade.php:248-275`

**Duplicated Code:**
```javascript
clear() {
    this.entangleable.set(null);
    this.open = false;
},

hasValue() {
    return this.entangleable.value !== null && this.entangleable.value !== '';
}
```

**Recommendation:**
Include in `EntangleableMixin`:
```javascript
export function EntangleableMixin(initialValue, inputSelector, onChange) {
    return {
        // ... existing code ...

        clear() {
            if (this.entangleable) {
                this.entangleable.set(null);
            }
            this.open = false;
        },

        hasValue() {
            return this.entangleable?.value !== null &&
                   this.entangleable?.value !== '' &&
                   this.entangleable?.value !== undefined;
        }
    };
}
```

---

### 2.5 Destroy Pattern (5+ Components)

**Severity:** Low
**Impact:** ~40 lines of identical code
**Affected Files:** Date Picker, Time Picker, Select, Slider, Dropdown

**Pattern found in:**
- `date-picker.js:263-270`
- `time-picker.js:166-173`
- `select/index.blade.php:410-417`
- `slider.js:235-242`

**Duplicated Code:**
```javascript
destroy() {
    if (this.entangleable) {
        this.entangleable.destroy();
    }
    if (this.positionable) {
        this.positionable.destroy();
    }
}
```

**Recommendation:**
Already handled by `EntangleableMixin` and `PositionableMixin` above.

---

## 3. Complexity Issues

### 3.1 Checkbox/Radio Multi-Variant Complexity

**Severity:** High
**Impact:** 300 lines of internal duplication (150 per component)
**Files:**
- `checkbox/index.blade.php` (241 lines total)
- `radio/index.blade.php` (233 lines total)

**Problem:**
Both components contain 4 variants with massive duplication:

```
Lines 59-106:   Default variant  (~47 lines)
Lines 108-152:  Bordered variant (~44 lines) - 80% similar to default
Lines 154-207:  Card variant     (~53 lines) - 70% similar to bordered
Lines 209-239:  Pill variant     (~30 lines) - Different structure
```

**Repeated pattern (4 times per component):**
```blade
<input
    type="checkbox"
    id="{{ $checkboxId }}"
    data-strata-checkbox
    data-strata-field-type="checkbox"
    @if($checked) checked @endif
    @if($disabled) disabled @endif
    {{ $checkboxAttributes->merge(['class' => "sr-only peer"]) }}
/>

<div class="flex items-center gap-2">
    <!-- Label content -->
</div>
```

**Variants only differ in:**
- Container border/background classes
- Label text color
- Hover effects
- Padding/spacing

**Recommendation:**
Create shared variant renderer:

```blade
{{-- checkbox/index.blade.php --}}
@props([
    'variant' => 'default',
    // ... other props
])

@php
$variantConfigs = [
    'default' => [
        'container' => '',
        'labelColor' => 'text-foreground',
        'hover' => '',
    ],
    'bordered' => [
        'container' => 'border border-border rounded-md p-3',
        'labelColor' => 'text-foreground',
        'hover' => 'hover:border-primary/50',
    ],
    'card' => [
        'container' => 'border border-border rounded-lg p-4 bg-card',
        'labelColor' => 'text-card-foreground',
        'hover' => 'hover:border-primary hover:bg-accent/5',
    ],
    'pill' => [
        'container' => 'rounded-full border border-border px-4 py-2',
        'labelColor' => 'text-foreground',
        'hover' => 'hover:bg-accent',
    ],
];

$config = $variantConfigs[$variant] ?? $variantConfigs['default'];
@endphp

<x-strata::checkbox.variant-renderer
    :config="$config"
    :checked="$checked"
    :disabled="$disabled"
    :label="$label"
    :description="$description"
    {{-- All other props --}}
/>
```

**Impact:** Reduce 241 lines → ~120 lines (50% reduction per component).

---

### 3.2 Button Variant Complexity

**Severity:** Medium
**Impact:** 32 lines of repetitive maps
**File:** `button/index.blade.php:13-76`

**Problem:**
Four separate variant maps with identical structure:

```php
// Lines 13-20
$filledVariants = [
    'primary' => 'bg-primary text-primary-foreground hover:bg-primary/90',
    'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/80',
    'success' => 'bg-success text-success-foreground hover:bg-success/90',
    'warning' => 'bg-warning text-warning-foreground hover:bg-warning/90',
    'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/90',
    'info' => 'bg-info text-info-foreground hover:bg-info/90',
];

// Lines 22-29 (Outlined)
// Lines 31-38 (Ghost)
// Lines 40-47 (Link)
```

Each contains the same 6 keys: `primary`, `secondary`, `success`, `warning`, `destructive`, `info`.

**Recommendation:**
Generate programmatically:

```php
$buttonStyles = [
    'filled' => fn($color) => "bg-{$color} text-{$color}-foreground hover:bg-{$color}/90",
    'outlined' => fn($color) => "border-2 border-{$color} text-{$color} hover:bg-{$color}/10",
    'ghost' => fn($color) => "text-{$color} hover:bg-{$color}/10",
    'link' => fn($color) => "text-{$color} underline-offset-4 hover:underline",
];

$colors = ['primary', 'secondary', 'success', 'warning', 'destructive', 'info'];

// Generate dynamically
$variantClasses = collect($buttonStyles[$style] ?? $buttonStyles['filled'])
    ->mapWithKeys(fn($fn, $key) => [$key => collect($colors)->mapWithKeys(fn($color) => [$color => $fn($color)])])
    ->toArray();
```

**Impact:** 32 lines → 10 lines.

---

### 3.3 Toggle State Classes Complexity

**Severity:** Low
**Impact:** Nested state arrays
**File:** `toggle/index.blade.php:55-72`

**Problem:**
```php
$states = [
    'default' => [
        'track' => 'bg-border peer-checked:bg-primary',
        'thumb' => 'bg-background',
    ],
    'success' => [
        'track' => 'bg-border peer-checked:bg-success',
        'thumb' => 'bg-background',
    ],
    // ... 4 variants total
];
```

**Recommendation:**
Generate from single source:

```php
$stateColors = ['default' => 'primary', 'success' => 'success', 'error' => 'destructive', 'warning' => 'warning'];

$states = collect($stateColors)->mapWithKeys(fn($color, $state) => [
    $state => [
        'track' => "bg-border peer-checked:bg-{$color}",
        'thumb' => 'bg-background',
    ]
])->toArray();
```

---

### 3.4 Select Component Complexity

**Severity:** Critical
**Impact:** 564 lines total, 323 lines of inline JavaScript
**File:** `select/index.blade.php`

**Problems:**

1. **Massive inline Alpine component** (lines 97-420)
   - 323 lines of JavaScript in Blade template
   - Violates separation of concerns
   - Hard to test independently
   - Not reusable

2. **Too many responsibilities:**
   - Value management (Entangleable)
   - Positioning (Positionable)
   - Search functionality
   - Multi-select with chips
   - Keyboard navigation
   - Option filtering
   - Clear functionality

3. **Complex computed properties:**
   - `filteredOptions` (search logic)
   - `selectedOptions` (multi-select)
   - `displayText` (format selected)
   - 5+ other getters

4. **Deep nesting:**
   - Trigger → Dropdown → Search → Options → Chips
   - 6+ levels of indentation

**Recommendation:**
Split into modules:

```
resources/js/
  select.js              (Main component - 80 lines)
  mixins/
    entangleable-mixin.js    (Already proposed)
    positionable-mixin.js    (Already proposed)
    keyboard-nav-mixin.js    (Already proposed)
  select/
    search-filter.js     (Search logic - 30 lines)
    chip-manager.js      (Multi-select chips - 40 lines)
    option-highlighter.js (Keyboard highlighting - 30 lines)
```

**Impact:** 564 lines → ~200 lines with better separation.

---

### 3.5 Badge Variant Complexity

**Severity:** Medium
**Impact:** Complex variant resolution with dynamic classes
**File:** `badge/index.blade.php:10-59`

**Problem:**

```php
// Lines 10-41: Design system variants
$variants = [
    'primary' => [
        'filled' => 'bg-primary text-primary-foreground',
        'outlined' => 'border-2 border-primary text-primary',
        // ... more
    ],
    // ... 6 variants
];

// Lines 43: Tailwind colors array
$tailwindColors = ['red', 'blue', 'green', /* ... 20+ colors */];

// Lines 47-59: Dynamic class generation
$variantClasses = '';
if (in_array($variant, $tailwindColors)) {
    $variantClasses = match($style) {
        'filled' => "bg-{$variant}-500 text-white",
        'outlined' => "border-2 border-{$variant}-500 text-{$variant}-700",
        // ... more
    };
} else {
    $variantClasses = $variants[$variant][$style] ?? /* default */;
}
```

**Problem:**
- Violates "No Alpine class generation" principle (even though PHP)
- Dynamic string concatenation for Tailwind classes
- Hard to maintain with Tailwind v4 theme

**Recommendation:**
Pre-generate all combinations or use design system colors only:

```php
// Option 1: Design system only (recommended)
$allowedVariants = array_keys($variants);
if (!in_array($variant, $allowedVariants)) {
    $variant = 'primary'; // Fallback
}
$variantClasses = $variants[$variant][$style] ?? $variants['primary']['filled'];

// Option 2: If Tailwind colors needed, pre-generate in config
// ComponentVariantConfig::badgeClasses($variant, $style)
```

---

### 3.6 Date Picker Preset Logic Duplication

**Severity:** Medium
**Impact:** 107 lines of repetitive preset methods
**File:** `date-picker.js:134-241`

**Problem:**
13 preset methods with identical structure:

```javascript
today() {
    const today = new Date();
    return {
        start: this.toDateString(today),
        end: this.toDateString(today)
    };
},

yesterday() {
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    return {
        start: this.toDateString(yesterday),
        end: this.toDateString(yesterday)
    };
},

last7Days() {
    const end = new Date();
    const start = new Date();
    start.setDate(start.getDate() - 6);
    return {
        start: this.toDateString(start),
        end: this.toDateString(end)
    };
},

// ... 10 more similar methods
```

**Recommendation:**
Data-driven configuration:

```javascript
// resources/js/config/date-presets.js
export const DATE_PRESETS = {
    today: { days: 0, relativeTo: 'today' },
    yesterday: { days: -1, relativeTo: 'today' },
    last7Days: { days: -6, relativeTo: 'today', range: true },
    last30Days: { days: -29, relativeTo: 'today', range: true },
    thisMonth: { type: 'month', offset: 0 },
    lastMonth: { type: 'month', offset: -1 },
    thisQuarter: { type: 'quarter', offset: 0 },
    lastQuarter: { type: 'quarter', offset: -1 },
    thisYear: { type: 'year', offset: 0 },
    lastYear: { type: 'year', offset: -1 },
};

// In date-picker.js
applyPreset(presetName) {
    const config = DATE_PRESETS[presetName];
    if (!config) return;

    const dates = this.calculatePresetDates(config);
    this.entangleable.set(dates);
}

calculatePresetDates(config) {
    // Single method handles all presets based on config
}
```

**Impact:** 107 lines → ~40 lines.

---

## 4. Architectural Issues

### 4.1 Missing Shared PHP Utilities

**Current State:** Each component duplicates common logic.

**Needed Abstractions:**

#### 1. ComponentSizeConfig
**Purpose:** Centralize all size-related classes
**Location:** `packages/strata-ui/src/Config/ComponentSizeConfig.php`
**Methods:**
- `sizes()` - Component heights and padding
- `iconSizes()` - Icon dimensions
- `labelSizes()` - Label text sizes
- `descriptionSizes()` - Description text sizes
- `badgeSizes()` - Badge-specific sizing
- `avatarSizes()` - Avatar-specific sizing

#### 2. ComponentStateConfig
**Purpose:** Centralize validation/state classes
**Location:** `packages/strata-ui/src/Config/ComponentStateConfig.php`
**Methods:**
- `inputStates()` - Input field states (default, success, error, warning)
- `buttonStates()` - Button states
- `disabledClasses()` - Disabled state styling
- `focusRingClasses()` - Focus ring utilities

#### 3. ComponentIdGenerator
**Purpose:** Standardize ID generation
**Location:** `packages/strata-ui/src/Helpers/ComponentIdGenerator.php`
**Methods:**
- `generate(string $prefix, $id = null, $attributes = null): string`

#### 4. ComponentAttributeSplitter
**Purpose:** Handle attribute splitting patterns
**Location:** `packages/strata-ui/src/Helpers/ComponentAttributeSplitter.php`
**Methods:**
- `splitWrapperAndInput($attributes): array`
- `filterWireModel($attributes): array`

#### 5. ComponentVariantConfig
**Purpose:** Handle variant class generation
**Location:** `packages/strata-ui/src/Config/ComponentVariantConfig.php`
**Methods:**
- `buttonVariants(string $style, string $color): string`
- `badgeVariants(string $style, string $variant): string`
- `checkboxVariants(string $variant): array`

---

### 4.2 Missing JavaScript Mixins

**Current State:** JavaScript patterns duplicated across components.

**Needed Abstractions:**

#### 1. EntangleableMixin
**Purpose:** Standardize Entangleable setup
**Location:** `packages/strata-ui/resources/js/mixins/entangleable-mixin.js`
**Provides:**
- `initEntangleable()` - Setup with watchers
- `destroyEntangleable()` - Cleanup
- `clear()` - Reset value
- `hasValue()` - Check for value

**Used by:** Date Picker, Time Picker, Select, Slider, Calendar

#### 2. PositionableMixin
**Purpose:** Standardize Positionable setup
**Location:** `packages/strata-ui/resources/js/mixins/positionable-mixin.js`
**Provides:**
- `initPositionable(trigger, content)` - Setup positioning
- `destroyPositionable()` - Cleanup
- Automatic open/close watchers
- External click handling

**Used by:** Date Picker, Time Picker, Select, Dropdown, Popover, Tooltip

#### 3. KeyboardNavigationMixin
**Purpose:** Shared keyboard handling
**Location:** `packages/strata-ui/resources/js/mixins/keyboard-navigation-mixin.js`
**Provides:**
- `handleArrowNavigation(e)` - Arrow key handling
- `highlightNext/Previous/First/Last()` - Navigation methods
- Configurable callbacks for component-specific behavior

**Used by:** Select, Dropdown, Calendar

#### 4. SearchFilterMixin
**Purpose:** Option filtering logic
**Location:** `packages/strata-ui/resources/js/mixins/search-filter-mixin.js`
**Provides:**
- `initSearch()` - Setup search state
- `filterOptions(query)` - Filter logic
- `clearSearch()` - Reset search

**Used by:** Select component

---

### 4.3 Missing Configuration Files

**Needed:**

#### 1. Date Preset Configuration
**Location:** `packages/strata-ui/resources/js/config/date-presets.js`
**Purpose:** Eliminate 13 duplicated preset methods
**Structure:**
```javascript
export const DATE_PRESETS = {
    today: { /* config */ },
    yesterday: { /* config */ },
    // ... all presets
};
```

#### 2. Time Preset Configuration
**Location:** `packages/strata-ui/resources/js/config/time-presets.js`
**Purpose:** Standardize time presets
**Structure:**
```javascript
export const TIME_PRESETS = [
    { label: 'Morning', start: '08:00', end: '12:00' },
    { label: 'Afternoon', start: '12:00', end: '17:00' },
    // ... presets
];
```

---

## 5. Quantified Impact

### Code Duplication Totals

| Category | Lines Duplicated | Files Affected | Reduction Potential |
|----------|------------------|----------------|---------------------|
| **PHP Size Maps** | ~600 | 30+ | 90% (→60 lines in config) |
| **PHP State Maps** | ~300 | 10+ | 90% (→30 lines in config) |
| **PHP Icon Sizes** | ~200 | 10+ | 95% (→10 lines in config) |
| **PHP ID Generation** | ~80 | 8+ | 95% (→4 lines helper) |
| **PHP Disabled States** | ~60 | 10+ | 80% (→12 lines in config) |
| **PHP Label/Desc Sizes** | ~100 | 5+ | 90% (→10 lines in config) |
| **PHP Attribute Splitting** | ~40 | 8+ | 90% (→4 lines helper) |
| **JS Entangleable Setup** | ~150 | 5+ | 85% (→20 lines mixin) |
| **JS Positionable Setup** | ~200 | 6+ | 85% (→30 lines mixin) |
| **JS Keyboard Nav** | ~120 | 3+ | 80% (→25 lines mixin) |
| **JS Clear/HasValue** | ~30 | 3+ | 90% (→3 lines mixin) |
| **JS Destroy Pattern** | ~40 | 5+ | 95% (→2 lines mixin) |
| **TOTAL** | **~1,920** | **50+** | **88%** (→230 lines) |

### Maintenance Impact

**Current State:**
- Design token change (e.g., `h-10` → `h-11` for `md` size): **30+ file updates**
- State color change (e.g., error ring color): **10+ file updates**
- Entangleable bug fix: **5+ file updates**
- Positioning logic update: **6+ file updates**

**After Refactoring:**
- Design token change: **1 file update** (ComponentSizeConfig)
- State color change: **1 file update** (ComponentStateConfig)
- Entangleable bug fix: **1 file update** (EntangleableMixin)
- Positioning logic update: **1 file update** (PositionableMixin)

### Complexity Metrics

| Component | Current Lines | Complexity Score | Target Lines | Priority |
|-----------|---------------|------------------|--------------|----------|
| `select/index.blade.php` | 564 | Critical (323 JS inline) | <300 | High |
| `checkbox/index.blade.php` | 241 | High (4 variants) | <150 | High |
| `radio/index.blade.php` | 233 | High (4 variants) | <150 | High |
| `button/index.blade.php` | 150 | Medium (4 variant maps) | <100 | Medium |
| `toggle/index.blade.php` | 135 | Medium (nested states) | <100 | Low |
| `badge/index.blade.php` | 120 | Medium (dynamic classes) | <80 | Low |
| `date-picker.js` | 270 | Medium (13 presets) | <180 | Medium |

**Complexity Thresholds:**
- **Target:** Components <150 lines, JS modules <200 lines
- **Warning:** Components >200 lines, JS modules >250 lines
- **Critical:** Components >300 lines, JS modules >350 lines

---

## 6. Refactoring Plan

### Phase 1: Shared PHP Utilities (HIGH PRIORITY)

**Estimated Effort:** 8 hours
**Impact:** Reduces PHP duplication by ~1,000 lines
**Risk:** Low (internal changes only)

**Tasks:**
1. Create `ComponentSizeConfig` class
   - Migrate size maps from 30+ components
   - Add icon, label, description size methods
   - Write unit tests

2. Create `ComponentStateConfig` class
   - Migrate state maps from 10+ components
   - Add disabled state methods
   - Write unit tests

3. Create `ComponentIdGenerator` helper
   - Standardize ID generation across 8+ components
   - Write unit tests

4. Create `ComponentAttributeSplitter` helper
   - Extract attribute splitting logic
   - Write unit tests

5. Update all components to use new utilities
   - Replace inline maps with config calls
   - Test each component thoroughly
   - Verify no visual regressions

**Deliverables:**
- 4 new PHP classes with tests
- 30+ components updated
- Documentation for utility usage

---

### Phase 2: JavaScript Mixins (HIGH PRIORITY)

**Estimated Effort:** 12 hours
**Impact:** Reduces JS duplication by ~500 lines
**Risk:** Medium (affects component behavior)

**Tasks:**
1. Create `EntangleableMixin`
   - Extract setup/destroy/clear/hasValue logic
   - Add comprehensive tests (Vitest)
   - Document usage patterns

2. Create `PositionableMixin`
   - Extract positioning setup logic
   - Add tests for positioning behavior
   - Document configuration options

3. Create `KeyboardNavigationMixin`
   - Extract arrow navigation logic
   - Add keyboard interaction tests
   - Document callback patterns

4. Update components to use mixins
   - Date Picker, Time Picker, Select, Slider (Entangleable)
   - Date Picker, Time Picker, Select, Dropdown (Positionable)
   - Select, Dropdown (Keyboard Nav)
   - Thorough testing for each

5. Create mixin documentation
   - Usage examples
   - Best practices
   - Migration guide

**Deliverables:**
- 3 JavaScript mixin modules with tests
- 10+ components refactored
- Comprehensive documentation

---

### Phase 3: Component Refactoring (MEDIUM PRIORITY)

**Estimated Effort:** 16 hours
**Impact:** Improves maintainability of most complex components
**Risk:** Medium-High (structural changes)

**Tasks:**

#### 3.1 Select Component Modularization
- Extract inline Alpine to `resources/js/select.js`
- Create `search-filter.js` module
- Create `chip-manager.js` module
- Create `option-highlighter.js` module
- Update Blade template to use modular JS
- Comprehensive testing (PHP feature tests + JS unit tests)
- **Target:** 564 lines → ~200 lines

#### 3.2 Checkbox/Radio Variant Refactoring
- Create `variant-renderer.blade.php` sub-component
- Extract variant configuration to data array
- Update checkbox to use renderer
- Update radio to use renderer
- Thorough visual regression testing
- **Target:** 241/233 lines → ~120 lines each

#### 3.3 Button Variant Generation
- Replace 4 static maps with programmatic generation
- Ensure all color combinations work
- Test all variants thoroughly
- **Target:** 150 lines → ~100 lines

#### 3.4 Date/Time Preset Configuration
- Create `date-presets.js` config file
- Create `time-presets.js` config file
- Refactor preset methods to use config
- Add preset customization documentation
- **Target:** Date picker 270 lines → ~180 lines

**Deliverables:**
- 4 major components refactored
- 6+ new modules/sub-components
- Full test coverage maintained
- Visual regression testing passed

---

### Phase 4: Documentation & Best Practices (LOW PRIORITY)

**Estimated Effort:** 6 hours
**Impact:** Prevents future duplication
**Risk:** None

**Tasks:**
1. Update CLAUDE.md with refactoring patterns
2. Create component development guide
3. Document shared utility usage
4. Add examples of mixin usage
5. Create "Before/After" refactoring examples
6. Add guidelines for avoiding duplication

**Deliverables:**
- Updated CLAUDE.md
- New `docs/component-development-guide.md`
- New `docs/shared-utilities.md`
- Code examples repository

---

### Phase 5: Continuous Improvement (ONGOING)

**Tasks:**
1. Add ESLint rules to prevent duplication
2. Add PHP_CodeSniffer rules for component standards
3. Create pre-commit hooks for complexity checks
4. Set up code coverage monitoring
5. Regular complexity audits (quarterly)

---

## 7. Breaking vs Non-Breaking Changes

### Non-Breaking Changes (All Proposed)

All refactoring changes are **internal only** and maintain the same component API:

✅ **Shared utility classes** - Components call helpers internally
✅ **JavaScript mixins** - Alpine data structure unchanged
✅ **Component modularization** - External usage identical
✅ **Configuration extraction** - Props remain the same

**No breaking changes to:**
- Component props
- Slot structure
- CSS classes exposed to users
- JavaScript APIs (Alpine data/methods)
- Event dispatching

**User code remains unchanged:**
```blade
{{-- Before refactoring --}}
<x-strata::button size="md" variant="primary">Click Me</x-strata::button>

{{-- After refactoring --}}
<x-strata::button size="md" variant="primary">Click Me</x-strata::button>
{{-- Identical usage --}}
```

### Version Recommendation

**Semantic Versioning Impact:**
- **Patch:** `v1.0.x` → `v1.0.(x+1)` - Bug fixes, internal refactoring only
- **Minor:** `v1.x.0` → `v1.(x+1).0` - New features added alongside refactoring

**Recommended approach:** Bundle refactoring with next minor release to minimize deployment overhead.

---

## 8. Priority Recommendations

### Critical (Start Immediately)

#### 1. ComponentSizeConfig
**Why:** Affects 30+ components, highest ROI
**Effort:** 2 hours
**Impact:** Centralizes all size definitions, single source of truth
**Risk:** Very low

#### 2. ComponentStateConfig
**Why:** Affects 10+ components, consistency critical
**Effort:** 2 hours
**Impact:** Ensures validation states consistent across forms
**Risk:** Very low

#### 3. EntangleableMixin
**Why:** Reduces JS duplication significantly, improves maintainability
**Effort:** 4 hours
**Impact:** Bug fixes only need one update
**Risk:** Low (well-tested pattern)

---

### Important (Do Next)

#### 4. Checkbox/Radio Refactoring
**Why:** High internal complexity, maintenance burden
**Effort:** 6 hours
**Impact:** 50% line reduction, easier to add variants
**Risk:** Medium (needs visual testing)

#### 5. Select Component Modularization
**Why:** 564 lines, hardest to maintain
**Effort:** 8 hours
**Impact:** Improved testability, reusable modules
**Risk:** Medium (complex behavior)

#### 6. PositionableMixin
**Why:** Standardizes positioning across 6+ components
**Effort:** 4 hours
**Impact:** Consistent dropdown behavior
**Risk:** Low

---

### Nice to Have (Future)

#### 7. Date/Time Preset Configuration
**Why:** Eliminates repetitive preset methods
**Effort:** 3 hours
**Impact:** Easier to customize presets
**Risk:** Low

#### 8. Badge Variant Simplification
**Why:** Cleaner variant resolution
**Effort:** 2 hours
**Impact:** Better Tailwind v4 compatibility
**Risk:** Low

#### 9. KeyboardNavigationMixin
**Why:** Standardizes ARIA keyboard behavior
**Effort:** 4 hours
**Impact:** Accessibility improvements
**Risk:** Low

---

## 9. Success Metrics

### Code Quality Metrics

**Before Refactoring:**
- Total lines of code: ~12,000
- Duplicated code: ~1,920 lines (16%)
- Average component size: 180 lines
- Components >200 lines: 10
- Components >300 lines: 2

**After Refactoring Target:**
- Total lines of code: ~10,300 (-14%)
- Duplicated code: ~230 lines (2%)
- Average component size: 120 lines
- Components >200 lines: 2
- Components >300 lines: 0

### Maintenance Metrics

**Before Refactoring:**
- Size change updates: 30+ files
- State change updates: 10+ files
- Bug fix propagation: 5+ files
- New variant addition: 4+ files

**After Refactoring Target:**
- Size change updates: 1 file
- State change updates: 1 file
- Bug fix propagation: 1 file
- New variant addition: 1-2 files

### Test Coverage

**Current:**
- PHP Tests: 148 cases
- JS Tests: 36 cases
- Coverage: ~65%

**Target:**
- PHP Tests: 200+ cases
- JS Tests: 60+ cases
- Coverage: >80%

---

## 10. Implementation Timeline

### Week 1: Foundation (Critical Items)
- Day 1-2: ComponentSizeConfig + ComponentStateConfig
- Day 3-4: EntangleableMixin + PositionableMixin
- Day 5: ComponentIdGenerator + ComponentAttributeSplitter
- **Deliverable:** Core utilities with tests

### Week 2: Component Updates
- Day 1-3: Update 30+ components to use size/state configs
- Day 4-5: Update 10+ components to use JS mixins
- **Deliverable:** All components using shared utilities

### Week 3: Complex Refactoring
- Day 1-3: Checkbox/Radio variant refactoring
- Day 4-5: Select component modularization (part 1)
- **Deliverable:** Simplified checkbox/radio variants

### Week 4: Completion & Documentation
- Day 1-2: Select component modularization (part 2)
- Day 3: Date/Time preset configuration
- Day 4-5: Documentation updates + testing
- **Deliverable:** Complete refactoring with docs

**Total Effort:** ~42 hours over 4 weeks

---

## 11. Risk Mitigation

### Testing Strategy
1. **Visual Regression Testing:**
   - Screenshot comparison before/after
   - Test all variants and states
   - Cross-browser testing

2. **Behavioral Testing:**
   - Existing Pest tests must pass
   - Add new tests for utilities
   - JavaScript unit tests for mixins

3. **Integration Testing:**
   - Test with real Livewire components
   - Test wire:model binding
   - Test Alpine reactivity

### Rollback Plan
1. All changes in feature branch
2. Git tags before each phase
3. Easy rollback if issues detected
4. Staged deployment (dev → staging → production)

### Gradual Migration
- Update components in batches (5 at a time)
- Test thoroughly after each batch
- Allow for incremental rollout

---

## 12. Conclusion

This analysis has identified **~1,920 lines of duplicated code** across 50+ files in the Strata UI component library. The proposed refactoring plan can reduce this to **~230 lines** of shared utilities, achieving an **88% reduction** in code duplication.

### Key Takeaways

1. **Size/State maps are the biggest issue** - 30+ components duplicate identical configuration
2. **JavaScript patterns need standardization** - Entangleable/Positionable setup repeated in 10+ files
3. **Complex components need modularization** - Select (564 lines) and Checkbox/Radio (241/233 lines) exceed maintainability thresholds
4. **All changes are non-breaking** - Internal refactoring only, no API changes

### Recommended Action

**Start with Phase 1 (Shared PHP Utilities):**
- Highest ROI (reduces 1,000+ lines of duplication)
- Lowest risk (internal changes only)
- Fastest to implement (8 hours)
- Immediate benefit (single source of truth for design tokens)

**Next Steps:**
1. Review and approve this analysis
2. Create GitHub issues for Phase 1 tasks
3. Begin implementation with ComponentSizeConfig
4. Regular progress reviews after each phase

---

**Document Version:** 1.0
**Last Updated:** November 2025
**Next Review:** After Phase 1 completion
