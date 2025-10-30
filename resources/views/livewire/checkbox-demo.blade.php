<div class="space-y-8">
    <div>
        <h3 class="text-lg font-semibold mb-4">Basic Checkboxes</h3>
        <div class="space-y-3">
            <x-strata::checkbox wire:model.live="agreed" label="I agree to the terms and conditions" />
            <x-strata::checkbox wire:model.live="notifications" label="Send me email notifications" />
            <x-strata::checkbox wire:model.live="newsletter" label="Subscribe to newsletter" />
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current State:</p>
            <p class="text-sm text-muted-foreground">Agreed: {{ $agreed ? 'Yes' : 'No' }}</p>
            <p class="text-sm text-muted-foreground">Notifications: {{ $notifications ? 'Yes' : 'No' }}</p>
            <p class="text-sm text-muted-foreground">Newsletter: {{ $newsletter ? 'Yes' : 'No' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Checkbox Sizes</h3>
        <div class="space-y-3">
            <x-strata::checkbox size="sm" label="Small checkbox" />
            <x-strata::checkbox size="md" label="Medium checkbox (default)" checked />
            <x-strata::checkbox size="lg" label="Large checkbox" />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Validation States</h3>
        <div class="space-y-3">
            <x-strata::checkbox state="default" label="Default state" checked />
            <x-strata::checkbox state="success" label="Success state" checked />
            <x-strata::checkbox state="error" label="Error state" checked />
            <x-strata::checkbox state="warning" label="Warning state" checked />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Disabled State</h3>
        <div class="space-y-3">
            <x-strata::checkbox disabled label="Disabled unchecked" />
            <x-strata::checkbox disabled checked label="Disabled checked" />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Indeterminate State (Select All)</h3>
        <div class="space-y-3">
            <x-strata::checkbox
                wire:model.live="selectAll"
                :indeterminate="count($selectedOptions) > 0 && count($selectedOptions) < count($availableOptions)"
                label="Select All Frameworks"
            />
            <div class="ml-6 space-y-2">
                @foreach($availableOptions as $key => $name)
                    <x-strata::checkbox
                        wire:model.live="selectedOptions"
                        value="{{ $key }}"
                        :label="$name"
                    />
                @endforeach
            </div>
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Selected: {{ count($selectedOptions) }} / {{ count($availableOptions) }}</p>
            @if(count($selectedOptions) > 0)
                <p class="text-sm text-muted-foreground">{{ implode(', ', array_map(fn($k) => $availableOptions[$k], $selectedOptions)) }}</p>
            @endif
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Checkbox Groups</h3>

        <div class="space-y-4">
            <x-strata::checkbox.group label="Vertical Group (Default)">
                <x-strata::checkbox label="Option 1" checked />
                <x-strata::checkbox label="Option 2" />
                <x-strata::checkbox label="Option 3" />
            </x-strata::checkbox.group>

            <x-strata::checkbox.group label="Horizontal Group" orientation="horizontal">
                <x-strata::checkbox label="Yes" />
                <x-strata::checkbox label="No" />
                <x-strata::checkbox label="Maybe" checked />
            </x-strata::checkbox.group>

            <x-strata::checkbox.group label="With Error" error="Please select at least one option">
                <x-strata::checkbox label="Option A" />
                <x-strata::checkbox label="Option B" />
            </x-strata::checkbox.group>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Checkboxes with Descriptions</h3>
        <div class="space-y-3">
            <x-strata::checkbox
                label="Email Notifications"
                description="Receive email updates about your account activity"
                checked
            />
            <x-strata::checkbox
                label="Marketing Communications"
                description="Get the latest news, updates, and special offers"
            />
            <x-strata::checkbox
                label="Security Alerts"
                description="Important notifications about your account security"
                state="warning"
                checked
            />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Bordered Variant</h3>
        <div class="space-y-3">
            <x-strata::checkbox
                variant="bordered"
                label="Enable two-factor authentication"
                description="Add an extra layer of security to your account"
                checked
            />
            <x-strata::checkbox
                variant="bordered"
                label="Email verification required"
                description="Users must verify their email before accessing features"
            />
            <x-strata::checkbox
                variant="bordered"
                label="Automatic backups"
                description="Daily backups of your data to secure cloud storage"
                checked
            />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Card Variant - Subscription Plans</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-strata::checkbox
                variant="card"
                wire:model.live="selectedPlanCards"
                value="basic"
                label="Basic Plan"
                description="Perfect for individuals and small projects. Includes essential features."
            >
                <div class="mt-4 space-y-2">
                    <p class="text-2xl font-bold">$9/month</p>
                    <ul class="space-y-1 text-sm text-muted-foreground">
                        <li>✓ 10 projects</li>
                        <li>✓ 5GB storage</li>
                        <li>✓ Email support</li>
                    </ul>
                </div>
            </x-strata::checkbox>

            <x-strata::checkbox
                variant="card"
                wire:model.live="selectedPlanCards"
                value="pro"
                label="Pro Plan"
                description="For growing teams and businesses. Everything in Basic, plus more."
            >
                <div class="mt-4 space-y-2">
                    <p class="text-2xl font-bold">$29/month</p>
                    <ul class="space-y-1 text-sm text-muted-foreground">
                        <li>✓ Unlimited projects</li>
                        <li>✓ 100GB storage</li>
                        <li>✓ Priority support</li>
                        <li>✓ Advanced analytics</li>
                    </ul>
                </div>
            </x-strata::checkbox>

            <x-strata::checkbox
                variant="card"
                wire:model.live="selectedPlanCards"
                value="enterprise"
                label="Enterprise Plan"
                description="For large organizations with custom needs and dedicated support."
            >
                <div class="mt-4 space-y-2">
                    <p class="text-2xl font-bold">$99/month</p>
                    <ul class="space-y-1 text-sm text-muted-foreground">
                        <li>✓ Everything in Pro</li>
                        <li>✓ Unlimited storage</li>
                        <li>✓ 24/7 phone support</li>
                        <li>✓ Custom integrations</li>
                        <li>✓ SLA guarantee</li>
                    </ul>
                </div>
            </x-strata::checkbox>
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-1">Selected Plans:</p>
            <p class="text-sm text-muted-foreground">
                @if(count($selectedPlanCards) > 0)
                    {{ implode(', ', array_map('ucfirst', $selectedPlanCards)) }}
                @else
                    None selected
                @endif
            </p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Pill Variant</h3>
        <div class="space-y-4">
            <div>
                <p class="text-sm text-muted-foreground mb-3">Select your interests:</p>
                <div class="flex flex-wrap gap-2">
                    <x-strata::checkbox
                        variant="pill"
                        wire:model.live="selectedPillOptions"
                        value="design"
                        label="Design"
                    />
                    <x-strata::checkbox
                        variant="pill"
                        wire:model.live="selectedPillOptions"
                        value="development"
                        label="Development"
                    />
                    <x-strata::checkbox
                        variant="pill"
                        wire:model.live="selectedPillOptions"
                        value="marketing"
                        label="Marketing"
                    />
                    <x-strata::checkbox
                        variant="pill"
                        wire:model.live="selectedPillOptions"
                        value="sales"
                        label="Sales"
                    />
                    <x-strata::checkbox
                        variant="pill"
                        wire:model.live="selectedPillOptions"
                        value="support"
                        label="Support"
                    />
                </div>
            </div>

            <div>
                <p class="text-sm text-muted-foreground mb-3">Different sizes:</p>
                <div class="flex flex-wrap items-center gap-2">
                    <x-strata::checkbox variant="pill" size="sm" label="Small" checked />
                    <x-strata::checkbox variant="pill" size="md" label="Medium" checked />
                    <x-strata::checkbox variant="pill" size="lg" label="Large" checked />
                </div>
            </div>

            @if(count($selectedPillOptions) > 0)
                <div class="p-4 bg-muted rounded-lg">
                    <p class="text-sm font-medium mb-1">Selected Interests:</p>
                    <p class="text-sm text-muted-foreground">
                        {{ implode(', ', array_map('ucfirst', $selectedPillOptions)) }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Form Submission</h3>
        <form wire:submit="submit" class="space-y-4">
            <x-strata::checkbox
                wire:model="agreed"
                label="I agree to submit this form"
                :state="$agreed ? 'success' : 'error'"
            />

            <div class="flex gap-3">
                <x-strata::button type="submit" variant="primary" :disabled="!$agreed">
                    Submit Form
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
