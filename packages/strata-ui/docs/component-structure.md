# Component File Structure

Strata UI follows a consistent, organized folder structure for all components. This guide explains how components are organized and why.

## The Pattern

**Every component lives in its own folder with the base component named `index.blade.php`.**

This applies to ALL components, even those without child components.

### Basic Structure

```
components/
  button/
    index.blade.php     → <x-strata::button />
    icon.blade.php      → <x-strata::button.icon />

  input/
    index.blade.php     → <x-strata::input />
    clear.blade.php     → <x-strata::input.clear />
    counter.blade.php   → <x-strata::input.counter />

  alert/
    index.blade.php     → <x-strata::alert />
```

## How It Works

Laravel automatically resolves component references:

- `<x-strata::button />` → `button/index.blade.php`
- `<x-strata::button.icon />` → `button/icon.blade.php`
- `<x-strata::input.clear />` → `input/clear.blade.php`

The `index.blade.php` naming convention is native to Laravel's component system.

## Component Organization

### Components with Children

Most form components have child components:

```
card/
  index.blade.php       → Base card component
  body.blade.php        → Card body
  header.blade.php      → Card header
  footer.blade.php      → Card footer
  image.blade.php       → Card image

input/
  index.blade.php       → Base input component
  clear.blade.php       → Clear button action
  counter.blade.php     → Character counter
  toggle-password.blade.php → Password visibility toggle

table/
  index.blade.php       → Base table component
  body.blade.php        → Table body
  cell.blade.php        → Table cell
  header.blade.php      → Table header
  row.blade.php         → Table row
  ...and more
```

### Standalone Components

Components without children also live in folders:

```
alert/
  index.blade.php       → Alert component

kbd/
  index.blade.php       → Keyboard shortcut component

toggle/
  index.blade.php       → Toggle switch component
```

### Special Cases

Some component folders contain only helper/child components with no base component:

**field/** - Helper components for form layouts:
```
field/
  index.blade.php       → <x-strata::field> (wrapper)
  label.blade.php       → <x-strata::field.label />
  error.blade.php       → <x-strata::field.error />
  hint.blade.php        → <x-strata::field.hint />
```

**icon/** - Icon library with individual icon files:
```
icon/
  accessibility.blade.php   → <x-strata::icon.accessibility />
  alert-circle.blade.php    → <x-strata::icon.alert-circle />
  ...hundreds of icon files
```

## Why This Structure?

### 1. Organization
All files related to a component live together in one place. No need to hunt through mixed files and folders.

### 2. Consistency
Every component follows the same pattern. New developers can immediately understand the structure.

### 3. Scalability
Easy to see component families and their relationships at a glance. Adding new child components is straightforward.

### 4. Clean Hierarchy
No mixing of files and folders at the same level. The components directory contains only folders.

### 5. No Breaking Changes
Laravel's automatic `index.blade.php` resolution means:
- Existing component references keep working
- No code updates needed
- Seamless migration from old structure

## Complete Component List

Current components in Strata UI:

- **accordion/** - Collapsible content sections
- **alert/** - Alert/notification messages
- **avatar/** - User avatars
- **badge/** - Status badges and labels
- **button/** - Buttons and button groups
- **card/** - Content cards
- **checkbox/** - Checkbox inputs
- **field/** - Field helper components and shorthand form fields
- **file-input/** - File upload inputs
- **group/** - Generic grouping component
- **icon/** - Icon library
- **input/** - Text inputs
- **kbd/** - Keyboard shortcuts
- **popover/** - Popover overlays
- **radio/** - Radio button inputs
- **select/** - Select/dropdown inputs
- **table/** - Data tables
- **textarea/** - Textarea inputs
- **toggle/** - Toggle switches

## Usage Examples

### Using Base Components

```blade
<x-strata::button>Click Me</x-strata::button>
<x-strata::input type="text" placeholder="Enter text..." />
<x-strata::alert>This is an alert message</x-strata::alert>
```

### Using Child Components

```blade
<x-strata::card>
    <x-strata::card.header>
        <h2>Card Title</h2>
    </x-strata::card.header>

    <x-strata::card.body>
        <p>Card content goes here</p>
    </x-strata::card.body>

    <x-strata::card.footer>
        <x-strata::button>Action</x-strata::button>
    </x-strata::card.footer>
</x-strata::card>
```

### Using Field Components (Shorthand)

```blade
{{-- Quick shorthand - props on input directly --}}
<x-strata::input
    label="Email Address"
    hint="We'll never share your email"
    wire:model="email"
    type="email"
    required
/>

{{-- Custom composition --}}
<x-strata::field>
    <x-strata::field.label for="email">Email Address</x-strata::field.label>
    <x-strata::input type="email" id="email" />
    <x-strata::field.hint>We'll never share your email</x-strata::field.hint>
    <x-strata::field.error name="email" />
</x-strata::field>
```

## Creating New Components

When creating new components:

1. Always create a folder first
2. Create `index.blade.php` for the base component
3. Add child components as needed in the same folder
4. Follow existing naming patterns

```bash
components/
  your-component/
    index.blade.php      # Base component
    variant.blade.php    # Child component
    action.blade.php     # Another child
```

## Migration Notes

If you're familiar with the old structure where base components were files at the root level:

**Old Structure:**
```
components/
  button.blade.php
  button/
    icon.blade.php
```

**New Structure:**
```
components/
  button/
    index.blade.php
    icon.blade.php
```

The component usage remains identical. Laravel automatically resolves `<x-strata::button />` to `button/index.blade.php`.
