<div class="space-y-8">
    <div>
        <h3 class="text-lg font-semibold mb-4">Basic Radio Buttons</h3>
        <x-strata::radio.group label="Select your plan" name="plan">
            <x-strata::radio wire:model.live="selectedPlan" name="plan" value="basic" label="Basic Plan" />
            <x-strata::radio wire:model.live="selectedPlan" name="plan" value="pro" label="Pro Plan" />
            <x-strata::radio wire:model.live="selectedPlan" name="plan" value="enterprise" label="Enterprise Plan" />
        </x-strata::radio.group>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current Selection:</p>
            <p class="text-sm text-muted-foreground">Plan: {{ ucfirst($selectedPlan) }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Radio Sizes</h3>
        <div class="space-y-3">
            <x-strata::radio size="sm" name="size-demo-sm" label="Small radio" />
            <x-strata::radio size="md" name="size-demo-md" label="Medium radio (default)" checked />
            <x-strata::radio size="lg" name="size-demo-lg" label="Large radio" />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Validation States</h3>
        <div class="space-y-3">
            <x-strata::radio state="default" name="state-demo-default" label="Default state" checked />
            <x-strata::radio state="success" name="state-demo-success" label="Success state" checked />
            <x-strata::radio state="error" name="state-demo-error" label="Error state" checked />
            <x-strata::radio state="warning" name="state-demo-warning" label="Warning state" checked />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Disabled State</h3>
        <div class="space-y-3">
            <x-strata::radio disabled name="disabled-demo" label="Disabled unchecked" />
            <x-strata::radio disabled checked name="disabled-demo-checked" label="Disabled checked" />
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Radio Groups</h3>

        <div class="space-y-4">
            <x-strata::radio.group label="Vertical Group (Default)" name="vertical-group">
                <x-strata::radio name="vertical-group" value="option1" label="Option 1" checked />
                <x-strata::radio name="vertical-group" value="option2" label="Option 2" />
                <x-strata::radio name="vertical-group" value="option3" label="Option 3" />
            </x-strata::radio.group>

            <x-strata::radio.group label="Horizontal Group" orientation="horizontal" name="horizontal-group">
                <x-strata::radio name="horizontal-group" value="yes" label="Yes" />
                <x-strata::radio name="horizontal-group" value="no" label="No" />
                <x-strata::radio name="horizontal-group" value="maybe" label="Maybe" checked />
            </x-strata::radio.group>

            <x-strata::radio.group label="With Error" error="Please select an option" name="error-group">
                <x-strata::radio name="error-group" value="optionA" label="Option A" />
                <x-strata::radio name="error-group" value="optionB" label="Option B" />
            </x-strata::radio.group>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Radios with Descriptions</h3>
        <div class="space-y-3">
            <x-strata::radio
                wire:model.live="selectedSize"
                name="size"
                value="sm"
                label="Small"
                description="Best for compact layouts and dense information"
            />
            <x-strata::radio
                wire:model.live="selectedSize"
                name="size"
                value="md"
                label="Medium"
                description="The default size, works well in most situations"
            />
            <x-strata::radio
                wire:model.live="selectedSize"
                name="size"
                value="lg"
                label="Large"
                description="Improved accessibility and easier to click"
            />
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-1">Selected Size:</p>
            <p class="text-sm text-muted-foreground">{{ strtoupper($selectedSize) }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Bordered Variant</h3>
        <div class="space-y-3">
            <x-strata::radio
                variant="bordered"
                wire:model.live="selectedColor"
                name="color"
                value="blue"
                label="Blue Theme"
                description="Classic and professional color scheme"
            />
            <x-strata::radio
                variant="bordered"
                wire:model.live="selectedColor"
                name="color"
                value="green"
                label="Green Theme"
                description="Natural and calming color palette"
            />
            <x-strata::radio
                variant="bordered"
                wire:model.live="selectedColor"
                name="color"
                value="purple"
                label="Purple Theme"
                description="Creative and modern appearance"
            />
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-1">Selected Color:</p>
            <p class="text-sm text-muted-foreground">{{ ucfirst($selectedColor) }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Card Variant - Subscription Plans</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-strata::radio
                variant="card"
                wire:model.live="selectedCardPlan"
                name="card-plan"
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
            </x-strata::radio>

            <x-strata::radio
                variant="card"
                wire:model.live="selectedCardPlan"
                name="card-plan"
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
            </x-strata::radio>

            <x-strata::radio
                variant="card"
                wire:model.live="selectedCardPlan"
                name="card-plan"
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
            </x-strata::radio>
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-1">Selected Plan:</p>
            <p class="text-sm text-muted-foreground">{{ ucfirst($selectedCardPlan) }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Pill Variant</h3>
        <div class="space-y-4">
            <div>
                <p class="text-sm text-muted-foreground mb-3">Select your primary skill:</p>
                <div class="flex flex-wrap gap-2">
                    <x-strata::radio
                        variant="pill"
                        wire:model.live="selectedPillOption"
                        name="skill"
                        value="design"
                        label="Design"
                    />
                    <x-strata::radio
                        variant="pill"
                        wire:model.live="selectedPillOption"
                        name="skill"
                        value="development"
                        label="Development"
                    />
                    <x-strata::radio
                        variant="pill"
                        wire:model.live="selectedPillOption"
                        name="skill"
                        value="marketing"
                        label="Marketing"
                    />
                    <x-strata::radio
                        variant="pill"
                        wire:model.live="selectedPillOption"
                        name="skill"
                        value="sales"
                        label="Sales"
                    />
                    <x-strata::radio
                        variant="pill"
                        wire:model.live="selectedPillOption"
                        name="skill"
                        value="support"
                        label="Support"
                    />
                </div>
            </div>

            <div>
                <p class="text-sm text-muted-foreground mb-3">Different sizes:</p>
                <div class="flex flex-wrap items-center gap-2">
                    <x-strata::radio variant="pill" size="sm" name="pill-size" value="sm" label="Small" checked />
                    <x-strata::radio variant="pill" size="md" name="pill-size" value="md" label="Medium" />
                    <x-strata::radio variant="pill" size="lg" name="pill-size" value="lg" label="Large" />
                </div>
            </div>

            <div class="p-4 bg-muted rounded-lg">
                <p class="text-sm font-medium mb-1">Selected Skill:</p>
                <p class="text-sm text-muted-foreground">{{ ucfirst($selectedPillOption) }}</p>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Form Submission</h3>
        <form wire:submit="submit" class="space-y-4">
            <x-strata::radio.group label="Choose your subscription plan" name="form-plan">
                <x-strata::radio
                    wire:model="selectedPlan"
                    name="form-plan"
                    value="basic"
                    label="Basic - $9/month"
                />
                <x-strata::radio
                    wire:model="selectedPlan"
                    name="form-plan"
                    value="pro"
                    label="Pro - $29/month"
                />
                <x-strata::radio
                    wire:model="selectedPlan"
                    name="form-plan"
                    value="enterprise"
                    label="Enterprise - $99/month"
                />
            </x-strata::radio.group>

            <div class="flex gap-3">
                <x-strata::button type="submit" variant="primary">
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
