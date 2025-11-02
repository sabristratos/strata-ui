<div class="space-y-16">
    <section>
        <h2 class="text-2xl font-bold mb-4">Pills Variant (Horizontal)</h2>

        <div class="space-y-8">
            <div>
                <h3 class="text-lg font-semibold mb-2">Medium Size (Default)</h3>
                <x-strata::tabs default="account">
                    <x-strata::tabs.list variant="pills" size="md">
                        <x-strata::tabs.trigger value="account" icon="user">
                            Account
                        </x-strata::tabs.trigger>
                        <x-strata::tabs.trigger value="password" icon="lock">
                            Password
                        </x-strata::tabs.trigger>
                        <x-strata::tabs.trigger value="notifications" icon="bell">
                            Notifications
                        </x-strata::tabs.trigger>
                    </x-strata::tabs.list>

                    <x-strata::tabs.content value="account">
                        <x-strata::card>
                            <x-strata::card.header>
                                <h3 class="text-lg font-semibold">Account Settings</h3>
                                <p class="text-sm text-muted-foreground">Manage your account settings here. Click save when you're done.</p>
                            </x-strata::card.header>
                            <x-strata::card.body class="space-y-4">
                                <div>
                                    <x-strata::form.label for="name">Name</x-strata::form.label>
                                    <x-strata::input id="name" value="John Doe" />
                                </div>
                                <div>
                                    <x-strata::form.label for="username">Username</x-strata::form.label>
                                    <x-strata::input id="username" value="@johndoe" />
                                </div>
                            </x-strata::card.body>
                            <x-strata::card.footer>
                                <x-strata::button>Save changes</x-strata::button>
                            </x-strata::card.footer>
                        </x-strata::card>
                    </x-strata::tabs.content>

                    <x-strata::tabs.content value="password">
                        <x-strata::card>
                            <x-strata::card.header>
                                <h3 class="text-lg font-semibold">Password Settings</h3>
                                <p class="text-sm text-muted-foreground">Change your password here. After saving, you'll be logged out.</p>
                            </x-strata::card.header>
                            <x-strata::card.body class="space-y-4">
                                <div>
                                    <x-strata::form.label for="current-password">Current Password</x-strata::form.label>
                                    <x-strata::input type="password" id="current-password" />
                                </div>
                                <div>
                                    <x-strata::form.label for="new-password">New Password</x-strata::form.label>
                                    <x-strata::input type="password" id="new-password" />
                                </div>
                            </x-strata::card.body>
                            <x-strata::card.footer>
                                <x-strata::button variant="destructive">Save password</x-strata::button>
                            </x-strata::card.footer>
                        </x-strata::card>
                    </x-strata::tabs.content>

                    <x-strata::tabs.content value="notifications">
                        <x-strata::card>
                            <x-strata::card.header>
                                <h3 class="text-lg font-semibold">Notification Settings</h3>
                                <p class="text-sm text-muted-foreground">Configure your notification preferences.</p>
                            </x-strata::card.header>
                            <x-strata::card.body class="space-y-4">
                                <x-strata::checkbox value="email">Email notifications</x-strata::checkbox>
                                <x-strata::checkbox value="push">Push notifications</x-strata::checkbox>
                                <x-strata::checkbox value="sms">SMS notifications</x-strata::checkbox>
                            </x-strata::card.body>
                            <x-strata::card.footer>
                                <x-strata::button>Save preferences</x-strata::button>
                            </x-strata::card.footer>
                        </x-strata::card>
                    </x-strata::tabs.content>
                </x-strata::tabs>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-2">Small Size</h3>
                <x-strata::tabs default="overview">
                    <x-strata::tabs.list variant="pills" size="sm">
                        <x-strata::tabs.trigger value="overview">Overview</x-strata::tabs.trigger>
                        <x-strata::tabs.trigger value="analytics">Analytics</x-strata::tabs.trigger>
                        <x-strata::tabs.trigger value="reports">Reports</x-strata::tabs.trigger>
                    </x-strata::tabs.list>

                    <x-strata::tabs.content value="overview">
                        <p class="text-sm text-muted-foreground">Overview content with small tabs...</p>
                    </x-strata::tabs.content>

                    <x-strata::tabs.content value="analytics">
                        <p class="text-sm text-muted-foreground">Analytics content...</p>
                    </x-strata::tabs.content>

                    <x-strata::tabs.content value="reports">
                        <p class="text-sm text-muted-foreground">Reports content...</p>
                    </x-strata::tabs.content>
                </x-strata::tabs>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-2">Large Size</h3>
                <x-strata::tabs default="dashboard">
                    <x-strata::tabs.list variant="pills" size="lg">
                        <x-strata::tabs.trigger value="dashboard" icon="layout-dashboard">Dashboard</x-strata::tabs.trigger>
                        <x-strata::tabs.trigger value="settings" icon="settings">Settings</x-strata::tabs.trigger>
                    </x-strata::tabs.list>

                    <x-strata::tabs.content value="dashboard">
                        <p class="text-muted-foreground">Dashboard content with large tabs...</p>
                    </x-strata::tabs.content>

                    <x-strata::tabs.content value="settings">
                        <p class="text-muted-foreground">Settings content...</p>
                    </x-strata::tabs.content>
                </x-strata::tabs>
            </div>
        </div>
    </section>

    <section>
        <h2 class="text-2xl font-bold mb-4">Underline Variant</h2>
        <x-strata::tabs default="all">
            <x-strata::tabs.list variant="underline">
                <x-strata::tabs.trigger value="all">All</x-strata::tabs.trigger>
                <x-strata::tabs.trigger value="active">Active</x-strata::tabs.trigger>
                <x-strata::tabs.trigger value="completed">Completed</x-strata::tabs.trigger>
                <x-strata::tabs.trigger value="archived" disabled>Archived</x-strata::tabs.trigger>
            </x-strata::tabs.list>

            <x-strata::tabs.content value="all">
                <div class="py-4">
                    <p class="text-muted-foreground">Showing all items...</p>
                </div>
            </x-strata::tabs.content>

            <x-strata::tabs.content value="active">
                <div class="py-4">
                    <p class="text-muted-foreground">Showing active items...</p>
                </div>
            </x-strata::tabs.content>

            <x-strata::tabs.content value="completed">
                <div class="py-4">
                    <p class="text-muted-foreground">Showing completed items...</p>
                </div>
            </x-strata::tabs.content>
        </x-strata::tabs>
    </section>

    <section>
        <h2 class="text-2xl font-bold mb-4">Default Variant</h2>
        <x-strata::tabs default="preview">
            <x-strata::tabs.list variant="default">
                <x-strata::tabs.trigger value="preview" icon="eye">Preview</x-strata::tabs.trigger>
                <x-strata::tabs.trigger value="code" icon="code">Code</x-strata::tabs.trigger>
                <x-strata::tabs.trigger value="settings" icon="settings">Settings</x-strata::tabs.trigger>
            </x-strata::tabs.list>

            <x-strata::tabs.content value="preview">
                <div class="py-4 border rounded-lg p-6">
                    <p>Preview mode - minimal styling variant</p>
                </div>
            </x-strata::tabs.content>

            <x-strata::tabs.content value="code">
                <div class="py-4 border rounded-lg p-6 bg-muted">
                    <code class="text-sm">Code view...</code>
                </div>
            </x-strata::tabs.content>

            <x-strata::tabs.content value="settings">
                <div class="py-4 border rounded-lg p-6">
                    <p>Settings panel...</p>
                </div>
            </x-strata::tabs.content>
        </x-strata::tabs>
    </section>

    <section>
        <h2 class="text-2xl font-bold mb-4">Vertical Orientation</h2>
        <x-strata::tabs default="profile" orientation="vertical">
            <x-strata::tabs.list variant="pills">
                <x-strata::tabs.trigger value="profile" icon="user">Profile</x-strata::tabs.trigger>
                <x-strata::tabs.trigger value="security" icon="shield">Security</x-strata::tabs.trigger>
                <x-strata::tabs.trigger value="billing" icon="credit-card">Billing</x-strata::tabs.trigger>
                <x-strata::tabs.trigger value="team" icon="users">Team</x-strata::tabs.trigger>
            </x-strata::tabs.list>

            <x-strata::tabs.content value="profile">
                <x-strata::card>
                    <x-strata::card.header>
                        <h3 class="text-lg font-semibold">Profile Settings</h3>
                    </x-strata::card.header>
                    <x-strata::card.body>
                        <p class="text-muted-foreground">Manage your profile information...</p>
                    </x-strata::card.body>
                </x-strata::card>
            </x-strata::tabs.content>

            <x-strata::tabs.content value="security">
                <x-strata::card>
                    <x-strata::card.header>
                        <h3 class="text-lg font-semibold">Security Settings</h3>
                    </x-strata::card.header>
                    <x-strata::card.body>
                        <p class="text-muted-foreground">Configure security options...</p>
                    </x-strata::card.body>
                </x-strata::card>
            </x-strata::tabs.content>

            <x-strata::tabs.content value="billing">
                <x-strata::card>
                    <x-strata::card.header>
                        <h3 class="text-lg font-semibold">Billing Information</h3>
                    </x-strata::card.header>
                    <x-strata::card.body>
                        <p class="text-muted-foreground">Manage your billing details...</p>
                    </x-strata::card.body>
                </x-strata::card>
            </x-strata::tabs.content>

            <x-strata::tabs.content value="team">
                <x-strata::card>
                    <x-strata::card.header>
                        <h3 class="text-lg font-semibold">Team Management</h3>
                    </x-strata::card.header>
                    <x-strata::card.body>
                        <p class="text-muted-foreground">Manage your team members...</p>
                    </x-strata::card.body>
                </x-strata::card>
            </x-strata::tabs.content>
        </x-strata::tabs>
    </section>
</div>
