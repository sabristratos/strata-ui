# Table Component

A fully-featured, accessible table component with sorting, selection, loading states, and responsive mobile layouts.

## Features

- 🎨 Three variants: bordered, striped, minimal
- 📏 Three sizes: sm, md, lg
- 🔄 Sortable columns with Livewire integration
- ✅ Row selection with bulk actions
- ⏳ Built-in loading states
- 📭 Empty state handling
- 📱 Mobile-responsive stacked layout
- ♿ Fully accessible (WCAG 2.1 AA compliant)
- ⌨️ Complete keyboard navigation
- 🌗 Dark mode support

## Basic Usage

```blade
<x-strata::table>
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>Name</x-strata::table.head-cell>
            <x-strata::table.head-cell>Email</x-strata::table.head-cell>
            <x-strata::table.head-cell>Role</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        @foreach($users as $user)
            <x-strata::table.row wire:key="user-{{ $user->id }}">
                <x-strata::table.cell data-label="Name">{{ $user->name }}</x-strata::table.cell>
                <x-strata::table.cell data-label="Email">{{ $user->email }}</x-strata::table.cell>
                <x-strata::table.cell data-label="Role">{{ $user->role }}</x-strata::table.cell>
            </x-strata::table.row>
        @endforeach
    </x-strata::table.body>
</x-strata::table>
```

## Component Props

### Table (Main Component)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'bordered'` | Visual style: `'bordered'`, `'striped'`, `'minimal'` |
| `size` | string | `'md'` | Size: `'sm'`, `'md'`, `'lg'` |
| `hoverable` | boolean | `true` | Enable row hover effect |
| `striped` | boolean | `null` | Enable striped rows (auto-true for striped variant) |
| `responsive` | string\|boolean | `'stacked'` | Responsive behavior: `'stacked'`, `'scroll'`, `true`, `false` |
| `sticky` | boolean | `false` | Enable sticky table header |
| `loading` | boolean | `false` | Show loading overlay |

### Table.head-cell

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `sortable` | boolean | `false` | Enable column sorting |
| `column` | string | `null` | Column name for sorting (required if sortable) |
| `sortColumn` | string | `null` | Currently sorted column |
| `sortDirection` | string | `null` | Sort direction: `'asc'` or `'desc'` |
| `align` | string | `'left'` | Text alignment: `'left'`, `'center'`, `'right'` |

### Table.cell

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `align` | string | `'left'` | Text alignment: `'left'`, `'center'`, `'right'` |
| `data-label` | string | - | **Required for mobile**: Column label for stacked layout |

### Table.row

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `selected` | boolean | `false` | Highlight row as selected |

### Table.empty

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `message` | string | `'No data available'` | Empty state message |
| `icon` | string | `'inbox'` | Icon name from Strata icons |
| `colspan` | integer | `null` | Number of columns to span |

### Table.loading

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `message` | string | `'Loading...'` | Loading message |

## Variants

### Bordered (Default)

```blade
<x-strata::table variant="bordered">
    <!-- Full borders around table and cells -->
</x-strata::table>
```

### Striped

```blade
<x-strata::table variant="striped">
    <!-- Alternating row colors -->
</x-strata::table>
```

### Minimal

```blade
<x-strata::table variant="minimal">
    <!-- No borders, clean look -->
</x-strata::table>
```

## Sortable Columns

```php
// Livewire Component
class UserTable extends Component
{
    public string $sortColumn = 'name';
    public string $sortDirection = 'asc';

    public function sortBy(string $column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }
}
```

```blade
<x-strata::table.head-cell
    sortable
    column="name"
    :sortColumn="$sortColumn"
    :sortDirection="$sortDirection"
>
    Name
</x-strata::table.head-cell>
```

## Row Selection

```php
// Livewire Component
public array $selected = [];

public function toggleSelection(int $id): void
{
    if (in_array($id, $this->selected)) {
        $this->selected = array_values(array_diff($this->selected, [$id]));
    } else {
        $this->selected[] = $id;
    }
}

public function toggleSelectAll(): void
{
    if (count($this->selected) === count($this->users)) {
        $this->selected = [];
    } else {
        $this->selected = array_column($this->users, 'id');
    }
}
```

```blade
<x-strata::table.header>
    <x-strata::table.row>
        <x-strata::table.head-cell class="w-12">
            <input type="checkbox" wire:click="toggleSelectAll" />
        </x-strata::table.head-cell>
        <!-- Other headers -->
    </x-strata::table.row>
</x-strata::table.header>

<x-strata::table.body>
    @foreach($users as $user)
        <x-strata::table.row :selected="in_array($user->id, $selected)">
            <x-strata::table.cell data-label="Select">
                <input type="checkbox" wire:click="toggleSelection({{ $user->id }})" />
            </x-strata::table.cell>
            <!-- Other cells -->
        </x-strata::table.row>
    @endforeach
</x-strata::table.body>
```

## Loading State

```blade
<x-strata::table :loading="$isLoading">
    <!-- Table content -->
</x-strata::table>
```

Or use the loading component directly:

```blade
<x-strata::table>
    @if($loading)
        <x-strata::table.loading message="Fetching data..." />
    @endif
    <!-- Table content -->
</x-strata::table>
```

## Empty State

```blade
<x-strata::table.body>
    @if(count($users) === 0)
        <x-strata::table.empty colspan="5">
            <p class="text-base font-medium">No users found</p>
            <p class="text-sm text-muted-foreground mt-1">Get started by adding your first user.</p>
        </x-strata::table.empty>
    @else
        @foreach($users as $user)
            <!-- Rows -->
        @endforeach
    @endif
</x-strata::table.body>
```

## Table Footer

```blade
<x-strata::table.footer>
    <x-strata::table.row>
        <x-strata::table.cell class="font-semibold">Total</x-strata::table.cell>
        <x-strata::table.cell align="right" class="font-semibold">$1,234</x-strata::table.cell>
    </x-strata::table.row>
</x-strata::table.footer>
```

## Responsive Mobile Layout

The table automatically transforms into a stacked card layout on mobile devices (< 640px). Each cell must have a `data-label` attribute:

```blade
<x-strata::table responsive="stacked">
    <x-strata::table.body>
        <x-strata::table.row>
            <x-strata::table.cell data-label="Name">John Doe</x-strata::table.cell>
            <x-strata::table.cell data-label="Email">john@example.com</x-strata::table.cell>
            <x-strata::table.cell data-label="Role">Admin</x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.body>
</x-strata::table>
```

For horizontal scroll instead:

```blade
<x-strata::table responsive="scroll">
    <!-- Table content -->
</x-strata::table>
```

## Sticky Header

```blade
<x-strata::table sticky>
    <!-- Table content -->
</x-strata::table>
```

## Cell Alignment

```blade
<x-strata::table.head-cell align="right">Price</x-strata::table.head-cell>
<x-strata::table.cell align="right" data-label="Price">$99.99</x-strata::table.cell>
```

## Accessibility

The table component is fully accessible:

- ✅ Proper ARIA attributes (`aria-sort`, `aria-selected`)
- ✅ Keyboard navigation (Tab, Enter, Space for sortable headers)
- ✅ Focus states on interactive elements
- ✅ Screen reader support with `scope="col"` on headers
- ✅ Semantic HTML (`<table>`, `<thead>`, `<tbody>`, `<tfoot>`)

### Keyboard Navigation

- **Tab**: Navigate between sortable headers
- **Enter/Space**: Trigger sorting on focused header
- **Shift+Tab**: Navigate backwards

## Best Practices

1. **Always use `wire:key`** on rows when using Livewire:
   ```blade
   <x-strata::table.row wire:key="user-{{ $user->id }}">
   ```

2. **Add `data-label` to all cells** for mobile responsiveness:
   ```blade
   <x-strata::table.cell data-label="Name">{{ $user->name }}</x-strata::table.cell>
   ```

3. **Use compact columns** for checkboxes and actions:
   ```blade
   <x-strata::table.head-cell class="w-12">Select</x-strata::table.head-cell>
   ```

4. **Pass column prop** to sortable headers:
   ```blade
   <x-strata::table.head-cell sortable column="name">Name</x-strata::table.head-cell>
   ```

## CSS Variables

Customize table colors by overriding these CSS variables:

```css
--color-table-header: light-dark(var(--color-neutral-50), var(--color-neutral-800));
--color-table-header-foreground: light-dark(var(--color-neutral-700), var(--color-neutral-200));
--color-table-border: var(--color-border);
--color-table-row-hover: light-dark(var(--color-neutral-100), var(--color-neutral-800));
--color-table-row-selected: light-dark(var(--color-primary-50), oklch(from var(--color-primary-900) l c h / 0.2));
--color-table-footer: light-dark(var(--color-neutral-50), var(--color-neutral-800));
--color-table-footer-foreground: light-dark(var(--color-neutral-700), var(--color-neutral-200));
```

## Complete Example

```blade
<x-strata::table
    variant="bordered"
    size="md"
    sticky
    :loading="$loading"
>
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell class="w-12">
                <input type="checkbox" wire:click="toggleSelectAll" />
            </x-strata::table.head-cell>
            <x-strata::table.head-cell
                sortable
                column="name"
                :sortColumn="$sortColumn"
                :sortDirection="$sortDirection"
            >
                Name
            </x-strata::table.head-cell>
            <x-strata::table.head-cell
                sortable
                column="email"
                :sortColumn="$sortColumn"
                :sortDirection="$sortDirection"
            >
                Email
            </x-strata::table.head-cell>
            <x-strata::table.head-cell align="right">Actions</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        @if(count($users) === 0)
            <x-strata::table.empty colspan="4" />
        @else
            @foreach($users as $user)
                <x-strata::table.row
                    wire:key="user-{{ $user->id }}"
                    :selected="in_array($user->id, $selected)"
                >
                    <x-strata::table.cell data-label="Select">
                        <input type="checkbox" wire:click="toggleSelection({{ $user->id }})" />
                    </x-strata::table.cell>
                    <x-strata::table.cell data-label="Name">{{ $user->name }}</x-strata::table.cell>
                    <x-strata::table.cell data-label="Email">{{ $user->email }}</x-strata::table.cell>
                    <x-strata::table.cell align="right" data-label="Actions">
                        <button class="text-sm text-primary hover:underline">Edit</button>
                    </x-strata::table.cell>
                </x-strata::table.row>
            @endforeach
        @endif
    </x-strata::table.body>

    <x-strata::table.footer>
        <x-strata::table.row>
            <x-strata::table.cell colspan="3" class="font-semibold">
                Total: {{ count($users) }} users
            </x-strata::table.cell>
            <x-strata::table.cell></x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.footer>
</x-strata::table>
```
