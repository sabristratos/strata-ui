# Design System

Strata UI uses a comprehensive design token system built on Tailwind v4's `@theme` directive. This system provides 75 carefully crafted tokens that enable consistent styling across all components while remaining fully customizable.

## Philosophy

The design system is built on three core principles:

1. **Semantic tokens** - Use meaningful names like `primary`, `success`, and `destructive` rather than raw colors
2. **Automatic utilities** - All tokens generate corresponding Tailwind utilities (e.g., `bg-primary`, `text-success-foreground`)
3. **Full customization** - Override any token to completely restyle the library

## Token Structure

### Semantic Colors

Six semantic color categories, each with seven variants:

**Categories:** `primary`, `secondary`, `success`, `warning`, `destructive`, `info`

**Variants per category:**
- `{color}` - Base color
- `{color}-foreground` - Text/icons on colored background
- `{color}-hover` - Hover state
- `{color}-active` - Active/pressed state
- `{color}-subtle` - Light background variant
- `{color}-subtle-foreground` - Text on subtle background
- `{color}-border` - Border color

**Default mappings:**
- `primary` → Teal
- `secondary` → Slate
- `success` → Green
- `warning` → Amber
- `destructive` → Red
- `info` → Blue

### Foundation Tokens

Core tokens for page structure and common UI elements:

- `background` - Page background
- `foreground` - Main text color
- `muted` - Muted background (subtle sections)
- `muted-foreground` - Text on muted backgrounds
- `border` - Default border color
- `ring` - Focus ring color (defaults to primary)

### Component Tokens

Specialized tokens for specific component types:

**Card**
- `card` - Card background
- `card-foreground` - Text on cards
- `card-border` - Card borders

**Popover**
- `popover` - Popover background
- `popover-foreground` - Text in popovers
- `popover-border` - Popover borders

**Dialog**
- `dialog` - Dialog background
- `dialog-foreground` - Text in dialogs
- `dialog-border` - Dialog borders
- `dialog-overlay` - Backdrop overlay

**Tooltip**
- `tooltip` - Tooltip background
- `tooltip-foreground` - Text in tooltips

**Input**
- `input` - Input background
- `input-foreground` - Input text
- `input-border` - Default border
- `input-border-hover` - Border on hover
- `input-border-focus` - Border when focused
- `input-placeholder` - Placeholder text
- `input-disabled` - Disabled background
- `input-disabled-foreground` - Disabled text
- `input-disabled-border` - Disabled border

**Table**
- `table-header` - Table header background
- `table-header-foreground` - Header text
- `table-row-hover` - Row hover background
- `table-border` - Table borders

### State Tokens

- `disabled` - Disabled element background
- `disabled-foreground` - Disabled element text

## Using Design Tokens

### In Components

All Strata UI components use these tokens automatically:

```blade
{{-- Badge using semantic tokens --}}
<x-strata::badge variant="success">Active</x-strata::badge>

{{-- This uses: bg-success and text-success-foreground --}}
```

### With Tailwind Utilities

Use token-based utilities in your own HTML:

```blade
<div class="bg-card text-card-foreground border border-card-border rounded-lg p-4">
  <h2 class="text-foreground font-semibold">Card Title</h2>
  <p class="text-muted-foreground">Card description text</p>
</div>
```

### In Custom CSS

Reference tokens as CSS variables for custom styling:

```css
.custom-alert {
  background-color: var(--color-warning-subtle);
  color: var(--color-warning-subtle-foreground);
  border: 1px solid var(--color-warning-border);
}
```

### In Inline Styles

```blade
<div style="background-color: var(--color-primary)">
  Custom styled element
</div>
```

## Customizing the Design System

### Override Individual Tokens

Create your own theme file and import it after Strata UI:

```css
/* resources/css/app.css */
@import "tailwindcss";
@import "../../packages/strata-ui/resources/css/strata.css";

@theme {
  /* Change primary color to purple */
  --color-primary: light-dark(theme(colors.purple.600), theme(colors.purple.500));
  --color-primary-foreground: white;
  --color-primary-hover: light-dark(theme(colors.purple.700), theme(colors.purple.400));
  --color-primary-active: light-dark(theme(colors.purple.800), theme(colors.purple.300));
  --color-primary-subtle: light-dark(theme(colors.purple.50), theme(colors.purple.950 / 10%));
  --color-primary-subtle-foreground: light-dark(theme(colors.purple.900), theme(colors.purple.100));
  --color-primary-border: light-dark(theme(colors.purple.300), theme(colors.purple.700));
}
```

Now all primary buttons, badges, and components use purple instead of teal.

### Change Input Styling

Want all inputs to have blue focus borders?

```css
@theme {
  --color-input-border-focus: theme(colors.blue.500);
}
```

### Customize Component Families

Make all popovers have a different background:

```css
@theme {
  --color-popover: theme(colors.slate.100);
  --color-popover-foreground: theme(colors.slate.900);
}
```

### Complete Theme Replacement

Replace the entire color system:

```css
@theme {
  /* Remove default colors */
  --color-*: initial;

  /* Define your brand colors */
  --color-primary: oklch(0.5 0.2 250);
  --color-primary-foreground: white;
  --color-primary-hover: oklch(0.45 0.22 250);
  /* ... continue with all variants ... */
}
```

## Dark Mode

All tokens use Tailwind v4's `light-dark()` function for automatic dark mode support:

```css
--color-background: light-dark(white, theme(colors.slate.950));
```

No additional configuration needed - dark mode works automatically when users toggle their system preference or when you use Tailwind's dark mode utilities.

## Complete Token Reference

### Semantic Colors (42 tokens)

#### Primary (Teal)
```
--color-primary
--color-primary-foreground
--color-primary-hover
--color-primary-active
--color-primary-subtle
--color-primary-subtle-foreground
--color-primary-border
```

#### Secondary (Slate)
```
--color-secondary
--color-secondary-foreground
--color-secondary-hover
--color-secondary-active
--color-secondary-subtle
--color-secondary-subtle-foreground
--color-secondary-border
```

#### Success (Green)
```
--color-success
--color-success-foreground
--color-success-hover
--color-success-active
--color-success-subtle
--color-success-subtle-foreground
--color-success-border
```

#### Warning (Amber)
```
--color-warning
--color-warning-foreground
--color-warning-hover
--color-warning-active
--color-warning-subtle
--color-warning-subtle-foreground
--color-warning-border
```

#### Destructive (Red)
```
--color-destructive
--color-destructive-foreground
--color-destructive-hover
--color-destructive-active
--color-destructive-subtle
--color-destructive-subtle-foreground
--color-destructive-border
```

#### Info (Blue)
```
--color-info
--color-info-foreground
--color-info-hover
--color-info-active
--color-info-subtle
--color-info-subtle-foreground
--color-info-border
```

### Foundation (6 tokens)
```
--color-background
--color-foreground
--color-muted
--color-muted-foreground
--color-border
--color-ring
```

### Component Tokens (25 tokens)

**Card (3)**
```
--color-card
--color-card-foreground
--color-card-border
```

**Popover (3)**
```
--color-popover
--color-popover-foreground
--color-popover-border
```

**Dialog (4)**
```
--color-dialog
--color-dialog-foreground
--color-dialog-border
--color-dialog-overlay
```

**Tooltip (2)**
```
--color-tooltip
--color-tooltip-foreground
```

**Input (9)**
```
--color-input
--color-input-foreground
--color-input-border
--color-input-border-hover
--color-input-border-focus
--color-input-placeholder
--color-input-disabled
--color-input-disabled-foreground
--color-input-disabled-border
```

**Table (4)**
```
--color-table-header
--color-table-header-foreground
--color-table-row-hover
--color-table-border
```

### State Tokens (2 tokens)
```
--color-disabled
--color-disabled-foreground
```

## Examples

### Custom Brand Colors

```css
@theme {
  /* Override primary to match your brand */
  --color-primary: #FF6B35;
  --color-primary-foreground: white;
  --color-primary-hover: #E55A2B;
  --color-primary-active: #CC4E23;
  --color-primary-subtle: #FFF5F2;
  --color-primary-subtle-foreground: #991F00;
  --color-primary-border: #FFB8A1;
}
```

### High Contrast Mode

```css
@theme {
  --color-border: light-dark(theme(colors.slate.400), theme(colors.slate.600));
  --color-input-border: light-dark(theme(colors.slate.400), theme(colors.slate.600));
}
```

### Subtle UI

```css
@theme {
  --color-card: var(--color-background);
  --color-card-border: var(--color-muted);
}
```
