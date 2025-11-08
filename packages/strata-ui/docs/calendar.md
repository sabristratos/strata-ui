# Calendar

Flexible calendar component with multiple selection modes, internationalization, date ranges, and keyboard navigation. Use standalone or as part of the date picker component.

## Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `mode` | string | `single` | `single`, `range`, `multiple`, `week` | Selection mode |
| `value` | mixed | `null` | String, array, or DateValue | Initial selected date(s) |
| `minDate` | string | `null` | ISO date string | Earliest selectable date |
| `maxDate` | string | `null` | ISO date string | Latest selectable date |
| `disabledDates` | array | `[]` | Array of ISO date strings | Specific dates to disable |
| `locale` | string | Auto-detected | Any locale code | Locale for month/day names |
| `weekStartsOn` | int | Auto by locale | `0` (Sunday), `1` (Monday) | First day of week |
| `monthsToShow` | int | `1` | Any positive integer | Number of months to display |
| `showPresets` | boolean | `false` | `true`, `false` | Show quick select presets |
| `yearRangeStart` | int | Current year - 50 | Any year | Start of year picker range |
| `yearRangeEnd` | int | Current year + 10 | Any year | End of year picker range |
| `variant` | string | `default` | `default`, `bordered`, `card`, `minimal` | Visual style |
| `size` | string | `md` | `xs`, `sm`, `md`, `lg`, `xl` | Calendar size |

## Examples

### Basic Calendar

```blade
{{-- Single date selection --}}
<x-strata::calendar wire:model="selectedDate" />

{{-- Date range selection --}}
<x-strata::calendar
    mode="range"
    wire:model="dateRange"
/>

{{-- Multiple dates selection --}}
<x-strata::calendar
    mode="multiple"
    wire:model="selectedDates"
/>

{{-- Week selection --}}
<x-strata::calendar
    mode="week"
    wire:model="selectedWeek"
/>
```

### With Constraints

```blade
{{-- Min/max date constraints --}}
<x-strata::calendar
    wire:model="appointmentDate"
    minDate="2025-01-01"
    maxDate="2025-12-31"
/>

{{-- Disabled specific dates --}}
<x-strata::calendar
    wire:model="meetingDate"
    :disabledDates="['2025-01-15', '2025-01-20', '2025-01-25']"
/>
```

### Multiple Months

```blade
{{-- Show 2 months side by side --}}
<x-strata::calendar
    mode="range"
    wire:model="travelDates"
    :monthsToShow="2"
/>

{{-- Show 3 months with presets --}}
<x-strata::calendar
    mode="range"
    wire:model="reportRange"
    :monthsToShow="3"
    :showPresets="true"
/>
```

### With Variants

```blade
{{-- Bordered variant --}}
<x-strata::calendar
    variant="bordered"
    wire:model="date"
/>

{{-- Card variant with shadow --}}
<x-strata::calendar
    variant="card"
    wire:model="date"
/>

{{-- Minimal variant --}}
<x-strata::calendar
    variant="minimal"
    wire:model="date"
/>
```

### Internationalization

```blade
{{-- French calendar (Monday start) --}}
<x-strata::calendar
    locale="fr"
    wire:model="date"
/>

{{-- Custom week start (Monday) --}}
<x-strata::calendar
    locale="en"
    :weekStartsOn="1"
    wire:model="date"
/>

{{-- Japanese calendar --}}
<x-strata::calendar
    locale="ja"
    wire:model="date"
/>
```

## Selection Modes

### Single Mode
Selects one date at a time. Returns a single date string.

```php
public $selectedDate = '2025-01-15';
```

### Range Mode
Selects start and end dates. Returns array with two dates.

```php
public $dateRange = ['2025-01-15', '2025-01-20'];
// Or using DateRange data object
public $dateRange;
```

### Multiple Mode
Selects multiple individual dates. Returns array of date strings.

```php
public $selectedDates = ['2025-01-15', '2025-01-18', '2025-01-22'];
```

### Week Mode
Selects entire week when clicking any day. Returns array of 7 dates.

```php
public $selectedWeek = ['2025-01-13', '2025-01-14', '2025-01-15', ...];
```

## Quick Select Presets

Enable presets with `showPresets` for common date selections:

**Single/Multiple/Week modes:**
- Today
- Yesterday
- This week
- This month

**Range mode:**
- Last 7 days
- Last 30 days
- This month
- Last month
- This quarter
- This year

## Keyboard Navigation

Full keyboard support for accessibility:

| Key | Action |
|-----|--------|
| `←` `→` | Navigate days (left/right) |
| `↑` `↓` | Navigate weeks (up/down) |
| `Home` | First day of month |
| `End` | Last day of month |
| `PageUp` | Previous month |
| `PageDown` | Next month |
| `Shift+PageUp` | Previous year |
| `Shift+PageDown` | Next year |
| `Enter` / `Space` | Select focused date |
| `Tab` | Focus navigation |

## Livewire Integration

### Wire Model
Use `wire:model` for seamless Livewire integration:

```blade
<x-strata::calendar wire:model="date" />
```

### Listen to Events
The calendar dispatches `date-selected` event on selection:

```blade
<div x-on:date-selected="console.log($event.detail)">
    <x-strata::calendar wire:model="date" />
</div>
```

Event detail contains:
```javascript
{
    dates: ['2025-01-15'], // or multiple dates
    mode: 'single'
}
```

### DateValue Data Objects

Use Strata UI data objects for type safety:

```php
use Stratos\StrataUI\Data\DateValue;
use Stratos\StrataUI\Data\DateRange;

// Single date
public DateValue $date;

// Date range
public DateRange $range;
```

## Notes

- **Locale detection:** Automatically detects app locale if not specified
- **Week start:** Auto-determines based on locale (e.g., Monday for most of Europe, Sunday for US)
- **Month names:** Uses `Intl.DateTimeFormat` for proper internationalization
- **Focus management:** Maintains focus state for keyboard navigation
- **Announcements:** Screen reader announcements for month navigation
- **Date format:** All dates use ISO 8601 format (YYYY-MM-DD)
- **Range hover:** Shows preview of range selection on hover
- **Disabled styling:** Visually distinct disabled dates with pointer-events disabled
- **Year picker:** Click month/year header to open month/year picker
- **Responsive:** Adjusts layout based on `monthsToShow` and screen size
