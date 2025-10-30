<div class="space-y-12">
    @if($message)
        <x-strata::alert variant="success">
            {{ $message }}
        </x-strata::alert>
    @endif

    <div>
        <h3 class="text-lg font-semibold mb-4">Contact Methods (Multiple Field Types)</h3>
        <p class="text-sm text-muted-foreground mb-4">Minimum 1 contact required. Demonstrates complex form fields within repeater items.</p>

        <form wire:submit="submitContacts">
            <x-strata::repeater wire:model="contacts" :min="1" add-label="Add Contact">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-strata::form.label ::for="'contact-name-' + itemIndex">Name</x-strata::form.label>
                        <x-strata::input
                            ::id="'contact-name-' + itemIndex"
                            x-model="items[itemIndex].name"
                            placeholder="John Doe"
                        />
                    </div>

                    <div>
                        <x-strata::form.label ::for="'contact-email-' + itemIndex">Email</x-strata::form.label>
                        <x-strata::input
                            ::id="'contact-email-' + itemIndex"
                            type="email"
                            x-model="items[itemIndex].email"
                            placeholder="john@example.com"
                        />
                    </div>

                    <div>
                        <x-strata::form.label ::for="'contact-phone-' + itemIndex">Phone</x-strata::form.label>
                        <x-strata::input
                            ::id="'contact-phone-' + itemIndex"
                            type="tel"
                            x-model="items[itemIndex].phone"
                            placeholder="555-0100"
                        />
                    </div>
                </div>
            </x-strata::repeater>

            <div class="mt-4">
                <x-strata::button type="submit">Save Contacts</x-strata::button>
            </div>
        </form>

        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current State:</p>
            <pre class="text-xs overflow-auto">{{ json_encode($contacts, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Social Links (Key-Value Pairs)</h3>
        <p class="text-sm text-muted-foreground mb-4">Simple platform and URL pairs. No minimum or maximum limits.</p>

        <form wire:submit="submitSocialLinks">
            <x-strata::repeater wire:model="socialLinks" add-label="Add Social Link">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-strata::form.label ::for="'social-platform-' + itemIndex">Platform</x-strata::form.label>
                        <x-strata::input
                            ::id="'social-platform-' + itemIndex"
                            x-model="items[itemIndex].platform"
                            placeholder="Twitter"
                        />
                    </div>

                    <div>
                        <x-strata::form.label ::for="'social-url-' + itemIndex">URL</x-strata::form.label>
                        <x-strata::input
                            ::id="'social-url-' + itemIndex"
                            type="url"
                            x-model="items[itemIndex].url"
                            placeholder="https://twitter.com/username"
                        />
                    </div>
                </div>
            </x-strata::repeater>

            <div class="mt-4">
                <x-strata::button type="submit">Save Social Links</x-strata::button>
            </div>
        </form>

        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current State:</p>
            <pre class="text-xs overflow-auto">{{ json_encode($socialLinks, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Product Features (Min/Max Constraints)</h3>
        <p class="text-sm text-muted-foreground mb-4">Between 3-6 features required. Demonstrates constraint handling.</p>

        <form wire:submit="submitFeatures">
            <x-strata::repeater wire:model="features" :min="3" :max="6" add-label="Add Feature" size="sm">
                <div>
                    <x-strata::input
                        x-model="items[itemIndex].title"
                        placeholder="Feature title"
                        size="sm"
                    />
                </div>
            </x-strata::repeater>

            <div class="mt-4">
                <x-strata::button type="submit" size="sm">Save Features</x-strata::button>
            </div>
        </form>

        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current State ({{ count($features) }}/6):</p>
            <pre class="text-xs overflow-auto">{{ json_encode($features, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
</div>
