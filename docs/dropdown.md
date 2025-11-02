# Dropdown Component

A comprehensive dropdown menu component with support for actions, checkboxes, radios, nested submenus, and full keyboard navigation following ARIA menu patterns.

## Installation

The dropdown component is included in Strata UI. No additional installation required.

## Basic Usage

### Simple Action Menu

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger data-dropdown-trigger="menu-1">
        Actions
        <x-strata::icon.chevron-down class="w-4 h-4" />
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.item icon="edit">Edit</x-strata::dropdown.item>
        <x-strata::dropdown.item icon="copy">Duplicate</x-strata::dropdown.item>
        <x-strata::dropdown.divider />
        <x-strata::dropdown.item icon="trash" destructive>Delete</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

### With Links

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger data-dropdown-trigger="nav-1">
        Menu
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.item href="/dashboard" icon="home">Dashboard</x-strata::dropdown.item>
        <x-strata::dropdown.item href="/settings" icon="settings">Settings</x-strata::dropdown.item>
        <x-strata::dropdown.item href="/profile" icon="user">Profile</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Props Reference

### Dropdown Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | string | auto-generated | Unique identifier for the dropdown |
| `size` | string | `'md'` | Size variant: `sm`, `md`, `lg` |
| `placement` | string | `'bottom-start'` | Floating UI placement option |
| `offset` | number | `8` | Distance from trigger in pixels |

### Dropdown Trigger

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Style variant: `default`, `primary`, `ghost`, `text` |
| `size` | string | `'md'` | Size variant: `sm`, `md`, `lg` |
| `data-dropdown-trigger` | string | required | Must match parent dropdown id |

### Dropdown Content

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `'md'` | Width size: `sm`, `md`, `lg` |

### Dropdown Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `disabled` | boolean | `false` | Disable the item |
| `href` | string | `null` | Make item a link |
| `icon` | string | `null` | Leading icon component name |
| `iconTrailing` | string | `null` | Trailing icon component name |
| `destructive` | boolean | `false` | Apply destructive styling |

### Dropdown Checkbox Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | required | Checkbox value |
| `checked` | boolean | `false` | Initial checked state |
| `disabled` | boolean | `false` | Disable the checkbox |
| `name` | string | `null` | Name for Livewire binding |

### Dropdown Radio Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | required | Radio value |
| `checked` | boolean | `false` | Initial checked state |
| `disabled` | boolean | `false` | Disable the radio |
| `name` | string | `null` | Group name for Livewire binding |

### Dropdown Submenu

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | string | required | Submenu trigger label |
| `icon` | string | `null` | Leading icon |
| `disabled` | boolean | `false` | Disable the submenu |
| `trigger` | string | `'hover'` | Open trigger: `hover`, `click`, `both` |
| `placement` | string | `'right-start'` | Submenu placement |
| `offset` | number | `4` | Distance from parent item |

## Trigger Variants

```blade
<x-strata::dropdown.trigger data-dropdown-trigger="menu-1" variant="default">
    Default
</x-strata::dropdown.trigger>

<x-strata::dropdown.trigger data-dropdown-trigger="menu-2" variant="primary">
    Primary
</x-strata::dropdown.trigger>

<x-strata::dropdown.trigger data-dropdown-trigger="menu-3" variant="ghost">
    Ghost
</x-strata::dropdown.trigger>

<x-strata::dropdown.trigger data-dropdown-trigger="menu-4" variant="text">
    Text
</x-strata::dropdown.trigger>
```

## With Icons

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger data-dropdown-trigger="icons-1">
        Actions
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.item icon="save">Save</x-strata::dropdown.item>
        <x-strata::dropdown.item icon="download">Export</x-strata::dropdown.item>
        <x-strata::dropdown.item icon="share" iconTrailing="arrow-right">
            Share
        </x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## With Sections

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger data-dropdown-trigger="sections-1">
        Menu
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.label>Account</x-strata::dropdown.label>
        <x-strata::dropdown.item icon="user">Profile</x-strata::dropdown.item>
        <x-strata::dropdown.item icon="settings">Settings</x-strata::dropdown.item>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.label>Actions</x-strata::dropdown.label>
        <x-strata::dropdown.item icon="refresh">Refresh</x-strata::dropdown.item>
        <x-strata::dropdown.item icon="trash" destructive>Delete</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Checkbox Items

```blade
<div x-data="{ selectedFeatures: @entangle('selectedFeatures') }">
    <x-strata::dropdown>
        <x-strata::dropdown.trigger data-dropdown-trigger="features-1">
            Features
        </x-strata::dropdown.trigger>

        <x-strata::dropdown.content>
            <x-strata::dropdown.checkbox-item
                value="notifications"
                name="selectedFeatures"
                wire:model="selectedFeatures"
            >
                Enable Notifications
            </x-strata::dropdown.checkbox-item>

            <x-strata::dropdown.checkbox-item
                value="auto-save"
                name="selectedFeatures"
                wire:model="selectedFeatures"
            >
                Auto Save
            </x-strata::dropdown.checkbox-item>

            <x-strata::dropdown.checkbox-item
                value="dark-mode"
                name="selectedFeatures"
                wire:model="selectedFeatures"
            >
                Dark Mode
            </x-strata::dropdown.checkbox-item>
        </x-strata::dropdown.content>
    </x-strata::dropdown>
</div>
```

## Radio Items

```blade
<div x-data="{ sortOrder: @entangle('sortOrder') }">
    <x-strata::dropdown>
        <x-strata::dropdown.trigger data-dropdown-trigger="sort-1">
            Sort By
        </x-strata::dropdown.trigger>

        <x-strata::dropdown.content>
            <x-strata::dropdown.radio-item
                value="newest"
                name="sortOrder"
                wire:model="sortOrder"
            >
                Newest First
            </x-strata::dropdown.radio-item>

            <x-strata::dropdown.radio-item
                value="oldest"
                name="sortOrder"
                wire:model="sortOrder"
            >
                Oldest First
            </x-strata::dropdown.radio-item>

            <x-strata::dropdown.radio-item
                value="alphabetical"
                name="sortOrder"
                wire:model="sortOrder"
            >
                Alphabetical
            </x-strata::dropdown.radio-item>
        </x-strata::dropdown.content>
    </x-strata::dropdown>
</div>
```

## Nested Submenus

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger data-dropdown-trigger="nested-1">
        File
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.item icon="file">New File</x-strata::dropdown.item>
        <x-strata::dropdown.item icon="folder">New Folder</x-strata::dropdown.item>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.submenu label="Export" icon="download">
            <x-strata::dropdown.item icon="file">Export as PDF</x-strata::dropdown.item>
            <x-strata::dropdown.item icon="file">Export as CSV</x-strata::dropdown.item>
            <x-strata::dropdown.item icon="file">Export as JSON</x-strata::dropdown.item>
        </x-strata::dropdown.submenu>

        <x-strata::dropdown.submenu label="Import" icon="upload">
            <x-strata::dropdown.item icon="file">Import CSV</x-strata::dropdown.item>
            <x-strata::dropdown.item icon="file">Import JSON</x-strata::dropdown.item>
        </x-strata::dropdown.submenu>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.item icon="save">Save</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Submenu Trigger Modes

```blade
<!-- Hover trigger (default) -->
<x-strata::dropdown.submenu label="Hover Menu" trigger="hover">
    <x-strata::dropdown.item>Item 1</x-strata::dropdown.item>
</x-strata::dropdown.submenu>

<!-- Click trigger -->
<x-strata::dropdown.submenu label="Click Menu" trigger="click">
    <x-strata::dropdown.item>Item 1</x-strata::dropdown.item>
</x-strata::dropdown.submenu>

<!-- Both hover and click -->
<x-strata::dropdown.submenu label="Both Menu" trigger="both">
    <x-strata::dropdown.item>Item 1</x-strata::dropdown.item>
</x-strata::dropdown.submenu>
```

## Placement Options

```blade
<!-- Bottom start (default) -->
<x-strata::dropdown placement="bottom-start">
    ...
</x-strata::dropdown>

<!-- Bottom end -->
<x-strata::dropdown placement="bottom-end">
    ...
</x-strata::dropdown>

<!-- Top start -->
<x-strata::dropdown placement="top-start">
    ...
</x-strata::dropdown>

<!-- Right start (for submenus) -->
<x-strata::dropdown placement="right-start">
    ...
</x-strata::dropdown>
```

## Keyboard Navigation

The dropdown component implements full ARIA menu pattern keyboard navigation:

| Key | Action |
|-----|--------|
| **Space/Enter** | Open dropdown or activate highlighted item |
| **Escape** | Close dropdown |
| **Arrow Down** | Highlight next item |
| **Arrow Up** | Highlight previous item |
| **Arrow Right** | Open submenu (when on submenu item) |
| **Arrow Left** | Close submenu |
| **Home** | Highlight first item |
| **End** | Highlight last item |
| **Tab** | Close dropdown and move focus |
| **A-Z** | Type-ahead to jump to items (500ms buffer) |

## Disabled Items

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger data-dropdown-trigger="disabled-1">
        Actions
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.item icon="edit">Edit</x-strata::dropdown.item>
        <x-strata::dropdown.item icon="copy" disabled>
            Duplicate (Pro Only)
        </x-strata::dropdown.item>
        <x-strata::dropdown.item icon="trash" destructive>Delete</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Size Variants

```blade
<!-- Small -->
<x-strata::dropdown size="sm">
    <x-strata::dropdown.trigger data-dropdown-trigger="sm-1" size="sm">
        Small
    </x-strata::dropdown.trigger>
    <x-strata::dropdown.content size="sm">
        <x-strata::dropdown.item>Item</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>

<!-- Medium (default) -->
<x-strata::dropdown size="md">
    <x-strata::dropdown.trigger data-dropdown-trigger="md-1" size="md">
        Medium
    </x-strata::dropdown.trigger>
    <x-strata::dropdown.content size="md">
        <x-strata::dropdown.item>Item</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>

<!-- Large -->
<x-strata::dropdown size="lg">
    <x-strata::dropdown.trigger data-dropdown-trigger="lg-1" size="lg">
        Large
    </x-strata::dropdown.trigger>
    <x-strata::dropdown.content size="lg">
        <x-strata::dropdown.item>Item</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Livewire Integration

The dropdown works seamlessly with Livewire for form controls:

```php
// In your Livewire component
class Settings extends Component
{
    public array $enabledFeatures = ['notifications'];
    public string $theme = 'light';

    public function render()
    {
        return view('livewire.settings');
    }
}
```

```blade
<!-- In your view -->
<div>
    <x-strata::dropdown>
        <x-strata::dropdown.trigger data-dropdown-trigger="settings-1">
            Settings
        </x-strata::dropdown.trigger>

        <x-strata::dropdown.content>
            <x-strata::dropdown.label>Features</x-strata::dropdown.label>

            <x-strata::dropdown.checkbox-item
                value="notifications"
                name="enabledFeatures"
                wire:model.live="enabledFeatures"
            >
                Notifications
            </x-strata::dropdown.checkbox-item>

            <x-strata::dropdown.checkbox-item
                value="auto-save"
                name="enabledFeatures"
                wire:model.live="enabledFeatures"
            >
                Auto Save
            </x-strata::dropdown.checkbox-item>

            <x-strata::dropdown.divider />

            <x-strata::dropdown.label>Theme</x-strata::dropdown.label>

            <x-strata::dropdown.radio-item
                value="light"
                name="theme"
                wire:model.live="theme"
            >
                Light
            </x-strata::dropdown.radio-item>

            <x-strata::dropdown.radio-item
                value="dark"
                name="theme"
                wire:model.live="theme"
            >
                Dark
            </x-strata::dropdown.radio-item>
        </x-strata::dropdown.content>
    </x-strata::dropdown>

    <p>Features: {{ implode(', ', $enabledFeatures) }}</p>
    <p>Theme: {{ $theme }}</p>
</div>
```

## Real-World Examples

### User Account Menu

```blade
<x-strata::dropdown placement="bottom-end">
    <x-strata::dropdown.trigger data-dropdown-trigger="account-1" variant="ghost">
        <x-strata::avatar src="/path/to/avatar.jpg" size="sm" />
        <span>John Doe</span>
        <x-strata::icon.chevron-down class="w-4 h-4" />
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.label>Account</x-strata::dropdown.label>
        <x-strata::dropdown.item icon="user" href="/profile">
            Profile
        </x-strata::dropdown.item>
        <x-strata::dropdown.item icon="settings" href="/settings">
            Settings
        </x-strata::dropdown.item>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.label>Preferences</x-strata::dropdown.label>
        <x-strata::dropdown.checkbox-item
            value="email"
            name="notifications"
            wire:model="notifications"
        >
            Email Notifications
        </x-strata::dropdown.checkbox-item>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.item icon="log-out" destructive wire:click="logout">
            Sign Out
        </x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

### Table Row Actions

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger data-dropdown-trigger="row-{{ $item->id }}" variant="ghost" size="sm">
        <x-strata::icon.more-vertical class="w-4 h-4" />
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content size="sm">
        <x-strata::dropdown.item icon="eye" wire:click="view({{ $item->id }})">
            View
        </x-strata::dropdown.item>
        <x-strata::dropdown.item icon="edit" wire:click="edit({{ $item->id }})">
            Edit
        </x-strata::dropdown.item>
        <x-strata::dropdown.item icon="copy" wire:click="duplicate({{ $item->id }})">
            Duplicate
        </x-strata::dropdown.item>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.submenu label="Export" icon="download" trigger="click">
            <x-strata::dropdown.item wire:click="exportPdf({{ $item->id }})">
                PDF
            </x-strata::dropdown.item>
            <x-strata::dropdown.item wire:click="exportCsv({{ $item->id }})">
                CSV
            </x-strata::dropdown.item>
        </x-strata::dropdown.submenu>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.item
            icon="trash"
            destructive
            wire:click="delete({{ $item->id }})"
            wire:confirm="Are you sure?"
        >
            Delete
        </x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Accessibility

The dropdown component is fully accessible and follows ARIA authoring practices:

- **ARIA Roles**: Proper menu, menuitem, menuitemcheckbox, menuitemradio roles
- **Keyboard Navigation**: Full keyboard support with arrow keys, Home/End, type-ahead
- **Focus Management**: Focus trap when open, returns focus on close
- **Screen Readers**: Proper labeling and state announcements
- **Visual Indicators**: Clear hover, focus, and active states

## Mobile Considerations

On mobile devices (< 640px), the Positionable module automatically disables advanced positioning and uses default layout behavior for better mobile UX.
