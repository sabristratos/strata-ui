# Dropdown

Accessible dropdown menus built with the native Popover API and CSS Anchor Positioning. Features keyboard navigation, typeahead search, nested submenus, and support for interactive items like checkboxes and radios.

## Dropdown Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `size` | string | `md` | `sm`, `md`, `lg` | Dropdown content size |
| `placement` | string | `bottom-start` | `top`, `top-start`, `top-end`, `bottom`, `bottom-start`, `bottom-end`, `left`, `left-start`, `left-end`, `right`, `right-start`, `right-end` | Dropdown position relative to trigger |
| `offset` | number | `8` | Any number | Distance in pixels between trigger and dropdown |

## Dropdown.Trigger Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `variant` | string | `default` | Any variant | Visual variant (unused, for future styling) |
| `size` | string | `md` | `sm`, `md`, `lg` | Trigger size (unused, for future styling) |

## Dropdown.Content Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `size` | string | `md` | `sm`, `md`, `lg` | Content panel size |

## Dropdown.Item Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `disabled` | boolean | `false` | `true`, `false` | Disable item interaction |
| `href` | string | `null` | Any URL | Makes item an anchor tag instead of button |
| `icon` | string | `null` | Any icon name | Leading icon (passed via prop, not slot) |
| `icon-trailing` | string | `null` | Any icon name | Trailing icon (passed via prop, not slot) |
| `destructive` | boolean | `false` | `true`, `false` | Apply destructive styling |

## Dropdown.Submenu Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `label` | string | `null` | Any string | Submenu trigger label text |
| `icon` | string | `null` | Any icon name | Leading icon for submenu trigger |
| `disabled` | boolean | `false` | `true`, `false` | Disable submenu interaction |
| `trigger` | string | `hover` | `hover`, `click`, `both` | How submenu opens |
| `placement` | string | `right-start` | `top`, `top-start`, `top-end`, `bottom`, `bottom-start`, `bottom-end`, `left`, `left-start`, `left-end`, `right`, `right-start`, `right-end` | Submenu position relative to parent item |
| `offset` | number | `4` | Any number | Distance in pixels between item and submenu |

## Dropdown.Label Props

No props. Renders section labels within dropdown content.

## Dropdown.Divider Props

No props. Renders horizontal dividers between dropdown sections.

## Dropdown.Checkbox-Item Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `value` | mixed | `null` | Any value | Checkbox value for forms |
| `checked` | boolean | `false` | `true`, `false` | Checked state |
| `disabled` | boolean | `false` | `true`, `false` | Disable checkbox interaction |
| `name` | string | `null` | Any string | Form input name attribute |

## Dropdown.Radio-Item Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `value` | mixed | `null` | Any value | Radio value for forms |
| `checked` | boolean | `false` | `true`, `false` | Checked state |
| `disabled` | boolean | `false` | `true`, `false` | Disable radio interaction |
| `name` | string | `null` | Any string | Form input name attribute |

## Example

```blade
{{-- User menu with submenus and interactive items --}}
<x-strata::dropdown placement="bottom-end" offset="8">
    <x-strata::dropdown.trigger>
        <x-strata::button.icon icon="user" aria-label="User Menu" />
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
            wire:model.live="preferences.notifications"
            value="notifications"
        >
            Enable Notifications
        </x-strata::dropdown.checkbox-item>

        <x-strata::dropdown.checkbox-item
            wire:model.live="preferences.darkMode"
            value="dark_mode"
        >
            Dark Mode
        </x-strata::dropdown.checkbox-item>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.submenu
            label="Theme"
            icon="palette"
            trigger="hover"
        >
            <x-strata::dropdown.radio-item
                wire:model.live="theme"
                value="light"
                name="theme"
            >
                Light Theme
            </x-strata::dropdown.radio-item>

            <x-strata::dropdown.radio-item
                wire:model.live="theme"
                value="dark"
                name="theme"
            >
                Dark Theme
            </x-strata::dropdown.radio-item>

            <x-strata::dropdown.radio-item
                wire:model.live="theme"
                value="auto"
                name="theme"
            >
                System Default
            </x-strata::dropdown.radio-item>
        </x-strata::dropdown.submenu>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.item
            icon="log-out"
            destructive
            wire:click="logout"
        >
            Sign Out
        </x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Keyboard Navigation

| Key | Action |
|-----|--------|
| `Space` / `Enter` | Open dropdown (when trigger focused) |
| `Escape` | Close dropdown |
| `ArrowDown` | Highlight next item |
| `ArrowUp` | Highlight previous item |
| `Home` | Highlight first item |
| `End` | Highlight last item |
| `ArrowRight` | Open submenu (when submenu item highlighted) |
| `ArrowLeft` | Close submenu and return to parent |
| `Enter` | Activate highlighted item |
| `a-z` / `0-9` | Typeahead search - jump to items starting with typed characters |

## Nested Submenus

Dropdowns support unlimited nesting levels. Submenus use the native Popover API with CSS Anchor Positioning for automatic placement:

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger>
        <x-strata::button>Actions</x-strata::button>
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.item icon="file">New File</x-strata::dropdown.item>

        <x-strata::dropdown.submenu label="Export" icon="download">
            <x-strata::dropdown.item icon="file-text">Export as PDF</x-strata::dropdown.item>
            <x-strata::dropdown.item icon="file-code">Export as CSV</x-strata::dropdown.item>

            <x-strata::dropdown.submenu label="Advanced" icon="settings">
                <x-strata::dropdown.item>Export with Metadata</x-strata::dropdown.item>
                <x-strata::dropdown.item>Export Encrypted</x-strata::dropdown.item>
            </x-strata::dropdown.submenu>
        </x-strata::dropdown.submenu>

        <x-strata::dropdown.item icon="trash" destructive>Delete</x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Livewire Integration

Dropdowns work seamlessly with Livewire for interactive items and actions:

```blade
<x-strata::dropdown>
    <x-strata::dropdown.trigger>
        <x-strata::button>Filter</x-strata::button>
    </x-strata::dropdown.trigger>

    <x-strata::dropdown.content>
        <x-strata::dropdown.label>Status</x-strata::dropdown.label>

        <x-strata::dropdown.checkbox-item
            wire:model.live="filters.active"
            value="active"
        >
            Active
        </x-strata::dropdown.checkbox-item>

        <x-strata::dropdown.checkbox-item
            wire:model.live="filters.pending"
            value="pending"
        >
            Pending
        </x-strata::dropdown.checkbox-item>

        <x-strata::dropdown.divider />

        <x-strata::dropdown.item
            wire:click="clearFilters"
            icon="x"
        >
            Clear All Filters
        </x-strata::dropdown.item>
    </x-strata::dropdown.content>
</x-strata::dropdown>
```

## Technical Implementation

The dropdown component leverages modern web standards for optimal performance and accessibility:

- **Native Popover API:** Main dropdown and submenus use the browser's native popover functionality
  - Auto-dismiss on outside click
  - Escape key closes automatically
  - Top layer rendering (no z-index conflicts)
  - Proper focus management
  - Light dismiss behavior

- **CSS Anchor Positioning:** Positioning handled by CSS Anchor Positioning specification
  - Automatic fallback positioning with `@position-try` rules
  - Intelligent repositioning when viewport space is limited
  - Configurable placement (12 placement options)
  - Configurable offset distance
  - No JavaScript positioning calculations
  - Dynamic anchor-name generation for unique instances

- **Keyboard Navigation:** Full ARIA-compliant keyboard support
  - Arrow keys for navigation
  - Typeahead search (type to jump to items)
  - Home/End for first/last item
  - ArrowRight/Left for submenu open/close
  - ARIA activedescendant pattern for screen readers

- **Livewire Integration:** Proper state management and morph handling
  - wire:model support on checkbox/radio items
  - wire:click support on regular items
  - wire:ignore.self prevents morph issues

- **Alpine.js Magic Helpers:** Global helpers for common operations
  - `$closeDropdown()` - Close nearest dropdown from any element inside
  - `$closePopover()` - Close nearest popover
  - `$closeModal()` - Close nearest modal/dialog

## Notes

- **Typeahead search:** Type any character to jump to items starting with that letter
- **Auto-close:** Clicking items automatically closes the dropdown (except checkbox/radio items)
- **Submenu triggers:** Use `trigger="hover"` (default), `trigger="click"`, or `trigger="both"`
- **Focus trap:** Focus stays within dropdown when open, preventing accidental background interaction
- **Nested support:** Submenus automatically close siblings when opened, allowing only one submenu open per level
- **Icons as props:** Pass icons via `icon` and `icon-trailing` props, never inside the item slot
- **Popover manual mode:** Submenus use `popover="manual"` for programmatic control (hover/click triggers)
- **Popover auto mode:** Main dropdown uses `popover="auto"` for automatic dismiss behavior
