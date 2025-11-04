<?php

use Carbon\Carbon;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\Livewire;
use Stratos\StrataUI\Data\DateRange;
use Stratos\StrataUI\Data\DateValue;
use Stratos\StrataUI\Data\TimeValue;
use Stratos\StrataUI\Enums\DateRangePreset;

beforeEach(function () {
    Carbon::setTestNow('2024-11-04 12:00:00');
});

afterEach(function () {
    Carbon::setTestNow();
});

describe('DateValue Livewire Integration', function () {
    test('binds DateValue to wire:model', function () {
        $component = Livewire::test(new class extends Component
        {
            public DateValue $selectedDate;

            public function mount()
            {
                $this->selectedDate = DateValue::today();
            }

            public function render()
            {
                return '<div>{{ $selectedDate->toDateString() }}</div>';
            }
        });

        $component->assertSee('2024-11-04');
    });

    test('updates DateValue via wire:model', function () {
        $component = Livewire::test(new class extends Component
        {
            public DateValue $selectedDate;

            public function mount()
            {
                $this->selectedDate = DateValue::today();
            }

            public function updateDate(string $date)
            {
                $this->selectedDate = DateValue::make($date);
            }

            public function render()
            {
                return '<div></div>';
            }
        });

        $component->call('updateDate', '2024-12-25');

        expect($component->get('selectedDate')->toDateString())->toBe('2024-12-25');
    });

    test('serializes DateValue for session storage', function () {
        $component = Livewire::test(new class extends Component
        {
            #[Session]
            public DateValue $selectedDate;

            public function mount()
            {
                $this->selectedDate = DateValue::make('2024-11-04');
            }

            public function render()
            {
                return '<div></div>';
            }
        });

        expect(session()->has('selectedDate'))->toBeTrue();
        expect(session('selectedDate'))->toBe('2024-11-04');
    });
});

describe('DateRange Livewire Integration', function () {
    test('binds DateRange to wire:model', function () {
        $component = Livewire::test(new class extends Component
        {
            public DateRange $range;

            public function mount()
            {
                $this->range = DateRange::last7Days();
            }

            public function render()
            {
                return '<div>{{ $range->count() }}</div>';
            }
        });

        $component->assertSee('7');
    });

    test('updates DateRange via wire:model', function () {
        $component = Livewire::test(new class extends Component
        {
            public DateRange $range;

            public function mount()
            {
                $this->range = DateRange::today();
            }

            public function updateRange(string $start, string $end)
            {
                $this->range = DateRange::between($start, $end);
            }

            public function render()
            {
                return '<div></div>';
            }
        });

        $component->call('updateRange', '2024-11-01', '2024-11-10');

        expect($component->get('range')->count())->toBe(10);
    });

    test('serializes DateRange with preset for session storage', function () {
        $component = Livewire::test(new class extends Component
        {
            #[Session]
            public DateRange $range;

            public function mount()
            {
                $this->range = DateRange::last7Days();
            }

            public function render()
            {
                return '<div></div>';
            }
        });

        expect(session()->has('range'))->toBeTrue();
        $sessionData = session('range');
        expect($sessionData)->toBeArray();
        expect($sessionData['preset'])->toBe('last-7-days');
    });

    test('restores DateRange from session', function () {
        session(['range' => [
            'start' => '2024-11-01',
            'end' => '2024-11-10',
            'preset' => 'last-7-days',
        ]]);

        $component = Livewire::test(new class extends Component
        {
            #[Session]
            public DateRange $range;

            public function mount()
            {
                if (! isset($this->range)) {
                    $this->range = DateRange::today();
                }
            }

            public function render()
            {
                return '<div></div>';
            }
        });

        $range = $component->get('range');
        expect($range->getStartDate()->toDateString())->toBe('2024-11-01');
        expect($range->preset())->toBe(DateRangePreset::Last7Days);
    });

    test('uses DateRange preset factory methods', function () {
        $component = Livewire::test(new class extends Component
        {
            public DateRange $range;

            public function mount()
            {
                $this->range = DateRange::thisMonth();
            }

            public function setPreset(string $presetName)
            {
                $this->range = match ($presetName) {
                    'today' => DateRange::today(),
                    'last-7-days' => DateRange::last7Days(),
                    'this-month' => DateRange::thisMonth(),
                    default => DateRange::last7Days(),
                };
            }

            public function render()
            {
                return '<div></div>';
            }
        });

        $component->call('setPreset', 'last-7-days');
        expect($component->get('range')->preset())->toBe(DateRangePreset::Last7Days);
    });
});

describe('TimeValue Livewire Integration', function () {
    test('binds TimeValue to wire:model', function () {
        $component = Livewire::test(new class extends Component
        {
            public TimeValue $time;

            public function mount()
            {
                $this->time = TimeValue::make('14:30');
            }

            public function render()
            {
                return '<div>{{ $time->toString() }}</div>';
            }
        });

        $component->assertSee('14:30');
    });

    test('updates TimeValue via wire:model', function () {
        $component = Livewire::test(new class extends Component
        {
            public TimeValue $time;

            public function mount()
            {
                $this->time = TimeValue::make('10:00');
            }

            public function updateTime(string $newTime)
            {
                $this->time = TimeValue::make($newTime);
            }

            public function render()
            {
                return '<div></div>';
            }
        });

        $component->call('updateTime', '14:30:45');

        $time = $component->get('time');
        expect($time->hour)->toBe(14);
        expect($time->minute)->toBe(30);
        expect($time->second)->toBe(45);
    });

    test('handles 12-hour format in Livewire', function () {
        $component = Livewire::test(new class extends Component
        {
            public TimeValue $time;

            public function mount()
            {
                $this->time = TimeValue::make('2:30 PM');
            }

            public function render()
            {
                return '<div>{{ $time->to12HourFormat() }}</div>';
            }
        });

        $component->assertSee('2:30 PM');
    });

    test('serializes TimeValue for session storage', function () {
        $component = Livewire::test(new class extends Component
        {
            #[Session]
            public TimeValue $appointmentTime;

            public function mount()
            {
                $this->appointmentTime = TimeValue::make('14:30');
            }

            public function render()
            {
                return '<div></div>';
            }
        });

        expect(session()->has('appointmentTime'))->toBeTrue();
        expect(session('appointmentTime'))->toBe('14:30');
    });
});

describe('Value Objects with Eloquent Integration', function () {
    test('uses DateRange with whereBetween query', function () {
        $range = DateRange::last7Days();

        expect($range->getStartDate())->toBeInstanceOf(Carbon::class);
        expect($range->end())->toBeInstanceOf(Carbon::class);
    });

    test('DateRange extends CarbonPeriod for Eloquent compatibility', function () {
        $range = DateRange::last7Days();

        expect($range)->toBeInstanceOf(\Carbon\CarbonPeriod::class);
    });
});

describe('Value Objects Type Hinting', function () {
    test('enforces DateValue type in Livewire component', function () {
        $component = new class extends Component
        {
            public DateValue $date;

            public function mount()
            {
                $this->date = DateValue::today();
            }

            public function render()
            {
                return '<div></div>';
            }
        };

        $livewire = Livewire::test($component);

        expect($livewire->get('date'))->toBeInstanceOf(DateValue::class);
    });

    test('enforces DateRange type in Livewire component', function () {
        $component = new class extends Component
        {
            public DateRange $range;

            public function mount()
            {
                $this->range = DateRange::last7Days();
            }

            public function render()
            {
                return '<div></div>';
            }
        };

        $livewire = Livewire::test($component);

        expect($livewire->get('range'))->toBeInstanceOf(DateRange::class);
    });

    test('enforces TimeValue type in Livewire component', function () {
        $component = new class extends Component
        {
            public TimeValue $time;

            public function mount()
            {
                $this->time = TimeValue::now();
            }

            public function render()
            {
                return '<div></div>';
            }
        };

        $livewire = Livewire::test($component);

        expect($livewire->get('time'))->toBeInstanceOf(TimeValue::class);
    });
});
