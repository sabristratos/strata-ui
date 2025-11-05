# Buttons

Versatile button components with multiple variants, appearances, sizes, and built-in loading states. Supports icons via props and seamless Livewire integration.

## Button Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `variant` | string | `primary` | `primary`, `secondary`, `success`, `warning`, `destructive`, `info` | Color variant |
| `appearance` | string | `filled` | `filled`, `outlined`, `ghost`, `link` | Visual style |
| `size` | string | `md` | `sm`, `md`, `lg` | Button size |
| `icon` | string | `null` | Any icon name | Leading icon (passed via prop, not slot) |
| `icon-trailing` | string | `null` | Any icon name | Trailing icon (passed via prop, not slot) |
| `loading` | boolean | `false` | `true`, `false` | Show spinner and disable interaction |
| `disabled` | boolean | `false` | `true`, `false` | Disable button |
| `type` | string | `button` | `button`, `submit`, `reset` | HTML button type attribute |

## Icon Button Props

Use `<x-strata::button.icon>` for icon-only buttons.

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `icon` | string | - | Any icon name | Icon to display (required) |
| `variant` | string | `secondary` | `primary`, `secondary`, `success`, `warning`, `destructive`, `info` | Color variant |
| `appearance` | string | `filled` | `filled`, `outlined`, `ghost`, `link` | Visual style |
| `size` | string | `md` | `sm`, `md`, `lg` | Button size |
| `loading` | boolean | `false` | `true`, `false` | Show spinner and disable interaction |
| `disabled` | boolean | `false` | `true`, `false` | Disable button |
| `type` | string | `button` | `button`, `submit`, `reset` | HTML button type attribute |

**Important:** Icon buttons require `aria-label` attribute for accessibility.

## Example

```blade
{{-- Button with multiple props --}}
<x-strata::button
    variant="primary"
    appearance="filled"
    size="lg"
    icon="rocket"
    icon-trailing="arrow-right"
    type="submit"
    :loading="$isSubmitting"
    :disabled="!$canSubmit"
>
    Launch Campaign
</x-strata::button>

{{-- Icon button with multiple props --}}
<x-strata::button.icon
    icon="settings"
    variant="secondary"
    appearance="outlined"
    size="md"
    :loading="$isProcessing"
    aria-label="Settings"
/>
```

## Livewire Integration

Use `wire:loading` directive to automatically show loading states during Livewire actions:

```blade
<x-strata::button
    wire:click="processPayment"
    wire:loading.attr="disabled"
    variant="success"
    icon="credit-card"
>
    <span wire:loading.remove>Process Payment</span>
    <span wire:loading>Processing...</span>
</x-strata::button>
```

## Button Groups

Use `<x-strata::group>` to group related buttons together:

```blade
{{-- Horizontal group (default) --}}
<x-strata::group>
    <x-strata::button appearance="outlined">Day</x-strata::button>
    <x-strata::button appearance="outlined">Week</x-strata::button>
    <x-strata::button appearance="outlined">Month</x-strata::button>
</x-strata::group>

{{-- Vertical group --}}
<x-strata::group orientation="vertical">
    <x-strata::button variant="success" icon="check">Approve</x-strata::button>
    <x-strata::button variant="destructive" icon="x">Reject</x-strata::button>
    <x-strata::button variant="secondary" appearance="outlined">Skip</x-strata::button>
</x-strata::group>
```

## Notes

- **Icons are props:** Pass icons via `icon` and `icon-trailing` props, never inside the button slot
- **Icon buttons need aria-label:** Always provide `aria-label` for accessibility
- **Loading state:** Use `:loading` prop or `wire:loading` directive for automatic Livewire integration
- **3D styling:** Filled appearance includes inset shadow for realistic depth
- **Focus states:** All buttons have visible focus rings for keyboard navigation
- **Responsive:** Icons automatically scale with button size
