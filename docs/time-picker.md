# Time Picker

A flexible time picker component with support for 12-hour and 24-hour formats, disabled times, and quick presets. Perfect for appointment booking, scheduling, and time-sensitive forms.

## Features

- **12-Hour & 24-Hour Formats** - Toggle between AM/PM and military time
- **Custom Time Intervals** - Generate times in 5, 10, 15, 30-minute increments
- **Disabled Times** - Block specific times from selection (e.g., booked appointments)
- **Min/Max Constraints** - Limit selectable times to business hours
- **Quick Presets** - Shortcuts like "Now", "Morning", "Evening"
- **Value Objects** - First-class support for TimeValue
- **Livewire Integration** - Seamless `wire:model` support
- **Auto-Scroll** - Automatically scrolls to selected or current time
- **Morphing Resistant** - Handles Livewire morphing without state loss

## Basic Usage

### 12-Hour Format (Default)

```blade
<x-strata::time-picker
    wire:model.live="appointmentTime"
    placeholder="Select time"
/>
```

### 24-Hour Format

```blade
<x-strata::time-picker
    wire:model.live="appointmentTime"
    format="24"
    placeholder="Select time"
/>
```

## Value Objects

The time picker works seamlessly with Strata UI's TimeValue object:

### TimeValue

```php
use StrataUI\Data\TimeValue;

class AppointmentForm extends Component
{
    public ?TimeValue $appointmentTime = null;

    public function mount(): void
    {
        $this->appointmentTime = TimeValue::now();
    }

    public function render(): View
    {
        return view('livewire.appointment-form');
    }
}
```

```blade
<x-strata::time-picker
    wire:model.live="appointmentTime"
    :value="$appointmentTime"
/>

@if ($appointmentTime)
    <p>Selected: {{ $appointmentTime->to12HourFormat() }}</p>
    <p>24-hour: {{ $appointmentTime->to24HourFormat() }}</p>
    <p>Seconds: {{ $appointmentTime->toSeconds() }}</p>
@endif
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `format` | `'12'\|'24'` | `'12'` | Time format (12-hour or 24-hour) |
| `value` | `TimeValue\|string\|null` | `null` | Current value (HH:MM format) |
| `stepMinutes` | `int` | `15` | Minutes between each time option |
| `minTime` | `string\|null` | `null` | Minimum selectable time (HH:MM) |
| `maxTime` | `string\|null` | `null` | Maximum selectable time (HH:MM) |
| `disabledTimes` | `array` | `[]` | Array of disabled times (HH:MM format) |
| `showPresets` | `boolean` | `false` | Show quick preset shortcuts |
| `placeholder` | `string` | `'Select time'` | Placeholder text |
| `state` | `'default'\|'success'\|'error'\|'warning'` | `'default'` | Visual state |
| `size` | `'sm'\|'md'\|'lg'` | `'md'` | Component size |
| `disabled` | `boolean` | `false` | Disable interaction |
| `clearable` | `boolean` | `true` | Show clear button |
| `id` | `string\|null` | Auto-generated | HTML ID attribute |
| `name` | `string\|null` | `null` | Form input name |

## Examples

### Business Hours Only

Limit time selection to 9 AM - 5 PM:

```blade
<x-strata::time-picker
    wire:model.live="appointmentTime"
    min-time="09:00"
    max-time="17:00"
    placeholder="Select time (9 AM - 5 PM)"
/>
```

### 30-Minute Intervals

Generate times in 30-minute increments:

```blade
<x-strata::time-picker
    wire:model.live="time"
    :step-minutes="30"
/>
```

This generates: 12:00 AM, 12:30 AM, 1:00 AM, 1:30 AM, etc.

### Disabled Times (Booked Appointments)

**Critical feature for appointment booking systems.**

```php
use StrataUI\Data\DateValue;
use StrataUI\Data\TimeValue;

class AppointmentBooking extends Component
{
    public ?DateValue $appointmentDate = null;
    public ?TimeValue $appointmentTime = null;

    public function getBookedTimesForSelectedDateProperty(): array
    {
        if (!$this->appointmentDate) {
            return [];
        }

        return Appointment::query()
            ->whereDate('scheduled_at', $this->appointmentDate->toDateString())
            ->pluck('scheduled_at')
            ->map(fn ($datetime) => Carbon::parse($datetime)->format('H:i'))
            ->toArray();
    }
}
```

```blade
<x-strata::date-picker
    wire:model.live="appointmentDate"
    :min-date="date('Y-m-d')"
/>

<x-strata::time-picker
    wire:model.live="appointmentTime"
    :disabled-times="$this->bookedTimesForSelectedDate"
    min-time="09:00"
    max-time="17:00"
    :step-minutes="15"
    placeholder="Select available time"
/>
```

Booked times will be grayed out and unselectable.

### With Quick Presets

**Available Presets:**
- **Now** - Current time (rounded to step interval)
- **Morning** - 9:00 AM
- **Noon** - 12:00 PM
- **Afternoon** - 1:00 PM
- **Evening** - 5:00 PM
- **End of Day** - 11:59 PM

```blade
<x-strata::time-picker
    wire:model.live="time"
    :show-presets="true"
/>
```

### Validation States

Show validation feedback:

```blade
<x-strata::time-picker
    wire:model.live="appointmentTime"
    :state="$errors->has('appointmentTime') ? 'error' : 'default'"
/>

@error('appointmentTime')
    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
@enderror
```

### Sizes

```blade
{{-- Small --}}
<x-strata::time-picker
    wire:model="time"
    size="sm"
/>

{{-- Medium (default) --}}
<x-strata::time-picker
    wire:model="time"
    size="md"
/>

{{-- Large --}}
<x-strata::time-picker
    wire:model="time"
    size="lg"
/>
```

## Real-World Examples

### Complete Appointment Booking System

This example shows date + time picker with disabled times:

```php
use StrataUI\Data\DateValue;
use StrataUI\Data\TimeValue;
use Illuminate\Support\Carbon;

class AppointmentBooking extends Component
{
    public ?DateValue $appointmentDate = null;
    public ?TimeValue $appointmentTime = null;

    public function mount(): void
    {
        $this->appointmentDate = DateValue::today();
    }

    public function getBookedTimesForSelectedDateProperty(): array
    {
        if (!$this->appointmentDate) {
            return [];
        }

        return Appointment::query()
            ->whereDate('scheduled_at', $this->appointmentDate->toDateString())
            ->pluck('scheduled_at')
            ->map(fn ($datetime) => Carbon::parse($datetime)->format('H:i'))
            ->toArray();
    }

    public function rules(): array
    {
        return [
            'appointmentDate' => ['required', 'after:today'],
            'appointmentTime' => ['required'],
        ];
    }

    public function book(): void
    {
        $this->validate();

        $scheduledAt = Carbon::parse(
            $this->appointmentDate->toDateString() . ' ' . $this->appointmentTime->toString()
        );

        Appointment::create([
            'scheduled_at' => $scheduledAt,
            'user_id' => auth()->id(),
        ]);

        session()->flash('success', 'Appointment booked successfully!');

        $this->redirect('/appointments');
    }
}
```

```blade
<form wire:submit="book">
    <div class="space-y-4">
        {{-- Date Selection --}}
        <div>
            <label class="block text-sm font-medium mb-1">Appointment Date</label>
            <x-strata::date-picker
                wire:model.live="appointmentDate"
                :value="$appointmentDate"
                :min-date="date('Y-m-d')"
                :show-presets="true"
                placeholder="Select date"
                :state="$errors->has('appointmentDate') ? 'error' : 'default'"
            />
            @error('appointmentDate')
                <p class="text-sm text-destructive mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Time Selection --}}
        <div>
            <label class="block text-sm font-medium mb-1">Appointment Time</label>
            <x-strata::time-picker
                wire:model.live="appointmentTime"
                :value="$appointmentTime"
                :disabled-times="$this->bookedTimesForSelectedDate"
                min-time="09:00"
                max-time="17:00"
                :step-minutes="15"
                :show-presets="true"
                placeholder="Select time"
                :state="$errors->has('appointmentTime') ? 'error' : 'default'"
            />
            @error('appointmentTime')
                <p class="text-sm text-destructive mt-1">{{ $message }}</p>
            @enderror

            @if (count($this->bookedTimesForSelectedDate) > 0)
                <p class="text-xs text-muted-foreground mt-1">
                    {{ count($this->bookedTimesForSelectedDate) }} time(s) already booked
                </p>
            @endif
        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Book Appointment
        </button>
    </div>
</form>
```

### Office Hours Scheduler

```php
class OfficeHoursForm extends Component
{
    public array $schedule = [];

    public function mount(): void
    {
        $this->schedule = [
            'monday' => ['start' => '09:00', 'end' => '17:00'],
            'tuesday' => ['start' => '09:00', 'end' => '17:00'],
            'wednesday' => ['start' => '09:00', 'end' => '17:00'],
            'thursday' => ['start' => '09:00', 'end' => '17:00'],
            'friday' => ['start' => '09:00', 'end' => '17:00'],
        ];
    }
}
```

```blade
<div class="space-y-4">
    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
        <div class="flex items-center gap-4">
            <label class="w-24 text-sm font-medium capitalize">{{ $day }}</label>

            <x-strata::time-picker
                wire:model.live="schedule.{{ $day }}.start"
                format="24"
                :step-minutes="30"
                placeholder="Start time"
                size="sm"
            />

            <span class="text-muted-foreground">to</span>

            <x-strata::time-picker
                wire:model.live="schedule.{{ $day }}.end"
                format="24"
                :step-minutes="30"
                placeholder="End time"
                size="sm"
            />
        </div>
    @endforeach
</div>
```

### Event Time Range

```blade
<div class="flex items-center gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Start Time</label>
        <x-strata::time-picker
            wire:model.live="startTime"
            :step-minutes="30"
        />
    </div>

    <span class="text-muted-foreground mt-6">to</span>

    <div>
        <label class="block text-sm font-medium mb-1">End Time</label>
        <x-strata::time-picker
            wire:model.live="endTime"
            :step-minutes="30"
        />
    </div>
</div>
```

## Time Generation Logic

The time picker generates times based on `stepMinutes`:

### 15-Minute Intervals (Default)

```
12:00 AM, 12:15 AM, 12:30 AM, 12:45 AM
1:00 AM, 1:15 AM, 1:30 AM, 1:45 AM
...
11:00 PM, 11:15 PM, 11:30 PM, 11:45 PM
```

### 30-Minute Intervals

```
12:00 AM, 12:30 AM
1:00 AM, 1:30 AM
...
11:00 PM, 11:30 PM
```

### Filtering

Times are filtered by:
1. **Min/Max** - Times outside `minTime` and `maxTime` are excluded
2. **Disabled** - Times in `disabledTimes` array are shown but disabled
3. **Current** - Current time is highlighted (if visible)

## Morphing & Reactivity

The time picker uses the same morphing-resistant patterns as the date picker:

- **Entangleable** for state synchronization
- **Positionable** for dropdown positioning
- **Hidden input pattern** for Livewire morphing stability

### Dynamic Disabled Times

The component reactively updates disabled times when the date changes:

```blade
<x-strata::date-picker
    wire:model.live="appointmentDate"
/>

{{-- Disabled times update automatically when date changes --}}
<x-strata::time-picker
    wire:model.live="appointmentTime"
    :disabled-times="$this->bookedTimesForSelectedDate"
/>
```

Livewire will:
1. Morph the DOM with new disabled times
2. Time picker re-renders the time list
3. Previously disabled times become available
4. Newly booked times become disabled

## Accessibility

The time picker follows WAI-ARIA best practices:

- **Keyboard Navigation** - Full keyboard support
- **ARIA Attributes** - Proper `role`, `aria-expanded`, `aria-modal`
- **Focus Management** - Logical tab order
- **Screen Readers** - All buttons properly labeled

### Keyboard Shortcuts

- `Enter` / `Space` - Open time picker
- `Escape` - Close time picker
- `Arrow Up/Down` - Navigate time list
- `Tab` / `Shift+Tab` - Navigate between elements

## Technical Details

### State Management

The time picker uses:

1. **Entangleable** - Alpine ↔ Livewire sync
   - Re-detects `wire:model` on every sync
   - Handles morphing gracefully

2. **Positionable** - Dropdown positioning
   - Smart placement (bottom-start)
   - Automatic scrolling to selected time

### Time Format Conversion

Times are stored in 24-hour format (HH:MM) internally:

```javascript
// Storage: "13:30"
// Display (12-hour): "1:30 PM"
// Display (24-hour): "13:30"
```

This ensures consistent data format for:
- Database storage
- Backend validation
- Time comparisons

### Auto-Scroll Behavior

When the dropdown opens, the time picker:
1. Finds the selected time in the list
2. Scrolls it into view with `smooth` behavior
3. Centers it in the viewport (when possible)

This improves UX by avoiding manual scrolling through long time lists.

## Performance Considerations

### Time Generation

Times are generated on component initialization and cached:

```javascript
get times() {
    // Generated once per render
    // Cached by Alpine's reactivity system
}
```

For 15-minute intervals, this generates **96 time options** (24 hours × 4).
For 5-minute intervals, this generates **288 time options**.

Use larger `stepMinutes` values for better performance with many time pickers on the page.

### Disabled Times

The `disabledTimes` prop accepts an array of time strings:

```php
// ✅ Good - Simple array
$disabledTimes = ['09:00', '10:30', '14:15'];

// ❌ Avoid - Complex computations in view
$disabledTimes = Appointment::all()->map(...)->filter(...)->toArray();
```

For best performance, compute disabled times in a cached property:

```php
#[Computed]
public function bookedTimesForSelectedDate(): array
{
    return Cache::remember(
        "booked-times-{$this->appointmentDate}",
        now()->addMinutes(5),
        fn () => Appointment::getBookedTimes($this->appointmentDate)
    );
}
```

## Related Components

- [Date Picker](./date-picker.md) - Date selection component
- [Calendar](./calendar.md) - Lower-level calendar component
- [Value Objects](./value-objects.md) - TimeValue, DateValue

## Learn More

- [Livewire Morphing Strategies](./livewire-morphing-strategies.md)
- [Value Objects Guide](./value-objects.md)
