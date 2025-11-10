# Date Picker

Date picker component with dropdown calendar, chips display for multiple selections, and seamless Livewire integration. Built on the calendar component with trigger and popover management.

## Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `mode` | string | `single` | `single`, `range`, `multiple`, `week` | Selection mode |
| `value` | mixed | `null` | String, array, or DateValue | Initial selected date(s) |
| `minDate` | string | `null` | ISO date string | Earliest selectable date |
| `maxDate` | string | `null` | ISO date string | Latest selectable date |
| `showPresets` | boolean | `false` | `true`, `false` | Show quick select presets |
| `placeholder` | string | Auto | Any string | Placeholder text when empty |
| `state` | string | `default` | `default`, `success`, `error`, `warning` | Validation state |
| `size` | string | `md` | `sm`, `md`, `lg` | Component size |
| `disabled` | boolean | `false` | `true`, `false` | Disable the picker |
| `clearable` | boolean | `true` | `true`, `false` | Show clear button when value exists |
| `chips` | boolean | `false` | `true`, `false` | Display selected dates as chips (multiple mode) |
| `placement` | string | `bottom-start` | See placement options | Dropdown position |
| `offset` | int | `8` | Any number | Distance from trigger (px) |
| `name` | string | `null` | Any string | Form input name |
| `id` | string | Auto-generated | Any string | Component ID |

## Placement Options

`top-start`, `top-end`, `bottom-start`, `bottom-end`, `right-start`, `right-end`, `left-start`, `left-end`

## Examples

### Basic Usage

```blade
{{-- Single date picker --}}
<x-strata::date-picker
    wire:model="birthDate"
    placeholder="Select your birth date"
/>

{{-- Date range picker --}}
<x-strata::date-picker
    mode="range"
    wire:model="vacationDates"
    placeholder="Select vacation dates"
/>

{{-- Multiple dates with chips --}}
<x-strata::date-picker
    mode="multiple"
    wire:model="availableDates"
    :chips="true"
    placeholder="Select available dates"
/>
```

### With Validation

```blade
<x-strata::date-picker
    wire:model="appointmentDate"
    :state="$errors->has('appointmentDate') ? 'error' : 'default'"
    placeholder="Select appointment date"
    minDate="2025-01-01"
    maxDate="2025-12-31"
/>
```

### With Presets

```blade
{{-- Quick date selection with presets --}}
<x-strata::date-picker
    mode="range"
    wire:model="reportRange"
    :showPresets="true"
    placeholder="Select reporting period"
/>
```

### Form Field Composition

```blade
<x-strata::field>
    <x-strata::field.label for="start-date" required>
        Project Start Date
    </x-strata::field.label>

    <x-strata::date-picker
        id="start-date"
        wire:model="projectStart"
        minDate="{{ now()->toDateString() }}"
        :state="$errors->has('projectStart') ? 'error' : 'default'"
    />

    <x-strata::field.hint>
        Project must start in the future
    </x-strata::field.hint>

    @error('projectStart')
        <x-strata::field.error>{{ $message }}</x-strata::field.error>
    @enderror
</x-strata::field>
```

### Clearable Control

```blade
{{-- Clearable (default) --}}
<x-strata::date-picker
    wire:model="optionalDate"
    :clearable="true"
/>

{{-- Not clearable --}}
<x-strata::date-picker
    wire:model="requiredDate"
    :clearable="false"
/>
```

### Different Sizes

```blade
<x-strata::date-picker size="sm" wire:model="date" />
<x-strata::date-picker size="md" wire:model="date" />
<x-strata::date-picker size="lg" wire:model="date" />
```

### Placement Options

```blade
{{-- Open above trigger --}}
<x-strata::date-picker
    placement="top-start"
    wire:model="date"
/>

{{-- Open to the right --}}
<x-strata::date-picker
    placement="right-start"
    wire:model="date"
/>

{{-- Custom offset --}}
<x-strata::date-picker
    placement="bottom-start"
    :offset="16"
    wire:model="date"
/>
```

## Livewire Integration

### Basic Wire Model

```blade
<x-strata::date-picker wire:model="selectedDate" />
```

### With Live Updates

```blade
<x-strata::date-picker wire:model.live="filterDate" />
```

### DateValue Data Objects

Use Strata UI data objects for type safety and additional features:

```php
use Stratos\StrataUI\Data\DateValue;
use Stratos\StrataUI\Data\DateRange;

class BookingForm extends Component
{
    public DateValue $checkIn;
    public DateValue $checkOut;

    // Or for ranges
    public DateRange $stayDates;

    public function mount()
    {
        $this->checkIn = DateValue::from('2025-03-15');

        $this->stayDates = new DateRange(
            start: DateValue::from('2025-03-15'),
            end: DateValue::from('2025-03-20')
        );
    }
}
```

```blade
<x-strata::date-picker wire:model="checkIn" />
<x-strata::date-picker mode="range" wire:model="stayDates" />
```

### Dependent Date Pickers

Set min/max dates based on other picker values:

```blade
<x-strata::date-picker
    wire:model.live="startDate"
    placeholder="Start date"
/>

<x-strata::date-picker
    wire:model="endDate"
    :minDate="$startDate"
    :disabled="!$startDate"
    placeholder="{{ $startDate ? 'End date' : 'Select start date first' }}"
/>
```

### Validation Example

```php
use Stratos\StrataUI\Data\DateValue;

class AppointmentForm extends Component
{
    public DateValue $appointmentDate;

    public function rules()
    {
        return [
            'appointmentDate' => ['required', 'after:today'],
        ];
    }

    public function submit()
    {
        $this->validate();

        // DateValue provides helpful methods
        $date = $this->appointmentDate->toCarbon();
        $formatted = $this->appointmentDate->format('F j, Y');
    }
}
```

## Display Modes

### Single Date Display
Shows formatted date string in trigger button.

### Range Display
Shows "Start date - End date" or uses chips if enabled.

### Multiple Dates Display
Without chips: Shows "X dates selected"
With chips: Displays each date as a removable chip

### Chips Mode
Enable with `chips` prop for visual date display:

```blade
<x-strata::date-picker
    mode="multiple"
    wire:model="dates"
    :chips="true"
/>
```

Chips features:
- Each date shown as individual chip
- Remove button on each chip
- Wraps to multiple lines
- Min-height maintains button size

## Interaction

### Opening Dropdown
- Click trigger button
- Press `Enter` or `Space` when focused

### Selecting Dates
- Click dates in calendar
- Use keyboard navigation (see Calendar docs)
- Click preset buttons (if enabled)

### Clearing Selection
- Click clear button (× icon) when `clearable=true`
- Only appears when a value is selected

### Closing Dropdown
- Click outside dropdown
- Press `Escape`
- Select date (in single mode)

## Notes

- **Popover API:** Uses native popover API for top-layer positioning
- **CSS Anchor Positioning:** Dropdown positioned relative to trigger without JavaScript
- **Entangleable:** Bidirectional sync between Alpine and Livewire state
- **Focus management:** Returns focus to trigger after selection
- **Validation states:** Automatic styling for success/error/warning states
- **Chips wrapping:** Trigger expands vertically when chips wrap
- **Date format:** Displays dates using locale-aware formatting
- **Hidden input:** Form submission handled via hidden input element
- **Smooth animations:** 150ms transitions for opening/closing
- **Accessibility:** Full ARIA attributes and keyboard navigation support
- **Responsive:** Works across different screen sizes with smart placement
- **Calendar inheritance:** Inherits all calendar props (locale, weekStartsOn, etc.)
