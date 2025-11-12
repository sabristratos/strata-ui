<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">Phone Input Component Demo</h1>
            <p class="text-muted-foreground">International phone number input with country selector, auto-formatting, validation, and country detection.</p>
        </div>

        @if (session()->has('message'))
            <div class="p-4 bg-success/10 border border-success rounded-lg text-success">
                {{ session('message') }}
            </div>
        @endif

        <x-strata::card class="p-6">
            <template x-slot:header>
                <h2 class="text-xl font-semibold">Basic Example</h2>
            </template>

            <div class="space-y-4">
                <div>
                    <x-strata::field.label for="phone-basic" required>Phone Number</x-strata::field.label>
                    <x-strata::phone-input
                        wire:model="phone"
                        id="phone-basic"
                        :countries="$countries"
                        default-country="US"
                        required
                        placeholder="Enter your phone number"
                    />
                    <x-strata::field.hint>Enter phone number in E.164 format (e.g., +15551234567)</x-strata::field.hint>
                </div>

                <div class="flex gap-2">
                    <x-strata::button wire:click="submit" variant="primary">
                        Submit
                    </x-strata::button>
                    <x-strata::button wire:click="resetPhone" variant="outline">
                        Reset
                    </x-strata::button>
                </div>

                @if($phone)
                    <div class="p-4 bg-muted rounded-lg">
                        <p class="text-sm font-medium mb-1">Current Value:</p>
                        <code class="text-sm">{{ $phone }}</code>
                    </div>
                @endif
            </div>
        </x-strata::card>

        <x-strata::card class="p-6">
            <template x-slot:header>
                <h2 class="text-xl font-semibold">Different Sizes</h2>
            </template>

            <div class="space-y-6">
                <div>
                    <x-strata::field.label>Small</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="GB"
                        size="sm"
                    />
                </div>

                <div>
                    <x-strata::field.label>Medium (Default)</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="CA"
                        size="md"
                    />
                </div>

                <div>
                    <x-strata::field.label>Large</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="AU"
                        size="lg"
                    />
                </div>
            </div>
        </x-strata::card>

        <x-strata::card class="p-6">
            <template x-slot:header>
                <h2 class="text-xl font-semibold">Validation States</h2>
            </template>

            <div class="space-y-6">
                <div>
                    <x-strata::field.label>Default State</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="DE"
                        state="default"
                    />
                </div>

                <div>
                    <x-strata::field.label>Success State</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="FR"
                        state="success"
                        value="+33612345678"
                    />
                    <x-strata::field.hint>Phone number is valid!</x-strata::field.hint>
                </div>

                <div>
                    <x-strata::field.label>Error State</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="IT"
                        state="error"
                    />
                    <x-strata::field.error>Please enter a valid phone number</x-strata::field.error>
                </div>

                <div>
                    <x-strata::field.label>Warning State</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="ES"
                        state="warning"
                    />
                </div>
            </div>
        </x-strata::card>

        <x-strata::card class="p-6">
            <template x-slot:header>
                <h2 class="text-xl font-semibold">Component States</h2>
            </template>

            <div class="space-y-6">
                <div>
                    <x-strata::field.label>Disabled</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="MX"
                        value="+525512345678"
                        disabled
                    />
                </div>

                <div>
                    <x-strata::field.label>Readonly</x-strata::field.label>
                    <x-strata::phone-input
                        :countries="$countries"
                        default-country="BR"
                        value="+5511987654321"
                        readonly
                    />
                </div>
            </div>
        </x-strata::card>

        <x-strata::card class="p-6">
            <template x-slot:header>
                <h2 class="text-xl font-semibold">Features</h2>
            </template>

            <div class="space-y-4">
                <ul class="list-disc list-inside space-y-2 text-muted-foreground">
                    <li>Country selector with flag icons</li>
                    <li>Searchable country dropdown</li>
                    <li>Auto-formatting based on country</li>
                    <li>Phone number validation</li>
                    <li>Country detection from number (type +1, +44, etc.)</li>
                    <li>Display calling code in UI</li>
                    <li>E.164 format output</li>
                    <li>Livewire integration</li>
                    <li>Multiple size variants (xs, sm, md, lg, xl)</li>
                    <li>Validation states (default, success, error, warning)</li>
                    <li>Disabled and readonly states</li>
                </ul>
            </div>
        </x-strata::card>
    </div>
</div>
