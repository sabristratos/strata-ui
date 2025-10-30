# Checkboxes

Flexible checkbox components with full Livewire integration, support for validation states, sizes, and indeterminate state.

## Basic Usage

```blade
<x-strata::checkbox label="I agree to the terms" />
<x-strata::checkbox label="Subscribe to newsletter" checked />
<x-strata::checkbox label="Disabled option" disabled />
```

## With Livewire

Checkboxes work seamlessly with Livewire's `wire:model` directive:

```blade
<x-strata::checkbox
    wire:model.live="agreed"
    label="I agree to the terms and conditions"
/>
```

### Multiple Selection

```blade
@foreach($options as $option)
    <x-strata::checkbox
        wire:model="selectedOptions"
        value="{{ $option->id }}"
        :label="$option->name"
    />
@endforeach
```

## Sizes

Available sizes: `sm`, `md` (default), `lg`

```blade
<x-strata::checkbox size="sm" label="Small checkbox" />
<x-strata::checkbox size="md" label="Medium checkbox" />
<x-strata::checkbox size="lg" label="Large checkbox" />
```

## Validation States

Available states: `default`, `success`, `error`, `warning`

```blade
<x-strata::checkbox state="default" label="Default state" />
<x-strata::checkbox state="success" label="Valid option" checked />
<x-strata::checkbox state="error" label="Invalid option" />
<x-strata::checkbox state="warning" label="Warning state" />
```

## Disabled State

```blade
<x-strata::checkbox disabled label="Disabled unchecked" />
<x-strata::checkbox disabled checked label="Disabled checked" />
```

## Indeterminate State

Perfect for "Select All" functionality:

```blade
<x-strata::checkbox
    wire:model="selectAll"
    :indeterminate="count($selected) > 0 && count($selected) < count($total)"
    label="Select All"
/>
```

### Complete Select All Example

```blade
{{-- Parent checkbox --}}
<x-strata::checkbox
    wire:model.live="selectAll"
    :indeterminate="count($selectedOptions) > 0 && count($selectedOptions) < count($allOptions)"
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

## Checkbox Groups

Group related checkboxes with consistent spacing and layout.

### Vertical Group (Default)

```blade
<x-strata::checkbox.group label="Select your preferences">
    <x-strata::checkbox label="Email notifications" checked />
    <x-strata::checkbox label="SMS notifications" />
    <x-strata::checkbox label="Push notifications" />
</x-strata::checkbox.group>
```

### Horizontal Group

```blade
<x-strata::checkbox.group label="Choose an answer" orientation="horizontal">
    <x-strata::checkbox label="Yes" />
    <x-strata::checkbox label="No" />
    <x-strata::checkbox label="Maybe" />
</x-strata::checkbox.group>
```

### Group with Error

```blade
<x-strata::checkbox.group
    label="Required selection"
    error="Please select at least one option"
>
    <x-strata::checkbox label="Option 1" />
    <x-strata::checkbox label="Option 2" />
    <x-strata::checkbox label="Option 3" />
</x-strata::checkbox.group>
```

## Custom Labels

Use the slot for more complex label content:

```blade
<x-strata::checkbox>
    <span class="font-medium">Accept terms</span>
    <span class="text-sm text-muted-foreground block">
        By checking this box, you agree to our terms and conditions
    </span>
</x-strata::checkbox>
```

## Props Reference

### Checkbox

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `md` | Size variant: `sm`, `md`, `lg` |
| `state` | string | `default` | Validation state: `default`, `success`, `error`, `warning` |
| `disabled` | boolean | `false` | Disable the checkbox |
| `checked` | boolean | `false` | Initial checked state |
| `indeterminate` | boolean | `false` | Show indeterminate state (dash) |
| `label` | string | `null` | Label text (or use default slot) |
| `id` | string | `null` | Custom ID (auto-generated if not provided) |

**Additional Attributes:**
- All standard input attributes (`name`, `value`, `wire:*`, etc.) are passed through
- Livewire directives work automatically

### Checkbox Group

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `orientation` | string | `vertical` | Layout direction: `vertical`, `horizontal` |
| `label` | string | `null` | Group label text |
| `error` | string | `null` | Error message to display |

## Real-World Examples

### Terms and Conditions

```blade
<form wire:submit="register">
    <x-strata::checkbox
        wire:model="agreedToTerms"
        :state="$errors->has('agreedToTerms') ? 'error' : 'default'"
    >
        I agree to the
        <a href="/terms" class="text-primary hover:underline">Terms and Conditions</a>
    </x-strata::checkbox>

    @error('agreedToTerms')
        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
    @enderror

    <x-strata::button type="submit" :disabled="!$agreedToTerms">
        Create Account
    </x-strata::button>
</form>
```

### Notification Preferences

```blade
<x-strata::card>
    <x-strata::card.header
        title="Notification Preferences"
        subtitle="Choose how you want to be notified"
    />
    <x-strata::card.body>
        <div class="space-y-4">
            <x-strata::checkbox
                wire:model.live="notifications.email"
                label="Email Notifications"
            />
            <x-strata::checkbox
                wire:model.live="notifications.sms"
                label="SMS Notifications"
            />
            <x-strata::checkbox
                wire:model.live="notifications.push"
                label="Push Notifications"
            />
        </div>
    </x-strata::card.body>
    <x-strata::card.footer>
        <x-strata::button wire:click="savePreferences" variant="primary">
            Save Preferences
        </x-strata::button>
    </x-strata::card.footer>
</x-strata::card>
```

### Task List with Select All

```blade
<div>
    <x-strata::checkbox
        wire:model.live="selectAll"
        :indeterminate="count($completedTasks) > 0 && count($completedTasks) < count($tasks)"
        label="Select All Tasks"
        size="lg"
    />

    <div class="mt-4 space-y-2">
        @foreach($tasks as $task)
            <x-strata::card style="outlined">
                <x-strata::card.body padding="sm">
                    <x-strata::checkbox
                        wire:model.live="completedTasks"
                        value="{{ $task->id }}"
                    >
                        <span class="font-medium">{{ $task->title }}</span>
                        <span class="text-sm text-muted-foreground block">
                            {{ $task->description }}
                        </span>
                    </x-strata::checkbox>
                </x-strata::card.body>
            </x-strata::card>
        @endforeach
    </div>

    <div class="mt-4">
        <p class="text-sm text-muted-foreground">
            {{ count($completedTasks) }} of {{ count($tasks) }} tasks completed
        </p>
    </div>
</div>
```

### Filter Sidebar

```blade
<aside class="w-64 space-y-6">
    <x-strata::checkbox.group label="Categories">
        <x-strata::checkbox
            wire:model.live="filters.categories"
            value="electronics"
            label="Electronics"
        />
        <x-strata::checkbox
            wire:model.live="filters.categories"
            value="clothing"
            label="Clothing"
        />
        <x-strata::checkbox
            wire:model.live="filters.categories"
            value="books"
            label="Books"
        />
    </x-strata::checkbox.group>

    <x-strata::checkbox.group label="Price Range">
        <x-strata::checkbox
            wire:model.live="filters.price"
            value="0-50"
            label="Under $50"
        />
        <x-strata::checkbox
            wire:model.live="filters.price"
            value="50-100"
            label="$50 - $100"
        />
        <x-strata::checkbox
            wire:model.live="filters.price"
            value="100+"
            label="Over $100"
        />
    </x-strata::checkbox.group>

    <x-strata::checkbox
        wire:model.live="filters.inStock"
        label="In Stock Only"
    />
</aside>
```

### Agreement Form with Validation

```blade
<form wire:submit="submit">
    <div class="space-y-4">
        <x-strata::checkbox
            wire:model="agreements.terms"
            :state="$errors->has('agreements.terms') ? 'error' : 'default'"
        >
            <span class="font-medium">Terms and Conditions</span>
            <span class="text-sm text-muted-foreground block">
                I have read and accept the terms and conditions
            </span>
        </x-strata::checkbox>

        <x-strata::checkbox
            wire:model="agreements.privacy"
            :state="$errors->has('agreements.privacy') ? 'error' : 'default'"
        >
            <span class="font-medium">Privacy Policy</span>
            <span class="text-sm text-muted-foreground block">
                I understand how my data will be processed
            </span>
        </x-strata::checkbox>

        <x-strata::checkbox
            wire:model="agreements.marketing"
        >
            <span class="font-medium">Marketing Communications</span>
            <span class="text-sm text-muted-foreground block">
                I want to receive updates and promotional offers (optional)
            </span>
        </x-strata::checkbox>
    </div>

    <x-strata::button
        type="submit"
        variant="primary"
        class="mt-6"
        :disabled="!$agreements['terms'] || !$agreements['privacy']"
    >
        Continue
    </x-strata::button>
</form>
```

## Accessibility

Checkboxes are fully accessible:
- Proper label associations using `for` and `id`
- Keyboard navigation support (Space to toggle)
- Screen reader support
- Disabled state properly communicated
- Focus indicators for keyboard navigation
