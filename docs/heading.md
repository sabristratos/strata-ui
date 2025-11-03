# Heading

Semantic heading component with opinionated typography scale and variants.

## Basic Usage

```blade
<x-strata::heading level="1">
    Welcome to Strata UI
</x-strata::heading>

<x-strata::heading level="2">
    Features Overview
</x-strata::heading>

<x-strata::heading level="3">
    Getting Started
</x-strata::heading>
```

## Typography Scale

The heading component provides a responsive typography scale optimized for readability:

```blade
{{-- h1: text-4xl md:text-5xl --}}
<x-strata::heading level="1">
    Hero Heading
</x-strata::heading>

{{-- h2: text-3xl md:text-4xl --}}
<x-strata::heading level="2">
    Section Heading
</x-strata::heading>

{{-- h3: text-2xl md:text-3xl --}}
<x-strata::heading level="3">
    Subsection Heading
</x-strata::heading>

{{-- h4: text-xl md:text-2xl --}}
<x-strata::heading level="4">
    Card Heading
</x-strata::heading>

{{-- h5: text-lg md:text-xl --}}
<x-strata::heading level="5">
    Small Heading
</x-strata::heading>

{{-- h6: text-base md:text-lg --}}
<x-strata::heading level="6">
    Tiny Heading
</x-strata::heading>
```

## Variants

### Default

Standard foreground color with proper contrast:

```blade
<x-strata::heading level="1">
    Default Heading
</x-strata::heading>
```

### Gradient

Eye-catching gradient text for hero sections:

```blade
<x-strata::heading level="1" variant="gradient">
    Build Beautiful Apps
</x-strata::heading>
```

**Browser Support:** The gradient variant uses `background-clip: text`, which is supported in all modern browsers. Tailwind automatically adds the `-webkit-` prefix for compatibility.

### Muted

Subtle heading for less emphasis:

```blade
<x-strata::heading level="2" variant="muted">
    Optional Section
</x-strata::heading>
```

## Semantic Flexibility

Render any level as a different HTML element for SEO:

```blade
{{-- Render h1 visually as h2 --}}
<x-strata::heading level="2" as="h1">
    Page Title (SEO h1, looks like h2)
</x-strata::heading>

{{-- Render h2 visually as h1 for hero --}}
<x-strata::heading level="1" as="h2">
    Hero Headline (SEO h2, looks like h1)
</x-strata::heading>
```

## Custom Size Override

Override the default size for a specific level:

```blade
<x-strata::heading level="3" size="text-xl font-medium">
    Custom Sized Heading
</x-strata::heading>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `level` | `1-6` | `2` | Heading level (h1-h6) |
| `as` | `string` | `null` | Override HTML tag (e.g., `h1`, `h2`) |
| `variant` | `string` | `default` | Style variant: `default`, `gradient`, `muted` |
| `size` | `string` | `null` | Custom size classes to override default scale |

## Examples

### Hero Section

```blade
<div class="text-center py-16">
    <x-strata::heading level="1" variant="gradient">
        The Future of Web Development
    </x-strata::heading>

    <x-strata::text variant="lead" class="mt-4 max-w-2xl mx-auto">
        Build beautiful, modern applications with Strata UI's comprehensive component library.
    </x-strata::text>
</div>
```

### Card with Heading

```blade
<x-strata::card>
    <x-strata::card.header title="User Profile" subtitle="Manage your account settings" />

    <x-strata::card.body>
        <x-strata::heading level="4" class="mb-2">
            Personal Information
        </x-strata::heading>
        {{-- Form fields --}}
    </x-strata::card.body>
</x-strata::card>
```

### Article Structure

```blade
<article>
    <x-strata::heading level="1">
        Building Scalable Laravel Applications
    </x-strata::heading>

    <x-strata::text variant="muted" class="mt-2">
        Published on January 15, 2025
    </x-strata::text>

    <x-strata::heading level="2" class="mt-8">
        Architecture Patterns
    </x-strata::heading>

    <x-strata::heading level="3" class="mt-4">
        Repository Pattern
    </x-strata::heading>
</article>
```

## Accessibility

- Proper semantic HTML elements (h1-h6)
- Maintains heading hierarchy for screen readers
- Sufficient color contrast in all variants
- `as` prop allows SEO optimization while maintaining visual consistency
