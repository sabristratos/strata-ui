# Image Component

A modern, feature-rich image component with lazy loading, fallbacks, blur placeholders, and responsive image support.

## Features

- **Lazy Loading** - Native browser lazy loading by default
- **Aspect Ratio Control** - Prevent layout shift with aspect ratio constraints
- **Fallback System** - Icon, image, or custom fallback when images fail to load
- **Loading States** - Skeleton loader while images load
- **Blur Placeholders** - Show tiny blurred images for instant feedback
- **Responsive Images** - srcset/sizes support for optimal image delivery
- **Size Variants** - xs, sm, md, lg, xl, 2xl, full
- **Visual Variants** - default, bordered, elevated, outlined
- **Rounded Corners** - none, sm, md, lg, xl, full
- **Object Fit Control** - cover, contain, fill, none, scale-down
- **Captions** - bottom, top, or overlay captions
- **Zoom Effect** - Hover zoom animation
- **Accessibility** - Required alt text, decorative mode
- **Spatie Media Library** - Direct integration with Media models

## Basic Usage

```blade
<x-strata::image
    src="https://example.com/image.jpg"
    alt="Description of image"
/>
```

## Size Variants

Control the size of the image container:

```blade
{{-- Predefined sizes --}}
<x-strata::image src="..." alt="..." size="xs" />
<x-strata::image src="..." alt="..." size="sm" />
<x-strata::image src="..." alt="..." size="md" />
<x-strata::image src="..." alt="..." size="lg" />
<x-strata::image src="..." alt="..." size="xl" />
<x-strata::image src="..." alt="..." size="2xl" />
<x-strata::image src="..." alt="..." size="full" /> {{-- Default --}}

{{-- Custom size --}}
<x-strata::image src="..." alt="..." size="w-64 h-64" />
```

## Aspect Ratios

Prevent layout shift by defining aspect ratios:

```blade
<x-strata::image src="..." alt="..." aspect="square" /> {{-- 1:1 --}}
<x-strata::image src="..." alt="..." aspect="video" />  {{-- 16:9 --}}
<x-strata::image src="..." alt="..." aspect="photo" />  {{-- 4:3 --}}
<x-strata::image src="..." alt="..." aspect="portrait" /> {{-- 3:4 --}}
<x-strata::image src="..." alt="..." aspect="wide" />   {{-- 21:9 --}}

{{-- Custom aspect ratio --}}
<x-strata::image src="..." alt="..." aspect="9/16" />
```

## Rounded Variants

```blade
<x-strata::image src="..." alt="..." rounded="none" />
<x-strata::image src="..." alt="..." rounded="sm" />
<x-strata::image src="..." alt="..." rounded="md" />
<x-strata::image src="..." alt="..." rounded="lg" />
<x-strata::image src="..." alt="..." rounded="xl" />
<x-strata::image src="..." alt="..." rounded="full" /> {{-- Circular --}}
```

## Visual Variants

```blade
<x-strata::image src="..." alt="..." variant="default" />
<x-strata::image src="..." alt="..." variant="bordered" />
<x-strata::image src="..." alt="..." variant="elevated" />
<x-strata::image src="..." alt="..." variant="outlined" />
```

## Object Fit

Control how the image fits within its container:

```blade
<x-strata::image src="..." alt="..." fit="cover" />     {{-- Default --}}
<x-strata::image src="..." alt="..." fit="contain" />
<x-strata::image src="..." alt="..." fit="fill" />
<x-strata::image src="..." alt="..." fit="none" />
<x-strata::image src="..." alt="..." fit="scale-down" />
```

## Object Position

Control where the image is positioned within its container:

```blade
<x-strata::image src="..." alt="..." position="center" />     {{-- Default --}}
<x-strata::image src="..." alt="..." position="top" />
<x-strata::image src="..." alt="..." position="bottom" />
<x-strata::image src="..." alt="..." position="left" />
<x-strata::image src="..." alt="..." position="right" />
<x-strata::image src="..." alt="..." position="top-left" />
<x-strata::image src="..." alt="..." position="top-right" />
<x-strata::image src="..." alt="..." position="bottom-left" />
<x-strata::image src="..." alt="..." position="bottom-right" />
```

## Fallback System

### Icon Fallback (Default)

When an image fails to load, a fallback icon is shown:

```blade
<x-strata::image
    src="https://broken-url.com/image.jpg"
    alt="Image description"
    fallbackIcon="photo"
/>
```

### Fallback Image

Provide a fallback image URL:

```blade
<x-strata::image
    src="https://user-avatar.com/avatar.jpg"
    fallbackSrc="https://cdn.example.com/default-avatar.jpg"
    alt="User avatar"
/>
```

### Custom Fallback

Use the default slot for custom fallback content:

```blade
<x-strata::image src="..." alt="...">
    <div class="text-center">
        <p>Image not available</p>
    </div>
</x-strata::image>
```

### Disable Fallback Icon

```blade
<x-strata::image
    src="..."
    alt="..."
    :showFallbackIcon="false"
/>
```

## Loading States

### Skeleton Loader

A skeleton loader is shown while the image loads (enabled by default):

```blade
{{-- With skeleton (default) --}}
<x-strata::image src="..." alt="..." />

{{-- Disable skeleton --}}
<x-strata::image src="..." alt="..." :skeleton="false" />

{{-- Change skeleton variant --}}
<x-strata::image src="..." alt="..." skeletonVariant="pulse" />  {{-- Default --}}
<x-strata::image src="..." alt="..." skeletonVariant="wave" />
<x-strata::image src="..." alt="..." skeletonVariant="shimmer" />
```

### Blur Placeholder

Show a tiny blurred image for instant visual feedback:

```blade
{{-- Using a tiny placeholder image --}}
<x-strata::image
    src="https://example.com/image.jpg"
    placeholder="https://example.com/image-tiny.jpg"
    alt="Image with placeholder"
/>

{{-- Using BlurHash (requires implementation) --}}
<x-strata::image
    src="https://example.com/image.jpg"
    blurHash="LGF5?xYk^6#M@-5c,1J5@[or[Q6."
    alt="Image with BlurHash"
/>
```

## Responsive Images

Use `srcset` and `sizes` for responsive images:

```blade
<x-strata::image
    src="https://example.com/image-800.jpg"
    srcset="https://example.com/image-400.jpg 400w,
            https://example.com/image-800.jpg 800w,
            https://example.com/image-1200.jpg 1200w"
    sizes="(max-width: 640px) 100vw, 800px"
    alt="Responsive image"
/>
```

## Captions

Add captions below, above, or overlaid on the image:

```blade
{{-- Bottom caption (default) --}}
<x-strata::image
    src="..."
    alt="..."
    caption="Beautiful mountain landscape at sunset"
/>

{{-- Top caption --}}
<x-strata::image
    src="..."
    alt="..."
    caption="Mountain landscape"
    captionPosition="top"
/>

{{-- Overlay caption --}}
<x-strata::image
    src="..."
    alt="..."
    caption="Mountain landscape"
    captionPosition="overlay"
/>
```

## Zoom Effect

Add a hover zoom effect:

```blade
<x-strata::image
    src="..."
    alt="..."
    :zoom="true"
/>
```

## Lazy Loading

Control lazy loading behavior:

```blade
{{-- Lazy load (default) --}}
<x-strata::image src="..." alt="..." />

{{-- Eager load (for above-the-fold images) --}}
<x-strata::image src="..." alt="..." loading="eager" />
```

## Accessibility

### Required Alt Text

The `alt` attribute is required for all images:

```blade
<x-strata::image
    src="..."
    alt="A descriptive alt text"
/>
```

### Decorative Images

For decorative images (that don't convey meaningful content), use the `decorative` prop:

```blade
<x-strata::image
    src="..."
    :decorative="true"
/>
```

This sets `alt=""` which tells screen readers to ignore the image.

## Advanced Customization

### Styling the Container

Use the `class` attribute to add or override styles on the wrapper container:

```blade
{{-- Add custom classes to the wrapper --}}
<x-strata::image
    src="..."
    alt="..."
    size="lg"
    class="shadow-2xl ring-4 ring-purple-500"
/>

{{-- Override size with Tailwind's ! modifier --}}
<x-strata::image
    src="..."
    alt="..."
    size="md"
    class="!w-full !h-auto"
/>
```

### Styling the Image Element

Use the `imgClass` prop to apply styles directly to the inner `<img>` element:

```blade
{{-- Apply CSS filters --}}
<x-strata::image
    src="..."
    alt="..."
    imgClass="sepia brightness-110"
/>

{{-- Custom opacity and saturation --}}
<x-strata::image
    src="..."
    alt="..."
    size="lg"
    imgClass="opacity-75 saturate-150 contrast-125"
/>

{{-- Combine with hover effects --}}
<x-strata::image
    src="..."
    alt="..."
    imgClass="grayscale hover:grayscale-0 transition-all duration-300"
/>
```

## Spatie Media Library Integration

If you're using Spatie Media Library, you can pass a Media model directly:

```blade
<x-strata::image
    :media="$user->getFirstMedia('avatar')"
/>
```

The component will automatically:
- Extract the image URL
- Use the media name as alt text (unless you provide one)
- Load responsive srcset if `getSrcset()` method exists
- Use blur hash from custom properties if available

## Common Use Cases

### Avatar

```blade
<x-strata::image
    :src="$user->avatar_url"
    fallbackSrc="/images/default-avatar.jpg"
    alt="{{ $user->name }}"
    size="md"
    aspect="square"
    rounded="full"
    variant="bordered"
/>
```

### Product Image

```blade
<x-strata::image
    src="{{ $product->image_url }}"
    alt="{{ $product->name }}"
    aspect="square"
    rounded="lg"
    variant="elevated"
    :zoom="true"
/>
```

### Hero Image

```blade
<x-strata::image
    src="/images/hero.jpg"
    srcset="/images/hero-400.jpg 400w,
            /images/hero-800.jpg 800w,
            /images/hero-1200.jpg 1200w"
    sizes="100vw"
    alt="Welcome to our platform"
    aspect="wide"
    size="full"
/>
```

### Gallery Image with Caption

```blade
<x-strata::image
    src="{{ $photo->url }}"
    alt="{{ $photo->title }}"
    aspect="photo"
    rounded="md"
    variant="elevated"
    caption="{{ $photo->description }}"
    captionPosition="overlay"
    :zoom="true"
/>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `src` | `string` | `null` | Image source URL |
| `alt` | `string` | `null` | Alt text (required unless decorative=true) |
| `aspect` | `string` | `null` | Aspect ratio: square, video, photo, portrait, wide, or custom (e.g., "16/9") |
| `fit` | `string` | `cover` | Object fit: cover, contain, fill, none, scale-down |
| `position` | `string` | `center` | Object position: center, top, bottom, left, right, etc. |
| `loading` | `string` | `lazy` | Loading strategy: lazy, eager |
| `size` | `string` | `null` | Size variant: xs, sm, md, lg, xl, 2xl, full, or custom classes |
| `rounded` | `string` | `null` | Border radius: none, sm, md, lg, xl, full |
| `variant` | `string` | `default` | Visual variant: default, bordered, elevated, outlined |
| `fallbackSrc` | `string` | `null` | Fallback image URL |
| `fallbackIcon` | `string` | `photo` | Icon to show in fallback |
| `showFallbackIcon` | `bool` | `true` | Show fallback icon |
| `skeleton` | `bool` | `true` | Show skeleton loader |
| `skeletonVariant` | `string` | `pulse` | Skeleton variant: pulse, wave, shimmer |
| `blurHash` | `string` | `null` | BlurHash string for placeholder |
| `placeholder` | `string` | `null` | Tiny placeholder image URL |
| `srcset` | `string` | `null` | Responsive image srcset |
| `sizes` | `string` | `null` | Responsive image sizes |
| `decorative` | `bool` | `false` | Mark image as decorative (sets alt="") |
| `caption` | `string` | `null` | Image caption text |
| `captionPosition` | `string` | `bottom` | Caption position: bottom, top, overlay |
| `zoom` | `bool` | `false` | Enable hover zoom effect |
| `imgClass` | `string` | `null` | Custom classes for the inner `<img>` element |
| `media` | `Media` | `null` | Spatie Media Library model |

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Native lazy loading support (all modern browsers)
- Graceful degradation for older browsers
