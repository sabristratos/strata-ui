<?php

declare(strict_types=1);

namespace Strata\UI\View\Components;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;
use Strata\UI\ValueObjects\DateRange;

class Calendar extends Component
{
    public Carbon $initialDate;
    public ?Carbon $startDate;
    public ?Carbon $endDate;
    public array $presets;
    public string $locale;

    public function __construct(
        public mixed $value = null,
        string $initialDate = null,
        string $startDate = null,
        string $endDate = null,
        public string $weekStart = 'sunday',
        public bool $range = true,
        public bool $multiple = true,
        public int $visibleMonths = 2,
        bool $presets = true,
        string $locale = null,
        public bool $selecting = false,
        public bool $updating = false,
        public ?string $minDate = null,
        public ?string $maxDate = null,
        public array $disabledDates = [],
        public bool $showClearButton = false,
        public bool $closeOnSelect = false
    ) {
        // Handle new wire:model approach with DateRange object or array
        if ($this->value instanceof DateRange) {
            $this->startDate = $this->value->start;
            $this->endDate = $this->value->end;
        } elseif (is_array($this->value) && isset($this->value['start'])) {
            $this->startDate = Carbon::parse($this->value['start']);
            $this->endDate = Carbon::parse($this->value['end']);
        }
        // Handle legacy string parameters for backward compatibility
        elseif ($startDate || $endDate) {
            $this->startDate = $startDate ? Carbon::parse($startDate) : null;
            $this->endDate = $endDate ? Carbon::parse($endDate) : null;
        } else {
            $this->startDate = null;
            $this->endDate = null;
        }

        $this->initialDate = Carbon::parse($initialDate ?? $this->startDate ?? 'now');
        $this->locale = $locale ?? App::getLocale();
        $this->presets = $presets ? $this->getTranslatedPresets() : [];
    }
    
    public function render(): View
    {
        return view('strata::components.calendar');
    }

    public function getDayNames(): array
    {
        $days = trans('strata::calendar.days_short', [], $this->locale);
        if ($this->weekStart === 'monday') {
            $sunday = array_shift($days);
            $days[] = $sunday;
        }
        return $days;
    }

    protected function getTranslatedPresets(): array
    {
        return [
            trans('strata::calendar.today', [], $this->locale) => [Carbon::today(), Carbon::today()],
            trans('strata::calendar.yesterday', [], $this->locale) => [Carbon::yesterday(), Carbon::yesterday()],
            trans('strata::calendar.this_week', [], $this->locale) => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            trans('strata::calendar.last_7_days', [], $this->locale) => [Carbon::now()->subDays(6), Carbon::now()],
            trans('strata::calendar.this_month', [], $this->locale) => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            trans('strata::calendar.last_30_days', [], $this->locale) => [Carbon::now()->subDays(29), Carbon::now()],
            trans('strata::calendar.last_month', [], $this->locale) => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
        ];
    }
}