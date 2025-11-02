# Rating

A flexible, interactive star rating component with multiple variants, half-star support, and full Livewire integration.

## Features

- **Multiple Variants**: Read-only display, interactive input, and clearable input
- **Half-Star Support**: Precise 0.5 increment ratings for detailed feedback
- **Full-Star Mode**: Integer-only ratings for simpler implementations
- **Configurable Maximum**: Support for any rating scale (5-star, 10-star, etc.)
- **Keyboard Navigation**: Full arrow key support with Enter/Space to confirm
- **Livewire Integration**: Full `wire:model` support with real-time sync
- **Size Variants**: Small, medium, and large sizes
- **State Colors**: Default (yellow), success, error, and warning states
- **Rating Display**: Optional numeric value and review count display
- **Accessible**: ARIA labels, keyboard navigation, screen reader support
- **Touch-Friendly**: Optimized for mobile interaction
- **Dark Mode**: Automatic dark mode support

## Basic Usage

### Read-Only Display

Display a static rating (non-interactive).

```blade
<x-strata::rating :value="4.5" />
```

With rating value and review count:

```blade
<x-strata::rating
    :value="4.5"
    :show-rating="true"
    :show-count="true"
    :count="127"
/>
```

### Interactive Input

Allow users to select a rating.

```blade
<x-strata::rating
    variant="input"
    wire:model.live="rating"
    :show-rating="true"
/>
```

### Clearable Input

Interactive rating with ability to clear/reset.

```blade
<x-strata::rating
    variant="clearable"
    wire:model.live="rating"
    :show-rating="true"
/>
```

## Variants

### Default (Read-Only)

Static display for showing existing ratings.

```blade
<x-strata::rating :value="4" />

<x-strata::rating :value="4.5" :show-rating="true" />

<x-strata::rating
    :value="4.5"
    :show-rating="true"
    :show-count="true"
    :count="89"
/>
```

### Input

Interactive stars for forms and user feedback.

```blade
<x-strata::rating
    variant="input"
    wire:model.live="productRating"
/>
```

### Clearable

Input variant with a clear button to reset to 0.

```blade
<x-strata::rating
    variant="clearable"
    wire:model.live="serviceRating"
    :show-rating="true"
/>
```

## Precision Modes

### Half-Star Precision (0.5)

Allow ratings in 0.5 increments (default).

```blade
<x-strata::rating
    variant="input"
    wire:model.live="rating"
    :precision="0.5"
    :show-rating="true"
/>
```

Users can click the left or right half of a star for half-star increments.

### Full-Star Precision (1.0)

Only allow whole star ratings.

```blade
<x-strata::rating
    variant="input"
    wire:model.live="rating"
    :precision="1"
    :show-rating="true"
/>
```

## Maximum Rating

### 5-Star Rating (Default)

```blade
<x-strata::rating
    variant="input"
    :max="5"
    wire:model.live="rating"
/>
```

### 10-Star Rating

```blade
<x-strata::rating
    variant="input"
    :max="10"
    wire:model.live="rating"
    :show-rating="true"
/>
```

### Custom Maximum

```blade
<x-strata::rating
    variant="input"
    :max="7"
    wire:model.live="rating"
/>
```

## Sizes

Available sizes: `sm`, `md` (default), `lg`

```blade
<x-strata::rating size="sm" :value="4.5" />

<x-strata::rating size="md" :value="4.5" />

<x-strata::rating size="lg" :value="4.5" />
```

## State Colors

Change star colors to indicate different states or contexts.

### Default (Yellow)

Standard yellow/gold stars for ratings.

```blade
<x-strata::rating state="default" :value="4" />
```

### Success (Green)

Green stars for positive feedback.

```blade
<x-strata::rating state="success" :value="5" />
```

### Error (Red)

Red stars for negative feedback or errors.

```blade
<x-strata::rating state="error" :value="2" />
```

### Warning (Orange)

Orange stars for warnings or cautions.

```blade
<x-strata::rating state="warning" :value="3" />
```

## Labels and Descriptions

### With Label

```blade
<x-strata::rating
    variant="input"
    wire:model.live="rating"
    label="Product Quality"
    :show-rating="true"
/>
```

### With Label and Count

```blade
<x-strata::rating
    variant="input"
    wire:model.live="rating"
    label="Customer Service"
    :show-rating="true"
    :show-count="true"
    :count="156"
/>
```

## Disabled State

Disable interaction while still showing the rating.

```blade
<x-strata::rating
    variant="input"
    :value="3.5"
    disabled
    :show-rating="true"
/>
```

## Livewire Integration

### Basic Form

```blade
<form wire:submit="submitReview">
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-2">
                Product Rating *
            </label>
            <x-strata::rating
                variant="input"
                wire:model="productRating"
                :show-rating="true"
            />
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">
                Service Rating *
            </label>
            <x-strata::rating
                variant="input"
                wire:model="serviceRating"
                :show-rating="true"
            />
        </div>

        <x-strata::button type="submit">
            Submit Review
        </x-strata::button>
    </div>
</form>
```

### Livewire Component

```php
<?php

namespace App\Livewire;

use Livewire\Component;

class ReviewForm extends Component
{
    public float $productRating = 0;
    public float $serviceRating = 0;
    public float $experienceRating = 0;

    public function submitReview()
    {
        $this->validate([
            'productRating' => 'required|numeric|min:0.5|max:5',
            'serviceRating' => 'required|numeric|min:0.5|max:5',
            'experienceRating' => 'required|numeric|min:0.5|max:5',
        ]);

        // Save review...

        session()->flash('message', 'Thank you for your review!');
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
```

## Keyboard Navigation

When the rating component has focus, use these keys:

- **→** (Right Arrow): Increase rating by one increment
- **←** (Left Arrow): Decrease rating by one increment
- **Enter** or **Space**: Confirm the current rating
- **Escape**: Clear hover state

```blade
<x-strata::rating
    variant="input"
    wire:model.live="rating"
    :show-rating="true"
/>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Rating variant: `default`, `input`, `clearable` |
| `value` | float | `0` | Current rating value (0 to max) |
| `max` | int | `5` | Maximum rating value |
| `precision` | float | `0.5` | Rating increment: `0.5` for half-stars, `1` for full stars |
| `size` | string | `'md'` | Size variant: `sm`, `md`, `lg` |
| `state` | string | `'default'` | Color state: `default`, `success`, `error`, `warning` |
| `disabled` | bool | `false` | Disable interaction |
| `readonly` | bool | `false` | Make non-interactive (alias for `variant="default"`) |
| `show-rating` | bool | `false` | Display numeric rating value |
| `show-count` | bool | `false` | Display review count |
| `count` | int\|null | `null` | Number of reviews/ratings |
| `label` | string\|null | `null` | Accessible label text |
| `id` | string\|null | `null` | Component ID (auto-generated if not provided) |

## Accessibility

The rating component is built with accessibility in mind:

### Read-Only Display
- Uses `role="img"` for static ratings
- Includes `aria-label` with the rating value (e.g., "Rating: 4.5 out of 5 stars")

### Interactive Input
- Uses `role="radiogroup"` for the container
- Individual stars have `role="radio"` with appropriate `aria-checked` state
- Each star has descriptive `aria-label` (e.g., "4 stars")
- Full keyboard navigation support
- Focus indicators on stars
- Screen reader announcements on value changes

### Best Practices

Always provide a label for interactive ratings:

```blade
<label for="product-rating" class="block text-sm font-medium mb-2">
    Product Rating *
</label>
<x-strata::rating
    id="product-rating"
    variant="input"
    wire:model="productRating"
    label="Product Rating"
    :show-rating="true"
/>
```

## Examples

### Product Review Form

```blade
<div class="space-y-6">
    <div>
        <label class="block text-sm font-medium mb-2">
            How would you rate this product?
        </label>
        <x-strata::rating
            variant="input"
            wire:model.live="rating"
            :show-rating="true"
            size="lg"
        />
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">
            Review Text
        </label>
        <x-strata::textarea wire:model="reviewText" rows="4" />
    </div>

    <x-strata::button wire:click="submitReview" variant="primary">
        Submit Review
    </x-strata::button>
</div>
```

### Display Average Rating

```blade
<div class="flex items-center gap-3">
    <x-strata::rating
        :value="$product->averageRating"
        :show-rating="true"
        :show-count="true"
        :count="$product->reviewCount"
        size="lg"
    />
</div>
```

### Multi-Criteria Rating Form

```blade
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium mb-2">
            Product Quality
        </label>
        <x-strata::rating
            variant="input"
            wire:model.live="qualityRating"
            :show-rating="true"
        />
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">
            Value for Money
        </label>
        <x-strata::rating
            variant="input"
            wire:model.live="valueRating"
            :show-rating="true"
        />
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">
            Customer Service
        </label>
        <x-strata::rating
            variant="clearable"
            wire:model.live="serviceRating"
            :show-rating="true"
        />
    </div>

    <div class="p-4 bg-muted rounded-lg">
        <p class="text-sm font-medium">Overall Average:</p>
        <div class="mt-2">
            <x-strata::rating
                :value="($qualityRating + $valueRating + $serviceRating) / 3"
                :show-rating="true"
                size="lg"
            />
        </div>
    </div>
</div>
```

### Different Rating Scales

```blade
{{-- 5-star rating for general feedback --}}
<x-strata::rating
    variant="input"
    :max="5"
    wire:model="generalRating"
    label="Overall Satisfaction"
/>

{{-- 10-star rating for detailed analysis --}}
<x-strata::rating
    variant="input"
    :max="10"
    wire:model="detailedRating"
    label="Performance Score"
/>

{{-- 3-star rating for simple feedback --}}
<x-strata::rating
    variant="input"
    :max="3"
    wire:model="simpleRating"
    label="Difficulty Level"
/>
```

## Styling

The rating component uses Tailwind CSS utilities and respects your theme colors:

- **Default stars**: `text-yellow-400` (filled), `text-gray-300` (empty)
- **Success stars**: `text-success`
- **Error stars**: `text-destructive`
- **Warning stars**: `text-warning`

Stars use `fill-current` to inherit the text color, making customization easy through parent text utilities.
