# Repeater

A flexible component for managing dynamic lists of items with add/remove functionality. Perfect for contact forms, social links, feature lists, and any scenario where users need to manage a collection of related data.

## Basic Usage

The repeater component uses a slot-based approach, giving you complete control over the fields within each item. Use Alpine.js `x-model` to bind to the items array using the `itemIndex` variable that's automatically available.

```blade
<x-strata::repeater wire:model="items">
    <x-strata::input
        x-model="items[itemIndex].title"
        placeholder="Enter title"
    />
</x-strata::repeater>
```

## With Livewire

The repeater integrates seamlessly with Livewire for state management:

```php
class ContactForm extends Component
{
    public array $contacts = [];

    public function mount(): void
    {
        $this->contacts = [
            ['name' => '', 'email' => ''],
        ];
    }

    public function save(): void
    {
        $this->validate([
            'contacts' => 'required|array',
            'contacts.*.name' => 'required|string',
            'contacts.*.email' => 'required|email',
        ]);

        // Save contacts...
    }
}
```

```blade
<form wire:submit="save">
    <x-strata::repeater wire:model="contacts">
        <div class="grid grid-cols-2 gap-4">
            <x-strata::input
                x-model="items[itemIndex].name"
                placeholder="Name"
            />
            <x-strata::input
                type="email"
                x-model="items[itemIndex].email"
                placeholder="Email"
            />
        </div>
    </x-strata::repeater>

    <x-strata::button type="submit">Save</x-strata::button>
</form>
```

## Multiple Field Types

You can include any type of form field within repeater items:

```blade
<x-strata::repeater wire:model="contacts">
    <div class="space-y-4">
        <x-strata::input
            x-model="items[itemIndex].name"
            placeholder="Full Name"
        />

        <x-strata::input
            type="email"
            x-model="items[itemIndex].email"
            placeholder="Email Address"
        />

        <x-strata::input
            type="tel"
            x-model="items[itemIndex].phone"
            placeholder="Phone Number"
        />

        <x-strata::select
            x-model="items[itemIndex].type"
            placeholder="Contact Type"
        >
            <option value="work">Work</option>
            <option value="personal">Personal</option>
        </x-strata::select>
    </div>
</x-strata::repeater>
```

## Sizes

The repeater supports three sizes that affect padding and spacing:

```blade
{{-- Small --}}
<x-strata::repeater wire:model="items" size="sm">
    <x-strata::input x-model="items[itemIndex].title" size="sm" />
</x-strata::repeater>

{{-- Medium (default) --}}
<x-strata::repeater wire:model="items" size="md">
    <x-strata::input x-model="items[itemIndex].title" />
</x-strata::repeater>

{{-- Large --}}
<x-strata::repeater wire:model="items" size="lg">
    <x-strata::input x-model="items[itemIndex].title" size="lg" />
</x-strata::repeater>
```

## Min/Max Constraints

Control the minimum and maximum number of items:

```blade
{{-- Minimum 1 item --}}
<x-strata::repeater wire:model="contacts" :min="1">
    <x-strata::input x-model="items[itemIndex].email" />
</x-strata::repeater>

{{-- Maximum 5 items --}}
<x-strata::repeater wire:model="features" :max="5">
    <x-strata::input x-model="items[itemIndex].title" />
</x-strata::repeater>

{{-- Between 3 and 6 items --}}
<x-strata::repeater wire:model="items" :min="3" :max="6">
    <x-strata::input x-model="items[itemIndex].title" />
</x-strata::repeater>
```

## Custom Add Button Label

Customize the label for the add button:

```blade
<x-strata::repeater wire:model="contacts" add-label="Add Contact">
    <x-strata::input x-model="items[itemIndex].name" />
</x-strata::repeater>

<x-strata::repeater wire:model="socialLinks" add-label="Add Social Link">
    <x-strata::input x-model="items[itemIndex].url" />
</x-strata::repeater>
```

## Validation States

Display validation errors for individual items:

```blade
<x-strata::repeater wire:model="contacts">
    <div class="space-y-2">
        <x-strata::form.label>Email</x-strata::form.label>
        <x-strata::input
            x-model="items[itemIndex].email"
        />
        {{-- Note: Validation errors should be handled in your Livewire component --}}
    </div>
</x-strata::repeater>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `wire:model` | string | - | The Livewire property to bind to |
| `min` | int | 0 | Minimum number of items (prevents removal below this) |
| `max` | int | null | Maximum number of items (disables add button when reached) |
| `addLabel` | string | 'Add Item' | Label for the add button |
| `size` | string | 'md' | Size of the repeater items: `sm`, `md`, `lg` |
| `state` | string | 'default' | Validation state: `default`, `success`, `error`, `warning` |

## Real-World Examples

### Contact Management Form

```blade
<form wire:submit="saveContacts">
    <x-strata::repeater wire:model="contacts" :min="1" add-label="Add Another Contact">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-strata::form.label>Name</x-strata::form.label>
                <x-strata::input
                    x-model="items[itemIndex].name"
                    placeholder="John Doe"
                />
            </div>

            <div>
                <x-strata::form.label>Email</x-strata::form.label>
                <x-strata::input
                    type="email"
                    x-model="items[itemIndex].email"
                    placeholder="john@example.com"
                />
            </div>

            <div>
                <x-strata::form.label>Phone</x-strata::form.label>
                <x-strata::input
                    type="tel"
                    x-model="items[itemIndex].phone"
                    placeholder="555-0100"
                />
            </div>
        </div>
    </x-strata::repeater>

    <x-strata::button type="submit" class="mt-4">Save Contacts</x-strata::button>
</form>
```

### Social Media Links

```blade
<x-strata::repeater wire:model="socialLinks" add-label="Add Social Link">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-strata::select x-model="items[itemIndex].platform">
            <option value="">Select Platform</option>
            <option value="twitter">Twitter</option>
            <option value="github">GitHub</option>
            <option value="linkedin">LinkedIn</option>
            <option value="facebook">Facebook</option>
        </x-strata::select>

        <x-strata::input
            type="url"
            x-model="items[itemIndex].url"
            placeholder="https://..."
        />
    </div>
</x-strata::repeater>
```

### Product Features List

```blade
<x-strata::repeater wire:model="features" :min="3" :max="6" add-label="Add Feature" size="sm">
    <x-strata::input
        x-model="items[itemIndex].title"
        placeholder="Feature title"
        size="sm"
    />
</x-strata::repeater>

<p class="text-sm text-muted-foreground mt-2">
    {{ count($features) }} of 6 features added (minimum 3 required)
</p>
```

### FAQ Management

```blade
<x-strata::repeater wire:model="faqs" add-label="Add FAQ">
    <div class="space-y-3">
        <div>
            <x-strata::form.label>Question</x-strata::form.label>
            <x-strata::input
                x-model="items[itemIndex].question"
                placeholder="What is your question?"
            />
        </div>

        <div>
            <x-strata::form.label>Answer</x-strata::form.label>
            <x-strata::textarea
                x-model="items[itemIndex].answer"
                rows="3"
                placeholder="Provide a detailed answer..."
            />
        </div>
    </div>
</x-strata::repeater>
```

### Team Member Invitations

```blade
<x-strata::repeater wire:model="invitations" :max="10" add-label="Invite Team Member">
    <div class="flex gap-4">
        <div class="flex-1">
            <x-strata::input
                type="email"
                x-model="items[itemIndex].email"
                placeholder="colleague@company.com"
            />
        </div>

        <div class="w-48">
            <x-strata::select x-model="items[itemIndex].role">
                <option value="member">Member</option>
                <option value="admin">Admin</option>
                <option value="viewer">Viewer</option>
            </x-strata::select>
        </div>
    </div>
</x-strata::repeater>
```

### Ingredient List with Measurements

```blade
<x-strata::repeater wire:model="ingredients" :min="1" add-label="Add Ingredient">
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-2">
            <x-strata::input
                type="number"
                x-model="items[itemIndex].amount"
                placeholder="1"
                step="0.1"
            />
        </div>

        <div class="col-span-3">
            <x-strata::select x-model="items[itemIndex].unit">
                <option value="cup">Cup</option>
                <option value="tbsp">Tbsp</option>
                <option value="tsp">Tsp</option>
                <option value="oz">Oz</option>
                <option value="lb">Lb</option>
                <option value="g">Gram</option>
            </x-strata::select>
        </div>

        <div class="col-span-7">
            <x-strata::input
                x-model="items[itemIndex].name"
                placeholder="Ingredient name"
            />
        </div>
    </div>
</x-strata::repeater>
```

## Accessibility

The repeater component is built with accessibility in mind:

- Remove buttons include proper `aria-label` attributes
- All interactive elements are keyboard accessible
- Validation states are properly announced to screen readers
- Focus management works correctly when adding/removing items
- Semantic HTML structure for better screen reader navigation

## Notes

- The repeater uses Alpine.js for client-side state management and syncs with Livewire
- Items are automatically initialized with an empty object `{}` if the array is empty
- The `$index` variable is available in the slot for building field names
- Min/max constraints are enforced both in the UI and should be validated server-side
- The component works seamlessly with all other Strata UI form components
