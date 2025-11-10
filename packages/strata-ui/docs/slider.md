# Slider

A versatile slider component supporting both single-value and dual-handle range selection. Perfect for filtering products, settings, and any scenario requiring numeric value selection.

## Features

- **Dual Modes** - Single value or range (dual handles) selection
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

### Range Mode (Default)

```blade
<x-strata::slider
    mode="range"
    name="price_range"
    :min="0"
    :max="1000"
    :step="10"
/>
```

### Single Value Mode

```blade
<x-strata::slider
    mode="single"
    name="volume"
    :min="0"
    :max="100"
    :step="1"
/>
```

## With Livewire

### Range Mode

```blade
<x-strata::slider
    mode="range"
    wire:model.live="priceRange"
    :min="0"
    :max="1000"
    :step="10"
/>
```

The component syncs with Livewire using an object structure for range mode:

```php
public array $priceRange = ['min' => 100, 'max' => 900];
```

### Single Mode

```blade
<x-strata::slider
    mode="single"
    wire:model.live="volume"
    :min="0"
    :max="100"
/>
```

For single mode, use a simple numeric value:

```php
public int $volume = 50;
```

## E-commerce Examples

### Price Range Filter

```blade
<x-strata::slider
    mode="range"
    wire:model.live="priceRange"
    :min="0"
    :max="1000"
    :step="10"
    prefix="$"
/>
```

### Discount Range Filter

```blade
<x-strata::slider
    mode="range"
    wire:model.live="discountRange"
    :min="0"
    :max="100"
    :step="5"
    suffix="%"
/>
```

### Rating Range Filter

```blade
<x-strata::slider
    mode="range"
    wire:model.live="ratingRange"
    :min="1"
    :max="5"
    :step="0.5"
/>
```

## Other Use Cases

### Age Range

```blade
<x-strata::slider
    mode="range"
    wire:model.live="ageRange"
    :min="18"
    :max="65"
    :step="1"
    suffix=" yrs"
/>
```

### Temperature Range

```blade
<x-strata::slider
    mode="range"
    wire:model.live="temperatureRange"
    :min="-20"
    :max="50"
    :step="1"
    suffix="°C"
/>
```

### Volume Range

```blade
<x-strata::slider
    mode="range"
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
<x-strata::slider
    mode="range"
    size="sm"
    :min="0"
    :max="1000"
    prefix="$"
/>
```

### Medium (Default)

```blade
<x-strata::slider
    mode="range"
    size="md"
    :min="0"
    :max="1000"
    prefix="$"
/>
```

### Large

```blade
<x-strata::slider
    mode="range"
    size="lg"
    :min="0"
    :max="1000"
    prefix="$"
/>
```

## Validation States

### Success

```blade
<x-strata::slider
    mode="range"
    state="success"
    :min="0"
    :max="100"
/>
```

### Error

```blade
<x-strata::slider
    mode="range"
    state="error"
    :min="0"
    :max="100"
/>
```

### Warning

```blade
<x-strata::slider
    mode="range"
    state="warning"
    :min="0"
    :max="100"
/>
```

## Display Options

### Without Values

Hide the current min/max value display:

```blade
<x-strata::slider
    mode="range"
    :show-values="false"
    :min="0"
    :max="1000"
/>
```

### Without Labels

Hide the min/max labels at track ends:

```blade
<x-strata::slider
    mode="range"
    :show-labels="false"
    :min="0"
    :max="1000"
/>
```

### Minimal (No Values/Labels)

```blade
<x-strata::slider
    mode="range"
    :show-values="false"
    :show-labels="false"
    :min="0"
    :max="1000"
/>
```

## Disabled State

```blade
<x-strata::slider
    mode="range"
    :disabled="true"
    :min="0"
    :max="1000"
/>
```

## Initial Value

Set the initial range:

```blade
<x-strata::slider
    mode="range"
    :value="['min' => 100, 'max' => 900]"
    :min="0"
    :max="1000"
/>
```

For single mode:

```blade
<x-strata::slider
    mode="single"
    :value="50"
    :min="0"
    :max="100"
/>
```

## Keyboard Navigation

The slider supports comprehensive keyboard controls:

- **Arrow Left/Down** - Decrease value by one step
- **Arrow Right/Up** - Increase value by one step
- **Page Down** - Decrease value by 10 steps
- **Page Up** - Increase value by 10 steps
- **Home** - Jump to minimum value
- **End** - Jump to maximum value
- **Tab** - Move focus between min and max handles (range mode only)

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `string` | `null` | Component ID |
| `name` | `string` | `null` | Input name attribute |
| `mode` | `string` | `'range'` | Slider mode: `'single'` or `'range'` |
| `value` | `array\|int\|float` | `null` | Initial value. Array `['min' => x, 'max' => y]` for range mode, numeric for single mode |
| `min` | `int\|float` | `0` | Minimum allowed value |
| `max` | `int\|float` | `100` | Maximum allowed value |
| `step` | `int\|float` | `1` | Value increment/decrement step |
| `size` | `string` | `'md'` | Size variant: `'sm'`, `'md'`, `'lg'` |
| `state` | `string` | `'default'` | Validation state: `'default'`, `'success'`, `'error'`, `'warning'` |
| `disabled` | `bool` | `false` | Disable the slider |
| `show-values` | `bool` | `true` | Show current value(s) |
| `show-labels` | `bool` | `true` | Show min/max labels at track ends |
| `show-tooltips` | `bool` | `true` | Show tooltips on handles |
| `prefix` | `string` | `''` | Text to prepend to values (e.g., `'$'`) |
| `suffix` | `string` | `''` | Text to append to values (e.g., `'%'`, `'°C'`) |

## Accessibility

The slider component is fully accessible:

- **ARIA Attributes** - Each handle has `role="slider"`, `aria-valuemin`, `aria-valuemax`, `aria-valuenow`, `aria-label`
- **Keyboard Navigation** - Full keyboard support with arrow keys, page up/down, home/end
- **Focus Management** - Clear focus indicators on handles
- **Screen Reader Support** - Announces current values and labels

## Value Format

### Range Mode

The component uses an object structure for range values:

```php
[
    'min' => 100,  // Minimum value in range
    'max' => 900   // Maximum value in range
]
```

### Single Mode

The component uses a simple numeric value:

```php
50  // Current value
```

Both formats are automatically synchronized with Livewire when using `wire:model`.

## Usage with Forms

```blade
<form wire:submit="filterProducts">
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-2">
                Price Range
            </label>
            <x-strata::slider
                mode="range"
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
            <x-strata::slider
                mode="range"
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
http://your-app.test/slider
```

The demo page includes:
- Single and range mode examples
- E-commerce filter examples (price, discount, rating)
- Size variants showcase
- Validation states
- Display options
- Interactive demo with real-time updates
