<div class="space-y-12 p-8">
    <section class="space-y-4">
        <h2 class="text-2xl font-bold">Breadcrumbs Component</h2>
        <p class="text-muted-foreground">Navigation component showing the user's location in the site hierarchy.</p>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Basic Usage</h3>
        <div class="p-6 border rounded-lg bg-card">
            <x-strata::breadcrumbs>
                <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item active>Category</x-strata::breadcrumbs.item>
            </x-strata::breadcrumbs>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Variants</h3>
        <div class="space-y-4">
            <div class="p-6 border rounded-lg bg-card space-y-2">
                <p class="text-sm font-medium mb-2">Default</p>
                <x-strata::breadcrumbs variant="default">
                    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
                </x-strata::breadcrumbs>
            </div>

            <div class="p-6 border rounded-lg bg-card space-y-2">
                <p class="text-sm font-medium mb-2">Bold</p>
                <x-strata::breadcrumbs variant="bold">
                    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
                </x-strata::breadcrumbs>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Sizes</h3>
        <div class="space-y-4">
            <div class="p-6 border rounded-lg bg-card space-y-2">
                <p class="text-sm font-medium mb-2">Small</p>
                <x-strata::breadcrumbs size="sm">
                    <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
                </x-strata::breadcrumbs>
            </div>

            <div class="p-6 border rounded-lg bg-card space-y-2">
                <p class="text-sm font-medium mb-2">Medium (Default)</p>
                <x-strata::breadcrumbs size="md">
                    <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
                </x-strata::breadcrumbs>
            </div>

            <div class="p-6 border rounded-lg bg-card space-y-2">
                <p class="text-sm font-medium mb-2">Large</p>
                <x-strata::breadcrumbs size="lg">
                    <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
                </x-strata::breadcrumbs>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Separators</h3>
        <div class="space-y-4">
            <div class="p-6 border rounded-lg bg-card space-y-2">
                <p class="text-sm font-medium mb-2">Chevron (Default)</p>
                <x-strata::breadcrumbs separator="chevron-right">
                    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
                </x-strata::breadcrumbs>
            </div>

            <div class="p-6 border rounded-lg bg-card space-y-2">
                <p class="text-sm font-medium mb-2">Slash</p>
                <x-strata::breadcrumbs separator="slash">
                    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
                </x-strata::breadcrumbs>
            </div>

            <div class="p-6 border rounded-lg bg-card space-y-2">
                <p class="text-sm font-medium mb-2">Custom (→)</p>
                <x-strata::breadcrumbs separator="→">
                    <x-strata::breadcrumbs.item href="/">Home</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item href="/products">Products</x-strata::breadcrumbs.item>
                    <x-strata::breadcrumbs.separator />
                    <x-strata::breadcrumbs.item active>Current</x-strata::breadcrumbs.item>
                </x-strata::breadcrumbs>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">With Icons</h3>
        <div class="p-6 border rounded-lg bg-card">
            <x-strata::breadcrumbs>
                <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/settings" icon="settings">Settings</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item icon="user" active>Profile</x-strata::breadcrumbs.item>
            </x-strata::breadcrumbs>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Long Path with Collapse</h3>
        <div class="p-6 border rounded-lg bg-card">
            <x-strata::breadcrumbs :max-items="3">
                <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/level1">Level 1</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/level2">Level 2</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/level3">Level 3</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/level4">Level 4</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item active>Current Page</x-strata::breadcrumbs.item>
            </x-strata::breadcrumbs>
        </div>
        <p class="text-sm text-muted-foreground">Click the ellipsis to show all items</p>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Real-World Example: E-commerce</h3>
        <div class="p-6 border rounded-lg bg-card">
            <x-strata::breadcrumbs>
                <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/shop" icon="shopping-bag">Shop</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/shop/electronics">Electronics</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/shop/electronics/laptops">Laptops</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item active>MacBook Pro 16"</x-strata::breadcrumbs.item>
            </x-strata::breadcrumbs>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xl font-semibold">Real-World Example: Admin Dashboard</h3>
        <div class="p-6 border rounded-lg bg-card">
            <x-strata::breadcrumbs variant="bold" separator="slash">
                <x-strata::breadcrumbs.item href="/admin" icon="layout-dashboard">Dashboard</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/admin/users" icon="users">Users</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item href="/admin/users/123">John Doe</x-strata::breadcrumbs.item>
                <x-strata::breadcrumbs.separator />
                <x-strata::breadcrumbs.item icon="pencil" active>Edit</x-strata::breadcrumbs.item>
            </x-strata::breadcrumbs>
        </div>
    </section>
</div>
