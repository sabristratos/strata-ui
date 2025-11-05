# Color Picker

An interactive color selection component with HSL/RGB picker, preset palette, and multiple format support.

## Features

- **Interactive HSL Picker** - Saturation/lightness area with hue slider
- **Color Formats** - Supports HEX and HSL formats with automatic conversion
- **Alpha Channel** - Optional transparency/opacity control
- **Preset Palette** - Tailwind theme colors or custom presets
- **Manual Input** - Type colors directly or adjust HSL components
- **Real-time Preview** - Live color preview in trigger and large preview area
- **Size Variants** - Small, medium, and large sizes
- **Validation States** - Default, success, error, and warning states
- **Livewire Integration** - Full `wire:model` support via Entangleable
- **Clearable** - Optional clear button to reset selection
- **Accessible** - ARIA attributes, keyboard navigation, screen reader support

## Basic Usage

```blade
<x-strata::color-picker
    name="brand_color"
    placeholder="Select brand color"
/>
```

## With Livewire

```blade
<x-strata::color-picker
    wire:model="themeColor"
    placeholder="Choose theme color"
/>
```

## Formats

### HEX Format (Default)

```blade
<x-strata::color-picker
    format="hex"
    value="#3b82f6"
/>
```

Output: `#3b82f6`

### HSL Format

```blade
<x-strata::color-picker
    format="hsl"
    value="hsl(217, 91%, 60%)"
/>
```

Output: `hsl(217, 91%, 60%)`

## Alpha Channel

Enable transparency/opacity control:

```blade
<x-strata::color-picker
    format="hex"
    :allow-alpha="true"
    value="#3b82f6cc"
/>
```

With HSL:

```blade
<x-strata::color-picker
    format="hsl"
    :allow-alpha="true"
    value="hsla(217, 91%, 60%, 0.8)"
/>
```

## Size Variants

```blade
{{-- Small --}}
<x-strata::color-picker size="sm" />

{{-- Medium (default) --}}
<x-strata::color-picker size="md" />

{{-- Large --}}
<x-strata::color-picker size="lg" />
```

## Validation States

```blade
{{-- Default --}}
<x-strata::color-picker state="default" />

{{-- Success --}}
<x-strata::color-picker state="success" />

{{-- Error --}}
<x-strata::color-picker state="error" />

{{-- Warning --}}
<x-strata::color-picker state="warning" />
```

## Custom Presets

Provide custom preset colors:

```blade
<x-strata::color-picker
    :presets="[
        '#ef4444' => 'Red',
        '#f59e0b' => 'Amber',
        '#10b981' => 'Green',
        '#3b82f6' => 'Blue',
        '#8b5cf6' => 'Purple',
        '#ec4899' => 'Pink',
    ]"
/>
```

## Hide Presets

```blade
<x-strata::color-picker :show-presets="false" />
```

## Disabled State

```blade
<x-strata::color-picker
    :disabled="true"
    value="#3b82f6"
/>
```

## Not Clearable

```blade
<x-strata::color-picker
    :clearable="false"
    value="#3b82f6"
/>
```

## Complete Example

```blade
<x-strata::color-picker
    id="theme-color"
    name="theme_color"
    wire:model.live="settings.theme_color"
    format="hex"
    :allow-alpha="true"
    size="md"
    state="default"
    placeholder="Choose your theme color"
    :clearable="true"
    :show-presets="true"
    :presets="[
        '#09090b' => 'Primary',
        '#71717a' => 'Secondary',
        '#3b82f6' => 'Accent',
        '#ef4444' => 'Destructive',
        '#22c55e' => 'Success',
        '#f59e0b' => 'Warning',
    ]"
/>
```

## Livewire Component Example

```php
use Livewire\Component;

class ThemeSettings extends Component
{
    public string $primaryColor = '#3b82f6';
    public string $secondaryColor = '#71717a';

    public function render()
    {
        return view('livewire.theme-settings');
    }
}
```

```blade
<div>
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-2">Primary Color</label>
            <x-strata::color-picker
                wire:model.live="primaryColor"
                format="hex"
                :allow-alpha="true"
            />
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Secondary Color</label>
            <x-strata::color-picker
                wire:model.live="secondaryColor"
                format="hex"
            />
        </div>

        <div class="flex gap-4">
            <div class="h-20 w-20 rounded-lg" :style="{ backgroundColor: '{{ $primaryColor }}' }"></div>
            <div class="h-20 w-20 rounded-lg" :style="{ backgroundColor: '{{ $secondaryColor }}' }"></div>
        </div>
    </div>
</div>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `string` | Auto-generated | Component ID |
| `name` | `string` | `null` | Form input name |
| `format` | `string` | `'hex'` | Color format: `'hex'` or `'hsl'` |
| `value` | `string` | `null` | Initial color value |
| `placeholder` | `string` | `'Select color'` | Placeholder text |
| `state` | `string` | `'default'` | Validation state: `'default'`, `'success'`, `'error'`, `'warning'` |
| `size` | `string` | `'md'` | Size variant: `'sm'`, `'md'`, `'lg'` |
| `disabled` | `boolean` | `false` | Disable the component |
| `clearable` | `boolean` | `true` | Show clear button |
| `allowAlpha` | `boolean` | `false` | Enable alpha/transparency control |
| `showPresets` | `boolean` | `true` | Show preset color palette |
| `presets` | `array` | Tailwind colors | Custom preset colors `['#color' => 'Label']` |

## Accessibility

The color picker component is fully accessible:

- **Keyboard Navigation** - Tab, Enter, Space, Escape
- **ARIA Attributes** - Proper roles and states
- **Screen Reader Support** - Descriptive labels and states
- **Focus Management** - Clear focus indicators
- **Color Labels** - Preset swatches have descriptive labels

### Keyboard Shortcuts

- **Enter/Space** - Open dropdown
- **Escape** - Close dropdown
- **Tab** - Navigate between fields
- **Click + Drag** - Select color in saturation/lightness area
- **Click + Drag** - Adjust hue slider
- **Click + Drag** - Adjust alpha slider (when enabled)

## Color Conversion

The component automatically converts between HEX and HSL formats:

```blade
{{-- HEX format with HSL initial value --}}
<x-strata::color-picker
    format="hex"
    value="hsl(217, 91%, 60%)"
/>
{{-- Output: #3b82f6 --}}

{{-- HSL format with HEX initial value --}}
<x-strata::color-picker
    format="hsl"
    value="#3b82f6"
/>
{{-- Output: hsl(217, 91%, 60%) --}}
```

## Integration with Forms

```blade
<form wire:submit="save">
    <div class="space-y-4">
        <div>
            <label for="bg-color" class="block text-sm font-medium mb-2">
                Background Color
            </label>
            <x-strata::color-picker
                id="bg-color"
                name="background_color"
                wire:model="backgroundColor"
                format="hex"
                :allow-alpha="true"
            />
        </div>

        <div>
            <label for="text-color" class="block text-sm font-medium mb-2">
                Text Color
            </label>
            <x-strata::color-picker
                id="text-color"
                name="text_color"
                wire:model="textColor"
                format="hex"
            />
        </div>

        <button type="submit">Save Colors</button>
    </div>
</form>
```

## Styling

The color picker uses Tailwind CSS v4 and follows Strata UI's design system. All colors are themeable through CSS variables.

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+

## Related Components

- [Input](/docs/input.md) - Basic text input
- [Select](/docs/select.md) - Dropdown selection
- [Dropdown](/docs/dropdown.md) - Generic dropdown
