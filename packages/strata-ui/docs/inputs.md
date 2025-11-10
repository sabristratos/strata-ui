# Inputs

Flexible input components with validation states, icons, prefix/suffix support, and Livewire integration. Supports all HTML5 input types with built-in action components for common patterns.

## Input Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `type` | string | `text` | Any HTML5 input type | Input type (text, email, password, number, tel, url, date, time, search, etc.) |
| `size` | string | `md` | `sm`, `md`, `lg` | Input size |
| `state` | string | `default` | `default`, `success`, `error`, `warning` | Validation state with automatic icon |
| `iconLeft` | string | `null` | Any icon name | Leading icon |
| `iconRight` | string | `null` | Any icon name | Trailing icon |
| `prefix` | string | `null` | Any text | Text before input (e.g., "$", "https://") |
| `suffix` | string | `null` | Any text | Text after input (e.g., "USD", ".com") |
| `disabled` | boolean | `false` | `true`, `false` | Disable input |

All other attributes (`wire:*`, `x-*`, `name`, `id`, `placeholder`, etc.) are passed to the input element.

## Action Components

Action components can be added via slot for common input patterns:

### Clear Button

Use `<x-strata::input.clear />` to add a clear button that only appears when input has a value.

### Toggle Password

Use `<x-strata::input.toggle-password />` to switch between showing and hiding password.

### Character Counter

Use `<x-strata::input.counter max="100" />` to show character count with color feedback.

## Example

```blade
{{-- Input with multiple props --}}
<x-strata::input
    type="email"
    size="lg"
    state="success"
    iconLeft="mail"
    prefix="https://"
    suffix=".com"
    placeholder="your-site"
    wire:model="domain"
/>

{{-- Input with action components --}}
<x-strata::input
    type="search"
    iconLeft="search"
    placeholder="Search..."
    wire:model.live.debounce.500ms="search"
>
    <x-strata::input.clear />
</x-strata::input>

{{-- Password with toggle and counter --}}
<x-strata::input
    type="password"
    iconLeft="lock"
    maxlength="50"
    placeholder="Password"
    wire:model="password"
>
    <x-strata::input.counter max="50" />
    <x-strata::input.toggle-password />
</x-strata::input>
```

## Form Fields

### Quick Shorthand (Recommended)

Add label, hint, and error props directly to the input component:

```blade
{{-- Basic field with label and validation --}}
<x-strata::input
    label="Email Address"
    hint="We'll never share your email"
    wire:model="email"
    type="email"
    iconLeft="mail"
    required
/>

{{-- With trailing hint --}}
<x-strata::input
    label="Username"
    hint="Choose a unique username"
    hintTrailing="Your username will be visible to others"
    wire:model="username"
    iconLeft="user"
    required
/>

{{-- Manual error message --}}
<x-strata::input
    label="Custom Field"
    error="This field has an error"
    wire:model="customField"
/>
```

**Shorthand Props:**
- `label` (string|null): Field label text
- `hint` (string|null): Help text above input
- `hintTrailing` (string|null): Help text below input
- `error` (string|null): Manual error (auto-detected from `$errors` if not provided)
- `required` (boolean): Show required indicator on label
- `spacing` (string): Field spacing (`tight`, `default`, `loose`)

All input props (type, size, state, iconLeft, etc.) work as normal.

### Custom Composition

For advanced layouts, compose fields manually:

```blade
<x-strata::field>
    <x-strata::field.label for="email" required>Email</x-strata::field.label>
    <x-strata::input
        id="email"
        type="email"
        wire:model="email"
        iconLeft="mail"
        :state="$errors->has('email') ? 'error' : 'default'"
    />
    <x-strata::field.hint>We'll never share your email</x-strata::field.hint>
    @error('email')
        <x-strata::field.error>{{ $message }}</x-strata::field.error>
    @enderror
</x-strata::field>
```

## Field Helper Components

### Label

```blade
<x-strata::field.label for="email" required>Email Address</x-strata::field.label>
```

**Props:**
- `for` (string): Input ID to associate with
- `required` (boolean): Show required indicator (*)

### Hint

```blade
<x-strata::field.hint>We'll send confirmation to this address</x-strata::field.hint>
```

**Props:**
- `hint` (string): Helper text (or use slot)

### Error

```blade
<x-strata::field.error>{{ $errors->first('email') }}</x-strata::field.error>
```

**Props:**
- `error` (string): Error message (or use slot)

### Field Wrapper

```blade
<x-strata::field spacing="default">
    <!-- Label, input, hint, error components -->
</x-strata::field>
```

**Props:**
- `spacing` (string): Spacing between elements (`tight`, `default`, `loose`)

## Livewire Integration

Wire directives are automatically passed to the input element:

```blade
<x-strata::input
    wire:model="email"
    wire:keydown.enter="submit"
    type="email"
    placeholder="Email"
/>
```

## Notes

- **Validation states:** Automatically show appropriate icons (success, error, warning)
- **Action components:** Work via data attributes - can be added anywhere in slot
- **Prefix/suffix:** Automatically styled and positioned - no manual spacing needed
- **Icons:** Passed as props, not slot content
- **Tactile depth:** Subtle inset shadow provides pressable feel
- **Focus states:** Visible focus rings for keyboard navigation
- **Responsive:** All elements scale with size prop
