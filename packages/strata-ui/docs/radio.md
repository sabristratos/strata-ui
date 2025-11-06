# Radio

Flexible radio button components with multiple variants, validation states, and seamless Livewire integration. Perfect for single-choice selections, plan pickers, and surveys.

## Radio Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `variant` | string | `default` | `default`, `bordered`, `card`, `pill` | Visual style |
| `size` | string | `md` | `sm`, `md`, `lg` | Radio button size |
| `state` | string | `default` | `default`, `success`, `error`, `warning` | Validation state (affects border color) |
| `name` | string | - | - | Radio group name (required) |
| `value` | string | - | - | Radio button value |
| `label` | string | `null` | - | Label text |
| `description` | string | `null` | - | Description text below label |
| `checked` | boolean | `false` | `true`, `false` | Initial checked state |
| `disabled` | boolean | `false` | `true`, `false` | Disable radio button |
| `id` | string | `null` | - | Custom ID (auto-generated if omitted) |

## Radio Group Props

Use `<x-strata::radio.group>` to group related radio buttons.

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `orientation` | string | `vertical` | `vertical`, `horizontal` | Layout direction |
| `label` | string | `null` | - | Group label |
| `error` | string | `null` | - | Error message |
| `name` | string | - | - | Shared name for all radios in group |

## Example

```blade
{{-- Radio with multiple props --}}
<x-strata::radio
    name="plan"
    value="pro"
    label="Pro Plan"
    description="For growing teams and businesses"
    state="success"
    size="lg"
    checked
/>

{{-- Radio group with multiple options --}}
<x-strata::radio.group label="Select your plan" name="plan">
    <x-strata::radio name="plan" value="basic" label="Basic" />
    <x-strata::radio name="plan" value="pro" label="Pro" checked />
    <x-strata::radio name="plan" value="enterprise" label="Enterprise" />
</x-strata::radio.group>
```

## Livewire Integration

Radio buttons work seamlessly with `wire:model`:

```blade
<x-strata::radio.group label="Choose your subscription" name="plan">
    <x-strata::radio
        wire:model.live="selectedPlan"
        name="plan"
        value="monthly"
        label="Monthly - $19/mo"
        description="Billed monthly, cancel anytime"
    />
    <x-strata::radio
        wire:model.live="selectedPlan"
        name="plan"
        value="yearly"
        label="Annual - $15/mo"
        description="Billed annually, save 20%"
    />
</x-strata::radio.group>

{{-- Display selected plan --}}
<p>Selected: {{ $selectedPlan }}</p>
```

## Variants

### Default

Standard radio buttons with labels and descriptions:

```blade
<x-strata::radio
    name="theme"
    value="light"
    label="Light Mode"
    description="Classic bright interface"
/>
```

### Bordered

Radio buttons with border and padding, ideal for shipping/payment options:

```blade
<x-strata::radio
    variant="bordered"
    name="shipping"
    value="express"
    label="Express Shipping"
    description="2-3 business days - $15"
/>
```

### Card

Large selectable cards perfect for pricing plans or feature selection:

```blade
<div class="grid grid-cols-3 gap-4">
    <x-strata::radio
        variant="card"
        wire:model="selectedPlan"
        name="plan"
        value="basic"
        label="Basic Plan"
        description="Perfect for individuals"
    >
        <div class="mt-4">
            <p class="text-2xl font-bold">$9/month</p>
            <ul class="mt-2 space-y-1 text-sm">
                <li>✓ 10 projects</li>
                <li>✓ 5GB storage</li>
            </ul>
        </div>
    </x-strata::radio>

    <x-strata::radio
        variant="card"
        wire:model="selectedPlan"
        name="plan"
        value="pro"
        label="Pro Plan"
        description="For growing teams"
    >
        <div class="mt-4">
            <p class="text-2xl font-bold">$29/month</p>
            <ul class="mt-2 space-y-1 text-sm">
                <li>✓ Unlimited projects</li>
                <li>✓ 100GB storage</li>
            </ul>
        </div>
    </x-strata::radio>
</div>
```

### Pill

Compact pill-shaped radio buttons for tags or categories:

```blade
<div class="flex flex-wrap gap-2">
    <x-strata::radio variant="pill" name="skill" value="design" label="Design" />
    <x-strata::radio variant="pill" name="skill" value="development" label="Development" />
    <x-strata::radio variant="pill" name="skill" value="marketing" label="Marketing" />
</div>
```

## Validation States

All variants support validation states with colored borders:

```blade
{{-- Default variant with states --}}
<x-strata::radio state="default" name="status" value="d" label="Default" />
<x-strata::radio state="success" name="status" value="s" label="Success" checked />
<x-strata::radio state="error" name="status" value="e" label="Error" />
<x-strata::radio state="warning" name="status" value="w" label="Warning" />

{{-- Bordered variant with error state --}}
<x-strata::radio
    variant="bordered"
    state="error"
    name="payment"
    value="card"
    label="Credit Card"
    description="Card verification failed"
/>

{{-- Card variant with success state --}}
<x-strata::radio
    variant="card"
    state="success"
    name="plan"
    value="verified"
    label="Verified Plan"
/>
```

**State colors apply to:**
- Inner radio circle border
- Outer wrapper border (bordered/card variants only)
- Hover effects

## Radio Groups

### Vertical Group (Default)

```blade
<x-strata::radio.group label="Shipping method" name="shipping">
    <x-strata::radio
        name="shipping"
        value="standard"
        label="Standard Shipping"
        description="5-7 business days - Free"
    />
    <x-strata::radio
        name="shipping"
        value="express"
        label="Express Shipping"
        description="2-3 business days - $15"
    />
</x-strata::radio.group>
```

### Horizontal Group

```blade
<x-strata::radio.group label="Answer" orientation="horizontal" name="answer">
    <x-strata::radio name="answer" value="yes" label="Yes" />
    <x-strata::radio name="answer" value="no" label="No" />
    <x-strata::radio name="answer" value="maybe" label="Maybe" />
</x-strata::radio.group>
```

### Group with Error

```blade
<x-strata::radio.group
    label="Required selection"
    error="Please select an option"
    name="required"
>
    <x-strata::radio name="required" value="option1" label="Option 1" />
    <x-strata::radio name="required" value="option2" label="Option 2" />
</x-strata::radio.group>
```

## Real-World Examples

### Payment Method Selector

```blade
<x-strata::radio.group label="Payment method" name="payment">
    <x-strata::radio
        variant="bordered"
        wire:model="paymentMethod"
        name="payment"
        value="card"
    >
        <div class="flex items-center gap-2">
            <x-strata::icon.credit-card class="size-5" />
            <span class="font-medium">Credit Card</span>
        </div>
    </x-strata::radio>

    <x-strata::radio
        variant="bordered"
        wire:model="paymentMethod"
        name="payment"
        value="paypal"
    >
        <div class="flex items-center gap-2">
            <x-strata::icon.wallet class="size-5" />
            <span class="font-medium">PayPal</span>
        </div>
    </x-strata::radio>
</x-strata::radio.group>
```

### Survey Question

```blade
<x-strata::radio.group
    label="How satisfied are you with our service?"
    name="satisfaction"
    :error="$errors->first('satisfaction')"
>
    <x-strata::radio
        wire:model="satisfaction"
        name="satisfaction"
        value="very-satisfied"
        label="Very Satisfied"
        state="success"
    />
    <x-strata::radio
        wire:model="satisfaction"
        name="satisfaction"
        value="satisfied"
        label="Satisfied"
    />
    <x-strata::radio
        wire:model="satisfaction"
        name="satisfaction"
        value="neutral"
        label="Neutral"
    />
    <x-strata::radio
        wire:model="satisfaction"
        name="satisfaction"
        value="unsatisfied"
        label="Unsatisfied"
        state="warning"
    />
    <x-strata::radio
        wire:model="satisfaction"
        name="satisfaction"
        value="very-unsatisfied"
        label="Very Unsatisfied"
        state="error"
    />
</x-strata::radio.group>
```

## Notes

- **Name attribute required:** All radios in a group must share the same `name` attribute
- **Validation states:** Success/error/warning states change border colors for both inner circle and outer wrapper (bordered/card variants)
- **Pixel-perfect centering:** Inner dot uses precise pixel values for perfect alignment
- **Focus states:** All variants have visible focus rings for keyboard navigation
- **Accessibility:** Proper label associations, keyboard support (arrow keys + space), and screen reader support
- **Disabled state:** Hover effects are automatically removed when disabled
