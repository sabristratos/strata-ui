# Carousel

A flexible carousel component inspired by Embla Carousel's best practices. Perfect for image galleries, testimonials, product showcases, and any content that benefits from horizontal scrolling.

## Features

- **Native Scroll Snap** - Leverages CSS scroll-snap for smooth, performant scrolling
- **Drag & Touch** - Full mouse drag and touch/swipe support
- **Keyboard Navigation** - Arrow keys, Home/End for accessibility
- **Loop Mode** - Infinite carousel with seamless wrapping
- **Autoplay** - Automatic slide advancement with pause on hover
- **Alignment Modes** - Start, center, or end alignment for slides
- **Pagination** - Dots, counter, and navigation buttons
- **Responsive** - Automatic dimension updates with ResizeObserver
- **Accessible** - ARIA compliant with proper roles and labels
- **Configurable** - Extensive options for customization
- **Motion Sensitive** - Respects prefers-reduced-motion

## Basic Usage

```blade
<x-strata::carousel>
    <x-strata::carousel.slide>
        <img src="slide1.jpg" alt="Slide 1" class="w-full h-64 object-cover rounded-lg">
    </x-strata::carousel.slide>
    <x-strata::carousel.slide>
        <img src="slide2.jpg" alt="Slide 2" class="w-full h-64 object-cover rounded-lg">
    </x-strata::carousel.slide>
    <x-strata::carousel.slide>
        <img src="slide3.jpg" alt="Slide 3" class="w-full h-64 object-cover rounded-lg">
    </x-strata::carousel.slide>
</x-strata::carousel>
```

## With Autoplay

```blade
<x-strata::carousel
    :autoplay="true"
    :autoplayDelay="3000"
    :loop="true"
>
    {{-- Slides --}}
</x-strata::carousel>
```

## Product Gallery Example

```blade
<x-strata::carousel
    align="center"
    :loop="true"
    size="lg"
    aria-label="Product images"
>
    @foreach($product->images as $image)
        <x-strata::carousel.slide>
            <img
                src="{{ $image->url }}"
                alt="{{ $product->name }}"
                class="w-full h-96 object-cover rounded-lg"
            >
        </x-strata::carousel.slide>
    @endforeach
</x-strata::carousel>
```

## Testimonials Carousel

```blade
<x-strata::carousel
    :autoplay="true"
    :autoplayDelay="5000"
    :loop="true"
    :arrows="false"
    :dots="true"
    :counter="false"
>
    @foreach($testimonials as $testimonial)
        <x-strata::carousel.slide>
            <x-strata::card class="mx-4">
                <x-slot:content>
                    <p class="text-lg italic">"{{ $testimonial->quote }}"</p>
                    <p class="mt-4 font-semibold">- {{ $testimonial->author }}</p>
                </x-slot:content>
            </x-strata::card>
        </x-strata::carousel.slide>
    @endforeach
</x-strata::carousel>
```

## Featured Products

```blade
<x-strata::carousel
    align="start"
    :slidesToScroll="3"
    :arrows="true"
    :dots="false"
>
    @foreach($products as $product)
        <x-strata::carousel.slide class="w-80">
            <x-strata::card>
                <x-slot:content>
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <h3 class="mt-2 font-semibold">{{ $product->name }}</h3>
                    <p class="text-muted-foreground">${{ $product->price }}</p>
                </x-slot:content>
            </x-strata::card>
        </x-strata::carousel.slide>
    @endforeach
</x-strata::carousel>
```

## Configuration Options

### `align` (string)
Slide alignment within viewport. Default: `'start'`
- `'start'` - Align slides to the left/start
- `'center'` - Center slides in viewport
- `'end'` - Align slides to the right/end

```blade
<x-strata::carousel align="center">
```

### `loop` (boolean)
Enable infinite looping. Default: `false`

```blade
<x-strata::carousel :loop="true">
```

### `containScroll` (string|boolean)
Prevents empty space at carousel edges. Default: `'trimSnaps'`

- `'trimSnaps'` - Removes snap points that would create empty space (recommended)
- `'keepSnaps'` - Keeps all snap points but adjusts scroll positions
- `false` - Disables contain scroll (allows empty space)

**How it works:**
When using `align="start"`, the carousel automatically trims snap points that would result in scrolling past the last fully-visible slide(s), preventing awkward empty space at the end.

```blade
{{-- Default: prevents empty space --}}
<x-strata::carousel align="start">

{{-- Keep all snap points, adjust positions --}}
<x-strata::carousel align="start" containScroll="keepSnaps">

{{-- Allow empty space (not recommended) --}}
<x-strata::carousel align="start" :containScroll="false">
```

**Note:** `containScroll` is ignored when `loop` is enabled since loop mode naturally fills all space.

### `slidesToScroll` (number|string)
Number of slides to scroll at once. Default: `1`
- `1`, `2`, `3`, etc. - Fixed number of slides
- `'auto'` - Automatically determine based on visible slides

```blade
<x-strata::carousel :slidesToScroll="2">
<x-strata::carousel slidesToScroll="auto">
```

### `autoplay` (boolean)
Enable automatic slide advancement. Default: `false`

```blade
<x-strata::carousel :autoplay="true">
```

### `autoplayDelay` (number)
Milliseconds between auto-advances. Default: `3000`

```blade
<x-strata::carousel :autoplay="true" :autoplayDelay="5000">
```

### `speed` (number)
Transition duration in milliseconds. Default: `300`

```blade
<x-strata::carousel :speed="500">
```

### `draggable` (boolean)
Enable drag/touch interactions. Default: `true`

```blade
<x-strata::carousel :draggable="false">
```

### `dragFree` (boolean)
Enable momentum scrolling. Default: `false`

```blade
<x-strata::carousel :dragFree="true">
```

### `arrows` (boolean)
Show prev/next navigation buttons. Default: `true`

```blade
<x-strata::carousel :arrows="false">
```

### `dots` (boolean)
Show pagination dots. Default: `true`

```blade
<x-strata::carousel :dots="false">
```

### `counter` (boolean)
Show slide counter (e.g., "1 / 5"). Default: `false`

```blade
<x-strata::carousel :counter="true">
```

### `size` (string)
Size variant for spacing and controls. Default: `'md'`
- `'xs'` - Extra small spacing and controls
- `'sm'` - Small spacing and controls
- `'md'` - Medium spacing and controls
- `'lg'` - Large spacing and controls
- `'xl'` - Extra large spacing and controls

```blade
<x-strata::carousel size="lg">
```

### `state` (string)
Visual state for controls. Default: `'default'`
- `'default'` - Default styling with background/foreground colors
- `'primary'` - Primary brand colors for controls

```blade
<x-strata::carousel state="primary">
```

### `watchSlides` (boolean)
Automatically detect when slides are added/removed dynamically. Default: `true`

```blade
<x-strata::carousel :watchSlides="true">
```

When enabled, the carousel uses MutationObserver to detect changes to slides and automatically recalculates snap points and dimensions. Useful for dynamic content loaded via Livewire or Alpine.

### `dragThreshold` (number)
Drag distance in pixels required to trigger slide change. Default: `10`

```blade
<x-strata::carousel :dragThreshold="20">
```

Lower values make the carousel more sensitive to drag gestures. Embla's default is 10 pixels.

### `inViewThreshold` (float)
Threshold for IntersectionObserver (0-1). Default: `0`

```blade
<x-strata::carousel :inViewThreshold="0.5">
```

Determines what percentage of a slide must be visible to trigger the `carousel-slide-in-view` event.
- `0` = Any part visible
- `0.5` = Half the slide visible
- `1` = Fully visible

## Sub-Components

### Slide

Use `<x-strata::carousel.slide>` to wrap each slide:

```blade
<x-strata::carousel>
    <x-strata::carousel.slide class="w-full md:w-1/2 lg:w-1/3">
        {{-- Content --}}
    </x-strata::carousel.slide>
</x-strata::carousel>
```

## Understanding Pagination

### How Dots Work

**Important:** Pagination dots represent **scroll positions** (snap points), not individual slides.

When multiple slides are visible in the viewport at once, the carousel intelligently groups them:

**Example:**
- 6 total slides
- Viewport shows 3 slides at a time
- `align="start"` with `containScroll="trimSnaps"`
- **Result:** 4 dots (not 6!)
  - Dot 1: Shows slides 1-3
  - Dot 2: Shows slides 2-4
  - Dot 3: Shows slides 3-5
  - Dot 4: Shows slides 4-6

This prevents the awkward scenario where clicking the last dot would leave empty space.

### Dot Count Formula

**With `containScroll` enabled (default):**
- Dots = Number of unique scroll positions that don't create empty space
- Automatically calculated based on slide widths and viewport size

**With `containScroll="false"`:**
- Dots = Total number of slides
- May result in empty space at the end

### Controlling Dot Behavior

```blade
{{-- Fewer dots: group slides by scroll position --}}
<x-strata::carousel align="start" containScroll="trimSnaps">
    <x-strata::carousel.slide class="w-1/3">...</x-strata::carousel.slide>
</x-strata::carousel>

{{-- More dots: one per slide --}}
<x-strata::carousel align="center">
    <x-strata::carousel.slide class="w-full">...</x-strata::carousel.slide>
</x-strata::carousel>

{{-- No pagination: use counter instead --}}
<x-strata::carousel :dots="false" :counter="true">
```

## Accessibility

The carousel includes comprehensive ARIA support:

- `role="region"` on the carousel container
- `aria-roledescription="carousel"` for screen readers
- `role="group"` and `aria-roledescription="slide"` on each slide
- `aria-label` on navigation controls
- `role="tablist"` and `role="tab"` on pagination dots
- `aria-live="polite"` on the slide counter
- Full keyboard navigation support

### Custom Aria Label

```blade
<x-strata::carousel aria-label="Product gallery">
```

## Keyboard Navigation

- `Arrow Left` - Navigate to previous slide
- `Arrow Right` - Navigate to next slide
- `Home` - Jump to first slide
- `End` - Jump to last slide

## Events

The carousel dispatches custom Alpine events you can listen to:

### `carousel-init`
Fired when carousel initializes.

```blade
<div x-data @carousel-init="console.log($event.detail)">
    <x-strata::carousel>
        {{-- Slides --}}
    </x-strata::carousel>
</div>
```

Event detail:
```javascript
{
    totalSlides: 5,
    currentIndex: 0
}
```

### `carousel-select`
Fired when a new slide is selected.

```blade
<div x-data @carousel-select="console.log($event.detail)">
    <x-strata::carousel>
        {{-- Slides --}}
    </x-strata::carousel>
</div>
```

Event detail:
```javascript
{
    index: 2,
    slide: HTMLElement
}
```

### `carousel-scroll`
Fired continuously during scrolling.

```blade
<div x-data @carousel-scroll="updateProgress($event.detail)">
    <x-strata::carousel>
        {{-- Slides --}}
    </x-strata::carousel>
</div>
```

Event detail:
```javascript
{
    currentIndex: 1,
    progress: 0.5 // 0-1 range
}
```

### `carousel-settle`
Fired after scrolling completes.

```blade
<div x-data @carousel-settle="console.log($event.detail)">
    <x-strata::carousel>
        {{-- Slides --}}
    </x-strata::carousel>
</div>
```

Event detail:
```javascript
{
    currentIndex: 2
}
```

## Responsive Slides

Control slide width with Tailwind classes:

```blade
<x-strata::carousel align="start">
    <x-strata::carousel.slide class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
        {{-- Content scales from full width to 1/4 width --}}
    </x-strata::carousel.slide>
</x-strata::carousel>
```

## Best Practices

### Use appropriate `align` mode
- `start` - Best for card lists and browsing content
- `center` - Best for featured items and hero carousels
- `end` - Rarely used, specific design scenarios

### Autoplay considerations
- Use autoplay sparingly - it can be distracting
- Provide adequate `autoplayDelay` (minimum 3000ms recommended)
- Always enable `loop` when using autoplay
- Autoplay pauses on hover and interaction

### Accessibility
- Always provide meaningful `aria-label` attributes
- Ensure sufficient color contrast on controls
- Test keyboard navigation thoroughly
- Respect `prefers-reduced-motion` (handled automatically)

### Performance
- Optimize images with appropriate sizes
- Use lazy loading for images beyond the viewport
- Limit total number of slides when possible
- Consider pagination for very long carousels

## Advanced Examples

### Synced Carousels

```blade
<div
    x-data="{
        mainIndex: 0,
        syncMain(event) { this.mainIndex = event.detail.index; },
        syncThumb(index) { this.mainIndex = index; }
    }"
>
    {{-- Main carousel --}}
    <x-strata::carousel
        :arrows="true"
        :dots="false"
        @carousel-select="syncMain($event)"
    >
        @foreach($images as $image)
            <x-strata::carousel.slide>
                <img src="{{ $image }}" class="w-full h-96 object-cover">
            </x-strata::carousel.slide>
        @endforeach
    </x-strata::carousel>

    {{-- Thumbnail carousel --}}
    <x-strata::carousel
        :arrows="false"
        :dots="false"
        size="sm"
        class="mt-4"
    >
        @foreach($images as $index => $image)
            <x-strata::carousel.slide
                @click="syncThumb({{ $index }})"
                class="w-24 cursor-pointer"
                :class="mainIndex === {{ $index }} ? 'ring-2 ring-primary' : 'opacity-60'"
            >
                <img src="{{ $image }}" class="w-full h-24 object-cover">
            </x-strata::carousel.slide>
        @endforeach
    </x-strata::carousel>
</div>
```

### Custom Progress Indicator

```blade
<div x-data="{ progress: 0 }">
    <x-strata::carousel
        :dots="false"
        @carousel-scroll="progress = $event.detail.progress"
    >
        {{-- Slides --}}
    </x-strata::carousel>

    {{-- Progress bar --}}
    <div class="h-1 bg-muted mt-4">
        <div
            class="h-full bg-primary transition-all"
            :style="`width: ${progress * 100}%`"
        ></div>
    </div>
</div>
```

### Dynamic Content with reInit()

When adding/removing slides dynamically (with `watchSlides` disabled), manually call `reInit()`:

```blade
<div x-data="{ slides: [1, 2, 3] }">
    <x-strata::carousel x-ref="myCarousel" :watchSlides="false">
        <template x-for="slide in slides" :key="slide">
            <x-strata::carousel.slide>
                <div x-text="'Slide ' + slide"></div>
            </x-strata::carousel.slide>
        </template>
    </x-strata::carousel>

    <button @click="slides.push(slides.length + 1); $nextTick(() => $refs.myCarousel.reInit())">
        Add Slide
    </button>
</div>
```

## Understanding Partial Slide Visibility

**Partial slide visibility is intentional and by design** - it's a core feature of Embla Carousel that provides:

- Visual indication that more content exists
- Better user experience with "peek" at next/previous slides
- Responsive behavior where slides naturally adapt to viewport

### Example: Why You See 2.5 Slides

```blade
{{-- Viewport: 1200px, Each slide: 480px (including gap) --}}
{{-- 1200 / 480 = 2.5 slides visible (this is correct!) --}}
<x-strata::carousel>
    <x-strata::carousel.slide class="w-1/3 px-2">
        {{-- Content --}}
    </x-strata::carousel.slide>
</x-strata::carousel>
```

### Controlling Slide Widths

**For fixed number of full slides:**
```blade
{{-- Exactly 3 full slides, accounting for gaps --}}
<x-strata::carousel align="start">
    <x-strata::carousel.slide class="w-[calc(33.333%-10.667px)] mx-2">
        {{-- Each slide: 33.333% minus proportional gap --}}
    </x-strata::carousel.slide>
</x-strata::carousel>
```

**For auto grouping:**
```blade
{{-- Let carousel intelligently group slides that fit --}}
<x-strata::carousel slidesToScroll="auto">
    <x-strata::carousel.slide class="w-80 px-2">
        {{-- Fixed 320px slides - carousel auto-calculates groups --}}
    </x-strata::carousel.slide>
</x-strata::carousel>
```

### How `slidesToScroll="auto"` Works

When set to `'auto'`, the carousel intelligently groups slides:

1. Measures viewport width
2. Groups consecutive slides until they exceed viewport width
3. Creates navigation groups based on these natural boundaries
4. Clicking "Next" jumps to the start of the next group

**Example with 6 slides (300px each) in 1000px viewport:**
- Group 1: Slides 1-3 (900px)
- Group 2: Slides 4-6 (900px)
- Result: 2 navigation groups, smooth jumping between them
