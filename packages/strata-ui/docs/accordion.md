# Accordion

Modern accordion components built with native HTML `<details>` and `<summary>` elements, featuring smooth animations using CSS `::details-content` pseudo-element and `interpolate-size`.

## Basic Usage

```blade
<x-strata::accordion>
    <x-strata::accordion.item value="item-1">
        <x-slot:trigger>
            <h4 class="font-medium">What is Strata UI?</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Strata UI is a modern Blade and Livewire component library.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-2">
        <x-slot:trigger>
            <h4 class="font-medium">How do I install it?</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Install via Composer: composer require strata-ui/strata-ui</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Accordion Types

### Single Mode

Only one item can be open at a time. Opening a new item automatically closes the previously open item.

```blade
<x-strata::accordion type="single" :defaultValue="['faq-1']">
    <x-strata::accordion.item value="faq-1">
        <x-slot:trigger>
            <h4 class="font-medium">First Question</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">This will be open by default.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="faq-2">
        <x-slot:trigger>
            <h4 class="font-medium">Second Question</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Opening this will close the first item.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

**How it works:** Single mode uses HTML's native `name` attribute on the `<details>` elements. All accordion items automatically receive the same `name` value, which tells the browser to only allow one item with that name to be open at a time. This is a native HTML feature - no JavaScript required!

### Multiple Mode (Default)

Multiple items can be open simultaneously. Each item works independently.

```blade
<x-strata::accordion type="multiple" :defaultValue="['item-1', 'item-3']">
    <x-strata::accordion.item value="item-1">
        <x-slot:trigger>
            <h4 class="font-medium">First Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Open by default.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-2">
        <x-slot:trigger>
            <h4 class="font-medium">Second Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Closed by default.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-3">
        <x-slot:trigger>
            <h4 class="font-medium">Third Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Open by default.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Variants

Available variants: `bordered` (default), `divided`, `card`, `minimal`

### Bordered Variant

Individual borders around each item with background and rounded corners.

```blade
<x-strata::accordion variant="bordered">
    <x-strata::accordion.item value="item-1">
        <x-slot:trigger>
            <h4 class="font-medium">Bordered Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">This item has a border and background.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

### Divided Variant

No individual borders, just dividers between items.

```blade
<x-strata::accordion variant="divided">
    <x-strata::accordion.item value="item-1">
        <x-slot:trigger>
            <h4 class="font-medium">First Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Clean look with dividers.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-2">
        <x-slot:trigger>
            <h4 class="font-medium">Second Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Separated by a border divider.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

### Card Variant

Elevated cards with shadows and spacing between items.

```blade
<x-strata::accordion variant="card">
    <x-strata::accordion.item value="item-1">
        <x-slot:trigger>
            <h4 class="font-medium">Card Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Elevated appearance with shadow.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

### Minimal Variant

Clean, borderless design with subtle hover states.

```blade
<x-strata::accordion variant="minimal">
    <x-strata::accordion.item value="item-1">
        <x-slot:trigger>
            <h4 class="font-medium">Minimal Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Clean and simple, no borders.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Custom Icons

Change the expand/collapse icon using the `icon` prop (defaults to `chevron-right`).

```blade
<x-strata::accordion variant="bordered">
    <x-strata::accordion.item value="item-1" icon="chevron-down">
        <x-slot:trigger>
            <h4 class="font-medium">Chevron Down Icon</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Uses a down chevron that rotates on open.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-2" icon="plus">
        <x-slot:trigger>
            <h4 class="font-medium">Plus Icon</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">Uses a plus icon.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

### Custom Icon Slot

For complete control, use the `iconSlot` named slot:

```blade
<x-strata::accordion.item value="item-1">
    <x-slot:trigger>
        <h4 class="font-medium">Custom Icon</h4>
    </x-slot:trigger>
    <x-slot:iconSlot>
        <div class="w-5 h-5 bg-primary rounded-full"></div>
    </x-slot:iconSlot>
    <x-slot:content>
        <p class="text-sm">Fully custom icon.</p>
    </x-slot:content>
</x-strata::accordion.item>
```

## Disabled State

Prevent items from being toggled with the `disabled` prop.

```blade
<x-strata::accordion variant="bordered">
    <x-strata::accordion.item value="item-1">
        <x-slot:trigger>
            <h4 class="font-medium">Enabled Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">This item can be toggled.</p>
        </x-slot:content>
    </x-strata::accordion.item>

    <x-strata::accordion.item value="item-2" :disabled="true">
        <x-slot:trigger>
            <h4 class="font-medium">Disabled Item</h4>
        </x-slot:trigger>
        <x-slot:content>
            <p class="text-sm">This item cannot be toggled.</p>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Rich Content

Accordion items can contain any content - not just text.

```blade
<x-strata::accordion type="single" variant="card">
    <x-strata::accordion.item value="install">
        <x-slot:trigger>
            <div>
                <h4 class="font-medium">Installation Steps</h4>
                <p class="text-xs text-muted-foreground mt-1">Get started in minutes</p>
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

    <x-strata::accordion.item value="features">
        <x-slot:trigger>
            <div>
                <h4 class="font-medium">Key Features</h4>
                <p class="text-xs text-muted-foreground mt-1">What makes it special</p>
            </div>
        </x-slot:trigger>
        <x-slot:content>
            <ul class="text-sm space-y-2 list-disc list-inside">
                <li>Built with Tailwind CSS v4</li>
                <li>Seamless Livewire integration</li>
                <li>Dark mode support</li>
                <li>Modern CSS animations</li>
            </ul>
        </x-slot:content>
    </x-strata::accordion.item>
</x-strata::accordion>
```

## Props Reference

### Accordion Wrapper

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | string | `multiple` | Accordion behavior: `single` (one open at a time using native HTML `name` attribute) or `multiple` (independent items) |
| `variant` | string | `bordered` | Visual style: `bordered`, `divided`, `card`, `minimal` |
| `defaultValue` | array | `[]` | Array of item values that should be open by default |
| `name` | string | auto-generated | Optional custom name for the accordion group (used for single mode). Auto-generated if not provided. |

### Accordion Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | auto-generated | Unique identifier for the item (required for controlled state) |
| `icon` | string | `chevron-right` | Icon name from the icon library |
| `disabled` | boolean | `false` | Disable the item (prevents toggling) |

**Named Slots:**
- `trigger` - Content for the clickable summary (recommended)
- `content` - Content that expands/collapses (recommended)
- `iconSlot` - Custom icon element (overrides `icon` prop)

## Real-World Examples

### FAQ Section

```blade
<section class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Frequently Asked Questions</h2>

    <x-strata::accordion type="single" variant="bordered">
        <x-strata::accordion.item value="faq-1">
            <x-slot:trigger>
                <h3 class="font-medium">How do I get started?</h3>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    Getting started is easy! Simply install the package via Composer,
                    publish the configuration, and start using the components in your Blade templates.
                </p>
            </x-slot:content>
        </x-strata::accordion.item>

        <x-strata::accordion.item value="faq-2">
            <x-slot:trigger>
                <h3 class="font-medium">Is dark mode supported?</h3>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    Yes! All components have built-in dark mode support using the
                    light-dark() CSS function and Tailwind CSS v4.
                </p>
            </x-slot:content>
        </x-strata::accordion.item>

        <x-strata::accordion.item value="faq-3">
            <x-slot:trigger>
                <h3 class="font-medium">Can I customize the components?</h3>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    Absolutely! Components are highly customizable through props, slots,
                    and theme variables. You can override styles and modify behavior
                    to match your design requirements.
                </p>
            </x-slot:content>
        </x-strata::accordion.item>
    </x-strata::accordion>
</section>
```

### Documentation Sidebar

```blade
<aside class="w-64">
    <h2 class="font-semibold mb-4">Documentation</h2>

    <x-strata::accordion type="multiple" variant="minimal" :defaultValue="['components']">
        <x-strata::accordion.item value="getting-started">
            <x-slot:trigger>
                <span class="font-medium text-sm">Getting Started</span>
            </x-slot:trigger>
            <x-slot:content>
                <nav class="space-y-2">
                    <a href="/docs/installation" class="block text-sm text-muted-foreground hover:text-foreground">Installation</a>
                    <a href="/docs/configuration" class="block text-sm text-muted-foreground hover:text-foreground">Configuration</a>
                    <a href="/docs/theming" class="block text-sm text-muted-foreground hover:text-foreground">Theming</a>
                </nav>
            </x-slot:content>
        </x-strata::accordion.item>

        <x-strata::accordion.item value="components">
            <x-slot:trigger>
                <span class="font-medium text-sm">Components</span>
            </x-slot:trigger>
            <x-slot:content>
                <nav class="space-y-2">
                    <a href="/docs/button" class="block text-sm text-muted-foreground hover:text-foreground">Button</a>
                    <a href="/docs/card" class="block text-sm text-muted-foreground hover:text-foreground">Card</a>
                    <a href="/docs/accordion" class="block text-sm text-primary font-medium">Accordion</a>
                    <a href="/docs/checkbox" class="block text-sm text-muted-foreground hover:text-foreground">Checkbox</a>
                </nav>
            </x-slot:content>
        </x-strata::accordion.item>

        <x-strata::accordion.item value="examples">
            <x-slot:trigger>
                <span class="font-medium text-sm">Examples</span>
            </x-slot:trigger>
            <x-slot:content>
                <nav class="space-y-2">
                    <a href="/examples/forms" class="block text-sm text-muted-foreground hover:text-foreground">Forms</a>
                    <a href="/examples/layouts" class="block text-sm text-muted-foreground hover:text-foreground">Layouts</a>
                    <a href="/examples/patterns" class="block text-sm text-muted-foreground hover:text-foreground">Patterns</a>
                </nav>
            </x-slot:content>
        </x-strata::accordion.item>
    </x-strata::accordion>
</aside>
```

### Product Features

```blade
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-center mb-8">Product Features</h2>

    <x-strata::accordion variant="card" :defaultValue="['feature-1']">
        <x-strata::accordion.item value="feature-1">
            <x-slot:trigger>
                <div class="flex items-start gap-3">
                    <x-strata::icon.zap class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                    <div>
                        <h3 class="font-semibold">Lightning Fast</h3>
                        <p class="text-sm text-muted-foreground mt-1">Optimized for performance</p>
                    </div>
                </div>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    Built with modern CSS and minimal JavaScript, our components
                    are optimized for performance. Smooth animations use GPU
                    acceleration and the latest CSS features for butter-smooth interactions.
                </p>
            </x-slot:content>
        </x-strata::accordion.item>

        <x-strata::accordion.item value="feature-2">
            <x-slot:trigger>
                <div class="flex items-start gap-3">
                    <x-strata::icon.palette class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                    <div>
                        <h3 class="font-semibold">Fully Customizable</h3>
                        <p class="text-sm text-muted-foreground mt-1">Make it your own</p>
                    </div>
                </div>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    Customize every aspect through theme variables, props, and slots.
                    Override styles, change colors, adjust spacing - everything is
                    designed to be flexible and adaptable to your design system.
                </p>
            </x-slot:content>
        </x-strata::accordion.item>

        <x-strata::accordion.item value="feature-3">
            <x-slot:trigger>
                <div class="flex items-start gap-3">
                    <x-strata::icon.shield-check class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                    <div>
                        <h3 class="font-semibold">Accessible by Default</h3>
                        <p class="text-sm text-muted-foreground mt-1">Built for everyone</p>
                    </div>
                </div>
            </x-slot:trigger>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    All components follow accessibility best practices with proper
                    ARIA attributes, keyboard navigation, and screen reader support.
                    Native HTML elements provide the foundation for robust accessibility.
                </p>
            </x-slot:content>
        </x-strata::accordion.item>
    </x-strata::accordion>
</div>
```

### Settings Panel with Livewire

```blade
<x-strata::card>
    <x-strata::card.header
        title="Account Settings"
        subtitle="Manage your account preferences"
    />
    <x-strata::card.body padding="none">
        <x-strata::accordion variant="divided">
            <x-strata::accordion.item value="profile">
                <x-slot:trigger>
                    <h3 class="font-medium">Profile Information</h3>
                </x-slot:trigger>
                <x-slot:content>
                    <div class="space-y-4">
                        <x-strata::input
                            wire:model.blur="name"
                            label="Name"
                            placeholder="Your name"
                        />
                        <x-strata::input
                            wire:model.blur="email"
                            type="email"
                            label="Email"
                            placeholder="your@email.com"
                        />
                        <x-strata::button wire:click="saveProfile" size="sm">
                            Save Changes
                        </x-strata::button>
                    </div>
                </x-slot:content>
            </x-strata::accordion.item>

            <x-strata::accordion.item value="notifications">
                <x-slot:trigger>
                    <h3 class="font-medium">Notification Preferences</h3>
                </x-slot:trigger>
                <x-slot:content>
                    <div class="space-y-3">
                        <x-strata::checkbox
                            wire:model.live="notifications.email"
                            label="Email Notifications"
                        />
                        <x-strata::checkbox
                            wire:model.live="notifications.push"
                            label="Push Notifications"
                        />
                        <x-strata::checkbox
                            wire:model.live="notifications.marketing"
                            label="Marketing Emails"
                        />
                    </div>
                </x-slot:content>
            </x-strata::accordion.item>

            <x-strata::accordion.item value="privacy">
                <x-slot:trigger>
                    <h3 class="font-medium">Privacy Settings</h3>
                </x-slot:trigger>
                <x-slot:content>
                    <div class="space-y-3">
                        <x-strata::checkbox
                            wire:model.live="privacy.showEmail"
                            label="Show email on profile"
                        />
                        <x-strata::checkbox
                            wire:model.live="privacy.publicProfile"
                            label="Make profile public"
                        />
                    </div>
                </x-slot:content>
            </x-strata::accordion.item>
        </x-strata::accordion>
    </x-strata::card.body>
</x-strata::card>
```

## Accessibility

The accordion component is built with accessibility in mind:

- **Native HTML**: Uses `<details>` and `<summary>` elements for semantic HTML
- **Keyboard Navigation**: Space and Enter keys toggle accordion items
- **Screen Reader Support**: Proper ARIA attributes and semantic structure
- **Focus Management**: Clear focus indicators for keyboard navigation
- **Disabled State**: Properly communicated to assistive technologies

## Implementation Details

### Native HTML for Single Mode

Single mode behavior is powered entirely by HTML's native `name` attribute on `<details>` elements. When multiple `<details>` elements share the same `name`, the browser automatically ensures only one can be open at a time - no JavaScript required! This provides:

- **Zero JavaScript overhead** for single mode behavior
- **Instant response** with no event handling delays
- **Native browser optimization** for performance
- **Consistent behavior** across all modern browsers

### Modern CSS for Animations

The accordion uses cutting-edge CSS features for smooth animations:

- **`interpolate-size: allow-keywords`**: Enables smooth height transitions from `0` to `auto`
- **`::details-content` pseudo-element**: Modern CSS for animating details content
- **`transition-behavior: allow-discrete`**: Allows transitions on discrete properties
- **GPU Acceleration**: Transforms and opacity for smooth 60fps animations

These features provide native, performant animations without JavaScript-heavy solutions.