# Date Picker

A beautiful and flexible date picker component with support for single date selection, date ranges, and quick presets. Built with Livewire integration and morphing-resistant state management.

## Features

- **Single & Range Modes** - Pick a single date or a date range
- **Quick Presets** - Shortcuts like "Today", "This Week", "Last 30 Days"
- **Min/Max Constraints** - Limit selectable dates
- **Value Objects** - First-class support for DateValue and DateRange
- **Livewire Integration** - Seamless `wire:model` support
- **Morphing Resistant** - Handles Livewire morphing without state loss
- **Keyboard Navigation** - Full keyboard accessibility
- **Responsive** - Adapts to mobile and desktop screens

## Basic Usage

### Single Date Selection

```blade
<x-strata::date-picker
    wire:model.live="appointmentDate"
    placeholder="Select appointment date"
/>
```

### Date Range Selection

```blade
<x-strata::date-picker
    wire:model.live="dateRange"
    mode="range"
    placeholder="Select date range"
/>
```

## Value Objects

The date picker works seamlessly with Strata UI's value objects:

### DateValue (Single Mode)

```php
use StrataUI\Data\DateValue;

class AppointmentForm extends Component
{
    public ?DateValue $appointmentDate = null;

    public function mount(): void
    {
        $this->appointmentDate = DateValue::today();
    }

    public function render(): View
    {
        return view('livewire.appointment-form');
    }
}
```

```blade
<x-strata::date-picker
    wire:model.live="appointmentDate"
    :value="$appointmentDate"
/>

@if ($appointmentDate)
    <p>Selected: {{ $appointmentDate->format('F j, Y') }}</p>
    <p>Is future: {{ $appointmentDate->isFuture() ? 'Yes' : 'No' }}</p>
@endif
```

### DateRange (Range Mode)

```php
use StrataUI\Data\DateRange;

class ReportFilter extends Component
{
    public ?DateRange $dateRange = null;

    public function mount(): void
    {
        $this->dateRange = DateRange::last30Days();
    }

    public function render(): View
    {
        return view('livewire.report-filter');
    }
}
```

```blade
<x-strata::date-picker
    wire:model.live="dateRange"
    :value="$dateRange"
    mode="range"
    :show-presets="true"
/>

@if ($dateRange)
    <p>From: {{ $dateRange->start->format('M j, Y') }}</p>
    <p>To: {{ $dateRange->end->format('M j, Y') }}</p>
    <p>Days: {{ $dateRange->start->diffInDays($dateRange->end) }}</p>
@endif
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `mode` | `'single'\|'range'` | `'single'` | Selection mode |
| `value` | `DateValue\|DateRange\|string\|array\|null` | `null` | Current value |
| `minDate` | `string\|null` | `null` | Minimum selectable date (YYYY-MM-DD) |
| `maxDate` | `string\|null` | `null` | Maximum selectable date (YYYY-MM-DD) |
| `showPresets` | `boolean` | `false` | Show quick preset shortcuts |
| `placeholder` | `string` | `'Select date'` or `'Select date range'` | Placeholder text |
| `state` | `'default'\|'success'\|'error'\|'warning'` | `'default'` | Visual state |
| `size` | `'sm'\|'md'\|'lg'` | `'md'` | Component size |
| `disabled` | `boolean` | `false` | Disable interaction |
| `clearable` | `boolean` | `true` | Show clear button |
| `id` | `string\|null` | Auto-generated | HTML ID attribute |
| `name` | `string\|null` | `null` | Form input name |

## Examples

### With Min/Max Constraints

Limit date selection to future dates only:

```blade
<x-strata::date-picker
    wire:model.live="appointmentDate"
    :min-date="date('Y-m-d')"
    placeholder="Select future date"
/>
```

Limit to a specific range:

```blade
<x-strata::date-picker
    wire:model.live="eventDate"
    min-date="2024-01-01"
    max-date="2024-12-31"
    placeholder="Select date in 2024"
/>
```

### With Quick Presets

**Single Mode Presets:**
- Today
- Tomorrow
- Next Week
- Next Month

```blade
<x-strata::date-picker
    wire:model.live="date"
    :show-presets="true"
/>
```

**Range Mode Presets:**
- Today
- Yesterday
- This Week
- Last Week
- Last 7 Days
- Last 30 Days
- This Month
- Last Month
- This Year

```blade
<x-strata::date-picker
    wire:model.live="dateRange"
    mode="range"
    :show-presets="true"
/>
```

### Validation States

Show validation feedback:

```blade
<x-strata::date-picker
    wire:model.live="appointmentDate"
    :state="$errors->has('appointmentDate') ? 'error' : 'default'"
/>

@error('appointmentDate')
    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
@enderror
```

### Sizes

```blade
{{-- Small --}}
<x-strata::date-picker
    wire:model="date"
    size="sm"
/>

{{-- Medium (default) --}}
<x-strata::date-picker
    wire:model="date"
    size="md"
/>

{{-- Large --}}
<x-strata::date-picker
    wire:model="date"
    size="lg"
/>
```

### Non-clearable

```blade
<x-strata::date-picker
    wire:model="date"
    :clearable="false"
/>
```

## Real-World Examples

### Appointment Booking

```php
use StrataUI\Data\DateValue;

class AppointmentBooking extends Component
{
    public ?DateValue $appointmentDate = null;

    public function rules(): array
    {
        return [
            'appointmentDate' => ['required', 'after:today'],
        ];
    }

    public function book(): void
    {
        $this->validate();

        // Create appointment...

        $this->redirect('/appointments');
    }
}
```

```blade
<form wire:submit="book">
    <x-strata::date-picker
        wire:model.live="appointmentDate"
        :value="$appointmentDate"
        :min-date="date('Y-m-d')"
        :show-presets="true"
        placeholder="Select appointment date"
        :state="$errors->has('appointmentDate') ? 'error' : 'default'"
    />

    @error('appointmentDate')
        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
    @enderror

    <button type="submit">Book Appointment</button>
</form>
```

### Report Date Range Filter

```php
use StrataUI\Data\DateRange;

class SalesReport extends Component
{
    public ?DateRange $dateRange = null;

    public function mount(): void
    {
        $this->dateRange = DateRange::thisMonth();
    }

    public function render(): View
    {
        $sales = Sale::query()
            ->whereBetween('created_at', $this->dateRange)
            ->get();

        return view('livewire.sales-report', [
            'sales' => $sales,
        ]);
    }
}
```

```blade
<div>
    <x-strata::date-picker
        wire:model.live="dateRange"
        :value="$dateRange"
        mode="range"
        :show-presets="true"
        placeholder="Select date range"
    />

    <div class="mt-4">
        <h3>Sales Report</h3>
        <p>{{ $dateRange->start->format('M j, Y') }} - {{ $dateRange->end->format('M j, Y') }}</p>

        @foreach ($sales as $sale)
            {{-- Sale details --}}
        @endforeach
    </div>
</div>
```

## Morphing & Reactivity

The date picker is built with Livewire morphing in mind and uses Strata UI's **Entangleable** pattern for morphing-resistant state synchronization.

### Switching Between Modes

You can safely switch between single and range modes without losing state:

```blade
<x-strata::radio-group wire:model.live="mode">
    <x-strata::radio value="single">Single Date</x-strata::radio>
    <x-strata::radio value="range">Date Range</x-strata::radio>
</x-strata::radio-group>

<x-strata::date-picker
    wire:model.live="selectedDate"
    :mode="$mode"
    :show-presets="true"
/>
```

The component will:
1. Re-detect the `wire:model` attribute after each morph
2. Preserve the dropdown state correctly
3. Handle value type changes (DateValue ↔ DateRange)

## Accessibility

The date picker follows WAI-ARIA best practices:

- **Keyboard Navigation** - Full keyboard support for date selection
- **ARIA Attributes** - Proper `role`, `aria-expanded`, `aria-modal` attributes
- **Focus Management** - Logical focus flow and tab order
- **Screen Readers** - All interactive elements are properly labeled

### Keyboard Shortcuts

- `Enter` / `Space` - Open date picker
- `Escape` - Close date picker
- `Arrow Keys` - Navigate calendar dates
- `Tab` / `Shift+Tab` - Navigate between elements

## Technical Details

### State Management

The date picker uses two core modules:

1. **Entangleable** - Bidirectional Alpine ↔ Livewire sync
   - Re-detects `wire:model` on every sync (morphing solution)
   - Deep equality comparison
   - Watcher support for reactive UI

2. **Positionable** - Floating UI integration
   - Smart positioning with flip/shift middleware
   - Automatic ancestor/sibling conflict resolution
   - Mobile-responsive (disabled < 640px)

### Data Flow

```
User clicks date
    ↓
Calendar emits @date-selected event
    ↓
date-picker.js handleDateSelected()
    ↓
Entangleable.set(newValue)
    ↓
Entangleable syncs to Livewire (re-detects wire:model)
    ↓
Livewire updates component property
    ↓
Livewire morphs DOM
    ↓
Entangleable watcher updates display value
```

### Hidden Input Pattern

The component uses a hidden input with both `class="hidden"` and the `hidden` attribute:

```blade
<div class="hidden" hidden>
    <input wire:model="property" data-strata-datepicker-input />
</div>
```

This signals to Livewire's morphing algorithm to treat the element as stable, preventing morphing conflicts.

## Related Components

- [Calendar](./calendar.md) - Lower-level calendar component used internally
- [Time Picker](./time-picker.md) - Time selection component
- [Value Objects](./value-objects.md) - DateValue, TimeValue, DateRange

## Learn More

- [Livewire Morphing Strategies](./livewire-morphing-strategies.md)
- [Value Objects Guide](./value-objects.md)
