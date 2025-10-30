<div class="space-y-12">
    <div>
        <h3 class="text-lg font-semibold mb-4">Bordered Variant (Single Mode)</h3>
        <p class="text-sm text-muted-foreground mb-4">Only one item can be open at a time.</p>
        <x-strata::accordion type="single" variant="bordered" :defaultValue="['faq-1']">
            @foreach($faqData as $faq)
                <x-strata::accordion.item :value="$faq['id']">
                    <x-slot:trigger>
                        <h4 class="font-medium">{{ $faq['question'] }}</h4>
                    </x-slot:trigger>
                    <x-slot:content>
                        <p class="text-sm">{{ $faq['answer'] }}</p>
                    </x-slot:content>
                </x-strata::accordion.item>
            @endforeach
        </x-strata::accordion>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Divided Variant (Multiple Mode)</h3>
        <p class="text-sm text-muted-foreground mb-4">Multiple items can be open at the same time.</p>
        <x-strata::accordion type="multiple" variant="divided" :defaultValue="['faq-1', 'faq-3']">
            @foreach($faqData as $faq)
                <x-strata::accordion.item :value="$faq['id']">
                    <x-slot:trigger>
                        <h4 class="font-medium">{{ $faq['question'] }}</h4>
                    </x-slot:trigger>
                    <x-slot:content>
                        <p class="text-sm">{{ $faq['answer'] }}</p>
                    </x-slot:content>
                </x-strata::accordion.item>
            @endforeach
        </x-strata::accordion>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Card Variant</h3>
        <p class="text-sm text-muted-foreground mb-4">Elevated card appearance with shadows.</p>
        <x-strata::accordion type="multiple" variant="card">
            @foreach(array_slice($faqData, 0, 3) as $faq)
                <x-strata::accordion.item :value="$faq['id']">
                    <x-slot:trigger>
                        <h4 class="font-medium">{{ $faq['question'] }}</h4>
                    </x-slot:trigger>
                    <x-slot:content>
                        <p class="text-sm">{{ $faq['answer'] }}</p>
                    </x-slot:content>
                </x-strata::accordion.item>
            @endforeach
        </x-strata::accordion>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Minimal Variant</h3>
        <p class="text-sm text-muted-foreground mb-4">Clean, borderless design.</p>
        <x-strata::accordion type="multiple" variant="minimal">
            @foreach(array_slice($faqData, 0, 3) as $faq)
                <x-strata::accordion.item :value="$faq['id']">
                    <x-slot:trigger>
                        <h4 class="font-medium">{{ $faq['question'] }}</h4>
                    </x-slot:trigger>
                    <x-slot:content>
                        <p class="text-sm">{{ $faq['answer'] }}</p>
                    </x-slot:content>
                </x-strata::accordion.item>
            @endforeach
        </x-strata::accordion>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Custom Icons</h3>
        <p class="text-sm text-muted-foreground mb-4">Using custom icons via the icon slot.</p>
        <x-strata::accordion type="single" variant="bordered">
            <x-strata::accordion.item value="custom-1" icon="chevron-down">
                <x-slot:trigger>
                    <h4 class="font-medium">Chevron Down Icon</h4>
                </x-slot:trigger>
                <x-slot:content>
                    <p class="text-sm">This accordion item uses a chevron-down icon instead of the default chevron-right.</p>
                </x-slot:content>
            </x-strata::accordion.item>

            <x-strata::accordion.item value="custom-2" icon="plus">
                <x-slot:trigger>
                    <h4 class="font-medium">Plus Icon</h4>
                </x-slot:trigger>
                <x-slot:content>
                    <p class="text-sm">This accordion item uses a plus icon.</p>
                </x-slot:content>
            </x-strata::accordion.item>
        </x-strata::accordion>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Disabled State</h3>
        <p class="text-sm text-muted-foreground mb-4">Accordion items can be disabled.</p>
        <x-strata::accordion type="multiple" variant="bordered">
            <x-strata::accordion.item value="disabled-1">
                <x-slot:trigger>
                    <h4 class="font-medium">Enabled Item</h4>
                </x-slot:trigger>
                <x-slot:content>
                    <p class="text-sm">This item is enabled and can be toggled.</p>
                </x-slot:content>
            </x-strata::accordion.item>

            <x-strata::accordion.item value="disabled-2" :disabled="true">
                <x-slot:trigger>
                    <h4 class="font-medium">Disabled Item</h4>
                </x-slot:trigger>
                <x-slot:content>
                    <p class="text-sm">This item is disabled and cannot be toggled.</p>
                </x-slot:content>
            </x-strata::accordion.item>
        </x-strata::accordion>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Rich Content</h3>
        <p class="text-sm text-muted-foreground mb-4">Accordion items can contain rich content.</p>
        <x-strata::accordion type="single" variant="card">
            <x-strata::accordion.item value="rich-1">
                <x-slot:trigger>
                    <div>
                        <h4 class="font-medium">Installation Steps</h4>
                        <p class="text-xs text-muted-foreground mt-1">Learn how to install Strata UI</p>
                    </div>
                </x-slot:trigger>
                <x-slot:content>
                    <ol class="text-sm space-y-2 list-decimal list-inside">
                        <li>Install via Composer: <code class="bg-muted px-2 py-1 rounded text-xs">composer require strata-ui/strata-ui</code></li>
                        <li>Publish the config file</li>
                        <li>Include the Blade directives in your layout</li>
                        <li>Start using components!</li>
                    </ol>
                </x-slot:content>
            </x-strata::accordion.item>

            <x-strata::accordion.item value="rich-2">
                <x-slot:trigger>
                    <div>
                        <h4 class="font-medium">Component Features</h4>
                        <p class="text-xs text-muted-foreground mt-1">What makes Strata UI special</p>
                    </div>
                </x-slot:trigger>
                <x-slot:content>
                    <ul class="text-sm space-y-2 list-disc list-inside">
                        <li>Built with Tailwind CSS v4</li>
                        <li>Seamless Livewire integration</li>
                        <li>Dark mode support</li>
                        <li>Highly customizable</li>
                        <li>Modern CSS animations</li>
                    </ul>
                </x-slot:content>
            </x-strata::accordion.item>
        </x-strata::accordion>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Livewire Integration</h3>
        <p class="text-sm text-muted-foreground mb-4">Accordion works seamlessly with Livewire.</p>
        <x-strata::accordion type="single" variant="bordered">
            <x-strata::accordion.item value="livewire-1">
                <x-slot:trigger>
                    <h4 class="font-medium">Current Time</h4>
                </x-slot:trigger>
                <x-slot:content>
                    <p class="text-sm">The current timestamp is: {{ now()->format('Y-m-d H:i:s') }}</p>
                    <p class="text-xs text-muted-foreground mt-2">This content is rendered via Livewire.</p>
                </x-slot:content>
            </x-strata::accordion.item>

            <x-strata::accordion.item value="livewire-2">
                <x-slot:trigger>
                    <h4 class="font-medium">Selected FAQ Count</h4>
                </x-slot:trigger>
                <x-slot:content>
                    <p class="text-sm">Total FAQ items: {{ count($faqData) }}</p>
                    <p class="text-xs text-muted-foreground mt-2">This data comes from the Livewire component.</p>
                </x-slot:content>
            </x-strata::accordion.item>
        </x-strata::accordion>
    </div>
</div>
