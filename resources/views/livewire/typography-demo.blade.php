<div class="space-y-16 p-8">
    {{-- Heading Showcase --}}
    <section>
        <x-strata::text variant="overline" class="mb-4">Typography Components</x-strata::text>
        <x-strata::heading level="1" variant="gradient" class="mb-4">
            Typography Showcase
        </x-strata::heading>
        <x-strata::text variant="lead">
            Explore Strata UI's typography components with beautiful, consistent styling.
        </x-strata::text>
    </section>

    {{-- Heading Levels --}}
    <section>
        <x-strata::heading level="2" class="mb-6">
            Heading Levels
        </x-strata::heading>

        <div class="space-y-4">
            <div>
                <x-strata::heading level="1">Heading Level 1</x-strata::heading>
                <x-strata::text variant="small">text-4xl md:text-5xl font-bold tracking-tight</x-strata::text>
            </div>

            <div>
                <x-strata::heading level="2">Heading Level 2</x-strata::heading>
                <x-strata::text variant="small">text-3xl md:text-4xl font-bold tracking-tight</x-strata::text>
            </div>

            <div>
                <x-strata::heading level="3">Heading Level 3</x-strata::heading>
                <x-strata::text variant="small">text-2xl md:text-3xl font-semibold</x-strata::text>
            </div>

            <div>
                <x-strata::heading level="4">Heading Level 4</x-strata::heading>
                <x-strata::text variant="small">text-xl md:text-2xl font-semibold</x-strata::text>
            </div>

            <div>
                <x-strata::heading level="5">Heading Level 5</x-strata::heading>
                <x-strata::text variant="small">text-lg md:text-xl font-semibold</x-strata::text>
            </div>

            <div>
                <x-strata::heading level="6">Heading Level 6</x-strata::heading>
                <x-strata::text variant="small">text-base md:text-lg font-semibold</x-strata::text>
            </div>
        </div>
    </section>

    {{-- Heading Variants --}}
    <section>
        <x-strata::heading level="2" class="mb-6">
            Heading Variants
        </x-strata::heading>

        <div class="space-y-4">
            <div>
                <x-strata::heading level="1">Default Variant</x-strata::heading>
                <x-strata::text variant="small">Standard foreground color</x-strata::text>
            </div>

            <div>
                <x-strata::heading level="1" variant="gradient">Gradient Variant</x-strata::heading>
                <x-strata::text variant="small">Eye-catching gradient from primary to info</x-strata::text>
            </div>

            <div>
                <x-strata::heading level="1" variant="muted">Muted Variant</x-strata::heading>
                <x-strata::text variant="small">Subtle muted foreground color</x-strata::text>
            </div>
        </div>
    </section>

    {{-- Text Variants --}}
    <section>
        <x-strata::heading level="2" class="mb-6">
            Text Variants
        </x-strata::heading>

        <div class="space-y-6">
            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Lead</x-strata::text>
                <x-strata::text variant="lead">
                    This is lead text, perfect for introductory paragraphs and summaries. It's larger and muted to draw attention without overwhelming.
                </x-strata::text>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Body (Default)</x-strata::text>
                <x-strata::text>
                    This is regular body text with the default variant. It's optimized for readability with proper line height and spacing for paragraphs.
                </x-strata::text>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Large</x-strata::text>
                <x-strata::text variant="large">
                    This is large text for important information that needs more emphasis than body text.
                </x-strata::text>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Small</x-strata::text>
                <x-strata::text variant="small">
                    This is small text for captions, hints, or supplementary information. Perfect for metadata.
                </x-strata::text>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Muted</x-strata::text>
                <x-strata::text variant="muted">
                    This is muted text for de-emphasized content that's less important than primary information.
                </x-strata::text>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Overline</x-strata::text>
                <x-strata::text variant="overline">Section Label</x-strata::text>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Quote</x-strata::text>
                <x-strata::text variant="quote">
                    "Strata UI has completely transformed our development workflow. The typography components make it easy to maintain consistent styling across our entire application."
                </x-strata::text>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Code</x-strata::text>
                <x-strata::text>
                    Install the package with <x-strata::text variant="code">composer require strata-ui</x-strata::text> and you're ready to go!
                </x-strata::text>
            </div>
        </div>
    </section>

    {{-- Prose Component --}}
    <section>
        <x-strata::heading level="2" class="mb-6">
            Prose Component
        </x-strata::heading>

        <x-strata::text class="mb-6">
            The prose component automatically styles rich content and markdown:
        </x-strata::text>

        <x-strata::prose>
            <h3>Getting Started</h3>
            <p>
                Strata UI is a modern Blade and Livewire component library for Laravel. It provides beautiful,
                accessible components that integrate seamlessly with your application.
            </p>

            <h4>Features</h4>
            <ul>
                <li>28+ production-ready components</li>
                <li>Full Livewire 3 integration</li>
                <li>Built with Tailwind CSS v4</li>
                <li>Comprehensive accessibility</li>
                <li>Light and dark mode support</li>
            </ul>

            <h4>Installation</h4>
            <p>
                Install via Composer:
            </p>

            <pre><code>composer require strata-ui/strata-ui
php artisan vendor:publish --tag=strata-ui-assets</code></pre>

            <blockquote>
                <p>Make sure you have Laravel 12, Livewire 3, and Tailwind CSS v4 installed.</p>
            </blockquote>

            <h4>Example Component</h4>
            <p>
                Use components with the <code>x-strata::</code> prefix:
            </p>

            <pre><code>&lt;x-strata::button variant="primary"&gt;
    Click Me
&lt;/x-strata::button&gt;</code></pre>

            <p>
                For more information, visit the <a href="#">official documentation</a>.
            </p>
        </x-strata::prose>
    </section>

    {{-- Real-world Example --}}
    <section>
        <x-strata::heading level="2" class="mb-6">
            Real-world Example
        </x-strata::heading>

        <x-strata::card>
            <x-strata::card.body>
                <x-strata::text variant="overline" class="mb-2">Product Update</x-strata::text>

                <x-strata::heading level="3" class="mb-2">
                    Strata UI v1.0 Released
                </x-strata::heading>

                <x-strata::text variant="lead" class="mb-4">
                    We're excited to announce the first stable release of Strata UI with comprehensive typography components.
                </x-strata::text>

                <x-strata::text class="mb-4">
                    This release includes three new components: Heading, Text, and Prose. Each component is designed to work
                    seamlessly together while providing extensive customization options.
                </x-strata::text>

                <x-strata::text variant="small">
                    Released on January 15, 2025
                </x-strata::text>
            </x-strata::card.body>
        </x-strata::card>
    </section>

    {{-- Prose Sizes --}}
    <section>
        <x-strata::heading level="2" class="mb-6">
            Prose Sizes
        </x-strata::heading>

        <div class="space-y-8">
            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Small (sm)</x-strata::text>
                <x-strata::prose size="sm">
                    <h4>Small Prose</h4>
                    <p>This is prose with the <code>sm</code> size variant, perfect for sidebars or compact layouts.</p>
                </x-strata::prose>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Base (default)</x-strata::text>
                <x-strata::prose size="base">
                    <h4>Base Prose</h4>
                    <p>This is prose with the <code>base</code> size variant, the default for most content.</p>
                </x-strata::prose>
            </div>

            <div>
                <x-strata::text variant="small" class="font-medium mb-2">Large (lg)</x-strata::text>
                <x-strata::prose size="lg">
                    <h4>Large Prose</h4>
                    <p>This is prose with the <code>lg</code> size variant, great for feature articles.</p>
                </x-strata::prose>
            </div>
        </div>
    </section>
</div>
