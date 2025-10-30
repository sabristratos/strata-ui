# Modal

A flexible modal component using native `<dialog>` with Alpine.js for modern, accessible dialogs and flyouts.

## Basic Usage

### Name-based Modal

Use triggers to open modals by name:

```blade
<x-strata::modal.trigger name="confirm-modal">
    <x-strata::button>Open Modal</x-strata::button>
</x-strata::modal.trigger>

<x-strata::modal name="confirm-modal">
    <x-strata::modal.header>
        Confirm Action
        <x-slot:actions>
            <x-strata::modal.close />
        </x-slot:actions>
    </x-strata::modal.header>

    <x-strata::modal.body>
        <p>Are you sure you want to continue?</p>
    </x-strata::modal.body>

    <x-strata::modal.footer>
        <x-strata::modal.close as-child>
            <x-strata::button variant="secondary">Cancel</x-strata::button>
        </x-strata::modal.close>
        <x-strata::button>Confirm</x-strata::button>
    </x-strata::modal.footer>
</x-strata::modal>
```

### Programmatic Control with Livewire

Use `wire:model` for programmatic modal control:

```blade
{{-- Component --}}
<x-strata::button wire:click="$set('showModal', true)">
    Open Modal
</x-strata::button>

<x-strata::modal wire:model.live="showModal">
    <x-strata::modal.header>
        Edit Profile
        <x-slot:actions>
            <x-strata::modal.close />
        </x-slot:actions>
    </x-strata::modal.header>

    <x-strata::modal.body>
        {{-- Form fields --}}
    </x-strata::modal.body>

    <x-strata::modal.footer>
        <x-strata::button wire:click="$set('showModal', false)" variant="secondary">
            Cancel
        </x-strata::button>
        <x-strata::button wire:click="save">Save</x-strata::button>
    </x-strata::modal.footer>
</x-strata::modal>
```

## Sizes

Control modal width with the `size` prop:

```blade
{{-- Small (400px) --}}
<x-strata::modal name="small-modal" size="sm">
    {{-- Content --}}
</x-strata::modal>

{{-- Medium (560px) - Default --}}
<x-strata::modal name="medium-modal" size="md">
    {{-- Content --}}
</x-strata::modal>

{{-- Large (768px) --}}
<x-strata::modal name="large-modal" size="lg">
    {{-- Content --}}
</x-strata::modal>

{{-- Extra Large (1024px) --}}
<x-strata::modal name="xl-modal" size="xl">
    {{-- Content --}}
</x-strata::modal>
```

## Variants

### Modal (Default)

Centered dialog in the viewport:

```blade
<x-strata::modal name="centered-modal">
    {{-- Content --}}
</x-strata::modal>
```

### Flyout

Slide-in panel from the side:

```blade
{{-- Right side (default) --}}
<x-strata::modal name="settings" variant="flyout" position="right">
    <x-strata::modal.header>
        Settings
        <x-slot:actions>
            <x-strata::modal.close />
        </x-slot:actions>
    </x-strata::modal.header>

    <x-strata::modal.body>
        {{-- Settings content --}}
    </x-strata::modal.body>
</x-strata::modal>

{{-- Left side --}}
<x-strata::modal name="navigation" variant="flyout" position="left">
    {{-- Navigation content --}}
</x-strata::modal>
```

## Structure Components

### Header

Styled header with optional title and actions:

```blade
{{-- With title prop --}}
<x-strata::modal.header title="Modal Title" />

{{-- With slot content --}}
<x-strata::modal.header>
    Modal Title
    <x-slot:actions>
        <x-strata::modal.close />
    </x-slot:actions>
</x-strata::modal.header>
```

### Body

Scrollable content area with configurable padding:

```blade
{{-- Default padding --}}
<x-strata::modal.body>
    <p>Content goes here</p>
</x-strata::modal.body>

{{-- No padding --}}
<x-strata::modal.body padding="none">
    <img src="image.jpg" alt="Full width image" />
</x-strata::modal.body>

{{-- Small padding --}}
<x-strata::modal.body padding="sm">
    <p>Compact content</p>
</x-strata::modal.body>

{{-- Large padding --}}
<x-strata::modal.body padding="lg">
    <p>Spacious content</p>
</x-strata::modal.body>
```

### Footer

Styled footer with configurable alignment:

```blade
{{-- Align end (default) --}}
<x-strata::modal.footer>
    <x-strata::button variant="secondary">Cancel</x-strata::button>
    <x-strata::button>Submit</x-strata::button>
</x-strata::modal.footer>

{{-- Align start --}}
<x-strata::modal.footer align="start">
    <x-strata::button>Action</x-strata::button>
</x-strata::modal.footer>

{{-- Align between --}}
<x-strata::modal.footer align="between">
    <x-strata::button variant="secondary">Cancel</x-strata::button>
    <x-strata::button>Submit</x-strata::button>
</x-strata::modal.footer>
```

### Close Button

Close the modal using the close component:

```blade
{{-- Default styled close button --}}
<x-strata::modal.close />

{{-- Custom close button --}}
<x-strata::modal.close as-child>
    <x-strata::button variant="secondary">Cancel</x-strata::button>
</x-strata::modal.close>

{{-- Custom content --}}
<x-strata::modal.close>
    <x-strata::icon.x class="w-4 h-4" />
</x-strata::modal.close>
```

## Dismissible Behavior

Control whether modals can be dismissed by clicking the backdrop or pressing ESC:

```blade
{{-- Dismissible (default) --}}
<x-strata::modal name="dismissible-modal">
    {{-- Can be closed with ESC or backdrop click --}}
</x-strata::modal>

{{-- Non-dismissible --}}
<x-strata::modal name="important-modal" :dismissible="false">
    {{-- Can only be closed with close button --}}
</x-strata::modal>
```

## Events

Modals dispatch custom events you can listen for:

```blade
<div x-data @modal-opened.window="console.log('Modal opened:', $event.detail.name)">
    {{-- Your content --}}
</div>

<div x-data @modal-closed.window="console.log('Modal closed:', $event.detail.name)">
    {{-- Your content --}}
</div>

<div x-data @modal-cancelled.window="console.log('Modal cancelled:', $event.detail.name)">
    {{-- Your content --}}
</div>
```

## Form Integration

Use modals with forms and Livewire validation:

```blade
<x-strata::modal wire:model.live="showForm" size="lg">
    <form wire:submit="submit">
        <x-strata::modal.header>
            Contact Form
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <div class="space-y-4">
                <x-strata::form.field>
                    <x-strata::form.label for="name">Name</x-strata::form.label>
                    <x-strata::input id="name" wire:model="name" />
                    <x-strata::form.error name="name" />
                </x-strata::form.field>

                <x-strata::form.field>
                    <x-strata::form.label for="email">Email</x-strata::form.label>
                    <x-strata::input id="email" type="email" wire:model="email" />
                    <x-strata::form.error name="email" />
                </x-strata::form.field>
            </div>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::button type="button" variant="secondary" wire:click="$set('showForm', false)">
                Cancel
            </x-strata::button>
            <x-strata::button type="submit">Submit</x-strata::button>
        </x-strata::modal.footer>
    </form>
</x-strata::modal>
```

## Props Reference

### Modal

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | `null` | Unique identifier for name-based triggers |
| `size` | `'sm' \| 'md' \| 'lg' \| 'xl'` | `'md'` | Modal width |
| `variant` | `'modal' \| 'flyout'` | `'modal'` | Display style |
| `position` | `'left' \| 'right'` | `'right'` | Flyout position (only for flyout variant) |
| `dismissible` | `boolean` | `true` | Whether backdrop/ESC closes modal |

### Modal.Trigger

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | required | Name of the modal to open |

### Modal.Close

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `as-child` | `boolean` | `false` | Whether to use child element instead of default button |

### Modal.Header

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `string` | `null` | Optional title text |

**Slots:**
- `default` - Header content
- `actions` - Action buttons (typically close button)

### Modal.Body

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `padding` | `'none' \| 'sm' \| 'default' \| 'lg'` | `'default'` | Body padding |

### Modal.Footer

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `align` | `'start' \| 'center' \| 'end' \| 'between'` | `'end'` | Footer content alignment |

## Best Practices

1. **Use descriptive names** - Choose clear, unique names for your modals
2. **Provide close options** - Always give users a way to close modals
3. **Consider mobile** - Test flyouts and large modals on mobile devices
4. **Form validation** - Use Livewire's validation with forms in modals
5. **Accessibility** - The dialog element handles focus trapping automatically
6. **Loading states** - Show loading indicators during async operations
7. **Non-dismissible sparingly** - Only use non-dismissible for critical actions

## Examples

### Confirmation Dialog

```blade
<x-strata::modal name="delete-confirm" size="sm">
    <x-strata::modal.header>
        Confirm Deletion
        <x-slot:actions>
            <x-strata::modal.close />
        </x-slot:actions>
    </x-strata::modal.header>

    <x-strata::modal.body>
        <p class="text-muted-foreground">
            This action cannot be undone. Are you sure you want to delete this item?
        </p>
    </x-strata::modal.body>

    <x-strata::modal.footer>
        <x-strata::modal.close as-child>
            <x-strata::button variant="secondary">Cancel</x-strata::button>
        </x-strata::modal.close>
        <x-strata::button variant="destructive" wire:click="delete">Delete</x-strata::button>
    </x-strata::modal.footer>
</x-strata::modal>
```

### Settings Flyout

```blade
<x-strata::modal name="settings" variant="flyout" position="right">
    <x-strata::modal.header>
        Settings
        <x-slot:actions>
            <x-strata::modal.close />
        </x-slot:actions>
    </x-strata::modal.header>

    <x-strata::modal.body>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="font-medium">Notifications</span>
                <x-strata::toggle wire:model="notifications" />
            </div>

            <div class="flex items-center justify-between">
                <span class="font-medium">Dark Mode</span>
                <x-strata::toggle wire:model="darkMode" />
            </div>
        </div>
    </x-strata::modal.body>

    <x-strata::modal.footer>
        <x-strata::modal.close as-child>
            <x-strata::button>Done</x-strata::button>
        </x-strata::modal.close>
    </x-strata::modal.footer>
</x-strata::modal>
```
