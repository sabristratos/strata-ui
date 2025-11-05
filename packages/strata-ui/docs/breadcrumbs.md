# Breadcrumbs

Navigation breadcrumbs that show the user's location within the site hierarchy. Supports multiple separators, sizes, variants, icons, and automatic overflow handling.

## Props Reference

### Breadcrumbs Container

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `default` | Visual style (`default`, `bold`) |
| `size` | string | `md` | Breadcrumb size (`sm`, `md`, `lg`) |
| `separator` | string | `chevron-right` | Separator icon between items |
| `maxItems` | number | `null` | Maximum items before collapsing middle items |

### Breadcrumb Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `href` | string | `null` | Link URL |
| `icon` | string | `null` | Leading icon name |
| `active` | boolean | `false` | Whether this is the current page |

## Example

```blade
{{-- Full-featured breadcrumbs with icons, sizes, and overflow --}}
<x-strata::breadcrumbs
    separator="chevron-right"
    size="md"
    variant="default"
    :max-items="5"
>
    <x-strata::breadcrumbs.item href="/" icon="home">Home</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/products" icon="shopping-bag">Products</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/products/electronics">Electronics</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item href="/products/electronics/laptops">Laptops</x-strata::breadcrumbs.item>
    <x-strata::breadcrumbs.separator />
    <x-strata::breadcrumbs.item icon="laptop" active>MacBook Pro</x-strata::breadcrumbs.item>
</x-strata::breadcrumbs>
```

## Dynamic Breadcrumbs

Generate breadcrumbs from route data or models:

```php
class ProductPage extends Component
{
    public Product $product;

    public function getBreadcrumbsProperty()
    {
        return collect([
            ['label' => 'Home', 'url' => route('home'), 'icon' => 'home'],
            ['label' => $this->product->category->name, 'url' => route('category', $this->product->category)],
            ['label' => $this->product->name, 'active' => true],
        ]);
    }
}
```

```blade
<x-strata::breadcrumbs>
    @foreach($this->breadcrumbs as $index => $crumb)
        @if($index > 0)
            <x-strata::breadcrumbs.separator />
        @endif

        <x-strata::breadcrumbs.item
            :href="$crumb['url'] ?? null"
            :icon="$crumb['icon'] ?? null"
            :active="$crumb['active'] ?? false"
        >
            {{ $crumb['label'] }}
        </x-strata::breadcrumbs.item>
    @endforeach
</x-strata::breadcrumbs>
```

## Notes

- **Separators:** `chevron-right` (default), `slash-forward`, `arrow-right`, `dot`
- **Active Page:** Set `active` prop on current page - renders as `<span>` with `aria-current="page"`
- **Overflow:** `maxItems` collapses middle items with ellipsis when threshold exceeded
- **Responsive:** Automatically wraps to multiple lines on smaller screens
- **Accessibility:** Uses semantic `<nav>` with `aria-label="Breadcrumbs"`
