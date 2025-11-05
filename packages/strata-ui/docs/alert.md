# Alert

Clean, modern alert components for displaying important messages with semantic colors and optional dismiss functionality.

## Props Reference

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `variant` | string | `info` | `neutral`, `info`, `success`, `warning`, `error` | Semantic color variant |
| `style` | string | `subtle` | `subtle`, `bordered`, `filled` | Visual style |
| `title` | string | `null` | Any text | Optional alert title |
| `icon` | string | `null` | Icon name | Custom icon (auto-selected based on variant if not provided) |
| `dismissible` | boolean | `false` | `true`, `false` | Show dismiss button with fade-out animation |

## Default Icons

Each variant has a default icon that's automatically selected when no custom icon is provided:

- `neutral`: circle-help
- `info`: info
- `success`: check-circle
- `warning`: alert-triangle
- `error`: x-circle

## Variants

All 5 semantic color variants with automatic icon selection:

```blade
<x-strata::alert variant="neutral" title="General information">
    This is a neutral alert for general information that doesn't fit other categories.
</x-strata::alert>

<x-strata::alert variant="info" title="New feature available">
    Check out our latest update that includes improved performance and new integrations.
</x-strata::alert>

<x-strata::alert variant="success" title="Changes saved successfully">
    Your profile has been updated with the new information.
</x-strata::alert>

<x-strata::alert variant="warning" title="Action required">
    Your subscription will expire in 3 days. Please renew to continue using all features.
</x-strata::alert>

<x-strata::alert variant="error" title="Unable to process request">
    There was an error processing your payment. Please check your payment method and try again.
</x-strata::alert>
```

## Styles

Three visual styles available for different emphasis levels:

### Subtle Style (Default)

Light background with subtle border - ideal for inline notifications:

```blade
<x-strata::alert variant="success" style="subtle" title="Changes saved">
    Your settings have been updated successfully.
</x-strata::alert>
```

### Bordered Style

Transparent background with prominent border - clean and minimal:

```blade
<x-strata::alert variant="info" style="bordered" title="System update">
    Maintenance scheduled for Saturday from 2AM to 4AM EST.
</x-strata::alert>
```

### Filled Style

Solid background color - maximum emphasis and visibility:

```blade
<x-strata::alert variant="error" style="filled" title="Critical error">
    Database connection failed. Please check your configuration.
</x-strata::alert>
```

## Without Title

Alerts can be used without a title for simpler messages:

```blade
<x-strata::alert variant="neutral">
    This is a simple neutral alert without a title.
</x-strata::alert>

<x-strata::alert variant="success">
    Welcome! Your account has been successfully created and is ready to use.
</x-strata::alert>

<x-strata::alert variant="warning">
    Please verify your email address to unlock all features.
</x-strata::alert>
```

## Dismissible Alerts

Add dismiss functionality with smooth fade-out animation:

```blade
<x-strata::alert variant="info" dismissible title="Cookie preferences">
    We use cookies to enhance your browsing experience. Click dismiss to acknowledge.
</x-strata::alert>

<x-strata::alert variant="success" dismissible>
    Profile updated successfully. This notification will auto-hide or you can dismiss it manually.
</x-strata::alert>

<x-strata::alert variant="warning" dismissible title="Trial ending soon">
    Your free trial will end in 3 days. Upgrade now to continue using premium features.
</x-strata::alert>
```

## Custom Icons

Override the default icon with any icon from the Lucide set:

```blade
<x-strata::alert variant="neutral" icon="lightbulb" title="Pro Tip">
    Use keyboard shortcuts to navigate faster. Press ? to view all available shortcuts.
</x-strata::alert>

<x-strata::alert variant="info" icon="zap" title="Performance tip">
    Enable caching to significantly improve your application's response time.
</x-strata::alert>

<x-strata::alert variant="success" icon="star" title="Congratulations!">
    You've earned a new achievement badge for completing 100 tasks.
</x-strata::alert>

<x-strata::alert variant="warning" icon="shield-alert" title="Security Notice">
    We detected a login from a new device. If this wasn't you, please secure your account.
</x-strata::alert>

<x-strata::alert variant="error" icon="wifi-off" title="Network Error">
    Unable to reach the server. Please check your internet connection and try again.
</x-strata::alert>
```

## Real-World Examples

### Form Validation Feedback

```blade
@if($errors->any())
    <x-strata::alert variant="error" title="Please fix the following errors">
        <ul class="list-disc list-inside space-y-1">
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

### Error with Multiple Actions

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
    We detected a login from a new device in New York, USA. If this wasn't you, please secure your account immediately.
    <div class="mt-3">
        <x-strata::button variant="warning" size="sm">
            Secure My Account
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

### Multi-Alert Stack

```blade
<div class="space-y-3">
    <x-strata::alert variant="success" dismissible>
        Profile updated successfully.
    </x-strata::alert>

    <x-strata::alert variant="info" dismissible>
        Remember to verify your new email address within 24 hours.
    </x-strata::alert>

    <x-strata::alert variant="warning">
        Your password will expire in 7 days. Consider updating it now.
    </x-strata::alert>
</div>
```

## Notes

- **5 Semantic Variants:** `neutral`, `info`, `success`, `warning`, `error` - each with automatic icon selection
- **3 Visual Styles:** `subtle` (light background, default), `bordered` (transparent with border), `filled` (solid background)
- **Automatic Icons:** Each variant has a sensible default icon that's auto-selected
- **Custom Icons:** Override defaults with any icon from the 1,648+ Lucide icon set
- **Dismissible:** Add `dismissible` prop for smooth fade-out animation on close
- **Flexible Content:** Supports plain text, HTML, lists, buttons, and complex layouts
- **Accessibility:** Proper `role="alert"` attribute, WCAG AA color contrast, keyboard accessible dismiss button
