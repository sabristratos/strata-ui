# Accordion

Modern collapsible panels with smooth CSS animations, multiple variants, and flexible content options using native HTML `<details>` and `<summary>` elements.

## Props Reference

### Accordion Wrapper

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | string | `single` | Accordion type (`single`, `multiple`) |
| `default-value` | string\|array | `null` | Default open item(s) - string for single, array for multiple |
| `variant` | string | `bordered` | Visual style variant |

### Accordion Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | auto-generated | Unique identifier for the item |
| `disabled` | boolean | `false` | Disable open/close interaction |
| `icon` | string | `chevron-right` | Icon name for expand/collapse indicator |

## Variants

All accordions support 4 visual style variants:

- **`bordered`** - Individual bordered panels with background (default)
- **`divided`** - Borderless items with dividing lines between
- **`card`** - Elevated card-style panels with shadow
- **`minimal`** - Clean, no borders or background

## Single Accordion

Only one item can be open at a time. Opening a new item closes the previously open one.

### Bordered Style (Default)

```blade
<x-strata::accordion type="single" default-value="item-1">
    <x-strata::accordion.item value="item-1">
        <x-slot:trigger>
            <h4 class="font-medium">What is Strata UI?</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Strata UI is a modern Blade and Livewire component library for Laravel, built with Tailwind CSS v4 and Alpine.js.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-2">
        <x-slot:trigger>
            <h4 class="font-medium">How do I install it?</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Install via Composer: <code class="bg-muted px-2 py-1 rounded text-xs">composer require strata-ui/strata-ui</code></p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-3">
        <x-slot:trigger>
            <h4 class="font-medium">Is it customizable?</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Yes! All components support full Tailwind customization through props, slots, and theme variables.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

### Divided Style

Clean dividing lines between items, no individual borders:

```blade
<x-strata::accordion type="single" variant="divided" default-value="faq-1">
    <x-strata::accordion.item value="faq-1">
        <x-slot:trigger>
            <h4 class="font-medium">Can I use this in production?</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Yes! Strata UI is production-ready with comprehensive testing and full Laravel support.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="faq-2">
        <x-slot:trigger>
            <h4 class="font-medium">Does it work with Livewire?</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Absolutely! Built specifically for Livewire v3 with seamless reactive integration.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

### Card Style

Elevated panels with shadow for emphasis:

```blade
<x-strata::accordion type="single" variant="card">
    <x-strata::accordion.item value="feature-1">
        <x-slot:trigger>
            <h4 class="font-medium">1,648+ Icons</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Complete Lucide icon set included with simple <code class="bg-muted px-1 rounded">strata::icon.name</code> syntax.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="feature-2">
        <x-slot:trigger>
            <h4 class="font-medium">Semantic Theming</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">75 design tokens with automatic light/dark mode support using CSS custom properties.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

### Minimal Style

Clean and borderless, for subtle UI:

```blade
<x-strata::accordion type="single" variant="minimal">
    <x-strata::accordion.item value="step-1">
        <x-slot:trigger>
            <h4 class="font-medium">Step 1: Install</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Run <code>composer require strata-ui/strata-ui</code></p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="step-2">
        <x-slot:trigger>
            <h4 class="font-medium">Step 2: Include Assets</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Add <code>@strataStyles</code> and <code>@strataScripts</code> to your layout.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Multiple Accordion

Multiple items can be open simultaneously. Each item toggles independently.

```blade
<x-strata::accordion type="multiple" :default-value="['tech-1', 'tech-3']">
    <x-strata::accordion.item value="tech-1">
        <x-slot:trigger>
            <h4 class="font-medium">Tailwind CSS v4</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Latest Tailwind with modern features: container queries, @starting-style, and more.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="tech-2">
        <x-slot:trigger>
            <h4 class="font-medium">Livewire v3</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Seamless reactive components with wire:model support and Livewire morphing compatibility.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="tech-3">
        <x-slot:trigger>
            <h4 class="font-medium">Alpine.js</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Lightweight JavaScript interactions for enhanced interactivity without complexity.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="tech-4">
        <x-slot:trigger>
            <h4 class="font-medium">Laravel 12</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Built for Laravel's latest features with modern PHP 8.3+ syntax.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Custom Icons

Override the default chevron with any Lucide icon:

```blade
<x-strata::accordion type="single">
    <x-strata::accordion.item value="item-1" icon="plus">
        <x-slot:trigger>
            <h4 class="font-medium">Add New Section</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Plus icon rotates to become an X when expanded.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-2" icon="arrow-down">
        <x-slot:trigger>
            <h4 class="font-medium">Download Details</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Arrow icon rotates 90° to point right when expanded.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Custom Icon Slot

For complete control, use the `iconSlot` to provide custom markup:

```blade
<x-strata::accordion type="single">
    <x-strata::accordion.item value="custom">
        <x-slot:trigger>
            <div class="flex items-center gap-2">
                <span class="text-2xl"><¯</span>
                <h4 class="font-medium">Custom Icon</h4>
            </div>
        </x-slot:trigger>
        <x-slot:iconSlot>
            <div class="w-6 h-6 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xs font-bold">
                ?
            </div>
        </x-slot:iconSlot>
        <x-slot:content>
            <p class="text-sm">You have full control over the icon area with custom HTML.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Disabled Items

Prevent interaction on specific items:

```blade
<x-strata::accordion type="single">
    <x-strata::accordion.item value="enabled">
        <x-slot:trigger>
            <h4 class="font-medium">Available Feature</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">This item can be opened and closed normally.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="disabled" :disabled="true">
        <x-slot:trigger>
            <h4 class="font-medium">Coming Soon</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">This content is currently unavailable.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Simplified Syntax

For simpler content, you can omit named slots:

```blade
<x-strata::accordion type="single">
    <x-strata::accordion.item value="simple-1">
        What is the simplified syntax?
        <x-slot:content>
            When you don't use the trigger slot, the main slot content becomes the trigger text.
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="simple-2">
        How does it work?
        <x-slot:content>
            The component automatically uses the main slot for the trigger if no trigger slot is provided.
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Rich Content

Accordion content supports any HTML markup:

```blade
<x-strata::accordion type="single" variant="card">
    <x-strata::accordion.item value="features">
        <x-slot:trigger>
            <h3 class="text-lg font-semibold">Feature Breakdown</h3>
        </x-slot:trigger>
        <x-slot:content>
            <div class="space-y-4">
                <div>
                    <h4 class="font-semibold text-sm mb-2">Core Components</h4>
                    <ul class="list-disc list-inside text-sm space-y-1 text-muted-foreground">
                        <li>Buttons, inputs, and form elements</li>
                        <li>Modals, dropdowns, and popovers</li>
                        <li>Tables, cards, and layouts</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-sm mb-2">Advanced Features</h4>
                    <ul class="list-disc list-inside text-sm space-y-1 text-muted-foreground">
                        <li>Date pickers and calendars</li>
                        <li>Rich text editors</li>
                        <li>File uploads with preview</li>
                    </ul>
                </div>
                <x-strata::button size="sm" variant="primary">
                    View Full Documentation
                </x-strata::button>
            </div>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Real-World Examples

### FAQ Section

```blade
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Frequently Asked Questions</h2>

    <x-strata::accordion type="single" variant="divided" default-value="faq-1">
        <x-strata::accordion.item value="faq-1">
            <x-slot:trigger>
                <h4 class="font-medium">What browsers are supported?</h4>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm text-muted-foreground">Strata UI supports all modern browsers including Chrome, Firefox, Safari, and Edge. IE11 is not supported.</p>
            </x-slot:content>
        </x-strata::accordion.item>

        <x-strata::accordion.item value="faq-2">
            <x-slot:trigger>
                <h4 class="font-medium">Is it free to use?</h4>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm text-muted-foreground">Yes! Strata UI is open source and free for both personal and commercial projects.</p>
            </x-slot:content>
        </x-strata::accordion.item>

        <x-strata::accordion.item value="faq-3">
            <x-slot:trigger>
                <h4 class="font-medium">Can I customize the components?</h4>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm text-muted-foreground">Absolutely! All components are fully customizable through Tailwind classes, props, slots, and you can publish views to modify them directly.</p>
            </x-slot:content>
        </x-strata::accordion.item>
    </x-strata::accordion>
</div>
```

### Settings Panel

```blade
<x-strata::accordion type="multiple" variant="card" :default-value="['general']">
    <x-strata::accordion.item value="general">
        <x-slot:trigger>
            <div class="flex items-center gap-2">
                <x-strata::icon.settings class="w-5 h-5" />
                <h4 class="font-medium">General Settings</h4>
            </div>
        </x-slot:trigger>
        <x-slot:content>
            <div class="space-y-4">
                <x-strata::input label="Site Name" value="My Application" />
                <x-strata::input label="Site URL" value="https://example.com" />
                <x-strata::textarea label="Description" rows="3" />
            </div>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="notifications">
        <x-slot:trigger>
            <div class="flex items-center gap-2">
                <x-strata::icon.bell class="w-5 h-5" />
                <h4 class="font-medium">Notifications</h4>
            </div>
        </x-slot:trigger>
        <x-slot:content>
            <div class="space-y-3">
                <x-strata::checkbox label="Email notifications" />
                <x-strata::checkbox label="Push notifications" />
                <x-strata::checkbox label="SMS notifications" />
            </div>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="security">
        <x-slot:trigger>
            <div class="flex items-center gap-2">
                <x-strata::icon.shield class="w-5 h-5" />
                <h4 class="font-medium">Security</h4>
            </div>
        </x-slot:trigger>
        <x-slot:content>
            <div class="space-y-4">
                <x-strata::checkbox label="Two-factor authentication" />
                <x-strata::checkbox label="Login notifications" />
                <x-strata::button size="sm" variant="destructive">
                    Sign Out All Devices
                </x-strata::button>
            </div>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

### Product Details

```blade
<x-strata::accordion type="single" variant="minimal">
    <x-strata::accordion.item value="specs">
        <x-slot:trigger>
            <h4 class="font-medium">Technical Specifications</h4>
        </x-slot:trigger>
        <x-slot:content>
            <dl class="grid grid-cols-2 gap-2 text-sm">
                <dt class="font-medium">Processor:</dt>
                <dd class="text-muted-foreground">M2 Pro</dd>
                <dt class="font-medium">Memory:</dt>
                <dd class="text-muted-foreground">16GB Unified</dd>
                <dt class="font-medium">Storage:</dt>
                <dd class="text-muted-foreground">512GB SSD</dd>
                <dt class="font-medium">Display:</dt>
                <dd class="text-muted-foreground">14.2" Liquid Retina XDR</dd>
            </dl>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="shipping">
        <x-slot:trigger>
            <h4 class="font-medium">Shipping & Returns</h4>
        </x-slot:trigger>
        <x-slot:content>
            <div class="text-sm space-y-2 text-muted-foreground">
                <p>Free shipping on orders over $50. Standard delivery takes 3-5 business days.</p>
                <p>30-day return policy. Items must be in original condition with tags attached.</p>
            </div>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="warranty">
        <x-slot:trigger>
            <h4 class="font-medium">Warranty Information</h4>
        </x-slot:trigger>
        <x-slot:content>
            <div class="text-sm space-y-2 text-muted-foreground">
                <p>1-year limited warranty included. Extended warranty available for purchase.</p>
                <p>Covers manufacturing defects and hardware failures under normal use.</p>
            </div>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Notes

- **Native HTML Elements**: Built on `<details>` and `<summary>` for semantic HTML and built-in keyboard accessibility
- **Smooth Animations**: CSS-based animations for smooth opening and closing transitions (300ms duration)
- **Single Mode**: Only one item open at a time, perfect for FAQs and space-constrained UIs
- **Multiple Mode**: Keep multiple items open simultaneously, ideal for settings panels and exploratory content
- **4 Visual Variants**: Choose between bordered, divided, card, or minimal styles
- **Flexible Content**: Support for simple text, rich HTML, form elements, buttons, and nested components
- **Icon Customization**: Use any of 1,648+ Lucide icons or provide completely custom icon markup
- **Disabled State**: Prevent interaction on specific items with visual feedback
- **Keyboard Accessible**: Full keyboard navigation support (Space/Enter to toggle, Tab to navigate)
- **ARIA Attributes**: Proper `aria-disabled` attributes for screen readers
- **Default Open State**: Pre-expand items on load with `default-value` prop (single string or array)
