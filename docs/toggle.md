# Toggle

A flexible toggle switch component with smooth animations, multiple size and rounded variants, validation states, and full Livewire integration.

## Features

- Switch-style toggle with animated thumb
- Three size variants (sm, md, lg)
- Nine rounded variants (none, sm, base, md, lg, xl, 2xl, 3xl, full)
- Four validation states (default, success, error, warning)
- Label and description support
- Disabled state with proper styling
- Dark mode support
- Smooth animations and transitions
- Full Livewire wire:model integration
- Keyboard accessible

## Basic Usage

### Simple Toggle

```blade
<x-strata::toggle
    wire:model.live="enabled"
    label="Enable feature"
/>
```

### Toggle with Description

```blade
<x-strata::toggle
    wire:model.live="notifications"
    label="Email Notifications"
    description="Receive email updates about your account activity"
/>
```

### Checked by Default

```blade
<x-strata::toggle
    checked
    label="Auto-save enabled"
/>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `'md'` | Toggle size: `'sm'`, `'md'`, `'lg'` |
| `rounded` | string | `'full'` | Border radius: `'none'`, `'sm'`, `'base'`, `'md'`, `'lg'`, `'xl'`, `'2xl'`, `'3xl'`, `'full'` |
| `state` | string | `'default'` | Validation state: `'default'`, `'success'`, `'error'`, `'warning'` |
| `disabled` | boolean | `false` | Disable toggle interaction |
| `checked` | boolean | `false` | Initial checked state |
| `label` | string | `null` | Label text displayed next to toggle |
| `description` | string | `null` | Helper text below the label |
| `id` | string | `null` | HTML id attribute (auto-generated if not provided) |

## Livewire Integration

The toggle component works seamlessly with Livewire's reactive properties.

### Component Setup

```php
use Livewire\Component;

class SettingsForm extends Component
{
    public bool $notifications = true;
    public bool $darkMode = false;
    public bool $autoSave = true;

    public function updatedNotifications($value): void
    {
        // React to toggle changes
        if ($value) {
            $this->enableNotifications();
        }
    }

    public function submit(): void
    {
        // Save settings
        auth()->user()->update([
            'notifications' => $this->notifications,
            'dark_mode' => $this->darkMode,
            'auto_save' => $this->autoSave,
        ]);

        session()->flash('message', 'Settings saved!');
    }

    public function render()
    {
        return view('livewire.settings-form');
    }
}
```

### View with Real-Time Updates

```blade
<div>
    <div class="space-y-4">
        <x-strata::toggle
            wire:model.live="notifications"
            label="Email Notifications"
            description="Receive email updates about your account"
            :state="$notifications ? 'success' : 'default'"
        />

        <x-strata::toggle
            wire:model.live="darkMode"
            label="Dark Mode"
            description="Switch to dark theme"
        />

        <x-strata::toggle
            wire:model.live="autoSave"
            label="Auto-save"
            description="Automatically save your work"
        />
    </div>

    <div class="mt-6">
        <x-strata::button wire:click="submit">
            Save Settings
        </x-strata::button>
    </div>
</div>
```

## Size Variants

The toggle component supports three sizes that scale both the track and thumb proportionally.

```blade
<x-strata::toggle size="sm" label="Small toggle" />
<x-strata::toggle size="md" label="Medium toggle (default)" />
<x-strata::toggle size="lg" label="Large toggle" />
```

**Size dimensions:**
- **Small**: Track: 36px × 20px, Thumb: 12px × 12px
- **Medium**: Track: 48px × 28px, Thumb: 16px × 16px
- **Large**: Track: 64px × 36px, Thumb: 20px × 20px

## Rounded Variants

Control the border radius of both the track and thumb. The `full` variant (default) creates the classic pill-shaped toggle switch.

```blade
<x-strata::toggle rounded="none" label="Square corners" checked />
<x-strata::toggle rounded="sm" label="Small radius" checked />
<x-strata::toggle rounded="base" label="Base radius" checked />
<x-strata::toggle rounded="md" label="Medium radius" checked />
<x-strata::toggle rounded="lg" label="Large radius" checked />
<x-strata::toggle rounded="xl" label="Extra large" checked />
<x-strata::toggle rounded="2xl" label="2X large" checked />
<x-strata::toggle rounded="3xl" label="3X large" checked />
<x-strata::toggle rounded="full" label="Fully rounded (default)" checked />
```

The `rounded` prop applies consistent border radius to both the track and thumb for a cohesive appearance.

## Validation States

Use validation states to provide visual feedback about the toggle's context or status.

```blade
<x-strata::toggle
    state="default"
    label="Default state"
    checked
/>

<x-strata::toggle
    state="success"
    label="Success state"
    description="Feature enabled successfully"
    checked
/>

<x-strata::toggle
    state="error"
    label="Error state"
    description="Unable to enable this feature"
    checked
/>

<x-strata::toggle
    state="warning"
    label="Warning state"
    description="Enabling this requires additional permissions"
    checked
/>
```

**State colors:**
- **Default**: Primary color when checked
- **Success**: Green track when checked
- **Error**: Red/destructive track when checked
- **Warning**: Orange/warning track when checked

## Disabled State

Disable toggles to prevent user interaction while maintaining visual context.

```blade
<x-strata::toggle disabled label="Disabled unchecked" />
<x-strata::toggle disabled checked label="Disabled checked" />
```

Disabled toggles have reduced opacity and prevent all mouse and keyboard interactions.

## Form Submission Example

```blade
<form wire:submit="submit">
    <div class="space-y-4">
        <x-strata::toggle
            wire:model="agreed"
            label="I agree to the terms"
            :state="$agreed ? 'success' : 'error'"
        />

        <x-strata::button
            type="submit"
            :disabled="!$agreed"
        >
            Continue
        </x-strata::button>
    </div>

    @if($message)
        <div class="mt-4 p-4 bg-success/10 border border-success rounded-lg">
            <p class="text-sm text-success">{{ $message }}</p>
        </div>
    @endif
</form>
```

```php
public function submit(): void
{
    if (!$this->agreed) {
        return;
    }

    // Process form...

    $this->message = 'Form submitted successfully!';
}
```

## Combining Size and Rounded Variants

You can combine size and rounded props for complete customization:

```blade
<x-strata::toggle size="lg" rounded="xl" label="Large with XL rounded" checked />
<x-strata::toggle size="sm" rounded="md" label="Small with MD rounded" checked />
<x-strata::toggle size="md" rounded="none" label="Medium with no rounding" checked />
```

## Settings Panel Example

Create a settings panel with multiple toggles:

```blade
<div class="space-y-6">
    <div>
        <h3 class="text-lg font-semibold mb-4">Notification Settings</h3>
        <div class="space-y-3">
            <x-strata::toggle
                wire:model.live="emailNotifications"
                label="Email Notifications"
                description="Receive updates via email"
            />
            <x-strata::toggle
                wire:model.live="pushNotifications"
                label="Push Notifications"
                description="Receive push alerts on your device"
            />
            <x-strata::toggle
                wire:model.live="smsNotifications"
                label="SMS Notifications"
                description="Receive text message alerts"
            />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Privacy Settings</h3>
        <div class="space-y-3">
            <x-strata::toggle
                wire:model.live="profilePublic"
                label="Public Profile"
                description="Make your profile visible to everyone"
            />
            <x-strata::toggle
                wire:model.live="showEmail"
                label="Show Email"
                description="Display your email on your profile"
            />
        </div>
    </div>
</div>
```

## Styling & Customization

The toggle component uses Strata UI's theming system with CSS custom properties:

```css
@theme {
    --color-primary: oklch(0.5 0.2 250);
    --color-success: oklch(0.6 0.2 140);
    --color-destructive: oklch(0.6 0.2 10);
    --color-warning: oklch(0.7 0.2 60);
    --color-secondary-200: oklch(0.9 0.01 250);
    --color-secondary-600: oklch(0.4 0.02 250);
}
```

## Accessibility

The toggle component includes comprehensive accessibility features:

- **Keyboard navigation**: Full keyboard support with Tab and Space/Enter
- **Focus indicators**: Clear visual focus states using ring utilities
- **ARIA attributes**: Proper ARIA roles and states for screen readers
- **Label association**: Explicit label-input association via `for` attribute
- **State announcements**: Screen readers announce checked/unchecked state
- **Disabled state**: Proper disabled attribute prevents interaction

### Keyboard Controls

- **Tab**: Move focus to/from toggle
- **Space**: Toggle checked state
- **Enter**: Toggle checked state

## Dark Mode Support

The toggle component automatically adapts to dark mode using Tailwind's dark mode utilities:

```blade
<x-strata::toggle label="Works in light and dark mode" checked />
```

The component adjusts:
- Track background colors
- Thumb colors
- Label and description text colors
- Focus ring colors

## Browser Support

Works in all modern browsers:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)

## Notes

- The toggle uses a checkbox input internally for form compatibility
- Animations use CSS transforms for optimal performance
- The thumb slides smoothly using transition utilities
- Default rounded variant is `full` for classic toggle appearance
- All wire:model variations work (live, blur, defer)
- The component is fully reactive with Livewire
- Custom IDs are auto-generated using `uniqid()` if not provided
- Data attributes (`data-strata-toggle`, `data-strata-toggle-wrapper`) enable reliable targeting
