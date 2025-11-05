<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Strata UI - Radio Component Showcase</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-body text-foreground min-h-screen" x-data="{ darkMode: $persist(false).as('darkMode') }" :class="darkMode ? 'scheme-dark' : 'scheme-light'">
    <x-strata::toast />

    <div class="max-w-7xl mx-auto px-6 py-12">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-foreground mb-4">Radio Component</h1>
            <p class="text-xl text-muted-foreground">Comprehensive radio button showcase with all features</p>
            <p class="text-sm text-muted-foreground mt-2">Strata UI Component Library</p>
        </div>

        {{-- Basic Radios --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Basic Radio Buttons</h2>
                <p class="text-muted-foreground">Simple radio examples with different states</p>
            </div>

            <div class="bg-card border border-border rounded-lg p-8">
                <div class="space-y-4">
                    <x-strata::radio name="basic" value="1" label="Default radio" />
                    <x-strata::radio name="basic" value="2" label="Checked radio" checked />
                    <x-strata::radio name="disabled" value="3" label="Disabled radio" disabled />
                    <x-strata::radio name="disabled-checked" value="4" label="Disabled checked" disabled checked />
                </div>
            </div>
        </section>

        {{-- Sizes --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Sizes</h2>
                <p class="text-muted-foreground">Three size variants</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Small</h3>
                    <div class="space-y-3">
                        <x-strata::radio name="small" value="1" size="sm" label="Small radio" />
                        <x-strata::radio name="small" value="2" size="sm" label="Small checked" checked />
                    </div>
                </div>

                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Medium (Default)</h3>
                    <div class="space-y-3">
                        <x-strata::radio name="medium" value="1" size="md" label="Medium radio" />
                        <x-strata::radio name="medium" value="2" size="md" label="Medium checked" checked />
                    </div>
                </div>

                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Large</h3>
                    <div class="space-y-3">
                        <x-strata::radio name="large" value="1" size="lg" label="Large radio" />
                        <x-strata::radio name="large" value="2" size="lg" label="Large checked" checked />
                    </div>
                </div>
            </div>
        </section>

        {{-- Validation States --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Validation States</h2>
                <p class="text-muted-foreground">Visual feedback for different validation states</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Default</h3>
                    <div class="space-y-3">
                        <x-strata::radio name="default-state" value="1" state="default" label="Default state" />
                        <x-strata::radio name="default-state" value="2" state="default" label="Default checked" checked />
                    </div>
                </div>

                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Success</h3>
                    <div class="space-y-3">
                        <x-strata::radio name="success-state" value="1" state="success" label="Valid option" />
                        <x-strata::radio name="success-state" value="2" state="success" label="Valid checked" checked />
                    </div>
                </div>

                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Error</h3>
                    <div class="space-y-3">
                        <x-strata::radio name="error-state" value="1" state="error" label="Invalid option" />
                        <x-strata::radio name="error-state" value="2" state="error" label="Invalid checked" checked />
                    </div>
                </div>

                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Warning</h3>
                    <div class="space-y-3">
                        <x-strata::radio name="warning-state" value="1" state="warning" label="Warning option" />
                        <x-strata::radio name="warning-state" value="2" state="warning" label="Warning checked" checked />
                    </div>
                </div>
            </div>
        </section>

        {{-- Radio Groups --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Radio Groups</h2>
                <p class="text-muted-foreground">Organize related radio buttons with group component</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Vertical Group --}}
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Vertical Group (Default)</h3>
                    <x-strata::radio.group label="Shipping Method">
                        <x-strata::radio name="shipping" value="standard" label="Standard Shipping" checked />
                        <x-strata::radio name="shipping" value="express" label="Express Shipping" />
                        <x-strata::radio name="shipping" value="overnight" label="Overnight Shipping" />
                    </x-strata::radio.group>
                </div>

                {{-- Horizontal Group --}}
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Horizontal Group</h3>
                    <x-strata::radio.group label="Rate this feature" orientation="horizontal">
                        <x-strata::radio name="rating" value="1" label="Poor" />
                        <x-strata::radio name="rating" value="2" label="Good" checked />
                        <x-strata::radio name="rating" value="3" label="Excellent" />
                    </x-strata::radio.group>
                </div>

                {{-- Group with Error --}}
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Group with Error State</h3>
                    <x-strata::radio.group
                        label="Payment Method"
                        error="Please select a payment method"
                    >
                        <x-strata::radio name="payment-error" value="credit" label="Credit Card" state="error" />
                        <x-strata::radio name="payment-error" value="debit" label="Debit Card" state="error" />
                        <x-strata::radio name="payment-error" value="paypal" label="PayPal" state="error" />
                    </x-strata::radio.group>
                </div>

                {{-- Group with Success --}}
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Group with Success</h3>
                    <x-strata::radio.group label="Subscription Plan">
                        <x-strata::radio name="plan-success" value="free" label="Free Plan" state="success" />
                        <x-strata::radio name="plan-success" value="pro" label="Pro Plan" state="success" checked />
                        <x-strata::radio name="plan-success" value="enterprise" label="Enterprise Plan" state="success" />
                    </x-strata::radio.group>
                </div>
            </div>
        </section>

        {{-- Custom Labels --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Custom Labels</h2>
                <p class="text-muted-foreground">Rich label content using slots</p>
            </div>

            <div class="bg-card border border-border rounded-lg p-8">
                <div class="space-y-6">
                    <x-strata::radio name="custom" value="1">
                        <span class="font-semibold text-base">One-Time Purchase</span>
                        <span class="text-sm text-muted-foreground block mt-1">
                            Pay $99 once and own the software forever
                        </span>
                    </x-strata::radio>

                    <x-strata::radio name="custom" value="2" checked>
                        <span class="font-semibold text-base">Monthly Subscription</span>
                        <span class="text-sm text-muted-foreground block mt-1">
                            Pay $9/month with automatic updates and support
                        </span>
                    </x-strata::radio>

                    <x-strata::radio name="custom" value="3">
                        <div class="flex items-start gap-3">
                            <div class="flex-1">
                                <span class="font-semibold text-base block">Annual Subscription</span>
                                <span class="text-sm text-muted-foreground block mt-1">
                                    Pay $89/year and save 17% compared to monthly
                                </span>
                            </div>
                            <x-strata::badge variant="success" size="sm">Best Value</x-strata::badge>
                        </div>
                    </x-strata::radio>
                </div>
            </div>
        </section>

        {{-- Real-World Examples --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Real-World Examples</h2>
                <p class="text-muted-foreground">Practical radio button implementations</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Shipping Options --}}
                <div class="bg-card border border-border rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg">Delivery Options</h3>
                        <x-strata::badge variant="primary" size="sm">Step 2 of 3</x-strata::badge>
                    </div>
                    <div class="space-y-3">
                        <x-strata::radio name="delivery" value="standard" checked>
                            <span class="font-medium">Standard Delivery (5-7 days)</span>
                            <span class="text-sm text-muted-foreground block">Free</span>
                        </x-strata::radio>
                        <x-strata::radio name="delivery" value="express">
                            <span class="font-medium">Express Delivery (2-3 days)</span>
                            <span class="text-sm text-muted-foreground block">$9.99</span>
                        </x-strata::radio>
                        <x-strata::radio name="delivery" value="overnight">
                            <span class="font-medium">Overnight Delivery (1 day)</span>
                            <span class="text-sm text-muted-foreground block">$24.99</span>
                        </x-strata::radio>
                    </div>
                </div>

                {{-- Settings Panel --}}
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Theme Preference</h3>
                    <div class="space-y-4">
                        <x-strata::radio name="theme" value="light">
                            <span class="font-medium">Light Mode</span>
                            <span class="text-sm text-muted-foreground block">Always use light theme</span>
                        </x-strata::radio>
                        <x-strata::radio name="theme" value="dark">
                            <span class="font-medium">Dark Mode</span>
                            <span class="text-sm text-muted-foreground block">Always use dark theme</span>
                        </x-strata::radio>
                        <x-strata::radio name="theme" value="system" checked>
                            <span class="font-medium">System Default</span>
                            <span class="text-sm text-muted-foreground block">Follow system preferences</span>
                        </x-strata::radio>
                    </div>
                </div>

                {{-- Account Type --}}
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Select Account Type</h3>
                    <div class="space-y-4">
                        <x-strata::radio name="account" value="personal" checked>
                            <span class="font-medium">Personal</span>
                            <span class="text-sm text-muted-foreground block">For individual use with basic features</span>
                        </x-strata::radio>
                        <x-strata::radio name="account" value="business">
                            <span class="font-medium">Business</span>
                            <span class="text-sm text-muted-foreground block">For teams with collaboration tools</span>
                        </x-strata::radio>
                        <x-strata::radio name="account" value="enterprise">
                            <span class="font-medium">Enterprise</span>
                            <span class="text-sm text-muted-foreground block">For large organizations with advanced features</span>
                        </x-strata::radio>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-card border border-border rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Payment Method</h3>
                    <div class="space-y-4">
                        <x-strata::radio name="payment" value="credit" state="success" checked>
                            <span class="font-medium">Credit Card</span>
                            <span class="text-sm text-muted-foreground block">Visa, Mastercard, Amex accepted</span>
                        </x-strata::radio>
                        <x-strata::radio name="payment" value="paypal" state="success">
                            <span class="font-medium">PayPal</span>
                            <span class="text-sm text-muted-foreground block">Fast and secure checkout</span>
                        </x-strata::radio>
                        <x-strata::radio name="payment" value="crypto" state="success">
                            <span class="font-medium">Cryptocurrency</span>
                            <span class="text-sm text-muted-foreground block">Bitcoin, Ethereum accepted</span>
                        </x-strata::radio>
                    </div>
                </div>
            </div>
        </section>

        {{-- Bordered Variant --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Bordered Variant</h2>
                <p class="text-muted-foreground">Radio buttons with bordered container, perfect for forms</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <x-strata::radio
                        variant="bordered"
                        name="bordered-options"
                        value="1"
                        label="Email notifications"
                        description="Get notified about important updates via email"
                    />
                    <x-strata::radio
                        variant="bordered"
                        name="bordered-options"
                        value="2"
                        label="SMS notifications"
                        description="Receive text messages for urgent alerts"
                        checked
                    />
                    <x-strata::radio
                        variant="bordered"
                        name="bordered-options"
                        value="3"
                        label="Push notifications"
                        description="Get real-time updates on your device"
                    />
                </div>

                <div class="space-y-4">
                    <x-strata::radio
                        variant="bordered"
                        size="sm"
                        name="bordered-sizes"
                        value="1"
                        label="Small bordered"
                        description="Compact size variant"
                    />
                    <x-strata::radio
                        variant="bordered"
                        size="lg"
                        name="bordered-sizes"
                        value="2"
                        label="Large bordered"
                        description="Large size variant"
                        checked
                    />
                    <x-strata::radio
                        variant="bordered"
                        name="bordered-disabled"
                        value="3"
                        label="Disabled bordered"
                        description="Cannot be changed"
                        disabled
                    />
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-strata::radio
                    variant="bordered"
                    state="default"
                    name="bordered-states-1"
                    value="1"
                    label="Default state"
                    description="Standard appearance"
                />
                <x-strata::radio
                    variant="bordered"
                    state="success"
                    name="bordered-states-2"
                    value="1"
                    label="Success state"
                    description="Valid selection"
                    checked
                />
                <x-strata::radio
                    variant="bordered"
                    state="error"
                    name="bordered-states-3"
                    value="1"
                    label="Error state"
                    description="Invalid selection"
                />
                <x-strata::radio
                    variant="bordered"
                    state="warning"
                    name="bordered-states-4"
                    value="1"
                    label="Warning state"
                    description="Needs attention"
                />
            </div>
        </section>

        {{-- Pill Variant --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Pill Variant</h2>
                <p class="text-muted-foreground">Tag/chip style radio buttons for compact selections</p>
            </div>

            <div class="bg-card border border-border rounded-lg p-8">
                <div class="mb-6">
                    <h3 class="font-semibold mb-3">Experience Level</h3>
                    <div class="flex flex-wrap gap-2">
                        <x-strata::radio variant="pill" name="experience" value="beginner" label="Beginner" />
                        <x-strata::radio variant="pill" name="experience" value="intermediate" label="Intermediate" checked />
                        <x-strata::radio variant="pill" name="experience" value="advanced" label="Advanced" />
                        <x-strata::radio variant="pill" name="experience" value="expert" label="Expert" />
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold mb-3">Size Variants</h3>
                    <div class="flex flex-wrap gap-3 items-center">
                        <x-strata::radio variant="pill" size="sm" name="pill-sizes" value="sm" label="Small" />
                        <x-strata::radio variant="pill" size="md" name="pill-sizes" value="md" label="Medium" checked />
                        <x-strata::radio variant="pill" size="lg" name="pill-sizes" value="lg" label="Large" />
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold mb-3">Priority Level</h3>
                    <div class="flex flex-wrap gap-2">
                        <x-strata::radio variant="pill" name="priority" value="low" label="Low" />
                        <x-strata::radio variant="pill" name="priority" value="medium" label="Medium" checked />
                        <x-strata::radio variant="pill" name="priority" value="high" label="High" />
                        <x-strata::radio variant="pill" name="priority" value="urgent" label="Urgent" />
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold mb-3">States</h3>
                    <div class="flex flex-wrap gap-2">
                        <x-strata::radio variant="pill" name="pill-states-1" value="1" label="Default" />
                        <x-strata::radio variant="pill" name="pill-states-2" value="1" label="Checked" checked />
                        <x-strata::radio variant="pill" name="pill-states-3" value="1" label="Disabled" disabled />
                        <x-strata::radio variant="pill" name="pill-states-4" value="1" label="Disabled Checked" disabled checked />
                    </div>
                </div>
            </div>
        </section>

        {{-- Card Variant --}}
        <section class="mb-16">
            <div class="mb-6">
                <h2 class="text-3xl font-bold mb-2">Card Variant</h2>
                <p class="text-muted-foreground">Large card-style radio buttons for important selections</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-strata::radio
                    variant="card"
                    name="plans"
                    value="basic"
                    label="Basic Plan"
                    description="Perfect for individuals and small teams. Includes 5 projects and 10GB storage."
                />
                <x-strata::radio
                    variant="card"
                    name="plans"
                    value="pro"
                    label="Pro Plan"
                    description="For growing businesses. Unlimited projects, 100GB storage, priority support."
                    checked
                />
                <x-strata::radio
                    variant="card"
                    name="plans"
                    value="enterprise"
                    label="Enterprise"
                    description="Advanced features for large organizations. Custom storage, dedicated account manager."
                />

                <x-strata::radio
                    variant="card"
                    name="support"
                    value="email"
                    label="Email Support"
                    description="Get help via email within 24 hours"
                    state="success"
                    checked
                />
                <x-strata::radio
                    variant="card"
                    name="support"
                    value="phone"
                    label="Phone Support"
                    description="Talk to our team during business hours"
                    state="error"
                />
                <x-strata::radio
                    variant="card"
                    name="support"
                    value="chat"
                    label="Chat Support"
                    description="Real-time assistance via live chat"
                    state="warning"
                />

                <x-strata::radio
                    variant="card"
                    size="sm"
                    name="card-sizes-1"
                    value="1"
                    label="Small Card"
                    description="Compact card variant"
                />
                <x-strata::radio
                    variant="card"
                    size="lg"
                    name="card-sizes-2"
                    value="1"
                    label="Large Card"
                    description="Spacious card variant"
                    checked
                />
                <x-strata::radio
                    variant="card"
                    name="card-disabled"
                    value="1"
                    label="Disabled Card"
                    description="Cannot be selected"
                    disabled
                />
            </div>
        </section>

        {{-- Dark Mode Toggle --}}
        <div class="fixed bottom-6 right-6">
            <x-strata::button.icon
                icon="moon"
                x-on:click="darkMode = !darkMode"
                variant="secondary"
                size="lg"
                class="shadow-lg"
            />
        </div>
    </div>

    @livewireScripts
</body>
</html>
