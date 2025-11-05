# Checkboxes

Flexible checkbox components with full Livewire integration, multiple visual variants, validation states, and indeterminate state support for "Select All" functionality.

## Checkbox Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `variant` | string | `default` | `default`, `bordered`, `card`, `pill` | Visual style |
| `size` | string | `md` | `sm`, `md`, `lg` | Checkbox size |
| `state` | string | `default` | `default`, `success`, `error`, `warning` | Validation state with border colors |
| `label` | string | `null` | - | Label text (or use default slot) |
| `description` | string | `null` | - | Helper text below label (not supported in `pill` variant) |
| `name` | string | `null` | - | Input name attribute for form submission |
| `checked` | boolean | `false` | `true`, `false` | Initial checked state |
| `indeterminate` | boolean | `false` | `true`, `false` | Show dash icon (not visually supported in `pill` variant) |
| `disabled` | boolean | `false` | `true`, `false` | Disable checkbox |
| `id` | string | `null` | - | Custom ID (auto-generated if not provided) |

**Additional Attributes:**
- All standard input attributes (`value`, `wire:*`, etc.) are passed through
- Livewire directives work automatically

## Checkbox Group Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `orientation` | string | `vertical` | `vertical`, `horizontal` | Layout direction |
| `label` | string | `null` | - | Group label text |
| `error` | string | `null` | - | Error message to display |

## Example

```blade
{{-- Checkbox with multiple props --}}
<x-strata::checkbox
    variant="bordered"
    size="lg"
    state="success"
    label="Enable Two-Factor Authentication"
    description="Add an extra layer of security to your account"
    name="features[]"
    value="2fa"
    :checked="in_array('2fa', $selectedFeatures)"
    wire:model.live="selectedFeatures"
/>

{{-- Indeterminate checkbox for "Select All" --}}
<x-strata::checkbox
    :indeterminate="count($selected) > 0 && count($selected) < count($total)"
    :checked="count($selected) === count($total)"
    label="Select All"
    wire:model.live="selectAll"
/>

{{-- Pill variant for tag-style selections --}}
<x-strata::checkbox
    variant="pill"
    size="sm"
    label="JavaScript"
    name="skills[]"
    value="javascript"
    checked
/>

{{-- Card variant for important selections --}}
<x-strata::checkbox
    variant="card"
    label="Pro Plan"
    description="For growing businesses. Unlimited projects, 100GB storage, priority support."
    name="plan"
    value="pro"
    state="success"
    checked
/>
```

## Livewire Integration

Checkboxes work seamlessly with Livewire's `wire:model` directive:

```blade
{{-- Single checkbox --}}
<x-strata::checkbox
    wire:model.live="agreedToTerms"
    label="I agree to the terms and conditions"
/>

{{-- Multiple selection --}}
@foreach($options as $option)
    <x-strata::checkbox
        wire:model="selectedOptions"
        value="{{ $option->id }}"
        :label="$option->name"
    />
@endforeach
```

## Checkbox Groups

Group related checkboxes with consistent spacing and layout:

```blade
{{-- Vertical group (default) --}}
<x-strata::checkbox.group label="Notification Preferences">
    <x-strata::checkbox label="Email notifications" checked />
    <x-strata::checkbox label="SMS notifications" />
    <x-strata::checkbox label="Push notifications" />
</x-strata::checkbox.group>

{{-- Horizontal group --}}
<x-strata::checkbox.group label="Choose an answer" orientation="horizontal">
    <x-strata::checkbox label="Yes" />
    <x-strata::checkbox label="No" />
    <x-strata::checkbox label="Maybe" />
</x-strata::checkbox.group>

{{-- Group with error --}}
<x-strata::checkbox.group
    label="Required selection"
    error="Please select at least one option"
>
    <x-strata::checkbox label="Option 1" state="error" />
    <x-strata::checkbox label="Option 2" state="error" />
    <x-strata::checkbox label="Option 3" state="error" />
</x-strata::checkbox.group>
```

## Variants

### Default
Standard checkbox with optional label and description.

```blade
<x-strata::checkbox label="Default checkbox" />
<x-strata::checkbox label="With description" description="Additional helper text" />
```

### Bordered
Checkbox inside a bordered container, perfect for forms.

```blade
<x-strata::checkbox
    variant="bordered"
    label="Enable notifications"
    description="Get notified about important updates"
/>
```

### Card
Large card-style checkbox with checkbox indicator in top-right corner.

```blade
<x-strata::checkbox
    variant="card"
    label="Enterprise Plan"
    description="Advanced features for large organizations. Custom storage, dedicated support."
/>
```

### Pill
Tag/chip style checkbox for compact selections. Does not support `description` prop or visual indeterminate indicator.

```blade
<x-strata::checkbox variant="pill" label="JavaScript" />
<x-strata::checkbox variant="pill" label="TypeScript" checked />
```

## Indeterminate State

Perfect for "Select All" functionality where some but not all child items are selected:

```blade
{{-- Parent checkbox --}}
<x-strata::checkbox
    wire:model.live="selectAll"
    :indeterminate="count($selectedOptions) > 0 && count($selectedOptions) < count($allOptions)"
    :checked="count($selectedOptions) === count($allOptions)"
    label="Select All Frameworks"
/>

{{-- Child checkboxes --}}
<div class="ml-6 space-y-2">
    @foreach($allOptions as $key => $name)
        <x-strata::checkbox
            wire:model.live="selectedOptions"
            value="{{ $key }}"
            :label="$name"
        />
    @endforeach
</div>
```

## Custom Labels

Use the default slot for rich label content:

```blade
<x-strata::checkbox>
    <span class="font-semibold">Accept Terms and Conditions</span>
    <span class="text-sm text-muted-foreground block mt-1">
        By checking this box, you agree to our
        <a href="/terms" class="text-primary hover:underline">terms of service</a>
        and <a href="/privacy" class="text-primary hover:underline">privacy policy</a>
    </span>
</x-strata::checkbox>
```

## Notes

- **Variants:** `default` for standard use, `bordered` for forms, `card` for important selections, `pill` for compact tags
- **Indeterminate state:** Shows dash icon instead of checkmark, perfect for "Select All" patterns
- **Validation states:** Apply border colors (`success`, `error`, `warning`) for visual feedback
- **Pill limitations:** No description support, no visual indeterminate indicator
- **Accessibility:** Proper label associations, keyboard navigation, screen reader support
- **Form arrays:** Use `name="items[]"` for multiple checkbox selections
