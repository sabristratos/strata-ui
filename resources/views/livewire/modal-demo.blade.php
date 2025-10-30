<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold">Modal Component - Livewire Integration Demo</h3>
        <div class="flex items-center gap-2 text-sm text-muted-foreground">
            <span>Programmatic Modal:</span>
            <x-strata::badge :variant="$showModal ? 'success' : 'secondary'">
                {{ $showModal ? 'Open' : 'Closed' }}
            </x-strata::badge>
            <span class="ml-4">Flyout:</span>
            <x-strata::badge :variant="$showFlyout ? 'success' : 'secondary'">
                {{ $showFlyout ? 'Open' : 'Closed' }}
            </x-strata::badge>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h4 class="font-medium mb-3">Basic Modal (Name-based)</h4>
            <x-strata::modal.trigger name="basic-modal">
                <x-strata::button>Open Basic Modal</x-strata::button>
            </x-strata::modal.trigger>
        </div>

        <div>
            <h4 class="font-medium mb-3">Small Modal</h4>
            <x-strata::modal.trigger name="small-modal">
                <x-strata::button variant="secondary">Open Small Modal</x-strata::button>
            </x-strata::modal.trigger>
        </div>

        <div>
            <h4 class="font-medium mb-3">Large Modal</h4>
            <x-strata::modal.trigger name="large-modal">
                <x-strata::button variant="info">Open Large Modal</x-strata::button>
            </x-strata::modal.trigger>
        </div>

        <div>
            <h4 class="font-medium mb-3">Extra Large Modal</h4>
            <x-strata::modal.trigger name="xl-modal">
                <x-strata::button variant="warning">Open XL Modal</x-strata::button>
            </x-strata::modal.trigger>
        </div>

        <div>
            <h4 class="font-medium mb-3">Modal with Form (Livewire wire:model)</h4>
            <x-strata::button wire:click="openModal">Open Form Modal</x-strata::button>
        </div>

        <div>
            <h4 class="font-medium mb-3">Flyout (Right)</h4>
            <x-strata::button variant="success" wire:click="openFlyout">Open Flyout</x-strata::button>
        </div>

        <div>
            <h4 class="font-medium mb-3">Flyout (Left)</h4>
            <x-strata::modal.trigger name="left-flyout">
                <x-strata::button variant="destructive">Open Left Flyout</x-strata::button>
            </x-strata::modal.trigger>
        </div>

        <div>
            <h4 class="font-medium mb-3">Non-dismissible Modal</h4>
            <x-strata::modal.trigger name="non-dismissible-modal">
                <x-strata::button variant="secondary">Open Non-dismissible</x-strata::button>
            </x-strata::modal.trigger>
        </div>
    </div>

    <x-strata::modal name="basic-modal">
        <x-strata::modal.header>
            Basic Modal
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <p class="text-muted-foreground">This is a basic modal with default size (md). It can be closed by clicking the X button, pressing ESC, or clicking the backdrop.</p>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button variant="secondary">Close</x-strata::button>
            </x-strata::modal.close>
            <x-strata::button>Confirm</x-strata::button>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="small-modal" size="sm">
        <x-strata::modal.header>
            Small Modal
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <p class="text-muted-foreground">This is a small modal (sm). Perfect for quick confirmations or alerts.</p>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button variant="secondary">Cancel</x-strata::button>
            </x-strata::modal.close>
            <x-strata::button>OK</x-strata::button>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="large-modal" size="lg">
        <x-strata::modal.header>
            Large Modal
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <div class="space-y-4">
                <p class="text-muted-foreground">This is a large modal (lg). Great for forms or content that needs more space.</p>
                <div class="p-4 bg-muted rounded-lg">
                    <h5 class="font-medium mb-2">Example Content</h5>
                    <p class="text-sm text-muted-foreground">You can put any content here. The modal body is scrollable if content overflows.</p>
                </div>
            </div>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button variant="secondary">Cancel</x-strata::button>
            </x-strata::modal.close>
            <x-strata::button>Save</x-strata::button>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="xl-modal" size="xl">
        <x-strata::modal.header>
            Extra Large Modal
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <div class="space-y-4">
                <p class="text-muted-foreground">This is an extra large modal (xl). Perfect for complex forms, data tables, or detailed content.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-muted rounded-lg">
                        <h5 class="font-medium mb-2">Column 1</h5>
                        <p class="text-sm text-muted-foreground">Content for the first column.</p>
                    </div>
                    <div class="p-4 bg-muted rounded-lg">
                        <h5 class="font-medium mb-2">Column 2</h5>
                        <p class="text-sm text-muted-foreground">Content for the second column.</p>
                    </div>
                </div>
            </div>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button variant="secondary">Cancel</x-strata::button>
            </x-strata::modal.close>
            <x-strata::button>Submit</x-strata::button>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal wire:model.live="showModal" size="lg">
        <form wire:submit="submitForm">
            <x-strata::modal.header>
                Contact Form
                <x-slot:actions>
                    <x-strata::modal.close />
                </x-slot:actions>
            </x-strata::modal.header>

            <x-strata::modal.body>
                <div class="space-y-4">
                    <p class="text-sm text-muted-foreground">This modal uses wire:model.live for programmatic control. Fill out the form below:</p>

                    <x-strata::form.field>
                        <x-strata::form.label for="name">Name</x-strata::form.label>
                        <x-strata::input id="name" wire:model="name" placeholder="Enter your name" />
                        <x-strata::form.error name="name" />
                    </x-strata::form.field>

                    <x-strata::form.field>
                        <x-strata::form.label for="email">Email</x-strata::form.label>
                        <x-strata::input id="email" type="email" wire:model="email" placeholder="Enter your email" />
                        <x-strata::form.error name="email" />
                    </x-strata::form.field>

                    <x-strata::form.field>
                        <x-strata::form.label for="message">Message</x-strata::form.label>
                        <x-strata::textarea id="message" wire:model="message" placeholder="Enter your message" rows="4" />
                        <x-strata::form.error name="message" />
                    </x-strata::form.field>
                </div>
            </x-strata::modal.body>

            <x-strata::modal.footer>
                <x-strata::button type="button" variant="secondary" wire:click="closeModal">Cancel</x-strata::button>
                <x-strata::button type="submit">Send Message</x-strata::button>
            </x-strata::modal.footer>
        </form>
    </x-strata::modal>

    <x-strata::modal wire:model.live="showFlyout" variant="flyout" position="right">
        <x-strata::modal.header>
            Settings
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <div class="space-y-4">
                <p class="text-sm text-muted-foreground">This is a flyout variant that slides in from the right side.</p>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">Notifications</span>
                        <x-strata::toggle />
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">Dark Mode</span>
                        <x-strata::toggle />
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">Auto-save</span>
                        <x-strata::toggle />
                    </div>
                </div>
            </div>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::button variant="secondary" wire:click="closeFlyout">Close</x-strata::button>
            <x-strata::button>Save Settings</x-strata::button>
        </x-strata::modal.footer>
    </x-strata::modal>

    <x-strata::modal name="left-flyout" variant="flyout" position="left">
        <x-strata::modal.header>
            Navigation
            <x-slot:actions>
                <x-strata::modal.close />
            </x-slot:actions>
        </x-strata::modal.header>

        <x-strata::modal.body>
            <div class="space-y-2">
                <p class="text-sm text-muted-foreground mb-4">This flyout slides in from the left side.</p>

                <a href="#" class="block px-3 py-2 rounded-md hover:bg-muted transition-colors">Dashboard</a>
                <a href="#" class="block px-3 py-2 rounded-md hover:bg-muted transition-colors">Projects</a>
                <a href="#" class="block px-3 py-2 rounded-md hover:bg-muted transition-colors">Team</a>
                <a href="#" class="block px-3 py-2 rounded-md hover:bg-muted transition-colors">Settings</a>
            </div>
        </x-strata::modal.body>
    </x-strata::modal>

    <x-strata::modal name="non-dismissible-modal" :dismissible="false">
        <x-strata::modal.header>
            Important Notice
        </x-strata::modal.header>

        <x-strata::modal.body>
            <p class="text-muted-foreground">This modal cannot be dismissed by clicking the backdrop or pressing ESC. You must use the buttons to close it.</p>
        </x-strata::modal.body>

        <x-strata::modal.footer>
            <x-strata::modal.close as-child>
                <x-strata::button>I Understand</x-strata::button>
            </x-strata::modal.close>
        </x-strata::modal.footer>
    </x-strata::modal>
</div>
