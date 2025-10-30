<div class="space-y-12">

    <div>
        <h3 class="text-lg font-semibold mb-2">Bordered Variant with Sortable Columns</h3>
        <p class="text-sm text-muted-foreground mb-4">Click column headers to sort. Hover over rows for highlight effect.</p>

        <x-strata::table variant="bordered" size="md">
            <x-strata::table.header>
                <x-strata::table.row>
                    <x-strata::table.head-cell class="w-12">
                        <x-strata::checkbox wire:model.live="selectAll" />
                    </x-strata::table.head-cell>
                    <x-strata::table.head-cell
                        sortable
                        :sortColumn="$sortBy === 'name' ? $sortBy : null"
                        :sortDirection="$sortBy === 'name' ? $sortDirection : null"
                        wire:click="sort('name')"
                    >
                        Name
                    </x-strata::table.head-cell>
                    <x-strata::table.head-cell
                        sortable
                        :sortColumn="$sortBy === 'email' ? $sortBy : null"
                        :sortDirection="$sortBy === 'email' ? $sortDirection : null"
                        wire:click="sort('email')"
                    >
                        Email
                    </x-strata::table.head-cell>
                    <x-strata::table.head-cell
                        sortable
                        :sortColumn="$sortBy === 'role' ? $sortBy : null"
                        :sortDirection="$sortBy === 'role' ? $sortDirection : null"
                        wire:click="sort('role')"
                    >
                        Role
                    </x-strata::table.head-cell>
                    <x-strata::table.head-cell
                        sortable
                        :sortColumn="$sortBy === 'status' ? $sortBy : null"
                        :sortDirection="$sortBy === 'status' ? $sortDirection : null"
                        wire:click="sort('status')"
                    >
                        Status
                    </x-strata::table.head-cell>
                    <x-strata::table.head-cell align="right">
                        Actions
                    </x-strata::table.head-cell>
                </x-strata::table.row>
            </x-strata::table.header>

            <x-strata::table.body>
                @foreach($sortedUsers as $user)
                    <x-strata::table.row :selected="in_array($user['id'], $selectedRows)">
                        <x-strata::table.cell class="w-12" align="center">
                            <x-strata::checkbox
                                wire:model.live="selectedRows"
                                :value="$user['id']"
                            />
                        </x-strata::table.cell>
                        <x-strata::table.cell>
                            <span class="font-medium">{{ $user['name'] }}</span>
                        </x-strata::table.cell>
                        <x-strata::table.cell>
                            {{ $user['email'] }}
                        </x-strata::table.cell>
                        <x-strata::table.cell>
                            <x-strata::badge :variant="$user['role'] === 'Admin' ? 'primary' : 'secondary'">
                                {{ $user['role'] }}
                            </x-strata::badge>
                        </x-strata::table.cell>
                        <x-strata::table.cell>
                            <x-strata::badge :variant="$user['status'] === 'Active' ? 'success' : 'secondary'">
                                {{ $user['status'] }}
                            </x-strata::badge>
                        </x-strata::table.cell>
                        <x-strata::table.cell align="right">
                            <div class="flex items-center justify-end gap-2">
                                <x-strata::button.icon icon="pencil" size="sm">
                                </x-strata::button.icon>
                                <x-strata::button.icon icon="trash" variant="destructive" size="sm">
                                </x-strata::button.icon>
                            </div>
                        </x-strata::table.cell>
                    </x-strata::table.row>
                @endforeach
            </x-strata::table.body>
        </x-strata::table>

        @if(count($selectedRows) > 0)
            <div class="mt-4 p-4 bg-primary/10 border border-primary/20 rounded-lg">
                <p class="text-sm">
                    <span class="font-semibold">{{ count($selectedRows) }}</span> row(s) selected:
                    <span class="text-muted-foreground">{{ implode(', ', $selectedRows) }}</span>
                </p>
            </div>
        @endif
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-2">Striped Variant - Small Size</h3>
        <p class="text-sm text-muted-foreground mb-4">Compact table with alternating row colors.</p>

        <x-strata::table variant="striped" size="sm">
            <x-strata::table.header>
                <x-strata::table.row>
                    <x-strata::table.head-cell>Name</x-strata::table.head-cell>
                    <x-strata::table.head-cell>Email</x-strata::table.head-cell>
                    <x-strata::table.head-cell>Role</x-strata::table.head-cell>
                    <x-strata::table.head-cell>Status</x-strata::table.head-cell>
                </x-strata::table.row>
            </x-strata::table.header>

            <x-strata::table.body>
                @foreach(array_slice($sortedUsers, 0, 5) as $user)
                    <x-strata::table.row>
                        <x-strata::table.cell>{{ $user['name'] }}</x-strata::table.cell>
                        <x-strata::table.cell>{{ $user['email'] }}</x-strata::table.cell>
                        <x-strata::table.cell>{{ $user['role'] }}</x-strata::table.cell>
                        <x-strata::table.cell>{{ $user['status'] }}</x-strata::table.cell>
                    </x-strata::table.row>
                @endforeach
            </x-strata::table.body>
        </x-strata::table>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-2">Minimal Variant - Large Size</h3>
        <p class="text-sm text-muted-foreground mb-4">Clean design with generous spacing.</p>

        <x-strata::table variant="minimal" size="lg">
            <x-strata::table.header>
                <x-strata::table.row>
                    <x-strata::table.head-cell>Name</x-strata::table.head-cell>
                    <x-strata::table.head-cell>Email</x-strata::table.head-cell>
                    <x-strata::table.head-cell align="right">Role</x-strata::table.head-cell>
                </x-strata::table.row>
            </x-strata::table.header>

            <x-strata::table.body>
                @foreach(array_slice($sortedUsers, 0, 4) as $user)
                    <x-strata::table.row>
                        <x-strata::table.cell>
                            <span class="font-medium">{{ $user['name'] }}</span>
                        </x-strata::table.cell>
                        <x-strata::table.cell>
                            <span class="text-muted-foreground">{{ $user['email'] }}</span>
                        </x-strata::table.cell>
                        <x-strata::table.cell align="right">
                            <x-strata::badge>{{ $user['role'] }}</x-strata::badge>
                        </x-strata::table.cell>
                    </x-strata::table.row>
                @endforeach
            </x-strata::table.body>
        </x-strata::table>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-2">Table with Footer</h3>
        <p class="text-sm text-muted-foreground mb-4">Demonstrating table footer for totals or summaries.</p>

        <x-strata::table variant="bordered" size="md">
            <x-strata::table.header>
                <x-strata::table.row>
                    <x-strata::table.head-cell>Product</x-strata::table.head-cell>
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
                    <x-strata::table.cell align="right" class="font-medium">$1,998.00</x-strata::table.cell>
                </x-strata::table.row>
                <x-strata::table.row>
                    <x-strata::table.cell>Mouse</x-strata::table.cell>
                    <x-strata::table.cell align="right">5</x-strata::table.cell>
                    <x-strata::table.cell align="right">$29.00</x-strata::table.cell>
                    <x-strata::table.cell align="right" class="font-medium">$145.00</x-strata::table.cell>
                </x-strata::table.row>
                <x-strata::table.row>
                    <x-strata::table.cell>Keyboard</x-strata::table.cell>
                    <x-strata::table.cell align="right">3</x-strata::table.cell>
                    <x-strata::table.cell align="right">$79.00</x-strata::table.cell>
                    <x-strata::table.cell align="right" class="font-medium">$237.00</x-strata::table.cell>
                </x-strata::table.row>
            </x-strata::table.body>

            <x-strata::table.footer>
                <x-strata::table.row>
                    <x-strata::table.cell colspan="3" align="right" class="font-semibold">
                        Grand Total
                    </x-strata::table.cell>
                    <x-strata::table.cell align="right" class="font-bold text-lg">
                        $2,380.00
                    </x-strata::table.cell>
                </x-strata::table.row>
            </x-strata::table.footer>
        </x-strata::table>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-2">Sticky Header (Scroll to Test)</h3>
        <p class="text-sm text-muted-foreground mb-4">Header stays visible while scrolling through long tables.</p>

        <div class="max-h-96 overflow-y-auto border border-border rounded-lg">
            <x-strata::table variant="bordered" size="md" sticky :responsive="false">
                <x-strata::table.header>
                    <x-strata::table.row>
                        <x-strata::table.head-cell>Name</x-strata::table.head-cell>
                        <x-strata::table.head-cell>Email</x-strata::table.head-cell>
                        <x-strata::table.head-cell>Role</x-strata::table.head-cell>
                        <x-strata::table.head-cell>Status</x-strata::table.head-cell>
                    </x-strata::table.row>
                </x-strata::table.header>

                <x-strata::table.body>
                    @for($i = 0; $i < 20; $i++)
                        @foreach($sortedUsers as $user)
                            <x-strata::table.row>
                                <x-strata::table.cell>{{ $user['name'] }}</x-strata::table.cell>
                                <x-strata::table.cell>{{ $user['email'] }}</x-strata::table.cell>
                                <x-strata::table.cell>{{ $user['role'] }}</x-strata::table.cell>
                                <x-strata::table.cell>{{ $user['status'] }}</x-strata::table.cell>
                            </x-strata::table.row>
                        @endforeach
                    @endfor
                </x-strata::table.body>
            </x-strata::table>
        </div>
    </div>

</div>
