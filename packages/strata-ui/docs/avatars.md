# Avatars

Flexible avatar components for user profiles, team members, and visual identifiers with automatic fallback handling.

## Basic Usage

```blade
{{-- Image avatar --}}
<x-strata::avatar src="path/to/avatar.jpg" alt="John Doe" />

{{-- Initials fallback --}}
<x-strata::avatar name="John Doe" />

{{-- Icon avatar --}}
<x-strata::avatar icon="user" />
```

## Sizes

Available sizes: `xs`, `sm`, `md` (default), `lg`, `xl`, `2xl`

```blade
<x-strata::avatar size="xs" src="avatar.jpg" alt="User" />
<x-strata::avatar size="sm" src="avatar.jpg" alt="User" />
<x-strata::avatar size="md" src="avatar.jpg" alt="User" />
<x-strata::avatar size="lg" src="avatar.jpg" alt="User" />
<x-strata::avatar size="xl" src="avatar.jpg" alt="User" />
<x-strata::avatar size="2xl" src="avatar.jpg" alt="User" />
```

## Shapes

Available shapes: `circle` (default), `square`, `rounded`

```blade
<x-strata::avatar shape="circle" name="Circle User" />
<x-strata::avatar shape="rounded" name="Rounded User" />
<x-strata::avatar shape="square" name="Square User" />
```

## Fallback Priority

Avatars automatically fall back through these options in order:

1. **Image** (if `src` provided)
2. **Icon** (if `icon` provided)
3. **Initials** (if `name` provided - extracts first letters)
4. **Placeholder** (default user icon)

```blade
{{-- Will show image --}}
<x-strata::avatar src="avatar.jpg" name="John Doe" icon="star" />

{{-- Will show star icon (no src) --}}
<x-strata::avatar name="John Doe" icon="star" />

{{-- Will show "JD" initials (no src or icon) --}}
<x-strata::avatar name="John Doe" />

{{-- Will show user icon placeholder (nothing provided) --}}
<x-strata::avatar />
```

## Image Avatars

Use the `src` prop for image-based avatars:

```blade
<x-strata::avatar
    src="https://example.com/avatar.jpg"
    alt="John Doe"
    size="lg"
/>
```

Images automatically fill the avatar container with proper object-fit handling.

## Initials Avatars

Provide a `name` prop to automatically generate initials:

```blade
<x-strata::avatar name="John Doe" />        {{-- Shows "JD" --}}
<x-strata::avatar name="Sarah Smith" />     {{-- Shows "SS" --}}
<x-strata::avatar name="Mike" />            {{-- Shows "M" --}}
```

The component extracts the first letter of the first two words.

## Icon Avatars

Use any icon from the icon set:

```blade
<x-strata::avatar icon="user" />
<x-strata::avatar icon="heart" size="lg" />
<x-strata::avatar icon="star" size="xl" />
```

Icons automatically scale to fit the avatar size.

## With Status Indicators

Combine with badge containers for status indicators:

```blade
{{-- Online status --}}
<x-strata::badge.container dot variant="success" position="bottom-right">
    <x-strata::avatar src="avatar.jpg" alt="Online user" />
</x-strata::badge.container>

{{-- Away status --}}
<x-strata::badge.container dot variant="warning" position="bottom-right">
    <x-strata::avatar src="avatar.jpg" alt="Away user" />
</x-strata::badge.container>

{{-- Offline status --}}
<x-strata::badge.container dot variant="destructive" position="bottom-right">
    <x-strata::avatar src="avatar.jpg" alt="Offline user" />
</x-strata::badge.container>
```

## Avatar Groups

Display multiple avatars in an overlapping stack with overflow indicator:

```blade
<x-strata::avatar.group max="3">
    <x-strata::avatar src="user1.jpg" alt="User 1" size="md" />
    <x-strata::avatar src="user2.jpg" alt="User 2" size="md" />
    <x-strata::avatar src="user3.jpg" alt="User 3" size="md" />
    <x-strata::avatar src="user4.jpg" alt="User 4" size="md" />
    <x-strata::avatar src="user5.jpg" alt="User 5" size="md" />
</x-strata::avatar.group>
```

This will show the first 3 avatars plus a "+2" indicator for the remaining avatars.

### Group Props

```blade
<x-strata::avatar.group max="4" size="lg">
    {{-- Avatars here --}}
</x-strata::avatar.group>
```

The `size` prop ensures consistent sizing across all avatars in the group.

## Props Reference

### Avatar

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `src` | string | `null` | Image source URL |
| `alt` | string | `null` | Image alt text |
| `name` | string | `null` | Name for generating initials |
| `icon` | string | `null` | Icon name from icon set |
| `size` | string | `md` | Avatar size (`xs`, `sm`, `md`, `lg`, `xl`, `2xl`) |
| `shape` | string | `circle` | Avatar shape (`circle`, `square`, `rounded`) |

### Avatar Group

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `max` | number | `3` | Maximum avatars to display before showing +N |
| `size` | string | `md` | Size for all avatars in group |
| `shape` | string | `circle` | Shape for all avatars and overflow indicator |

## Examples

### User Profile

```blade
<div class="flex items-center gap-3">
    <x-strata::avatar src="{{ $user->avatar }}" alt="{{ $user->name }}" size="lg" />
    <div>
        <div class="font-medium">{{ $user->name }}</div>
        <div class="text-sm text-muted-foreground">{{ $user->email }}</div>
    </div>
</div>
```

### Team Members

```blade
<x-strata::avatar.group max="5" size="md">
    @foreach($team->members as $member)
        <x-strata::avatar
            src="{{ $member->avatar }}"
            alt="{{ $member->name }}"
            size="md"
        />
    @endforeach
</x-strata::avatar.group>
```

### Comment Author

```blade
<div class="flex gap-3">
    <x-strata::avatar name="{{ $comment->author->name }}" size="sm" />
    <div class="flex-1">
        <div class="font-medium text-sm">{{ $comment->author->name }}</div>
        <p class="text-sm">{{ $comment->body }}</p>
    </div>
</div>
```

### User Menu

```blade
<button class="flex items-center gap-2">
    <x-strata::badge.container dot variant="success" position="bottom-right">
        <x-strata::avatar src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" />
    </x-strata::badge.container>
    <span>{{ auth()->user()->name }}</span>
</button>
```
