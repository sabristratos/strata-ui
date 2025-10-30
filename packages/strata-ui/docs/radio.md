# Radio Buttons

Flexible radio button components with full Livewire integration, support for validation states, sizes, and multiple variants.

## Basic Usage

```blade
<x-strata::radio name="plan" value="basic" label="Basic Plan" />
<x-strata::radio name="plan" value="pro" label="Pro Plan" checked />
<x-strata::radio name="plan" value="enterprise" label="Enterprise Plan" />
```

## With Livewire

Radio buttons work seamlessly with Livewire's `wire:model` directive:

```blade
<x-strata::radio
    wire:model.live="selectedPlan"
    name="plan"
    value="basic"
    label="Basic Plan"
/>
```

## Sizes

Available sizes: `sm`, `md` (default), `lg`

```blade
<x-strata::radio size="sm" name="size" label="Small radio" />
<x-strata::radio size="md" name="size" label="Medium radio" />
<x-strata::radio size="lg" name="size" label="Large radio" />
```

## Validation States

Available states: `default`, `success`, `error`, `warning`

```blade
<x-strata::radio state="default" name="status" label="Default state" />
<x-strata::radio state="success" name="status" label="Valid option" checked />
<x-strata::radio state="error" name="status" label="Invalid option" />
<x-strata::radio state="warning" name="status" label="Warning state" />
```

## Disabled State

```blade
<x-strata::radio disabled name="disabled" label="Disabled unchecked" />
<x-strata::radio disabled checked name="disabled" label="Disabled checked" />
```

## Radio Groups

Group related radio buttons with consistent spacing and layout.

### Vertical Group (Default)

```blade
<x-strata::radio.group label="Select your plan" name="plan">
    <x-strata::radio name="plan" value="basic" label="Basic" />
    <x-strata::radio name="plan" value="pro" label="Pro" />
    <x-strata::radio name="plan" value="enterprise" label="Enterprise" />
</x-strata::radio.group>
```

### Horizontal Group

```blade
<x-strata::radio.group label="Choose an answer" orientation="horizontal" name="answer">
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

## Radios with Descriptions

```blade
<x-strata::radio
    wire:model="selectedSize"
    name="size"
    value="sm"
    label="Small"
    description="Best for compact layouts and dense information"
/>
<x-strata::radio
    wire:model="selectedSize"
    name="size"
    value="md"
    label="Medium"
    description="The default size, works well in most situations"
/>
```

## Bordered Variant

```blade
<x-strata::radio
    variant="bordered"
    name="theme"
    value="blue"
    label="Blue Theme"
    description="Classic and professional color scheme"
/>
```

## Card Variant

Create selectable cards perfect for pricing plans or feature selection:

```blade
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <x-strata::radio
        variant="card"
        wire:model="selectedPlan"
        name="plan"
        value="basic"
        label="Basic Plan"
        description="Perfect for individuals and small projects"
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
        description="For growing teams and businesses"
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

## Pill Variant

```blade
<div class="flex flex-wrap gap-2">
    <x-strata::radio
        variant="pill"
        wire:model="skill"
        name="skill"
        value="design"
        label="Design"
    />
    <x-strata::radio
        variant="pill"
        wire:model="skill"
        name="skill"
        value="development"
        label="Development"
    />
    <x-strata::radio
        variant="pill"
        wire:model="skill"
        name="skill"
        value="marketing"
        label="Marketing"
    />
</div>
```

## Props Reference

### Radio

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `default` | Visual variant: `default`, `bordered`, `card`, `pill` |
| `size` | string | `md` | Size variant: `sm`, `md`, `lg` |
| `state` | string | `default` | Validation state: `default`, `success`, `error`, `warning` |
| `disabled` | boolean | `false` | Disable the radio button |
| `checked` | boolean | `false` | Initial checked state |
| `label` | string | `null` | Label text (or use default slot) |
| `description` | string | `null` | Description text below label |
| `id` | string | `null` | Custom ID (auto-generated if not provided) |
| `name` | string | `null` | Radio button name (required for grouping) |

**Additional Attributes:**
- All standard input attributes (`value`, `wire:*`, etc.) are passed through
- Livewire directives work automatically

### Radio Group

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `orientation` | string | `vertical` | Layout direction: `vertical`, `horizontal` |
| `label` | string | `null` | Group label text |
| `error` | string | `null` | Error message to display |

## Real-World Examples

### Subscription Plan Selection

```blade
<form wire:submit="subscribe">
    <x-strata::radio.group label="Choose your subscription plan" name="plan">
        <x-strata::radio
            wire:model="selectedPlan"
            name="plan"
            value="monthly"
            label="Monthly - $19/mo"
            description="Billed monthly, cancel anytime"
        />
        <x-strata::radio
            wire:model="selectedPlan"
            name="plan"
            value="yearly"
            label="Annual - $15/mo"
            description="Billed annually, save 20%"
        />
    </x-strata::radio.group>

    <x-strata::button type="submit" class="mt-4">
        Continue to Payment
    </x-strata::button>
</form>
```

### Shipping Method Selection

```blade
<x-strata::radio.group label="Shipping method" name="shipping">
    <x-strata::radio
        variant="bordered"
        wire:model="shippingMethod"
        name="shipping"
        value="standard"
        label="Standard Shipping"
        description="5-7 business days - Free"
        checked
    />
    <x-strata::radio
        variant="bordered"
        wire:model="shippingMethod"
        name="shipping"
        value="express"
        label="Express Shipping"
        description="2-3 business days - $15"
    />
    <x-strata::radio
        variant="bordered"
        wire:model="shippingMethod"
        name="shipping"
        value="overnight"
        label="Overnight Shipping"
        description="Next business day - $30"
    />
</x-strata::radio.group>
```

### Payment Method Selection

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

    <x-strata::radio
        variant="bordered"
        wire:model="paymentMethod"
        name="payment"
        value="bank"
    >
        <div class="flex items-center gap-2">
            <x-strata::icon.building class="size-5" />
            <span class="font-medium">Bank Transfer</span>
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

## Accessibility

Radio buttons are fully accessible:
- Proper label associations using `for` and `id`
- Keyboard navigation support (Arrow keys to navigate, Space to select)
- Screen reader support
- Disabled state properly communicated
- Focus indicators for keyboard navigation
