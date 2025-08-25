# Strata UI Development Patterns

This document outlines the architectural patterns and conventions used in the Strata UI package for maintaining consistency and quality across all components.

## Table of Contents

1. [Alpine.js Patterns](#alpinejs-patterns)
2. [PHP Component Patterns](#php-component-patterns)
3. [Blade Template Patterns](#blade-template-patterns)
4. [Testing Patterns](#testing-patterns)
5. [Icon System](#icon-system)
6. [Styling Conventions](#styling-conventions)

## Alpine.js Patterns

### Component Registration

All interactive components use the `Alpine.data()` pattern with named components:

```javascript
document.addEventListener('alpine:init', () => {
    Alpine.data('componentName', (config) => ({
        // Component state and methods
    }));
});
```

### Template Usage

Components are initialized using the named Alpine data pattern:

```blade
<div 
    x-data="componentName({
        hasWireModel: @js($hasWireModel),
        value: @js($value),
        // other config...
    })"
    x-modelable="value"
    @if($hasWireModel) {{ $attributes->wire('model') }} @endif
>
```

### Configuration Patterns

#### Required Config Properties
- `hasWireModel` - Boolean indicating Livewire integration
- `value` - Initial component value
- Component-specific properties passed via `@js()`

#### State Management
```javascript
{
    value: config.hasWireModel ? null : config.value,
    
    init() {
        // Handle Livewire entanglement
        if (config.hasWireModel) {
            this.value = config.value;
        }
        
        // Component initialization
    }
}
```

#### Livewire Integration
- Use `x-modelable="value"` for two-way binding
- Check `config.hasWireModel` in init method
- Support both `wire:model` and regular form inputs

### Event Handling

Components should dispatch custom events for state changes:

```javascript
setValue(newValue) {
    this.value = newValue;
    this.$dispatch('change', { value: newValue });
}
```

### Script Placement

Alpine component definitions are placed in `<script>` tags at the bottom of Blade templates:

```blade
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('componentName', (config) => ({
            // Component definition
        }));
    });
</script>
```

## PHP Component Patterns

### Component Class Structure

```php
<?php

declare(strict_types=1);

namespace Strata\UI\View\Components\[Category];

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Component description for Strata UI.
 */
class ComponentName extends Component
{
    public function __construct(
        // Use PHP 8 constructor property promotion
        public ?string $name = null,
        public ?string $label = null,
        // Type all properties appropriately
        public bool $readonly = false,
        public ?string $id = null,
    ) {
        // Generate unique IDs when not provided
        $this->id = $id ?: 'component-' . uniqid();
    }

    public function render(): View
    {
        return view('strata::components.[category].component-name');
    }

    // Helper methods for CSS classes, configurations, etc.
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'w-4 h-4',
            'lg' => 'w-6 h-6',
            default => 'w-5 h-5',
        };
    }
}
```

### Required Properties Pattern

For form components, enforce required properties:

```php
public function __construct(
    public string $name,        // Required
    public string $id,          // Required  
    public string $value,       // Required
    public string $label,       // Required
    // Optional properties with defaults
    public ?string $description = null,
) {
    // Validation can be added here if needed
}
```

### Method Naming Conventions

- `get{PropertyName}Classes()` - Returns CSS classes for styling
- `getId()` - Returns component ID
- Prefix boolean checks with `is` or `has`
- Use descriptive method names

## Blade Template Patterns

### Template Structure

```blade
@php
    $hasWireModel = $attributes->wire('model');
    // Other computed variables
@endphp

<div 
    x-data="componentName({
        hasWireModel: @js($hasWireModel),
        // Pass all config via @js()
    })"
    x-modelable="value"
    @if($hasWireModel) {{ $attributes->wire('model') }} @endif
    class="base-component-classes"
>
    <!-- Hidden inputs for form submission -->
    @if($name && !$hasWireModel)
        <input 
            x-ref="hiddenInput"
            type="hidden" 
            name="{{ $name }}" 
            value="{{ $value ?? '' }}"
        >
    @endif

    <!-- Component content -->
    
</div>

<!-- Alpine component definition -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('componentName', (config) => ({
            // Component logic
        }));
    });
</script>
```

### Attribute Handling

- Use `{{ $attributes->except(['wire:model']) }}` to pass through attributes
- Use `@if($hasWireModel) {{ $attributes->wire('model') }} @endif` for Livewire binding
- Handle both `wire:model` and regular form submission patterns

### Accessibility Patterns

```blade
@if($label || $description)
    <div class="space-y-1">
        @if($label)
            <label 
                id="{{ $id }}-label"
                class="text-sm font-medium text-foreground"
            >
                {{ $label }}
            </label>
        @endif
        @if($description)
            <p 
                id="{{ $id }}-description"
                class="text-xs text-muted-foreground"
            >
                {{ $description }}
            </p>
        @endif
    </div>
@endif
```

## Testing Patterns

### Test Structure (Pest)

```php
<?php

declare(strict_types=1);

use Strata\UI\View\Components\ComponentName;

describe('Component Tests', function () {
    it('renders component with default settings', function () {
        $component = new ComponentName();
        $view = $component->render();
        
        expect($view)->toBeInstanceOf(\Illuminate\Contracts\View\View::class);
        expect($view->name())->toBe('strata::components.category.component-name');
    });

    // Test all constructor parameters
    // Test all public methods
    // Test rendered output contains expected elements
    // Test Alpine.data pattern usage
});
```

### Test Coverage Requirements

- Constructor parameter validation
- CSS class generation methods
- Template rendering
- Alpine.data pattern integration
- Accessibility attributes
- Form integration patterns

## Icon System

### Heroicons Usage

All icons use Heroicons with specific naming patterns:

```blade
<!-- Outline icons (default) -->
<x-icon name="heroicon-o-star" class="w-5 h-5" />

<!-- Solid icons (for active states) -->
<x-icon name="heroicon-s-star" class="w-5 h-5" />
```

### Dynamic Icon Switching

For components that need filled/unfilled states:

```blade
<x-icon 
    :name="str_replace('-o-', '-s-', $icon)" 
    :class="$getSizeClasses()" 
    x-show="isActive"
/>
<x-icon 
    :name="$icon" 
    :class="$getSizeClasses() . ' opacity-40'" 
    x-show="!isActive"
/>
```

## Styling Conventions

### CSS Class Patterns

- Use semantic color tokens: `text-primary`, `bg-accent`, `border-destructive`
- Available colors: `primary`, `accent`, `destructive`, `secondary`, `muted`
- Use `gap-*` utilities for spacing, not margins
- Follow size patterns: `sm`, `md` (default), `lg`

### Tailwind v4 Patterns

```css
/* Use semantic variables, not hardcoded values */
.component-class {
    background: var(--background);
    color: var(--foreground);
    border-radius: var(--radius);
}
```

### Dark Mode Support

All components automatically support dark mode through semantic color variables. No additional dark: prefixes needed when using semantic tokens.

### Component Size Systems

```php
public function getSizeClasses(): string
{
    return match ($this->size) {
        'sm' => 'h-8 px-3 text-xs',
        'lg' => 'h-12 px-6 text-lg',
        default => 'h-10 px-4 text-sm',
    };
}
```

## Best Practices

### Performance
- Use `@js()` directive for passing PHP values to JavaScript
- Minimize Alpine reactivity overhead
- Use `x-show` vs `x-if` appropriately

### Accessibility
- Always provide ARIA labels and descriptions
- Use semantic HTML elements
- Ensure keyboard navigation works
- Test with screen readers

### Maintainability
- Follow established naming conventions
- Document complex logic with PHPDoc
- Use TypeScript-style parameter documentation
- Keep components focused on single responsibility

### Error Handling
- Validate input parameters in PHP constructors
- Provide fallback values for optional properties
- Handle edge cases gracefully in Alpine components

This pattern documentation ensures consistency across all Strata UI components and provides a foundation for future development.