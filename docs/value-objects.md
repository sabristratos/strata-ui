# Value Objects

Strata UI provides specialized value objects for working with dates, time, and date ranges in your Laravel applications. These objects provide type safety, convenient methods, and seamless Livewire integration.

## Available Value Objects

- **DateValue** - Single date representation
- **DateRange** - Date range with preset support (extends CarbonPeriod)
- **TimeValue** - Time representation with 12/24-hour format support

## Benefits

### Type Safety
```php
// ❌ Without value objects - no type hints, no autocomplete
public array|string $selectedDate;

// ✅ With value objects - clear types, full IDE support
public DateValue $birthday;
public DateRange $reportingPeriod;
public TimeValue $appointmentTime;
```

### Rich API
```php
// ❌ Without value objects
$days = Carbon::parse($this->range[1])->diffInDays($this->range[0]);

// ✅ With value objects
$days = $this->range->count();
$contains = $this->range->contains(now());
```

### Eloquent Integration
```php
// Works directly with Eloquent queries
$orders = Order::whereBetween('created_at', $this->range)->get();
```

## DateValue

Single date representation with convenient methods.

### Creating DateValue

```php
use Stratos\StrataUI\Data\DateValue;

// From string
$date = DateValue::make('2024-11-04');

// From Carbon instance
$date = DateValue::make(Carbon::parse('2024-11-04'));

// Factory methods
$today = DateValue::today();
$tomorrow = DateValue::tomorrow();
$yesterday = DateValue::yesterday();
```

### Using DateValue

```php
// Formatting
$date->toDateString();              // '2024-11-04'
$date->format('F j, Y');            // 'November 4, 2024'
(string) $date;                     // '2024-11-04'

// Comparison
$date->isToday();                   // bool
$date->isFuture();                  // bool
$date->isPast();                    // bool
$date->isWeekend();                 // bool
$date->isWeekday();                 // bool

// Date math
$date->diffInDays($otherDate);      // int
$newDate = $date->addDays(5);       // DateValue
$newDate = $date->subDays(3);       // DateValue

// Carbon integration
$carbon = $date->toCarbon();        // Carbon
```

### Livewire Integration

```php
use Livewire\Component;
use Stratos\StrataUI\Data\DateValue;

class AppointmentForm extends Component
{
    public DateValue $appointmentDate;

    public function mount()
    {
        $this->appointmentDate = DateValue::today();
    }
}
```

```blade
<x-strata::date-picker wire:model.live="appointmentDate" />
```

### Session Persistence

```php
use Livewire\Attributes\Session;

class Dashboard extends Component
{
    #[Session]
    public DateValue $selectedDate;
}
```

## DateRange

Date range representation with preset support. Extends CarbonPeriod for full compatibility with Laravel's query builder.

### Creating DateRange

```php
use Stratos\StrataUI\Data\DateRange;

// From strings
$range = DateRange::between('2024-11-01', '2024-11-30');

// From Carbon instances
$range = DateRange::between($start, $end);
```

### Preset Factory Methods

```php
// Single day presets
$range = DateRange::today();
$range = DateRange::yesterday();

// Week presets
$range = DateRange::thisWeek();
$range = DateRange::lastWeek();
$range = DateRange::last7Days();

// Month presets
$range = DateRange::last30Days();
$range = DateRange::thisMonth();
$range = DateRange::lastMonth();

// Quarter presets
$range = DateRange::thisQuarter();
$range = DateRange::lastQuarter();

// Year presets
$range = DateRange::thisYear();
$range = DateRange::lastYear();
$range = DateRange::yearToDate();

// Special
$range = DateRange::allTime();
```

### Using DateRange

```php
// Access dates
$start = $range->getStartDate();           // Carbon
$end = $range->getEndDate();               // Carbon

// Calculate duration
$days = $range->count();             // int
$length = $range->length();         // alias for days()

// Check containment
$range->contains('2024-11-15');     // bool
$range->contains(now());            // bool

// Get preset
$preset = $range->preset();         // DateRangePreset enum or null
$hasPreset = $range->hasPreset();   // bool

// Iterate over dates
foreach ($range as $date) {
    // $date is a Carbon instance
}
```

### Eloquent Integration

```php
use Livewire\Component;
use Stratos\StrataUI\Data\DateRange;
use App\Models\Order;

class Dashboard extends Component
{
    public DateRange $range;

    public function mount()
    {
        $this->range = DateRange::last30Days();
    }

    public function getOrdersProperty()
    {
        return Order::whereBetween('created_at', $this->range)->get();
    }
}
```

### Livewire Integration

```php
use Livewire\Component;
use Stratos\StrataUI\Data\DateRange;

class ReportDashboard extends Component
{
    public DateRange $reportingPeriod;

    public function mount()
    {
        $this->reportingPeriod = DateRange::last30Days();
    }

    public function setPreset(string $preset)
    {
        $this->reportingPeriod = match ($preset) {
            'today' => DateRange::today(),
            'last-7-days' => DateRange::last7Days(),
            'this-month' => DateRange::thisMonth(),
            default => DateRange::last30Days(),
        };
    }
}
```

```blade
<x-strata::calendar
    wire:model.live="reportingPeriod"
    mode="range"
/>

<div>
    Showing {{ $reportingPeriod->count() }} days
    from {{ $reportingPeriod->getStartDate()->format('M j') }}
    to {{ $reportingPeriod->getEndDate()->format('M j') }}
</div>
```

### Session Persistence

```php
use Livewire\Attributes\Session;

class Dashboard extends Component
{
    #[Session]
    public DateRange $range;

    public function mount()
    {
        // Restored from session automatically
        if (!isset($this->range)) {
            $this->range = DateRange::last7Days();
        }
    }
}
```

## TimeValue

Time representation with support for both 12-hour and 24-hour formats.

### Creating TimeValue

```php
use Stratos\StrataUI\Data\TimeValue;

// From string (24-hour)
$time = TimeValue::make('14:30');
$time = TimeValue::make('14:30:45');

// From string (12-hour)
$time = TimeValue::make('2:30 PM');
$time = TimeValue::make('2:30:45 PM');

// Factory methods
$now = TimeValue::now();
$time = TimeValue::from24Hour(14, 30, 45);
$time = TimeValue::from12Hour(2, 30, 'PM', 45);
```

### Using TimeValue

```php
// Format conversion
$time->to24HourFormat();            // int (14)
$time->to12HourFormat();            // '2:30 PM'
$time->toString();                  // '14:30' (24-hour default)
$time->toString(false);             // '2:30 PM' (12-hour)
(string) $time;                     // '14:30:45' (preserves seconds)

// Format checking
$time->is24Hour();                  // bool
$time->is12Hour();                  // bool

// Comparison
$time->isBefore($otherTime);        // bool
$time->isAfter($otherTime);         // bool
$time->equals($otherTime);          // bool

// Conversion
$seconds = $time->toSeconds();      // int
$carbon = $time->toCarbon();        // Carbon (today with this time)
$carbon = $time->toCarbon($date);   // Carbon (specific date with this time)

// Carbon formatting
$time->format('H:i');               // '14:30'
$time->format('g:i A');             // '2:30 PM'
```

### Livewire Integration

```php
use Livewire\Component;
use Stratos\StrataUI\Data\TimeValue;

class AppointmentBooking extends Component
{
    public TimeValue $startTime;
    public TimeValue $endTime;

    public function mount()
    {
        $this->startTime = TimeValue::make('09:00');
        $this->endTime = TimeValue::make('17:00');
    }
}
```

```blade
<x-strata::time-picker
    wire:model.live="startTime"
    label="Start Time"
/>

<x-strata::time-picker
    wire:model.live="endTime"
    label="End Time"
/>
```

## DateRangePreset Enum

The `DateRangePreset` enum provides preset identifiers for common date ranges.

### Available Presets

```php
use Stratos\StrataUI\Enums\DateRangePreset;

DateRangePreset::Today
DateRangePreset::Yesterday
DateRangePreset::ThisWeek
DateRangePreset::LastWeek
DateRangePreset::Last7Days
DateRangePreset::Last30Days
DateRangePreset::ThisMonth
DateRangePreset::LastMonth
DateRangePreset::ThisQuarter
DateRangePreset::LastQuarter
DateRangePreset::ThisYear
DateRangePreset::LastYear
DateRangePreset::YearToDate
DateRangePreset::AllTime
```

### Using Presets

```php
// Get label
$preset = DateRangePreset::Last7Days;
$preset->label();                   // 'Last 7 Days'

// Create range from preset
$range = DateRange::fromPreset(DateRangePreset::Last7Days);

// Check preset on range
$range = DateRange::last30Days();
$range->preset();                   // DateRangePreset::Last30Days
$range->hasPreset();                // true
```

## Migration Guide

### From Arrays to DateRange

```php
// ❌ Before
public array $range = [];

public function mount()
{
    $this->range = [now()->subDays(7), now()];
}

$orders = Order::whereBetween('created_at', $this->range)->get();

// ✅ After
public DateRange $range;

public function mount()
{
    $this->range = DateRange::last7Days();
}

$orders = Order::whereBetween('created_at', $this->range)->get();
```

### From Strings to DateValue

```php
// ❌ Before
public string $birthday;

public function mount()
{
    $this->birthday = '2024-11-04';
}

$carbon = Carbon::parse($this->birthday);

// ✅ After
public DateValue $birthday;

public function mount()
{
    $this->birthday = DateValue::make('2024-11-04');
}

$carbon = $this->birthday->toCarbon();
```

### From Strings to TimeValue

```php
// ❌ Before
public string $appointmentTime = '14:30';

// Manual parsing
[$hour, $minute] = explode(':', $this->appointmentTime);

// ✅ After
public TimeValue $appointmentTime;

public function mount()
{
    $this->appointmentTime = TimeValue::make('14:30');
}

// Direct access to components
$hour = $this->appointmentTime->hour;
$minute = $this->appointmentTime->minute;
```

## Technical Implementation

### Livewire Synthesizers

Strata UI uses custom Livewire Synthesizers to enable seamless wire:model integration with nullable typed properties. These synthesizers handle the conversion between raw values (strings/arrays) and value objects automatically.

**How it works:**
1. When Livewire receives a value from the frontend, the synthesizer's `hydrate()` method converts it to a value object
2. When sending data to the frontend, the `dehydrate()` method converts the value object back to a simple format
3. Null values are handled gracefully throughout the lifecycle

**Registered Synthesizers:**
- `DateValueSynthesizer` - Converts between strings and DateValue objects
- `DateRangeSynthesizer` - Converts between arrays and DateRange objects
- `TimeValueSynthesizer` - Converts between strings/arrays and TimeValue objects

This means you can use wire:model directly with typed properties without any issues:

```php
// Works perfectly with wire:model
public ?DateValue $appointmentDate = null;
public ?DateRange $reportingPeriod = null;
public ?TimeValue $startTime = null;
```

### Wireable Interface

The value objects also implement the `Wireable` interface for additional compatibility and serialization support. This enables:
- Session persistence with `#[Session]` attribute
- Property locking with `#[Locked]` attribute
- Custom serialization logic

## Backward Compatibility

All Strata UI components continue to accept string and array inputs for backward compatibility. The components will automatically convert these to value objects internally.

```blade
{{-- Still works with strings --}}
<x-strata::date-picker wire:model="dateString" />

{{-- Also works with value objects --}}
<x-strata::date-picker wire:model="dateValue" />
```

However, we recommend migrating to value objects for the improved type safety and developer experience.
