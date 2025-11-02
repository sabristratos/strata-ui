# Calendar

A flexible, dependency-free calendar component for date selection with multiple modes, keyboard navigation, and full Livewire integration.

## Features

- **Multiple Selection Modes**: Single date, multiple dates, date range, and week selection
- **Keyboard Navigation**: Full arrow key support with Enter to select
- **Multiple Month View**: Display 1-3 months side by side
- **Date Constraints**: Min/max dates and disabled dates
- **Preset Ranges**: Quick selection buttons for common date ranges
- **Popup Mode**: Use as a dropdown date picker with input field
- **Inline Mode**: Display calendar directly on the page
- **Livewire Integration**: Full `wire:model` support
- **Customizable**: Multiple variants, sizes, and theming options
- **Accessible**: ARIA labels, keyboard navigation, focus management
- **Dark Mode**: Automatic dark mode support

## Basic Usage

### Inline Calendar

```blade
<x-strata::calendar
    mode="single"
    wire:model.live="selectedDate"
/>
```

### Date Input with Popup

```blade
<x-strata::date-picker
    mode="single"
    wire:model.live="selectedDate"
    placeholder="Select a date..."
/>
```

## Selection Modes

### Single Date

Select one date at a time.

```blade
<x-strata::calendar
    mode="single"
    wire:model.live="singleDate"
/>
```

### Multiple Dates

Select multiple individual dates.

```blade
<x-strata::calendar
    mode="multiple"
    wire:model.live="multipleDates"
/>
```

### Date Range

Select a start and end date.

```blade
<x-strata::calendar
    mode="range"
    wire:model.live="dateRange"
/>
```

### Week Selection

Select entire weeks at once.

```blade
<x-strata::calendar
    mode="week"
    wire:model.live="weekDates"
    :week-starts-on="1"
/>
```

## Multiple Month View

Display 2 or 3 months side by side for easier range selection.

```blade
<x-strata::calendar
    mode="range"
    wire:model.live="dateRange"
    :months-to-show="2"
/>
```

## Date Constraints

### Min and Max Dates

Restrict selectable dates to a specific range.

```blade
<x-strata::calendar
    mode="single"
    wire:model.live="selectedDate"
    :min-date="now()->format('Y-m-d')"
    :max-date="now()->addDays(30)->format('Y-m-d')"
/>
```

### Disabled Dates

Disable specific dates.

```blade
<x-strata::calendar
    mode="single"
    wire:model.live="selectedDate"
    :disabled-dates="[
        '2025-01-01',
        '2025-12-25',
    ]"
/>
```

## Preset Date Ranges

Add quick selection buttons for common date ranges. The available presets change based on the selected mode.

```blade
<x-strata::calendar
    mode="range"
    wire:model.live="dateRange"
    show-presets
/>
```

**Presets for single/multiple modes:**
- Today
- Yesterday
- This week
- This month

**Presets for range mode:**
- Last 7 days
- Last 30 days
- This month
- Last month
- This quarter
- This year

## Date Input Component

The `date-picker` component provides a text input with a popup calendar.

```blade
<x-strata::date-picker
    mode="single"
    wire:model.live="selectedDate"
    placeholder="Select a date..."
/>
```

### Range Input with Presets

```blade
<x-strata::date-picker
    mode="range"
    wire:model.live="dateRange"
    placeholder="Select date range..."
    show-presets
    :months-to-show="2"
/>
```

### Clearable Input

```blade
<x-strata::date-picker
    mode="single"
    wire:model.live="selectedDate"
    :clearable="true"
/>
```

## Quick Month/Year Navigation

The calendar header includes a calendar icon button that opens a month/year picker for quick navigation. This allows users to jump to any month and year without clicking through multiple months.

### Features

- **Year Selector**: Dropdown with years from 100 years ago to 10 years in the future
- **Month Grid**: 3×4 grid of month buttons for quick selection
- **Instant Navigation**: Calendar updates immediately when a month is selected

### Usage

The month/year picker appears automatically in the calendar header. Simply click the calendar icon next to the month name to open it.

```blade
<x-strata::calendar
    mode="single"
    wire:model.live="selectedDate"
/>
```

The picker is positioned as a popover below the button and closes automatically when:
- A month is selected
- User clicks outside the picker
- User navigates away

## Variants

### Default

```blade
<x-strata::calendar variant="default" />
```

### Bordered

```blade
<x-strata::calendar variant="bordered" />
```

### Card

```blade
<x-strata::calendar variant="card" />
```

### Minimal

No borders or padding. Used internally by `date-picker` for embedded calendars.

```blade
<x-strata::calendar variant="minimal" />
```

## Sizes

```blade
<x-strata::calendar size="sm" />
<x-strata::calendar size="md" />
<x-strata::calendar size="lg" />
```

## Week Configuration

Change which day the week starts on (0 = Sunday, 1 = Monday).

```blade
<x-strata::calendar
    :week-starts-on="1"
/>
```

## Keyboard Navigation

The calendar supports full keyboard navigation:

- **Arrow Keys**: Navigate between dates
- **Enter/Space**: Select focused date
- **Tab**: Move focus to/from calendar
- **Escape**: Close popup (when used with `date-picker`)

## Livewire Integration

### Basic Integration

```php
class MyComponent extends Component
{
    public ?string $selectedDate = null;

    public function mount(): void
    {
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.my-component');
    }
}
```

```blade
<x-strata::calendar
    mode="single"
    wire:model.live="selectedDate"
/>
```

### Multiple Dates

```php
public array $selectedDates = [];
```

```blade
<x-strata::calendar
    mode="multiple"
    wire:model.live="selectedDates"
/>
```

### Date Range

```php
public array $dateRange = [];

public function mount(): void
{
    $this->dateRange = [
        now()->subDays(7)->format('Y-m-d'),
        now()->format('Y-m-d'),
    ];
}
```

```blade
<x-strata::calendar
    mode="range"
    wire:model.live="dateRange"
/>
```

### Reactive Updates

```php
public ?string $selectedDate = null;

public function updatedSelectedDate($value): void
{
    // Perform actions when date changes
    logger('Date changed to: ' . $value);
}
```

## Props Reference

### Calendar Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `mode` | string | `'single'` | Selection mode: `single`, `multiple`, `range`, `week` |
| `value` | string\|array | `null` | Initial selected date(s) |
| `minDate` | string | `null` | Minimum selectable date (Y-m-d format) |
| `maxDate` | string | `null` | Maximum selectable date (Y-m-d format) |
| `disabledDates` | array | `[]` | Array of disabled dates (Y-m-d format) |
| `weekStartsOn` | int | `0` | First day of week (0 = Sunday, 1 = Monday) |
| `monthsToShow` | int | `1` | Number of months to display (1-3) |
| `showPresets` | bool | `false` | Show preset date range buttons |
| `variant` | string | `'default'` | Visual variant: `default`, `bordered`, `card`, `minimal` |
| `size` | string | `'md'` | Size: `sm`, `md`, `lg` |

### Date Picker Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `mode` | string | `'single'` | Selection mode: `single`, `multiple`, `range`, `week` |
| `value` | string\|array | `null` | Initial selected date(s) |
| `placeholder` | string | `'Select date...'` | Input placeholder text |
| `minDate` | string | `null` | Minimum selectable date |
| `maxDate` | string | `null` | Maximum selectable date |
| `disabledDates` | array | `[]` | Array of disabled dates |
| `weekStartsOn` | int | `0` | First day of week |
| `monthsToShow` | int | `1` | Number of months in popup |
| `showPresets` | bool | `false` | Show preset buttons in popup |
| `variant` | string | `'default'` | Input variant |
| `size` | string | `'md'` | Input size |
| `state` | string | `'default'` | Input state: `default`, `success`, `error` |
| `disabled` | bool | `false` | Disable the input |
| `clearable` | bool | `true` | Show clear button |

## Styling

The calendar uses semantic color tokens that automatically adapt to light/dark mode:

- `bg-primary` - Selected dates (single, range start/end)
- `text-primary-foreground` - Text on selected dates
- `bg-primary-subtle` - Dates in range (between start/end), hover states
- `border-primary` - Today indicator
- `text-muted-foreground` - Inactive dates
- `bg-muted` - Disabled dates

### Range Selection Styling

When using range mode, the calendar applies special styling to create a visual flow:

- **Range Start**: Full primary background with left rounded corners (`rounded-l-lg`)
- **Range End**: Full primary background with right rounded corners (`rounded-r-lg`)
- **In-Between Dates**: Subtle background with no rounded corners for a continuous selection appearance

This creates a cohesive visual indication of the selected date range.

## Examples

### Booking System

```blade
<div>
    <h3>Select Your Stay</h3>

    <x-strata::date-picker
        mode="range"
        wire:model.live="bookingDates"
        :min-date="now()->format('Y-m-d')"
        :max-date="now()->addMonths(6)->format('Y-m-d')"
        :disabled-dates="$unavailableDates"
        :months-to-show="2"
        placeholder="Check-in - Check-out"
    />

    @if(count($bookingDates) === 2)
        <p>
            Nights: {{ \Carbon\Carbon::parse($bookingDates[0])->diffInDays($bookingDates[1]) }}
        </p>
    @endif
</div>
```

### Task Scheduler

```blade
<x-strata::calendar
    mode="multiple"
    wire:model.live="taskDates"
    variant="bordered"
    :disabled-dates="$holidays"
/>

<div>
    <h4>Selected Dates ({{ count($taskDates) }}):</h4>
    <ul>
        @foreach($taskDates as $date)
            <li>{{ \Carbon\Carbon::parse($date)->format('M j, Y') }}</li>
        @endforeach
    </ul>
</div>
```

### Event Calendar

```blade
<x-strata::calendar
    mode="single"
    wire:model.live="selectedDate"
    variant="card"
/>

@if($selectedDate)
    <div>
        <h4>Events on {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}:</h4>
        @foreach($this->getEventsForDate($selectedDate) as $event)
            <div>{{ $event->title }}</div>
        @endforeach
    </div>
@endif
```

### Timesheet Week Selection

```blade
<x-strata::calendar
    mode="week"
    wire:model.live="timesheetWeek"
    :week-starts-on="1"
    variant="bordered"
/>

@if(count($timesheetWeek) === 7)
    <div>
        Week of {{ \Carbon\Carbon::parse($timesheetWeek[0])->format('M j') }} -
        {{ \Carbon\Carbon::parse($timesheetWeek[6])->format('M j, Y') }}
    </div>
@endif
```

## Accessibility

The calendar component follows accessibility best practices:

- Semantic HTML structure
- ARIA labels for navigation and dates
- Keyboard navigation support
- Focus management
- Screen reader friendly date announcements
- High contrast support
- Visible focus indicators

## Browser Support

The calendar works in all modern browsers:

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

No external dependencies or polyfills required.
