# Range Slider

A dual-handle range slider component for selecting numeric value ranges. Perfect for filtering products, settings, and any scenario requiring min/max range selection.

## Features

- **Dual Handles** - Independent min and max handles for range selection
- **Drag Interaction** - Smooth mouse/touch dragging for both handles
- **Keyboard Navigation** - Arrow keys, Page Up/Down, Home/End support
- **Track Click** - Click anywhere on track to move nearest handle
- **Collision Prevention** - Handles cannot cross each other
- **Custom Min/Max/Step** - Flexible numeric constraints
- **Prefix/Suffix** - Support for currency ($), percentage (%), units (°C, yrs)
- **Size Variants** - Small, medium, and large sizes
- **Validation States** - Default, success, error, and warning states
- **Display Options** - Toggle value display and min/max labels
- **Livewire Integration** - Full `wire:model` support via Entangleable
- **Accessible** - ARIA compliant with role="slider" and keyboard support

## Basic Usage

```blade
<x-strata::range-slider
    name="price_range"
    :min="0"
    :max="1000"
    :step="10"
/>
```

## With Livewire

```blade
<x-strata::range-slider
    wire:model.live="priceRange"
    :min="0"
    :max="1000"
    :step="10"
/>
```

The component syncs with Livewire using an object structure:

```php
public array $priceRange = ['min' => 100, 'max' => 900];
```

## E-commerce Examples

### Price Range Filter

```blade
<x-strata::range-slider
    wire:model.live="priceRange"
    :min="0"
    :max="1000"
    :step="10"
    prefix="$"
/>
```

### Discount Range Filter

```blade
<x-strata::range-slider
    wire:model.live="discountRange"
    :min="0"
    :max="100"
    :step="5"
    suffix="%"
/>
```

### Rating Range Filter

```blade
<x-strata::range-slider
    wire:model.live="ratingRange"
    :min="1"
    :max="5"
    :step="0.5"
/>
```

## Other Use Cases

### Age Range

```blade
<x-strata::range-slider
    wire:model.live="ageRange"
    :min="18"
    :max="65"
    :step="1"
    suffix=" yrs"
/>
```

### Temperature Range

```blade
<x-strata::range-slider
    wire:model.live="temperatureRange"
    :min="-20"
    :max="50"
    :step="1"
    suffix="°C"
/>
```

### Volume Range

```blade
<x-strata::range-slider
    wire:model.live="volumeRange"
    :min="0"
    :max="100"
    :step="1"
    suffix="%"
/>
```

## Size Variants

### Small

```blade
<x-strata::range-slider
    size="sm"
    :min="0"
    :max="1000"
    prefix="$"
/>
```

### Medium (Default)

```blade
<x-strata::range-slider
    size="md"
    :min="0"
    :max="1000"
    prefix="$"
/>
```

### Large

```blade
<x-strata::range-slider
    size="lg"
    :min="0"
    :max="1000"
    prefix="$"
/>
```

## Validation States

### Success

```blade
<x-strata::range-slider
    state="success"
    :min="0"
    :max="100"
/>
```

### Error

```blade
<x-strata::range-slider
    state="error"
    :min="0"
    :max="100"
/>
```

### Warning

```blade
<x-strata::range-slider
    state="warning"
    :min="0"
    :max="100"
/>
```

## Display Options

### Without Values

Hide the current min/max value display:

```blade
<x-strata::range-slider
    :show-values="false"
    :min="0"
    :max="1000"
/>
```

### Without Labels

Hide the min/max labels at track ends:

```blade
<x-strata::range-slider
    :show-labels="false"
    :min="0"
    :max="1000"
/>
```

### Minimal (No Values/Labels)

```blade
<x-strata::range-slider
    :show-values="false"
    :show-labels="false"
    :min="0"
    :max="1000"
/>
```

## Disabled State

```blade
<x-strata::range-slider
    :disabled="true"
    :min="0"
    :max="1000"
/>
```

## Initial Value

Set the initial range:

```blade
<x-strata::range-slider
    :value="['min' => 100, 'max' => 900]"
    :min="0"
    :max="1000"
/>
```

## Keyboard Navigation

The range slider supports comprehensive keyboard controls:

- **Arrow Left/Down** - Decrease value by one step
- **Arrow Right/Up** - Increase value by one step
- **Page Down** - Decrease value by 10 steps
- **Page Up** - Increase value by 10 steps
- **Home** - Jump to minimum value
- **End** - Jump to maximum value
- **Tab** - Move focus between min and max handles

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `string` | `null` | Component ID |
| `name` | `string` | `null` | Input name attribute |
| `value` | `array` | `null` | Initial value `['min' => x, 'max' => y]` |
| `min` | `int\|float` | `0` | Minimum allowed value |
| `max` | `int\|float` | `100` | Maximum allowed value |
| `step` | `int\|float` | `1` | Value increment/decrement step |
| `size` | `string` | `'md'` | Size variant: `'sm'`, `'md'`, `'lg'` |
| `state` | `string` | `'default'` | Validation state: `'default'`, `'success'`, `'error'`, `'warning'` |
| `disabled` | `bool` | `false` | Disable the slider |
| `show-values` | `bool` | `true` | Show current min/max values |
| `show-labels` | `bool` | `true` | Show min/max labels at track ends |
| `prefix` | `string` | `''` | Text to prepend to values (e.g., `'$'`) |
| `suffix` | `string` | `''` | Text to append to values (e.g., `'%'`, `'°C'`) |

## Accessibility

The range slider component is fully accessible:

- **ARIA Attributes** - Each handle has `role="slider"`, `aria-valuemin`, `aria-valuemax`, `aria-valuenow`, `aria-label`
- **Keyboard Navigation** - Full keyboard support with arrow keys, page up/down, home/end
- **Focus Management** - Clear focus indicators on handles
- **Screen Reader Support** - Announces current values and labels

## Value Format

The component uses an object structure for the range value:

```php
[
    'min' => 100,  // Minimum value in range
    'max' => 900   // Maximum value in range
]
```

This format is automatically synchronized with Livewire when using `wire:model`.

## Usage with Forms

```blade
<form wire:submit="filterProducts">
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-2">
                Price Range
            </label>
            <x-strata::range-slider
                wire:model.live="filters.price"
                :min="0"
                :max="1000"
                :step="10"
                prefix="$"
            />
            <p class="mt-2 text-sm text-muted-foreground">
                Selected: ${{ $filters['price']['min'] }} - ${{ $filters['price']['max'] }}
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">
                Rating Range
            </label>
            <x-strata::range-slider
                wire:model.live="filters.rating"
                :min="1"
                :max="5"
                :step="0.5"
            />
        </div>

        <button type="submit">Apply Filters</button>
    </div>
</form>
```

## Live Demo

For an interactive demonstration of all features and variants, visit:

```
http://your-app.test/range-slider
```

The demo page includes:
- E-commerce filter examples (price, discount, rating)
- Size variants showcase
- Validation states
- Display options
- Interactive demo with real-time updates
