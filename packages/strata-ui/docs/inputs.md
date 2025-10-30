# Inputs

Flexible input components with validation states, icons, prefix/suffix support, and composable form fields.

## Basic Usage

```blade
<x-strata::input placeholder="Enter text..." />
<x-strata::input type="email" placeholder="Email address" />
<x-strata::input type="password" placeholder="Password" />
```

## Input Types

Supports all HTML5 input types via the `type` prop:

```blade
<x-strata::input type="text" placeholder="Text" />
<x-strata::input type="email" placeholder="Email" />
<x-strata::input type="password" placeholder="Password" />
<x-strata::input type="number" placeholder="Number" />
<x-strata::input type="tel" placeholder="Phone" />
<x-strata::input type="url" placeholder="URL" />
<x-strata::input type="date" />
<x-strata::input type="time" />
<x-strata::input type="search" placeholder="Search..." />
```

## Sizes

Available sizes: `sm`, `md` (default), `lg`

```blade
<x-strata::input size="sm" placeholder="Small" />
<x-strata::input size="md" placeholder="Medium" />
<x-strata::input size="lg" placeholder="Large" />
```

## Validation States

Show validation feedback with state variants:

```blade
<x-strata::input state="default" placeholder="Default" />
<x-strata::input state="success" value="Valid input" />
<x-strata::input state="error" value="Invalid input" />
<x-strata::input state="warning" value="Warning" />
```

Each state automatically shows the appropriate icon and border color.

## With Icons

Add leading or trailing icons:

```blade
{{-- Leading icon --}}
<x-strata::input iconLeft="search" placeholder="Search..." />
<x-strata::input iconLeft="mail" type="email" placeholder="Email" />
<x-strata::input iconLeft="lock" type="password" placeholder="Password" />

{{-- Both icons --}}
<x-strata::input iconLeft="user" iconRight="check" value="John Doe" />
```

## Prefix and Suffix

Add text labels before or after the input:

```blade
{{-- Prefix --}}
<x-strata::input prefix="$" type="number" placeholder="0.00" />
<x-strata::input prefix="https://" placeholder="example.com" />

{{-- Suffix --}}
<x-strata::input suffix="USD" type="number" placeholder="Amount" />
<x-strata::input suffix="@example.com" placeholder="username" />

{{-- Both --}}
<x-strata::input prefix="$" suffix="USD" type="number" value="100" />
```

## Action Components

Strata UI provides reusable action components that automatically work when added to inputs.

### Clear Button

Automatically clears the input and only shows when there's a value:

```blade
<x-strata::input type="search" placeholder="Search...">
    <x-strata::input.clear />
</x-strata::input>
```

The clear button:
- Only appears when input has value
- Clears the value on click
- Refocuses the input
- Dispatches input event (works with Livewire)

### Toggle Password Visibility

Switches between showing and hiding password:

```blade
<x-strata::input type="password" placeholder="Password">
    <x-strata::input.toggle-password />
</x-strata::input>
```

The toggle button:
- Switches input type between 'password' and 'text'
- Shows eye icon when hidden, eye-off when visible
- Updates aria-label for accessibility

### Character Counter

Shows current length vs maximum with color feedback:

```blade
<x-strata::input placeholder="Bio" maxlength="100">
    <x-strata::input.counter max="100" />
</x-strata::input>
```

The counter:
- Updates in real-time as you type
- Shows "X/100" format
- Color changes: muted (normal) → warning (80%) → destructive (100%)
- Props: `max` (required)

### Combining Actions

You can combine multiple action components:

```blade
<x-strata::input type="password" maxlength="50">
    <x-strata::input.counter max="50" />
    <x-strata::input.toggle-password />
</x-strata::input>
```

### Custom Actions

You can also add your own buttons or elements:

```blade
<x-strata::input iconLeft="search" placeholder="Search...">
    <x-strata::input.clear />
    <x-strata::button size="sm" variant="primary" wire:click="search">
        Search
    </x-strata::button>
</x-strata::input>
```

## Disabled State

```blade
<x-strata::input disabled value="Cannot edit this" />
```

## Livewire Integration

All wire:* attributes are automatically passed to the input element:

```blade
<x-strata::input
    wire:model="email"
    wire:keydown.enter="submit"
    type="email"
    placeholder="Email"
/>

<x-strata::input
    wire:model.live.debounce.500ms="search"
    iconLeft="search"
    placeholder="Search..."
/>
```

## Alpine.js Integration

Alpine directives are also passed to the input:

```blade
<x-strata::input
    x-model="username"
    @input="validateUsername()"
    placeholder="Username"
/>
```

## Form Components

### Label

Accessible labels with required indicator:

```blade
<x-strata::form.label for="email">Email Address</x-strata::form.label>

<x-strata::form.label for="name" required>Full Name</x-strata::form.label>
```

### Hint Text

Helper text for additional context:

```blade
<x-strata::form.hint>We'll never share your email</x-strata::form.hint>

{{-- Or with prop --}}
<x-strata::form.hint hint="Enter your full legal name" />
```

### Error Message

Validation error display with icon:

```blade
<x-strata::form.error>This field is required</x-strata::form.error>

{{-- Or with prop --}}
<x-strata::form.error error="Invalid email format" />

{{-- With Laravel errors --}}
<x-strata::form.error>{{ $errors->first('email') }}</x-strata::form.error>
```

### Field Wrapper

Compose complete form fields:

```blade
<x-strata::form.field>
    <x-strata::form.label for="email" required>Email</x-strata::form.label>
    <x-strata::input id="email" type="email" wire:model="email" />
    <x-strata::form.hint>We'll send confirmation to this address</x-strata::form.hint>
</x-strata::form.field>
```

The field wrapper provides consistent spacing between label, input, hint, and error.

## Complete Examples

### Basic Field

```blade
<x-strata::form.field>
    <x-strata::form.label for="name" required>Full Name</x-strata::form.label>
    <x-strata::input id="name" iconLeft="user" placeholder="John Doe" />
    <x-strata::form.hint>Enter your first and last name</x-strata::form.hint>
</x-strata::form.field>
```

### With Success State

```blade
<x-strata::form.field>
    <x-strata::form.label for="email" required>Email</x-strata::form.label>
    <x-strata::input
        id="email"
        type="email"
        state="success"
        iconLeft="mail"
        value="john@example.com"
    />
</x-strata::form.field>
```

### With Error State

```blade
<x-strata::form.field>
    <x-strata::form.label for="password" required>Password</x-strata::form.label>
    <x-strata::input
        id="password"
        type="password"
        state="error"
        iconLeft="lock"
        value="weak"
    />
    <x-strata::form.error>Password must be at least 8 characters</x-strata::form.error>
</x-strata::form.field>
```

### With Prefix and Suffix

```blade
<x-strata::form.field>
    <x-strata::form.label for="amount">Amount</x-strata::form.label>
    <x-strata::input
        id="amount"
        type="number"
        prefix="$"
        suffix="USD"
        placeholder="0.00"
    />
    <x-strata::form.hint>Enter the transaction amount</x-strata::form.hint>
</x-strata::form.field>
```

### Livewire Form

```blade
<form wire:submit="save">
    <x-strata::form.field>
        <x-strata::form.label for="email" required>Email</x-strata::form.label>
        <x-strata::input
            id="email"
            type="email"
            wire:model="email"
            iconLeft="mail"
            :state="$errors->has('email') ? 'error' : 'default'"
        />
        @error('email')
            <x-strata::form.error>{{ $message }}</x-strata::form.error>
        @enderror
    </x-strata::form.field>

    <x-strata::button type="submit">Save</x-strata::button>
</form>
```

## Props Reference

### Input

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | string | `text` | HTML input type |
| `state` | string | `default` | Validation state (`default`, `success`, `error`, `warning`) |
| `size` | string | `md` | Input size (`sm`, `md`, `lg`) |
| `iconLeft` | string | `null` | Leading icon name |
| `iconRight` | string | `null` | Trailing icon name |
| `prefix` | string | `null` | Text prefix (left) |
| `suffix` | string | `null` | Text suffix (right) |
| `disabled` | boolean | `false` | Disable the input |

All other attributes (`wire:*`, `x-*`, `name`, `id`, `placeholder`, etc.) are passed to the input element.

### Form Label

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `for` | string | `null` | Input ID to associate with |
| `required` | boolean | `false` | Show required indicator (*) |

### Form Error

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `error` | string | `null` | Error message (or use slot) |

### Form Hint

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `hint` | string | `null` | Hint text (or use slot) |

### Form Field

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `spacing` | string | `default` | Spacing between elements (`tight`, `default`, `loose`) |

### Action Components

#### Clear Button

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `sm` | Button size |

#### Toggle Password

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `sm` | Button size |

#### Counter

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `max` | number | `100` | Maximum character count |

## Architecture

The input component uses a wrapper-based architecture:

```blade
<div class="wrapper-with-styling">  <!-- Outer wrapper gets border, background, focus -->
    <icon-left />                   <!-- Optional left icon -->
    <prefix />                      <!-- Optional prefix text -->
    <input />                       <!-- Input element -->
    <state-icon />                  <!-- Auto validation icon -->
    <suffix />                      <!-- Optional suffix text -->
    <icon-right />                  <!-- Optional right icon -->
    <slot />                        <!-- Optional actions -->
</div>
```

This avoids absolute positioning and complex padding calculations. The wrapper receives focus styles while the input itself has no border or background.
