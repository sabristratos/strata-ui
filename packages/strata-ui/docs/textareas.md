# Textareas

Multi-line text input components with validation states, resize control, character counter, and Livewire integration. Includes action components for common patterns.

## Textarea Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `size` | string | `md` | `sm`, `md`, `lg` | Textarea size |
| `state` | string | `default` | `default`, `success`, `error`, `warning` | Validation state with automatic icon |
| `resize` | string | `vertical` | `none`, `vertical`, `horizontal`, `both` | Resize behavior |
| `rows` | number | `4` | Any positive number | Number of visible text rows |
| `disabled` | boolean | `false` | `true`, `false` | Disable textarea |

All other attributes (`wire:*`, `x-*`, `name`, `id`, `placeholder`, `maxlength`, etc.) are passed to the textarea element.

## Action Components

Action components can be added via slot and appear in the footer below the textarea:

### Clear Button

Use `<x-strata::textarea.clear />` to add a clear button that only appears when textarea has a value.

### Character Counter

Use `<x-strata::textarea.counter max="500" />` to show character count with color feedback (muted → warning at 80% → destructive at 100%).

## Example

```blade
{{-- Textarea with multiple props --}}
<x-strata::textarea
    size="lg"
    state="success"
    resize="vertical"
    rows="6"
    placeholder="Enter your message..."
    wire:model="message"
/>

{{-- Textarea with action components --}}
<x-strata::textarea
    placeholder="Type something..."
    maxlength="500"
    rows="8"
    wire:model="content"
>
    <x-strata::textarea.counter max="500" />
    <x-strata::textarea.clear />
</x-strata::textarea>
```

## Form Composition

Use form helper components for complete fields:

```blade
<x-strata::form.field>
    <x-strata::form.label for="bio" required>Bio</x-strata::form.label>
    <x-strata::textarea
        id="bio"
        wire:model="bio"
        rows="6"
        maxlength="500"
        :state="$errors->has('bio') ? 'error' : 'default'"
        placeholder="Tell us about yourself..."
    >
        <x-strata::textarea.counter max="500" />
    </x-strata::textarea>
    <x-strata::form.hint>Share a brief description of your background</x-strata::form.hint>
    @error('bio')
        <x-strata::form.error>{{ $message }}</x-strata::form.error>
    @enderror
</x-strata::form.field>
```

## Livewire Integration

Wire directives are automatically passed to the textarea element:

```blade
<x-strata::textarea
    wire:model="description"
    wire:keydown.enter="submit"
    placeholder="Enter description"
/>
```

## Notes

- **Validation states:** Icon automatically floats in top-right corner of textarea
- **Action components:** Appear in footer below textarea via slot
- **Resize control:** Four options for user control of textarea dimensions
- **Character counter:** Color changes based on proximity to limit
- **Tactile depth:** Subtle inset shadow provides pressable feel
- **Focus states:** Visible focus rings for keyboard navigation
- **Responsive:** All elements scale with size prop
