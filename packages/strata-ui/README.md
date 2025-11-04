# Strata UI

A modern Blade and Livewire component library for Laravel.

## Features

- Clean, flexible, and powerful UI components
- Built with Tailwind CSS v4
- Seamless Livewire integration
- Alpine.js for interactions
- Type-safe value objects for dates and times
- Semantic color tokens and theming
- 1,648+ Lucide icons included

## Installation

```bash
composer require stratos/strata-ui
```

## Quick Start

Add the Strata UI directives to your layout:

```blade
<!DOCTYPE html>
<html>
<head>
    @strataStyles
</head>
<body>
    {{ $slot }}
    @strataScripts
</body>
</html>
```

Start using components:

```blade
<x-strata::badge variant="success" icon="check">Verified</x-strata::badge>
<x-strata::icon.heart class="w-5 h-5 text-red-500" />
```

Use type-safe value objects:

```php
use Stratos\StrataUI\Data\DateRange;
use Stratos\StrataUI\Data\TimeValue;

class Dashboard extends Component
{
    public DateRange $period;
    public TimeValue $appointmentTime;

    public function mount()
    {
        $this->period = DateRange::last30Days();
        $this->appointmentTime = TimeValue::make('14:30');
    }
}
```

```blade
<x-strata::calendar wire:model.live="period" mode="range" />
<x-strata::time-picker wire:model="appointmentTime" />

<p>Showing {{ $period->count() }} days of data</p>
```

## Documentation

**[View Full Documentation →](docs/index.md)**

### Components
- [Icons](docs/icons.md) - 1,648 Lucide icons
- [Badges](docs/badges.md) - Labels, status indicators, and tags
- [Calendar](docs/calendar.md) - Flexible date picker with multiple modes
- [Date Picker](docs/date-picker.md) - Date selection with value object support
- [Time Picker](docs/time-picker.md) - Time selection with 12/24-hour formats

### Data Objects
- [Value Objects](docs/value-objects.md) - Type-safe DateValue, DateRange, and TimeValue

## Development

Build package assets:

```bash
php artisan strata:build
```

Watch for changes during development:

```bash
php artisan strata:build --watch
```

## License

MIT
