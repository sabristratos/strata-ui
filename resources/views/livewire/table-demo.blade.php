<div class="space-y-12">
    <div>
        <h2 class="text-2xl font-bold mb-6">Table Component</h2>
        <p class="text-muted-foreground mb-8">
            A fully-featured, accessible table component with sorting, selection, loading states, and responsive mobile layouts.
        </p>
    </div>

    <div class="space-y-4">
        <h3 class="text-lg font-semibold">Interactive Controls</h3>
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Variant:</label>
                <select wire:model.live="variant" class="px-3 py-1 border border-border rounded-md text-sm">
                    <option value="bordered">Bordered</option>
                    <option value="striped">Striped</option>
                    <option value="minimal">Minimal</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Size:</label>
                <select wire:model.live="size" class="px-3 py-1 border border-border rounded-md text-sm">
                    <option value="sm">Small</option>
                    <option value="md">Medium</option>
                    <option value="lg">Large</option>
                </select>
            </div>

            <x-strata::checkbox wire:model.live="hoverable" size="sm">Hoverable</x-strata::checkbox>

            <x-strata::checkbox wire:model.live="loading" size="sm">Loading</x-strata::checkbox>

            <x-strata::checkbox wire:model.live="showEmpty" size="sm">Empty State</x-strata::checkbox>
        </div>

        @if(count($selected) > 0)
            <div class="bg-primary/10 border border-primary/20 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium">{{ count($selected) }} row(s) selected</span>
                    <button
                        wire:click="$set('selected', [])"
                        class="text-sm text-primary hover:underline"
                    >
                        Clear selection
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">User Management Table</h3>
        <x-strata::table
            :variant="$variant"
            :size="$size"
            :hoverable="$hoverable"
            :loading="$loading"
            sticky
        >
            <x-strata::table.header>
                <x-strata::table.row>
                    <x-strata::table.head-cell class="w-12">
                        <x-strata::checkbox
                            wire:click="toggleSelectAll"
                            :checked="$this->allSelected"
                            size="sm"
                        />
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
                    <x-strata::table.head-cell
                        sortable
                        column="role"
                        :sortColumn="$sortColumn"
                        :sortDirection="$sortDirection"
                    >
                        Role
                    </x-strata::table.head-cell>
                    <x-strata::table.head-cell
                        sortable
                        column="status"
                        :sortColumn="$sortColumn"
                        :sortDirection="$sortDirection"
                    >
                        Status
                    </x-strata::table.head-cell>
                    <x-strata::table.head-cell align="right">
                        Actions
                    </x-strata::table.head-cell>
                </x-strata::table.row>
            </x-strata::table.header>

            <x-strata::table.body>
                @if(count($this->users) === 0)
                    <x-strata::table.empty colspan="6">
                        <p class="text-base font-medium">No users found</p>
                        <p class="text-sm text-muted-foreground mt-1">Get started by adding your first user.</p>
                    </x-strata::table.empty>
                @else
                    @foreach($this->users as $user)
                        <x-strata::table.row
                            wire:key="user-{{ $user['id'] }}"
                            :selected="in_array($user['id'], $selected)"
                        >
                            <x-strata::table.cell data-label="Select">
                                <x-strata::checkbox
                                    wire:click="toggleSelection({{ $user['id'] }})"
                                    :checked="in_array($user['id'], $selected)"
                                    size="sm"
                                />
                            </x-strata::table.cell>
                            <x-strata::table.cell data-label="Name">
                                <div class="font-medium">{{ $user['name'] }}</div>
                            </x-strata::table.cell>
                            <x-strata::table.cell data-label="Email">
                                {{ $user['email'] }}
                            </x-strata::table.cell>
                            <x-strata::table.cell data-label="Role">
                                <x-strata::badge>{{ $user['role'] }}</x-strata::badge>
                            </x-strata::table.cell>
                            <x-strata::table.cell data-label="Status">
                                <x-strata::badge :variant="$user['status'] === 'Active' ? 'success' : 'secondary'">
                                    {{ $user['status'] }}
                                </x-strata::badge>
                            </x-strata::table.cell>
                            <x-strata::table.cell align="right" data-label="Actions">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="text-sm text-primary hover:underline">Edit</button>
                                    <button class="text-sm text-destructive hover:underline">Delete</button>
                                </div>
                            </x-strata::table.cell>
                        </x-strata::table.row>
                    @endforeach
                @endif
            </x-strata::table.body>
        </x-strata::table>
    </div>

    <div class="space-y-6">
        <div>
            <h3 class="text-lg font-semibold mb-4">Minimal Variant (No borders)</h3>
            <x-strata::table variant="minimal" size="sm">
                <x-strata::table.header>
                    <x-strata::table.row>
                        <x-strata::table.head-cell>Product</x-strata::table.head-cell>
                        <x-strata::table.head-cell align="center">Price</x-strata::table.head-cell>
                        <x-strata::table.head-cell align="right">Stock</x-strata::table.head-cell>
                    </x-strata::table.row>
                </x-strata::table.header>
                <x-strata::table.body>
                    <x-strata::table.row>
                        <x-strata::table.cell data-label="Product">Laptop Pro</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Price">$1,299</x-strata::table.cell>
                        <x-strata::table.cell align="right" data-label="Stock">45</x-strata::table.cell>
                    </x-strata::table.row>
                    <x-strata::table.row>
                        <x-strata::table.cell data-label="Product">Wireless Mouse</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Price">$29</x-strata::table.cell>
                        <x-strata::table.cell align="right" data-label="Stock">128</x-strata::table.cell>
                    </x-strata::table.row>
                    <x-strata::table.row>
                        <x-strata::table.cell data-label="Product">USB-C Cable</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Price">$12</x-strata::table.cell>
                        <x-strata::table.cell align="right" data-label="Stock">256</x-strata::table.cell>
                    </x-strata::table.row>
                </x-strata::table.body>
                <x-strata::table.footer>
                    <x-strata::table.row>
                        <x-strata::table.cell class="font-semibold">Total</x-strata::table.cell>
                        <x-strata::table.cell align="center" class="font-semibold">$1,340</x-strata::table.cell>
                        <x-strata::table.cell align="right" class="font-semibold">429 items</x-strata::table.cell>
                    </x-strata::table.row>
                </x-strata::table.footer>
            </x-strata::table>
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-4">Striped Variant</h3>
            <x-strata::table variant="striped">
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
                        <x-strata::table.cell data-label="Feature">Users</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Basic">Up to 5</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Pro">Up to 50</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Enterprise">Unlimited</x-strata::table.cell>
                    </x-strata::table.row>
                    <x-strata::table.row>
                        <x-strata::table.cell data-label="Feature">Storage</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Basic">10 GB</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Pro">100 GB</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Enterprise">1 TB</x-strata::table.cell>
                    </x-strata::table.row>
                    <x-strata::table.row>
                        <x-strata::table.cell data-label="Feature">Support</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Basic">Email</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Pro">Priority Email</x-strata::table.cell>
                        <x-strata::table.cell align="center" data-label="Enterprise">24/7 Phone</x-strata::table.cell>
                    </x-strata::table.row>
                </x-strata::table.body>
            </x-strata::table>
        </div>
    </div>

    <div class="bg-muted/50 border border-border rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-3">Responsive Mobile Layout</h3>
        <p class="text-sm text-muted-foreground mb-2">
            Resize your browser window to less than 640px width (or view on mobile) to see the table transform into a stacked card layout.
            Each row becomes a card with labels displayed on the left side.
        </p>
        <p class="text-sm text-muted-foreground">
            This is achieved using the <code class="px-1 py-0.5 bg-muted rounded text-xs">data-label</code> attribute on each cell,
            which becomes visible on mobile devices.
        </p>
    </div>
</div>
