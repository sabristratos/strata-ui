# Textareas

Multi-line text input components with validation states, resize control, and composable action components.

## Basic Usage

```blade
<x-strata::textarea placeholder="Enter your message..." />
<x-strata::textarea rows="6" placeholder="Longer textarea..." />
```

## Sizes

Available sizes: `sm`, `md` (default), `lg`

```blade
<x-strata::textarea size="sm" placeholder="Small" />
<x-strata::textarea size="md" placeholder="Medium" />
<x-strata::textarea size="lg" placeholder="Large" />
```

## Validation States

Show validation feedback with state variants:

```blade
<x-strata::textarea state="default" placeholder="Default" />
<x-strata::textarea state="success" value="Looks good!" />
<x-strata::textarea state="error" value="Error here" />
<x-strata::textarea state="warning" value="Warning" />
```

Each state automatically shows the appropriate icon and border color.

## Resize Control

Control how users can resize the textarea:

```blade
<x-strata::textarea resize="none" placeholder="No resize" />
<x-strata::textarea resize="vertical" placeholder="Vertical only (default)" />
<x-strata::textarea resize="horizontal" placeholder="Horizontal only" />
<x-strata::textarea resize="both" placeholder="Both directions" />
```

Available options: `none`, `vertical` (default), `horizontal`, `both`

## Rows

Set the default height in rows:

```blade
<x-strata::textarea rows="3" placeholder="Short textarea" />
<x-strata::textarea rows="8" placeholder="Tall textarea" />
```

## State Icons

When a validation state is set, the appropriate icon automatically appears floating in the top-right corner:

```blade
<x-strata::textarea state="error" value="Invalid input" />
{{-- Error icon shown top-right --}}

<x-strata::textarea state="success" value="Valid input" />
{{-- Success icon shown top-right --}}

<x-strata::textarea state="warning" value="Review this" />
{{-- Warning icon shown top-right --}}
```

The icon has `pointer-events-none` so it doesn't interfere with interaction.

## Footer Slot

Textareas include a footer slot below the textarea where you can add action components and custom content:

```blade
<x-strata::textarea>
    <x-strata::textarea.counter max="200" />
    <x-strata::textarea.clear />
</x-strata::textarea>
```

## Action Components

Strata UI provides reusable action components that go in the footer slot.

### Clear Button

Automatically clears the textarea and only shows when there's a value:

```blade
<x-strata::textarea placeholder="Type something...">
    <x-strata::textarea.clear />
</x-strata::textarea>
```

The clear button:
- Only appears when textarea has value
- Clears the value on click
- Refocuses the textarea
- Dispatches input event (works with Livewire)

### Character Counter

Shows current length vs maximum with color feedback:

```blade
<x-strata::textarea placeholder="Bio" maxlength="200">
    <x-strata::textarea.counter max="200" />
</x-strata::textarea>
```

The counter:
- Updates in real-time as you type
- Shows "X/200" format
- Color changes: muted (normal) → warning (80%) → destructive (100%)
- Props: `max` (required)

### Combining Actions

You can combine multiple action components in the footer:

```blade
<x-strata::textarea maxlength="500">
    <x-strata::textarea.counter max="500" />
    <x-strata::textarea.clear />
</x-strata::textarea>
```

### State with Actions

State icons float top-right inside textarea, actions appear in footer below:

```blade
<x-strata::textarea state="error" maxlength="200">
    <x-strata::textarea.counter max="200" />
</x-strata::textarea>
{{-- Error icon floating top-right, counter in footer below --}}
```

### Custom Footer Content

Add any custom content to the footer slot:

```blade
<x-strata::textarea>
    <span class="text-sm text-muted-foreground">Custom footer text</span>
    <x-strata::button size="sm">Submit</x-strata::button>
</x-strata::textarea>
```

## Disabled State

```blade
<x-strata::textarea disabled value="Cannot edit this" />
```

## Livewire Integration

All wire:* attributes are automatically passed to the textarea element:

```blade
<x-strata::textarea
    wire:model="description"
    placeholder="Enter description"
/>

<x-strata::textarea
    wire:model.live.debounce.500ms="notes"
    placeholder="Notes..."
/>
```

## Alpine.js Integration

Alpine directives are also passed to the textarea:

```blade
<x-strata::textarea
    x-model="bio"
    @input="validateBio()"
    placeholder="Bio"
/>
```

## Form Field Composition

Use with form components for complete fields:

```blade
<x-strata::form.field>
    <x-strata::form.label for="bio" required>Bio</x-strata::form.label>
    <x-strata::textarea
        id="bio"
        placeholder="Tell us about yourself..."
        rows="5"
        maxlength="500"
    >
        <x-strata::textarea.counter max="500" />
    </x-strata::textarea>
    <x-strata::form.hint>Share a brief description of your background</x-strata::form.hint>
</x-strata::form.field>
```

## Complete Examples

### Basic Field

```blade
<x-strata::form.field>
    <x-strata::form.label for="message" required>Message</x-strata::form.label>
    <x-strata::textarea id="message" placeholder="Enter your message..." />
    <x-strata::form.hint>This will be sent to the team</x-strata::form.hint>
</x-strata::form.field>
```

### With Success State

```blade
<x-strata::form.field>
    <x-strata::form.label for="notes">Notes</x-strata::form.label>
    <x-strata::textarea
        id="notes"
        state="success"
        value="Successfully saved!"
        rows="6"
    />
</x-strata::form.field>
```

### With Error State

```blade
<x-strata::form.field>
    <x-strata::form.label for="description" required>Description</x-strata::form.label>
    <x-strata::textarea
        id="description"
        state="error"
        value="Too short"
    />
    <x-strata::form.error>Description must be at least 20 characters</x-strata::form.error>
</x-strata::form.field>
```

### With Character Counter

```blade
<x-strata::form.field>
    <x-strata::form.label for="bio">Bio</x-strata::form.label>
    <x-strata::textarea
        id="bio"
        placeholder="Write your bio..."
        maxlength="500"
        rows="6"
    >
        <x-strata::textarea.counter max="500" />
    </x-strata::textarea>
    <x-strata::form.hint>Maximum 500 characters</x-strata::form.hint>
</x-strata::form.field>
```

### Livewire Form

```blade
<form wire:submit="save">
    <x-strata::form.field>
        <x-strata::form.label for="content" required>Content</x-strata::form.label>
        <x-strata::textarea
            id="content"
            wire:model="content"
            :state="$errors->has('content') ? 'error' : 'default'"
            rows="8"
            maxlength="1000"
        >
            <x-strata::textarea.counter max="1000" />
            <x-strata::textarea.clear />
        </x-strata::textarea>
        @error('content')
            <x-strata::form.error>{{ $message }}</x-strata::form.error>
        @enderror
    </x-strata::form.field>

    <x-strata::button type="submit">Save</x-strata::button>
</form>
```

## Props Reference

### Textarea

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `state` | string | `default` | Validation state (`default`, `success`, `error`, `warning`) - icon shown in footer |
| `size` | string | `md` | Textarea size (`sm`, `md`, `lg`) |
| `resize` | string | `vertical` | Resize behavior (`none`, `vertical`, `horizontal`, `both`) |
| `rows` | number | `4` | Number of visible text rows |
| `disabled` | boolean | `false` | Disable the textarea |

All other attributes (`wire:*`, `x-*`, `name`, `id`, `placeholder`, etc.) are passed to the textarea element.

### Action Components

#### Clear Button

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `sm` | Button size |

#### Counter

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `max` | number | `100` | Maximum character count |

## Architecture

The textarea component uses a clean wrapper-based architecture with optional footer:

```blade
<div>
    {{-- Textarea wrapper --}}
    <div data-strata-textarea-wrapper class="relative">
        <textarea data-strata-textarea />  <!-- Textarea element (full-width) -->
        <state-icon />                     <!-- Auto validation icon (floating top-right) -->
    </div>

    {{-- Optional footer section --}}
    @if($slot->isNotEmpty())
        <div class="footer">
            {{ $slot }}  <!-- User content: actions, counter, custom elements -->
        </div>
    @endif
</div>
```

**Benefits:**
- Resize handle stays in correct position (bottom-right of wrapper)
- State icons float top-right for immediate visual feedback
- Footer below prevents any overlap with textarea content
- Clean separation between textarea and supplementary content
- Flexible footer for any custom content

### Data Attributes

- `data-strata-textarea-wrapper` - Main wrapper element
- `data-strata-textarea` - The textarea element itself

Action components use these attributes to reliably find and interact with the textarea regardless of nesting level.
