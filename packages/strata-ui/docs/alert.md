# Alerts

Clean, modern alert components for displaying important messages with semantic colors and optional dismiss functionality.

## Basic Usage

```blade
<x-strata::alert variant="info" title="New feature available">
    Check out our latest update that includes improved performance and new integrations.
</x-strata::alert>
```

## Variants

Available variants: `neutral`, `info`, `success`, `warning`, `error`

```blade
<x-strata::alert variant="neutral" title="General information">
    This is a neutral alert for general information that doesn't fit other categories.
</x-strata::alert>

<x-strata::alert variant="info" title="New feature available">
    Check out our latest update that includes improved performance.
</x-strata::alert>

<x-strata::alert variant="success" title="Changes saved successfully">
    Your profile has been updated with the new information.
</x-strata::alert>

<x-strata::alert variant="warning" title="Action required">
    Your subscription will expire in 3 days.
</x-strata::alert>

<x-strata::alert variant="error" title="Unable to process request">
    There was an error processing your payment.
</x-strata::alert>
```

## Styles

Available styles: `subtle` (default), `bordered`, `filled`

### Subtle Style (Default)

```blade
<x-strata::alert variant="success" title="Changes saved">
    Your settings have been updated successfully.
</x-strata::alert>
```

### Bordered Style

```blade
<x-strata::alert variant="info" style="bordered" title="System update">
    Maintenance scheduled for Saturday from 2AM to 4AM EST.
</x-strata::alert>
```

### Filled Style

```blade
<x-strata::alert variant="error" style="filled" title="Critical error">
    Database connection failed. Please check your configuration.
</x-strata::alert>
```

## Without Title

Alerts can be used without a title for simpler messages:

```blade
<x-strata::alert variant="success">
    Welcome! Your account has been successfully created.
</x-strata::alert>
```

## Dismissible Alerts

Add dismiss functionality with fade-out animation:

```blade
<x-strata::alert variant="info" dismissible title="Cookie preferences">
    We use cookies to enhance your browsing experience.
</x-strata::alert>
```

## Custom Icons

Override the default icon with any icon from the Lucide set:

```blade
<x-strata::alert variant="info" icon="zap" title="Performance tip">
    Enable caching to significantly improve your application's response time.
</x-strata::alert>

<x-strata::alert variant="success" icon="star" title="Congratulations!">
    You've earned a new achievement badge.
</x-strata::alert>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `info` | Semantic variant: `neutral`, `info`, `success`, `warning`, `error` |
| `style` | string | `subtle` | Visual style: `subtle`, `bordered`, `filled` |
| `title` | string | `null` | Optional alert title |
| `icon` | string | `null` | Custom icon name (auto-selected based on variant if not provided) |
| `dismissible` | boolean | `false` | Show dismiss button with fade-out animation |

### Default Icons

Each variant has a default icon that's automatically selected:

- `neutral`: circle-help
- `info`: info
- `success`: check-circle
- `warning`: alert-triangle
- `error`: x-circle

## Real-World Examples

### Form Validation Feedback

```blade
@if($errors->any())
    <x-strata::alert variant="error" title="Please fix the following errors">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-strata::alert>
@endif
```

### Success Messages

```blade
@if(session('success'))
    <x-strata::alert variant="success" dismissible>
        {{ session('success') }}
    </x-strata::alert>
@endif
```

### System Notifications

```blade
<x-strata::alert variant="info" style="bordered" title="Scheduled Maintenance">
    Our system will undergo scheduled maintenance on Saturday, March 15th from 2:00 AM to 4:00 AM EST. During this time, some services may be temporarily unavailable.
</x-strata::alert>
```

### Warning Banner

```blade
<x-strata::alert variant="warning" title="Trial ending soon">
    Your free trial will end in 3 days. Upgrade now to continue using all premium features without interruption.
    <div class="mt-3">
        <x-strata::button variant="primary" size="sm">
            Upgrade Now
        </x-strata::button>
    </div>
</x-strata::alert>
```

### Error with Action

```blade
<x-strata::alert variant="error" title="Payment failed" dismissible>
    We were unable to process your payment. Please check your card details and try again.
    <div class="mt-3 flex gap-2">
        <x-strata::button variant="primary" size="sm" wire:click="retryPayment">
            Retry Payment
        </x-strata::button>
        <x-strata::button variant="secondary" size="sm" wire:click="updatePaymentMethod">
            Update Payment Method
        </x-strata::button>
    </div>
</x-strata::alert>
```

### Informational Tips

```blade
<x-strata::alert variant="neutral" icon="lightbulb" style="bordered">
    <strong>Tip:</strong> You can use keyboard shortcuts to navigate faster. Press <kbd>?</kbd> to view all available shortcuts.
</x-strata::alert>
```

### Feature Announcement

```blade
<x-strata::alert variant="success" icon="sparkles" style="filled" title="New Feature Released!">
    We're excited to announce our new collaboration features. Now you can invite team members and work together in real-time.
    <x-strata::button variant="secondary" size="sm" class="mt-3">
        Learn More
    </x-strata::button>
</x-strata::alert>
```

### Security Notice

```blade
<x-strata::alert variant="warning" icon="shield-alert" title="Security Notice">
    We detected a login from a new device. If this wasn't you, please secure your account immediately.
    <div class="mt-3">
        <x-strata::button variant="warning" size="sm">
            Secure My Account
        </x-strata::button>
    </div>
</x-strata::alert>
```

### Multi-Alert Stack

```blade
<div class="space-y-3">
    <x-strata::alert variant="success" dismissible>
        Profile updated successfully.
    </x-strata::alert>

    <x-strata::alert variant="info" dismissible>
        Remember to verify your new email address.
    </x-strata::alert>

    <x-strata::alert variant="warning">
        Your password will expire in 7 days.
    </x-strata::alert>
</div>
```

## Accessibility

Alerts are fully accessible:
- Proper `role="alert"` attribute for screen readers
- Semantic color contrast ratios for readability
- Keyboard accessible dismiss button
- Focus management for interactive elements
- Clear visual hierarchy with icons and titles
