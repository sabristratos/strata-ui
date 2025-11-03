# Text

Versatile text component with presets for common typography use cases.

## Basic Usage

```blade
<x-strata::text>
    This is a paragraph of body text with sensible defaults.
</x-strata::text>
```

## Variants

### Body (Default)

Standard paragraph text:

```blade
<x-strata::text variant="body">
    The quick brown fox jumps over the lazy dog. This is the default text variant
    with optimal readability for body content.
</x-strata::text>
```

### Lead

Larger introductory text for article intros or section descriptions:

```blade
<x-strata::text variant="lead">
    Strata UI is a modern Blade and Livewire component library designed for rapid
    application development with Laravel.
</x-strata::text>
```

### Large

Slightly larger than body text:

```blade
<x-strata::text variant="large">
    Important information that needs more emphasis than body text.
</x-strata::text>
```

### Small

Smaller text for captions, hints, or supplementary information (normal foreground color):

```blade
<x-strata::text variant="small">
    Last updated 2 hours ago
</x-strata::text>
```

### Muted

De-emphasized text with muted color and smaller size:

```blade
<x-strata::text variant="muted">
    This information is secondary and less important.
</x-strata::text>
```

**Note:** Both `small` and `muted` use `text-sm`, but `small` uses normal foreground color while `muted` uses muted-foreground color. Use `small` for metadata that should still be readable, and `muted` for less important information.

### Overline

Uppercase label text for section headers:

```blade
<x-strata::text variant="overline">
    Features
</x-strata::text>

<x-strata::heading level="2">
    What We Offer
</x-strata::heading>
```

### Quote

Styled blockquote for quotations:

```blade
<x-strata::text variant="quote">
    "Strata UI has transformed how we build Laravel applications. The components
    are beautiful, accessible, and incredibly easy to use."
</x-strata::text>
```

### Code

Inline code with background and monospace font:

```blade
<x-strata::text>
    To install the package, run <x-strata::text variant="code">composer require strata-ui</x-strata::text>
    in your terminal.
</x-strata::text>
```

## Custom Element

Override the default HTML element:

```blade
{{-- Render as span instead of p --}}
<x-strata::text as="span">
    Inline text content
</x-strata::text>

{{-- Render as div --}}
<x-strata::text as="div">
    Block-level content
</x-strata::text>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `body` | Text style: `body`, `lead`, `large`, `small`, `muted`, `overline`, `quote`, `code` |
| `as` | `string` | `null` | Override HTML tag (defaults to variant's preferred tag) |

## Default Elements by Variant

| Variant | Default Element |
|---------|----------------|
| `body` | `<p>` |
| `lead` | `<p>` |
| `large` | `<p>` |
| `small` | `<p>` |
| `muted` | `<p>` |
| `overline` | `<span>` |
| `quote` | `<blockquote>` |
| `code` | `<code>` |

## Examples

### Article Introduction

```blade
<article>
    <x-strata::heading level="1">
        Getting Started with Strata UI
    </x-strata::heading>

    <x-strata::text variant="lead" class="mt-4">
        This guide will walk you through installing and configuring Strata UI
        in your Laravel application.
    </x-strata::text>

    <x-strata::text class="mt-4">
        Strata UI is designed to work seamlessly with Laravel 12, Livewire 3,
        and Tailwind CSS v4. Let's get started!
    </x-strata::text>
</article>
```

### Card with Metadata

```blade
<x-strata::card>
    <x-strata::card.body>
        <x-strata::text variant="overline" class="mb-2">
            New Release
        </x-strata::text>

        <x-strata::heading level="3" class="mb-2">
            Strata UI v1.0
        </x-strata::heading>

        <x-strata::text class="mb-4">
            We're excited to announce the first stable release of Strata UI with
            over 28 production-ready components.
        </x-strata::text>

        <x-strata::text variant="small">
            Released on January 15, 2025
        </x-strata::text>
    </x-strata::card.body>
</x-strata::card>
```

### Code Documentation

```blade
<div>
    <x-strata::heading level="3">
        Installation
    </x-strata::heading>

    <x-strata::text class="mt-2">
        Install the package via Composer:
    </x-strata::text>

    <x-strata::text variant="code" as="pre" class="mt-2 block p-4">
        composer require strata-ui/strata-ui
    </x-strata::text>

    <x-strata::text class="mt-4">
        Then publish the configuration with <x-strata::text variant="code">php artisan vendor:publish</x-strata::text>.
    </x-strata::text>
</div>
```

### Testimonial

```blade
<div class="max-w-2xl mx-auto text-center">
    <x-strata::text variant="quote" class="text-lg">
        "Strata UI has completely changed our development workflow. We ship features
        faster and our UI is more consistent than ever before."
    </x-strata::text>

    <x-strata::text class="mt-4 font-medium">
        Sarah Johnson
    </x-strata::text>

    <x-strata::text variant="small">
        Lead Developer at Acme Corp
    </x-strata::text>
</div>
```

### Feature List with Overlines

```blade
<div class="grid md:grid-cols-3 gap-8">
    <div>
        <x-strata::text variant="overline" class="mb-2">
            Performance
        </x-strata::text>
        <x-strata::heading level="4" class="mb-2">
            Blazing Fast
        </x-strata::heading>
        <x-strata::text variant="small">
            Optimized components with minimal JavaScript footprint
        </x-strata::text>
    </div>

    <div>
        <x-strata::text variant="overline" class="mb-2">
            Accessibility
        </x-strata::text>
        <x-strata::heading level="4" class="mb-2">
            WCAG Compliant
        </x-strata::heading>
        <x-strata::text variant="small">
            Built with accessibility best practices from the ground up
        </x-strata::text>
    </div>

    <div>
        <x-strata::text variant="overline" class="mb-2">
            Customization
        </x-strata::text>
        <x-strata::heading level="4" class="mb-2">
            Fully Themeable
        </x-strata::heading>
        <x-strata::text variant="small">
            Customize every aspect with CSS variables and Tailwind
        </x-strata::text>
    </div>
</div>
```

## Accessibility

- Semantic HTML elements
- Proper color contrast in all variants
- Supports screen readers
- Respects user font size preferences
