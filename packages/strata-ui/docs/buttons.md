# Buttons

Flexible button components with realistic 3D styling, multiple variants, and comprehensive state management.

## Basic Usage

```blade
<x-strata::button>Default Button</x-strata::button>
<x-strata::button variant="success">Success Button</x-strata::button>
<x-strata::button variant="destructive">Delete</x-strata::button>
```

## Variants

Available variants: `primary` (default), `secondary`, `success`, `warning`, `destructive`, `info`

```blade
<x-strata::button variant="primary">Primary</x-strata::button>
<x-strata::button variant="secondary">Secondary</x-strata::button>
<x-strata::button variant="success">Success</x-strata::button>
<x-strata::button variant="warning">Warning</x-strata::button>
<x-strata::button variant="destructive">Destructive</x-strata::button>
<x-strata::button variant="info">Info</x-strata::button>
```

## Sizes

Available sizes: `sm`, `md` (default), `lg`

```blade
<x-strata::button size="sm">Small</x-strata::button>
<x-strata::button size="md">Medium</x-strata::button>
<x-strata::button size="lg">Large</x-strata::button>
```

## Styles

Available styles: `filled` (default), `outlined`, `ghost`, `link`

### Filled

The filled style features realistic 3D effects with gradient overlays, inset shadows, and tactile hover states:

```blade
<x-strata::button appearance="filled" variant="primary">Filled Button</x-strata::button>
```

### Outlined

Transparent background with colored border:

```blade
<x-strata::button appearance="outlined" variant="primary">Outlined Button</x-strata::button>
```

### Ghost

Transparent background, no border, shows subtle background on hover:

```blade
<x-strata::button appearance="ghost" variant="primary">Ghost Button</x-strata::button>
```

### Link

Text-only appearance with underline on hover:

```blade
<x-strata::button appearance="link" variant="primary">Link Button</x-strata::button>
```

## With Icons

Add icons before or after the text:

```blade
{{-- Leading icon --}}
<x-strata::button icon="plus" variant="primary">Add Item</x-strata::button>
<x-strata::button icon="save" variant="success">Save</x-strata::button>

{{-- Trailing icon --}}
<x-strata::button icon-trailing="arrow-right" variant="secondary">Next</x-strata::button>

{{-- Both icons --}}
<x-strata::button icon="download" icon-trailing="chevron-down" variant="info">
    Download
</x-strata::button>
```

## Icon Buttons

Square buttons for single icons using `button.icon`:

```blade
<x-strata::button.icon icon="heart" variant="primary" aria-label="Like" />
<x-strata::button.icon icon="share-2" variant="secondary" aria-label="Share" />
<x-strata::button.icon icon="bookmark" variant="info" aria-label="Bookmark" />
```

Icon buttons support all the same variants, styles, and sizes as regular buttons.

## Loading State

Show a spinner and disable interaction:

```blade
<x-strata::button :loading="true" variant="primary">Loading</x-strata::button>
<x-strata::button :loading="$isProcessing" icon="check" variant="success">
    Process
</x-strata::button>
```

### With Livewire

```blade
<x-strata::button wire:click="submit" :loading="$isSubmitting" variant="primary">
    Submit Form
</x-strata::button>
```

## Disabled State

```blade
<x-strata::button :disabled="true" variant="secondary">Disabled</x-strata::button>
<x-strata::button :disabled="!$canSubmit" variant="primary">Submit</x-strata::button>
```

## Button Types

Specify HTML button type attribute:

```blade
<x-strata::button type="button" variant="secondary">Cancel</x-strata::button>
<x-strata::button type="submit" variant="primary">Submit</x-strata::button>
<x-strata::button type="reset" variant="destructive">Reset</x-strata::button>
```

## Props Reference

### Base Button

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `primary` | Color variant |
| `size` | string | `md` | Button size |
| `style` | string | `filled` | Button style |
| `icon` | string | `null` | Leading icon name |
| `icon-trailing` | string | `null` | Trailing icon name |
| `loading` | boolean | `false` | Show spinner, disable interaction |
| `disabled` | boolean | `false` | Disabled state |
| `type` | string | `button` | HTML button type |

### Icon Button

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `primary` | Color variant |
| `size` | string | `md` | Button size |
| `style` | string | `filled` | Button style |
| `icon` | string | `null` | Icon name (required) |
| `loading` | boolean | `false` | Show spinner, disable interaction |
| `disabled` | boolean | `false` | Disabled state |
| `type` | string | `button` | HTML button type |

**Note:** Icon buttons require `aria-label` attribute for accessibility.

## Examples

### Form Actions

```blade
<form wire:submit="save">
    <div class="flex gap-2">
        <x-strata::button type="submit" variant="primary" icon="check" :loading="$isSaving">
            Save Changes
        </x-strata::button>
        <x-strata::button type="button" variant="secondary" wire:click="cancel">
            Cancel
        </x-strata::button>
    </div>
</form>
```

### Confirmation Actions

```blade
<div class="flex gap-2">
    <x-strata::button variant="destructive" icon="trash-2" wire:click="delete">
        Delete Account
    </x-strata::button>
    <x-strata::button variant="secondary" appearance="outlined">
        Keep Account
    </x-strata::button>
</div>
```

### Navigation

```blade
<div class="flex gap-2">
    <x-strata::button appearance="ghost" icon="arrow-left">
        Back
    </x-strata::button>
    <x-strata::button variant="primary" icon-trailing="arrow-right">
        Continue
    </x-strata::button>
</div>
```

### Action Bar

```blade
<div class="flex items-center gap-2">
    <x-strata::button.icon icon="plus" variant="primary" aria-label="Add new" />
    <x-strata::button.icon icon="filter" variant="secondary" aria-label="Filter" />
    <x-strata::button.icon icon="download" variant="secondary" aria-label="Download" />
    <x-strata::button.icon icon="settings" variant="secondary" appearance="ghost" aria-label="Settings" />
</div>
```

### Loading States

```blade
<x-strata::button
    wire:click="processPayment"
    :loading="$isProcessing"
    :disabled="!$canProcess"
    variant="success"
    icon="credit-card"
>
    {{ $isProcessing ? 'Processing...' : 'Pay Now' }}
</x-strata::button>
```

### Grouped Buttons

```blade
<div class="inline-flex rounded-lg shadow-sm" role="group">
    <x-strata::button variant="secondary" size="sm" class="rounded-r-none border-r-0">
        Left
    </x-strata::button>
    <x-strata::button variant="secondary" size="sm" class="rounded-none border-r-0">
        Middle
    </x-strata::button>
    <x-strata::button variant="secondary" size="sm" class="rounded-l-none">
        Right
    </x-strata::button>
</div>
```

## Design Details

### 3D Filled Style

The filled button style uses several CSS techniques for realistic appearance:

- **Gradient Overlay**: White-to-transparent gradient on top surface
- **Shadow**: Subtle drop shadow for elevation
- **Border**: Matches background color for depth
- **Hover**: Enhanced background color
- **Active**: Darker background simulating button press

### Accessibility

All buttons include:

- Proper focus states with visible ring
- Keyboard navigation support
- Disabled state handling
- ARIA attributes for loading and disabled states
- Icon buttons require `aria-label` for screen readers

### Transitions

All state changes use smooth transitions (`duration-150`) for professional feel.
