# Select Component

A flexible, accessible select component with single and multiselect modes, keyboard navigation, and extensive customization options.

## Installation

The select component is included in Strata UI. No additional installation required.

## Basic Usage

### Single Select

```blade
<x-strata::select wire:model="selectedCountry" placeholder="Select a country">
    <x-strata::select.option value="us">United States</x-strata::select.option>
    <x-strata::select.option value="ca">Canada</x-strata::select.option>
    <x-strata::select.option value="mx">Mexico</x-strata::select.option>
</x-strata::select>
```

### Multiselect

```blade
<x-strata::select
    multiple
    wire:model="selectedColors"
    placeholder="Select colors"
>
    <x-strata::select.option value="red">Red</x-strata::select.option>
    <x-strata::select.option value="blue">Blue</x-strata::select.option>
    <x-strata::select.option value="green">Green</x-strata::select.option>
</x-strata::select>
```

## Props Reference

### Select Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `multiple` | boolean | `false` | Enable multiselect mode |
| `size` | string | `'md'` | Size variant: `sm`, `md`, `lg` |
| `state` | string | `'default'` | Validation state: `default`, `success`, `error`, `warning` |
| `placeholder` | string | `'Select an option'` | Placeholder text when nothing selected |
| `disabled` | boolean | `false` | Disable the select |
| `name` | string | `null` | Name attribute for form submission |
| `value` | string\|array | `null` | Initial value (string for single, array for multiple) |
| `chips` | string | `'inline'` | Multiselect chip display: `inline`, `below`, `summary` |

### Select Option Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | required | Value of the option |
| `disabled` | boolean | `false` | Disable the option |

### Select Chip Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | string | `''` | Label text (bound with Alpine) |
| `size` | string | `'md'` | Size variant matching parent select |

## Sizes

Three size options available:

```blade
<x-strata::select size="sm" placeholder="Small select">
    <x-strata::select.option value="1">Option 1</x-strata::select.option>
</x-strata::select>

<x-strata::select size="md" placeholder="Medium select (default)">
    <x-strata::select.option value="1">Option 1</x-strata::select.option>
</x-strata::select>

<x-strata::select size="lg" placeholder="Large select">
    <x-strata::select.option value="1">Option 1</x-strata::select.option>
</x-strata::select>
```

## Validation States

Four validation states with visual feedback:

```blade
<x-strata::select state="default" placeholder="Default">
    <x-strata::select.option value="1">Option</x-strata::select.option>
</x-strata::select>

<x-strata::select state="success" placeholder="Valid selection">
    <x-strata::select.option value="1">Option</x-strata::select.option>
</x-strata::select>

<x-strata::select state="error" placeholder="Invalid selection">
    <x-strata::select.option value="1">Option</x-strata::select.option>
</x-strata::select>

<x-strata::select state="warning" placeholder="Caution required">
    <x-strata::select.option value="1">Option</x-strata::select.option>
</x-strata::select>
```

## Multiselect Chip Display Modes

### Inline Chips

Selected items appear as chips inside the trigger:

```blade
<x-strata::select
    multiple
    chips="inline"
    wire:model="selected"
    placeholder="Select items"
>
    <x-strata::select.option value="1">Item 1</x-strata::select.option>
    <x-strata::select.option value="2">Item 2</x-strata::select.option>
</x-strata::select>
```

### Below Chips

Selected items appear as chips below the select:

```blade
<x-strata::select
    multiple
    chips="below"
    wire:model="selected"
    placeholder="Select items"
>
    <x-strata::select.option value="1">Item 1</x-strata::select.option>
    <x-strata::select.option value="2">Item 2</x-strata::select.option>
</x-strata::select>
```

### Summary Mode

Shows a count instead of individual chips:

```blade
<x-strata::select
    multiple
    chips="summary"
    wire:model="selected"
    placeholder="Select items"
>
    <x-strata::select.option value="1">Item 1</x-strata::select.option>
    <x-strata::select.option value="2">Item 2</x-strata::select.option>
</x-strata::select>
```

Displays: "2 selected"

## Option Customization

### Simple Text Options

```blade
<x-strata::select.option value="1">
    Simple text option
</x-strata::select.option>
```

### Options with Icons

Use the `icon` slot for adding icons:

```blade
<x-strata::select.option value="laravel">
    <x-slot:icon>
        <x-strata::icon.code class="w-5 h-5 text-primary" />
    </x-slot:icon>
    Laravel
</x-strata::select.option>
```

### Options with Label and Description

Use named slots for structured content:

```blade
<x-strata::select.option value="laravel">
    <x-slot:icon>
        <div class="w-6 h-6 bg-red-500 rounded"></div>
    </x-slot:icon>
    <x-slot:label>Laravel</x-slot:label>
    <x-slot:description>
        The PHP framework for web artisans
    </x-slot:description>
</x-strata::select.option>
```

### Fully Custom Options

Use the default slot for completely custom layouts:

```blade
<x-strata::select.option value="user-1">
    <div class="flex items-center gap-3">
        <img src="/avatar.jpg" class="w-8 h-8 rounded-full">
        <div>
            <div class="font-semibold">John Doe</div>
            <div class="text-sm text-muted-foreground">john@example.com</div>
        </div>
    </div>
</x-strata::select.option>
```

## Disabled States

### Disabled Select

```blade
<x-strata::select disabled placeholder="Cannot select">
    <x-strata::select.option value="1">Option 1</x-strata::select.option>
</x-strata::select>
```

### Disabled Options

```blade
<x-strata::select placeholder="Select an option">
    <x-strata::select.option value="1">Available Option</x-strata::select.option>
    <x-strata::select.option value="2" disabled>
        Disabled Option
    </x-strata::select.option>
</x-strata::select>
```

## Livewire Integration

### Single Select Binding

```php
// Component
public ?string $selectedCountry = null;
```

```blade
<x-strata::select wire:model.live="selectedCountry">
    <x-strata::select.option value="us">United States</x-strata::select.option>
    <x-strata::select.option value="ca">Canada</x-strata::select.option>
</x-strata::select>
```

### Multiselect Binding

```php
// Component
public array $selectedColors = [];
```

```blade
<x-strata::select multiple wire:model.live="selectedColors">
    <x-strata::select.option value="red">Red</x-strata::select.option>
    <x-strata::select.option value="blue">Blue</x-strata::select.option>
</x-strata::select>
```

### Deferred Updates

Use `wire:model` without `.live` for updates on form submission:

```blade
<x-strata::select wire:model="country">
    <!-- options -->
</x-strata::select>

<x-strata::button wire:click="submit">Submit</x-strata::button>
```

## Form Submission

The component includes a hidden native `<select>` element that syncs with the Alpine state, ensuring compatibility with traditional form submissions and server-side processing.

```blade
<form wire:submit="handleSubmit">
    <x-strata::select name="country" wire:model="selectedCountry">
        <x-strata::select.option value="us">United States</x-strata::select.option>
        <x-strata::select.option value="ca">Canada</x-strata::select.option>
    </x-strata::select>

    <x-strata::button type="submit">Submit</x-strata::button>
</form>
```

## Keyboard Navigation

Full keyboard accessibility built-in:

- **Arrow Down** - Open dropdown or move to next option
- **Arrow Up** - Open dropdown or move to previous option
- **Enter/Space** - Select highlighted option
- **Escape** - Close dropdown
- **Tab** - Navigate away and close dropdown

## Accessibility

The select component is built with accessibility in mind:

- Semantic HTML with proper ARIA attributes
- Full keyboard navigation support
- Focus management and visual indicators
- Screen reader friendly
- Native `<select>` fallback for progressive enhancement
- Disabled state properly communicated

## Dynamic Options

Generate options from arrays:

```php
// Component
public array $countries = [
    'us' => 'United States',
    'ca' => 'Canada',
    'mx' => 'Mexico',
];
```

```blade
<x-strata::select wire:model="selectedCountry">
    @foreach($countries as $value => $label)
        <x-strata::select.option :value="$value">
            {{ $label }}
        </x-strata::select.option>
    @endforeach
</x-strata::select>
```

## Real-World Examples

### User Selection with Avatars

```blade
<x-strata::select placeholder="Assign to user">
    @foreach($users as $user)
        <x-strata::select.option :value="$user->id">
            <div class="flex items-center gap-3">
                <img
                    src="{{ $user->avatar }}"
                    class="w-8 h-8 rounded-full"
                    alt="{{ $user->name }}"
                >
                <div>
                    <div class="font-medium">{{ $user->name }}</div>
                    <div class="text-sm text-muted-foreground">
                        {{ $user->email }}
                    </div>
                </div>
            </div>
        </x-strata::select.option>
    @endforeach
</x-strata::select>
```

### Status Selection with Icons

```blade
<x-strata::select wire:model="status">
    <x-strata::select.option value="active">
        <x-slot:icon>
            <x-strata::icon.check-circle class="w-5 h-5 text-success" />
        </x-slot:icon>
        <x-slot:label>Active</x-slot:label>
        <x-slot:description>User account is active</x-slot:description>
    </x-strata::select.option>

    <x-strata::select.option value="pending">
        <x-slot:icon>
            <x-strata::icon.clock class="w-5 h-5 text-warning" />
        </x-slot:icon>
        <x-slot:label>Pending</x-slot:label>
        <x-slot:description>Awaiting verification</x-slot:description>
    </x-strata::select.option>

    <x-strata::select.option value="inactive">
        <x-slot:icon>
            <x-strata::icon.x-circle class="w-5 h-5 text-destructive" />
        </x-slot:icon>
        <x-slot:label>Inactive</x-slot:label>
        <x-slot:description>Account disabled</x-slot:description>
    </x-strata::select.option>
</x-strata::select>
```

### Tag Selection

```blade
<x-strata::select
    multiple
    chips="below"
    wire:model="tags"
    placeholder="Add tags"
>
    @foreach($availableTags as $tag)
        <x-strata::select.option :value="$tag->id">
            <x-slot:icon>
                <span
                    class="w-3 h-3 rounded-full"
                    style="background-color: {{ $tag->color }}"
                ></span>
            </x-slot:icon>
            {{ $tag->name }}
        </x-strata::select.option>
    @endforeach
</x-strata::select>
```

## Technical Notes

### Popover Integration

The select component uses Strata UI's popover component for dropdown positioning, ensuring proper placement and overflow handling across different viewport sizes.

### Alpine.js State

The component uses Alpine.js for state management with the following reactive properties:

- `open` - Dropdown open/closed state
- `selected` - Current selection (string or array)
- `highlighted` - Index of highlighted option for keyboard navigation
- `options` - Collected option data from DOM

### Native Select Fallback

A hidden native `<select>` element is included for:
- Progressive enhancement (works without JavaScript)
- Form submission compatibility
- Better screen reader support in some cases
- Server-side validation

## Browser Support

Works in all modern browsers with support for:
- CSS anchor positioning
- Popover API
- Alpine.js
- Modern CSS features

Gracefully degrades to native `<select>` when JavaScript is unavailable.
