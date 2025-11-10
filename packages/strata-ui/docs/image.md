# Image

Modern image component with responsive images, placeholders, and lazy loading.

## Basic Usage

```blade
<x-strata::image
    src="/images/photo.jpg"
    alt="Beautiful sunset"
/>
```

## Accessibility

Alt text is required. Use `decorative` for decorative images.

```blade
<x-strata::image
    src="/images/photo.jpg"
    alt="Mountain sunset"
/>

<x-strata::image
    src="/images/pattern.jpg"
    decorative
/>
```

## Aspect Ratios

```blade
<x-strata::image
    src="/images/photo.jpg"
    alt="Square photo"
    aspect="square"
/>
```

**Presets:** `square`, `video`, `wide`, `portrait`, `photo`

**Custom:**
```blade
<x-strata::image aspect="4/3" ... />
```

## Object Fit

```blade
<x-strata::image
    src="/images/photo.jpg"
    alt="Contained image"
    object-fit="contain"
/>
```

**Options:** `contain`, `cover`, `fill`, `none`, `scale-down`

## Object Position

```blade
<x-strata::image
    object-position="top"
    ...
/>
```

**Options:** `center`, `top`, `bottom`, `left`, `right`, `top-left`, `top-right`, `bottom-left`, `bottom-right`

## Rounded Corners

```blade
<x-strata::image
    rounded="full"
    ...
/>
```

**Options:** `none`, `sm`, `md`, `lg`, `xl`, `2xl`, `full`

## Placeholders

### Skeleton (Default)

```blade
<x-strata::image
    src="/images/photo.jpg"
    alt="With skeleton"
    placeholder-type="skeleton"
/>
```

### Blur Placeholder

```blade
<x-strata::image
    src="/images/photo.jpg"
    placeholder="/images/photo-tiny.jpg"
    alt="With blur"
/>
```

### BlurHash

```blade
<x-strata::image
    src="/images/photo.jpg"
    blur-hash="LGF5]+Yk^6#M@-5c,1J5@[or[Q6."
    alt="With BlurHash"
/>
```

Generate BlurHash: https://blurha.sh/

## Captions

```blade
<x-strata::image
    src="/images/photo.jpg"
    alt="Mountain"
    caption="Swiss Alps at sunset"
/>
```

**Overlay caption:**
```blade
<x-strata::image
    caption="Swiss Alps"
    caption-position="overlay"
    ...
/>
```

## Error Handling

```blade
<x-strata::image
    src="/images/photo.jpg"
    fallback="/images/placeholder.jpg"
    alt="With fallback"
/>
```

## Lightbox

```blade
<x-strata::image
    src="/images/photo.jpg"
    alt="Gallery photo"
    lightbox="gallery-1"
/>
```

**With caption:**
```blade
<x-strata::image
    lightbox="gallery-1"
    lightbox-caption="Mountain sunset"
    ...
/>
```

## Responsive Images

### srcset and sizes

```blade
<x-strata::image
    src="/images/photo.jpg"
    srcset="/images/photo-320w.jpg 320w,
            /images/photo-640w.jpg 640w"
    sizes="(max-width: 640px) 100vw, 50vw"
    alt="Responsive"
/>
```

### Modern Formats

```blade
<x-strata::image
    src="/images/photo.jpg"
    :formats="['avif', 'webp']"
    alt="Modern formats"
/>
```

Generates:
```html
<picture>
  <source srcset="/images/photo.avif" type="image/avif">
  <source srcset="/images/photo.webp" type="image/webp">
  <img src="/images/photo.jpg" alt="Modern formats">
</picture>
```

### Art Direction

```blade
<x-strata::image
    src="/images/desktop.jpg"
    :sources="[
        [
            'srcset' => '/images/mobile.jpg',
            'media' => '(max-width: 640px)',
        ],
        [
            'srcset' => '/images/tablet.jpg',
            'media' => '(max-width: 1024px)',
        ],
    ]"
    alt="Responsive art direction"
/>
```

## Performance

### Lazy Loading

```blade
<x-strata::image
    src="/images/photo.jpg"
    alt="Lazy loaded"
    loading="lazy"
/>
```

### Priority Loading

For above-the-fold images:

```blade
<x-strata::image
    src="/images/hero.jpg"
    alt="Hero"
    loading="eager"
    fetchpriority="high"
/>
```

## Spatie Media Library

```blade
<x-strata::image
    :media="$user->getFirstMedia('avatars')"
    alt="User avatar"
/>
```

## Events

```blade
<div
    x-on:image-loaded="console.log('Loaded')"
    x-on:image-error="console.log('Failed')"
>
    <x-strata::image src="/images/photo.jpg" alt="Event test" />
</div>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `src` | string | required | Image URL |
| `alt` | string | required* | Alt text |
| `width` | int | null | Width in pixels |
| `height` | int | null | Height in pixels |
| `loading` | string | `'lazy'` | `'lazy'` or `'eager'` |
| `srcset` | string | null | Responsive sources |
| `sizes` | string | null | Responsive sizes |
| `sources` | array | null | Picture sources |
| `formats` | array | null | Auto-generate formats |
| `placeholder` | string | null | Blur placeholder URL |
| `blurHash` | string | null | BlurHash string |
| `placeholderType` | string | `'skeleton'` | `'blur'`, `'skeleton'`, `'none'` |
| `fallback` | string | null | Fallback image URL |
| `media` | object | null | Spatie Media object |
| `lightbox` | string\|bool | null | Lightbox gallery name |
| `lightboxCaption` | string | null | Lightbox caption |
| `aspect` | string | null | Aspect ratio |
| `objectFit` | string | `'cover'` | CSS object-fit |
| `objectPosition` | string | `'center'` | CSS object-position |
| `rounded` | string | `'md'` | Border radius |
| `caption` | string | null | Caption text |
| `captionPosition` | string | `'bottom'` | `'bottom'` or `'overlay'` |
| `decorative` | bool | false | Skip alt requirement |
| `fetchpriority` | string | null | Fetch priority hint |
| `decodeAsync` | bool | true | Async decoding |

\* Required unless `decorative="true"`
