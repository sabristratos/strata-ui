# Icons

Strata UI includes all 1,648 Lucide icons with a simple, consistent syntax.

## Basic Usage

```blade
<x-strata::icon.home class="w-5 h-5" />
<x-strata::icon.user class="w-6 h-6" />
<x-strata::icon.settings class="w-4 h-4" />
```

## Styling

Icons support full Tailwind customization:

```blade
<x-strata::icon.heart class="w-8 h-8 text-red-500 hover:text-red-600" />
<x-strata::icon.star class="w-6 h-6 text-yellow-400" />
```

## Common Sizes

```blade
<x-strata::icon.check class="w-3 h-3" />  <!-- Extra small -->
<x-strata::icon.check class="w-4 h-4" />  <!-- Small -->
<x-strata::icon.check class="w-5 h-5" />  <!-- Medium (recommended) -->
<x-strata::icon.check class="w-6 h-6" />  <!-- Large -->
<x-strata::icon.check class="w-8 h-8" />  <!-- Extra large -->
```

## With Buttons

```blade
<button class="flex items-center gap-2">
    <x-strata::icon.plus class="w-4 h-4" />
    Add Item
</button>
```

## Available Icons

Browse all 1,648 icons at [Lucide Icons](https://lucide.dev/icons/).

Use any icon by replacing spaces and special characters with hyphens:

- "Home" → `icon.home`
- "Arrow Right" → `icon.arrow-right`
- "Check Circle" → `icon.check-circle`
- "Settings 2" → `icon.settings-2`

## Customizing Icons

You can override any icon or add custom ones:

### 1. Publish Views

```bash
php artisan vendor:publish --tag=strata-ui-views
```

### 2. Create or Edit Icon

Create or edit in `resources/views/vendor/strata-ui/components/icon/`:

```blade
{{-- resources/views/vendor/strata-ui/components/icon/custom-logo.blade.php --}}
<svg {{ $attributes->merge(['class' => 'inline-block']) }}>
  <path d="..." />
</svg>
```

### 3. Use Your Icon

```blade
<x-strata::icon.custom-logo class="w-10 h-10" />
```

## Attributes

All icons support full attribute merging:

```blade
<x-strata::icon.bookmark
    class="w-5 h-5"
    data-favorite="true"
    aria-label="Bookmark this page"
/>
```
