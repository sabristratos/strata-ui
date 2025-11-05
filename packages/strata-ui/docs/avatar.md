# Avatar

Flexible avatar components for user profiles, teams, and status indicators. Features intelligent fallback hierarchy, comprehensive color system, and grouping with overflow counters.

## Avatar Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `src` | string | `null` | Image URL | Avatar image source |
| `alt` | string | `null` | Alt text | Alternative text for image |
| `name` | string | `null` | Full name | Generates initials (first + last) |
| `icon` | string | `null` | Icon name | Display icon instead of image |
| `size` | string | `md` | `xs`, `sm`, `md`, `lg`, `xl`, `2xl` | Avatar size |
| `shape` | string | `circle` | `circle`, `square`, `rounded` | Avatar shape |
| `variant` | string | `secondary` | Design system + Tailwind colors | Background color for fallback states |
| `style` | string | `filled` | `filled`, `outlined`, `soft` | Visual style for fallback states |

## Avatar Group Props

Use `<x-strata::avatar.group>` to display overlapping avatar stacks with overflow counters.

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `max` | number | `3` | Any number | Maximum avatars before showing +N counter |
| `size` | string | `md` | `xs`, `sm`, `md`, `lg`, `xl`, `2xl` | Size applied to all child avatars |
| `shape` | string | `circle` | `circle`, `square`, `rounded` | Shape applied to all child avatars |
| `ring` | string | `accent` | Design system + Tailwind colors | Ring color separating overlapping avatars |
| `variant` | string | `secondary` | Design system + Tailwind colors | Counter badge background color |
| `style` | string | `filled` | `filled`, `outlined`, `soft` | Counter badge visual style |

## Sizes

```blade
<x-strata::avatar src="/avatar.jpg" size="xs" />
<x-strata::avatar src="/avatar.jpg" size="sm" />
<x-strata::avatar src="/avatar.jpg" size="md" />
<x-strata::avatar src="/avatar.jpg" size="lg" />
<x-strata::avatar src="/avatar.jpg" size="xl" />
<x-strata::avatar src="/avatar.jpg" size="2xl" />
```

## Shapes

```blade
<x-strata::avatar src="/avatar.jpg" shape="circle" />
<x-strata::avatar src="/avatar.jpg" shape="square" />
<x-strata::avatar src="/avatar.jpg" shape="rounded" />
```

## Fallback Hierarchy

Avatars automatically fall back through 4 levels until content is found:

```blade
{{-- 1. Image (highest priority) --}}
<x-strata::avatar src="/avatar.jpg" alt="John Doe" />

{{-- 2. Icon (if no image) --}}
<x-strata::avatar icon="user-circle" variant="primary" />

{{-- 3. Initials (if no image or icon, generated from name) --}}
<x-strata::avatar name="Jane Smith" variant="success" />

{{-- 4. Placeholder icon (if nothing else provided) --}}
<x-strata::avatar variant="secondary" />
```

## Initials Generation

Avatars automatically generate initials from names:

```blade
<x-strata::avatar name="John Doe" />          {{-- Shows "JD" --}}
<x-strata::avatar name="Jane Smith" />        {{-- Shows "JS" --}}
<x-strata::avatar name="Alice" />             {{-- Shows "A" --}}
<x-strata::avatar name="Bob van der Berg" />  {{-- Shows "BV" (first + second word) --}}
```

## Color Variants

### Design System Variants

Avatars support all 6 design system color variants for fallback states (initials, icons, placeholder):

```blade
<x-strata::avatar name="Primary User" variant="primary" />
<x-strata::avatar name="Secondary User" variant="secondary" />
<x-strata::avatar icon="user" variant="success" />
<x-strata::avatar icon="user" variant="warning" />
<x-strata::avatar icon="user" variant="destructive" />
<x-strata::avatar icon="user" variant="info" />
```

### Tailwind Color Variants

Beyond design system variants, avatars support all 22 Tailwind color palettes:

```blade
<x-strata::avatar name="Blue" variant="blue" />
<x-strata::avatar name="Purple" variant="purple" />
<x-strata::avatar name="Pink" variant="pink" />
<x-strata::avatar name="Orange" variant="orange" />
<x-strata::avatar name="Green" variant="green" />
<x-strata::avatar name="Red" variant="red" />
{{-- Also: amber, yellow, lime, emerald, teal, cyan, sky, indigo, violet, fuchsia, rose, slate, gray, zinc, neutral, stone --}}
```

## Styles

Three visual styles available for fallback states:

```blade
{{-- Filled (default) - Solid background --}}
<x-strata::avatar name="Filled" variant="primary" style="filled" />

{{-- Outlined - Transparent with border --}}
<x-strata::avatar name="Outlined" variant="primary" style="outlined" />

{{-- Soft - Light background with darker text --}}
<x-strata::avatar name="Soft" variant="primary" style="soft" />
```

## Icon Avatars

Use icons for system users, bots, or role indicators:

```blade
<x-strata::avatar icon="user" variant="secondary" />
<x-strata::avatar icon="user-circle" variant="primary" />
<x-strata::avatar icon="shield" variant="success" size="lg" />
<x-strata::avatar icon="cog" variant="info" size="lg" />
```

## Avatar Groups

Display overlapping avatar stacks with automatic overflow counters:

```blade
{{-- Basic group --}}
<x-strata::avatar.group>
    <x-strata::avatar src="/user1.jpg" />
    <x-strata::avatar src="/user2.jpg" />
    <x-strata::avatar src="/user3.jpg" />
    <x-strata::avatar src="/user4.jpg" />
    <x-strata::avatar src="/user5.jpg" />
</x-strata::avatar.group>
{{-- Shows 3 avatars + "+2" counter --}}
```

### Max Prop

Control how many avatars display before showing the overflow counter:

```blade
{{-- Show 2 avatars max --}}
<x-strata::avatar.group max="2">
    <x-strata::avatar name="User 1" />
    <x-strata::avatar name="User 2" />
    <x-strata::avatar name="User 3" />
    <x-strata::avatar name="User 4" />
</x-strata::avatar.group>
{{-- Shows 2 avatars + "+2" counter --}}

{{-- Show 5 avatars max --}}
<x-strata::avatar.group max="5">
    <x-strata::avatar name="User 1" />
    <x-strata::avatar name="User 2" />
    <x-strata::avatar name="User 3" />
    <x-strata::avatar name="User 4" />
    <x-strata::avatar name="User 5" />
    <x-strata::avatar name="User 6" />
</x-strata::avatar.group>
{{-- Shows 5 avatars + "+1" counter --}}
```

### Group Sizes and Shapes

Size and shape props apply to all child avatars:

```blade
{{-- Small circular group --}}
<x-strata::avatar.group size="sm" shape="circle">
    <x-strata::avatar name="User 1" />
    <x-strata::avatar name="User 2" />
    <x-strata::avatar name="User 3" />
</x-strata::avatar.group>

{{-- Large rounded group --}}
<x-strata::avatar.group size="lg" shape="rounded">
    <x-strata::avatar name="User 1" />
    <x-strata::avatar name="User 2" />
    <x-strata::avatar name="User 3" />
</x-strata::avatar.group>
```

### Colored Groups

Customize counter badge and ring colors independently:

```blade
{{-- Counter badge variants (design system) --}}
<x-strata::avatar.group variant="primary">
    <x-strata::avatar name="User 1" />
    <x-strata::avatar name="User 2" />
    <x-strata::avatar name="User 3" />
    <x-strata::avatar name="User 4" />
</x-strata::avatar.group>

{{-- Counter badge styles --}}
<x-strata::avatar.group variant="success" style="filled">...</x-strata::avatar.group>
<x-strata::avatar.group variant="success" style="outlined">...</x-strata::avatar.group>
<x-strata::avatar.group variant="success" style="soft">...</x-strata::avatar.group>

{{-- Tailwind color variants --}}
<x-strata::avatar.group variant="purple">...</x-strata::avatar.group>
<x-strata::avatar.group variant="orange">...</x-strata::avatar.group>

{{-- Ring colors --}}
<x-strata::avatar.group ring="primary">...</x-strata::avatar.group>
<x-strata::avatar.group ring="success">...</x-strata::avatar.group>
<x-strata::avatar.group ring="purple">...</x-strata::avatar.group>

{{-- Combined ring + counter colors --}}
<x-strata::avatar.group variant="primary" ring="primary">...</x-strata::avatar.group>
<x-strata::avatar.group variant="purple" ring="fuchsia">...</x-strata::avatar.group>
```

### Mixed Color Avatar Groups

Individual avatars can have different colors within a group:

```blade
{{-- Team with role-based colors --}}
<x-strata::avatar.group size="lg">
    <x-strata::avatar name="Admin" variant="primary" />
    <x-strata::avatar name="Editor" variant="blue" />
    <x-strata::avatar name="Reviewer" variant="purple" />
    <x-strata::avatar name="Viewer" variant="secondary" />
    <x-strata::avatar name="Guest" variant="secondary" />
</x-strata::avatar.group>

{{-- Status indicators --}}
<x-strata::avatar.group>
    <x-strata::avatar name="Active" variant="success" />
    <x-strata::avatar name="Away" variant="warning" />
    <x-strata::avatar name="Busy" variant="destructive" />
    <x-strata::avatar name="Offline" variant="secondary" />
</x-strata::avatar.group>
```

## Status Indicators

Combine avatars with badge containers for online/offline status dots:

```blade
{{-- Online status --}}
<x-strata::badge.container dot variant="success" position="bottom-right">
    <x-strata::avatar src="/avatar.jpg" size="lg" />
</x-strata::badge.container>

{{-- Away status --}}
<x-strata::badge.container dot variant="warning" position="bottom-right">
    <x-strata::avatar src="/avatar.jpg" size="lg" />
</x-strata::badge.container>

{{-- Offline status --}}
<x-strata::badge.container dot variant="secondary" position="bottom-right">
    <x-strata::avatar src="/avatar.jpg" size="lg" />
</x-strata::badge.container>

{{-- Notification badge --}}
<x-strata::badge.container badge="3" variant="destructive">
    <x-strata::avatar src="/avatar.jpg" size="xl" />
</x-strata::badge.container>
```

## Notes

- **Fallback Hierarchy:** Avatars display content in order: Image → Icon → Initials → Placeholder. The first available option is shown.
- **Initials Generation:** Automatically extracts first letter of first word + first letter of second word from the `name` prop. Always uppercase.
- **Color Support:** Colors only apply to fallback states (icon, initials, placeholder). When `src` is provided, colors are ignored.
- **28 Color Variants:** 6 design system variants (`primary`, `secondary`, `success`, `warning`, `destructive`, `info`) + 22 Tailwind colors (`red`, `orange`, `amber`, `yellow`, `lime`, `green`, `emerald`, `teal`, `cyan`, `sky`, `blue`, `indigo`, `violet`, `purple`, `fuchsia`, `pink`, `rose`, `slate`, `gray`, `zinc`, `neutral`, `stone`)
- **3 Visual Styles:** `filled` (solid background), `outlined` (transparent with border), `soft` (light background with darker text)
- **Group Behavior:** Child avatars inherit size and shape from parent group. Individual avatar colors are independent from group counter badge color.
- **Overlapping Stack:** Groups use negative margin (`-ml-2`) to create overlapping effect. Rings (2px borders) separate overlapping avatars.
- **Overflow Counter:** Automatically calculated via Alpine.js. Hidden when all avatars fit within `max` limit.
- **Accessibility:** Always provide `alt` attribute when using `src` for screen readers.
