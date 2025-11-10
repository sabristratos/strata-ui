# Cards

Flexible card components for displaying content in a contained, structured format. Perfect for product listings, user profiles, and dashboard widgets.

## Props Reference

### Card

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `style` | string | `elevated` | Visual style: `elevated`, `outlined`, `filled`, `flat` |
| `hoverable` | boolean | `false` | Enable hover effects |
| `clickable` | boolean | `false` | Make card clickable |
| `loading` | boolean | `false` | Show loading spinner overlay |
| `href` | string | `null` | URL for clickable cards |

### Card Header

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | `null` | Header title text |
| `subtitle` | string | `null` | Subtitle text below title |

**Slots:** Default slot for custom content, `actions` for buttons/icons

### Card Body

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `padding` | string | `normal` | Padding size: `none`, `sm`, `normal`, `lg` |

### Card Footer

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `align` | string | `end` | Alignment: `start`, `center`, `end`, `between` |

## Example

```blade
{{-- Full-featured card with all components --}}
<x-strata::card style="elevated" hoverable>
    <x-strata::card.header title="MacBook Pro 16&quot;" subtitle="M3 Pro chip">
        <x-slot:actions>
            <x-strata::button.icon icon="heart" variant="secondary" appearance="ghost" aria-label="Like" />
            <x-strata::button.icon icon="share" variant="secondary" appearance="ghost" aria-label="Share" />
        </x-slot:actions>
    </x-strata::card.header>
    <x-strata::card.body padding="normal">
        <p class="text-3xl font-bold mb-2">$2,499</p>
        <p class="text-sm text-muted-foreground mb-4">
            Powerful performance for professionals with stunning display.
        </p>
        <div class="flex gap-2">
            <x-strata::badge variant="success" size="sm">In Stock</x-strata::badge>
            <x-strata::badge variant="info" size="sm">Free Shipping</x-strata::badge>
        </div>
    </x-strata::card.body>
    <x-strata::card.footer align="end">
        <x-strata::button variant="secondary" appearance="outlined">Details</x-strata::button>
        <x-strata::button variant="primary">Add to Cart</x-strata::button>
    </x-strata::card.footer>
</x-strata::card>
```

## Notes

- **Styles:** `elevated` (shadow), `outlined` (border), `filled` (background), `flat` (minimal)
- **Interactive:** Use `hoverable` for hover effects or `clickable` with `href` for link cards
- **Loading:** Set `loading` prop to show spinner overlay during async operations
- **Accessibility:** Clickable cards render as semantic `<a>` tags with proper ARIA attributes
