# Slider Component

A flexible, accessible carousel/slider component with support for both presentational (carousel) and form (value selection) modes. Features autoplay, loop, navigation controls, and extensive customization.

## Installation

The slider component is included in Strata UI. No additional installation required.

## Basic Usage

### Presentational Carousel

```blade
<x-strata::slider :autoplay="true" :loop="true">
    <x-strata::slider.item>
        <img src="/image1.jpg" alt="Slide 1">
    </x-strata::slider.item>
    <x-strata::slider.item>
        <img src="/image2.jpg" alt="Slide 2">
    </x-strata::slider.item>
    <x-strata::slider.item>
        <img src="/image3.jpg" alt="Slide 3">
    </x-strata::slider.item>
</x-strata::slider>
```

### Form Mode with Livewire

```blade
<x-strata::slider
    mode="form"
    wire:model="selectedProduct"
    name="product_selection"
    :perView="3"
>
    <x-strata::slider.item>
        <div class="p-4">
            <h3>Product A</h3>
            <p>$99.99</p>
        </div>
    </x-strata::slider.item>
    <x-strata::slider.item>
        <div class="p-4">
            <h3>Product B</h3>
            <p>$149.99</p>
        </div>
    </x-strata::slider.item>
    <x-strata::slider.item>
        <div class="p-4">
            <h3>Product C</h3>
            <p>$199.99</p>
        </div>
    </x-strata::slider.item>
</x-strata::slider>
```

## Props Reference

### Slider Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `mode` | string | `'presentational'` | Component mode: `presentational`, `form` |
| `size` | string | `'md'` | Size variant: `sm`, `md`, `lg` |
| `state` | string | `'default'` | Validation state (form mode only): `default`, `success`, `error`, `warning` |
| `id` | string | `'slider-{uniqid}'` | Component ID |
| `name` | string | `null` | Form input name (form mode) |
| `value` | int\|null | `null` | Selected slide index (form mode) |
| `perView` | int | `1` | Number of slides visible at once: `1-4` |
| `gap` | int | `4` | Gap between slides in Tailwind spacing units |
| `peek` | boolean | `false` | Show partial next/previous slides |
| `peekAmount` | string | `'10%'` | Amount of peek as CSS value |
| `loop` | boolean | `false` | Enable infinite loop |
| `autoplay` | boolean | `false` | Enable autoplay |
| `autoplayDelay` | int | `5000` | Autoplay delay in milliseconds |
| `showNavigation` | boolean | `true` | Show prev/next buttons |
| `showDots` | boolean | `true` | Show dot indicators |
| `snapAlign` | string | `'start'` | Scroll snap alignment: `start`, `center`, `end` |

### Slider Item Component

The slider item component accepts any content via the default slot. Each item will be automatically sized based on the parent slider's `perView` and `peek` settings.

## Modes

### Presentational Mode (Default)

Standard carousel for displaying content. Supports autoplay, navigation, and loop features.

```blade
<x-strata::slider :autoplay="true" :loop="true" :showDots="true">
    <x-strata::slider.item>
        <div class="bg-primary text-primary-foreground p-8 rounded-lg">
            <h2>Welcome</h2>
            <p>First slide content</p>
        </div>
    </x-strata::slider.item>
    <x-strata::slider.item>
        <div class="bg-secondary text-secondary-foreground p-8 rounded-lg">
            <h2>Features</h2>
            <p>Second slide content</p>
        </div>
    </x-strata::slider.item>
</x-strata::slider>
```

### Form Mode

Allows slide selection as a form value with Livewire sync. Perfect for product selection, image galleries with selection, or step indicators.

```blade
<x-strata::slider
    mode="form"
    wire:model.live="selectedIndex"
    state="default"
    :loop="false"
>
    <x-strata::slider.item>Option 1</x-strata::slider.item>
    <x-strata::slider.item>Option 2</x-strata::slider.item>
    <x-strata::slider.item>Option 3</x-strata::slider.item>
</x-strata::slider>
```

## Sizes

Three size options control the minimum height of the slider:

```blade
<x-strata::slider size="sm">
    <x-strata::slider.item>Small (min-h-32)</x-strata::slider.item>
</x-strata::slider>

<x-strata::slider size="md">
    <x-strata::slider.item>Medium (min-h-48, default)</x-strata::slider.item>
</x-strata::slider>

<x-strata::slider size="lg">
    <x-strata::slider.item>Large (min-h-64)</x-strata::slider.item>
</x-strata::slider>
```

## Validation States (Form Mode)

Four validation states available in form mode:

```blade
<x-strata::slider mode="form" state="default" wire:model="value">
    <x-strata::slider.item>Default</x-strata::slider.item>
</x-strata::slider>

<x-strata::slider mode="form" state="success" wire:model="value">
    <x-strata::slider.item>Success</x-strata::slider.item>
</x-strata::slider>

<x-strata::slider mode="form" state="error" wire:model="value">
    <x-strata::slider.item>Error</x-strata::slider.item>
</x-strata::slider>

<x-strata::slider mode="form" state="warning" wire:model="value">
    <x-strata::slider.item>Warning</x-strata::slider.item>
</x-strata::slider>
```

## Per View Configuration

Display multiple slides at once:

```blade
{{-- Single slide (default) --}}
<x-strata::slider :perView="1">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
    <x-strata::slider.item>Slide 2</x-strata::slider.item>
    <x-strata::slider.item>Slide 3</x-strata::slider.item>
</x-strata::slider>

{{-- Two slides visible --}}
<x-strata::slider :perView="2" :gap="6">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
    <x-strata::slider.item>Slide 2</x-strata::slider.item>
    <x-strata::slider.item>Slide 3</x-strata::slider.item>
</x-strata::slider>

{{-- Three slides visible --}}
<x-strata::slider :perView="3" :gap="4">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
    <x-strata::slider.item>Slide 2</x-strata::slider.item>
    <x-strata::slider.item>Slide 3</x-strata::slider.item>
</x-strata::slider>
```

## Peek Mode

Show partial next/previous slides to indicate more content:

```blade
<x-strata::slider :peek="true" peekAmount="15%">
    <x-strata::slider.item>
        <div class="bg-primary text-primary-foreground p-8 rounded-lg">
            Slide 1
        </div>
    </x-strata::slider.item>
    <x-strata::slider.item>
        <div class="bg-secondary text-secondary-foreground p-8 rounded-lg">
            Slide 2
        </div>
    </x-strata::slider.item>
</x-strata::slider>
```

## Autoplay

Enable automatic slide progression:

```blade
<x-strata::slider
    :autoplay="true"
    :autoplayDelay="3000"
    :loop="true"
>
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
    <x-strata::slider.item>Slide 2</x-strata::slider.item>
    <x-strata::slider.item>Slide 3</x-strata::slider.item>
</x-strata::slider>
```

**Autoplay Features:**
- Automatically advances slides after delay
- Respects `prefers-reduced-motion` user preference
- Stops when carousel receives focus (W3C accessibility requirement)
- Pauses on hover
- Shows play/pause control button
- Can be toggled by user

## Navigation Controls

Customize the visibility and position of navigation elements:

```blade
{{-- Hide navigation buttons --}}
<x-strata::slider :showNavigation="false">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
</x-strata::slider>

{{-- Hide dot indicators --}}
<x-strata::slider :showDots="false">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
</x-strata::slider>

{{-- Minimal controls --}}
<x-strata::slider :showNavigation="false" :showDots="false">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
</x-strata::slider>
```

## Loop Mode

Enable infinite looping:

```blade
<x-strata::slider :loop="true" :autoplay="true">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
    <x-strata::slider.item>Slide 2</x-strata::slider.item>
    <x-strata::slider.item>Slide 3</x-strata::slider.item>
</x-strata::slider>
```

When `loop` is enabled:
- Next button on last slide goes to first slide
- Previous button on first slide goes to last slide
- Autoplay continuously loops through slides

When `loop` is disabled:
- Next button is disabled on last slide
- Previous button is disabled on first slide
- Autoplay stops at last slide

## Snap Alignment

Control how slides align within the viewport:

```blade
{{-- Align to start (default) --}}
<x-strata::slider snapAlign="start">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
</x-strata::slider>

{{-- Center alignment --}}
<x-strata::slider snapAlign="center">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
</x-strata::slider>

{{-- End alignment --}}
<x-strata::slider snapAlign="end">
    <x-strata::slider.item>Slide 1</x-strata::slider.item>
</x-strata::slider>
```

## Accessibility

The slider component follows W3C ARIA Authoring Practices Guide (APG) carousel pattern:

### ARIA Roles and Properties
- Container has `role="region"` with `aria-roledescription="carousel"`
- Each slide has `role="group"` with `aria-roledescription="slide"`
- Live region announces slide changes to screen readers
- Controls properly labeled with `aria-label`

### Keyboard Navigation
- **Tab/Shift+Tab**: Navigate through interactive controls
- **Space/Enter**: Activate buttons (navigation, dots, play/pause)
- **Note**: Arrow keys are NOT used for slide navigation (prevents conflict with screen reader virtual cursor)

### Focus Management
- Controls are positioned before slides in DOM for better keyboard UX
- Auto-rotation stops permanently when any carousel element receives focus
- Focus order: play/pause → dots → navigation → slides

### Screen Reader Support
- Slide changes announced via ARIA live region
- Slide position information provided (e.g., "Slide 2 of 5")
- Button labels are descriptive and dynamic
- Hidden slides are excluded from focus order

### Motion Preferences
- Respects `prefers-reduced-motion` media query
- Autoplay disabled when reduced motion preferred

## Touch Support

Native touch gestures supported:
- **Swipe left**: Next slide
- **Swipe right**: Previous slide
- Swipe threshold: 30% of container width
- Pauses autoplay on swipe

## Advanced Examples

### Product Gallery with Selection

```blade
<div>
    <x-strata::slider
        mode="form"
        wire:model.live="selectedProduct"
        :perView="3"
        :gap="4"
        state="{{ $errors->has('selectedProduct') ? 'error' : 'default' }}"
    >
        @foreach($products as $index => $product)
            <x-strata::slider.item>
                <div class="p-4 border rounded-lg hover:border-primary transition">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded">
                    <h3 class="mt-2 font-semibold">{{ $product->name }}</h3>
                    <p class="text-muted-foreground">${{ $product->price }}</p>
                </div>
            </x-strata::slider.item>
        @endforeach
    </x-strata::slider>

    @error('selectedProduct')
        <p class="text-destructive text-sm mt-2">{{ $message }}</p>
    @enderror
</div>
```

### Testimonials Carousel

```blade
<x-strata::slider
    :autoplay="true"
    :autoplayDelay="5000"
    :loop="true"
    snapAlign="center"
>
    @foreach($testimonials as $testimonial)
        <x-strata::slider.item>
            <div class="max-w-2xl mx-auto text-center p-8">
                <p class="text-lg italic">"{{ $testimonial->quote }}"</p>
                <p class="mt-4 font-semibold">{{ $testimonial->author }}</p>
                <p class="text-sm text-muted-foreground">{{ $testimonial->role }}</p>
            </div>
        </x-strata::slider.item>
    @endforeach
</x-strata::slider>
```

### Image Gallery with Peek

```blade
<x-strata::slider
    :peek="true"
    peekAmount="10%"
    :perView="1"
    :gap="4"
    :showDots="false"
>
    @foreach($images as $image)
        <x-strata::slider.item>
            <img src="{{ $image }}" alt="Gallery image" class="w-full h-96 object-cover rounded-lg">
        </x-strata::slider.item>
    @endforeach
</x-strata::slider>
```

## Browser Support

Uses modern CSS scroll-snap for optimal performance:
- Chrome/Edge: Full support
- Firefox: Full support
- Safari: Full support
- All modern mobile browsers

Graceful degradation for older browsers with native scrolling behavior.

## Performance

The slider component is optimized for performance:

- **Native scroll-snap**: Browser-optimized scrolling instead of JavaScript positioning
- **Passive touch listeners**: Prevents scroll blocking
- **Debounced scroll detection**: Reduces scroll event processing
- **CSS-only animations**: Hardware-accelerated transitions
- **No external dependencies**: Minimal JavaScript footprint

## Technical Details

### State Management
- Uses Alpine.js for transient UI state
- Uses Entangleable module for bidirectional Alpine ↔ Livewire sync (form mode)
- Native CSS scroll-snap for position management

### JavaScript Module
The slider is powered by the `StrataSlider` JavaScript class:
- Automatic initialization via Alpine `x-data`
- Proper cleanup on component destruction
- Event-driven architecture
- Touch gesture detection
- Scroll position tracking

### CSS Architecture
- Tailwind CSS utility classes
- CSS scroll-snap for native browser behavior
- Responsive by default
- No custom CSS required
