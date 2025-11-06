<div class="min-h-screen bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Hero Section --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-foreground mb-4">Popover Component Showcase</h1>
            <p class="text-lg text-muted-foreground max-w-3xl mx-auto">
                Comprehensive demonstration of the Strata UI Popover component featuring flexible triggers, placement options, real-world use cases, and seamless Livewire integration using the native Popover API and CSS anchor positioning.
            </p>
        </div>

        {{-- Basic Usage --}}
        <div class="bg-card border border-border rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-4">Basic Usage</h2>
            <p class="text-muted-foreground mb-6">Simple popovers with different content types</p>

            <div class="flex flex-wrap gap-4">
                <x-strata::popover id="basic-text">
                    <x-strata::popover.trigger target="basic-text">
                        <x-strata::button>Simple Text Popover</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <p class="text-sm text-foreground">This is a basic popover with simple text content.</p>
                    </x-strata::popover.content>
                </x-strata::popover>

                <x-strata::popover id="rich-content">
                    <x-strata::popover.trigger target="rich-content">
                        <x-strata::button variant="secondary">Rich Content</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <div class="space-y-2">
                            <h4 class="font-semibold text-foreground">Popover Title</h4>
                            <p class="text-sm text-muted-foreground">Popovers can contain rich content including headings, paragraphs, and buttons.</p>
                            <x-strata::button size="sm" appearance="outlined" class="w-full">Action Button</x-strata::button>
                        </div>
                    </x-strata::popover.content>
                </x-strata::popover>

                <x-strata::popover id="list-content">
                    <x-strata::popover.trigger target="list-content">
                        <x-strata::button variant="success">List Content</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <div class="space-y-1">
                            <p class="text-sm font-semibold text-foreground mb-2">Quick Actions</p>
                            <button class="w-full text-left px-2 py-1.5 text-sm rounded hover:bg-accent text-foreground">Edit</button>
                            <button class="w-full text-left px-2 py-1.5 text-sm rounded hover:bg-accent text-foreground">Duplicate</button>
                            <button class="w-full text-left px-2 py-1.5 text-sm rounded hover:bg-accent text-destructive">Delete</button>
                        </div>
                    </x-strata::popover.content>
                </x-strata::popover>
            </div>
        </div>

        {{-- Placement Options --}}
        <div class="bg-card border border-border rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-4">Placement Options</h2>
            <p class="text-muted-foreground mb-6">All 12 placement variants with automatic viewport-aware positioning</p>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach(['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end', 'right', 'right-start', 'right-end'] as $placement)
                <x-strata::popover id="placement-{{ $placement }}" placement="{{ $placement }}">
                    <x-strata::popover.trigger target="placement-{{ $placement }}">
                        <x-strata::button appearance="outlined" class="w-full">{{ ucfirst(str_replace('-', ' ', $placement)) }}</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <p class="text-sm text-foreground">Placement: <span class="font-mono font-semibold">{{ $placement }}</span></p>
                    </x-strata::popover.content>
                </x-strata::popover>
                @endforeach
            </div>
        </div>

        {{-- Size Variants --}}
        <div class="bg-card border border-border rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-4">Size Variants</h2>
            <p class="text-muted-foreground mb-6">Small, medium, and large popover widths</p>

            <div class="flex flex-wrap gap-4">
                <x-strata::popover id="size-sm" size="sm">
                    <x-strata::popover.trigger target="size-sm">
                        <x-strata::button>Small</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <p class="text-sm text-foreground">This is a small popover (size="sm")</p>
                    </x-strata::popover.content>
                </x-strata::popover>

                <x-strata::popover id="size-md" size="md">
                    <x-strata::popover.trigger target="size-md">
                        <x-strata::button variant="secondary">Medium (Default)</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <p class="text-sm text-foreground">This is a medium popover (size="md"). This is the default size and provides a good balance for most content.</p>
                    </x-strata::popover.content>
                </x-strata::popover>

                <x-strata::popover id="size-lg" size="lg">
                    <x-strata::popover.trigger target="size-lg">
                        <x-strata::button variant="success">Large</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <p class="text-sm text-foreground">This is a large popover (size="lg"). Perfect for more detailed content or when you need extra space for forms or complex layouts.</p>
                    </x-strata::popover.content>
                </x-strata::popover>
            </div>
        </div>

        {{-- Flexible Triggers --}}
        <div class="bg-card border border-border rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-4">Flexible Triggers</h2>
            <p class="text-muted-foreground mb-6">Any element can be a trigger using the slot-based pattern</p>

            <div class="flex flex-wrap items-center gap-6">
                {{-- Icon Button Trigger --}}
                <x-strata::popover id="trigger-icon">
                    <x-strata::popover.trigger target="trigger-icon">
                        <x-strata::button.icon icon="info" variant="secondary" aria-label="Information" />
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <p class="text-sm text-foreground">Icon button as trigger</p>
                    </x-strata::popover.content>
                </x-strata::popover>

                {{-- Avatar Trigger --}}
                <x-strata::popover id="trigger-avatar">
                    <x-strata::popover.trigger target="trigger-avatar">
                        <x-strata::avatar src="https://ui-avatars.com/api/?name=John+Doe&background=3b82f6&color=fff" class="cursor-pointer" />
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <div class="flex items-center gap-3">
                            <x-strata::avatar src="https://ui-avatars.com/api/?name=John+Doe&background=3b82f6&color=fff" />
                            <div>
                                <p class="font-semibold text-sm text-foreground">{{ $username }}</p>
                                <p class="text-xs text-muted-foreground">{{ $email }}</p>
                            </div>
                        </div>
                    </x-strata::popover.content>
                </x-strata::popover>

                {{-- Badge Trigger --}}
                <x-strata::popover id="trigger-badge">
                    <x-strata::popover.trigger target="trigger-badge">
                        <x-strata::badge variant="destructive" class="cursor-pointer">
                            {{ $notificationCount }} New
                        </x-strata::badge>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <p class="text-sm text-foreground">You have {{ $notificationCount }} unread notifications</p>
                    </x-strata::popover.content>
                </x-strata::popover>

                {{-- Custom Element Trigger --}}
                <x-strata::popover id="trigger-custom">
                    <x-strata::popover.trigger target="trigger-custom">
                        <div class="px-4 py-2 bg-accent rounded-md cursor-pointer hover:bg-accent/80 transition-colors">
                            <p class="text-sm font-medium text-foreground">Custom Element</p>
                        </div>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content>
                        <p class="text-sm text-foreground">Any element can be a trigger, not just buttons!</p>
                    </x-strata::popover.content>
                </x-strata::popover>
            </div>
        </div>

        {{-- Content Padding Options --}}
        <div class="bg-card border border-border rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-4">Content Padding Options</h2>
            <p class="text-muted-foreground mb-6">Control the padding inside popover content</p>

            <div class="flex flex-wrap gap-4">
                <x-strata::popover id="padding-none">
                    <x-strata::popover.trigger target="padding-none">
                        <x-strata::button>No Padding</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content padding="none">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-4 text-white text-sm">
                            padding="none" - Perfect for full-width images or custom layouts
                        </div>
                    </x-strata::popover.content>
                </x-strata::popover>

                <x-strata::popover id="padding-sm">
                    <x-strata::popover.trigger target="padding-sm">
                        <x-strata::button variant="secondary">Small Padding</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content padding="sm">
                        <p class="text-sm text-foreground">padding="sm" - Compact content</p>
                    </x-strata::popover.content>
                </x-strata::popover>

                <x-strata::popover id="padding-normal">
                    <x-strata::popover.trigger target="padding-normal">
                        <x-strata::button variant="success">Normal Padding</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content padding="normal">
                        <p class="text-sm text-foreground">padding="normal" - Default padding, balanced spacing</p>
                    </x-strata::popover.content>
                </x-strata::popover>

                <x-strata::popover id="padding-lg">
                    <x-strata::popover.trigger target="padding-lg">
                        <x-strata::button variant="warning">Large Padding</x-strata::button>
                    </x-strata::popover.trigger>
                    <x-strata::popover.content padding="lg">
                        <p class="text-sm text-foreground">padding="lg" - Spacious content with extra breathing room</p>
                    </x-strata::popover.content>
                </x-strata::popover>
            </div>
        </div>

        {{-- Real-World Use Cases --}}
        <div class="bg-card border border-border rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-4">Real-World Use Cases</h2>
            <p class="text-muted-foreground mb-6">Practical examples demonstrating common popover patterns</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- User Profile Menu --}}
                <div>
                    <h3 class="text-sm font-semibold text-foreground mb-2">User Profile Menu</h3>
                    <x-strata::popover id="user-profile-menu" placement="bottom-end">
                        <x-strata::popover.trigger target="user-profile-menu">
                            <div class="flex items-center gap-2 px-3 py-2 bg-accent rounded-md cursor-pointer hover:bg-accent/80 transition-colors">
                                <x-strata::avatar src="https://ui-avatars.com/api/?name=John+Doe&background=3b82f6&color=fff" size="sm" />
                                <span class="text-sm font-medium text-foreground">{{ $username }}</span>
                                <x-strata::icon.chevron-down class="w-4 h-4 text-muted-foreground" />
                            </div>
                        </x-strata::popover.trigger>
                        <x-strata::popover.content padding="sm">
                            <div class="space-y-1 min-w-48">
                                <div class="px-2 py-1.5 border-b border-border mb-1">
                                    <p class="text-sm font-semibold text-foreground">{{ $username }}</p>
                                    <p class="text-xs text-muted-foreground">{{ $email }}</p>
                                </div>
                                @foreach($userActions as $action)
                                    <button wire:click="selectedAction = '{{ $action['value'] }}'" class="w-full flex items-center gap-2 px-2 py-1.5 text-sm rounded hover:bg-accent text-foreground">
                                        @switch($action['icon'])
                                            @case('user')
                                                <x-strata::icon.user class="w-4 h-4" />
                                                @break
                                            @case('settings')
                                                <x-strata::icon.settings class="w-4 h-4" />
                                                @break
                                            @case('credit-card')
                                                <x-strata::icon.credit-card class="w-4 h-4" />
                                                @break
                                            @case('log-out')
                                                <x-strata::icon.log-out class="w-4 h-4" />
                                                @break
                                        @endswitch
                                        {{ $action['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </x-strata::popover.content>
                    </x-strata::popover>
                    @if($selectedAction)
                        <p class="text-xs text-muted-foreground mt-2">Selected: {{ $selectedAction }}</p>
                    @endif
                </div>

                {{-- Notification Panel --}}
                <div>
                    <h3 class="text-sm font-semibold text-foreground mb-2">Notification Panel</h3>
                    <x-strata::popover id="notifications" placement="bottom-end" size="lg">
                        <x-strata::popover.trigger target="notifications">
                            <div class="relative">
                                <x-strata::button.icon icon="bell" variant="secondary" aria-label="Notifications" />
                                @if($notificationCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-destructive text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $notificationCount }}</span>
                                @endif
                            </div>
                        </x-strata::popover.trigger>
                        <x-strata::popover.content padding="none">
                            <div class="w-80">
                                <div class="px-4 py-3 border-b border-border flex items-center justify-between">
                                    <h3 class="font-semibold text-foreground">Notifications</h3>
                                    @if($notificationCount > 0)
                                        <button wire:click="clearNotifications" class="text-xs text-primary hover:underline">Clear all</button>
                                    @endif
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    @forelse($notifications as $notification)
                                        <div class="px-4 py-3 hover:bg-accent border-b border-border last:border-0">
                                            <p class="text-sm text-foreground">{{ $notification['text'] }}</p>
                                            <p class="text-xs text-muted-foreground mt-1">{{ $notification['time'] }}</p>
                                        </div>
                                    @empty
                                        <div class="px-4 py-8 text-center">
                                            <p class="text-sm text-muted-foreground">No new notifications</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </x-strata::popover.content>
                    </x-strata::popover>
                    <p class="text-xs text-muted-foreground mt-2">Count: {{ $notificationCount }}</p>
                </div>

                {{-- Confirmation Dialog --}}
                <div>
                    <h3 class="text-sm font-semibold text-foreground mb-2">Confirmation Dialog</h3>
                    <x-strata::popover id="delete-confirm">
                        <x-strata::popover.trigger target="delete-confirm">
                            <x-strata::button variant="destructive" icon="trash" :disabled="$itemDeleted">
                                {{ $itemDeleted ? 'Deleted' : 'Delete Item' }}
                            </x-strata::button>
                        </x-strata::popover.trigger>
                        <x-strata::popover.content>
                            <div class="space-y-3">
                                <p class="text-sm font-semibold text-foreground">Are you sure?</p>
                                <p class="text-sm text-muted-foreground">This action cannot be undone.</p>
                                <div class="flex gap-2">
                                    <x-strata::button wire:click="deleteItem" variant="destructive" size="sm" class="flex-1">Delete</x-strata::button>
                                    <x-strata::button size="sm" appearance="outlined" class="flex-1" onclick="document.getElementById('delete-confirm').hidePopover()">Cancel</x-strata::button>
                                </div>
                            </div>
                        </x-strata::popover.content>
                    </x-strata::popover>
                    @if($itemDeleted)
                        <p class="text-xs text-destructive mt-2">Item has been deleted</p>
                    @endif
                </div>

                {{-- Color Picker --}}
                <div>
                    <h3 class="text-sm font-semibold text-foreground mb-2">Color Picker</h3>
                    <x-strata::popover id="color-picker">
                        <x-strata::popover.trigger target="color-picker">
                            <button class="flex items-center gap-2 px-3 py-2 border border-border rounded-md hover:bg-accent">
                                @if($selectedColor)
                                    <div class="w-5 h-5 rounded border border-border" style="background-color: {{ collect($colors)->firstWhere('value', $selectedColor)['hex'] }}"></div>
                                    <span class="text-sm capitalize text-foreground">{{ $selectedColor }}</span>
                                @else
                                    <span class="text-sm text-muted-foreground">Choose color</span>
                                @endif
                            </button>
                        </x-strata::popover.trigger>
                        <x-strata::popover.content padding="sm">
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($colors as $color)
                                    <button
                                        wire:click="selectColor('{{ $color['value'] }}')"
                                        class="w-10 h-10 rounded border-2 {{ $selectedColor === $color['value'] ? 'border-primary' : 'border-border' }} hover:scale-110 transition-transform"
                                        style="background-color: {{ $color['hex'] }}"
                                        title="{{ ucfirst($color['value']) }}"
                                    ></button>
                                @endforeach
                            </div>
                        </x-strata::popover.content>
                    </x-strata::popover>
                    @if($selectedColor)
                        <p class="text-xs text-muted-foreground mt-2">Selected: {{ $selectedColor }}</p>
                    @endif
                </div>

                {{-- Quick Settings --}}
                <div>
                    <h3 class="text-sm font-semibold text-foreground mb-2">Quick Settings</h3>
                    <x-strata::popover id="quick-settings" placement="bottom-start">
                        <x-strata::popover.trigger target="quick-settings">
                            <x-strata::button icon="settings" variant="secondary">Settings</x-strata::button>
                        </x-strata::popover.trigger>
                        <x-strata::popover.content>
                            <div class="space-y-3 min-w-56">
                                <p class="text-sm font-semibold text-foreground">Quick Settings</p>
                                <div class="space-y-2">
                                    <label class="flex items-center justify-between">
                                        <span class="text-sm text-foreground">Dark Mode</span>
                                        <x-strata::toggle wire:model.live="darkModeEnabled" size="sm" />
                                    </label>
                                    <label class="flex items-center justify-between">
                                        <span class="text-sm text-foreground">Notifications</span>
                                        <x-strata::toggle wire:model.live="notificationsEnabled" size="sm" />
                                    </label>
                                    <label class="flex items-center justify-between">
                                        <span class="text-sm text-foreground">Email Updates</span>
                                        <x-strata::toggle wire:model.live="emailUpdates" size="sm" />
                                    </label>
                                </div>
                            </div>
                        </x-strata::popover.content>
                    </x-strata::popover>
                    <div class="text-xs text-muted-foreground mt-2 space-y-0.5">
                        <p>Dark Mode: {{ $darkModeEnabled ? 'On' : 'Off' }}</p>
                        <p>Notifications: {{ $notificationsEnabled ? 'On' : 'Off' }}</p>
                        <p>Email: {{ $emailUpdates ? 'On' : 'Off' }}</p>
                    </div>
                </div>

                {{-- Form Help Text --}}
                <div>
                    <h3 class="text-sm font-semibold text-foreground mb-2">Form Help Text</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-foreground">
                            Password
                            <x-strata::popover id="password-help" placement="right">
                                <x-strata::popover.trigger target="password-help">
                                    <x-strata::button.icon icon="help-circle" size="sm" variant="secondary" appearance="ghost" aria-label="Password help" />
                                </x-strata::popover.trigger>
                                <x-strata::popover.content>
                                    <div class="space-y-2">
                                        <p class="text-sm font-semibold text-foreground">Password Requirements:</p>
                                        <ul class="text-xs text-muted-foreground space-y-1 list-disc list-inside">
                                            <li>At least 8 characters</li>
                                            <li>One uppercase letter</li>
                                            <li>One number</li>
                                            <li>One special character</li>
                                        </ul>
                                    </div>
                                </x-strata::popover.content>
                            </x-strata::popover>
                        </label>
                        <x-strata::input type="password" placeholder="Enter password" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Livewire Integration --}}
        <div class="bg-card border border-border rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-4">Livewire Integration Demo</h2>
            <p class="text-muted-foreground mb-6">Interactive examples with form submission and state management</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Form in Popover --}}
                <div>
                    <h3 class="text-sm font-semibold text-foreground mb-2">Form in Popover</h3>
                    <x-strata::popover id="quick-note-form">
                        <x-strata::popover.trigger target="quick-note-form">
                            <x-strata::button icon="plus">Add Quick Note</x-strata::button>
                        </x-strata::popover.trigger>
                        <x-strata::popover.content>
                            <form wire:submit="submitQuickNote" class="space-y-3">
                                <p class="text-sm font-semibold text-foreground">Quick Note</p>
                                <x-strata::textarea wire:model="quickNote" placeholder="Enter your note..." rows="3" />
                                @error('quickNote') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
                                <x-strata::button type="submit" size="sm" class="w-full">Save Note</x-strata::button>
                            </form>
                        </x-strata::popover.content>
                    </x-strata::popover>
                    @if($noteSubmitted)
                        <p class="text-xs text-success mt-2">Note submitted successfully!</p>
                    @endif
                </div>

                {{-- Reset Demo Button --}}
                <div class="flex items-end">
                    <x-strata::button wire:click="resetDemo" variant="secondary" icon="rotate-ccw">Reset All Demos</x-strata::button>
                </div>
            </div>
        </div>

        {{-- Features Summary --}}
        <div class="bg-card border border-border rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-6">Features Demonstrated</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">12 Placement Options</h4>
                        <p class="text-sm text-muted-foreground">All edge and corner placements with auto-positioning</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">3 Size Variants</h4>
                        <p class="text-sm text-muted-foreground">Small, medium, and large widths</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">Flexible Triggers</h4>
                        <p class="text-sm text-muted-foreground">Any element via slot-based pattern</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">Content Padding</h4>
                        <p class="text-sm text-muted-foreground">None, small, normal, large options</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">Native Popover API</h4>
                        <p class="text-sm text-muted-foreground">Built-in light dismiss and accessibility</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">CSS Anchor Positioning</h4>
                        <p class="text-sm text-muted-foreground">Automatic layout with polyfill support</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">Livewire Integration</h4>
                        <p class="text-sm text-muted-foreground">Forms, state management, dynamic content</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">Smooth Animations</h4>
                        <p class="text-sm text-muted-foreground">CSS transitions with @starting-style</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-success/10 text-success flex items-center justify-center text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-foreground text-sm mb-1">Focus Management</h4>
                        <p class="text-sm text-muted-foreground">Automatic focus trap and keyboard support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
