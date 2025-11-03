<div class="flex h-screen overflow-hidden">
        {{-- Sidebar Component --}}
        <x-strata::sidebar id="demo-sidebar" variant="persistent" width="md">
            {{-- Header with logo and search --}}
            <x-strata::sidebar.header search searchPlaceholder="Search menu...">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-md flex items-center justify-center">
                        <x-strata::icon.layers class="w-5 h-5 text-primary-foreground" />
                    </div>
                    <span class="font-semibold text-lg">Strata UI</span>
                </div>
            </x-strata::sidebar.header>

            {{-- Navigation Content --}}
            <x-strata::sidebar.nav>
                {{-- Main Section --}}
                <x-strata::sidebar.section title="Main">
                    <x-strata::sidebar.item
                        wire:click="setPage('dashboard')"
                        icon="home"
                        :active="$currentPage === 'dashboard'"
                    >
                        Dashboard
                    </x-strata::sidebar.item>

                    <x-strata::sidebar.item
                        wire:click="setPage('analytics')"
                        icon="bar-chart-2"
                        :active="$currentPage === 'analytics'"
                    >
                        Analytics
                    </x-strata::sidebar.item>

                    <x-strata::sidebar.item
                        wire:click="setPage('inbox')"
                        icon="inbox"
                        badge="12"
                        badgeVariant="destructive"
                        :active="$currentPage === 'inbox'"
                    >
                        Inbox
                    </x-strata::sidebar.item>

                    <x-strata::sidebar.item
                        wire:click="setPage('tasks')"
                        icon="check-square"
                        badge="5"
                        badgeVariant="warning"
                        :active="$currentPage === 'tasks'"
                    >
                        Tasks
                    </x-strata::sidebar.item>
                </x-strata::sidebar.section>

                {{-- Management Section --}}
                <x-strata::sidebar.section title="Management" divider>
                    <x-strata::sidebar.group title="Projects" icon="folder" defaultExpanded>
                        <x-strata::sidebar.item
                            wire:click="setPage('all-projects')"
                            icon="list"
                            :active="$currentPage === 'all-projects'"
                        >
                            All Projects
                        </x-strata::sidebar.item>

                        <x-strata::sidebar.item
                            wire:click="setPage('active-projects')"
                            icon="activity"
                            badge="8"
                            :active="$currentPage === 'active-projects'"
                        >
                            Active
                        </x-strata::sidebar.item>

                        <x-strata::sidebar.item
                            wire:click="setPage('archived-projects')"
                            icon="archive"
                            :active="$currentPage === 'archived-projects'"
                        >
                            Archived
                        </x-strata::sidebar.item>
                    </x-strata::sidebar.group>

                    <x-strata::sidebar.group title="Team" icon="users" badge="24">
                        <x-strata::sidebar.item
                            wire:click="setPage('team-members')"
                            icon="user"
                            :active="$currentPage === 'team-members'"
                        >
                            Members
                        </x-strata::sidebar.item>

                        <x-strata::sidebar.item
                            wire:click="setPage('team-roles')"
                            icon="shield"
                            :active="$currentPage === 'team-roles'"
                        >
                            Roles & Permissions
                        </x-strata::sidebar.item>

                        <x-strata::sidebar.item
                            wire:click="setPage('team-invites')"
                            icon="mail"
                            badge="3"
                            badgeVariant="info"
                            :active="$currentPage === 'team-invites'"
                        >
                            Invitations
                        </x-strata::sidebar.item>
                    </x-strata::sidebar.group>

                    <x-strata::sidebar.item
                        wire:click="setPage('calendar')"
                        icon="calendar"
                        :active="$currentPage === 'calendar'"
                    >
                        Calendar
                    </x-strata::sidebar.item>

                    <x-strata::sidebar.item
                        wire:click="setPage('files')"
                        icon="file-text"
                        :active="$currentPage === 'files'"
                    >
                        Documents
                    </x-strata::sidebar.item>
                </x-strata::sidebar.section>

                {{-- Settings Section --}}
                <x-strata::sidebar.section title="Settings" divider>
                    <x-strata::sidebar.group title="Preferences" icon="settings">
                        <x-strata::sidebar.item
                            wire:click="setPage('profile')"
                            icon="user"
                            :active="$currentPage === 'profile'"
                        >
                            Profile
                        </x-strata::sidebar.item>

                        <x-strata::sidebar.item
                            wire:click="setPage('security')"
                            icon="lock"
                            :active="$currentPage === 'security'"
                        >
                            Security
                        </x-strata::sidebar.item>

                        <x-strata::sidebar.item
                            wire:click="setPage('notifications')"
                            icon="bell"
                            :active="$currentPage === 'notifications'"
                        >
                            Notifications
                        </x-strata::sidebar.item>

                        <x-strata::sidebar.item
                            wire:click="setPage('billing')"
                            icon="credit-card"
                            :active="$currentPage === 'billing'"
                        >
                            Billing
                        </x-strata::sidebar.item>
                    </x-strata::sidebar.group>

                    <x-strata::sidebar.item
                        wire:click="setPage('help')"
                        icon="help-circle"
                        :active="$currentPage === 'help'"
                    >
                        Help & Support
                    </x-strata::sidebar.item>
                </x-strata::sidebar.section>
            </x-strata::sidebar.nav>

            {{-- Footer with user profile --}}
            <x-strata::sidebar.footer>
                <x-strata::sidebar.user-menu name="John Doe" email="john@example.com" fallback="JD">
                    <x-strata::dropdown.label>My Account</x-strata::dropdown.label>
                    <x-strata::dropdown.item wire:click="setPage('profile')" icon="user">
                        Profile
                    </x-strata::dropdown.item>
                    <x-strata::dropdown.item wire:click="setPage('settings')" icon="settings">
                        Settings
                    </x-strata::dropdown.item>
                    <x-strata::dropdown.divider />
                    <x-strata::dropdown.item icon="log-out">
                        Logout
                    </x-strata::dropdown.item>
                </x-strata::sidebar.user-menu>
            </x-strata::sidebar.footer>
        </x-strata::sidebar>

        {{-- Main Content Area --}}
        <main class="flex-1 overflow-y-auto">
            {{-- Top bar with toggle --}}
            <div class="sticky top-0 z-10 bg-card border-b border-border px-4 py-3">
                <div class="flex items-center gap-4">
                    <x-strata::sidebar.toggle target="demo-sidebar" variant="hamburger" class="md:hidden" />

                    <div class="flex-1">
                        <h1 class="text-2xl font-bold capitalize">{{ str_replace('-', ' ', $currentPage) }}</h1>
                        <p class="text-sm text-muted-foreground">Welcome to the Strata UI Sidebar demo</p>
                    </div>

                    <div class="hidden md:flex items-center gap-2">
                        <x-strata::sidebar.toggle target="demo-sidebar" variant="collapse" />
                    </div>
                </div>
            </div>

            {{-- Page Content --}}
            <div class="p-6 space-y-6">
                <x-strata::card>
                    <x-strata::card.header>
                        <h2 class="text-lg font-semibold">Current Page: {{ ucfirst(str_replace('-', ' ', $currentPage)) }}</h2>
                    </x-strata::card.header>

                    <x-strata::card.body>
                        <p class="text-muted-foreground mb-4">
                            This is a demo of the Strata UI Sidebar component. Try the following features:
                        </p>

                        <ul class="space-y-2 list-disc list-inside text-sm">
                            <li><strong>Click menu items</strong> to navigate and see active state changes</li>
                            <li><strong>Expand/collapse groups</strong> by clicking on parent items</li>
                            <li><strong>Use the search</strong> in the header to filter navigation items</li>
                            <li><strong>Toggle collapsed mode</strong> with the button in the top bar (desktop only)</li>
                            <li><strong>Resize your browser</strong> to see responsive behavior</li>
                            <li><strong>On mobile</strong>, use the hamburger menu to open/close</li>
                            <li><strong>Click the user profile</strong> in the footer to see dropdown menu</li>
                            <li><strong>Notice badges</strong> on Inbox (12), Tasks (5), and other items</li>
                        </ul>
                    </x-strata::card.body>
                </x-strata::card>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <x-strata::card>
                        <x-strata::card.header>
                            <div class="flex items-center gap-2">
                                <x-strata::icon.users class="w-5 h-5 text-primary" />
                                <h3 class="font-semibold">Total Users</h3>
                            </div>
                        </x-strata::card.header>
                        <x-strata::card.body>
                            <p class="text-3xl font-bold">1,234</p>
                            <p class="text-sm text-success">+12% from last month</p>
                        </x-strata::card.body>
                    </x-strata::card>

                    <x-strata::card>
                        <x-strata::card.header>
                            <div class="flex items-center gap-2">
                                <x-strata::icon.folder class="w-5 h-5 text-info" />
                                <h3 class="font-semibold">Active Projects</h3>
                            </div>
                        </x-strata::card.header>
                        <x-strata::card.body>
                            <p class="text-3xl font-bold">42</p>
                            <p class="text-sm text-muted-foreground">8 new this week</p>
                        </x-strata::card.body>
                    </x-strata::card>

                    <x-strata::card>
                        <x-strata::card.header>
                            <div class="flex items-center gap-2">
                                <x-strata::icon.check-circle class="w-5 h-5 text-success" />
                                <h3 class="font-semibold">Completed Tasks</h3>
                            </div>
                        </x-strata::card.header>
                        <x-strata::card.body>
                            <p class="text-3xl font-bold">89</p>
                            <p class="text-sm text-success">+23 this week</p>
                        </x-strata::card.body>
                    </x-strata::card>
                </div>

                <x-strata::card>
                    <x-strata::card.header>
                        <h3 class="font-semibold">Sidebar Features</h3>
                    </x-strata::card.header>
                    <x-strata::card.body>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-medium mb-2">Navigation Features</h4>
                                <ul class="text-sm space-y-1 text-muted-foreground">
                                    <li>✓ Nested navigation groups</li>
                                    <li>✓ Section dividers and headers</li>
                                    <li>✓ Icon support on all items</li>
                                    <li>✓ Badge notifications</li>
                                    <li>✓ Active state indicators</li>
                                    <li>✓ Search/filter functionality</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-medium mb-2">Responsive & Accessibility</h4>
                                <ul class="text-sm space-y-1 text-muted-foreground">
                                    <li>✓ Mobile overlay with backdrop</li>
                                    <li>✓ Desktop persistent/mini modes</li>
                                    <li>✓ localStorage state persistence</li>
                                    <li>✓ Full keyboard navigation</li>
                                    <li>✓ ARIA labels and roles</li>
                                    <li>✓ Dark mode support</li>
                                </ul>
                            </div>
                        </div>
                    </x-strata::card.body>
                </x-strata::card>
            </div>
        </main>
</div>
