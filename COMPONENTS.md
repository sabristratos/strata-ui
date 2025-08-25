# Strata UI Components Documentation

This document provides comprehensive documentation for all components in the Strata UI package, including all props, usage examples, and considerations.

## Table of Contents

- [Core UI Components](#core-ui-components)
  - [Alert](#alert)
  - [Avatar](#avatar)
  - [Badge](#badge)
  - [Button](#button)
  - [Card](#card)
- [Form Components](#form-components)
  - [Input](#input)
  - [Textarea](#textarea)
  - [Checkbox](#checkbox)
  - [Radio](#radio)
  - [Toggle](#toggle)
  - [Rating](#rating)
  - [Select](#select)
  - [File Upload](#file-upload)
  - [Form Group](#form-group)
  - [Choice Group](#choice-group)
- [Advanced Components](#advanced-components)
  - [Calendar](#calendar)
  - [Modal](#modal)
  - [Table](#table)
  - [Tabs](#tabs)
  - [Toast Container](#toast-container)
  - [Tooltip](#tooltip)
  - [Dropdown](#dropdown)
  - [Popover](#popover)

---

## Core UI Components

### Alert

Displays contextual feedback messages with icons and optional dismiss functionality.

**Props:**
- `variant` (string, default: `'solid'`): Visual style - `'solid'`, `'outline'`, `'soft'`
- `color` (string, default: `'info'`): Color theme - `'info'`, `'success'`, `'warning'`, `'destructive'`, `'primary'`, `'accent'`
- `size` (string, default: `'md'`): Size - `'sm'`, `'md'`, `'lg'`
- `icon` (string|null, default: `null`): Custom icon name (auto-detected by color if null)
- `dismissible` (bool, default: `false`): Show dismiss button
- `title` (string|null, default: `null`): Alert title

**Slots:**
- `default`: Alert content/message
- `actions`: Action buttons (optional)

**Basic Usage:**
```blade
<x-strata::alert color="success" title="Success!" dismissible>
    Your changes have been saved successfully.
</x-strata::alert>

<x-strata::alert color="destructive" icon="heroicon-o-exclamation-triangle">
    There was an error processing your request.
</x-strata::alert>

<x-strata::alert variant="outline" color="info">
    This is an informational message.
    <x-slot name="actions">
        <x-strata::button variant="ghost" size="sm">Learn More</x-strata::button>
        <x-strata::button variant="outline" size="sm">Dismiss</x-strata::button>
    </x-slot>
</x-strata::alert>
```

**Considerations:**
- Icons are automatically selected based on color (destructive=x-circle, success=check-circle, etc.)
- Dismissible alerts use Alpine.js for smooth hide animations
- Actions slot appears below the main content
- ARIA attributes are automatically applied for accessibility

---

### Avatar

Displays user profile images with fallback options and status indicators.

**Props:**
- `src` (string|null, default: `null`): Image URL
- `alt` (string|null, default: `null`): Alt text for image
- `initials` (string|null, default: `null`): Fallback initials text
- `size` (string, default: `'md'`): Size - `'xs'`, `'sm'`, `'md'`, `'lg'`, `'xl'`, `'2xl'`, `'3xl'`
- `shape` (string, default: `'circle'`): Shape - `'circle'`, `'square'`, `'rounded'`
- `status` (string, default: `'none'`): Status indicator - `'none'`, `'online'`, `'away'`, `'busy'`, `'offline'`
- `statusPosition` (string, default: `'bottom-right'`): Status position - `'top-left'`, `'top-right'`, `'bottom-left'`, `'bottom-right'`
- `border` (bool, default: `false`): Add border ring

**Slots:**
- `default`: Additional content (overlays, badges, etc.)

**Basic Usage:**
```blade
{{-- Image with status --}}
<x-strata::avatar 
    src="/path/to/image.jpg" 
    alt="John Doe" 
    status="online"
    size="lg"
/>

{{-- Initials fallback --}}
<x-strata::avatar 
    initials="JD" 
    size="md" 
    status="away"
/>

{{-- Default icon fallback --}}
<x-strata::avatar size="sm" border />

{{-- Square avatar with overlay --}}
<x-strata::avatar 
    src="/image.jpg" 
    shape="square" 
    size="xl"
>
    <div class="absolute inset-0 bg-black/20 rounded-lg flex items-end p-2">
        <span class="text-white text-xs">Badge</span>
    </div>
</x-strata::avatar>
```

**Considerations:**
- Automatic fallback chain: image → initials → user icon
- Alpine.js handles image load errors gracefully
- Status colors use CSS custom properties for theming
- Supports all Tailwind size options with proper scaling

---

### Badge

Small status and labeling component with multiple visual styles.

**Props:**
- `variant` (string, default: `'solid'`): Visual style - `'solid'`, `'outline'`, `'soft'`
- `color` (string, default: `'primary'`): Color - `'primary'`, `'accent'`, `'success'`, `'warning'`, `'destructive'`, `'info'`
- `size` (string, default: `'md'`): Size - `'sm'`, `'md'`, `'lg'`
- `shape` (string, default: `'pill'`): Shape - `'pill'`, `'rounded'`, `'square'`
- `icon` (string|null, default: `null`): Optional icon name
- `dismissible` (bool, default: `false`): Show dismiss button

**Basic Usage:**
```blade
{{-- Basic badges --}}
<x-strata::badge>Default</x-strata::badge>
<x-strata::badge color="success">Success</x-strata::badge>
<x-strata::badge color="destructive" variant="outline">Error</x-strata::badge>

{{-- With icon --}}
<x-strata::badge color="info" icon="heroicon-o-information-circle">
    Info Badge
</x-strata::badge>

{{-- Dismissible --}}
<x-strata::badge color="warning" dismissible>
    Dismissible Badge
</x-strata::badge>

{{-- Different sizes and shapes --}}
<x-strata::badge size="sm" shape="rounded">Small</x-strata::badge>
<x-strata::badge size="lg" shape="square">Large Square</x-strata::badge>
```

**Considerations:**
- Dismissible badges use Alpine.js for removal animation
- Icon appears before text content
- Color variants provide consistent theming across the design system

---

### Button

Interactive button component with multiple variants and states.

**Props:**
- `variant` (string, default: `'primary'`): Style variant - `'primary'`, `'accent'`, `'destructive'`, `'outline'`, `'secondary'`, `'ghost'`
- `size` (string, default: `'md'`): Size - `'sm'`, `'md'`, `'lg'`
- `type` (string, default: `'button'`): HTML type attribute
- `disabled` (bool, default: `false`): Disabled state
- `loading` (bool, default: `false`): Loading state with spinner
- `icon` (string|null, default: `null`): Icon name
- `iconPosition` (string, default: `'left'`): Icon position - `'left'`, `'right'`

**Basic Usage:**
```blade
{{-- Basic buttons --}}
<x-strata::button>Default Button</x-strata::button>
<x-strata::button variant="accent">Accent Button</x-strata::button>
<x-strata::button variant="destructive">Delete</x-strata::button>

{{-- With icons --}}
<x-strata::button icon="heroicon-o-plus">Add Item</x-strata::button>
<x-strata::button icon="heroicon-o-arrow-right" iconPosition="right">
    Next Step
</x-strata::button>

{{-- States --}}
<x-strata::button disabled>Disabled</x-strata::button>
<x-strata::button loading>Loading...</x-strata::button>

{{-- Sizes --}}
<x-strata::button size="sm">Small</x-strata::button>
<x-strata::button size="lg">Large</x-strata::button>

{{-- As link --}}
<x-strata::button href="/dashboard" variant="outline">
    Go to Dashboard
</x-strata::button>
```

**Considerations:**
- Automatically becomes `<a>` tag when `href` attribute is present
- Loading state shows spinner and maintains button dimensions
- Disabled state prevents all interactions
- Icon-only buttons should include `aria-label` for accessibility

---

### Card

Container component for grouping related content.

**Props:**
- `variant` (string, default: `'default'`): Style variant - `'default'`, `'outlined'`, `'elevated'`
- `padding` (string, default: `'md'`): Padding size - `'none'`, `'sm'`, `'md'`, `'lg'`

**Slots:**
- `default`: Main card content
- `header`: Card header content
- `footer`: Card footer content

**Basic Usage:**
```blade
{{-- Basic card --}}
<x-strata::card>
    <h3>Card Title</h3>
    <p>Card content goes here...</p>
</x-strata::card>

{{-- With header and footer --}}
<x-strata::card>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h3>Settings</h3>
            <x-strata::button size="sm" variant="ghost">Edit</x-strata::button>
        </div>
    </x-slot>
    
    <p>Configure your application settings here.</p>
    
    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-strata::button variant="outline">Cancel</x-strata::button>
            <x-strata::button>Save Changes</x-strata::button>
        </div>
    </x-slot>
</x-strata::card>

{{-- Variants --}}
<x-strata::card variant="outlined">Outlined Card</x-strata::card>
<x-strata::card variant="elevated">Elevated Card</x-strata::card>
```

---

## Form Components

### Input

Text input component with icons, validation, and special features.

**Props:**
- `type` (string, default: `'text'`): Input type - `'text'`, `'email'`, `'password'`, `'number'`, `'url'`, etc.
- `name` (string|null, default: `null`): Form field name
- `icon` (string|null, default: `null`): Icon name for decoration
- `clearable` (bool, default: `false`): Show clear button
- `showPasswordToggle` (bool, default: `false`): Show password visibility toggle (auto-enabled for password type)
- `placeholder` (string|null, default: `null`): Placeholder text
- `value` (mixed, default: `null`): Input value

**Slots:**
- `prefix`: Content before input
- `suffix`: Content after input

**Basic Usage:**
```blade
{{-- Basic inputs --}}
<x-strata::form.input 
    name="email" 
    type="email" 
    placeholder="Enter your email"
    wire:model="email"
/>

<x-strata::form.input 
    name="search" 
    icon="heroicon-o-magnifying-glass" 
    placeholder="Search..."
    clearable
/>

{{-- Password with toggle --}}
<x-strata::form.input 
    name="password" 
    type="password" 
    placeholder="Password"
/>

{{-- With prefix/suffix --}}
<x-strata::form.input name="website" type="url" placeholder="example.com">
    <x-slot name="prefix">https://</x-slot>
    <x-slot name="suffix">.com</x-slot>
</x-strata::form.input>

{{-- Number input --}}
<x-strata::form.input 
    name="price" 
    type="number" 
    min="0" 
    step="0.01"
    placeholder="0.00"
>
    <x-slot name="prefix">$</x-slot>
</x-strata::form.input>
```

**Considerations:**
- Password inputs automatically get password toggle functionality
- Icons, clear button, and prefix/suffix slots are positioned properly
- Full Livewire `wire:model` support
- Validation state styling automatically applied

---

### Rating

Interactive star rating component with customizable icons and clear functionality.

**Props:**
- `name` (string|null, default: `null`): Form field name
- `label` (string|null, default: `null`): Label text
- `description` (string|null, default: `null`): Help text
- `value` (int|float|null, default: `null`): Current rating value
- `max` (int, default: `5`): Maximum rating value
- `readonly` (bool, default: `false`): Read-only mode
- `clearable` (bool, default: `true`): Show clear button
- `size` (string, default: `'md'`): Size - `'sm'`, `'md'`, `'lg'`
- `icon` (string, default: `'heroicon-o-star'`): Icon for rating items
- `id` (string|null, default: `null`): Component ID (auto-generated if null)

**Basic Usage:**
```blade
{{-- Basic rating --}}
<x-strata::form.rating 
    name="rating" 
    label="Rate this product"
    wire:model="rating"
/>

{{-- Custom max and value --}}
<x-strata::form.rating 
    name="satisfaction" 
    label="Satisfaction Level"
    :max="10"
    :value="7"
    description="Rate from 1-10"
/>

{{-- Readonly display --}}
<x-strata::form.rating 
    :value="4.5" 
    :readonly="true"
    label="Average Rating"
    description="Based on 142 reviews"
/>

{{-- Different icon --}}
<x-strata::form.rating 
    name="recommendation" 
    icon="heroicon-o-heart"
    label="Would you recommend?"
    :max="5"
/>

{{-- Sizes --}}
<x-strata::form.rating name="rating_sm" size="sm" label="Small" />
<x-strata::form.rating name="rating_lg" size="lg" label="Large" />
```

**Considerations:**
- Uses dedicated `--rating-star` color variable for theming
- Alpine.js provides interactive hover and click functionality
- Supports decimal ratings for display
- Automatic form integration with hidden inputs
- Full Livewire compatibility with `x-modelable`

---

### File Upload

Advanced file upload component with drag-and-drop, previews, and multiple file support.

**Props:**
- `name` (string|null): Form field name
- `multiple` (bool, default: `false`): Allow multiple files
- `accept` (string|null): File type restrictions (e.g., "image/*")
- `maxSize` (int|null): Maximum file size in KB
- `collection` (string|null): Spatie Media Library collection
- `mediaLibrary` (bool, default: `false`): Use Media Library integration
- `enableReordering` (bool, default: `false`): Allow file reordering
- `showPreview` (bool, default: `true`): Show file previews
- `showProgress` (bool, default: `true`): Show upload progress
- `placeholder` (string|null): Custom placeholder text
- `helpText` (string|null): Help text
- And many more advanced options...

**Basic Usage:**
```blade
{{-- Simple file upload --}}
<x-strata::form.file-upload 
    name="avatar" 
    accept="image/*" 
    placeholder="Drop your profile picture here"
/>

{{-- Multiple files with preview --}}
<x-strata::form.file-upload 
    name="documents" 
    multiple 
    accept=".pdf,.doc,.docx"
    :maxSize="5000"
    helpText="Maximum 5MB per file"
/>

{{-- With Media Library --}}
<x-strata::form.file-upload 
    name="gallery" 
    multiple
    mediaLibrary
    collection="gallery"
    enableReordering
    wire:model="galleryFiles"
/>
```

---

### Toggle

Switch-style toggle component for boolean values.

**Props:**
- `name` (string): Form field name (required)
- `id` (string): Input ID (required)
- `value` (string): Toggle value (required)
- `label` (string): Label text (required)
- `description` (string|null): Help text
- `checked` (bool, default: `false`): Initial checked state
- `disabled` (bool, default: `false`): Disabled state

**Basic Usage:**
```blade
<x-strata::form.toggle 
    name="notifications" 
    id="notifications" 
    value="1"
    label="Email Notifications"
    description="Receive email notifications for updates"
    wire:model="emailNotifications"
/>

<x-strata::form.toggle 
    name="dark_mode" 
    id="dark_mode" 
    value="enabled"
    label="Dark Mode"
    :checked="true"
/>
```

---

## Advanced Components

### Calendar

Comprehensive date picker with range selection and presets.

**Props:**
- `value` (mixed): Current value - can be DateRange object, array, or null
- `range` (bool, default: `true`): Enable range selection
- `multiple` (bool, default: `true`): Enable multi-month view
- `visibleMonths` (int, default: `2`): Number of visible months
- `weekStart` (string, default: `'sunday'`): Week start day
- `minDate` (string|null): Minimum selectable date
- `maxDate` (string|null): Maximum selectable date
- `disabledDates` (array, default: `[]`): Array of disabled dates
- `showClearButton` (bool, default: `false`): Show clear button
- `closeOnSelect` (bool, default: `false`): Close on date selection

**Basic Usage:**
```blade
{{-- Basic date range picker --}}
<x-strata::calendar wire:model="dateRange" />

{{-- Single date picker --}}
<x-strata::calendar 
    :range="false" 
    :multiple="false"
    wire:model="selectedDate"
/>

{{-- With constraints --}}
<x-strata::calendar 
    minDate="2024-01-01"
    maxDate="2024-12-31"
    :disabledDates="['2024-12-25', '2024-12-26']"
    wire:model="availableDates"
/>
```

**Considerations:**
- Uses Carbon for date manipulation
- Supports DateRange value objects for Livewire
- Multi-language support with localization
- Preset date ranges (Today, Yesterday, Last 7 days, etc.)

---

### Modal

Overlay dialog component with multiple variants and positioning options.

**Props:**
- `name` (string|null): Unique modal identifier
- `variant` (string, default: `'default'`): Style - `'default'`, `'flyout'`, `'bare'`
- `size` (string, default: `'md'`): Size - `'sm'`, `'md'`, `'lg'`, `'xl'`, `'2xl'`, `'full'`
- `position` (string, default: `'center'`): Position - `'center'`, `'left'`, `'right'`, `'bottom'`
- `dismissible` (bool, default: `true`): Allow closing modal

**Slots:**
- `default`: Modal content
- `header`: Modal header
- `footer`: Modal footer

**Basic Usage:**
```blade
{{-- Modal trigger --}}
<x-strata::modal.trigger target="example-modal">
    <x-strata::button>Open Modal</x-strata::button>
</x-strata::modal.trigger>

{{-- Modal definition --}}
<x-strata::modal name="example-modal" size="lg">
    <x-slot name="header">
        <h2>Modal Title</h2>
    </x-slot>
    
    <p>Modal content goes here...</p>
    
    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-strata::modal.close>
                <x-strata::button variant="outline">Cancel</x-strata::button>
            </x-strata::modal.close>
            <x-strata::button>Confirm</x-strata::button>
        </div>
    </x-slot>
</x-strata::modal>

{{-- Flyout modal --}}
<x-strata::modal name="settings" variant="flyout" position="right">
    <h2>Settings Panel</h2>
    <!-- Settings content -->
</x-strata::modal>
```

**Considerations:**
- Uses Alpine.js for show/hide functionality
- Named modals prevent conflicts
- Flyout variant slides in from edges
- Automatic focus management and backdrop clicks

---

### Table

Structured data display with sorting, loading states, and responsive design.

**Props:**
- `striped` (bool, default: `false`): Alternate row styling
- `loading` (bool, default: `false`): Show loading state
- `size` (string, default: `'md'`): Table size - `'sm'`, `'md'`, `'lg'`
- `sticky` (bool, default: `false`): Sticky header

**Sub-components:**
- `table.header`: Table header row
- `table.body`: Table body container
- `table.footer`: Table footer
- `table.row`: Table row (with `clickable` prop)
- `table.cell`: Table cell
- `table.vertical`: Vertical layout for mobile
- `table.vertical-row`: Vertical row component

**Basic Usage:**
```blade
<x-strata::table striped>
    <x-strata::table.header>
        <x-strata::table.cell>Name</x-strata::table.cell>
        <x-strata::table.cell>Email</x-strata::table.cell>
        <x-strata::table.cell>Role</x-strata::table.cell>
        <x-strata::table.cell>Actions</x-strata::table.cell>
    </x-strata::table.header>
    
    <x-strata::table.body>
        @foreach($users as $user)
            <x-strata::table.row clickable wire:click="viewUser({{ $user->id }})">
                <x-strata::table.cell>{{ $user->name }}</x-strata::table.cell>
                <x-strata::table.cell>{{ $user->email }}</x-strata::table.cell>
                <x-strata::table.cell>
                    <x-strata::badge>{{ $user->role }}</x-strata::badge>
                </x-strata::table.cell>
                <x-strata::table.cell>
                    <x-strata::button size="sm" variant="ghost">Edit</x-strata::button>
                </x-strata::table.cell>
            </x-strata::table.row>
        @endforeach
    </x-strata::table.body>
</x-strata::table>
```

**Considerations:**
- Clickable rows show hover effects and pointer cursor
- Loading state overlays the entire table
- Responsive design with vertical layout option
- Sticky headers remain visible during scroll

---

## Usage Patterns

### Form Integration

All form components support both traditional form submission and Livewire:

```blade
{{-- Traditional Form --}}
<form method="POST" action="/submit">
    @csrf
    <x-strata::form.input name="email" type="email" />
    <x-strata::form.rating name="rating" />
    <x-strata::button type="submit">Submit</x-strata::button>
</form>

{{-- Livewire Integration --}}
<div>
    <x-strata::form.input wire:model="email" />
    <x-strata::form.rating wire:model="rating" />
    <x-strata::button wire:click="save">Save</x-strata::button>
</div>
```

### Theming and Customization

Components use CSS custom properties for consistent theming:

```css
:root {
    --primary: oklch(0.6104 0.0767 299.7335);
    --rating-star: oklch(0.7540 0.0982 76.8292);
    /* Customize other variables */
}
```

### Alpine.js Integration

Components use Alpine.js for interactivity and follow consistent patterns:

```blade
{{-- Components expose their Alpine data --}}
<x-strata::form.rating 
    x-data="strataRating({...})"
    x-on:change="handleRatingChange"
/>
```

This documentation covers all major components with their complete prop APIs, usage examples, and important considerations for implementation.