# Cards

Flexible card components for displaying content in a contained, structured format. Perfect for product listings, blog posts, user profiles, and dashboard widgets.

## Basic Usage

```blade
<x-strata::card>
    <x-strata::card.header title="Card Title" subtitle="Optional subtitle" />
    <x-strata::card.body>
        <p>Your card content goes here.</p>
    </x-strata::card.body>
    <x-strata::card.footer>
        <x-strata::button variant="primary">Action</x-strata::button>
    </x-strata::card.footer>
</x-strata::card>
```

## Styles

Available styles: `elevated` (default), `outlined`, `filled`, `flat`

```blade
{{-- Elevated: Subtle shadow for depth --}}
<x-strata::card style="elevated">
    <x-strata::card.body>Content with shadow elevation</x-strata::card.body>
</x-strata::card>

{{-- Outlined: Border only, no shadow --}}
<x-strata::card style="outlined">
    <x-strata::card.body>Content with border</x-strata::card.body>
</x-strata::card>

{{-- Filled: Solid background --}}
<x-strata::card style="filled">
    <x-strata::card.body>Content with solid background</x-strata::card.body>
</x-strata::card>

{{-- Flat: Minimal styling --}}
<x-strata::card style="flat">
    <x-strata::card.body>Minimal card styling</x-strata::card.body>
</x-strata::card>
```

## Interactive States

### Hoverable Cards

Add hover effects for better interactivity:

```blade
<x-strata::card style="elevated" hoverable>
    <x-strata::card.body>
        <p>Hover over this card to see the effect</p>
    </x-strata::card.body>
</x-strata::card>
```

### Clickable Cards

Make the entire card clickable as a link:

```blade
<x-strata::card style="outlined" clickable href="/products/123">
    <x-strata::card.header title="Product Name" />
    <x-strata::card.body>
        <p>Click anywhere on this card to navigate</p>
    </x-strata::card.body>
</x-strata::card>
```

### Loading State

Display a loading spinner overlay:

```blade
<x-strata::card loading>
    <x-strata::card.header title="Loading..." />
    <x-strata::card.body>
        <p>Content is being loaded</p>
    </x-strata::card.body>
</x-strata::card>
```

## Card Header

The header component supports titles, subtitles, and action buttons.

### With Title and Subtitle

```blade
<x-strata::card.header
    title="Dashboard"
    subtitle="Overview of your activity"
/>
```

### With Actions

Use the `actions` slot for buttons or icons:

```blade
<x-strata::card.header title="Settings" subtitle="Manage your preferences">
    <x-slot:actions>
        <x-strata::button.icon icon="settings" variant="secondary" style="ghost" />
        <x-strata::button.icon icon="more-vertical" variant="secondary" style="ghost" />
    </x-slot:actions>
</x-strata::card.header>
```

### Custom Header Content

Use the default slot for complete control:

```blade
<x-strata::card.header>
    <h3 class="text-xl font-bold">Custom Header</h3>
    <p class="text-sm text-muted-foreground">Complete freedom over content</p>
</x-strata::card.header>
```

## Card Body

The body component wraps your main content with consistent padding.

### Padding Options

Available padding options: `none`, `sm`, `normal` (default), `lg`

```blade
<x-strata::card.body padding="none">
    <p>No padding - use for full-width content</p>
</x-strata::card.body>

<x-strata::card.body padding="sm">
    <p>Small padding</p>
</x-strata::card.body>

<x-strata::card.body padding="normal">
    <p>Normal padding (default)</p>
</x-strata::card.body>

<x-strata::card.body padding="lg">
    <p>Large padding</p>
</x-strata::card.body>
```

## Card Footer

The footer component is perfect for action buttons.

### Footer Alignment

Available alignments: `start`, `center`, `end` (default), `between`

```blade
{{-- Align left --}}
<x-strata::card.footer align="start">
    <x-strata::button variant="primary">Save</x-strata::button>
    <x-strata::button variant="secondary">Cancel</x-strata::button>
</x-strata::card.footer>

{{-- Center aligned --}}
<x-strata::card.footer align="center">
    <x-strata::button variant="primary">Confirm</x-strata::button>
</x-strata::card.footer>

{{-- Right aligned (default) --}}
<x-strata::card.footer align="end">
    <x-strata::button variant="secondary">Back</x-strata::button>
    <x-strata::button variant="primary">Next</x-strata::button>
</x-strata::card.footer>

{{-- Space between --}}
<x-strata::card.footer align="between">
    <x-strata::badge variant="info">Draft</x-strata::badge>
    <x-strata::button variant="primary">Publish</x-strata::button>
</x-strata::card.footer>
```

## Card Image

Add images to your cards with automatic aspect ratio handling.

### Basic Image

```blade
<x-strata::card>
    <x-strata::card.image
        src="https://example.com/image.jpg"
        alt="Product image"
    />
    <x-strata::card.body>
        <p>Image content goes here</p>
    </x-strata::card.body>
</x-strata::card>
```

### Aspect Ratios

Available aspect ratios: `square`, `video` (default), `wide`, `portrait`, `auto`

```blade
{{-- Square (1:1) --}}
<x-strata::card.image
    src="/images/avatar.jpg"
    alt="Avatar"
    aspectRatio="square"
/>

{{-- Video (16:9) - Default --}}
<x-strata::card.image
    src="/images/preview.jpg"
    alt="Video preview"
    aspectRatio="video"
/>

{{-- Wide (21:9) --}}
<x-strata::card.image
    src="/images/banner.jpg"
    alt="Banner"
    aspectRatio="wide"
/>

{{-- Portrait (3:4) --}}
<x-strata::card.image
    src="/images/portrait.jpg"
    alt="Portrait"
    aspectRatio="portrait"
/>

{{-- Auto - Natural aspect ratio --}}
<x-strata::card.image
    src="/images/photo.jpg"
    alt="Photo"
    aspectRatio="auto"
/>
```

## Props Reference

### Card

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `style` | string | `elevated` | Visual style: `elevated`, `outlined`, `filled`, `flat` |
| `hoverable` | boolean | `false` | Enable hover effects |
| `clickable` | boolean | `false` | Make card clickable (renders as `<a>` tag) |
| `loading` | boolean | `false` | Show loading spinner overlay |
| `href` | string | `null` | URL for clickable cards |

### Card Header

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | `null` | Header title text |
| `subtitle` | string | `null` | Subtitle text below title |

**Slots:**
- Default slot: Custom header content (overrides title)
- `actions`: Action buttons or icons

### Card Body

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `padding` | string | `normal` | Padding size: `none`, `sm`, `normal`, `lg` |

### Card Footer

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `align` | string | `end` | Alignment: `start`, `center`, `end`, `between` |

### Card Image

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `src` | string | `null` | Image source URL |
| `alt` | string | `''` | Alternative text for accessibility |
| `aspectRatio` | string | `video` | Aspect ratio: `square`, `video`, `wide`, `portrait`, `auto` |

## Real-World Examples

### Product Card

```blade
<x-strata::card style="elevated" hoverable>
    <x-strata::card.image
        src="/products/laptop.jpg"
        alt="MacBook Pro"
        aspectRatio="square"
    />
    <x-strata::card.header title="MacBook Pro 16\"" />
    <x-strata::card.body>
        <p class="text-2xl font-bold mb-2">$2,499</p>
        <p class="text-sm text-muted-foreground">
            Powerful performance for professionals
        </p>
    </x-strata::card.body>
    <x-strata::card.footer>
        <x-strata::button variant="secondary" style="outlined">Details</x-strata::button>
        <x-strata::button variant="primary">Add to Cart</x-strata::button>
    </x-strata::card.footer>
</x-strata::card>
```

### User Profile Card

```blade
<x-strata::card style="outlined">
    <x-strata::card.header title="John Doe" subtitle="Software Engineer">
        <x-slot:actions>
            <x-strata::button.icon icon="mail" variant="secondary" style="ghost" />
            <x-strata::button.icon icon="more-horizontal" variant="secondary" style="ghost" />
        </x-slot:actions>
    </x-strata::card.header>
    <x-strata::card.body>
        <div class="flex items-center gap-4 mb-4">
            <x-strata::avatar name="John Doe" size="xl" />
            <div>
                <p class="font-medium">San Francisco, CA</p>
                <p class="text-sm text-muted-foreground">Member since 2020</p>
            </div>
        </div>
        <div class="flex gap-2">
            <x-strata::badge variant="primary">React</x-strata::badge>
            <x-strata::badge variant="primary">Laravel</x-strata::badge>
            <x-strata::badge variant="primary">Tailwind</x-strata::badge>
        </div>
    </x-strata::card.body>
    <x-strata::card.footer>
        <x-strata::button variant="secondary">Message</x-strata::button>
        <x-strata::button variant="primary">Follow</x-strata::button>
    </x-strata::card.footer>
</x-strata::card>
```

### Blog Post Card

```blade
<x-strata::card style="elevated" clickable href="/blog/post-slug">
    <x-strata::card.image
        src="/blog/cover.jpg"
        alt="Blog post cover"
    />
    <x-strata::card.header title="Getting Started with Strata UI" />
    <x-strata::card.body>
        <div class="flex items-center gap-2 mb-3">
            <x-strata::badge variant="primary" size="sm">Tutorial</x-strata::badge>
            <span class="text-sm text-muted-foreground">5 min read</span>
        </div>
        <p class="text-sm text-muted-foreground">
            Learn how to build beautiful interfaces with Strata UI components
            in just a few minutes.
        </p>
    </x-strata::card.body>
    <x-strata::card.footer align="between">
        <div class="flex items-center gap-2">
            <x-strata::avatar name="Jane Smith" size="sm" />
            <span class="text-sm">Jane Smith</span>
        </div>
        <span class="text-sm text-muted-foreground">Dec 15, 2024</span>
    </x-strata::card.footer>
</x-strata::card>
```

### Dashboard Widget

```blade
<x-strata::card style="elevated">
    <x-strata::card.header title="Revenue" subtitle="Last 30 days">
        <x-slot:actions>
            <x-strata::button.icon icon="refresh-cw" variant="secondary" style="ghost" size="sm" />
        </x-slot:actions>
    </x-strata::card.header>
    <x-strata::card.body>
        <div class="space-y-4">
            <div>
                <p class="text-3xl font-bold">$45,231</p>
                <div class="flex items-center gap-2 mt-1">
                    <x-strata::badge variant="success" size="sm">+12.5%</x-strata::badge>
                    <span class="text-sm text-muted-foreground">vs last month</span>
                </div>
            </div>
            <div class="h-32 bg-muted rounded flex items-center justify-center">
                <span class="text-muted-foreground text-sm">[Chart goes here]</span>
            </div>
        </div>
    </x-strata::card.body>
</x-strata::card>
```

### Settings Panel

```blade
<x-strata::card style="outlined">
    <x-strata::card.header title="Notification Preferences" subtitle="Manage how you receive updates" />
    <x-strata::card.body>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">Email Notifications</p>
                    <p class="text-sm text-muted-foreground">Receive updates via email</p>
                </div>
                <x-strata::toggle />
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">Push Notifications</p>
                    <p class="text-sm text-muted-foreground">Receive push notifications</p>
                </div>
                <x-strata::toggle />
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">SMS Notifications</p>
                    <p class="text-sm text-muted-foreground">Receive text messages</p>
                </div>
                <x-strata::toggle />
            </div>
        </div>
    </x-strata::card.body>
    <x-strata::card.footer>
        <x-strata::button variant="secondary">Cancel</x-strata::button>
        <x-strata::button variant="primary">Save Changes</x-strata::button>
    </x-strata::card.footer>
</x-strata::card>
```
