<div class="space-y-8">
    <div>
        <h3 class="text-lg font-semibold mb-4">Basic Toggles</h3>
        <div class="space-y-3">
            <x-strata::toggle wire:model.live="enabled" label="Enable feature" />
            <x-strata::toggle wire:model.live="notifications" label="Push notifications" />
            <x-strata::toggle wire:model.live="darkMode" label="Dark mode" />
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current State:</p>
            <p class="text-sm text-muted-foreground">Enabled: {{ $enabled ? 'Yes' : 'No' }}</p>
            <p class="text-sm text-muted-foreground">Notifications: {{ $notifications ? 'Yes' : 'No' }}</p>
            <p class="text-sm text-muted-foreground">Dark Mode: {{ $darkMode ? 'Yes' : 'No' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Toggle Sizes</h3>
        <div class="space-y-3">
            <x-strata::toggle size="sm" label="Small toggle" />
            <x-strata::toggle size="md" label="Medium toggle (default)" checked />
            <x-strata::toggle size="lg" label="Large toggle" />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Rounded Variants</h3>
        <div class="flex flex-wrap gap-8">
            <x-strata::toggle rounded="none" label="None" checked />
            <x-strata::toggle rounded="sm" label="SM" checked />
            <x-strata::toggle rounded="base" label="Base" checked />
            <x-strata::toggle rounded="md" label="MD" checked />
            <x-strata::toggle rounded="lg" label="LG" checked />
            <x-strata::toggle rounded="xl" label="XL" checked />
            <x-strata::toggle rounded="2xl" label="2XL" checked />
            <x-strata::toggle rounded="3xl" label="3XL" checked />
            <x-strata::toggle rounded="full" label="Full" checked />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Validation States</h3>
        <div class="space-y-3">
            <x-strata::toggle state="default" label="Default state" checked />
            <x-strata::toggle state="success" label="Success state" checked />
            <x-strata::toggle state="error" label="Error state" checked />
            <x-strata::toggle state="warning" label="Warning state" checked />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Disabled State</h3>
        <div class="space-y-3">
            <x-strata::toggle disabled label="Disabled unchecked" />
            <x-strata::toggle disabled checked label="Disabled checked" />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Toggles with Descriptions</h3>
        <div class="space-y-3">
            <x-strata::toggle
                label="Email Notifications"
                description="Receive email updates about your account activity"
                checked
            />
            <x-strata::toggle
                label="Marketing Communications"
                description="Get the latest news, updates, and special offers"
            />
            <x-strata::toggle
                label="Security Alerts"
                description="Important notifications about your account security"
                state="warning"
                checked
            />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Different Sizes with Descriptions</h3>
        <div class="space-y-4">
            <x-strata::toggle
                size="sm"
                label="Small Toggle"
                description="A smaller toggle switch with compact sizing"
                wire:model.live="emailAlerts"
            />
            <x-strata::toggle
                size="md"
                label="Medium Toggle"
                description="The default medium-sized toggle switch"
                wire:model.live="autoSave"
            />
            <x-strata::toggle
                size="lg"
                label="Large Toggle"
                description="A larger toggle switch for better visibility"
                checked
            />
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">State:</p>
            <p class="text-sm text-muted-foreground">Email Alerts: {{ $emailAlerts ? 'Enabled' : 'Disabled' }}</p>
            <p class="text-sm text-muted-foreground">Auto Save: {{ $autoSave ? 'Enabled' : 'Disabled' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Form Submission</h3>
        <form wire:submit="submit" class="space-y-4">
            <x-strata::toggle
                wire:model="notifications"
                label="Enable notifications"
                description="Receive important updates and alerts"
                :state="$notifications ? 'success' : 'default'"
            />

            <div class="flex gap-3">
                <x-strata::button type="submit" variant="primary">
                    Save Settings
                </x-strata::button>
                <x-strata::button type="button" variant="secondary" wire:click="$refresh">
                    Reset
                </x-strata::button>
            </div>

            @if($message)
                <div class="p-4 bg-success/10 border border-success rounded-lg">
                    <p class="text-sm text-success font-medium">{{ $message }}</p>
                </div>
            @endif
        </form>
    </div>
</div>
