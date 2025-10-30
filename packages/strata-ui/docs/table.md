# Table

A fully composable table component with support for sorting, selection, variants, and responsive design.

## Basic Usage

The table component is fully composable with separate components for each part:

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
            <x-strata::table.row>
                <x-strata::table.cell>{{ $user->name }}</x-strata::table.cell>
                <x-strata::table.cell>{{ $user->email }}</x-strata::table.cell>
                <x-strata::table.cell>{{ $user->role }}</x-strata::table.cell>
            </x-strata::table.row>
        @endforeach
    </x-strata::table.body>
</x-strata::table>
```

## Variants

### Bordered

Traditional table with borders around all cells:

```blade
<x-strata::table variant="bordered">
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>Product</x-strata::table.head-cell>
            <x-strata::table.head-cell>Price</x-strata::table.head-cell>
            <x-strata::table.head-cell>Stock</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        <x-strata::table.row>
            <x-strata::table.cell>Laptop</x-strata::table.cell>
            <x-strata::table.cell>$999.00</x-strata::table.cell>
            <x-strata::table.cell>In Stock</x-strata::table.cell>
        </x-strata::table.row>
        <x-strata::table.row>
            <x-strata::table.cell>Mouse</x-strata::table.cell>
            <x-strata::table.cell>$29.00</x-strata::table.cell>
            <x-strata::table.cell>Low Stock</x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.body>
</x-strata::table>
```

### Striped

Alternating row colors for improved readability:

```blade
<x-strata::table variant="striped">
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>Name</x-strata::table.head-cell>
            <x-strata::table.head-cell>Department</x-strata::table.head-cell>
            <x-strata::table.head-cell>Status</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        <x-strata::table.row>
            <x-strata::table.cell>Alice Johnson</x-strata::table.cell>
            <x-strata::table.cell>Engineering</x-strata::table.cell>
            <x-strata::table.cell>Active</x-strata::table.cell>
        </x-strata::table.row>
        <x-strata::table.row>
            <x-strata::table.cell>Bob Smith</x-strata::table.cell>
            <x-strata::table.cell>Marketing</x-strata::table.cell>
            <x-strata::table.cell>Active</x-strata::table.cell>
        </x-strata::table.row>
        <x-strata::table.row>
            <x-strata::table.cell>Carol White</x-strata::table.cell>
            <x-strata::table.cell>Sales</x-strata::table.cell>
            <x-strata::table.cell>Away</x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.body>
</x-strata::table>
```

### Minimal

Clean design without borders:

```blade
<x-strata::table variant="minimal">
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>Task</x-strata::table.head-cell>
            <x-strata::table.head-cell>Priority</x-strata::table.head-cell>
            <x-strata::table.head-cell>Due Date</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        <x-strata::table.row>
            <x-strata::table.cell>Fix bug in checkout</x-strata::table.cell>
            <x-strata::table.cell>High</x-strata::table.cell>
            <x-strata::table.cell>2024-03-15</x-strata::table.cell>
        </x-strata::table.row>
        <x-strata::table.row>
            <x-strata::table.cell>Update documentation</x-strata::table.cell>
            <x-strata::table.cell>Medium</x-strata::table.cell>
            <x-strata::table.cell>2024-03-20</x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.body>
</x-strata::table>
```

## Sizes

### Small

Compact padding for dense data:

```blade
<x-strata::table size="sm">
    <!-- Table content -->
</x-strata::table>
```

### Medium (Default)

Comfortable spacing:

```blade
<x-strata::table size="md">
    <!-- Table content -->
</x-strata::table>
```

### Large

Generous padding:

```blade
<x-strata::table size="lg">
    <!-- Table content -->
</x-strata::table>
```

## Sortable Columns

Make columns sortable by adding the `sortable` prop to head cells and using Livewire for state management:

```blade
<x-strata::table>
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell
                sortable
                :sortColumn="$sortBy === 'name' ? $sortBy : null"
                :sortDirection="$sortBy === 'name' ? $sortDirection : null"
                wire:click="sortBy('name')"
            >
                Name
            </x-strata::table.head-cell>
            <x-strata::table.head-cell
                sortable
                :sortColumn="$sortBy === 'email' ? $sortBy : null"
                :sortDirection="$sortBy === 'email' ? $sortDirection : null"
                wire:click="sortBy('email')"
            >
                Email
            </x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        @foreach($sortedUsers as $user)
            <x-strata::table.row>
                <x-strata::table.cell>{{ $user->name }}</x-strata::table.cell>
                <x-strata::table.cell>{{ $user->email }}</x-strata::table.cell>
            </x-strata::table.row>
        @endforeach
    </x-strata::table.body>
</x-strata::table>
```

**Livewire Component:**

```php
class UserTable extends Component
{
    public string $sortBy = 'name';
    public string $sortDirection = 'asc';

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }
}
```

## Row Selection

Add checkboxes for row selection:

```blade
<x-strata::table>
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>
                <x-strata::checkbox wire:model.live="selectAll" />
            </x-strata::table.head-cell>
            <x-strata::table.head-cell>Name</x-strata::table.head-cell>
            <x-strata::table.head-cell>Email</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        @foreach($users as $user)
            <x-strata::table.row :selected="in_array($user->id, $selectedRows)">
                <x-strata::table.cell>
                    <x-strata::checkbox
                        wire:model.live="selectedRows"
                        :value="$user->id"
                    />
                </x-strata::table.cell>
                <x-strata::table.cell>{{ $user->name }}</x-strata::table.cell>
                <x-strata::table.cell>{{ $user->email }}</x-strata::table.cell>
            </x-strata::table.row>
        @endforeach
    </x-strata::table.body>
</x-strata::table>
```

**Livewire Component:**

```php
public array $selectedRows = [];
public bool $selectAll = false;

public function updatedSelectAll(bool $value): void
{
    $this->selectedRows = $value
        ? $this->users->pluck('id')->toArray()
        : [];
}

public function updatedSelectedRows(): void
{
    $this->selectAll = count($this->selectedRows) === $this->users->count();
}
```

## Sticky Header

Keep the header visible when scrolling:

```blade
<div class="max-h-96 overflow-y-auto">
    <x-strata::table sticky :responsive="false">
        <x-strata::table.header>
            <x-strata::table.row>
                <x-strata::table.head-cell>Name</x-strata::table.head-cell>
                <x-strata::table.head-cell>Email</x-strata::table.head-cell>
            </x-strata::table.row>
        </x-strata::table.header>

        <x-strata::table.body>
            @foreach($manyUsers as $user)
                <x-strata::table.row>
                    <x-strata::table.cell>{{ $user->name }}</x-strata::table.cell>
                    <x-strata::table.cell>{{ $user->email }}</x-strata::table.cell>
                </x-strata::table.row>
            @endforeach
        </x-strata::table.body>
    </x-strata::table>
</div>
```

## Cell Alignment

Align cell content using the `align` prop:

```blade
<x-strata::table>
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>Product</x-strata::table.head-cell>
            <x-strata::table.head-cell align="center">Quantity</x-strata::table.head-cell>
            <x-strata::table.head-cell align="right">Price</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        <x-strata::table.row>
            <x-strata::table.cell>Laptop</x-strata::table.cell>
            <x-strata::table.cell align="center">2</x-strata::table.cell>
            <x-strata::table.cell align="right">$999.00</x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.body>
</x-strata::table>
```

## Compact Columns (Shrink-to-Fit)

To make a column take only the minimum width needed for its content (useful for checkboxes, icons, or actions), use `w-[1%]`:

```blade
<x-strata::table>
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell class="w-[1%]">
                <x-strata::checkbox wire:model="selectAll" />
            </x-strata::table.head-cell>
            <x-strata::table.head-cell>Name</x-strata::table.head-cell>
            <x-strata::table.head-cell>Email</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        @foreach($users as $user)
            <x-strata::table.row>
                <x-strata::table.cell class="w-[1%]">
                    <x-strata::checkbox :value="$user->id" />
                </x-strata::table.cell>
                <x-strata::table.cell>{{ $user->name }}</x-strata::table.cell>
                <x-strata::table.cell>{{ $user->email }}</x-strata::table.cell>
            </x-strata::table.row>
        @endforeach
    </x-strata::table.body>
</x-strata::table>
```

**How it works:** The `w-[1%]` class is a classic table technique that tells the column to shrink to the minimum width needed to fit its content plus padding. The column will expand to fit the content but won't take any extra space.

## Table Footer

Add a footer section for totals or summaries:

```blade
<x-strata::table>
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>Item</x-strata::table.head-cell>
            <x-strata::table.head-cell align="right">Quantity</x-strata::table.head-cell>
            <x-strata::table.head-cell align="right">Price</x-strata::table.head-cell>
            <x-strata::table.head-cell align="right">Total</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        <x-strata::table.row>
            <x-strata::table.cell>Laptop</x-strata::table.cell>
            <x-strata::table.cell align="right">2</x-strata::table.cell>
            <x-strata::table.cell align="right">$999.00</x-strata::table.cell>
            <x-strata::table.cell align="right">$1,998.00</x-strata::table.cell>
        </x-strata::table.row>
        <x-strata::table.row>
            <x-strata::table.cell>Mouse</x-strata::table.cell>
            <x-strata::table.cell align="right">5</x-strata::table.cell>
            <x-strata::table.cell align="right">$29.00</x-strata::table.cell>
            <x-strata::table.cell align="right">$145.00</x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.body>

    <x-strata::table.footer>
        <x-strata::table.row>
            <x-strata::table.cell colspan="3" align="right" class="font-semibold">
                Grand Total
            </x-strata::table.cell>
            <x-strata::table.cell align="right" class="font-bold">
                $2,143.00
            </x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.footer>
</x-strata::table>
```

## Sub-components

### table

Main table wrapper component.

### table.header

Table header section (`<thead>`).

### table.body

Table body section (`<tbody>`).

### table.footer

Table footer section (`<tfoot>`).

### table.row

Table row (`<tr>`).

### table.head-cell

Table header cell (`<th>`).

### table.cell

Table data cell (`<td>`).

### table.checkbox

Helper component that wraps a checkbox in a properly styled table cell.

## Props Reference

### Table Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `bordered` | Visual style: `bordered`, `striped`, `minimal` |
| `size` | string | `md` | Cell padding size: `sm`, `md`, `lg` |
| `hoverable` | boolean | `true` | Enable row hover effect |
| `striped` | boolean | `null` | Override striped rows (auto-enabled with `striped` variant) |
| `responsive` | boolean | `true` | Wrap table in horizontally scrollable container |
| `sticky` | boolean | `false` | Make header sticky when scrolling |

### Table.Row Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `selected` | boolean | `false` | Highlight row as selected |

### Table.Head-Cell Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `sortable` | boolean | `false` | Enable sortable functionality |
| `sortColumn` | string\|null | `null` | Current sort column (for active state) |
| `sortDirection` | string\|null | `null` | Current sort direction: `asc` or `desc` |
| `align` | string | `left` | Text alignment: `left`, `center`, `right` |

### Table.Cell Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `align` | string | `left` | Text alignment: `left`, `center`, `right` |

## Real-World Examples

### User Management Table

```blade
<x-strata::table variant="bordered">
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>User</x-strata::table.head-cell>
            <x-strata::table.head-cell>Role</x-strata::table.head-cell>
            <x-strata::table.head-cell>Status</x-strata::table.head-cell>
            <x-strata::table.head-cell align="right">Actions</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        @foreach($users as $user)
            <x-strata::table.row>
                <x-strata::table.cell>
                    <div class="flex items-center gap-3">
                        <x-strata::avatar :src="$user->avatar" size="sm" />
                        <div>
                            <div class="font-medium">{{ $user->name }}</div>
                            <div class="text-sm text-muted-foreground">{{ $user->email }}</div>
                        </div>
                    </div>
                </x-strata::table.cell>
                <x-strata::table.cell>
                    <x-strata::badge :variant="$user->role === 'admin' ? 'primary' : 'secondary'">
                        {{ $user->role }}
                    </x-strata::badge>
                </x-strata::table.cell>
                <x-strata::table.cell>
                    <x-strata::badge :variant="$user->active ? 'success' : 'secondary'">
                        {{ $user->active ? 'Active' : 'Inactive' }}
                    </x-strata::badge>
                </x-strata::table.cell>
                <x-strata::table.cell align="right">
                    <div class="flex items-center justify-end gap-2">
                        <x-strata::button size="sm" variant="ghost">Edit</x-strata::button>
                        <x-strata::button size="sm" variant="ghost">Delete</x-strata::button>
                    </div>
                </x-strata::table.cell>
            </x-strata::table.row>
        @endforeach
    </x-strata::table.body>
</x-strata::table>
```

### Invoice Table

```blade
<x-strata::table variant="minimal" size="lg">
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>Invoice</x-strata::table.head-cell>
            <x-strata::table.head-cell>Client</x-strata::table.head-cell>
            <x-strata::table.head-cell>Date</x-strata::table.head-cell>
            <x-strata::table.head-cell align="right">Amount</x-strata::table.head-cell>
            <x-strata::table.head-cell>Status</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        @foreach($invoices as $invoice)
            <x-strata::table.row>
                <x-strata::table.cell>
                    <span class="font-mono font-medium">#{{ $invoice->number }}</span>
                </x-strata::table.cell>
                <x-strata::table.cell>{{ $invoice->client->name }}</x-strata::table.cell>
                <x-strata::table.cell>{{ $invoice->date->format('M d, Y') }}</x-strata::table.cell>
                <x-strata::table.cell align="right" class="font-semibold">
                    ${{ number_format($invoice->amount, 2) }}
                </x-strata::table.cell>
                <x-strata::table.cell>
                    <x-strata::badge :variant="match($invoice->status) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'overdue' => 'destructive',
                        default => 'secondary'
                    }">
                        {{ ucfirst($invoice->status) }}
                    </x-strata::badge>
                </x-strata::table.cell>
            </x-strata::table.row>
        @endforeach
    </x-strata::table.body>
</x-strata::table>
```

### Product Comparison Table

```blade
<x-strata::table variant="striped" size="md">
    <x-strata::table.header>
        <x-strata::table.row>
            <x-strata::table.head-cell>Feature</x-strata::table.head-cell>
            <x-strata::table.head-cell align="center">Basic</x-strata::table.head-cell>
            <x-strata::table.head-cell align="center">Pro</x-strata::table.head-cell>
            <x-strata::table.head-cell align="center">Enterprise</x-strata::table.head-cell>
        </x-strata::table.row>
    </x-strata::table.header>

    <x-strata::table.body>
        <x-strata::table.row>
            <x-strata::table.cell>Storage</x-strata::table.cell>
            <x-strata::table.cell align="center">10 GB</x-strata::table.cell>
            <x-strata::table.cell align="center">100 GB</x-strata::table.cell>
            <x-strata::table.cell align="center">Unlimited</x-strata::table.cell>
        </x-strata::table.row>
        <x-strata::table.row>
            <x-strata::table.cell>Users</x-strata::table.cell>
            <x-strata::table.cell align="center">1</x-strata::table.cell>
            <x-strata::table.cell align="center">10</x-strata::table.cell>
            <x-strata::table.cell align="center">Unlimited</x-strata::table.cell>
        </x-strata::table.row>
        <x-strata::table.row>
            <x-strata::table.cell>Support</x-strata::table.cell>
            <x-strata::table.cell align="center">Email</x-strata::table.cell>
            <x-strata::table.cell align="center">Priority</x-strata::table.cell>
            <x-strata::table.cell align="center">24/7</x-strata::table.cell>
        </x-strata::table.row>
    </x-strata::table.body>
</x-strata::table>
```

## Accessibility

- Tables use semantic HTML elements (`<table>`, `<thead>`, `<tbody>`, `<tfoot>`, `<tr>`, `<th>`, `<td>`)
- Header cells (`<th>`) provide context for screen readers
- Sortable columns are keyboard accessible when using proper Livewire wire:click handlers
- Row selection checkboxes follow standard checkbox accessibility patterns

## Implementation Details

### Theme Tokens

The table component uses dedicated theme tokens for consistent styling:

- `bg-table-header` - Header background color
- `text-table-header-foreground` - Header text color
- `hover:bg-table-row-hover` - Row hover background
- `border-table-border` - Border color

These tokens automatically adapt to light and dark themes using the `light-dark()` CSS function.

### Responsive Behavior

By default, tables are wrapped in a horizontally scrollable container on smaller screens. Disable this by setting `responsive="false"` if you want to handle responsive behavior differently.

### State Management with Alpine.js

The table component uses Alpine.js to pass configuration (variant, size, hoverable, etc.) from the parent table component down to all child components. This ensures consistent styling without prop drilling.
